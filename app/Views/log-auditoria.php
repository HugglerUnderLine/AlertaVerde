<?= $this->extend('layouts/default') ?>

<?= $this->section('page-title') ?>
<title>Log Auditoria</title>
<?= $this->endSection() ?>

<?= $this->section('more-styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/css/buttons.bootstrap5.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="p-4 flex-fill">
    <section>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 text-destaque text-claro">Log Auditoria</h1>
        </div>
        <p class="fs-6 fw-normal mt-2" style="color: var(--cor-7);">Visualize as ações realizadas pelos usuários da sua unidade.</p>
    </section>

    <div class="card bg-secundaria position-relative p-4 mt-2 px-4 pt-2 pb-4">
        <form id="busca_log_form" class="mb-4" method="post">
            <div class="row justify-content-center mb-3 mt-2">
                <div class="col-auto">
                    <div class="d-flex gap-2 justify-content-center">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text">Início</span>
                            <input type="date" class="form-control" name="dataInicial" id="dataInicial">
                        </div>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text">Fim</span>
                            <input type="date" class="form-control" name="dataFinal" id="dataFinal">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <input type="text" class="form-control" placeholder="🔍 Buscar por E-mail..." style="max-width: 250px;" id="filtroBuscaValor" name="filtroBuscaValor">

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
            <table id="listar_logs" class="table table-hover align-middle rounded-2 table-striped" style="width:100%">
                <thead class="bg-success bg-opacity-10">
                    <tr>
                        <th>E-mail</th>
                        <th>Órgão</th>
                        <th>Tipo Usuário</th>
                        <th>Ação</th>
                        <th>IP</th>
                        <th>Detalhes</th>
                        <th>Data</th>
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
<script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/buttons.bootstrap5.min.js') ?>"></script>

<script type="text/javascript">

    DataTable.Buttons.defaults.dom.button.className = 'btn'; //Sobrescreve a estilização padrão dos botões no DataTables
    
    var url = '<?= $url_destino ?>';

    // Variáveis para armazenar os valores dos filtros
    let filtroBuscaValorAtual = "";

    var table = new DataTable('#listar_logs', {
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: "POST",
            data: function(d) {
                d.valor_busca = filtroBuscaValorAtual;
            },
        },
        info: true,
        responsive: true,
        pageLength: 10,
        order: [[6, 'desc']],
        language: { url: '<?= base_url('assets/datatables-pt-BR.json') ?>', decimal: ',', thousands: '.' },
        layout: {
            topStart: null,
            topEnd: 'pageLength',
        },
        columnDefs: [{ targets: "_all", orderSequence: ['asc', 'desc'], className: "dt-body-left dt-head-left" }],
        columns: [
            { data: "user_email" },
            { data: "nome_orgao" },
            { data: "tipo_usuario", 
                render: function (data, type, row) {
                    if(row['tipo_usuario'] == 'orgao_master') {
                        return '<span class="material-symbols-rounded align-bottom text-success btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Gestor do Órgão">shield_person</span>';
                    } else if (row['tipo_usuario'] == 'orgao_representante') {
                        return '<span class="material-symbols-rounded align-bottom text-secondary btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Usuário">shield</span>';
                    }
                }, 
            },
            { data: "user_action" },
            { data: "user_ip" },
            { data: "detalhes" },
            { data: "data_log" },
        ],
    } );

    $('#busca_log_form').on('submit', function(event) {
        event.preventDefault();
        $('#btnAplicarFiltros').trigger('click'); 
    });

    // Evento para o botão "Filtrar"
    $('#btnAplicarFiltros').on('click', function() {
        filtroBuscaValorAtual = $('#filtroBuscaValor').val();
        table.draw();
    });

    // Evento para limpar filtros
    $('#btnLimparFiltros').on('click', function(){
        $('#filtroBuscaValor').val('');
        
        // Reseta o filtro de status para "Todos"
        filtroAtivoValor = "";
        
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
<?= $this->endSection() ?>