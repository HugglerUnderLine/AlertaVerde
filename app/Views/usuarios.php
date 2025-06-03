<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel da Agência</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/google-fonts/font.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/material-symbols/material-symbols-rounded.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/css/dataTables.bootstrap5.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/css/buttons.bootstrap5.min.css') ?>">

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

        /* DataTables processing message styling */
        div.dt-processing {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 1055 !important;
            background-color: rgba(255, 255, 255, 0.85) !important;
            padding: 1rem 2rem !important;
            border-radius: 0.5rem;
            text-align: center !important;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-left: 0 !important;
            margin-top: 0 !important;
            width: auto !important; /* let the size flow according to the content */
        }

        /* DataTables pagination */
        .page-item.active .page-link {
            color: #FFF !important;
            background-color: #198754 !important;
            border-color: #198754 !important;
        }

        .page-link {
            color: #198754 !important;
        }

        /* Datatables row details style */
        td.details-control svg {
            fill: darkslategray;
            opacity: .7;
            transition: transform .3s linear;
            cursor: pointer;
        }

        tr.shown td.details-control svg{
            transform: rotate(180deg);
            transition: transform .3s linear;
        }

        div #moreDetails {
            display: none;
        }

        tbody td.no-padding {
            padding: 0;
        }
    </style>
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
                    <span class="material-symbols-rounded">shield_person</span>
                    <h3 class="h6 text-white m-0"><?= session('nome_completo') ?></h3> 
                </div>
                <nav class="mt-4">
                    <ul class="bg-denuncias nav flex-column gap-3">
                        <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                            <span class="material-symbols-rounded">assignment</span>
                            <a class="nav-link text-white text-start" href="<?=  base_url('/painel/orgao') ?>">Lista de Denuncias</a>
                        </li>
                        <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                            <span class="material-symbols-rounded">account_circle</span>
                            <a class="nav-link text-white" href="<?= base_url('/usuario/perfil/' . session('uuid')) ?>">Perfil</a>
                        </li>
                        <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                            <span class="material-symbols-rounded">group_add</span>
                            <a class="nav-link text-white" href="<?= base_url('/usuarios')?>">Usuários</a>
                        </li>
                        <li class="nav-item d-flex gap-2 align-items-center text-start btn text-white highlight-on-hover">
                            <span class="material-symbols-rounded">logout</span>
                            <a class="nav-link text-white" href="<?= base_url('logout') ?>">Sair</a>
                        </li>
                    </ul>
                </nav>
            </aside>
        </div>

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
                                    <h3 class="fw-bold mt-3">Dados do Usuário</h3>
                                    <p class="fs-6 mt-2" style="color: var(--cor-8);">Informe os dados do novo usuário.</p>
                                </div>

                                <form id="formNovoUsuarioModal" class="row gap-3">
                                    <?= csrf_field() ?>
                                    <div class="form-group col-12">
                                        <label for="nomeUsuarioModal" class="form-label fw-bold mt-2">Nome Completo</label>
                                        <input type="text" class="form-control form-control-sm" id="nomeUsuarioModal" name="nome" placeholder="Ex: João da Silva" required>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="emailUsuarioModal" class="form-label fw-bold ">Email</label>
                                        <input type="email" class="form-control form-control-sm" id="emailUsuarioModal" name="email" placeholder="Ex: email.exemplo@dominio.com" required>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="permissaoUsuarioModal" class="form-label fw-bold ">Permissão</label>
                                        <select class="form-select" id="permissaoUsuarioModal" name="permissao">
                                            <option value="1">Gestor do Órgão</option>
                                            <option value="2" selected>Usuário</option>
                                            <?php if(session('is_admin') === true) : ?>
                                            <option value="3" selected>Administrador</option>
                                            <?php endif ?>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center mt-4">
                                        <button type="submit" class="btn-cadastrar btn btn-success w-75 d-flex justify-content-center align-items-center gap-2">
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
                                <button type="button" data-valor="" class="btn btn-filtro-status btn-outline-primary active">Todos</button>
                                <button type="button" data-valor="1" class="btn btn-filtro-status btn-outline-success">Ativos</button>
                                <button type="button" data-valor="0" class="btn btn-filtro-status btn-outline-secondary">Inativos</button>
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
                                    <span class="material-symbols-rounded align-middle fs-6">filter_alt_off</span> Limpar
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
            </section>
        </main>
    </div>

  

<script src="<?= base_url("assets/JQuery-3.7.0/jquery-3.7.0.min.js") ?>"></script>
<script src="<?= base_url("assets/jquery-validation-1.19.5/jquery.validate.min.js") ?>"></script>
<script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url("assets/jquery-validation-1.19.5/additional-methods.min.js") ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/buttons.bootstrap5.min.js') ?>"></script>
<script type="text/javascript">

    DataTable.Buttons.defaults.dom.button.className = 'btn'; //Sobrescreve a estilização padrão dos botões no DataTables
    
    var url = '<?= base_url("/usuarios/list") ?>';

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
                    } else if (row['permissao'] == 'admin') {
                        return '<span class="material-symbols-rounded align-bottom text-primary btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Administrador">security</span>';
                    }
                },
            },
            { 
                data: 'usuarioAtivo', 
                render: function (data, type, row) {
                    if(row['usuarioAtivo'] == '1') {
                        return '<span class="material-symbols-rounded align-bottom text-primary btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ativo">check_circle</span>';
                    } else if (row['usuarioAtivo'] == '0') {
                        return '<span class="material-symbols-rounded align-bottom text-secondary btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Inativo">error</span>';
                    }
                },
            },
            { data: 'criadoEm' },
            {
                data: 'acoes', searchable: false, orderable: false, className: 'dt-body-center dt-head-center',
                render: function (data, type, row) {
                    return '<a class="btn btn-sm btn-outline-primary p-0 editar-usuario" data-id="' + row['usuarioID'] + '"><span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar">edit</span></a> '
                         + '<a href="<?= base_url("usuario/log") ?>' + row['uuid'] + '" class="btn btn-sm btn-outline-secondary p-0 historico-usuario" id="logUsuario"><span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Histórico de Atividade">history</span></a>';
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
        // Remove 'active' e classes de cor de todos os botões de status
        $('.btn-filtro-status').removeClass('active btn-primary btn-success btn-secondary');
        // Adiciona classe de contorno padrão de volta a todos (exceto o clicado)
        $('.btn-filtro-status').not(this).addClass('btn-outline-primary');
        
        // Ativa o botão clicado e aplica sua cor específica
        $(this).addClass('active');
        const statusValor = $(this).data('valor').toString();
        filtroAtivoValor = statusValor;

        if (statusValor === '1') {
            $(this).removeClass('btn-outline-primary').addClass('btn-success');
        } else if (statusValor === '0') {
            $(this).removeClass('btn-outline-primary').addClass('btn-secondary');
        } else { // "Todos"
             $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        }
        table.draw(); 
    });
    $('#btnFiltroTodos').removeClass('btn-outline-primary').addClass('btn-primary active');


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
        $('.btn-filtro-status').removeClass('active btn-primary btn-success btn-secondary').addClass('btn-outline-primary');
        $('#btnFiltroTodos').removeClass('btn-outline-primary').addClass('btn-primary active');
        
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

</script>


</body>
</html>