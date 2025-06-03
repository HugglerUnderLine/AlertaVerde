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
            background-color: #012057 !important;
            border-color: #012057 !important;
        }

        .page-link {
            color: #012057 !important;
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
                <div class="mt-4">
                    <h2>Painel da Agência</h2>
                    <p class="fs-6 fw-normal mt-2" style="color: var(--cor-7);">Monitore e gerencie os relatos dos cidadãos.</p>
                </div>
            </section>

            <section class="rounded-2 text-dark mt-5 px-4 pt-2 pb-4 d-flex gap-3">
                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Total de Denúncias</h5>
                        <p class="card-text">1,248</p>
                        <p class="small">📍 +12% em relação ao mês passado</p>
                    </div>
                </div>

                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Pendentes</h5>
                        <p class="card-text">1,248</p>
                        <p class="small">📍 +12% em relação ao mês passado</p>
                    </div>
                </div>

                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Em Progresso</h5>
                        <p class="card-text">1,248</p>
                        <p class="small">📍 +12% em relação ao mês passado</p>
                    </div>
                </div>

                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Resolvidas</h5>
                        <p class="card-text">1,248</p>
                        <p class="small">📍 +12% em relação ao mês passado</p>
                    </div>
                </div>
            </section>

            <section class="rounded-2 text-dark p-4 mt-2 px-4 pt-2 pb-4 d-flex justify-content-start gap-3 aligm-items-center">
                <div class=" card bg-secundaria position-relative" style="padding: 100px;">
                    <div class="card-body">
                        <h5 class="card-title">Status da Denuncia</h5>
                        <p class="card-text">Aqui tera um grafico</p>
                        <p class="small">📍 +12% em relação ao mês passado</p>
                    </div>
                </div>
                
                <div class="card bg-secundaria position-relative" style="padding: 100px;"">
                    <div class="card-body">
                        <h5 class="card-title">Categoria das Denuncias</h5>
                        <p class="card-text">Aqui tera um grafico</p>
                        <p class="small">📍 +12% em relação ao mês passado</p>
                    </div>
                </div>
            </section>

            <section class="rounded-2 text-dark p-4 mt-2 px-4 pt-2 pb-4">
                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Localização</h5>
                        <p class="card-text">Aqui ficara um mapa </p>
                        <p class="small">📍 +12% em relação ao mês passado</p>
                    </div>
                </div>
            </section>

            <section class="rounded-2 mt-2 px-4 pt-2 pb-4">
                <div class="card bg-secundaria position-relative p-4 mt-2 px-4 pt-2 pb-4">
                    <div class="d-flex text-dark justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold">Denúncias recentes</h4>
                    </div>
                    <div class="row mb-3 g-2 align-items-center"> 
                        <div class="col-md-auto">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Filtros de Status">
                                <button type="button" id="btnFiltroTodos" data-status="" class="btn btn-filtro-status btn-outline-secondary me-1 active">Todos</button>
                                <button type="button" data-status="Pendente" class="btn btn-filtro-status btn-outline-warning me-1">Pendente</button>
                                <button type="button" data-status="Em progresso" class="btn btn-filtro-status btn-outline-primary me-1">Em progresso</button>
                                <button type="button" data-status="Resolvido" class="btn btn-filtro-status btn-outline-success">Resolvido</button>
                            </div>
                        </div>

                        <div class="col-md d-flex justify-content-md-end align-items-center flex-wrap gap-2">
                            <select id="selectTipoBuscaTexto" name="selectTipoBuscaTexto" class="form-select form-select-md" style="width: auto;">
                                <option value="0" selected>Filtrar por Título</option>
                                <option value="1">Filtrar por Categoria</option>
                            </select>
                            <input type="text" class="form-control" placeholder="🔍 Buscar por..." style="max-width: 250px;" id="filtroBusca" name="filtroBusca">
                            <button class="btn btn-warning">Filtrar</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="listar_denuncias" class="table table-hover align-middle rounded-2" style="width:100%">
                            <thead class="bg-success bg-opacity-10">
                                <tr>
                                    <th scope="col" class="align-middle col"><span class="collapsed material-symbols-rounded p-0 m-0 btn text-start" id="toggle_detalhes">keyboard_double_arrow_down</span></th>
                                    <th>Título</th>
                                    <th>Categoria</th>
                                    <th>Status</th>
                                    <th>Reportado por</th>
                                    <!-- Daqui adiante, são os detalhes que podem ser exibidos na expansão da linha -->
                                    <th>id_denuncia</th> <!-- Apenas para validação interna. Não é exibido no datatables. -->
                                    <th>id_usuario</th> <!-- Apenas para validação interna. Não é exibido no datatables. -->
                                    <th>id_tipo</th> <!-- Apenas para validação interna. Não é exibido no datatables. -->
                                    <th>detalhes</th> <!-- Apenas para validação interna. Não é exibido no datatables. -->
                                    <th>Logradouro</th>
                                    <th>Número</th>
                                    <th>Bairro</th>
                                    <th>CEP</th>
                                    <th>Ponto de Referência</th>
                                    <th>Órgão Responsável</th>
                                    <th>Data da Denúncia</th>
                                    <th>Data de atribuição</th>
                                    <th>Concluída em</th>
                                    <!-- Icone para editar / atualizar os campos da denuncia -->
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
    
    function isValid(value) {
        // Verifica se o valor atual é válido (não nulo, não vazio e diferente de um array vazio)
        return value != null && value !== '' && value !== '[]';
    }

    function format(d) {
        let s = '<div class="row text-secondary bg-body border mx-4 border" id="mais_detalhes">';

        s += '<div class="d-flex">';
        s += '<div class="col-6">';

        // Informações gerais acerca da denúncia
        let col_name = 'Detalhes da Denúncia:';
        s += '<p class="m-1 pt-2"><strong>' + col_name + '</strong></p>';

        var generalInfo = false;

        if (isValid(d['detalhes'])) {
            s += '<p class="m-1 pt-1"><strong>Detalhamento:</strong> ' 
            + String(d['detalhes']) 
            + '</p>';

            generalInfo = true;
        }
        if (isValid(d['logradouro']) && isValid(d['numero'])) {
            s += '<p class="m-1 pt-1"><strong>Endereço:</strong> ' 
            + String(d['logradouro']) + ", "
            + String(d['numero'])
            + '</p>';

            generalInfo = true;
        }
        if (isValid(d['bairro'])) {
            s += '<p class="m-1 pt-1"><strong>Bairro:</strong> ' 
            + String(d['bairro'])
            + '</p>';
            
            generalInfo = true;
        }
        if (isValid(d['CEP'])) {
            s += '<p class="m-1 pt-1"><strong>CEP:</strong> ' 
            + String(d['CEP'])
            + '</p>';
            
            generalInfo = true;
        }
        if (isValid(d['pontoReferencia'])) {
            s += '<p class="m-1 pt-1"><strong>Ponto de Referência:</strong> ' 
            + String(d['pontoReferencia'])
            + '</p>';
            
            generalInfo = true;
        }

        if (!generalInfo) {
            s += '<p class="m-1 pt-1 text-muted">Sem dados disponíveis :(</p>';
        }

        s += '</div>'; // Fim General Info

        // Denuncia Info
        s += '<div class="col-6">';
        s += '<p class="m-1 pt-2"><strong>Dados da Denúncia:</strong></p>';

        denunciaInfo = false;

        if (isValid(d['dataDenuncia'])) {
            s += `<p class="m-1 pt-1"><strong>Data da Denúncia:</strong> ${formatFPS(d['dataDenuncia'])}</p>`;

            denunciaInfo = true;
        }
        if (isValid(d['dataAtribuicao'])) {
            s += `<p class="m-1 pt-1"><strong>Data da Atribuição:</strong> ${formatTraffic(parseFloat(d['dataAtribuicao']))}</p>`;

            denunciaInfo = true;
        }
        if (isValid(d['dataConclusao'])) {
            s += `<p class="m-1 pt-1"><strong>Concluída Em:</strong> ${formatTraffic(parseFloat(d['dataConclusao']))}</p>`;

            denunciaInfo = true;
        }


        if (!denunciaInfo) {
            s += '<p class="m-1 pt-1 text-muted">Sem dados disponíveis :(</p>';
        }

        s += '</div>'; // Fim Denuncia Info 
        s += '</div>'; // Fim linha atual
        s += '</div>'; // Fim main container

        return s;
    }

    var url = '<?= base_url("/painel/orgao/list") ?>';

    var table = new DataTable('#listar_denuncias', {
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: "POST",
            data: function(d) {
                d.planFilter = $('#planFilter').val();
                d.deviceFilter = $('#deviceFilter').val();
            },
        },
        info: true,
        responsive: true,
        pageLength: 10,
        order: [[15, 'desc']],
        language: { url: '<?= base_url('assets/datatables-pt-BR.json') ?>', decimal: ',', thousands: '.' },
        layout: {
            topStart: {},
            topEnd: 'pageLength',
        },
        columnDefs: [{ targets: "_all", orderSequence: ['asc', 'desc'], className: "dt-body-left dt-head-left" }],
        columns: [
            {
                data: '',
                className: 'details-control text-start',
                orderable: false,
                defaultContent: '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480-362q-8 0-15-2.5t-13-8.5L268-557q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-373q-6 6-13 8.5t-15 2.5Z"/></svg>'
            },
            { data: 'tituloDenuncia' },
            { data: 'categoria' },
            { 
                data: 'status', 
                render: function (data, type, row) {
                    if(row['status'] == 'Pendente') {
                        return '<span class="badge rounded-pill bg-warning text-warning bg-opacity-25 text-bg-warning"> &middot; Pendente</span>';
                    } else if (row['status'] == 'Em Progresso') {
                        return '<span class="badge rounded-pill bg-primary text-primary bg-opacity-25 text-bg-primary"> &middot; Em progresso</span>';
                    } else if (row['status'] == 'Resolvido') {
                        return '<span class="badge rounded-pill bg-success text-success bg-opacity-25 text-bg-success"> &middot; Resolvido</span>';
                    }
                },
            },
            { data: 'nomeDenunciante', orderable: false },
            { data: 'denunciaID', visible: false, orderable: false, searchable: false },
            { data: 'usuarioID', visible: false, orderable: false, searchable: false },
            { data: 'tipoDenunciaID', visible: false, orderable: false, searchable: false },
            { data: 'detalhes', visible: false, orderable: false, searchable: false },
            { data: 'logradouro', visible: false, orderable: false, searchable: false },
            { data: 'numero', visible: false, orderable: false, searchable: false },
            { data: 'bairro', visible: false, orderable: false, searchable: false },
            { data: 'CEP', visible: false, orderable: false, searchable: false },
            { data: 'pontoReferencia', visible: false, orderable: false, searchable: false },
            { data: 'orgaoResponsavel', visible: false, orderable: false, searchable: false },
            { data: 'dataDenuncia' },
            { data: 'dataAtribuicao', visible: false, orderable: false, searchable: false },
            { data: 'dataConclusao', visible: false, orderable: false, searchable: false },
            {
                data: 'acoes', searchable: false, orderable: false, className: 'dt-body-center dt-head-center',
                render: function (data, type, row) {
                    return '<a class="btn btn-sm btn-outline-primary p-0 editar-status-denuncia" data-id="' + row['denunciaID'] + '"><span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alterar Status">edit</span></a> '
                         + '<a href="<?= base_url("denuncia/") ?>' + row['denunciaID'] + '/visualizar" class="btn btn-sm btn-outline-secondary p-0 visualizar-denuncia" id="visualizarDenuncia"><span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualizar Denúncia">visibility</span></a>';
                },
            },
        ],
    } );

    // Lógica para os botões de filtro de status
    $('.btn-filtro-status').on('click', function() {
        $('.btn-filtro-status').removeClass('active btn-secondary').addClass('btn-outline-secondary'); // Reseta todos
        $(this).removeClass('btn-outline-secondary').addClass('active btn-secondary'); // Ativa o clicado
        
        // Pega o status do atributo data-status. Se for "Todos", o valor é "" (string vazia)
        filtroStatusAtual = $(this).data('status');
        table.draw(); // Redesenha a tabela, enviando o novo filtro_status para o servidor
    });

    // Lógica para o filtro de texto e seleção de coluna
    $('#inputBuscaPorTexto, #selectTipoBuscaTexto').on('keyup change', function() {
        filtroColunaTextoSelecionada = $('#selectTipoBuscaTexto').val();
        filtroValorTextoAtual = $('#inputBuscaPorTexto').val();
        table.draw(); // Redesenha a tabela
    });

    // Expands one row at a time
    table.on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if( row.child.isShown() ) {
            tr.removeClass('shown').addClass('manual-toggle');
            $('#mais_detalhes', row.child()).slideUp( function () {
                row.child.hide();
            });
        }
        else {
            row.child( format(row.data()), 'no-padding' ).show();
            tr.addClass('shown').addClass('manual-toggle');
            $('#mais_detalhes', row.child()).slideDown();
        }
    });

    // Expand all rows simultaneously
    $('#toggle_detalhes').on('click', function() {
        var toggleText = $('#toggle_detalhes').text();

        if(toggleText === 'keyboard_double_arrow_down') {
            $('#toggle_detalhes').text('keyboard_double_arrow_up');

            table.rows(':not(.parent)').nodes().to$().find('td:first-child').each(function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if(!row.child.isShown()) {
                    $(this).trigger('click');
                }
            });
        }
        else {
            $('#toggle_detalhes').text('keyboard_double_arrow_down');

            table.rows(':not(.parent)').nodes().to$().find('td:first-child').each(function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if(row.child.isShown()) {
                    $(this).trigger('click');
                }
            });
        }
    });

    // Bootstrap Tooltips
    $(document).ready(function () {
        const tooltips = document.querySelectorAll('.tt')
        tooltips.forEach(t => {
            new bootstrap.Tooltip(t)
        })
    });

    // Carrega todos os tooltips do bootstrap na inicialização
    table.on('draw.dt', function () {
        $('.tooltip').remove(); // Evita duplicatas de tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    $('#filtrar').on('click', function(event) {
        event.preventDefault();
        table.ajax.reload();
    });

    // Limpa os campos do formulário
    $('#limpar').on('click', function(){
        $('#buscar_denuncias')[0].reset();
        table.ajax.reload(); // Recarrega a tabela
    });

</script>


</body>
</html>