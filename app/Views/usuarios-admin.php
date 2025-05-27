<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Painel da Agência</title>
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
          <h3 class="h6 p-4 mb-4 text-claro">Administrador</h3>
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
              <a class="nav-link text-claro" href="/dashboard-admin.html">Denúncias</a>
            </li>
            <li class="nav-item d-flex align-items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person"
                viewBox="0 0 16 16">
                <path
                  d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
              </svg>
              <a class="nav-link text-claro" href="/empresas-admin.html">Empresas</a>
            </li>
            <li class="nav-item d-flex align-items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person"
                viewBox="0 0 16 16">
                <path
                  d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
              </svg>
              <a class="nav-link text-claro" href="/usuarios-admin.html">Usúarios</a>
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

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h1 class="h4 text-destaque text-claro">Usuarios</h1>
          <a href="/" class="btn bg-botao text-claro fw-bold">+ Novo Usuario</a>
        </div>
        <p class="fs-6 fw-normal mt-2" style="color: var(--cor-7);">Gerencie usuarios cadastrados no sistema.</p>
      </section>


      <section class="rounded-2 mt-2 px-4 pt-2 pb-4 ">
        <div class="card bg-secundaria position-relative p-4 mt-2 px-4 pt-2 pb-4">
          <div class="d-flex text-dark justify-content-between align-items-center mb-3 ">
            <h4 class="fw-bold">Todos os Usuários</h4>
            <div class="d-flex align-items-center gap-2">
              <input type="text" class="form-control" placeholder="🔍 Buscar usuários..." style="max-width: 250px;">
              <button class="btn btn-warning">Filtrar</button>
            </div>
          </div>
          <div class="mb-3">
            <button class="btn btn-outline-secondary btn-sm me-2">Todos</button>
            <button class="btn btn-outline-success btn-sm me-2">Ativos</button>
            <button class="btn btn-outline-secondary btn-sm me-2">Inativos</button>
            <button class="btn btn-outline-danger btn-sm">Bloqueados</button>
          </div>
          <div class="table-responsive">
            <table class="table table-hover align-middle rounded-2">
              <thead class="table-light">
                <tr>
                  <th><input type="checkbox" /></th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Tipo</th>
                  <th>Status</th>
                  <th>Data de Cadastro</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="checkbox" /></td>
                  <td>João Silva</td>
                  <td>joao.silva@example.com</td>
                  <td>Cidadão</td>
                  <td><span class="badge bg-success">Ativo</span></td>
                  <td>2023-01-10</td>
                </tr>
                <tr>
                  <td><input type="checkbox" /></td>
                  <td>Maria Oliveira</td>
                  <td>maria.oliveira@example.com</td>
                  <td>Cidadão</td>
                  <td><span class="badge bg-success">Ativo</span></td>
                  <td>2023-01-15</td>
                </tr>
                <tr>
                  <td><input type="checkbox" /></td>
                  <td>Secretaria de Obras</td>
                  <td>obras@prefeitura.gov.br</td>
                  <td>Órgão Público</td>
                  <td><span class="badge bg-success">Ativo</span></td>
                  <td>2023-01-05</td>
                </tr>
                <tr>
                  <td><input type="checkbox" /></td>
                  <td>Carlos Santos</td>
                  <td>carlos.santos@example.com</td>
                  <td>Cidadão</td>
                  <td><span class="badge bg-secondary">Inativo</span></td>
                  <td>2023-02-01</td>
                </tr>
                <tr>
                  <td><input type="checkbox" /></td>
                  <td>Ana Pereira</td>
                  <td>ana.pereira@example.com</td>
                  <td>Cidadão</td>
                  <td><span class="badge bg-danger">Bloqueado</span></td>
                  <td>2023-02-10</td>
                </tr>
                <tr>
                  <td><input type="checkbox" /></td>
                  <td>Secretaria de Meio Ambiente</td>
                  <td>meioambiente@prefeitura.gov.br</td>
                  <td>Órgão Público</td>
                  <td><span class="badge bg-success">Ativo</span></td>
                  <td>2023-01-08</td>
                </tr>
                <tr>
                  <td><input type="checkbox" /></td>
                  <td>Admin Sistema</td>
                  <td>admin@civicwatch.com</td>
                  <td>Administrador</td>
                  <td><span class="badge bg-success">Ativo</span></td>
                  <td>2023-01-01</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="text-muted">Mostrando 1 a 7 de 100 usuários</span>
            <div>
              <button class="btn btn-outline-secondary btn-sm me-2">Anterior</button>
              <button class="btn btn-outline-secondary btn-sm">Próximo</button>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
    </main>
  </div>

  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>