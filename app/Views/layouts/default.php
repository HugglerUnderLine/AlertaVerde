<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Relate problemas na sua comunidade e acompanhe o progresso com o Alerta Verde. Uma plataforma de cidadania ativa." />

    <!-- título da página -->
    <?= $this->renderSection('page-title') ?>

    <!-- Estilização -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/google-fonts/font.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/material-symbols/material-symbols-rounded.css') ?>">
    <?= $this->renderSection('more-styles') ?>

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
        /* Estilização da mensagem de proceessamento do Datatables */
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
            width: auto !important;
        }
        /* Paginação do DataTables */
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
        #previewImagensModal img,
        #previewVideoModal video {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
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

<header class="bg-principal d-flex justify-content-between">
    <div class="d-flex gap-1 m-0 ms-5">
        <a href="#">
            <img class="logo highlight-on-hover" src="<?= base_url('assets/img/alerta_verde_horizontal.png') ?>" alt="Alerta Verde" width="130" height="26">
        </a>
    </div>
</header>

<body class="text-white">

<div class="bg-divisao bg-principal d-flex min-vh-100">
    <div class="bg-menu">
        <aside class="bg-aside p-4" style="width: 250px;">
            <div class="d-flex bg-nome align-items-center text-start gap-3">
                <span class="material-symbols-rounded">
                    <?php if ($conta === 'orgao') : ?>
                    shield_person
                    <?php elseif ($conta === 'representante') : ?>
                    shield
                    <?php elseif ($conta === 'admin') : ?>
                    security
                    <?php elseif ($conta === 'cidadao') : ?>
                    account_circle
                    <?php endif ?>
                </span>
                <h3 class="h6 text-white m-0">
                    <?= session('nome_reduzido') ?>
                </h3> 
            </div>

            <nav class="mt-4">
                <ul class="bg-denuncias nav flex-column gap-3">
                <!-- Menu -->

                    <?php if ($conta === 'orgao' || $conta === 'representante') : ?>
                    <!-- Órgão -->
                    <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">analytics</span>
                        <a class="nav-link text-white text-start" href="<?= base_url('painel/orgao') ?>">Painel da Agência</a>
                    </li>

                    <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">assignment</span>
                        <a class="nav-link text-white text-start" href="<?= base_url('painel/orgao/denuncias') ?>">Lista de Denúncias</a>
                    </li>

                    <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">group_add</span>
                        <a class="nav-link text-white" href="<?= base_url('painel/orgao/usuarios')?>">Usuários</a>
                    </li>

                    <li class="nav-item d-flex gap-2 align-items-center text-start btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">history</span>
                        <a class="nav-link text-white" href="<?= base_url('painel/orgao/usuarios/log') ?>">Log Auditoria</a>
                    </li>

                    <!-- End Órgão -->

                    <?php elseif ($conta === 'admin') : ?>
                    <!-- Admin -->
                    <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">analytics</span>
                        <a class="nav-link text-white text-start" href="<?= base_url('painel/admin') ?>">Painel do Administrador</a>
                    </li>

                    <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">assignment</span>
                        <a class="nav-link text-white text-start" href="<?= base_url('painel/admin/denuncias') ?>">Lista de Denúncias</a>
                    </li>

                    <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">group_add</span>
                        <a class="nav-link text-white" href="<?= base_url('painel/admin/usuarios')?>">Usuários</a>
                    </li>

                    <li class="nav-item d-flex gap-2 align-items-center text-start btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">history</span>
                        <a class="nav-link text-white" href="<?= base_url('painel/admin/usuarios/log') ?>">Log Auditoria</a>
                    </li>
                    <!-- End Admin -->

                    <?php else : ?>
                    <!-- Cidadão -->
                    <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">assignment</span>
                        <a class="nav-link text-white text-start" href="<?= base_url('painel/cidadao') ?>">Minhas Denúncias</a>
                    </li>
                    
                    <!-- End Cidadão -->
                    <?php endif ?>

                    <li class="nav-item d-flex align-items-center text-start gap-2 btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">account_circle</span>
                        <a class="nav-link text-white" href="<?= base_url('usuario/perfil/' . session('uuid')) ?>">Meu Perfil</a>
                    </li>
                    <li class="nav-item d-flex gap-2 align-items-center text-start btn text-white highlight-on-hover">
                        <span class="material-symbols-rounded">logout</span>
                        <a class="nav-link text-white" href="<?= base_url('logout') ?>">Sair</a>
                    </li>
                <!-- End Menu -->
                </ul>
            </nav>
        </aside>
    </div>

    <!-- Conteúdo -->
    <?= $this->renderSection('content') ?>

</div>

<!--===========================================================================================================-->
<!--===========================================================================================================-->
<!--===========================================================================================================-->

<script src="<?= base_url("assets/JQuery-3.7.0/jquery-3.7.0.min.js") ?>"></script>
<script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/sweetalert2/sweet.min.js') ?>"></script>
<script>
    function copiarParaAreaDeTransferencia(text) {
        if (navigator.clipboard && window.isSecureContext) {
            // Navegadores modernos (HTTPS ou localhost)
            navigator.clipboard.writeText(text).then(function() {
                console.log('Texto copiado com sucesso!');
            }, function(err) {
                console.error('Erro ao copiar texto: ', err);
            });
        } else {
            // Fallback para navegadores mais antigos
            let tempInput = document.createElement("textarea");
            tempInput.value = text;
            tempInput.style.position = "absolute";
            tempInput.style.left = "-9999px"; // Fora da tela
            document.body.appendChild(tempInput);
            tempInput.focus();
            tempInput.select();
            try {
                document.execCommand("copy");
                // console.log('Texto copiado com sucesso.');
            } catch (err) {
                // console.error('Erro ao copiar com fallback: ', err);
            }
            document.body.removeChild(tempInput);
        }
    }
</script>

<?= $this->renderSection('more-scripts') ?>

</body>
</html>



