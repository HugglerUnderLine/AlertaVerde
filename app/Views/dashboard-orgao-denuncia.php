<?= $this->extend('layouts/default') ?>

<?= $this->section('page-title') ?>
<title>Painel da Agência</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="flex-grow-1 p-4 bg-principal">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-white">Denúncias</h1>
    </div>

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

    <section class="d-flex flex-column gap-3">
        <?php if (isset($denuncia) && !empty($denuncia)): ?>
            <?php foreach ($denuncia as $d): ?>
            <div class="card bg-secundaria position-relative">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($d['titulo_denuncia']) ?></h5>
                    <p class="card-text small mb-2"><?= esc($d['detalhes']) ?></p>
                    <p class="small text-secondary">📍 <?= esc($d['endereco']) ?> | <?= esc($d['tempo']) ?></p>
                    <button class="btn bg-botao-detalhes text-white btn-sm mt-3 btn-ver-detalhes"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalDenuncia"
                            data-id="<?= $d['id_denuncia'] ?>"
                            data-titulo="<?= esc($d['titulo_denuncia']) ?>"
                            data-categoria="<?= esc($d['id_tipo_fk']) ?>"
                            data-descricao="<?= esc($d['detalhes']) ?>"
                            data-logradouro="<?= esc($d['logradouro']) ?>"
                            data-numero="<?= esc($d['numero']) ?>"
                            data-bairro="<?= esc($d['bairro']) ?>"
                            data-cep="<?= esc($d['cep']) ?>"
                            data-referencia="<?= esc($d['ponto_referencia']) ?>"
                            data-imagens='<?= json_encode($d["imagens"] ?? []) ?>'
                            data-video='<?= !empty($d["video"]) ? base_url("uploads/" . $d["video"]) : "" ?>'
                    >Ver detalhes
                    </button>

                    <button class="btn btn-success btn-sm mt-3 float-end btn-assumir-denuncia"
                            data-id="<?= $d['id_denuncia'] ?>"
                            data-titulo="<?= esc($d['titulo_denuncia']) ?>">
                        Assumir denúncia
                    </button>

                    <?php if (esc($d['status_denuncia']) === 'Pendente'): ?>
                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">
                        <?= $d['status_denuncia'] ?>
                    </span>
                    <?php elseif (esc($d['status_denuncia']) === 'Em Progresso'): ?>
                    <span class="badge bg-botao-hover bg-info text-white position-absolute top-0 end-0 m-3">
                        <?= esc($d['status_denuncia']) ?>
                    </span>
                    <?php elseif (esc($d['status_denuncia']) === 'Resolvida'): ?>
                    <span class="badge bg-botao-hover bg-success text-white position-absolute top-0 end-0 m-3">
                        <?= esc($d['status_denuncia']) ?>
                    </span>
                    <?php endif ?>
                </div>
            </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="card bg-secundaria position-relative">
                <div class="card-body">
                    <h5 class="card-title">Nenhuma denúncia de tipagem atendida pela sua agência foi registrada.</h5>
                    <p class="card-text small">Quando uma denúncia de sua competência for registrada, ela aparecerá aqui até que a sua ou outra unidade se declare como responsável por atendê-la.</p>
                </div>
            </div>
        <?php endif ?>
    </section>

    <!-- Modal de confirmação de atribuição -->
    <div class="modal fade" id="modalConfirmarAtribuicao" tabindex="-1" aria-labelledby="modalConfirmarAtribuicaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-principal text-dark">
                <div class="modal-header bg-principal text-white">
                    <h5 class="modal-title" id="modalConfirmarAtribuicaoLabel">Confirmação de Atribuição</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body formulario-main">
                    <!-- O texto desse trecho é preenchido via JS posteriormente -->
                    <p id="texto-confirmacao" class="text-start"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnConfirmarAtribuicao">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>

<!--===========================================================================================================-->
<!--===========================================================================================================-->
<!--===========================================================================================================-->

<?= $this->section('more-scripts') ?>
<script>

    // Limpa o formulário e reseta os campos após o modal ser fechado
    $('#modalDenuncia').on('hidden.bs.modal', function () {
        const $form = $('#formDenunciaModal');

        $form[0].reset(); // Limpa os campos do formulário
        $('#previewImagensModal').empty(); // Limpa previews de imagens
        $('#previewVideoModal').empty();   // Limpa previews de vídeo
    });

    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("modalDenuncia");

        modal.addEventListener("show.bs.modal", function (event) {
            const button = event.relatedTarget;

            // Preenchimento dos campos do modal
            document.getElementById("titulo_denuncia").value = button.getAttribute("data-titulo");
            document.getElementById("categoria_denuncia").value = button.getAttribute("data-categoria");
            document.getElementById("descricao_denuncia").value = button.getAttribute("data-descricao");
            document.getElementById("logradouro_denuncia").value = button.getAttribute("data-logradouro");
            document.getElementById("numero_denuncia").value = button.getAttribute("data-numero");
            document.getElementById("bairro_denuncia").value = button.getAttribute("data-bairro");
            document.getElementById("cep_denuncia").value = button.getAttribute("data-cep");
            document.getElementById("ponto_referencia").value = button.getAttribute("data-referencia");

            // Preenchimento de mídias
            const imagens = JSON.parse(button.getAttribute("data-imagens") || '[]');
            const video = button.getAttribute("data-video");

            const previewImagens = document.getElementById("previewImagensModal");
            const previewVideo = document.getElementById("previewVideoModal");

            // Limpa conteúdos anteriores
            previewImagens.innerHTML = "";
            previewVideo.innerHTML = "";

            // Adiciona as imagens
            imagens.forEach(src => {
                const img = document.createElement("img");
                img.src = src;
                img.classList.add("img-thumbnail");
                img.style.maxWidth = "150px";
                img.style.maxHeight = "150px";
                previewImagens.appendChild(img);
            });

            // Adiciona o vídeo
            if (video) {
                const videoEl = document.createElement("video");
                videoEl.src = video;
                videoEl.controls = true;
                videoEl.style.maxWidth = "100%";
                previewVideo.appendChild(videoEl);
            }
        });
    });

    $(document).ready(function () {
        let denunciaIdSelecionada = null;
        const nomeUsuario = "<?= esc(session()->get('nome_completo')) ?>";
        const nomeOrgao = "<?= esc(session()->get('nome_orgao') ?? 'Agência') ?>";

        // Abrir o modal ao clicar no botão "Assumir denúncia"
        $(document).on('click', '.btn-assumir-denuncia', function () {
            denunciaIdSelecionada = $(this).data('id');
            const tituloDenuncia = $(this).data('titulo');

            const texto = `
                Prezado(a) ${nomeUsuario},<br><br>
                Tem certeza de que deseja atribuir a Denúncia #${denunciaIdSelecionada} "<strong>${tituloDenuncia}</strong>" à sua unidade (${nomeOrgao})?<br><br>
                Ao confirmar, essa denúncia passa a ser de responsabilidade de sua unidade e deve ser atendida em algum momento. Esta ação <strong>não pode ser desfeita</strong>.<br><br>
                Deseja continuar?
            `;

            $('#texto-confirmacao').html(texto);
            $('#modalConfirmarAtribuicao').modal('show');
        });

        // Confirmar atribuição
        $('#btnConfirmarAtribuicao').on('click', function () {
            if (!denunciaIdSelecionada) return;

            $.ajax({
                url: '<?= base_url('painel/orgao/denuncias/atribuir-denuncia') ?>',
                method: 'POST',
                data: { id_denuncia: denunciaIdSelecionada },
                dataType: 'json',
                success: function (response) {
                    if (response.sucesso) {
                        $('#modalConfirmarAtribuicao').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: response.mensagem || 'Denúncia atribuída com sucesso!',
                            confirmButtonColor: '#198754', // verde Bootstrap
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: response.mensagem || 'Erro ao atribuir denúncia.',
                            confirmButtonColor: '#198754', // verde Bootstrap
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Ocorreu um erro inesperado. Tente novamente.',
                        confirmButtonColor: '#198754', // verde Bootstrap
                    });
                }
            });
        });
    });

    $(document).on('click', '.btn-ver-detalhes', function () {
        const idDenuncia = $(this).data('id');
        const modalLabel = $('#modalDenunciaLabel');
        $('#previewImagensModal').empty();
        $('#previewVideoModal').empty();

        // Muda o título do modal com o ID da denúncia em questão
        modalLabel.text("Denúncia #" + idDenuncia);

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
    });

</script>
<?= $this->endSection() ?>
