@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up">
    <div class="section-title">
        <h2>Editar Hóspede</h2>
        <p>Atualize os dados do hóspede abaixo</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $hospede->nome }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('hospedes.update', $hospede->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Seção 1: Dados Pessoais -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                            <input type="text" name="nome" id="nome" class="form-control" required
                                   value="{{ old('nome', $hospede->nome) }}">
                            @error('nome')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apartamento_id" class="form-label">Apartamento <span class="text-danger">*</span></label>
                            <select name="apartamento_id" id="apartamento_id" class="form-select" required>
                                <option value="" disabled>Selecione o Apartamento</option>
                                @foreach($apartamentos as $apartamento)
                                    <option value="{{ $apartamento->id }}" 
                                        {{ old('apartamento_id', $hospede->apartamento_id) == $apartamento->id ? 'selected' : '' }}>
                                        {{ $apartamento->numero }} - {{ $apartamento->descricao }}
                                    </option>
                                @endforeach
                            </select>
                            @error('apartamento_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control cpf-mask"
                                   value="{{ old('cpf', $hospede->cpf) }}">
                            @error('cpf')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="doc_identidade" class="form-label">Documento de Identidade</label>
                            <input type="text" name="doc_identidade" id="doc_identidade" class="form-control"
                                   value="{{ old('doc_identidade', $hospede->doc_identidade) }}">
                        </div>

                        <div class="mb-3">
                            <label for="passaporte" class="form-label">Passaporte</label>
                            <input type="text" name="passaporte" id="passaporte" class="form-control"
                                   value="{{ old('passaporte', $hospede->passaporte) }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" name="data_nascimento" id="data_nascimento" class="form-control"
                                       value="{{ old('data_nascimento', $hospede->data_nascimento) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estado_civil" class="form-label">Estado Civil</label>
                                <select name="estado_civil" id="estado_civil" class="form-select">
                                    <option value="" {{ old('estado_civil', $hospede->estado_civil) == '' ? 'selected' : '' }}>Selecione</option>
                                    <option value="Solteiro(a)" {{ old('estado_civil', $hospede->estado_civil) == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                                    <option value="Casado(a)" {{ old('estado_civil', $hospede->estado_civil) == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                    <option value="Divorciado(a)" {{ old('estado_civil', $hospede->estado_civil) == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                    <option value="Viúvo(a)" {{ old('estado_civil', $hospede->estado_civil) == 'Viúvo(a)' ? 'selected' : '' }}>Viúvo(a)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Seção 2: Contato e Profissional -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $hospede->email) }}">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" name="telefone" id="telefone" class="form-control phone-mask"
                                       value="{{ old('telefone', $hospede->telefone) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="celular" class="form-label">Celular <span class="text-danger">*</span></label>
                                <input type="text" name="celular" id="celular" class="form-control phone-mask" required
                                       value="{{ old('celular', $hospede->celular) }}">
                                @error('celular')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="profissao" class="form-label">Profissão</label>
                            <input type="text" name="profissao" id="profissao" class="form-control"
                                   value="{{ old('profissao', $hospede->profissao) }}">
                        </div>

                        <div class="mb-3">
                            <label for="empresa" class="form-label">Empresa</label>
                            <input type="text" name="empresa" id="empresa" class="form-control"
                                   value="{{ old('empresa', $hospede->empresa) }}">
                        </div>
                    </div>
                </div>
                @php $estadosBrasil = [
                    'AC' => 'Acre',
                    'AL' => 'Alagoas',
                    'AP' => 'Amapá',
                    'AM' => 'Amazonas',
                    'BA' => 'Bahia',
                    'CE' => 'Ceará',
                    'DF' => 'Distrito Federal',
                    'ES' => 'Espírito Santo',
                    'GO' => 'Goiás',
                    'MA' => 'Maranhão',
                    'MT' => 'Mato Grosso',
                    'MS' => 'Mato Grosso do Sul',
                    'MG' => 'Minas Gerais',
                    'PA' => 'Pará',
                    'PB' => 'Paraíba',
                    'PR' => 'Paraná',
                    'PE' => 'Pernambuco',
                    'PI' => 'Piauí',
                    'RJ' => 'Rio de Janeiro',
                    'RN' => 'Rio Grande do Norte',
                    'RS' => 'Rio Grande do Sul',
                    'RO' => 'Rondônia',
                    'RR' => 'Roraima',
                    'SC' => 'Santa Catarina',
                    'SP' => 'São Paulo',
                    'SE' => 'Sergipe',
                    'TO' => 'Tocantins',
                    'HI' => 'Hóspede Internacional'
                ];@endphp
                <!-- Seção 3: Endereço -->
                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">Endereço Residencial</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="endereco_residencial" class="form-label">Endereço</label>
                                <input type="text" name="endereco_residencial" id="endereco_residencial" class="form-control"
                                       value="{{ old('endereco_residencial', $hospede->endereco_residencial) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" name="cidade" id="cidade" class="form-control"
                                       value="{{ old('cidade', $hospede->cidade) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select name="estado" id="estado" class="form-select">
                                    <option value="" selected>Selecione</option>
                                    @foreach($estadosBrasil as $uf => $estado)
                                    <option value="{{ $uf }}" {{ old('estado', $hospede->estado) == $uf ? 'selected' : '' }}>{{ $estado }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Seção 4: Veículo -->
                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">Veículo</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="veiculo_modelo" class="form-label">Modelo</label>
                                <input type="text" name="veiculo[veiculo]" id="veiculo_modelo" class="form-control"
                                    value="{{ old('veiculo.veiculo', $hospede->veiculos->first()->veiculo ?? '') }}">
                                @error('veiculo.veiculo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="veiculo_cor" class="form-label">Cor</label>
                                <input type="text" name="veiculo[cor]" id="veiculo_cor" class="form-control"
                                    value="{{ old('veiculo.cor', $hospede->veiculos->first()->cor ?? '') }}">
                                @error('veiculo.cor')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="veiculo_placa" class="form-label">Placa</label>
                                <input type="text" name="veiculo[placa]" id="veiculo_placa" class="form-control placa-mask"
                                    value="{{ old('veiculo.placa', $hospede->veiculos->first()->placa ?? '') }}">
                                @error('veiculo.placa')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Seção 5: Acompanhantes -->
                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">Acompanhantes</h6>
                    </div>
                    <div class="card-body">
                        <div id="acompanhantes-container">
                            @php
                                $oldAcompanhantes = old('acompanhantes', $hospede->acompanhantes->map(function($item) {
                                    return [
                                        'id' => $item->id,
                                        'nome' => $item->nome,
                                        'documento' => $item->documento
                                    ];
                                })->toArray());
                            @endphp
                            
                            @foreach($oldAcompanhantes as $index => $acompanhante)
                                <div class="acompanhante-group mb-3 border p-3 rounded">
                                    <input type="hidden" name="acompanhantes[{{ $index }}][id]" value="{{ $acompanhante['id'] ?? '' }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Nome</label>
                                            <input type="text" name="acompanhantes[{{ $index }}][nome]" 
                                                class="form-control" value="{{ $acompanhante['nome'] ?? '' }}"
                                                required>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Documento</label>
                                            <input type="text" name="acompanhantes[{{ $index }}][documento]" 
                                                class="form-control" value="{{ $acompanhante['documento'] ?? '' }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-acompanhante">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-acompanhante" class="btn btn-success mt-2">
                            <i class="bi bi-plus-circle"></i> Adicionar Acompanhante
                        </button>
                    </div>
                </div>

                <!-- Seção 6: Datas e Foto -->
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <label for="data_entrada" class="form-label">Data de Entrada <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="data_entrada" id="data_entrada" class="form-control" required
                        value="{{ old('data_entrada', $hospede->data_entrada ? \Carbon\Carbon::parse($hospede->data_entrada)->format('Y-m-d\TH:i') : '') }}">
                        @error('data_entrada')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="data_saida" class="form-label">Data de Saída (Opcional)</label>
                        <input type="datetime-local" name="data_saida" id="data_saida" class="form-control"
                        value="{{ old('data_saida', $hospede->data_saida ? \Carbon\Carbon::parse($hospede->data_saida)->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>

        <!-- Seção de Foto Aprimorada -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">Foto do Hóspede</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Opção de Upload -->
                        <div class="mb-3">
                            <label class="form-label">Alterar Foto</label>
                            <input type="file" name="foto" id="foto-input" class="form-control" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-primary w-100" onclick="document.getElementById('foto-input').click()">
                                <i class="bi bi-upload"></i> Selecionar Nova Foto
                            </button>
                            <small class="text-muted">Formatos aceitos: JPG, PNG (Máx. 2MB)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Opção de Webcam -->
                        <div class="mb-3">
                            <label class="form-label">Capturar pela Webcam</label>
                            <button type="button" class="btn btn-success w-100" id="start-camera">
                                <i class="bi bi-camera"></i> Tirar Nova Foto
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Área de Visualização -->
                <div class="text-center mt-3">
                    <!-- Foto Atual -->
                    @if($hospede->foto)
                        <div id="current-photo" class="mb-3">
                            <p class="text-muted">Foto Atual:</p>
                            <img src="{{ asset('storage/' . $hospede->foto) }}" alt="Foto atual" class="img-thumbnail" style="max-width: 200px;">
                            <div class="mt-2">
                                <button type="button" class="btn btn-outline-danger btn-sm" id="remove-photo">
                                    <i class="bi bi-trash"></i> Remover Foto
                                </button>
                                <input type="hidden" name="remove_foto" id="remove-foto" value="0">
                            </div>
                        </div>
                    @endif

                    <!-- Container da Câmera -->
                    <div id="camera-container" style="display: none;">
                        <div id="camera-view" class="border rounded mb-2" style="width: 320px; height: 240px; margin: 0 auto;"></div>
                        <button type="button" id="take-photo" class="btn btn-info me-2">
                            <i class="bi bi-camera-fill"></i> Capturar
                        </button>
                        <button type="button" id="cancel-camera" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                    </div>
                    
                    <!-- Pré-visualização da Nova Foto -->
                    <div id="photo-preview" class="mt-3" style="{{ !$hospede->foto ? 'display: block;' : 'display: none;' }}">
                        <img id="preview-image" src="{{ $hospede->foto ? asset('storage/' . $hospede->foto) : '#' }}" 
                             alt="Pré-visualização" style="max-width: 320px; max-height: 240px; {{ !$hospede->foto ? 'display: none;' : '' }}" 
                             class="img-thumbnail">
                        <input type="hidden" name="foto_base64" id="foto-base64">
                    </div>
                </div>
            </div>
        </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('hospedes.index') }}" class="btn btn-secondary me-md-2">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Atualizar Hóspede
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        // Máscaras para os campos
        $('.cpf-mask').mask('000.000.000-00');
        $('.phone-mask').mask('(00) 00000-0000');
        $('.placa-mask').mask('AAA-0A00', {
            translation: {
                'A': { pattern: /[A-Za-z]/ },
                '0': { pattern: /[0-9]/ }
            }
        });

        // Controle de acompanhantes
        let acompanhanteIndex = {{ count($oldAcompanhantes) > 0 ? count($oldAcompanhantes) : 0 }};
        
        $('#add-acompanhante').on('click', function() {
            let newGroup = `
                <div class="acompanhante-group mb-3 border p-3 rounded">
                    <input type="hidden" name="acompanhantes[${acompanhanteIndex}][id]" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nome <span class="text-danger">*</span></label>
                            <input type="text" name="acompanhantes[${acompanhanteIndex}][nome]" 
                                   class="form-control" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Documento</label>
                            <input type="text" name="acompanhantes[${acompanhanteIndex}][documento]" 
                                   class="form-control">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-acompanhante">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $('#acompanhantes-container').append(newGroup);
            acompanhanteIndex++;
        });

        $(document).on('click', '.remove-acompanhante', function() {
            $(this).closest('.acompanhante-group').remove();
        });
    });
</script>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fotoInput = document.getElementById('foto-input');
        const previewImage = document.getElementById('preview-image');
        const cameraContainer = document.getElementById('camera-container');
        const startCameraBtn = document.getElementById('start-camera');
        const takePhotoBtn = document.getElementById('take-photo');
        const cancelCameraBtn = document.getElementById('cancel-camera');
        const fotoBase64 = document.getElementById('foto-base64');
        const removePhotoBtn = document.getElementById('remove-photo');
        const removePhotoInput = document.getElementById('remove-foto');
        const currentPhotoDiv = document.getElementById('current-photo');
        let cameraActive = false;

        // Preview da imagem selecionada
        fotoInput.addEventListener('change', function() {
            if (cameraActive) {
                Webcam.reset();
                cameraActive = false;
                cameraContainer.style.display = 'none';
            }

            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    fotoBase64.value = '';
                    document.getElementById('photo-preview').style.display = 'block';
                    
                    // Esconde a foto atual se estiver visível
                    if (currentPhotoDiv) {
                        currentPhotoDiv.style.display = 'none';
                    }
                }
                reader.readAsDataURL(file);
            }
        });

        // Configuração da Webcam
        startCameraBtn.addEventListener('click', function() {
            // Esconde a foto atual se estiver visível
            if (currentPhotoDiv) {
                currentPhotoDiv.style.display = 'none';
            }
            
            // Mostra o container da câmera
            cameraContainer.style.display = 'block';
            document.getElementById('photo-preview').style.display = 'none';
            
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90,
                flip_horiz: true
            });
            Webcam.attach('#camera-view');
            cameraActive = true;
        });

        // Capturar foto
        takePhotoBtn.addEventListener('click', function() {
            Webcam.snap(function(data_uri) {
                previewImage.src = data_uri;
                previewImage.style.display = 'block';
                fotoBase64.value = data_uri;
                document.getElementById('photo-preview').style.display = 'block';
                
                Webcam.reset();
                cameraContainer.style.display = 'none';
                cameraActive = false;
            });
        });

        // Cancelar câmera
        cancelCameraBtn.addEventListener('click', function() {
            Webcam.reset();
            cameraContainer.style.display = 'none';
            cameraActive = false;
            
            // Mostra a foto atual novamente se existir
            if (currentPhotoDiv) {
                currentPhotoDiv.style.display = 'block';
            }
        });

        // Remover foto atual
        if (removePhotoBtn) {
            removePhotoBtn.addEventListener('click', function() {
                if (confirm('Tem certeza que deseja remover a foto atual?')) {
                    removePhotoInput.value = '1';
                    currentPhotoDiv.style.display = 'none';
                    document.getElementById('photo-preview').style.display = 'block';
                    previewImage.src = '#';
                    previewImage.style.display = 'none';
                }
            });
        }

        // Limpar tudo ao enviar o formulário
        document.querySelector('form').addEventListener('submit', function() {
            if (cameraActive) {
                Webcam.reset();
            }
        });
    });

    $(document).ready(function() {
        let acompanhanteIndex = {{ count($oldAcompanhantes) }};
        
        $('#add-acompanhante').click(function() {
            let newGroup = `
                <div class="acompanhante-group mb-3 border p-3 rounded">
                    <input type="hidden" name="acompanhantes[${acompanhanteIndex}][id]" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nome</label>
                            <input type="text" name="acompanhantes[${acompanhanteIndex}][nome]" 
                                   class="form-control" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Documento</label>
                            <input type="text" name="acompanhantes[${acompanhanteIndex}][documento]" 
                                   class="form-control">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-acompanhante">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $('#acompanhantes-container').append(newGroup);
            acompanhanteIndex++;
        });

        $(document).on('click', '.remove-acompanhante', function() {
            $(this).closest('.acompanhante-group').remove();
        });
    });

</script>
@endpush