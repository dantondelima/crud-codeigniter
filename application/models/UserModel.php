<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class UserModel extends MY_Model{
      var $select_columns = array ("id_usuario" ,"nome", "email", "data_nasc", "categoria",  "subcategoria", "imagem");
      var $order_columns = array ("id_usuario" ,"nome", "email", "data_nasc", "categoria", "subcategoria", "imagem");

        function __construct() {
            parent::__construct();
            $this->table = 'users';
        }

        function GetAllJoin($id) {
          $this->db->select("*");
          $this->db->from($this->table);
          $this->db->join('subcategorias', 'subcategoria_fk = id_subcategoria');
          $this->db->join('categorias', 'categoria_fk = id_categoria');
          $this->db->order_by($id, 'desc');
          $query = $this->db->get();
            if ($query->num_rows() > 0) {
              return $query->result_array();
            } else {
              return null;
            }
        }

        function GetByEmail($email)
        {
            $this->db->select("*");
            $this->db->from($this->table);
            $this->db->join('subcategorias', 'subcategoria_fk = id_subcategoria');
            $this->db->join('categorias', 'categoria_fk = id_categoria');
            $this->db->where('email', $email);
            $query = $this->db->get();
            return $query->row_array();
        }

        function selectSubcategoria($id) {
            $this->db
            ->select("*")
            ->from("subcategorias")
            ->where('categoria_id', $id);
            $dados = $this->db->get();
            return $dados->result_array();
          }
          
          function selectCategoria() {
            $this->db
            ->select("*")
            ->from("users")
            ->join('categorias', 'users.categoria_fk = categorias.id_categoria');
            $dados = $this->db->get();
            return $dados->result_array();
          }

          function getSubCategoria() {
            $this->db
            ->select("*")
            ->from("users")
            ->join('subcategorias', 'users.categoria_fk = subcategorias.id_categoria');
            $dados = $this->db->get();
            return $dados->result_array();
          }

          function Formatar($categorias){
            if($categorias){
              for($i = 0; $i < count($categorias); $i++){
                $categorias[$i]['editar_url'] = base_url('usuario/alterar')."/".$categorias[$i]['id_usuario'];
                $categorias[$i]['excluir_url'] = base_url('usuario/excluir')."/".$categorias[$i]['id_usuario'];
              }
              return $categorias;
            } else {
              return false;
            }
          }

          function criar_query()
          {
              $this->db->select($this->select_columns);
              $this->db->from($this->table, 'subcategorias', 'categorias');
              $this->db->join('subcategorias', 'subcategoria_fk = id_subcategoria');
              $this->db->join('categorias', 'categoria_fk = id_categoria');
              if(isset($_POST["search"]["value"]))
              {
                  $this->db->or_like("nome", $_POST["search"]["value"]);
                  $this->db->or_like("email", $_POST["search"]["value"]);
                  $this->db->or_like("data_nasc", $_POST["search"]["value"]);
                  $this->db->or_like("categoria", $_POST["search"]["value"]);
                  $this->db->or_like("subcategoria", $_POST["search"]["value"]);
              }
              if(isset($_POST["order"]))
              {
                  $this->db->order_by($this->order_columns[$_POST["order"]["0"]["column"]]
                          , $_POST["order"]["0"]["dir"]);
              }
              else
              {
                  $this->db->order_by("id_usuario", "desc");
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