@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up">
    <div class="section-title">
        <h2>Cadastrar Novo Hóspede</h2>
        <p>Preencha os dados do hóspede abaixo</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informações do Hóspede</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('hospedes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Seção 1: Dados Pessoais -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                            <input type="text" name="nome" id="nome" class="form-control" required
                                   value="{{ old('nome') }}" placeholder="Digite o nome completo">
                            @error('nome')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apartamento_id" class="form-label">Apartamento <span class="text-danger">*</span></label>
                            <select name="apartamento_id" id="apartamento_id" class="form-select" required>
                                <option value="" disabled selected>Selecione o Apartamento</option>
                                @foreach($apartamentos as $apartamento)
                                    <option value="{{ $apartamento->id }}" {{ old('apartamento_id') == $apartamento->id ? 'selected' : '' }}>
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
                                   value="{{ old('cpf') }}" placeholder="000.000.000-00">
                            @error('cpf')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="doc_identidade" class="form-label">Documento de Identidade</label>
                            <input type="text" name="doc_identidade" id="doc_identidade" class="form-control"
                                   value="{{ old('doc_identidade') }}">
                        </div>

                        <div class="mb-3">
                            <label for="passaporte" class="form-label">Passaporte</label>
                            <input type="text" name="passaporte" id="passaporte" class="form-control"
                                   value="{{ old('passaporte') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="data_nascimento" class="form-label">Data de Nascimento<span class="text-danger"> *</span></label>
                                <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" required
                                       value="{{ old('data_nascimento') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estado_civil" class="form-label">Estado Civil</label>
                                <select name="estado_civil" id="estado_civil" class="form-select">
                                    <option value="" selected>Selecione</option>
                                    <option value="Solteiro(a)" {{ old('estado_civil') == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                                    <option value="Casado(a)" {{ old('estado_civil') == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                    <option value="Divorciado(a)" {{ old('estado_civil') == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                    <option value="Viúvo(a)" {{ old('estado_civil') == 'Viúvo(a)' ? 'selected' : '' }}>Viúvo(a)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Seção 2: Contato e Profissional -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email') }}" placeholder="exemplo@email.com">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" name="telefone" id="telefone" class="form-control phone-mask"
                                       value="{{ old('telefone') }}" placeholder="(00) 0000-0000">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="celular" class="form-label">Celular <span class="text-danger">*</span></label>
                                <input type="text" name="celular" id="celular" class="form-control phone-mask" required
                                       value="{{ old('celular') }}" placeholder="(00) 00000-0000">
                                @error('celular')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="profissao" class="form-label">Profissão</label>
                            <input type="text" name="profissao" id="profissao" class="form-control"
                                   value="{{ old('profissao') }}">
                        </div>

                        <div class="mb-3">
                            <label for="empresa" class="form-label">Empresa</label>
                            <input type="text" name="empresa" id="empresa" class="form-control"
                                   value="{{ old('empresa') }}">
                        </div>
                    </div>
                </div>

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
                                       value="{{ old('endereco_residencial') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" name="cidade" id="cidade" class="form-control"
                                       value="{{ old('cidade') }}">
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
                                'EX' => 'EXTERIOR',
                            ];@endphp
                            <div class="col-md-4 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select name="estado" id="estado" class="form-select">
                                    <option value="" selected>Selecione</option>
                                    @foreach($estadosBrasil as $uf => $estado)
                                    <option value="{{ $uf }}" {{ old('estado') == $uf ? 'selected' : '' }}>{{ $estado }}</option>
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
                                <label for="veiculo" class="form-label">Modelo</label>
                                <input type="text" name="veiculo" id="veiculo" class="form-control"
                                       value="{{ old('veiculo') }}" placeholder="Ex: Ford Ka">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cor" class="form-label">Cor</label>
                                <input type="text" name="cor" id="cor" class="form-control"
                                       value="{{ old('cor') }}" placeholder="Ex: Prata">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="placa" class="form-label">Placa</label>
                                <input type="text" name="placa" id="placa" class="form-control placa-mask"
                                       value="{{ old('placa') }}" placeholder="AAA-0000">
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
                            @if(old('acompanhantes'))
                                @foreach(old('acompanhantes') as $index => $acompanhante)
                                    <div class="acompanhante-group mb-3 border p-3 rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Nome</label>
                                                <input type="text" name="acompanhantes[{{ $index }}][nome]" 
                                                       class="form-control" value="{{ $acompanhante['nome'] ?? '' }}">
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
                            @else
                                <div class="acompanhante-group mb-3 border p-3 rounded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Nome</label>
                                            <input type="text" name="acompanhantes[0][nome]" class="form-control">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Documento</label>
                                            <input type="text" name="acompanhantes[0][documento]" class="form-control">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-acompanhante">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                               value="{{ old('data_entrada') }}">
                        @error('data_entrada')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="data_saida" class="form-label">Data de Saída (Opcional)</label>
                        <input type="datetime-local" name="data_saida" id="data_saida" class="form-control"
                               value="{{ old('data_saida') }}">
                    </div>
                </div>
 <!-- Seção de Foto -->
 <div class="card mt-4">
    <div class="card-header bg-secondary text-white">
        <h6 class="mb-0">Foto do Hóspede</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <!-- Opção de Upload -->
                <div class="mb-3">
                    <label class="form-label">Enviar Foto</label>
                    <input type="file" name="foto" id="foto-input" class="form-control" accept="image/*" style="display: none;">
                    <button type="button" class="btn btn-primary w-100" onclick="document.getElementById('foto-input').click()">
                        <i class="bi bi-upload"></i> Selecionar Arquivo
                    </button>
                    <small class="text-muted">Formatos aceitos: JPG, PNG (Máx. 2MB)</small>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Opção de Webcam -->
                <div class="mb-3">
                    <label class="form-label">Capturar pela Webcam</label>
                    <button type="button" class="btn btn-success w-100" id="start-camera">
                        <i class="bi bi-camera"></i> Abrir Câmera
                    </button>
                </div>
            </div>
        </div>

        <!-- Área de Visualização -->
        <div class="text-center mt-3">
            <div id="camera-container" style="display: none;">
                <div id="camera-view" class="border rounded mb-2" style="width: 320px; height: 240px; margin: 0 auto;"></div>
                <button type="button" id="take-photo" class="btn btn-info me-2">
                    <i class="bi bi-camera-fill"></i> Capturar Foto
                </button>
                <button type="button" id="cancel-camera" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
            </div>
            
            <div id="photo-preview" class="mt-3">
                <img id="preview-image" src="#" alt="Pré-visualização" style="max-width: 320px; max-height: 240px; display: none;" class="img-thumbnail">
                <input type="hidden" name="foto_base64" id="foto-base64">
            </div>
        </div>
    </div>
</div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('hospedes.index') }}" class="btn btn-secondary me-md-2">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Cadastrar Hóspede
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

        // Adicionar acompanhante
        let acompanhanteIndex = {{ old('acompanhantes') ? count(old('acompanhantes')) : 1 }};
        
        $('#add-acompanhante').click(function() {
            let newGroup = `
                <div class="acompanhante-group mb-3 border p-3 rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nome</label>
                            <input type="text" name="acompanhantes[${acompanhanteIndex}][nome]" class="form-control">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Documento</label>
                            <input type="text" name="acompanhantes[${acompanhanteIndex}][documento]" class="form-control">
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

        // Remover acompanhante
        $(document).on('click', '.remove-acompanhante', function() {
            if($('.acompanhante-group').length > 1) {
                $(this).closest('.acompanhante-group').remove();
            } else {
                alert('É necessário pelo menos um acompanhante.');
            }
        });

        // Preenchimento automático de CEP (exemplo)
        $('#cep').on('blur', function() {
            const cep = $(this).val().replace(/\D/g, '');
            if (cep.length === 8) {
                $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                    if (!data.erro) {
                        $('#endereco_residencial').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    }
                });
            }
        });
    });
</script>
@endpush
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
                    fotoBase64.value = ''; // Limpa a foto da webcam se houver
                }
                reader.readAsDataURL(file);
            }
        });

        // Configuração da Webcam
        startCameraBtn.addEventListener('click', function() {
            // Esconde o upload se estiver visível
            if (previewImage.style.display === 'block') {
                previewImage.style.display = 'none';
                fotoInput.value = '';
            }

            cameraContainer.style.display = 'block';
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
        });

        // Limpar tudo ao enviar o formulário (opcional)
        document.querySelector('form').addEventListener('submit', function() {
            if (cameraActive) {
                Webcam.reset();
            }
        });
    });
</script>