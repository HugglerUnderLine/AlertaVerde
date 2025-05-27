<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nova Denuncia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<header class="bg-principal d-flex justify-content-between">
  <div class="d-flex gap-1 m-0 ms-5">
    <a href="./">
      <img class="logo" src="img/alerta_verde_horizontal.png" alt="Alerta Verde" width="130" height="26">
    </a>
  </div>
  <nav class="d-flex gap-2 align-items-center me-4">
    <button class="bg-botao-header p-2 rounded-2">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell"
        viewBox="0 0 16 16">
        <path
          d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
      </svg>
    </button>
    <button class="bg-botao-header p-2 rounded-2">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-left"
        viewBox="0 0 16 16">
        <path fill-rule="evenodd"
          d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
        <path fill-rule="evenodd"
          d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
      </svg>
    </button>
  </nav>
</header>

<body class="text-claro">
  <div class="bg-divisao bg-principal d-flex min-vh-100">
    <div class="bg-menu">
      <aside class="bg-aside p-4" style="width: 250px;">
        <div class="d-flex bg-nome">
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="85" fill="currentColor" class="bi bi-person-circle"
            viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
            <path fill-rule="evenodd"
              d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
          </svg>
          <h3 class="h6 p-4 mb-4 text-claro">Nome e Sobrenome</h3>
        </div>
        <nav class="mt-4">
          <ul class="bg-denuncias nav flex-column gap-3">
            <li class="nav-item d-flex align-items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                <path
                  d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                <path
                  d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
              </svg>
              <a class="nav-link text-claro" href="/dashboard-cidadao.html">Minhas Denúncias</a>
            </li>
            <li class="nav-item d-flex align-items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person"
                viewBox="0 0 16 16">
                <path
                  d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
              </svg>
              <a class="nav-link text-claro" href="/">Perfil</a>
            </li>
            <li class="nav-item d-flex gap-2 align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="30" fill="currentColor"
                class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                <path
                  d="M11 7a1 1 0 0 1 1 1v3.5h1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1V4.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0-.5.5V7h1a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1h1V8a1 1 0 0 1 1-1h1V4.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5V7h1z" />
              </svg>
              <a class="nav-link text-claro" href="./index.html">Sair</a>
            </li>
          </ul>
        </nav>
      </aside>
    </div>

    <main class="p-4 flex-fill">
      <section>
        <div class="d-flex gap-2 align-items-center">
          <a href="dashboard-cidadao.html" class="voltar">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
            </svg>
          </a>
          <p class="fs-6 fw-normal">Voltar para o painel</p>
        </div>
        <div class="mt-4">
          <h2>Enviar uma nova denúncia</h2>
          <p class="fs-6 fw-normal mt-2" style="color: var(--cor-7);">Forneça detalhes sobre o problema que deseja relatar.</p>
        </div>
      </section>
      <section class="formulario-main rounded-2 text-dark mt-5 px-4 pt-2 pb-4">
        <div >
          <h3 class="fw-bold mt-3">Detalhes da Denuncia</h3>
          <p class="fs-6 mt-2" style="color: var(--cor-8);">Prencha o formulario abaixo com o maximo de detalhes possivel</p>
        </div>
        <form class="row gap-4">
          <div class="form-group col-12">
            <label for="titulo" class="form-label fw-bold mt-4">Titulo da Denuncia</label>
            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo"
              placeholder="Ex: Buraco na rua...">
          </div>
          <div class="form-group col-12 ">
            <label for="natureza" class="form-label fw-bold ">Categoria:</label>
            <select class="form-select" id="natureza">
              <option value="0">Selecionar...</option>
              <option value="1">Qualidade da água</option>
              <option value="2">Poluição do ar</option>
              <option value="3">Desmatamento</option>
              <option value="4">Outros</option>
            </select>
          </div>
          <div class="form-group col-12">
            <label for="descricao" class="form-label fw-bold ">Descrição:</label>
            <textarea class="form-control" id="descricao" rows="4" placeholder="Forneça uma descrição detalhada do problema."></textarea>
          </div>
          <div class="form-group col-12">
            <label for="localizacao" class="form-label fw-bold ">Localização</label>
            <div class="d-flex gap-2">
              <input type="text" class="form-control form-control-sm flex-grow-1" id="localizacao" name="localizacao"
                placeholder="Ex: Avenida ...">
              <button type="submit" class="btn-localizacao btn btn-primary d-flex align-items-center gap-2" style="white-space: nowrap;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt"
                  viewBox="0 0 16 16">
                  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                </svg>
                Localização atual
              </button>
            </div>
          </div>
          <div class="form-group col-12">
            <label for="midia" class="form-label fw-bold ">Midias</label>
            <div class="d-flex gap-2 d-flex justify-content-center gap-5 ">
              <div class="bg-white rounded-3 d-flex flex-column gap-2 justify-content-center align-items-center" style="width: 100%; max-width: 750px; height: 150px;">

                <svg class="midia-itens" style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-card-image" viewBox="0 0 16 16" id="uploadImagemIcon">
                  <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                  <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z"/>
                </svg>
                <input type="file" class="form-control form-control-sm" id="imagem" name="imagem" accept="image/*" style="display: none;">
                <p class="fs-6">Adicionar imagens</p>
                <p class="fs-6">JPG, PNG, GIF de até 10MB</p>
              </div>
            
              <div class="bg-white rounded-3 d-flex flex-column gap-2 justify-content-center align-items-center" style="width: 100%; max-width: 750px; height: 150px;">

                <svg class="midia-itens" style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-camera-video" viewBox="0 0 16 16" id="uploadVideoIcon">
                  <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2zm11.5 5.175 3.5 1.556V4.269l-3.5 1.556zM2 4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h7.5a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1z"/>
                </svg>
                <input type="file" class="form-control form-control-sm" id="video" name="video" accept="video/*" style="display: none;">
                <p class="fs-6">Adicionar vídeo</p>
                <p class="fs-6">MP4, MOV de até 50MB</p>
              </div>
            </div>
           </div>
          <div class="d-flex justify-content-center align-items-center">
            <button type="submit" class="btn-enviar btn btn-primary w-100 d-flex justify-content-center align-items-center gap-2" style="white-space: nowrap;">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send"
                viewBox="0 0 16 16">
                <path d="M15.854 7.146a.5.5 0 0 0 0-.707L9.207.5a.5.5 0 0 0-.707.707L13.793 6H2.5a.5.5 0 0 0 0 1h11.293l-5.293 5.293a.5.5 0 0 0 .707.707l6-6z"/>
              </svg>
              Enviar Denúncia
            </button>
            
          </div>
        </form>
      </section>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
  document.getElementById("uploadImagemIcon").addEventListener("click", function() {
    document.getElementById("imagem").click();
  });

  document.getElementById("uploadVideoIcon").addEventListener("click", function() {
    document.getElementById("video").click();
  });
</script>
</html>