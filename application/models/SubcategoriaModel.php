<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class SubcategoriaModel extends MY_Model{
        
        function __construct() {
            parent::__construct();
            $this->table = 'categorias';
        }
        
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

        function pegaCategoria() {
            $this->db
            ->select("subcategoria.subcategorias")
            ->from("ci")
            ->join('categorias', 'categoria.id_categoria = subcategoria.id_categoria')
            ->where('status_vaga', $status);
        }
    }