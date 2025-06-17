<?= $this->extend('layouts/default') ?>

<?= $this->section('page-title') ?>
<title>Painel do Cidadão</title>
<?= $this->endSection() ?>

<?= $this->section('more-styles') ?>
<style>
    .formulario-input.is-invalid {
        border-color: #dc3545;
    }

    #validation-error-container {
        display: none;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #f5c2c7;
        border-radius: 5px;
        background-color: #f8d7da;
        color: #842029;
    }

    #validation-error-container .error-title { 
        font-weight: bold; 
        margin-bottom: 10px; 
    }

    #validation-error-container ul { 
        margin: 0; 
        padding-left: 20px; 
    }

    #modalImagemExpandida {
        z-index: 1060;
    }

    #modalImagemExpandida .modal-content {
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
        border-radius: 8px;
    }

    #modalImagemExpandida .modal-body img {
        object-fit: contain;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="modal fade" id="modalImagemExpandida" tabindex="-1" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
        <div class="modal-content bg-dark text-white position-relative">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <!-- Corpo com a imagem -->
            <div class="modal-body p-2 d-flex justify-content-center align-items-center">
                <img id="imagemExpandida" src="" class="img-fluid rounded-2" alt="Imagem Ampliada" style="max-height: 70vh;">
            </div>
        </div>
    </div>
</div>

<main class="flex-grow-1 p-4 bg-principal">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-destaque text-white">Denúncias</h1>
        <button type="button" class="btn bg-botao text-white fw-bold" data-bs-toggle="modal" data-bs-target="#modalNovaDenuncia">
            + Nova denúncia
        </button>
    </div>

    <div class="modal fade" id="modalDenuncia" tabindex="-1" aria-labelledby="modalDenunciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down bg-principal">
            <div class="modal-content bg-principal text-white">

                <div class="modal-header border-0 bg-principal">
                    <h5 class="modal-title px-2" id="modalDenunciaLabel"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0 bg-principal">
                    <div class="bg-divisao d-flex" style="min-height: 75vh;">
                        <main class="px-4 flex-fill">
                            <section>
                                <div class="d-flex gap-2 align-items-center">
                                    <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            </section>

                            <section class="formulario-main rounded-2 text-dark mt-4 px-4 pt-2 pb-4 mb-4">
                                <div>
                                    <h3 class="fw-bold mt-3">Detalhes da Denuncia</h3>
                                </div>
                                <form id="formDenunciaModal" class="row gap-4" enctype="multipart/form-data">
                                    <div class="form-group col-12">
                                        <label for="titulo" class="form-label fw-bold mt-4">Titulo da Denuncia:</label>
                                        <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" readonly>
                                    </div>
                                    <div class="form-group col-12 ">
                                        <label for="categoria" class="form-label fw-bold ">Categoria: </label>
                                        <select class="form-select form-select-sm" id="categoria" name="categoria" readonly disabled>
                                            <option value="1">Meio Ambiente</option>
                                            <option value="2">Proteção Animal</option>
                                            <option value="3">Iluminação Pública</option>
                                            <option value="4">Trânsito e Vias</option>
                                            <option value="5">Saneamento Básico</option>
                                            <option value="6">Saúde Pública</option>
                                            <option value="7">Obras e Edificações</option>
                                            <option value="8">Poluição Sonora</option>
                                            <option value="9">Zeladoria Urbana</option>
                                            <option value="10">Outros</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="descricao" class="form-label fw-bold ">Descrição:</label>
                                        <textarea class="form-control form-control-sm" id="descricao" name="descricao" rows="4" readonly></textarea>
                                    </div>
                                    
                                    <h4 class="fw-bold mt-3">Localização da Denúncia:</h4>
                                    <div class="form-group col-md-10">
                                        <label for="logradouro" class="form-label fw-bold">Logradouro:</label>
                                        <input type="text" class="form-control form-control-sm" id="logradouro" name="logradouro" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="numero" class="form-label fw-bold">Número:</label>
                                        <input type="text" class="form-control form-control-sm" id="numero" name="numero" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="bairro" class="form-label fw-bold">Bairro:</label>
                                        <input type="text" class="form-control form-control-sm" id="bairro" name="bairro" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="cep" class="form-label fw-bold">CEP:</label>
                                        <input type="text" class="form-control form-control-sm" id="cep" name="cep" readonly>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="referencia" class="form-label fw-bold">Ponto de Referência:</label>
                                        <input type="text" class="form-control form-control-sm" id="referencia" name="referencia" readonly>
                                    </div>

                                    <div class="form-group col-12">
                                        <label class="form-label fw-bold">Mídias:</label>
                                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                                            <div class="bg-white rounded-3 p-3 w-100" style="min-height: 180px;">
                                                <input type="file" class="form-control form-control-sm" id="imagens" name="imagens[]" accept="image/*" style="display: none;" multiple>
                                                <div id="previewImagensModal" class="d-flex flex-wrap gap-2 justify-content-center align-items-center"></div>
                                            </div>
                                            <div class="bg-white rounded-3 p-3 w-100" style="min-height: 180px;">
                                                <input type="file" class="form-control form-control-sm" id="video" name="video" accept="video/*" style="display: none;">
                                                <div id="previewVideoModal" class="d-flex flex-wrap gap-2 justify-content-center align-items-center"></div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </section>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNovaDenuncia" tabindex="-1" aria-labelledby="modalNovaDenunciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-fullscreen-lg-down bg-principal">
            <div class="modal-content bg-principal text-white">

                <div class="modal-header border-0 bg-principal">
                    <h5 class="modal-title px-2" id="modalNovaDenunciaLabel">Registrar Nova Denúncia</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0 bg-principal">
                    <div class="bg-divisao d-flex" style="min-height: 75vh;">
                        <main class="px-4 flex-fill">
                            <section>
                                <div class="d-flex gap-2 align-items-center">
                                    <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="mt-0 mb-1">
                                    <p class="fs-6 fw-normal mt-2" style="color: var(--cor-7);">Forneça mais detalhes sobre o problema que deseja relatar.</p>
                                </div>
                            </section>
                            <section class="formulario-main rounded-2 text-dark mt-4 px-4 pt-2 pb-4 mb-4">
                                <div>
                                    <h3 class="fw-bold mt-3">Detalhes da Denuncia</h3>
                                    <p class="fs-6 mt-2" style="color: var(--cor-8);">Prencha o formulário abaixo com a maior riqueza de detalhes possível.</p>
                                </div>
                                <form id="formNovaDenunciaModal" class="row gap-4" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <div class="form-group col-12">
                                        <label for="titulo_denuncia" class="form-label fw-bold mt-4">Titulo da Denuncia *</label>
                                        <input type="text" class="form-control form-control-sm" id="titulo_denuncia" name="titulo_denuncia" placeholder="Ex: Buraco na rua..." maxlength="150">
                                    </div>
                                    <div class="form-group col-12 ">
                                        <label for="categoria_denuncia" class="form-label fw-bold ">Categoria: *</label>
                                        <select class="form-select form-select-sm" id="categoria_denuncia" name="categoria_denuncia">
                                            <option disabled selected value="0">Selecione...</option>
                                            <option value="1">Meio Ambiente</option>
                                            <option value="2">Proteção Animal</option>
                                            <option value="3">Iluminação Pública</option>
                                            <option value="4">Trânsito e Vias</option>
                                            <option value="5">Saneamento Básico</option>
                                            <option value="6">Saúde Pública</option>
                                            <option value="7">Obras e Edificações</option>
                                            <option value="8">Poluição Sonora</option>
                                            <option value="9">Zeladoria Urbana</option>
                                            <option value="10">Outros</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="descricao_denuncia" class="form-label fw-bold ">Descrição: *</label>
                                        <textarea class="form-control form-control-sm" id="descricao_denuncia" name="descricao_denuncia" rows="4" placeholder="Forneça uma descrição detalhada do problema."></textarea>
                                    </div>
                                    
                                    <h4 class="fw-bold mt-3">Localização da Denúncia *</h4>
                                    <div class="mt-0 mb-0">
                                        <p class="fs-6 fw-normal text-secondary">Informe o endereço do local apontado pela denúncia.</p>
                                    </div>
                                    <div class="form-group col-md-10">
                                        <label for="logradouro_denuncia" class="form-label fw-bold">Logradouro *</label>
                                        <input type="text" class="form-control form-control-sm" id="logradouro_denuncia" name="logradouro_denuncia" placeholder="Ex: Avenida Brasil" maxlength="150">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="numero_denuncia" class="form-label fw-bold">Número *</label>
                                        <input type="text" class="form-control form-control-sm" id="numero_denuncia" name="numero_denuncia" placeholder="Ex: 123" maxlength="6">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="bairro_denuncia" class="form-label fw-bold">Bairro *</label>
                                        <input type="text" class="form-control form-control-sm" id="bairro_denuncia" name="bairro_denuncia" placeholder="Ex: Centro" maxlength="125">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="cep_denuncia" class="form-label fw-bold">CEP *</label>
                                        <input type="text" class="form-control form-control-sm" id="cep_denuncia" name="cep_denuncia" placeholder="Ex: 84000-000" maxlength="9">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="ponto_referencia" class="form-label fw-bold">Ponto de Referência</label>
                                        <input type="text" class="form-control form-control-sm" id="ponto_referencia" name="ponto_referencia" placeholder="Ex: Próximo ao mercado municipal" maxlength="150">
                                    </div>

                                    <div class="form-group col-12">
                                        <label class="form-label fw-bold">Mídias (Opcional)</label>
                                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                                            <div class="bg-white rounded-3 d-flex flex-column gap-1 justify-content-center align-items-center p-3" style="width: 100%; height: 150px; cursor: pointer;" onclick="document.getElementById('imagens_nova_denuncia_input').click();">
                                                <span class="material-symbols-rounded">photo_camera</span>
                                                <input type="file" class="form-control form-control-sm" id="imagens_nova_denuncia_input" name="imagens_denuncia[]" accept="image/*" style="display: none;" multiple>
                                                <p class="fs-6 text-center">Adicionar Imagens <br><small>(JPG, PNG até 10MB)</small></p>
                                                <div id="previewImagensNovaDenuncia" class="mt-2 d-flex flex-wrap gap-2"></div>
                                            </div>
                                            <div class="bg-white rounded-3 d-flex flex-column gap-1 justify-content-center align-items-center p-3" style="width: 100%; height: 150px; cursor: pointer;" onclick="document.getElementById('video_nova_denuncia_input').click();">
                                                <span class="material-symbols-rounded">videocam</span>
                                                <input type="file" class="form-control form-control-sm" id="video_nova_denuncia_input" name="video_denuncia" accept="video/*" style="display: none;">
                                                <p class="fs-6 text-center">Adicionar Vídeo <br><small>(MP4, MOV até 50MB)</small></p>
                                                <div id="previewVideoNovaDenuncia" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="validation-error-container">
                                        <div class="error-title">Erro:</div>
                                        <ul></ul>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center align-items-center mt-3">
                                        <button type="submit" class="btn-enviar btn btn-success w-75 d-flex justify-content-center align-items-center gap-2">
                                            <span class="material-symbols-rounded">send</span>
                                            Enviar Denúncia
                                        </button>
                                    </div>
                                </form>
                            </section>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="input-group mb-4">
        <input type="text" id="filtroTitulo" class="form-control" placeholder="Procurar denúncia..." />
        <button class="btn bg-botao text-white" id="btnFiltro">Filtrar</button>
    </div>

    <div class="mb-4">
        <button class="btn btn-outline-warning text-white me-2 filtro-status" data-status="Todas">Todas</button>
        <button class="btn btn-outline-warning text-white me-2 filtro-status" data-status="Pendente">Pendentes</button>
        <button class="btn btn-outline-warning text-white me-2 filtro-status" data-status="Em Progresso">Em Progresso</button>
        <button class="btn btn-outline-warning text-white me-2 filtro-status" data-status="Resolvido">Resolvidas</button>
    </div>

    <section id="listaDenuncias" class="d-flex flex-column gap-3">
        <!-- Cards AJAX são inseridos aqui -->
    </section>

</main>

<?= $this->endSection() ?>

<!--===========================================================================================================-->
<!--===========================================================================================================-->
<!--===========================================================================================================-->
<?= $this->section('more-scripts') ?>
<script src="<?= base_url('assets/jquery-validation-1.19.5/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('assets/jquery-validation-1.19.5/additional-methods.min.js') ?>"></script>
    
<script>
    $(document).ready(function () {
        const $errorContainer = $('#validation-error-container');
        const $errorList = $errorContainer.find('ul'); // Cache da lista de erros

        // Função para exibir APENAS mensagens de erro
        function displayDenunciaErrors(messages) {
            $errorContainer.removeClass('message-success').addClass('message-error');

            $errorList.empty();
            if (typeof messages === 'object') {
                $.each(messages, function(key, value) {
                    $errorList.append('<li>' + value + '</li>');
                });
            } else {
                $errorList.append('<li>' + messages + '</li>');
            }

            if ($errorContainer.find('.error-title').length === 0) {
                $errorContainer.prepend('<div class="error-title">Erro:</div>');
            }
            $errorContainer.slideDown();
        }

        const serverMessage = <?= !empty($msg) ? json_encode($msg) : 'null' ?>;
        if (serverMessage) {
            displayDenunciaErrors(serverMessage);
        }
        
        const validator = $('#formNovaDenunciaModal').validate({
            rules: {
                titulo_denuncia: {
                    required: true,
                    minlength: 5,
                    maxlength: 150
                },
                categoria_denuncia: {
                    required: true,
                },
                descricao_denuncia: {
                    required: true,
                    minlength: 10,
                    maxlength: 4000,
                },
                logradouro_denuncia: {
                    required: true,
                    minlength: 8,
                    maxlength: 150,
                },
                numero_denuncia: {
                    required: true,
                    minlength: 1,
                    maxlength: 6,
                },
                bairro_denuncia: {
                    required: true,
                    minlength: 5,
                    maxlength: 125,
                },
                cep_denuncia: {
                    required: true,
                    minlength: 9,
                    maxlength: 9,
                },
                ponto_referencia: {
                    maxlength: 150,
                },
                'imagens_denuncia[]': { 
                    required: false, 
                    extension: "jpg|jpeg|png|gif", 
                    filesize: 10485760 /* 10MB */ 
                },
               'video_denuncia': { 
                    required: false, 
                    extension: "mp4|mov",
                    filesize: 52428800 /* 50MB */ 
                }
            },
            messages: {
                titulo_denuncia: {
                    required: "O Título da denúncia deve ser preenchido.",
                    minlength: "O Título da denúncia informado é muito curto.",
                    maxlength: "O Título da denúncia informado é muito longo.",
                },
                categoria_denuncia: {
                    required: "A Categoria da denúncia deve ser preenchida.",
                },
                descricao_denuncia: {
                    required: "A Descrição da denúncia deve ser preenchida.",
                    minlength: "A Descrição da denúncia informada muito curta.",
                    maxlength: "A Descrição da denúncia informada muito longa.",
                },
                logradouro_denuncia: {
                    required: "O Logradouro deve ser preenchido.",
                    minlength: "O Logradouro informado é muito curto.",
                    maxlength: "O Logradouro informado é muito longo.",
                },
                numero_denuncia: {
                    required: "O Número deve ser preenchido.",
                    minlength: "O Número informado é muito curto.",
                    maxlength: "O Número informado é muito longo.",
                },
                bairro_denuncia: {
                    required: "O Bairro deve ser preenchido.",
                    minlength: "O Bairro informado é muito curto.",
                    maxlength: "O Bairro informado é muito longo.",
                },
                cep_denuncia: {
                    required: "O CEP deve ser preenchido.",
                    minlength: "O CEP informado é muito curto.",
                    maxlength: "O CEP informado é muito longo.",
                },
                ponto_referencia: {
                    maxlength: "O Ponto de Referência informado é muito longo.",
                },
                'imagens_denuncia[]': { 
                    extension: "Uma ou mais imagens não correspondem ao formato esperado (jpg, jpeg, png, gif)", 
                    filesize: 10485760 /* 10MB */ 
                },
               'video_denuncia': { 
                    extension: "O vídeo anexado não corresponde ao formato esperado (mp4, mov)",
                    filesize: 52428800 /* 50MB */ 
                }
            },
            errorPlacement: function(error, element) {},
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            invalidHandler: function (event, validatorInstance) {
                let errorMessages = {};
                $.each(validatorInstance.errorList, function(index, error) {
                    errorMessages['error_' + index] = error.message;
                });
                displayDenunciaErrors(errorMessages); 
            },
            submitHandler: function(form) {
                $errorContainer.slideUp(); // Esconde erros anteriores
                const $form = $(form);
                const $submitButton = $form.find('button[type="submit"]');
                // Armazena o HTML original do botão se ainda não foi armazenado
                if (!$submitButton.data('original-html')) {
                    $submitButton.data('original-html', $submitButton.html());
                }
                const originalButtonHtml = $submitButton.data('original-html');
                let denunciaBemSucedida = false; // Flag para controlar o estado do botão no 'complete'

                let dadosParaEnviar = {};

                const actionUrl = '<?= base_url("painel/cidadao/denuncia/registro") ?>';
                const formData = new FormData(form); 
                
                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false, // Impede o jQuery de processar o FormData
                    contentType: false, // Deixa o navegador definir o Content-Type correto para multipart/form-data
                    beforeSend: function() {
                        denunciaBemSucedida = false; // Reseta a flag
                        $submitButton.prop('disabled', true).html('<span class="spinner"></span> Processando...');
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                           Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: response.message || 'Sua Denúncia foi enviada com sucesso!',
                                confirmButtonColor: '#198754', // verde Bootstrap
                                timer: 5000,
                            }).then(() => {
                                carregarDenuncias();
                                $submitButton.prop('disabled', false).html(originalButtonHtml);
                                $('#modalNovaDenuncia').modal('hide');
                            });

                        } else { // Erro de negócio
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: response.message || 'Algo deu errado ao efetuar o registro da sua denúncia. Por favor, tente novamente.',
                                confirmButtonColor: '#198754', // verde Bootstrap
                            });

                            // Se não foi sucesso, restaura o botão para seu estado original
                            $submitButton.prop('disabled', false).html(originalButtonHtml);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro de Comunicação',
                            text: 'Não foi possível estabelecer uma conexão com o servidor. Por favor, entre em contato com um administrador ou tente novamente em alguns instantes.',
                            confirmButtonColor: '#198754', // verde Bootstrap
                        });
                    },
                });
            }
        });

        function carregarDenuncias(filtros = {}) {
            $.ajax({
                url: '<?= base_url("/painel/cidadao/list") ?>',
                method: 'POST',
                data: filtros,
                dataType: 'json',
                success: function (response) {
                    const container = $('#listaDenuncias');
                    container.empty();

                    if (response.length === 0) {
                        container.append('<div class="text-white">Nenhuma denúncia encontrada.</div>');
                        return;
                    }

                    response.forEach(denuncia => {
                        const emAtendimento = denuncia.orgao_responsavel 
                            ? `<p class="mt-2 mb-2 small">Em atendimento por:<strong> ${denuncia.orgao_responsavel}</strong></p>` 
                            : '<p class="mt-2 mb-2 small">Aguardando Atribuição</p>';

                        const card = `
                            <div class="card bg-secundaria position-relative" data-id="${denuncia.id_denuncia}">
                                <div class="card-body">
                                    <h5 class="card-title">${denuncia.titulo}</h5>
                                    <p class="card-text small">${denuncia.descricao}</p>
                                    <p class="small text-secondary">📍 ${denuncia.localizacao} | ${denuncia.tempo}</p>
                                    ${emAtendimento}
                                    <button class="btn bg-botao-detalhes text-white btn-sm mt-2 btn-ver-detalhes">Ver detalhes</button>
                                    <span class="badge ${getStatusBadge(denuncia.status)} position-absolute top-0 end-0 m-3">${denuncia.status}</span>
                                </div>
                            </div>
                        `;
                        container.append(card);
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao carregar',
                        text: 'Ocorreu um erro ao tentar carregar as denúncias. Tente novamente.',
                        confirmButtonColor: '#198754', // verde Bootstrap
                    });
                }
            });
        }


        $('#btnFiltro').on('click', function () {
            const titulo = $('#filtroTitulo').val();
            const status = $('.filtro-status.btn.bg-botao').data('status') || 'Todas';
            carregarDenuncias({ status, titulo });
        });

        $('#filtroTitulo').on('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Evita comportamento padrão de envio de formulário
                $('#btnFiltro').click(); // Dispara o clique do botão
            }
        });

        $('.filtro-status').on('click', function () {
            $('.filtro-status').removeClass('bg-botao').addClass('btn-outline-warning');
            $(this).removeClass('btn-outline-warning').addClass('bg-botao');

            const status = $(this).data('status');
            const titulo = $('#filtroTitulo').val();
            carregarDenuncias({ status, titulo });
        });

        window.atualizarDenuncias = function () {
            const titulo = $('#filtroTitulo').val();
            const status = $('.filtro-status.bg-botao').data('status') || 'Todas';
            carregarDenuncias({ status, titulo });
        };

        function getStatusBadge(status) {
            switch (status.toLowerCase()) {
                case 'pendente':
                    return 'bg-warning text-white';
                case 'em progresso':
                    return 'bg-info text-white';
                case 'resolvido':
                    return 'bg-success text-white';
                case 'cancelada':
                    return 'bg-danger text-white';
                default:
                    return 'bg-secondary text-white';
            }
        }

        carregarDenuncias(); // Inicial

    });

    // Limpa o formulário e reseta os campos após o modal ser fechado
    $('#modalNovaDenuncia').on('hidden.bs.modal', function () {
        const $form = $('#formNovaDenunciaModal');
        const $submitButton = $form.find('button[type="submit"]');
        const originalHtml = $submitButton.data('original-html') || '<span class="material-symbols-rounded">send</span> Enviar Denúncia'; // Fallback

        $form[0].reset(); // Limpa os campos do formulário
        $('#previewImagensNovaDenuncia').empty(); // Limpa previews de imagens
        $('#previewVideoNovaDenuncia').empty();   // Limpa previews de vídeo
        
        if (validator) { // Verifica se o validador foi inicializado
            validator.resetForm(); // Reseta o estado do jQuery Validation (remove classes .is-invalid, etc.)
        }
        $errorContainer.hide().find('ul').empty(); // Esconde e limpa o container de erros
        
        // Restaura o botão de submit para seu estado original
        $submitButton.prop('disabled', false).html(originalHtml); 
    });

    // Limpa o formulário e reseta os campos após o modal ser fechado
    $('#modalDenuncia').on('hidden.bs.modal', function () {
        const $form = $('#formDenunciaModal');

        $form[0].reset(); // Limpa os campos do formulário
        $('#previewImagens').empty(); // Limpa previews de imagens
        $('#previewVideo').empty();   // Limpa previews de vídeo
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Lógica para o input de imagem
        const imagemModalInput = document.getElementById("imagens_nova_denuncia_input");
        if (imagemModalInput) {
            imagemModalInput.addEventListener("change", function(event) {
                const previewContainer = document.getElementById("previewImagensNovaDenuncia");
                if (previewContainer) {
                    previewContainer.innerHTML = ''; // Limpa previews anteriores
                    Array.from(event.target.files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.style.maxWidth = '80px';
                                img.style.maxHeight = '80px';
                                img.style.marginRight = '5px';
                                previewContainer.appendChild(img);
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                }
            });
        }

        // Lógica para o input de vídeo
        const videoModalInput = document.getElementById("video_nova_denuncia_input");
        if (videoModalInput) {
            videoModalInput.addEventListener("change", function(event) {
                const previewContainer = document.getElementById("previewVideoNovaDenuncia");
                if (previewContainer && event.target.files[0]) {
                    previewContainer.innerHTML = `<small class="text-muted">${event.target.files[0].name}</small>`;
                } else if (previewContainer) {
                    previewContainer.innerHTML = '';
                }
            });
        }
    });

    $(document).on('click', '.btn-ver-detalhes', function () {
        const idDenuncia = $(this).closest('.card').data('id');

        const modalLabel = $('#modalDenunciaLabel');
        $('#previewImagensModal').empty();
        $('#previewVideoModal').empty();
        modalLabel.text("Denúncia #" + idDenuncia);

        $.ajax({
            url: '<?= base_url("/painel/cidadao/denuncias/midias/") ?>' + idDenuncia,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.imagens.length > 0) {
                    response.imagens.forEach(function (imgUrl) {
                        $('#previewImagensModal').append(`
                            <img src="${imgUrl}" data-src="${imgUrl}" class="img-thumbnail imagem-expandivel" style="width: 100px; height: auto; cursor: pointer;">
                        `);

                    });
                } else {
                    $('#previewImagensModal').html('<p class="text-center text-muted">Nenhuma imagem enviada.</p>');
                }

                if (response.videos.length > 0) {
                    response.videos.forEach(function (videoUrl) {
                        $('#previewVideoModal').append(`
                            <video controls class="w-100" style="max-width: 320px;">
                                <source src="${videoUrl}" type="video/mp4">
                                Seu navegador não suporta vídeos.
                            </video>
                        `);
                    });
                } else {
                    $('#previewVideoModal').html('<p class="text-center text-muted">Nenhum vídeo enviado.</p>');
                }
            },
            error: function () {
                $('#previewImagensModal').html('<p class="text-danger">Erro ao carregar imagens.</p>');
                $('#previewVideoModal').html('<p class="text-danger">Erro ao carregar vídeos.</p>');
            }
        });

        $.ajax({
            url: '<?= base_url("/painel/cidadao/denuncias/detalhes/") ?>' + idDenuncia,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#titulo').val(response.titulo_denuncia);
                $('#categoria').val(response.id_tipo_fk);
                $('#descricao').val(response.detalhes);
                $('#logradouro').val(response.logradouro);
                $('#numero').val(response.numero);
                $('#bairro').val(response.bairro);
                $('#cep').val(response.cep);
                $('#referencia').val(response.ponto_referencia);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao carregar os dados da denúncia.',
                    confirmButtonColor: '#198754',
                });
            }
        });

        $('#modalDenuncia').modal('show');
    });

    $(document).on('click', '.imagem-expandivel', function () {
        const imagemSrc = $(this).data('src');
        $('#imagemExpandida').attr('src', imagemSrc);
        $('#modalImagemExpandida').modal('show');
    });



</script>

<?= $this->endSection() ?>