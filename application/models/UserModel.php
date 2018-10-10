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

        /*function criar_datatable()
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
        $this->db->join('subcategorias', 'subcategoria_fk = subcategoria_id');
        $this->db->join('categorias', 'categoria_fk = categoria_id');
        $this->db->where('usuario_email', $email);
        $query = $this->db->get();
        return $query->row_array();
    }
    */
    }