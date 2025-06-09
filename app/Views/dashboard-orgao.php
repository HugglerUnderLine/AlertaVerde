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

        .grafico-container {
            width: 100%;
            max-width: 500px;
            height: 300px;
            margin: auto;
        }

        #previewImagensModal img,
        #previewVideoModal video {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
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
                            <span class="material-symbols-rounded">analytics</span>
                            <a class="nav-link text-white text-start" href="<?=  base_url('/painel/orgao') ?>">Painel da Agência</a>
                        </li>
                        <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                            <span class="material-symbols-rounded">assignment</span>
                            <a class="nav-link text-white text-start" href="<?=  base_url('/painel/orgao/denuncias') ?>">Lista de Denuncias</a>
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
                        <p class="card-text">
                            <?= esc($stats['total']['atual'] ?? '0') ?>
                        </p>
                        <p class="small">
                            <?= esc($stats['total']['texto_variacao'] ?? 'N/A') ?>
                        </p>
                    </div>
                </div>

                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Pendentes</h5>
                        <p class="card-text">
                            <?= esc($stats['pendente']['atual'] ?? '0') ?>
                        </p>
                        <p class="small">
                            <?= esc($stats['pendente']['texto_variacao'] ?? 'N/A') ?>
                        </p>
                    </div>
                </div>

                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Em Progresso</h5>
                        <p class="card-text">
                            <?= esc($stats['em_progresso']['atual'] ?? '0') ?>
                        </p>
                        <p class="small">
                            <?= esc($stats['em_progresso']['texto_variacao'] ?? 'N/A') ?>
                        </p>
                    </div>
                </div>

                <div class="card bg-secundaria position-relative">
                    <div class="card-body">
                        <h5 class="card-title">Resolvidas</h5>
                        <p class="card-text">
                            <?= esc($stats['resolvido']['atual'] ?? '0') ?>
                        </p>
                        <p class="small">
                            <?= esc($stats['resolvido']['texto_variacao'] ?? 'N/A') ?>
                        </p>
                    </div>
                </div>
            </section>

            <section class="rounded-2 text-dark p-4 mt-2 px-4 pt-2 pb-4 d-flex justify-content-start gap-3 aligm-items-center">
                <div class="card bg-secundaria position-relative" style="padding: 40px; width: 50%;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Quantidade de Denúncias por Status</h5>
                        <div class="grafico-container">
                            <canvas id="graficoStatus"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card bg-secundaria position-relative" style="padding: 40px; width: 50%;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Quantidade de Denúncias por Categoria</h5>
                        <div class="grafico-container">
                            <canvas id="graficoCategoria"></canvas>
                        </div>
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

                    <form id="busca_denuncia_form" class="mb-4" method="post">
                        <div class="row mb-3 g-2 align-items-center" id="filtrosContainer">
                            <div class="col-md-auto">
                                <div class="btn-group" role="group" aria-label="Filtros de Status">
                                    <button type="button" id="btnFiltroTodos" data-valor="" class="btn btn-filtro-status btn-outline-secondary active me-1">Todas</button>
                                    <button type="button" id="btnFiltroPendente" data-valor="Pendente" class="btn btn-filtro-status btn-outline-warning me-1">Pendentes</button>
                                    <button type="button" id="btnFiltroEmProgresso" data-valor="Em Progresso" class="btn btn-filtro-status btn-outline-primary me-1">Em Progresso</button>
                                    <button type="button" id="btnFiltroResolvido" data-valor="Resolvido" class="btn btn-filtro-status btn-outline-success">Resolvidas</button>
                                </div>
                            </div>
                        
                            <div class="col-md d-flex justify-content-md-end align-items-end gap-2 flex-wrap">
                                <div>
                                    <select id="selectTipoBuscaTexto" name="selectTipoBuscaTexto" class="form-select" style="width: auto;">
                                        <option value="titulo" selected>Filtrar por Título</option>
                                        <option value="categoria">Filtrar por Categoria</option>
                                    </select>
                                </div>
                                <div>
                                    <input type="text" class="form-control" placeholder="🔍 Buscar por..." style="max-width: 250px;" id="filtroBuscaValor" name="filtroBuscaValor">
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
                                                        <label for="titulo_denuncia" class="form-label fw-bold mt-4">Titulo da Denuncia:</label>
                                                        <input type="text" class="form-control form-control-sm" id="titulo_denuncia" name="titulo_denuncia" readonly>
                                                    </div>
                                                    <div class="form-group col-12 ">
                                                        <label for="categoria_denuncia" class="form-label fw-bold ">Categoria: </label>
                                                        <select class="form-select form-select-sm" id="categoria_denuncia" name="categoria_denuncia" readonly disabled>
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
                                                        <label for="descricao_denuncia" class="form-label fw-bold ">Descrição:</label>
                                                        <textarea class="form-control form-control-sm" id="descricao_denuncia" name="descricao_denuncia" rows="4" readonly></textarea>
                                                    </div>
                                                    
                                                    <h4 class="fw-bold mt-3">Localização da Denúncia:</h4>
                                                    <div class="form-group col-md-10">
                                                        <label for="logradouro_denuncia" class="form-label fw-bold">Logradouro:</label>
                                                        <input type="text" class="form-control form-control-sm" id="logradouro_denuncia" name="logradouro_denuncia" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="numero_denuncia" class="form-label fw-bold">Número:</label>
                                                        <input type="text" class="form-control form-control-sm" id="numero_denuncia" name="numero_denuncia" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="bairro_denuncia" class="form-label fw-bold">Bairro:</label>
                                                        <input type="text" class="form-control form-control-sm" id="bairro_denuncia" name="bairro_denuncia" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="cep_denuncia" class="form-label fw-bold">CEP:</label>
                                                        <input type="text" class="form-control form-control-sm" id="cep_denuncia" name="cep_denuncia" readonly>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label for="ponto_referencia" class="form-label fw-bold">Ponto de Referência:</label>
                                                        <input type="text" class="form-control form-control-sm" id="ponto_referencia" name="ponto_referencia" readonly>
                                                    </div>

                                                    <div class="form-group col-12">
                                                        <label class="form-label fw-bold">Mídias:</label>
                                                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                                                            <div class="bg-white rounded-3 p-3 w-100" style="min-height: 180px;">
                                                                <input type="file" class="form-control form-control-sm" id="imagens_denuncia_input" name="imagens_denuncia[]" accept="image/*" style="display: none;" multiple>
                                                                <div id="previewImagensModal" class="d-flex flex-wrap gap-2 justify-content-center align-items-center"></div>
                                                            </div>
                                                            <div class="bg-white rounded-3 p-3 w-100" style="min-height: 180px;">
                                                                <input type="file" class="form-control form-control-sm" id="video_denuncia_input" name="video_denuncia" accept="video/*" style="display: none;">
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

                    <div class="table-responsive">
                        <table id="listar_denuncias" class="table table-hover align-middle rounded-2" style="width:100%">
                            <thead class="bg-success bg-opacity-10">
                                <tr>
                                    <th scope="col" class="align-middle col"><span class="collapsed material-symbols-rounded p-0 m-0 btn text-start" id="toggle_detalhes">keyboard_double_arrow_down</span></th>
                                    <th scope="col">Título</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col" class="col-2">Status</th>
                                    <th scope="col">Reportado por</th>
                                    <!-- Daqui adiante, são os detalhes que podem ser exibidos na expansão da linha -->
                                    <th scope="col">id_denuncia</th> <!-- Apenas para validação interna. Não é exibido no datatables. -->
                                    <th scope="col">id_usuario</th> <!-- Apenas para validação interna. Não é exibido no datatables. -->
                                    <th scope="col">id_tipo</th> <!-- Apenas para validação interna. Não é exibido no datatables. -->
                                    <th scope="col">detalhes</th> <!-- Apenas para validação interna. Não é exibido no datatables. -->
                                    <th scope="col">Logradouro</th>
                                    <th scope="col">Número</th>
                                    <th scope="col">Bairro</th>
                                    <th scope="col">CEP</th>
                                    <th scope="col">Ponto de Referência</th>
                                    <th scope="col">Órgão Responsável</th>
                                    <th scope="col">Data da Denúncia</th>
                                    <th scope="col">Data de atribuição</th>
                                    <th scope="col">Concluída em</th>
                                    <!-- Icone para editar / atualizar os campos da denuncia -->
                                    <th scope="col">Ações</th>
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
<script src="<?= base_url('assets/sweetalert2/sweet.min.js') ?>"></script>
<script src="<?= base_url('assets/chart.js/chart.min.js') ?>"></script>
<script type="text/javascript">
    DataTable.Buttons.defaults.dom.button.className = 'btn'; //Sobrescreve a estilização padrão dos botões no DataTables
    
    // Variáveis para armazenar os valores dos filtros
    let filtroStatusValor = ""; // Para a opção Todos, recebe uma string vazia por padrão
    let filtroTipoBuscaAtual = "titulo";
    let filtroBuscaValorAtual = "";

    function isValid(value) {
        // Verifica se o valor atual é válido (não nulo, não vazio e diferente de um array vazio)
        return value != null && value !== '' && value !== '[]';
    }

    function format(d) {
        let s = '<div class="row text-secondary bg-secundaria border mx-4 border" id="mais_detalhes">';

        s += '<div class="d-flex">';
        s += '<div class="col-6">';

        // Informações gerais acerca da denúncia
        let col_name = 'Detalhes da Denúncia:';
        s += '<p class="m-1 pt-2 small"><strong>' + col_name + '</strong></p>';

        var generalInfo = false;

        if (isValid(d['detalhes'])) {
            s += '<p class="m-1 pt-1 small"><strong>Detalhamento:</strong> ' 
            + String(d['detalhes']) 
            + '</p>';

            generalInfo = true;
        }
        if (isValid(d['logradouro']) && isValid(d['numero'])) {
            s += '<p class="m-1 pt-1 small"><strong>Endereço:</strong> ' 
            + String(d['logradouro']) + ", "
            + String(d['numero'])
            + '</p>';

            generalInfo = true;
        }
        if (isValid(d['bairro'])) {
            s += '<p class="m-1 pt-1 small"><strong>Bairro:</strong> ' 
            + String(d['bairro'])
            + '</p>';
            
            generalInfo = true;
        }
        if (isValid(d['CEP'])) {
            s += '<p class="m-1 pt-1 small"><strong>CEP:</strong> ' 
            + String(d['CEP'])
            + '</p>';
            
            generalInfo = true;
        }
        if (isValid(d['pontoReferencia'])) {
            s += '<p class="m-1 pt-1 small"><strong>Ponto de Referência:</strong> ' 
            + String(d['pontoReferencia'])
            + '</p>';
            
            generalInfo = true;
        }

        if (!generalInfo) {
            s += '<p class="m-1 pt-1 text-muted small">Sem dados disponíveis :(</p>';
        }

        s += '</div>'; // Fim General Info

        // Denuncia Info
        s += '<div class="col-6">';
        s += '<p class="m-1 pt-2 small"><strong>Dados da Denúncia:</strong></p>';

        denunciaInfo = false;

        if (isValid(d['dataDenuncia'])) {
            s += `<p class="m-1 pt-1 small"><strong>Data da Denúncia:</strong> ${d['dataDenuncia']}</p>`;

            denunciaInfo = true;
        }
        if (isValid(d['dataAtribuicao'])) {
            s += `<p class="m-1 pt-1 small"><strong>Data da Atribuição:</strong> ${d['dataAtribuicao']}</p>`;

            denunciaInfo = true;
        }
        if (isValid(d['dataConclusao'])) {
            s += `<p class="m-1 pt-1 small"><strong>Concluída Em:</strong> ${d['dataConclusao']}</p>`;

            denunciaInfo = true;
        }


        if (!denunciaInfo) {
            s += '<p class="m-1 pt-1 text-muted small">Sem dados disponíveis :(</p>';
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
                d.status = filtroStatusValor;
                d.coluna_busca = filtroTipoBuscaAtual;
                d.valor_busca = filtroBuscaValorAtual;
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
                    return '<a class="btn btn-sm btn-outline-primary p-0 editar-status-denuncia" data-id="' + row['denunciaID'] + '">' +
                    '<span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Alterar Status da Denúncia">edit</span></a> '
                    + '<a href="#" class="btn btn-sm btn-outline-secondary p-0 visualizar-denuncia" ' +
                        'data-id="' + row['denunciaID'] + '" ' +
                        'data-titulo="' + row['tituloDenuncia'] + '" ' +
                        'data-categoria="' + row['tipoDenunciaID'] + '" ' +
                        'data-detalhes="' + row['detalhes'] + '" ' +
                        'data-logradouro="' + row['logradouro'] + '" ' +
                        'data-numero="' + row['numero'] + '" ' +
                        'data-bairro="' + row['bairro'] + '" ' +
                        'data-cep="' + row['CEP'] + '" ' +
                        'data-referencia="' + row['pontoReferencia'] + '" ' +
                        'data-midias="' + JSON.stringify(row['midias'] || []) + '" ' +
                        'data-bs-toggle="modal" data-bs-target="#modalDenuncia">' +
                        '<span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" title="Visualizar Denúncia">visibility</span>' +
                        '</a>';
                },
            },
        ],
    } );

    $('#listar_denuncias tbody').on('click', '.editar-status-denuncia', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var rowData = row.data();

        var currentStatus = rowData.status;
        var denunciaID = rowData.denunciaID;

        var selectHTML = `
            <div class="d-flex flex-column gap-1">
                <select class="form-select form-select-sm status-dropdown" data-id="${denunciaID}">
                    <option value="Pendente" ${currentStatus === 'Pendente' ? 'selected' : ''}>Pendente</option>
                    <option value="Em Progresso" ${currentStatus === 'Em Progresso' ? 'selected' : ''}>Em Progresso</option>
                    <option value="Resolvido" ${currentStatus === 'Resolvido' ? 'selected' : ''}>Resolvido</option>
                </select>
                <div class="d-flex justify-content-between gap-2">
                    <button class="btn btn-sm btn-danger cancelar-acao-btn" data-id="${denunciaID}">Cancelar</button>
                    <button class="btn btn-sm btn-success salvar-status-btn" data-id="${denunciaID}">Salvar</button>
                </div>
            </div>
        `;

        // Coluna 3 é a do status
        $(tr).find('td').eq(3).html(selectHTML);
    });

    $('#listar_denuncias tbody').on('click', '.salvar-status-btn', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var rowData = row.data();
        var denunciaID = $(this).data('id');
        var novoStatus = tr.find('.status-dropdown').val();
        var statusAtual = rowData.status;

        // Se não houve alteração, volta para o badge e não faz requisição
        if (novoStatus === statusAtual) {
            var statusBadge = '';
            if (statusAtual === 'Pendente') {
                statusBadge = '<span class="badge rounded-pill bg-warning text-warning bg-opacity-25 text-bg-warning"> &middot; Pendente</span>';
            } else if (statusAtual === 'Em Progresso') {
                statusBadge = '<span class="badge rounded-pill bg-primary text-primary bg-opacity-25 text-bg-primary"> &middot; Em progresso</span>';
            } else if (statusAtual === 'Resolvido') {
                statusBadge = '<span class="badge rounded-pill bg-success text-success bg-opacity-25 text-bg-success"> &middot; Resolvido</span>';
            }
            $(tr).find('td').eq(3).html(statusBadge);
            return;
        }

        // Caso tenha alteração, prossegue com a requisição
        $.ajax({
            url: '<?= base_url('painel/orgao/denuncia/atualizar-status') ?>',
            method: 'POST',
            data: {
                denunciaID: denunciaID,
                novoStatus: novoStatus
            },
            dataType: 'json',
            success: function (resposta) {
                if (resposta.status === 'sucesso') {
                    Swal.fire({
                        icon: 'success',
                        title: `O Status da Denúncia #${denunciaID} foi atualizado com sucesso.`,
                        text: resposta.mensagem,
                        confirmButtonColor: '#198754', // verde Bootstrap
                        timer: 2000,
                    });
                    table.ajax.reload(null, false); // reload sem resetar a página
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: resposta.mensagem,
                        confirmButtonColor: '#198754', // verde Bootstrap
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de comunicação',
                    text: 'Não foi possível atualizar o status. Tente novamente.',
                    confirmButtonColor: '#198754', // verde Bootstrap
                });
            }
        });
    });

    // Btn cancelar
    $('#listar_denuncias tbody').on('click', '.cancelar-acao-btn', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var rowData = row.data();

        // Renderiza novamente o badge de status (visualização padrão)
        var statusBadge = '';
        if (rowData.status === 'Pendente') {
            statusBadge = '<span class="badge rounded-pill bg-warning text-warning bg-opacity-25 text-bg-warning"> &middot; Pendente</span>';
        } else if (rowData.status === 'Em Progresso') {
            statusBadge = '<span class="badge rounded-pill bg-primary text-primary bg-opacity-25 text-bg-primary"> &middot; Em progresso</span>';
        } else if (rowData.status === 'Resolvido') {
            statusBadge = '<span class="badge rounded-pill bg-success text-success bg-opacity-25 text-bg-success"> &middot; Resolvido</span>';
        }

        // Atualiza a célula da coluna de status (coluna 3)
        $(tr).find('td').eq(3).html(statusBadge);
    });

    // Limpa o formulário e reseta os campos após o modal ser fechado
    $('#modalDenuncia').on('hidden.bs.modal', function () {
        const $form = $('#formDenunciaModal');

        $form[0].reset(); // Limpa os campos do formulário
        $('#previewImagensModal').empty(); // Limpa previews de imagens
        $('#previewVideoModal').empty();   // Limpa previews de vídeo
    });

    $(document).on('click', '.visualizar-denuncia', function () {
        var rowData = table.row($(this).parents('tr')).data();
        var idDenuncia = rowData['denunciaID'];

        $('#titulo_denuncia').val(rowData['tituloDenuncia']);
        $('#categoria_denuncia').val(rowData['tipoDenunciaID']);
        $('#descricao_denuncia').val(rowData['detalhes']);
        $('#logradouro_denuncia').val(rowData['logradouro']);
        $('#numero_denuncia').val(rowData['numero']);
        $('#bairro_denuncia').val(rowData['bairro']);
        $('#cep_denuncia').val(rowData['CEP']);
        $('#ponto_referencia').val(rowData['pontoReferencia']);

        // Mídias (fotos e vídeos)
        $('#previewImagensModal').empty();
        $('#previewVideoModal').empty();

        // Carrega mídias via AJAX
        $.ajax({
            url: '<?= base_url("/painel/orgao/denuncias/midias/") ?>' + idDenuncia,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                // Imagens
                if (response.imagens.length > 0) {
                    response.imagens.forEach(function (imgUrl) {
                        $('#previewImagensModal').append(`
                            <img src="${imgUrl}" class="img-thumbnail" style="width: 100px; height: auto;">
                        `);
                    });
                } else {
                    $('#previewImagensModal').html('<p class="text-center text-muted">Nenhuma imagem enviada.</p>');
                }

                // Vídeos
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

        // Abre o modal
        $('#modalDenunciaLabel').text("Denúncia #" + idDenuncia);
        $('#modalDenuncia').modal('show');

    });

    $('#busca_denuncia_form').on('submit', function(event) {
        event.preventDefault();
        $('#btnAplicarFiltros').trigger('click'); 
    });

    $('.btn-filtro-status').on('click', function () {

        $('.btn-filtro-status').removeClass('active btn-warning btn-primary btn-success btn-secondary btn-outline-warning btn-outline-primary btn-outline-success btn-outline-secondary');
        $('#btnFiltroTodos').addClass('btn-outline-secondary');
        $('#btnFiltroPendente').addClass('btn-outline-warning');
        $('#btnFiltroEmProgresso').addClass('btn-outline-primary');
        $('#btnFiltroResolvido').addClass('btn-outline-success');

        $(this).addClass('active');
        const statusValor = $(this).data('valor') || "";
        filtroStatusValor = statusValor.toString();

        if (statusValor === 'Pendente') {
            $(this).removeClass('btn-outline-warning').addClass('btn-warning');
        } else if (statusValor === 'Em Progresso') {
            $(this).removeClass('btn-outline-primary').addClass('btn-primary');
        } else if (statusValor === 'Resolvido') {
            $(this).removeClass('btn-outline-success').addClass('btn-success');
        } else {
            $(this).removeClass('btn-outline-secondary').addClass('btn-secondary');
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
        $('#selectTipoBuscaTexto').val('titulo'); // Volta para o padrão
        $('#filtroBuscaValor').val('');
        
        // Reseta o filtro de status para "Todos"
        filtroStatusValor = "";
        $('#btnFiltroTodos').removeClass('btn-outline-secondary').addClass('btn-secondary active');
        $('#btnFiltroPendente').removeClass('active btn-warning').addClass('btn-outline-warning');
        $('#btnFiltroEmProgresso').removeClass('active btn-primary').addClass('btn-outline-primary');
        $('#btnFiltroResolvido').removeClass('active btn-success').addClass('btn-outline-success');
        
        // Reseta a ordenação para o padrão e recarrega a tabela
        table.order([[15, 'desc']]).draw();
    });

    $('#selectTipoBuscaTexto').on('change', function() {
        filtroTipoBuscaAtual = $(this).val();
        // Se o campo de busca já tiver algo, refiltra. Senão, espera o usuário digitar ou clicar em "Filtrar".
        if ($('#filtroBuscaValor').val().trim() !== '') {
            filtroBuscaValorAtual = $('#filtroBuscaValor').val();
            table.draw();
        }
    });

    $('#busca_denuncia_form').on('submit', function (event) {
        event.preventDefault();
        $('#btnAplicarFiltros').trigger('click');
    });

    // Expande uma linha por vez
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

    // Expande todas as linhas simultaneamente
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

    document.addEventListener('DOMContentLoaded', function () {
        fetch('<?= base_url("/painel/orgao/denuncias/graficos") ?>')
            .then(response => response.json())
            .then(data => {
                // Gráfico de Status
                if (data.status && data.status.length > 0) {
                    const statusLabels = data.status.map(item => item.status);
                    const statusValues = data.status.map(item => item.total);

                    new Chart(document.getElementById('graficoStatus'), {
                        type: 'bar',
                        data: {
                            labels: statusLabels,
                            datasets: [{
                                label: 'Total',
                                data: statusValues,
                                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                title: { display: false, text: 'Denúncias por Status' }
                            }
                        }
                    });
                }

                // Gráfico de Categorias
                if (data.categorias && data.categorias.length > 0) {
                    const categoriaLabels = data.categorias.map(item => item.categoria);
                    const categoriaValues = data.categorias.map(item => item.total);

                    new Chart(document.getElementById('graficoCategoria'), {
                        type: 'pie',
                        data: {
                            labels: categoriaLabels,
                            datasets: [{
                                label: 'Total',
                                data: categoriaValues,
                                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#9966FF', '#009688'],
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: { display: false, text: 'Denúncias por Categoria' }
                            }
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Erro ao carregar dados dos gráficos:', error);
            });
    });

</script>


</body>
</html>