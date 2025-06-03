<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/google-fonts/font.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/material-symbols/material-symbols-rounded.css') ?>">

    <style>
        /* Navbar Hover */
        .highlight-on-hover:hover { 
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            transition: .2s;
        }
        .highlight-on-hover { 
            transition: .2s;
        }

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

        .spinner {
            display: inline-block;
            width: 1.2em;
            height: 1.2em;
            vertical-align: -0.2em;
            border: 0.2em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
        }
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
    </style>

    <title>Painel do Cidadão</title>
</head>

<header class="bg-principal d-flex justify-content-between">
    <div class="d-flex gap-1 m-0 ms-5">
        <a href="#">
            <img class="logo highlight-on-hover" src="<?= base_url('assets/img/alerta_verde_horizontal.png') ?>" alt="Alerta Verde" width="130" height="26">
        </a>
    </div>

    <nav class="d-flex gap-2 align-items-center me-4">
        <button class="bg-botao-header p-2 rounded-2 d-flex align-items-center justify-content-center">
            <span class="material-symbols-rounded">notifications</span>
        </button>
    </nav>
</header>

<body class="text-white">

    <div class="bg-divisao bg-principal d-flex min-vh-100">
        <div class="bg-menu">
            <aside class="bg-aside p-4" style="width: 250px;">
                <div class="d-flex bg-nome align-items-center text-start gap-3">
                    <span class="material-symbols-rounded">person</span>
                    <h3 class="h6 text-white m-0"><?= session('nome_reduzido') ?></h3> 
                </div>
                <nav class="mt-4">
                    <ul class="bg-denuncias nav flex-column gap-3">
                        <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                            <span class="material-symbols-rounded">assignment</span>
                            <a class="nav-link text-white text-start" href="<?= base_url('/painel/cidadao') ?>">Minhas Denúncias</a>
                        </li>
                        <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                            <span class="material-symbols-rounded">account_circle</span>
                            <a href="<?= base_url('/usuario/perfil/'. session('uuid')) ?>" class="nav-link text-white">Perfil</a>
                        </li>
                        <li class="nav-item d-flex gap-2 align-items-center text-start btn text-white highlight-on-hover">
                            <span class="material-symbols-rounded">logout</span>
                            <a class="nav-link text-white" href="<?= base_url('logout') ?>">Sair</a>
                        </li>
                    </ul>
                </nav>
            </aside>
        </div>

        <main class="flex-grow-1 p-4 bg-principal">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4 text-destaque text-white">Denúncias</h1>
                <button type="button" class="btn bg-botao text-white fw-bold" data-bs-toggle="modal" data-bs-target="#modalNovaDenuncia">
                    + Nova denúncia
                </button>
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
                                        <form id="formNovaDenunciaModal" class="row gap-4">
                                            <?= csrf_field() ?>
                                            <div class="form-group col-12">
                                                <label for="titulo_denuncia" class="form-label fw-bold mt-4">Titulo da Denuncia</label>
                                                <input type="text" class="form-control form-control-sm" id="titulo_denuncia" name="titulo_denuncia" placeholder="Ex: Buraco na rua...">
                                            </div>
                                            <div class="form-group col-12 ">
                                                <label for="categoria_denuncia" class="form-label fw-bold ">Categoria:</label>
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
                                                    <option value="9">Zeladoria Urbana / Serviços Públicos</option>
                                                    <option value="10">Outros</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="descricao_denuncia" class="form-label fw-bold ">Descrição:</label>
                                                <textarea class="form-control form-control-sm" id="descricao_denuncia" name="descricao_denuncia" rows="4" placeholder="Forneça uma descrição detalhada do problema."></textarea>
                                            </div>
                                            
                                            <h4 class="fw-bold mt-3">Localização da Denúncia</h4>
                                            <div class="mt-0 mb-0">
                                                <p class="fs-6 fw-normal text-secondary">Informe o endereço do local apontado pela denúncia.</p>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label for="logradouro_denuncia" class="form-label fw-bold">Logradouro</label>
                                                <input type="text" class="form-control form-control-sm" id="logradouro_denuncia" name="logradouro_denuncia" placeholder="Ex: Avenida Brasil">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="numero_denuncia" class="form-label fw-bold">Número</label>
                                                <input type="text" class="form-control form-control-sm" id="numero_denuncia" name="numero_denuncia" placeholder="Ex: 123">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="bairro_denuncia" class="form-label fw-bold">Bairro</label>
                                                <input type="text" class="form-control form-control-sm" id="bairro_denuncia" name="bairro_denuncia" placeholder="Ex: Centro">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cep_denuncia" class="form-label fw-bold">CEP</label>
                                                <input type="text" class="form-control form-control-sm" id="cep_denuncia" name="cep_denuncia" placeholder="Ex: 84000-000">
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="ponto_referencia" class="form-label fw-bold">Ponto de Referência</label>
                                                <input type="text" class="form-control form-control-sm" id="ponto_referencia" name="ponto_referencia" placeholder="Ex: Próximo ao mercado municipal">
                                            </div>

                                            <div class="form-group col-12">
                                                <label class="form-label fw-bold">Mídias (Opcional)</label>
                                                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                                                    <div class="bg-white rounded-3 d-flex flex-column gap-1 justify-content-center align-items-center p-3" style="width: 100%; height: 150px; cursor: pointer;" onclick="document.getElementById('imagens_denuncia').click();">
                                                        <span class="material-symbols-rounded">photo_camera</span>
                                                        <input type="file" class="form-control form-control-sm" id="imagens_denuncia" name="imagens_denuncia[]" accept="image/*" style="display: none;" multiple>
                                                        <p class="fs-6 text-center">Adicionar Imagens <br><small>(JPG, PNG até 10MB)</small></p>
                                                        <div id="previewImagensModal" class="mt-2 d-flex flex-wrap gap-2"></div>
                                                    </div>
                                                    <div class="bg-white rounded-3 d-flex flex-column gap-1 justify-content-center align-items-center p-3" style="width: 100%; height: 150px; cursor: pointer;" onclick="document.getElementById('video_denuncia').click();">
                                                        <span class="material-symbols-rounded">videocam</span>
                                                        <input type="file" class="form-control form-control-sm" id="video_denuncia" name="video_denuncia" accept="video/*" style="display: none;">
                                                        <p class="fs-6 text-center">Adicionar Vídeo <br><small>(MP4, MOV até 50MB)</small></p>
                                                        <div id="previewVideoModal" class="mt-2"></div>
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
                <input type="text" class="form-control" placeholder="Procurar denúncia..." />
                <button class="btn bg-botao text-white">Filtro</button>
            </div>

            <div class="mb-4">
                <button class="btn bg-botao text-white me-2">Ativas</button>
                <button class="btn btn-outline-light text-white me-2">Resolvidas</button>
                <button class="btn btn-outline-light text-white">Todas</button>
            </div>

            <section class="d-flex flex-column gap-3">

                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Visualização de árvore caída.</h5>
                        <p class="card-text">Pedido no estacionamento principal da UTFPR, há uma árvore caída.</p>
                        <p class="small">📍 R. Doutor Washington Subtil Chueire, 330 - UFPR | 2 dias atrás</p>
                        <button class="btn bg-botao-detalhes text-white btn-sm mt-2">Ver detalhes</button>
                        <span class="badge bg-botao-hover white-text position-absolute top-0 end-0 m-3">Em progresso</span>
                    </div>
                </div>


                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Poste de iluminação quebrado</h5>
                        <p class="card-text">A iluminação do poste está quebrada há mais de uma semana, gerando preocupação com a
                        segurança.</p>
                        <p class="small">📍 Avenida Doutor Vicente Machado, 100 | 1 semana atrás</p>
                        <button class="btn bg-botao-detalhes text-white btn-sm mt-2">Ver detalhes</button>
                        <span class="badge bg-warning white-text position-absolute top-0 end-0 m-3">Pendente</span>
                    </div>
                </div>

                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Descarte inapropriado de lixo</h5>
                        <p class="card-text">Materiais de construção e resíduos diversos descartados ilegalmente.</p>
                        <p class="small">📍 Rua Coronel Dulcídio, 620 | 3 dias atrás</p>
                        <button class="btn bg-botao-detalhes text-white btn-sm mt-2">Ver detalhes</button>
                        <span class="badge bg-secondary white-text position-absolute top-0 end-0 m-3">Inativo</span>
                    </div>
                </div>

            </section>
        </main>
    </div>

<script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/JQuery-3.7.0/jquery-3.7.0.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
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
                const originalButtonHtml = $submitButton.html();
                let denunciaBemSucedida = false; // Flag para controlar o estado do botão no 'complete'

                let dadosParaEnviar = {};

                const actionUrl = '<?= base_url("painel/cidadao/denuncia/registro") ?>';

                dadosParaEnviar = {
                    titulo_denuncia: $('#titulo_denuncia').val(),
                    categoria_denuncia: $('#categoria_denuncia').val(),
                    descricao_denuncia: $('#descricao_denuncia').val(),
                    logradouro_denuncia: $('#logradouro_denuncia').val(),
                    numero_denuncia: $('#numero_denuncia').val(),
                    bairro_denuncia: $('#bairro_denuncia').val(),
                    cep_denuncia: $('#cep_denuncia').val(),
                    ponto_referencia: $('#ponto_referencia').val(),
                };
                
                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: dadosParaEnviar,
                    dataType: 'json',
                    beforeSend: function() {
                        denunciaBemSucedida = false; // Reseta a flag
                        $submitButton.prop('disabled', true).html('<span class="spinner"></span> Processando...');
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            denunciaBemSucedida = true; // Define a flag de sucesso
                            $submitButton.html('Sucesso! Sua denúncia foi enviada e está aguardando verificação.'); 

                        } else { // Erro de negócio
                            displayDenunciaErrors(response.message || 'Algo deu errado ao processar o envio da sua denúncia.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Erro AJAX Denúncia:", textStatus, errorThrown, jqXHR.responseText);
                        displayDenunciaErrors('Ocorreu um erro na comunicação. Tente novamente.');
                    },
                    complete: function() {
                        if (!denunciaBemSucedida) { // Só reabilita se o envio da denúncia não foi bem sucedido
                            $submitButton.prop('disabled', false).html(originalButtonHtml);
                        }

                        let countdown = 5;

                        const countdownInterval = setInterval(function() {
                            countdown--;
                            if (countdown < 0) { // Redireciona quando chega abaixo de 0
                                $('#modalNovaDenuncia').modal('hide');
                            }
                        }, 1000);
                    }
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    // Lógica para o input de imagem
    const imagemModalInput = document.getElementById("imagem_denuncia");
    if (imagemModalInput) {
        imagemModalInput.addEventListener("change", function(event) {
            const previewContainer = document.getElementById("previewImagensModal");
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
    const videoModalInput = document.getElementById("video_denuncia");
    if (videoModalInput) {
        videoModalInput.addEventListener("change", function(event) {
            const previewContainer = document.getElementById("previewVideoModal");
            if (previewContainer && event.target.files[0]) {
                 previewContainer.innerHTML = `<small class="text-muted">${event.target.files[0].name}</small>`;
            } else if (previewContainer) {
                previewContainer.innerHTML = '';
            }
        });
    }
});

</script>

</body>
</html>