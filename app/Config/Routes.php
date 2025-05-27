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

## User
# Cadastro
$routes->get('/cadastro', 'Usuario::cadastrar_usuario');
$routes->match(['GET', 'POST'], '/usuario/cadastro/(cidadao)', 'Usuario::cadastrar_usuario/$1');
$routes->match(['GET', 'POST'], '/usuario/cadastro/(orgao)', 'Usuario::cadastrar_usuario/$1');
$routes->match(['GET', 'POST'], '/usuario/profile/(:any)/alterarSenha', 'Usuario::alterarSenha/$1');

## Dashboard
$routes->match(['GET', 'POST'], '/painel/(cidadao)', 'Denuncia::index/$1');
$routes->match(['GET', 'POST'], '/painel/(orgao)', 'Denuncia::index/$1');

# List | Upsert
$routes->match(['GET', 'POST'], '/usuarios/list', 'Usuario::index');
$routes->match(['GET', 'POST'], '/usuarios/list/json', 'Usuario::json_list');
$routes->match(['GET', 'POST'], '/usuarios/(novo)', 'Usuario::upsert/$1');
$routes->match(['GET', 'POST'], '/usuarios/(editar)/(:num)', 'Usuario::upsert/$1/$2');
$routes->match(['GET', 'POST'], '/usuarios/inativar/(:num)', 'Usuario::inativarUsuario/$1');
$routes->match(['GET', 'POST'], '/usuario/profile/(:any)/alterarSenha', 'Usuario::alterarSenha/$1');

#Redirect
$routes->addRedirect('(.+)', '/');
