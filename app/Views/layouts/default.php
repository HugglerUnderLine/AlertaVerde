<!-- Header -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Relate problemas na sua comunidade e acompanhe o progresso com o Alerta Verde. Uma plataforma de cidadania ativa." />
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/google-fonts/font.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/material-symbols/material-symbols-rounded.css') ?>">

    <?= $this->renderSection('more-styles') ?>
    <title><?= !empty($telaAtual) ? $telaAtual . " • " : "" ?>Alerta Verde</title>
</head>

<body class="d-flex flex-column min-vh-100">

<!-- Conteúdo -->
<?= $this->renderSection('content') ?>

<!-- Alertas -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
    <div id="alerta" class="toast toast-custom" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto" id="tituloAlerta">Notificação</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="alertaMensagem">
            </div>
    </div>
</div>


<!--==========================================================================================================================================-->
<!--==========================================================================================================================================-->
<!--==========================================================================================================================================-->

<script src="<?= base_url('assets/JQuery-3.7.0/jquery-3.7.0.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
<script>
    $(document).ready(function(){
        // Inicializa os tooltips
        const tooltips = document.querySelectorAll('.tt');
        tooltips.forEach(t => {
            new bootstrap.Tooltip(t);
        });
    });

    // Bootstrap Tooltips:
    $(document).ready(function () {
        const tooltips = document.querySelectorAll('.tt'); // Seleciona todos os elementos com a classe .tt
        tooltips.forEach(t => {
            new bootstrap.Tooltip(t); // Inicializa o tooltip para cada elemento
        });
    });

</script>

<?= $this->renderSection('more-scripts') ?>

</body>

</html>



