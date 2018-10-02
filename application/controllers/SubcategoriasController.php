<?php
class SubcategoriasController extends CI_Controller{
  
    function index(){
		$this->template->load('layout', 'subcategorias/listar', $dados);
    }

    public function Form() {
        // Recupera os contatos através do model
		$categorias = $this->SubcategoriaModel->pegaCategoria('categoria');
		// Passa os contatos para o array que será enviado à home
		$dados['categorias'] = $this->CategoriaModel->Formatar($categorias);
		// Chama a home enviando um array de dados a serem exibidos
        $this->template->load('layout', 'subcategorias/cadastrar');              
    }
    
}
