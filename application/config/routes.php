<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'UsuariosController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['categoria'] = "CategoriasController/index";
$route['categoria/cadastro'] = "CategoriasController/Form";
$route['categoria/cadastrar'] = "CategoriasController/Salvar";
$route['categoria/alterar/(:num)'] = "CategoriasController/Editar/$1";
$route['categoria/atualizar'] = "CategoriasController/Atualizar";
$route['categoria/excluir/(:num)'] = "CategoriasController/Excluir/$1";

$route['subcategoria'] = "SubcategoriasController/index";
$route['subcategoria/cadastro'] = "SubcategoriasController/Form";
$route['subcategoria/cadastrar'] = "SubcategoriasController/Salvar";
$route['subcategoria/alterar/(:num)'] = "SubcategoriasController/Editar/$1";
$route['subcategoria/atualizar'] = "SubcategoriasController/Atualizar";
$route['subcategoria/excluir/(:num)'] = "SubcategoriasController/Excluir/$1";