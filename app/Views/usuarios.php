<?= $this->extend('layouts/default') ?>

<?= $this->section('page-title') ?>
<title>Painel da Agência</title>
<?= $this->endSection() ?>

<?= $this->section('more-styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/css/buttons.bootstrap5.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="p-4 flex-fill">
    <section>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 text-destaque text-claro">Usuários</h1>
            <button type="button" class="btn bg-botao text-claro fw-bold" data-bs-toggle="modal" data-bs-target="#modalNovoUsuario">
                + Novo Usuário
            </button>
        </div>
        <p class="fs-6 fw-normal mt-2" style="color: var(--cor-7);">Gerencie usuários cadastrados na sua plataforma.</p>
    </section>

    <div class="modal fade" id="modalNovoUsuario" tabindex="-1" aria-labelledby="modalNovoUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-principal text-white">

                <div class="modal-header border-0 bg-principal">
                    <h5 class="modal-title px-2" id="modalNovoUsuarioLabel">Novo Usuário</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 bg-principal">
                    <section class="formulario-main rounded-2 text-dark mt-0 px-4 pt-2 pb-4 mb-0">

                        <div>
                            <h3 class="fw-bold mt-3">Informações</h3>
                            <p class="fs-6 mt-2" style="color: var(--cor-8);">Preencha os campos com os dados do usuário.</p>
                        </div>

                        <form id="form_usuario" class="row gap-3">
                            <?= csrf_field() ?>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-12">
                                    <label for="nome_completo" class="form-label fw-bold mt-2">Nome Completo</label>
                                    <input type="text" class="form-control" id="nome_completo" name="nome_completo" placeholder="Ex: João da Silva" required>
                                </div>
                            </div>

                            <div class="row justify-content-center align-items-center">
                                <div class="col-12">
                                    <label for="email" class="form-label fw-bold ">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Ex: email.exemplo@dominio.com" required>
                                </div>
                            </div>

                            <div class="row justify-content-center align-items-center form-group">
                                <div class="col-6">
                                    <label for="permissao" class="form-label fw-bold ">Permissão</label>
                                    <select class="form-select" id="permissao" name="permissao">
                                        <option value="orgao_master">Gestor do Órgão</option>
                                        <option value="orgao_representante" selected>Usuário</option>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="status" class="form-label fw-bold ">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="0">Inativo</option>
                                        <option value="1" selected>Ativo</option>
                                    </select>
                                </div>
                            </div>

                            <div id="form-message-container">
                                <ul Style="list-style-type: none;"></ul>
                            </div>

                            <div class="d-flex justify-content-center align-items-center mt-4">
                                <button type="submit" class="btn-cadastrar btn btn-success w-75 d-flex justify-content-center align-items-center gap-2" id="btnCadastrarUsuario">
                                    <span class="material-symbols-rounded">person_add</span>Cadastrar Usuário
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>


    <div class="card bg-secundaria position-relative p-4 mt-2 px-4 pt-2 pb-4">
        <form id="busca_usuario_form" class="mb-4" method="post">
            <div class="row mb-3 g-2 align-items-center" id="filtrosContainer">
                <div class="col-md-auto">
                    <div class="btn-group" role="group" aria-label="Filtros de Status">
                        <button type="button" data-valor="" class="btn btn-filtro-status btn-outline-primary active me-1" id="btnFiltroTodos">Todos</button>
                        <button type="button" data-valor="1" class="btn btn-filtro-status btn-outline-success me-1" id="btnFiltroAtivos">Ativos</button>
                        <button type="button" data-valor="0" class="btn btn-filtro-status btn-outline-secondary" id="btnFiltroInativos">Inativos</button>
                    </div>
                </div>
            
                <div class="col-md d-flex justify-content-md-end align-items-end gap-2 flex-wrap">
                    <div>
                        <select id="selectTipoBuscaTexto" name="selectTipoBuscaTexto" class="form-select" style="width: auto;">
                            <option value="nomeUsuario" selected>Nome</option>
                            <option value="email">E-mail</option>
                        </select>
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="🔍 Buscar..." style="max-width: 250px;" id="filtroBuscaValor" name="filtroBuscaValor">
                    </div>
                    <div class="mt-auto">
                        <button type="button" id="btnAplicarFiltros" class="btn btn-warning py-1 px-2">
                            <span class="material-symbols-rounded align-middle fs-6">filter_alt</span> Filtrar
                        </button>
                        <button type="button" class="btn btn-outline-warning py-1 px-2 tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Limpar Filtros" id="btnLimparFiltros">
                            <span class="material-symbols-rounded align-middle fs-6">filter_alt_off</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table id="listar_usuarios" class="table table-hover align-middle rounded-2 table-striped" style="width:100%">
                <thead class="bg-success bg-opacity-10">
                    <tr>
                        <th>ID</th> <!-- Apenas para validação interna. Não será exibido no Datatables -->
                        <th>UUID</th> <!-- Apenas para validação interna. Não será exibido no Datatables -->
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Permissão</th>
                        <th>Ativo</th>
                        <th>Criado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</main>

<?= $this->endSection() ?>

<!--===========================================================================================================-->
<!--===========================================================================================================-->
<!--===========================================================================================================-->

<?= $this->section('more-scripts') ?>
<script src="<?= base_url("assets/jquery-validation-1.19.5/jquery.validate.min.js") ?>"></script>
<script src="<?= base_url("assets/jquery-validation-1.19.5/additional-methods.min.js") ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/buttons.bootstrap5.min.js') ?>"></script>
<script type="text/javascript">

    DataTable.Buttons.defaults.dom.button.className = 'btn'; //Sobrescreve a estilização padrão dos botões no DataTables
    var url = '<?= base_url("painel/orgao/usuarios/list") ?>';


    // Variáveis para armazenar os valores dos filtros
    let filtroAtivoValor = ""; // Para a opção Todos, recebe uma string vazia por padrão
    let filtroTipoBuscaAtual = $('#selectTipoBuscaTexto').val();
    let filtroBuscaValorAtual = "";


    var table = new DataTable('#listar_usuarios', {
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: "POST",
            data: function(d) {
                d.ativo = filtroAtivoValor === '0' || filtroAtivoValor === '1' ? filtroAtivoValor : null;
                d.coluna_busca = filtroTipoBuscaAtual;
                d.valor_busca = filtroBuscaValorAtual;
            },
        },
        info: true,
        responsive: true,
        pageLength: 10,
        order: [[2, 'asc']],
        language: { url: '<?= base_url('assets/datatables-pt-BR.json') ?>', decimal: ',', thousands: '.' },
        layout: {
            topStart: null,
            topEnd: 'pageLength',
        },
        columnDefs: [{ targets: "_all", orderSequence: ['asc', 'desc'], className: "dt-body-left dt-head-left" }],
        columns: [
            { data: 'usuarioID', visible: false, orderable: false, searchable: false },
            { data: 'uuid', visible: false, orderable: false, searchable: false },
            { data: 'nomeUsuario' },
            { data: 'email' },
            { 
                data: 'permissao', 
                render: function (data, type, row) {
                    if(row['permissao'] == 'orgao_master') {
                        return '<span class="material-symbols-rounded align-bottom text-success btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Gestor do Órgão">shield_person</span>';
                    } else if (row['permissao'] == 'orgao_representante') {
                        return '<span class="material-symbols-rounded align-bottom text-secondary btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Usuário">shield</span>';
                    }
                },
            },
            { 
                data: 'usuarioAtivo', 
                render: function (data, type, row) {
                    if(row['usuarioAtivo'] == '1') {
                        return '<span class="material-symbols-rounded align-bottom text-primary btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ativo">check_circle</span>';
                    } else if (row['usuarioAtivo'] == '0') {
                        return '<span class="material-symbols-rounded align-bottom text-secondary btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Inativo">do_not_disturb_on</span>';
                    }
                },
            },
            { data: 'criadoEm' },
            {
                data: 'acoes', searchable: false, orderable: false, className: 'dt-body-center dt-head-center',
                render: function (data, type, row) {
                    <?php if (session()->get('tipo_usuario') != 'orgao_representante'): ?>
                    return '<a class="btn btn-sm btn-outline-primary p-0 editar-usuario" data-id="' + row['usuarioID'] + '"><span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar">edit</span></a> '
                         + '<a href="<?= base_url("usuario/log") ?>' + row['uuid'] + '" class="btn btn-sm btn-outline-secondary p-0 historico-usuario" id="logUsuario"><span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Histórico de Atividade">history</span></a>';
                    <?php else : ?>
                    return '<a href="<?= base_url("usuario/log") ?>' + row['uuid'] + '" class="btn btn-sm btn-outline-secondary p-0 historico-usuario" id="logUsuario"><span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Histórico de Atividade">history</span></a>';
                    <?php endif ?>
                },
            },
        ],
    } );


    $('#busca_usuario_form').on('submit', function(event) {
        event.preventDefault();
        $('#btnAplicarFiltros').trigger('click'); 
    });


    // Evento para os botões de filtro de status
    $('.btn-filtro-status').on('click', function() {
        $('.btn-filtro-status').removeClass('active btn-primary btn-success btn-secondary btn-outline-primary btn-outline-success btn-outline-secondary');

        $('#btnFiltroTodos').addClass('btn-outline-primary');
        $('#btnFiltroAtivos').addClass('btn-outline-success');
        $('#btnFiltroInativos').addClass('btn-outline-secondary');

        $(this).addClass('active');
        
        const statusValor = $(this).data('valor').toString();
        filtroAtivoValor = statusValor;

        if (statusValor === '1') {
            $(this).removeClass('btn-outline-success').addClass('btn-success');
        } else if (statusValor === '0') {
            $(this).removeClass('btn-outline-secondary').addClass('btn-secondary');
        } else { // "Todos"
             $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        }

        table.draw(); 
    });


    // Evento para o botão "Filtrar"
    $('#btnAplicarFiltros').on('click', function() {
        // Atualiza as variáveis globais com os valores atuais dos campos
        filtroTipoBuscaAtual = $('#selectTipoBuscaTexto').val();
        filtroBuscaValorAtual = $('#filtroBuscaValor').val();
        table.draw();
    });


    // Evento para limpar filtros
    $('#btnLimparFiltros').on('click', function(){
        // Reseta os campos do formulário de filtros
        $('#selectTipoBuscaTexto').val('nomeUsuario'); // Volta para o padrão
        $('#filtroBuscaValor').val('');
        
        // Reseta o filtro de status para "Todos"
        filtroAtivoValor = "";
        $('#btnFiltroTodos').removeClass('btn-outline-primary').addClass('btn-primary active');
        $('#btnFiltroAtivos').removeClass('active btn-success').addClass('btn-outline-success');
        $('#btnFiltroInativos').removeClass('active btn-secondary').addClass('btn-outline-secondary');
        
        // Reseta a ordenação para o padrão e recarrega a tabela
        table.order([[2, 'asc']]).draw();
    });


    $('#selectTipoBuscaTexto').on('change', function() {
        filtroTipoBuscaAtual = $(this).val();
        // Se o campo de busca já tiver algo, refiltra. Senão, espera o usuário digitar ou clicar em "Filtrar".
        if ($('#filtroBuscaValor').val().trim() !== '') {
            filtroBuscaValorAtual = $('#filtroBuscaValor').val();
            table.draw();
        }
    });


    $('#btnLimparFiltros').on('click', function(){
        $('#selectTipoBuscaTexto').val('nomeUsuario');
        $('#filtroBuscaValor').val('');
        
        filtroAtivoValor = "";
        filtroTipoBuscaAtual = $('#selectTipoBuscaTexto').val(); // Reseta para o padrão
        filtroBuscaValorAtual = "";

        $('.btn-filtro-status').removeClass('active btn-primary btn-success btn-secondary').addClass('btn-outline-primary');
        $('#btnFiltroTodos').removeClass('btn-outline-primary').addClass('btn-primary active');
        
        table.order([[2, 'asc']]).draw(); // Reseta ordenação e redesenha a tabela
    });


    // Re-inicializa tooltips do Bootstrap após cada desenho da tabela
    table.on('draw.dt', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('.tt'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            // Remove tooltips antigos para evitar duplicatas
            var existingTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
            if (existingTooltip) {
                existingTooltip.dispose();
            }
            new bootstrap.Tooltip(tooltipTriggerEl); // Cria novo tooltip
        });
    });


    // Abre o modal de edição de usuário
    $('#listar_usuarios').on('click', '.editar-usuario', function(e) {
        e.preventDefault();
        $('#form_usuario')[0].reset();
        var rowData = table.row($(this).parents('tr')).data();
        $('#modalNovoUsuarioLabel').text('Editar Usuário');

        $('#nome_completo').val(rowData['nomeUsuario']);
        $('#email').val(rowData['email']);
        $('#permissao').val(rowData['permissao']);
        $('#status').val(rowData['usuarioAtivo']);
        $('#modalNovoUsuario').data('id', rowData['usuarioID']);
        $('#email').val(rowData['email']).prop('disabled', true);
        $('#btnCadastrarUsuario').html('<span class="material-symbols-rounded">save</span>Salvar Alterações');
        $('#modalNovoUsuario').modal('show');
    });


    // Limpa o formulário e reseta os campos após o modal ser fechado
    $('#modalNovoUsuario').on('hidden.bs.modal', function () {
        const $form = $('#form_usuario');
        $('#modalNovoUsuario').data('id', '');
        $('#modalNovoUsuarioLabel').text('Novo Usuário');
        $('#email').prop('disabled', false);
        $('#btnCadastrarUsuario').html('<span class="material-symbols-rounded">person_add</span>Cadastrar Usuário');
        $form[0].reset(); // Limpa os campos do formulário
        $('#nome_completo').removeClass('is-valid is-invalid');
        $('#email').removeClass('is-valid is-invalid');
        $('#status').removeClass('is-valid is-invalid');
        $('#permissao').removeClass('is-valid is-invalid');

        // Limpa mensagens de erro/sucesso
        const $formMessageContainer = $('#form-message-container');
        $formMessageContainer.removeClass('message-error message-success');
        $formMessageContainer.find('ul').empty();
        $formMessageContainer.hide(); // Ou .slideUp() para manter o efeito
    });


    $(document).ready(function() {
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
                    maxlength: 255 
                },
                permissao: {
                    required: true,
                },
                status: {
                    required: true,
                },
            },
            messages: {
                nome_completo: { 
                    required: "O nome é obrigatório.", 
                    minlength: "O nome informado é muito curto.",
                    maxlength: "O nome informado é muito longo",
                }, 
                email: { 
                    required: "O e-mail é obrigatório.",
                    email: "Por favor, insira um e-mail de acesso válido.",
                    maxlength: "O e-mail informado é muito longo.",
                },
                permissao: { 
                    required: "A Permissão do usuário deve ser selecionada.",
                },
                status: { 
                    required: "O Status do usuário deve ser selecionado.",
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

                var idUsuario = $('#modalNovoUsuario').data('id');
                var actionUrl = idUsuario ? "<?= base_url('painel/orgao/usuario/editar-usuario/') ?>" + idUsuario 
                                    : "<?= base_url('painel/orgao/usuario/cadastrar-usuario') ?>";

                let dadosParaEnviar = {};
                dadosParaEnviar = {
                    nome_completo: $('#nome_completo').val(),
                    permissao: $('#permissao').val(),
                    status: $('#status').val(),
                };

                if (!idUsuario) {
                    dadosParaEnviar.email = $("#email").val();
                }

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

                            if (idUsuario) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso',
                                    text: response.message || 'Os dados do usuário foram atualizados com sucesso.',
                                    confirmButtonColor: '#198754', // verde Bootstrap
                                    timer: 5000,
                                });
                                $submitButton.prop('disabled', false);
                                $('#modalNovoUsuario').modal('hide');
                                table.ajax.reload(null, false);
                                
                            } else {
                                // Copia a senha do novo usuário para o clipboard
                                var tempPassword = response.data;
                                copiarParaAreaDeTransferencia(tempPassword);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso',
                                    html: response.message || `O Usuário foi cadastrado com sucesso!<br><br>
                                    A senha do primeiro acesso do usuário foi copiada para a área de transferência (Ctrl + C).<br>
                                    Guarde a senha em um local seguro. Ela deverá ser fornecida ao usuário para efetuar seu primeiro acesso na plataforma.<br><br>
                                    <b>Senha do primeiro acesso:</b> "${tempPassword}"`,
                                    confirmButtonColor: '#198754', // verde Bootstrap
                                });
                                $submitButton.prop('disabled', false);
                                $('#modalNovoUsuario').modal('hide');
                                table.ajax.reload(null, false);
                            }
                        } else { // Erros do servidor
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: response.message || "Ocorreu um erro ao atualizar os dados do usuário.",
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
                            text: 'Não foi possível atualizar os dados do usuário. Tente novamente.',
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