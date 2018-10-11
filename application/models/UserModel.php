<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class UserModel extends MY_Model{
        function __construct() {
            parent::__construct();
            $this->table = 'users';
        }

        function selectSubcategoria($id) {
            $this->db
            ->select("*")
            ->from("subcategorias")
            ->where('id_categoria', $id);
            $dados = $this->db->get();
            return $dados->result_array();
          }
          
          function selectCategoria() {
            $this->db
            ->select("*")
            ->from("categorias")
            ->join('categorias', 'users.categoria = categorias.id_categoria');
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
    
    function criar_query()
    {
        $this->db->select($this->select_columns);
        $this->db->from($this->table, 'subcategorias', 'categorias');
        $this->db->join('subcategorias', 'id_categoria = id_categoria');
        $this->db->join('categorias', 'categoria_fk = categoria_id');
        if(!empty($_POST["subcategoria"]))
        {
            $this->db->where('subcategoria_id', intval($_POST["subcategoria"]));
        }
        else if(!empty($_POST["categoria"]))
        {
            $this->db->where('categoria_id', intval($_POST["categoria"]));
        }     
        else if(isset($_POST["search"]["value"]))
        {
            $this->db->like("usuario_id", $_POST["search"]["value"]);
            $this->db->or_like("usuario_nome", $_POST["search"]["value"]);
            $this->db->or_like("usuario_email", $_POST["search"]["value"]);
            $this->db->or_like("usuario_data", $_POST["search"]["value"]);
            $this->db->or_like("subcategoria_nome", $_POST["search"]["value"]);
            $this->db->or_like("categoria_nome", $_POST["search"]["value"]);
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_columns[$_POST["order"]["0"]["column"]]
                    , $_POST["order"]["0"]["dir"]);
        }
        else
        {
            $this->db->order_by("usuario_id", "desc");
        }
    }
}