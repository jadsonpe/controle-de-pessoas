<?php

namespace App\Http\Controllers;

use App\Models\Hospede;
use App\Models\LeituraEnergia;
use App\Models\Veiculo;
use App\Models\Acompanhante;
use App\Models\Apartamento;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HospedeController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string',
            'sort' => 'nullable|in:nome,apartamento,data_entrada,data_saida',
            'direction' => 'nullable|in:asc,desc',
            'ativos' => 'nullable|boolean'
        ]);
    
        $query = Hospede::with(['apartamento', 'acompanhantes'])
        ->when(request('ativos'), function($q) {
            $q->where(function($query) {
                $query->whereNull('data_saida')
                      ->orWhere('data_saida', '>', now());
            });
        });
            
        // Filtro de busca
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nome', 'like', "%{$request->search}%")
                  ->orWhereHas('apartamento', function($q) use ($request) {
                      $q->where('numero', 'like', "%{$request->search}%");
                  });
            });
        }
    
        // Filtro de ativos
        if ($request->boolean('ativos')) {
            $query->whereNull('data_saida');
        }
    
        // Ordenação
        $sort = $validated['sort'] ?? 'nome';
        $direction = $validated['direction'] ?? 'asc';
    
        if ($sort === 'apartamento') {
            $query->leftJoin('apartamentos', 'hospedes.apartamento_id', '=', 'apartamentos.id')
                  ->orderBy('apartamentos.numero', $direction)
                  ->select('hospedes.*');
        } else {
            $query->orderBy($sort, $direction);
        }
    
        $hospedes = $query->paginate(20)->appends($request->query());
    
        return view('hospedes.index', compact('hospedes'));
    }
    
    public function create()
    {
        $apartamentos = Apartamento::all();
        return view('hospedes.create', compact('apartamentos'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'celular' => 'required|string|max:20',
            'data_entrada' => 'required|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
            'cpf' => 'nullable|string|max:14|unique:hospedes,cpf',
            'email' => 'nullable|email|max:255|unique:hospedes,email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_base64' => 'nullable|string',
            'acompanhantes.*.nome' => 'nullable|string|max:255',
            'acompanhantes.*.documento' => 'nullable|string|max:255',
            'veiculo' => 'nullable|string|max:100',
            'cor' => 'nullable|string|max:50',
            'placa' => 'nullable|string|max:10',
        ]);
    
        $fotoPath = null;
        
        // Caso 1: Upload de arquivo
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('hospedes_fotos', 'public');
        } 
        // Caso 2: Foto da webcam (base64)
        elseif ($request->filled('foto_base64')) {
            try {
                $imageData = $request->input('foto_base64');
                $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
                $imageData = str_replace(' ', '+', $imageData);
                $decodedImage = base64_decode($imageData);
                
                if ($decodedImage === false) {
                    throw new \Exception('Formato de imagem inválido');
                }
                
                $fileName = 'webcam_' . time() . '_' . Str::random(10) . '.jpg';
                Storage::disk('public')->put('hospedes_fotos/' . $fileName, $decodedImage);
                $fotoPath = 'hospedes_fotos/' . $fileName;
            } catch (\Exception $e) {
                return back()->withInput()->with('error', 'Erro ao processar a foto: ' . $e->getMessage());
            }
        }
    
        $hospedeData = [
            'apartamento_id' => $validatedData['apartamento_id'],
            'nome' => $validatedData['nome'],
            'endereco_residencial' => $request->input('endereco_residencial'),
            'cidade' => $request->input('cidade'),
            'estado' => $request->input('estado'),
            'telefone' => $request->input('telefone'),
            'celular' => $validatedData['celular'],
            'email' => $validatedData['email'] ?? null,
            'doc_identidade' => $request->input('doc_identidade'),
            'org_expedidor' => $request->input('org_expedidor'),
            'passaporte' => $request->input('passaporte'),
            'cpf' => $validatedData['cpf'] ?? null,
            'idade' => $request->input('idade'),
            'estado_civil' => $request->input('estado_civil'),
            'profissao' => $request->input('profissao'),
            'empresa' => $request->input('empresa'),
            'endereco_comercial' => $request->input('endereco_comercial'),
            'cidade_comercial' => $request->input('cidade_comercial'),
            'estado_comercial' => $request->input('estado_comercial'),
            'telefone_comercial' => $request->input('telefone_comercial'),
            'data_entrada' => $validatedData['data_entrada'],
            'data_saida' => $validatedData['data_saida'] ?? null,
            'foto' => $fotoPath,
        ];
    
        // Dados do veículo
        $veiculoData = [
            'modelo' => $validatedData['veiculo'] ?? null,
            'cor' => $validatedData['cor'] ?? null,
            'placa' => $validatedData['placa'] ?? null,
        ];
    
        // Criar o hóspede e relacionamentos
        try {
            DB::beginTransaction();
    
            // Criar hóspede
            $hospede = Hospede::create($hospedeData);
    
            // Criar veículo se houver dados
            if (!empty(array_filter($veiculoData))) {
                $hospede->veiculos()->create($veiculoData);
            }
    
            // Criar acompanhantes se houver
            if ($request->has('acompanhantes')) {
                foreach ($request->input('acompanhantes') as $acompanhante) {
                    if (!empty($acompanhante['nome'])) {
                        $hospede->acompanhantes()->create([
                            'nome' => $acompanhante['nome'],
                            'documento' => $acompanhante['documento'] ?? null
                        ]);
                    }
                }
            }
    
            DB::commit();
    
            return redirect()->route('hospedes.index')
                ->with('success', 'Hóspede cadastrado com sucesso!');
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Remove a foto se foi salva mas ocorreu um erro
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
    
            return back()->withInput()
                ->with('error', 'Erro ao cadastrar hóspede: ' . $e->getMessage());
        }
    }
    public function edit(Hospede $hospede)
    {
        $hospede->load(['veiculos', 'acompanhantes', 'apartamento']);
        
        $apartamentos = Apartamento::all();
        $acompanhantes = Acompanhante::all();
        
        return view('hospedes.edit', compact('hospede', 'acompanhantes', 'apartamentos'));
    }
    
    public function update(Request $request, Hospede $hospede)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'celular' => 'required|string|max:20',
            'data_entrada' => 'required|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
            'data_nascimento' => 'nullable|date_format:Y-m-d',
            'cpf' => 'nullable|string|max:14',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'acompanhantes.*.id' => 'nullable|exists:acompanhantes,id,hospede_id,'.$hospede->id,
            'acompanhantes.*.nome' => 'required_with:acompanhantes|string|max:255',
            'acompanhantes.*.documento' => 'nullable|string|max:255',
            'veiculo.veiculo' => 'nullable|string|max:100',
            'veiculo.cor' => 'nullable|string|max:50',
            'veiculo.placa' => 'nullable|string|max:10|unique:veiculos,placa,' . 
                              ($hospede->veiculos->first()->id ?? 'NULL') . ',id,hospede_id,' . $hospede->id,
        ]);
    
        // Tratamento da foto
        $fotoPath = $hospede->foto;
        
        if ($request->input('remove_foto') == '1') {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = null;
        }
        elseif ($request->hasFile('foto')) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('hospedes_fotos', 'public');
        }
        elseif ($request->filled('foto_base64')) {
            try {
                if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
                
                $imageData = $request->input('foto_base64');
                $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
                $imageData = str_replace(' ', '+', $imageData);
                $decodedImage = base64_decode($imageData);
                
                $fileName = 'webcam_' . time() . '_' . Str::random(10) . '.jpg';
                Storage::disk('public')->put('hospedes_fotos/' . $fileName, $decodedImage);
                $fotoPath = 'hospedes_fotos/' . $fileName;
            } catch (\Exception $e) {
                return back()->withInput()->with('error', 'Erro ao processar a foto: ' . $e->getMessage());
            }
        }
    
        // Dados do hóspede
        $hospedeData = [
            'apartamento_id' => $validatedData['apartamento_id'],
            'nome' => $validatedData['nome'],
            'endereco_residencial' => $request->input('endereco_residencial'),
            'cidade' => $request->input('cidade'),
            'estado' => $request->input('estado'),
            'telefone' => $request->input('telefone'),
            'celular' => $validatedData['celular'],
            'email' => $validatedData['email'] ?? null,
            'doc_identidade' => $request->input('doc_identidade'),
            'org_expedidor' => $request->input('org_expedidor'),
            'passaporte' => $request->input('passaporte'),
            'cpf' => $validatedData['cpf'] ?? null,
            'idade' => $request->input('idade'),
            'estado_civil' => $request->input('estado_civil'),
            'profissao' => $request->input('profissao'),
            'empresa' => $request->input('empresa'),
            'endereco_comercial' => $request->input('endereco_comercial'),
            'cidade_comercial' => $request->input('cidade_comercial'),
            'estado_comercial' => $request->input('estado_comercial'),
            'telefone_comercial' => $request->input('telefone_comercial'),
            'data_entrada' => $validatedData['data_entrada'],
            'data_saida' => $validatedData['data_saida'] ?? null,
            'data_nascimento' => $validatedData['data_nascimento'] ?? null,
            'foto' => $fotoPath,
        ];
    
        try {
            DB::beginTransaction();
    
            // Atualizar hóspede
            $hospede->update($hospedeData);
    
            // Lógica para veículos
            $veiculoData = $request->veiculo ?? [];
            
            if (!empty(array_filter($veiculoData))) {
                if ($hospede->veiculos->isNotEmpty()) {
                    // Atualiza veículo existente
                    $hospede->veiculos()->first()->update($veiculoData);
                } else {
                    // Cria novo veículo
                    $hospede->veiculos()->create($veiculoData);
                }
            } elseif ($hospede->veiculos->isNotEmpty()) {
                // Remove veículo se todos campos estiverem vazios
                $hospede->veiculos()->first()->delete();
            }
    
            // Lógica para acompanhantes
            $currentAcompanhantes = $hospede->acompanhantes->keyBy('id');
            $submittedAcompanhantes = collect($request->input('acompanhantes', []));
            $keptAcompanhantesIds = [];
    
            foreach ($submittedAcompanhantes as $acompanhanteData) {
                if (!empty($acompanhanteData['nome'])) {
                    if (!empty($acompanhanteData['id']) && $currentAcompanhantes->has($acompanhanteData['id'])) {
                        // Atualiza existente
                        $currentAcompanhantes->get($acompanhanteData['id'])->update([
                            'nome' => $acompanhanteData['nome'],
                            'documento' => $acompanhanteData['documento'] ?? null
                        ]);
                        $keptAcompanhantesIds[] = $acompanhanteData['id'];
                    } else {
                        // Cria novo
                        $newAcompanhante = $hospede->acompanhantes()->create([
                            'nome' => $acompanhanteData['nome'],
                            'documento' => $acompanhanteData['documento'] ?? null
                        ]);
                        $keptAcompanhantesIds[] = $newAcompanhante->id;
                    }
                }
            }
    
            // Remove acompanhantes não enviados no formulário
            $hospede->acompanhantes()
                    ->whereNotIn('id', $keptAcompanhantesIds)
                    ->delete();
    
            DB::commit();
    
            return redirect()->route('hospedes.index')
                ->with('success', 'Hóspede atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Erro ao atualizar hóspede: ' . $e->getMessage());
        }
    }

    public function destroy(Hospede $hospede)
    {
        $hospede->delete();
        return redirect()->route('hospedes.index');
    }

    public function ativos()
    {
        $hospedesAtivos = Hospede::whereNull('data_saida')->get();
        return view('hospedes.ativos', compact('hospedesAtivos'));
    }

    public function show() {
        dd('show');
        
    }

}
