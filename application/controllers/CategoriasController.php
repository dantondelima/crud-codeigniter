<?php
class CategoriasController extends CI_Controller{
    public function Index()
	{
		$categorias = $this->CategoriaModel->GetAll('categoria');
		$dados['categorias'] =$this->CategoriaModel->Formatar($categorias);
		$this->template->load('layout', 'categorias/listar', $dados);
    }
    
    public function Form() {
        $this->template->load('layout', 'categorias/cadastrar');              
	}
	
	public function Salvar(){
		$categoria = $this->CategoriaModel->GetAll('categoria');
		$dados['categorias'] = $this->CategoriaModel->Formatar($categoria);
		$validacao = self::Validar('insert');
		if($validacao){
			$categoria = $this->input->post();
			$status = $this->CategoriaModel->Inserir($categoria);
			if(!$status){
				$this->session->set_flashdata('error', 'Não foi possível inserir o contato.');
			}else{
				$this->session->set_flashdata('success', 'Contato inserido com sucesso.');
				$this->template->load('layout', 'inicio');
			}
		}else{
			$this->session->set_flashdata('error', validation_errors('<p>','</p>'));
			$this->template->load('layout', 'categorias/cadastrar');
		}
	}
	/**
     * Carrega a view para edição dos dados
     */
	public function Editar(){
		// Recupera o ID do registro - através da URL - a ser editado
		$id = $this->uri->segment(3);
		// Se não foi passado um ID, então redireciona para a home
		if(is_null($id))
			redirect();
		// Recupera os dados do registro a ser editado
		$dados['categoria'] = $this->CategoriaModel->GetById($id, 'categoria');
		// Carrega a view passando os dados do registro
		$this->template->load('layout', 'categorias/alterar', $dados);
	}
	/**
     * Processa o formulário para atualizar os dados
     */
	public function Atualizar(){
		$validacao = self::Validar('update');
		
		if($validacao){
			$categoria = $this->input->post();
            $status = $this->CategoriaModel->Atualizar($categoria['id_categoria'], $categoria, 'categoria');
			if(!$status){
				$dados['categoria'] = $this->CategoriaModel->GetById($categoria['id_categoria'], 'categoria');
                $this->session->set_flashdata('error', 'Não foi possível atualizar o contato.');
                $this->template->load('layout', 'inicio');
			}else{
				$this->session->set_flashdata('success', 'Contato atualizado com sucesso.');
                $this->template->load('layout', 'inicio');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
            $this->template->load('layout', 'inicio');
		}
	}

	public function Excluir(){
		$id = $this->uri->segment(3);

		if(is_null($id))
			redirect();

		$status = $this->CategoriaModel->Excluir($id, 'categoria');

		if($status){
			$this->session->set_flashdata('success', '<p>Contato excluído com sucesso.</p>');
		}else{
			$this->session->set_flashdata('error', '<p>Não foi possível excluir o contato.</p>');
        }
		
		$this->Index();
	}

	private function Validar($operacao = 'insert'){
		switch($operacao){
			case 'insert':
				$rules['categoria'] = array('trim', 'required', 'min_length[3]', 'max_length[50]','is_unique[categorias.categoria]');
				break;
			case 'update':
				$rules['categoria'] = array('trim', 'required', 'min_length[3]', 'max_length[50]','is_unique[categorias.categoria]');
				break;
			default:
				$rules['categoria'] = array('trim', 'required', 'min_length[3]', 'max_length[50]','is_unique[categorias.categoria]');
				break;
		}
		$this->form_validation->set_rules('categoria', 'categoria', $rules['categoria']);
		return $this->form_validation->run();
	}



    
}
