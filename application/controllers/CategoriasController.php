<?php
class CategoriasController extends CI_Controller{
    public function index()
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
				$this->index();
			}
		}else{
			$this->session->set_flashdata('error', validation_errors('<p>','</p>'));
			$this->template->load('layout', 'categorias/cadastrar');
		}
	}

	public function Editar(){
		$id = $this->uri->segment(3);
		if(is_null($id))
			redirect();
		$dados['categoria'] = $this->CategoriaModel->GetById($id, 'categoria');
		$this->template->load('layout', 'categorias/alterar', $dados);
	}

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
                $this->index();
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
		
		$this->index();
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

	public function PegaDados() {
        $pegadados = $this->CategoriaModel->criar_datatable();
        $dados = array();
        foreach ($pegadados as $row) {
            $sub_dados = array();
            $sub_dados[] = $row->categoria;
            $sub_dados[] = "<a href='".base_url('categoria/alterar')."/".$row->id_categoria."' role='button' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span></a>";
            $sub_dados[] = "<a href='".base_url('categoria/excluir')."/".$row->id_categoria."' role='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></a>";
            $dados[] = $sub_dados;
        }
        
        $output = array (
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => $this->CategoriaModel->getAllData(), 
            "recordsFiltered" => $this->CategoriaModel->getFilteredData(),
            "data" => $dados
        );
        echo json_encode($output);
    }

    
}
