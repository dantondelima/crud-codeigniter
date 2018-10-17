<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class CategoriaModel extends MY_Model{
      var $select_columns = array ("id_categoria", "categoria");
      var $order_columns = array ("id_categoria", "categoria");
        
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

        function criar_query()
        {
            $this->db->select($this->select_columns);
            $this->db->from($this->table);
            if(isset($_POST["search"]["value"]))
            {
                $this->db->like("categoria", $_POST["search"]["value"]);
            }
            if(isset($_POST["order"]))
            {
                $this->db->order_by($this->order_columns[$_POST["order"]["0"]["column"]]
                        , $_POST["order"]["0"]["dir"]);
            }
            else
            {
                $this->db->order_by("id_categoria", "desc");
            }
        }
        
        function criar_datatable()
        {
            $this->criar_query();
            if($_POST["length"] != -1)
            {
               $this->db->limit($_POST["length"], $_POST["start"]);
            }
            $query = $this->db->get();
            return $query->result();
        }
        
        function getFilteredData()
        {
            $this->criar_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
            
        function getAllData()
        {
            $this->db->select("*");
            $this->db->from($this->table);
            return $this->db->count_all_results();
        }

    }