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
        function Formatar($contatos){
          if($contatos){
            for($i = 0; $i < count($contatos); $i++){
              $contatos[$i]['editar_url'] = base_url('editar')."/".$contatos[$i]['id_categoria'];
              $contatos[$i]['excluir_url'] = base_url('excluir')."/".$contatos[$i]['id_categoria'];
            }
            return $contatos;
          } else {
            return false;
          }
        }
    }