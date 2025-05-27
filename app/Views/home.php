<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Relate problemas na sua comunidade e acompanhe o progresso com o Alerta Verde. Uma plataforma de cidadania ativa." />
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/google-fonts/font.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/material-symbols/material-symbols-rounded.css') ?>">
    <title>Alerta Verde</title>
</head>

<body>
    <header>
        <div class="header-container">
            <a href="./">
                <img class="logo" src="<?= base_url('assets/img/alerta_verde_horizontal.png') ?>" alt="Alerta Verde" width="136" height="26">
            </a>
            <nav aria-label="primaria">
                <ul class="header-menu">
                    <li><a href="<?= base_url('login') ?>">Login</a></li>
                    <li><a href="<?= base_url('cadastro') ?>">Cadastro</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="introducao">
        <div class="intro-container">
            <h1>Relate problemas na sua <br> comunidade</h1>
            <p>Ajude a melhorar sua cidade relatando problemas diretamente aos órgãos responsáveis. <br> Acompanhe o progresso e veja os resultados.</p>
            <a href="<?= base_url('login') ?>"> Denuncie
                <span class="material-symbols-rounded">arrow_forward</span>
            </a>
            
        </div>
    </main>

    <section class="funciona-bg">
        <div>
            <h2>Como funciona</h2>
            <div class="cards-container">
                <div class="cards">
                    <img src="<?= base_url('assets/img/denuncia.svg') ?>" alt="ícone de denúncia" width="75" height="75">
                    <h3>Enviar uma denúncia</h3>
                    <p>Documente problemas com fotos, vídeos e dados de localização <br> precisos.</p>
                </div>
                <div class="cards">
                    <img src="<?= base_url('assets/img/analise.svg') ?>" alt="ícone de análise" width="75" height="75">
                    <h3>Análise dos órgãos </h3>
                    <p>Os órgãos públicos recebem e processam relatos por meio de um painel especializado.</p>
                </div>
                <div class="cards">
                    <img src="<?= base_url('assets/img/localizacao.svg') ?>" alt="ícone de localização" width="75" height="75">
                    <h3>Acompanhar o Progresso</h3>
                    <p>Acompanhe o status dos seus relatos e receba atualizações à medida que forem resolvidos.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="comunidade-bg">
        <h2>Faça parte da comunidade</h2>
        <p>Milhares de cidadãos e centenas de órgãos públicos já estão usando o Alerta Verde <br> para melhorar as comunidades.</p>
        <div class="comunidade-conteudo">
            <div class="comunidade-info">
                <span class="material-symbols-rounded">group</span>
                <p>10,000+ Cidadãos</p>
            </div>
                <div class="comunidade-info">
                <span class="material-symbols-rounded">shield</span>
                <p>200+ Órgãos públicos</p>
            </div>
        </div>
    </section>

    <footer class="footer-bg">
        <div class="direitos">
            <span>© <?= date('Y') ?> Alerta Verde. Todos os direitos reservados</span>
        </div>
    </footer>

</body>
</html>
