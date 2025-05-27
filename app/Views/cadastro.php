<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <title>Cadastro • Alerta Verde</title>
    
    <style>
        /* Estilo para o campo de formulário inválido */
        .formulario-input.is-invalid {
            border-color: #dc3545; /* Vermelho Bootstrap para perigo */
        }

        /* Base para o container de mensagens */
        #form-message-container {
            display: none; 
            padding: 15px; 
            margin-bottom: 20px;
            border-radius: 5px; 
            border: 1px solid transparent;
        }
        /* Estilo específico para mensagens de ERRO */
        #form-message-container.message-error {
            background-color: #f8d7da; 
            color: #842029; 
            border-color: #f5c2c7;
        }
        #form-message-container.message-error .message-title { 
            font-weight: bold; 
            margin-bottom: 10px; 
        }
        #form-message-container.message-error ul { 
            margin: 0; 
            padding-left: 20px; 
            list-style-type: disc;
        }

        /* Estilo específico para mensagens de SUCESSO */
        #form-message-container.message-success {
            background-color: #d4edda; 
            color: #155724; 
            border-color: #c3e6cb;
            text-align: center; 
            font-weight: bold;
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
</head>

<body class="login-bg">
    <header class="menu-login">
        <div>
            <a href="<?= base_url('home') ?>" class="voltar-link">
                <img src="<?= base_url('assets/img/voltar.svg') ?>" alt="Voltar" class="voltar-icon" />
                Voltar para a Home
            </a>
        </div>
    </header>

    <main class="login-container">
        <section class="formulario-box">
            <div class="formulario-header">
                <h1 class="formulario-titulo">Crie sua conta</h1>
                <p class="formulario-subtitulo">Cadastre-se para começar a relatar problemas na sua comunidade.</p>
            </div>

            <form id="formulario_cadastro" class="formulario" method="POST" action="<?= base_url('cadastro') ?>">
                <div class="formulario-campo">
                    <label class="formulario-label">Tipo de Conta *</label>
                    <div class="formulario-radio-group">
                        <label class="formulario-radio">
                            <input type="radio" name="tipoConta" value="cidadao" checked /> Cidadão
                        </label>

                        <label class="formulario-radio">
                            <input type="radio" name="tipoConta" value="orgao"/> Órgão ou Agência
                        </label>
                    </div>
                </div>

                <div id="camposCidadao">
                    <div class="formulario-campo">
                        <label for="nome_completo" class="formulario-label">Nome Completo</label>
                        <input type="text" id="nome_completo" name="nome_completo" placeholder="Seu nome completo" class="formulario-input"/>
                    </div>

                    <div class="formulario-campo">
                        <label for="email_cidadao" class="formulario-label">Seu E-mail</label>
                        <input type="email" id="email_cidadao" name="email_cidadao" placeholder="seu.email@dominio.com" class="formulario-input"/>
                    </div>
                </div>

                <div id="camposOrgao" style="display: none;">
                    <div class="formulario-campo">
                        <label for="nome_orgao" class="formulario-label">Nome do Órgão/Agência</label>
                        <input type="text" id="nome_orgao" name="nome_orgao" placeholder="Nome completo do órgão" class="formulario-input"/>
                    </div>

                    <div class="formulario-campo">
                        <label for="descricao" class="formulario-label">Descrição</label>
                        <textarea id="descricao" name="descricao" rows="3" placeholder="Fale sobre o que o órgão representa..." class="formulario-input"></textarea>
                    </div>

                    <div class="formulario-campo">
                        <label for="telefone_contato" class="formulario-label">Telefone</label>
                        <input type="tel" id="telefone_contato" name="telefone_contato" placeholder="(XX) XXXXX-XXXX" class="formulario-input"/>
                    </div>

                    <div class="formulario-campo">
                        <label for="email_institucional" class="formulario-label">E-mail Institucional</label>
                        <input type="email" id="email_institucional" name="email_institucional" placeholder="contato@orgao.gov" class="formulario-input" value="<?= $email_institucional ?? '' ?>"/>
                    </div>

                    <div class="formulario-campo">
                        <label for="cep" class="formulario-label">CEP</label>
                        <input type="text" id="cep" name="cep" placeholder="XXXXX-XXX" class="formulario-input" value="<?= isset($cep) && !empty($cep) ? $cep : '' ?>"/>
                    </div>

                    <div class="formulario-campo">
                        <label for="logradouro" class="formulario-label">Logradouro</label>
                        <input type="text" id="logradouro" name="logradouro" placeholder="Rua, Avenida..." class="formulario-input"/>
                    </div>

                    <div class="formulario-campo">
                        <label for="numero" class="formulario-label">Número</label>
                        <input type="text" id="numero" name="numero" placeholder="Nº" class="formulario-input"/>
                    </div>

                    <div class="formulario-campo">
                        <label for="bairro" class="formulario-label">Bairro</label>
                        <input type="text" id="bairro" name="bairro" placeholder="Bairro" class="formulario-input"/>
                    </div>

                    <div class="formulario-campo">
                        <label for="ponto_referencia" class="formulario-label">Ponto de Referência</label>
                        <input type="text" id="ponto_referencia" name="ponto_referencia" placeholder="Próximo a..." class="formulario-input"/>
                    </div>

                </div>
                
                <div class="formulario-campo">
                    <label for="senha" class="formulario-label">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Crie uma senha forte" class="formulario-input"/>
                </div>

                <div class="formulario-campo">
                    <label for="confirmarSenha" class="formulario-label">Confirmar Senha</label>
                    <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Repita a senha" class="formulario-input"/>
                </div>

                <div id="form-message-container">
                    <ul Style="list-style-type: none;"></ul>
                </div>

                <button type="submit" class="formulario-botao">Criar conta</button>
                <p class="formulario-link-texto">Já tem uma conta? <a href="<?= base_url('login') ?>" class="formulario-link">Entre aqui</a></p>
            </form>
        </section>
    </main>

    <script src="<?= base_url('assets/JQuery-3.7.0/jquery-3.7.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('/assets/jquery-validation-1.19.5/jquery.validate.min.js') ?>"></script>
    <script src="<?= base_url('/assets/jquery-validation-1.19.5/additional-methods.min.js') ?>"></script>
    
    <script>
        $(document).ready(function() {
            // --- Seletores e Variáveis ---
            const $tipoContaRadios = $('input[name="tipoConta"]');
            const $camposCidadao = $('#camposCidadao');
            const $camposOrgao = $('#camposOrgao');
            const $formMessageContainer = $('#form-message-container'); // Container genérico de mensagens

            // Função para exibir mensagens (erro ou sucesso)
            function displayFormMessage(type, content) {
                $formMessageContainer.removeClass('message-error message-success');
                const $ul = $formMessageContainer.find('ul');
                $ul.empty(); // Limpa mensagens anteriores

                if (type === 'error') {
                    $formMessageContainer.addClass('message-error');
                    $ul.css('list-style-type', 'disc'); // Adiciona marcadores para erros
                    if (typeof content === 'object') {
                        $.each(content, function(key, value) {
                            $ul.append('<li>' + value + '</li>');
                        });
                    } else {
                        $ul.append('<li>' + content + '</li>');
                    }
                } else if (type === 'success') {
                    $formMessageContainer.addClass('message-success');
                    $ul.css('list-style-type', 'none'); // Remove marcadores para sucesso
                    $ul.html('<li>' + content + '</li>'); // Mensagem de sucesso como item único
                }
                $formMessageContainer.slideDown();
            }

            const validator = $('#formulario_cadastro').validate({
                rules: {
                    tipoConta: {
                        required: true,
                    },
                    // Cidadao
                    nome_completo: { 
                        required: true, 
                        minlength: 5,
                        maxlength: 250,
                    }, 
                    email_cidadao: {
                        required: { 
                            depends: function() { 
                                return $('input[name="tipoConta"]:checked').val() === 'cidadao'; 
                            } 
                        },
                        email: true, 
                        maxlength: 255 
                    },

                    // Orgao
                    nome_orgao: { 
                        required: { 
                            depends: function() { 
                                return $('input[name="tipoConta"]:checked').val() === 'orgao'; 
                            }
                        },
                        minlength: 10,
                        maxlength: 150,
                    },
                    descricao: { 
                        required: { 
                            depends: function() { 
                                return $('input[name="tipoConta"]:checked').val() === 'orgao'; 
                            } 
                        },
                        minlength: 10,
                        maxlength: 4000
                    },
                    telefone_contato: { 
                        required: { 
                            depends: function() { 
                                return $('input[name="tipoConta"]:checked').val() === 'orgao'; 
                            } 
                        },
                        minlength: 11,
                        maxlength: 20
                    },
                    email_institucional: { 
                        required: { 
                            depends: function() { 
                                return $('input[name="tipoConta"]:checked').val() === 'orgao'; 
                            } 
                        },
                        email: true,
                        maxlength: 255,
                    },
                    cep: { 
                        required: { 
                            depends: function() { 
                                return $('input[name="tipoConta"]:checked').val() === 'orgao'; 
                            } 
                        },
                        minlength: 9,
                        maxlength: 9,
                    },
                    logradouro: { 
                        required: { 
                            depends: function() { 
                                return $('input[name="tipoConta"]:checked').val() === 'orgao'; 
                            } 
                        },
                        minlength: 8,
                        maxlength: 150,
                    },
                    numero: { 
                        required: { 
                            depends: function() { 
                                return $('input[name="tipoConta"]:checked').val() === 'orgao'; 
                            } 
                        },
                        minlength: 1,
                        maxlength: 6,
                    },
                    bairro: { 
                        required: { 
                            depends: function() { 
                                return $('input[name="tipoConta"]:checked').val() === 'orgao'; 
                            } 
                        },
                        minlength: 5,
                        maxlength: 125,
                    },
                    ponto_referencia: {
                        maxlength: 150,
                    },
                    senha: { 
                        required: true, 
                        minlength: 8,
                        maxlength: 256,
                    },
                    confirmarSenha: { 
                        required: true, 
                        equalTo: "#senha" 
                    }
                },
                messages: {
                    tipoConta: {
                        required: 'O tipo da conta é obrigatório.',
                    },
                    nome_completo: { 
                        required: "O nome é obrigatório.", 
                        minlength: "O nome informado é muito curto.",
                        maxlength: "O nome informado é muito longo",
                    }, 
                    email_cidadao: { 
                        required: "O e-mail é obrigatório.",
                        email: "Por favor, insira um e-mail de acesso válido.",
                        maxlength: "O e-mail informado é muito longo.",
                    },
                    nome_orgao: { 
                        required: "O nome do órgão é obrigatório.", 
                        minlength: "O nome do órgão informado é muito curto.",
                        maxlength: "O nome do órgão informado é muito longo.",
                    },
                    descricao: { 
                        required: "A descrição do órgão é obrigatória.",
                        minlength: "A descrição informada é muito curta.",
                        maxlength: "A descrição informada é muito longa.",
                    },
                    telefone_contato: { 
                        required: "O telefone de contato é obrigatório.", 
                        minlength: "O telefone informado é muito curto.",
                        maxlength: "O telefone informado é muito longo.",
                    },
                    email_institucional: { 
                        required: "O E-mail institucional é obrigatório.",
                        email: "Por favor, insira um e-mail institucional válido.",
                        maxlength: "O e-mail informado é muito longo.",
                    },
                    cep: { 
                        required: "O CEP é obrigatório.",
                        minlength: "O CEP informado é muito curto.",
                        maxlength: "O CEP informado é muito longo.",
                    },
                    logradouro: { 
                        required: "O logradouro é obrigatório.",
                        minlength: "O logradouro informado é muito curto.",
                        maxlength: "O logradouro informado é muito longo.",
                    },
                    numero: { 
                        required: "O número é obrigatório.",
                        minlength: "O número informado é muito curto.",
                        maxlength: "O número informado é muito longo.",
                    },
                    bairro: { 
                        required: "O bairro é obrigatório.",
                        minlength: "O bairro informado é muito curto.",
                        maxlength: "O bairro informado é muito longo.",
                    },
                    ponto_referencia: {
                        maxlength: "O ponto de referência é muito longo."
                    },
                    senha: { 
                        required: "A senha é obrigatória.", 
                        minlength: "A senha informada é muito curta.",
                        maxlength: "A senha informada é muito longa.",
                    },
                    confirmarSenha: { 
                        required: "A confirmação de senha é obrigatória.", 
                        equalTo: "As senhas não correspondem." 
                    },
                },
                errorPlacement: function(error, element) {},
                highlight: function(element) { $(element).addClass('is-invalid'); },
                unhighlight: function(element) { $(element).removeClass('is-invalid'); },
                invalidHandler: function(event, validator) {
                    let errorMessages = {};
                     $.each(validator.errorList, function(index, error) {
                        errorMessages['error_' + index] = error.message;
                    });
                    displayFormMessage('error', errorMessages);
                },
                submitHandler: function(form) {
                    $formMessageContainer.slideUp();
                    const $form = $(form);
                    const $submitButton = $form.find('button[type="submit"]');
                    const originalButtonHtml = $submitButton.html();
                    const tipoContaSelecionado = $tipoContaRadios.filter(':checked').val(); 

                    let dadosParaEnviar = {};

                    if (tipoContaSelecionado === 'cidadao') {
                        // Coleta apenas os dados do Cidadão
                        dadosParaEnviar = {
                            nome_completo: $('#nome_completo').val(),
                            email_cidadao: $('#email_cidadao').val(),
                        };
                    } else { // tipoContaSelecionado === 'orgao'
                        // Coleta apenas os dados do Órgão
                        dadosParaEnviar = {
                            nome_orgao: $('#nome_orgao').val(),
                            descricao: $('#descricao').val(),
                            telefone_contato: $('#telefone_contato').val(),
                            email_institucional: $('#email_institucional').val(),
                            cep: $('#cep').val(),
                            logradouro: $('#logradouro').val(),
                            numero: $('#numero').val(),
                            bairro: $('#bairro').val(),
                            ponto_referencia: $('#ponto_referencia').val()
                        };
                    }

                    // Adiciona os campos comuns a TODOS os tipos de conta
                    dadosParaEnviar.senha = $('#senha').val();
                    dadosParaEnviar.confirmarSenha = $('#confirmarSenha').val();
                    dadosParaEnviar.tipo_usuario = tipoContaSelecionado

                    // Determina a URL dinamicamente
                    const actionUrl = (tipoContaSelecionado === 'cidadao') 
                        ? '<?= base_url("usuario/cadastro/cidadao") ?>' 
                        : '<?= base_url("usuario/cadastro/orgao") ?>';
                    
                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: dadosParaEnviar,
                        dataType: 'json',
                        beforeSend: function() {
                            // Desabilita o botão e mostra o spinner
                            $submitButton.prop('disabled', true);
                            $submitButton.html('<span class="spinner"></span> Processando...');
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $submitButton.prop('disabled', true); // Mantém desabilitado
                                $submitButton.html('Sucesso!');

                                let countdown = 5;
                                const successMessageBase = "Sua conta foi criada com sucesso. Redirecionando para o login em ";
                                
                                displayFormMessage('success', successMessageBase + countdown + '...');

                                const countdownInterval = setInterval(function() {
                                    countdown--;
                                    if (countdown >= 0) { // >= 0 para mostrar o 0 antes de redirecionar
                                        $formMessageContainer.find('ul li').text(successMessageBase + countdown + '...');
                                    } 
                                    if (countdown < 0) { // Redireciona quando chega abaixo de 0
                                        clearInterval(countdownInterval);
                                        window.location.href = '<?= base_url("login") ?>';
                                    }
                                }, 1000);

                            } else { // Erros do servidor
                                displayFormMessage('error', response.message || 'Ocorreu um erro no cadastro.');
                                // Reabilitar o botão aqui se a requisição AJAX foi concluída mas teve erro de negócio
                                $submitButton.prop('disabled', false);
                                $submitButton.html(originalButtonHtml);
                            }
                        },
                        error: function() {
                            displayFormMessage('error', 'Ocorreu um erro inesperado na comunicação. Tente novamente mais tarde.');
                             // Reabilitar o botão em caso de erro de AJAX
                            $submitButton.prop('disabled', false);
                            $submitButton.html(originalButtonHtml);
                        },
                    });
                }
            });

            // Lidar com a Troca de Formulário (LIMPEZA DE ERROS) 
            function atualizarCamposVisiveis() {
                validator.resetForm();
                $formMessageContainer.hide();
                const tipoSelecionado = $tipoContaRadios.filter(':checked').val();
                if (tipoSelecionado === 'cidadao') {
                    $camposOrgao.slideUp(); $camposCidadao.slideDown();
                } else {
                    $camposCidadao.slideUp(); $camposOrgao.slideDown();
                }
            }
            atualizarCamposVisiveis();
            $tipoContaRadios.on('change', atualizarCamposVisiveis);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
                e.preventDefault();
            }
        });

        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
    </script>
</body>
</html>