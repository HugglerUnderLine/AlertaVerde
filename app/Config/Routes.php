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

## Usuários
# Cadastro
$routes->get('/cadastro', 'Usuario::cadastrar_usuario');
$routes->match(['GET', 'POST'], '/usuario/cadastro/(cidadao)', 'Usuario::cadastrar_usuario/$1');
$routes->match(['GET', 'POST'], '/usuario/cadastro/(orgao)', 'Usuario::cadastrar_usuario/$1');
$routes->match(['GET', 'POST'], '/usuario/profile/(:any)/alterarSenha', 'Usuario::alterarSenha/$1');

## Usuário
# List | Upsert
$routes->match(['GET', 'POST'], '/usuarios', 'Usuario::index');
$routes->match(['GET', 'POST'], '/usuarios/list', 'Usuario::json_list');
$routes->match(['GET', 'POST'], '/usuarios/(novo)', 'Usuario::upsert/$1');
$routes->match(['GET', 'POST'], '/usuarios/(editar)/(:num)', 'Usuario::upsert/$1/$2');
$routes->match(['GET', 'POST'], '/usuarios/inativar/(:num)', 'Usuario::inativar_usuario/$1');
$routes->match(['GET', 'POST'], '/usuario/perfil/(:any)', 'Usuario::exibir_perfil/$1');
$routes->match(['GET', 'POST'], '/usuario/log/(:any)', 'Usuario::log_usuario/$1');

## Dashboard
# Cidadão
$routes->match(['GET', 'POST'], '/painel/cidadao', 'Cidadao::index');
$routes->match(['GET', 'POST'], '/painel/cidadao/list', 'Denuncia::listar_denuncias_cidadao');
$routes->match(['GET', 'POST'], '/painel/cidadao/denuncia/registro', 'Denuncia::nova_denuncia');

# Órgão
$routes->match(['GET', 'POST'], '/painel/orgao', 'Orgao::index');
$routes->match(['GET', 'POST'], '/painel/orgao/list', 'Denuncia::json_list');
$routes->match(['GET', 'POST'], '/painel/orgao/denuncias', 'Orgao::denuncias_enviadas');
$routes->match(['GET', 'POST'], '/painel/orgao/denuncias/list', 'Denuncia::listar_denuncias_orgao');
$routes->post('/painel/orgao/denuncias/atribuir-denuncia', 'Denuncia::atribuir_denuncia');
$routes->post('/painel/orgao/denuncia/atualizar-status', 'Denuncia::atualizar_status_denuncia');
$routes->get('/painel/orgao/denuncias/graficos', 'Orgao::dados_graficos');
$routes->get('/painel/orgao/denuncias/midias/(:num)', 'Orgao::listar_midias/$1');

#Redirect
$routes->addRedirect('(.+)', '/');
