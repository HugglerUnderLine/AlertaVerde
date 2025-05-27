<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <title>Login • Alerta Verde</title>
    
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

<body>
    <header class="menu-login">
        <div>
            <a href="<?= base_url('home') ?>" class="voltar-link">
                <img src="<?= base_url('assets/img/voltar.svg') ?>" alt="Voltar" class="voltar-icon"/>
                Voltar para a Home
            </a>
        </div>
    </header>

    <main class="login-bg">
        <section class="login-container">
            <div class="formulario-box">
                <div class="formulario-header">
                    <h1 class="formulario-titulo">Entre no Alerta Verde</h1>
                    <p class="formulario-subtitulo">Insira suas credenciais para acessar sua conta.</p>
                </div>

                <form method="POST" id="formulario_login" action="<?= base_url('login') ?>" class="form">
                    <div class="formulario-campo">
                        <label for="email" class="formulario-label">E-mail</label>
                        <input type="email" name="email" id="email" placeholder="E-mail" class="formulario-input" />
                    </div>
                    <div class="formulario-campo">
                        <label for="senha" class="formulario-label">Senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Senha" class="formulario-input" />
                    </div>

                    <div class="formulario-campo">
                        <p class="formulario-label">Tipo de conta:</p>
                        <div class="formulario-radio-group">
                            <label class="formulario-radio">
                                <input type="radio" name="tipoConta" value="cidadao" checked /> Cidadão
                            </label>
                            <label class="formulario-radio">
                                <input type="radio" name="tipoConta" value="orgao" /> Órgão ou Agência
                            </label>
                        </div>
                    </div>
                    
                    <div id="validation-error-container">
                        <div class="error-title">Erro:</div>
                        <ul></ul>
                    </div>

                    <button type="submit" class="formulario-botao">
                        Entrar
                        <span class="material-symbols-rounded align-middle">login</span>
                    </button>
                    
                    <p class="formulario-link-texto">
                        Não tem uma conta?
                        <a href="<?= base_url('cadastro') ?>" class="formulario-link">Registre-se</a>
                    </p>
                </form>
            </div>
        </section>
    </main>

    <script src="<?= base_url('assets/JQuery-3.7.0/jquery-3.7.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('/assets/jquery-validation-1.19.5/jquery.validate.min.js') ?>"></script>
    <script src="<?= base_url('/assets/jquery-validation-1.19.5/additional-methods.min.js') ?>"></script>
    
    <script type="text/javascript">
        $(document).ready(function () {
            const $errorContainer = $('#validation-error-container');
            const $errorList = $errorContainer.find('ul'); // Cache da lista de erros

            // Função para exibir APENAS mensagens de erro
            function displayLoginErrors(messages) {
                $errorContainer.removeClass('message-success').addClass('message-error'); // Garante estilo de erro
                $errorList.empty();
                if (typeof messages === 'object') {
                    $.each(messages, function(key, value) {
                        $errorList.append('<li>' + value + '</li>');
                    });
                } else {
                    $errorList.append('<li>' + messages + '</li>');
                }
                // Garante que o título de erro esteja presente
                if ($errorContainer.find('.error-title').length === 0) {
                    $errorContainer.prepend('<div class="error-title">Erro:</div>');
                }
                $errorContainer.slideDown();
            }

            // Exibe erros vindos do servidor na carga da página (ex: tentativa de login anterior falhou)
            const serverMessage = <?= !empty($msg) ? json_encode($msg) : 'null' ?>;
            if (serverMessage) {
                displayLoginErrors(serverMessage);
            }
            
            const validator = $('#formulario_login').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        minlength: 10,
                        maxlength: 255
                    },
                    senha: {
                        required: true,
                        minlength: 6,
                        maxlength: 256
                    },
                    tipoConta: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        required: "O E-mail é obrigatório.",
                        email: "O E-mail deve conter um e-mail válido.",
                        minlength: "O E-mail fornecido é muito curto.",
                        maxlength: "O E-mail fornecido é muito longo."
                    },
                    senha: {
                        required: "A senha é obrigatória.",
                        minlength: "A senha fornecida é muito curta.",
                    },
                    tipoConta: "O tipo de conta é obrigatório."
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
                    displayLoginErrors(errorMessages); 
                },
                submitHandler: function(form) {
                    $errorContainer.slideUp(); // Esconde erros anteriores
                    const $form = $(form);
                    const $submitButton = $form.find('button[type="submit"]');
                    const originalButtonHtml = $submitButton.html();
                    let loginBemSucedido = false; // Flag para controlar o estado do botão no 'complete'

                    let dadosParaEnviar = {};

                    const tipoContaSelecionado = $('input[name="tipoConta"]:checked').val();
                    // URLs de autenticação específicas por tipo de conta
                    const actionUrl = (tipoContaSelecionado === 'cidadao') 
                        ? '<?= base_url("login/cidadao") ?>' 
                        : '<?= base_url("login/orgao") ?>';

                    dadosParaEnviar = {
                        email: $('#email').val(),
                        senha: $('#senha').val(),
                        tipoConta: tipoContaSelecionado,
                    };
                    
                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: dadosParaEnviar,
                        dataType: 'json',
                        beforeSend: function() {
                            loginBemSucedido = false; // Reseta a flag
                            $submitButton.prop('disabled', true).html('<span class="spinner"></span> Validando...');
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                loginBemSucedido = true; // Define a flag de sucesso
                                $submitButton.html('Logado! Redirecionando...'); 
                                
                                const redirectUrl = response.redirect_url || 
                                                    (tipoContaSelecionado === 'cidadao' ? '<?= base_url("painel/cidadao") ?>' : '<?= base_url("painel/orgao") ?>');
                                
                                // Pequeno delay para o usuário ver a mensagem no botão antes de redirecionar
                                setTimeout(function() {
                                    window.location.href = redirectUrl;
                                }, 1500); // 1.5 segundos de delay

                            } else { // Erro de negócio
                                displayLoginErrors(response.message || 'Falha na autenticação. Verifique seus dados.');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Erro AJAX Login:", textStatus, errorThrown, jqXHR.responseText);
                            displayLoginErrors('Ocorreu um erro na comunicação. Tente novamente.');
                        },
                        complete: function() {
                            if (!loginBemSucedido) { // Só reabilita se o login não foi bem-sucedido
                                $submitButton.prop('disabled', false).html(originalButtonHtml);
                            }
                            // Se loginBemSucedido for true, o botão permanece desabilitado com a mensagem de sucesso/redirecionando.
                        }
                    });
                }
            });
        });

        // document.addEventListener('keydown', function (e) {
        //     if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
        //         e.preventDefault();
        //     }
        // });
        // document.addEventListener('contextmenu', function (e) {
        //     e.preventDefault();
        // });
    </script>
</body>
</html>