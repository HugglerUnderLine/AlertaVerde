<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Painel do Cidadão</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style-bootstrap.css">
  <link rel="stylesheet" href="style.css">
</head>
<header class="bg-principal d-flex justify-content-between">
  <div class=" d-flex gap-1 m-0 ms-5">
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
          <h3 class="h6 p-4 mb-4 text-claro">Painel da Agência</h3>
        </div>
        <nav class="mt-4">
          <ul class="bg-denuncias nav flex-column gap-3">
            <li class="nav-item d-flex align-items-center gap-2 ">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                <path
                  d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                <path
                  d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
              </svg>
              <a class="nav-link text-claro" href="/dashboard-empresa.html">Minhas Denúncias</a>
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
                <path fill-rule="evenodd"
                  d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
              </svg>
              <a class="nav-link text-claro" href="/">Sair</a>
            </li>
          </ul>
        </nav>
      </aside>
    </div>
    <main class="flex-grow-1 p-4 bg-principal">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-destaque text-claro">Denúncias</h1>
        <a href="/nova-denuncia.html" class="btn bg-botao text-claro fw-bold">+ Nova denúncia</a>
      </div>
      <div class="input-group mb-4">
        <input type="text" class="form-control" placeholder="Procurar denúncia..." />
        <button class="btn bg-botao text-claro">Filtro</button>
      </div>

      <div class="mb-4">
        <button class="btn bg-botao text-claro me-2">Ativas</button>
        <button class="btn btn-outline-light text-claro me-2">Resolvidas</button>
        <button class="btn btn-outline-light text-claro">Todas</button>
      </div>

      <section class="d-flex flex-column gap-3">

        <div class="card bg-secundaria position-relative">
          <div class="card-body">
            <h5 class="card-title">Visualização de árvore caída.</h5>
            <p class="card-text">Pedido no estacionamento principal da UTFPR, há uma árvore caída.</p>
            <p class="small">📍 R. Doutor Washington Subtil Chueire, 330 - UFPR | 2 dias atrás</p>
            <button class="btn bg-botao-detalhes text-claro btn-sm mt-2">Ver detalhes</button>
            <span class="badge bg-botao-hover white-text position-absolute top-0 end-0 m-3">Em progresso</span>
          </div>
        </div>


        <div class="card bg-secundaria position-relative">
          <div class="card-body">
            <h5 class="card-title">Poste de iluminação quebrado</h5>
            <p class="card-text">A iluminação do poste está quebrada há mais de uma semana, gerando preocupação com a
              segurança.</p>
            <p class="small">📍 Avenida Doutor Vicente Machado, 100 | 1 semana atrás</p>
            <button class="btn bg-botao-detalhes text-claro btn-sm mt-2">Ver detalhes</button>
            <span class="badge bg-warning white-text position-absolute top-0 end-0 m-3">Pendente</span>
          </div>
        </div>

        <div class="card bg-secundaria position-relative">
          <div class="card-body">
            <h5 class="card-title">Descarte inapropriado de lixo</h5>
            <p class="card-text">Materiais de construção e resíduos diversos descartados ilegalmente.</p>
            <p class="small">📍 Rua Coronel Dulcídio, 620 | 3 dias atrás</p>
            <button class="btn bg-botao-detalhes text-claro btn-sm mt-2">Ver detalhes</button>
            <span class="badge bg-secondary white-text position-absolute top-0 end-0 m-3">Inativo</span>
          </div>
        </div>

      </section>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>