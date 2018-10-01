<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'UsuariosController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['categoria'] = "CategoriasController/index";
$route['categoria/cadastro'] = "CategoriasController/Form";
$route['categoria/cadastrar'] = "CategoriasController/Salvar";
$route['categoria/alterar/(:id)'] = "CategoriasController/Alterar/$1";
$route['categoria/atualizar'] = "CategoriasController/Atualizar";
$route['categoria/excluir/(:id)'] = "CategoriasController/Excluir/$1";