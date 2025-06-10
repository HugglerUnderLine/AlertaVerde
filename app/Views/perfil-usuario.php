<?= $this->extend('layouts/default') ?>

<?= $this->section('page-title') ?>
<title>Meu Perfil</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="p-4 flex-fill">
    <section>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 text-destaque text-claro">Meu Perfil</h1>
        </div>
        <p class="fs-6 fw-normal mt-2" style="color: var(--cor-7);">Altere o valor dos campos abaixo com seus novos dados.</p>
    </section>

    <form id="form_usuario" class="row gap-3 bg-secundaria rounded-2 p-4">
        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <label for="nome_completo" class="form-label fw-bold mt-2 text-dark">Nome Completo</label>
                <input type="text" class="form-control" id="nome_completo" name="nome_completo"
                    placeholder="Ex: João da Silva"
                    value="<?= esc($nome_completo) ?>">
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <label for="email" class="form-label fw-bold text-dark">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="Ex: email.exemplo@dominio.com"
                    value="<?= esc($email) ?>">
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <label for="senha" class="formulario-label fw-bold text-dark">Senha Atual *</label>
                <input type="password" id="senhaAtual" name="senhaAtual" placeholder="Insira sua senha atual" class="form-control"/>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <label for="senha" class="formulario-label fw-bold text-dark">Nova Senha</label>
                <input type="password" id="novaSenha" name="novaSenha" placeholder="Insira uma senha forte" class="form-control"/>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <label for="confirmarSenha" class="formulario-label fw-bold text-dark">Confirme sua Nova Senha</label>
                <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Repita a senha" class="form-control"/>
            </div>
        </div>

        <div id="form-message-container">
            <ul Style="list-style-type: none;"></ul>
        </div>

        <div class="d-flex justify-content-center align-items-center mt-4 mb-3">
            <button type="submit" class="btn-cadastrar btn btn-success w-75 d-flex justify-content-center align-items-center gap-2" id="btnAtualizarUsuario">
                <span class="material-symbols-rounded">save</span>Salvar Alterações
            </button>
        </div>
    </form>
</main>


<?= $this->endSection() ?>

<?= $this->section('more-scripts') ?>

<script src="<?= base_url("assets/jquery-validation-1.19.5/jquery.validate.min.js") ?>"></script>
<script src="<?= base_url("assets/jquery-validation-1.19.5/additional-methods.min.js") ?>"></script>
<script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod("notEqualTo", function(value, element, param) {
            return this.optional(element) || value !== $(param).val();
        }, "Os valores não podem ser iguais.");

        // --- Seletores e Variáveis ---
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

        const validator = $('#form_usuario').validate({
            rules: {
                nome_completo: { 
                    required: true, 
                    minlength: 5,
                    maxlength: 250,
                }, 
                email: { 
                    required: true,
                    email: true,
                    maxlength: 255,
                },
                senhaAtual: { 
                    required: true, 
                    minlength: 8,
                    maxlength: 256,
                },
                novaSenha: { 
                    minlength: 8,
                    maxlength: 256,
                    notEqualTo: "#senhaAtual", // novaSenha não pode ser igual à senhaAtual
                },
                confirmarSenha: { 
                    required: {
                        depends: function() {
                            const novaSenha = $('#novaSenha').val();
                            const senhaAtual = $('#senhaAtual').val();
                            return novaSenha.length >= 8 && novaSenha !== senhaAtual;
                        }
                    },
                    equalTo: "#novaSenha"
                }
            },
            messages: {
                nome_completo: { 
                    required: "O nome é obrigatório.", 
                    minlength: "O nome informado é muito curto.",
                    maxlength: "O nome informado é muito longo",
                }, 
                email: { 
                    required: "O E-mail é obrigatório.",
                    email: "Por favor, insira um e-mail válido.",
                    maxlength: "O e-mail informado é muito longo.",
                },
                senhaAtual: { 
                    required: "A senha atual é obrigatória.", 
                    minlength: "A senha atual informada é muito curta.",
                    maxlength: "A senha atual informada é muito longa.",
                },
                novaSenha: { 
                    minlength: "A nova senha informada é muito curta.",
                    maxlength: "A nova senha informada é muito longa.",
                    notEqualTo: "A nova senha deve ser diferente da senha atual.",
                },
                confirmarSenha: { 
                    required: "A confirmação da nova senha é obrigatória.",
                    equalTo: "A nova senha e sua confirmação não correspondem."
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

                var actionUrl = "<?= base_url('usuario/perfil/' . session()->get('uuid')) ?>";

                let dadosParaEnviar = {};
                dadosParaEnviar = {
                    nome_completo: $('#nome_completo').val(),
                    email: $('#email').val(),
                    senhaAtual: $('#senhaAtual').val(),
                    novaSenha: $('#novaSenha').val(),
                    confirmarSenha: $('#confirmarSenha').val(),
                };

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
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: response.message || 'Seus dados foram atualizados com sucesso.',
                                confirmButtonColor: '#198754', // verde Bootstrap
                                timer: 5000,
                            });
                            $submitButton.html(originalButtonHtml);
                            $submitButton.prop('disabled', false);
                                
                        } else { // Erros do servidor
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: response.message || "Ocorreu um erro ao atualizar seus dados.",
                                confirmButtonColor: '#198754', // verde Bootstrap
                            });

                            // Reabilitar o botão aqui se a requisição AJAX foi concluída mas teve erro de negócio
                            $submitButton.prop('disabled', false);
                            $submitButton.html(originalButtonHtml);
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro de comunicação',
                            text: 'Não foi possível atualizar os seus dados. Tente novamente.',
                            confirmButtonColor: '#198754', // verde Bootstrap
                        });
                        // Reabilitar o botão em caso de erro de AJAX
                        $submitButton.prop('disabled', false);
                        $submitButton.html(originalButtonHtml);
                    },
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>