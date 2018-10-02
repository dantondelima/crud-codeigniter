<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class CategoriaModel extends MY_Model{
        /*public function buscaTodos() {
            return $this->db->get("categorias")->result_array();
        }*/
        
        function __construct() {
            parent::__construct();
            $this->table = 'categorias';
        }
        /**
        * Formata os contatos para exibição dos dados na home
        *
        * @param array $contatos Lista dos contatos a serem formatados
        *
        * @return array
        */
        function Formatar($categorias){
          if($categorias){
            for($i = 0; $i < count($categorias); $i++){
              $categorias[$i]['editar_url'] = base_url('categoria/alterar')."/".$categorias[$i]['id_categoria'];
              $categorias[$i]['excluir_url'] = base_url('categoria/excluir')."/".$categorias[$i]['id_categoria'];
            }
            return $categorias;
          } else {
            return false;
          }
        }
    }