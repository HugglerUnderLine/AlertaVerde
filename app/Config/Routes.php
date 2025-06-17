<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Index::index');


#Base
$routes->get('/home', 'Home::index');
$routes->get('/login', 'Login::index');
$routes->post('/login/(cidadao)', 'Login::autenticar/$1');
$routes->post('/login/(orgao)', 'Login::autenticar/$1');
$routes->get('/logout', 'Login::logout');
$routes->get('/sobre', 'Sobre::index');



### Usuários
## Cadastro
$routes->get('/cadastro', 'Usuario::cadastrar_usuario');
$routes->match(['GET', 'POST'], '/usuario/cadastro/(cidadao)', 'Usuario::cadastrar_usuario/$1');
$routes->match(['GET', 'POST'], '/usuario/cadastro/(orgao)', 'Usuario::cadastrar_usuario/$1');

## Perfil
$routes->match(['GET', 'POST'], '/usuario/perfil/(:any)', 'Usuario::exibir_perfil/$1');

## Listagem
# Orgao
$routes->match(['GET', 'POST'], 'painel/orgao/usuarios', 'Usuario::index');
$routes->match(['GET', 'POST'], 'painel/orgao/usuarios/list', 'Usuario::json_list');
# Admin
$routes->match(['GET', 'POST'], 'painel/admin/usuarios', 'Usuario::index');
$routes->match(['GET', 'POST'], 'painel/admin/usuarios/list', 'Usuario::json_list');

## Upsert (Update | Insert) - Novos usuários do Órgão
$routes->post('/painel/orgao/usuario/(cadastrar-usuario)', 'Usuario::upsert_orgao/$1');
$routes->post('/painel/orgao/usuario/(editar-usuario)/(:num)', 'Usuario::upsert_orgao/$1/$2');

## Upsert (Update | Insert) - Novos Usuários Administradores na Plataforma
$routes->post('/painel/admin/usuario/(cadastrar-usuario)', 'Usuario::upsert_admin/$1');
$routes->post('/painel/admin/usuario/(editar-usuario)/(:num)', 'Usuario::upsert_admin/$1/$2');



### Audit Log
## Órgão
$routes->match(['GET', 'POST'], '/painel/orgao/usuarios/log', 'LogAuditoria::index');
$routes->match(['GET', 'POST'], '/painel/orgao/usuario/(:any)/log', 'LogAuditoria::index/$1');

$routes->match(['GET', 'POST'], '/painel/orgao/usuarios/log/list', 'LogAuditoria::log_usuario');
$routes->match(['GET', 'POST'], '/painel/orgao/usuario/(:any)/log/list', 'LogAuditoria::log_usuario/$1');
## Admin
$routes->match(['GET', 'POST'], '/painel/admin/usuarios/log', 'LogAuditoria::index');
$routes->match(['GET', 'POST'], '/painel/admin/usuario/log/list/(:any)', 'LogAuditoria::log_usuario/$1');

### Painel - Denúncias
## Cidadão
$routes->match(['GET', 'POST'], '/painel/cidadao', 'Cidadao::index');
$routes->match(['GET', 'POST'], '/painel/cidadao/list', 'Denuncia::listar_denuncias_cidadao');
$routes->match(['GET', 'POST'], '/painel/cidadao/denuncia/registro', 'Denuncia::nova_denuncia');
$routes->get('/painel/cidadao/denuncias/midias/(:num)', 'Orgao::listar_midias/$1');
$routes->get('/painel/cidadao/denuncias/detalhes/(:num)', 'Denuncia::listar_denuncias_form/$1');

## Órgão
$routes->match(['GET', 'POST'], '/painel/orgao', 'Orgao::index');
$routes->match(['GET', 'POST'], '/painel/orgao/list', 'Denuncia::json_list');
$routes->match(['GET', 'POST'], '/painel/orgao/denuncias', 'Orgao::denuncias_enviadas');
$routes->match(['GET', 'POST'], '/painel/orgao/denuncias/list', 'Denuncia::listar_denuncias_orgao');
# Upsert (Update | Insert) - Atribuição de denúncias a um órgão
$routes->post('/painel/orgao/denuncias/atribuir-denuncia', 'Denuncia::atribuir_denuncia');
$routes->post('/painel/orgao/denuncia/atualizar-status', 'Denuncia::atualizar_status_denuncia');
# Listagem de Dados para o Painel do Órgão
$routes->get('/painel/orgao/denuncias/graficos', 'Orgao::dados_graficos');
$routes->get('/painel/orgao/denuncias/midias/(:num)', 'Orgao::listar_midias/$1');

## Admin
$routes->match(['GET', 'POST'], '/painel/admin', 'Admin::index');
$routes->match(['GET', 'POST'], '/painel/admin/list', 'Denuncia::json_list');
$routes->match(['GET', 'POST'], '/painel/admin/denuncias', 'Orgao::denuncias_enviadas');
$routes->match(['GET', 'POST'], '/painel/admin/denuncias/list', 'Denuncia::listar_denuncias_admin');
# Listagem de Dados para o Painel do Admin
$routes->get('/painel/admin/denuncias/graficos', 'Orgao::dados_graficos');
$routes->get('/painel/admin/denuncias/midias/(:num)', 'Orgao::listar_midias/$1');



#Redirect
$routes->addRedirect('(.+)', '/');
