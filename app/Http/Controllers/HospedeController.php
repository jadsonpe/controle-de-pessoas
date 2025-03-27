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
    public function index()
    {
        $hospedes = Hospede::with(['apartamento', 'acompanhantes'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        $acompanhantes = Acompanhante::all();
        return view('hospedes.index', compact('hospedes', 'acompanhantes'));
    }
    public function create()
    {
        $apartamentos = Apartamento::all();
        return view('hospedes.create', compact('apartamentos'));
    }
    
    public function store(Request $request)
    {
        // Validação dos dados
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
            'carro' => 'nullable|string|max:100',
            'cor' => 'nullable|string|max:50',
            'placa' => 'nullable|string|max:10',
        ]);
    
        // Tratamento da foto
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
            'foto' => $fotoPath,
        ];
    
        // Dados do veículo
        $veiculoData = [
            'modelo' => $validatedData['carro'] ?? null,
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
        $hospedes = Hospede::all();
        $acompanhantes = Acompanhante::all();
        $apartamentos = Apartamento::all();
        return view('hospedes.edit', compact('hospede', 'acompanhantes', 'apartamentos'));
    }

    public function update(Request $request, Hospede $hospede)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'celular' => 'required|string|max:20',
            'data_entrada' => 'required|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
            'cpf' => 'nullable|string|max:14',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'acompanhantes.*.nome' => 'nullable|string|max:255',
            'acompanhantes.*.documento' => 'nullable|string|max:255',
            'carro' => 'nullable|string|max:100',
            'cor' => 'nullable|string|max:50',
            'placa' => 'nullable|string|max:10',
        ]);
    
    // Tratamento da foto
    $fotoPath = $hospede->foto;
    
    // Caso 1: Remoção da foto
    if ($request->input('remove_foto') == '1') {
        if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
            Storage::disk('public')->delete($fotoPath);
        }
        $fotoPath = null;
    }
    // Caso 2: Upload de arquivo
    elseif ($request->hasFile('foto')) {
        // Remove a foto antiga se existir
        if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
            Storage::disk('public')->delete($fotoPath);
        }
        
        // Armazena a nova foto
        $fotoPath = $request->file('foto')->store('hospedes_fotos', 'public');
    }
    // Caso 3: Foto da webcam (base64)
    elseif ($request->filled('foto_base64')) {
        try {
            // Remove a foto antiga se existir
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
            'foto' => $fotoPath,
        ];
    
        // Dados do veículo
        $veiculoData = [
            'modelo' => $validatedData['carro'] ?? null,
            'cor' => $validatedData['cor'] ?? null,
            'placa' => $validatedData['placa'] ?? null,
        ];
    
        // Atualizar o hóspede e relacionamentos
        try {
            DB::beginTransaction();
    
            // Atualizar hóspede
            $hospede->update($hospedeData);
    
            // Atualizar veículo
            if ($hospede->veiculos->isNotEmpty()) {
                $hospede->veiculos()->first()->update($veiculoData);
            } elseif (!empty(array_filter($veiculoData))) {
                $hospede->veiculos()->create($veiculoData);
            }
    
            // Atualizar acompanhantes (remove todos e recria)
            $hospede->acompanhantes()->delete();
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

    // Ação específica para mostrar hóspedes ativos
    public function ativos()
    {
        $hospedesAtivos = Hospede::whereNull('data_saida')->get();
        return view('hospedes.ativos', compact('hospedesAtivos'));
    }

    public function show() {
        dd('show');
        
    }

}
