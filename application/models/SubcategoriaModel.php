<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class SubcategoriaModel extends MY_Model{
        
        function __construct() {
            parent::__construct();
            $this->table = 'subcategorias';
        }
        
        function pegaCategoria() {
          $this->db->select("*");
          $this->db->from('categorias');
          $query = $this->db->get();
          return $query->result();
        }
        
        function selectCategoria() {
          $this->db
          ->select("*")
          ->from("subcategorias")
          ->join('categorias', 'subcategorias.categoria_id = categorias.id_categoria');
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