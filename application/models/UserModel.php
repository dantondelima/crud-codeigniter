<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class UserModel extends MY_Model{
        function __construct() {
            parent::__construct();
            $this->table = 'subcategorias';
        }

        function selectSubcategoria($id) {
            $this->db
            ->select("*")
            ->from("subcategorias")
            ->where('id_categoria', $id);
            $dados = $this->db->get();
            return $dados->result_array();
          }
          
          function Formatar($categorias){
            if($categorias){
              for($i = 0; $i < count($categorias); $i++){
                $categorias[$i]['editar_url'] = base_url('subcategoria/alterar')."/".$categorias[$i]['id_subcategoria'];
                $categorias[$i]['excluir_url'] = base_url('subcategoria/excluir')."/".$categorias[$i]['id_subcategoria'];
              }
              return $categorias;
            } else {
              return false;
            }
          }
    }