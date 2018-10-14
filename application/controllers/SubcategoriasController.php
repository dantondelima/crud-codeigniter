<?php
class SubcategoriasController extends CI_Controller{
  
    function index(){
        $subcategorias = $this->SubcategoriaModel->selectCategoria();
		$dados['subcategorias'] = $this->SubcategoriaModel->Formatar($subcategorias);
		$this->template->load('layout', 'subcategorias/listar', $dados);
    }

    public function Form() {
        $categorias = $this->CategoriaModel->GetAll('categoria');
		$dados['categorias'] = $this->CategoriaModel->Formatar($categorias);
        $this->template->load('layout', 'subcategorias/cadastrar', $dados);              
    }

    public function Salvar(){
		$validacao = self::Validar();

		if($validacao){
			$subcategoria = $this->input->post();
			$status = $this->SubcategoriaModel->Inserir($subcategoria);
			if(!$status){
				$this->session->set_flashdata('error', 'Não foi possível inserir o contato.');
			}else{
				$this->session->set_flashdata('success', 'Contato inserido com sucesso.');
				$this->template->load('layout', 'inicio');			}
		}else{
			$this->session->set_flashdata('error', validation_errors('<p>','</p>'));
        }
    }

    public function Editar(){
		$id = $this->uri->segment(3);
		if(is_null($id))
			redirect();

        $dados['subcategoria'] = $this->SubcategoriaModel->GetById($id, 'subcategoria');
        $categorias = $this->CategoriaModel->GetAll('categoria');
        $outros['categorias'] = $this->CategoriaModel->Formatar($categorias);
		$this->template->load('layout', 'subcategorias/alterar', $dados);
	}

    public function Atualizar(){
		// Realiza o processo de validação dos dados
        $validacao = self::Validar('update');
		if(!$validacao){
			// Recupera os dados do formulário
            $subcategoria = $this->input->post();
           
			// Atualiza os dados no banco recuperando o status dessa operação
            $status = $this->SubcategoriaModel->Atualizar($subcategoria['id_subcategoria'], $subcategoria, 'subcategoria');
			// Checa o status da operação gravando a mensagem na seção
			if(!$status){
				$dados['subcategoria'] = $this->SubcategoriaModel->GetById($subcategoria['id_subcategoria'], 'subcategoria');
                $this->session->set_flashdata('error', 'Não foi possível atualizar o contato.');
                $this->template->load('layout', 'subcategorias/alterar', $dados);
			}else{
				$this->session->set_flashdata('success', 'Contato atualizado com sucesso.');
                // Redireciona o usuário para a home
                $this->template->load('layout', 'inicio');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
            $this->template->load('layout', 'inicio');
		}
	}

    public function Excluir(){
		// Recupera o ID do registro - através da URL - a ser editado
		$id = $this->uri->segment(3);
		// Se não foi passado um ID, então redireciona para a home
		if(is_null($id))
			redirect();
		// Remove o registro do banco de dados recuperando o status dessa operação
		$status = $this->SubcategoriaModel->Excluir($id, 'subcategoria');
		// Checa o status da operação gravando a mensagem na seção
		if($status){
			$this->session->set_flashdata('success', '<p>Contato excluído com sucesso.</p>');
		}else{
			$this->session->set_flashdata('error', '<p>Não foi possível excluir o contato.</p>');
        }
        
        // Recupera os contatos através do model
		$this->Index();
    }
    
    public function Categoria(){
        $dados = $this->SubcategoriaModel->pegaCategoria();
        echo json_encode($dados);
    }

    private function Validar($operacao = 'insert'){
		switch($operacao){
			case 'insert':
				$rules['subcategoria'] = array('trim', 'required', 'min_length[3]');
				break;
			case 'update':
				$rules['subcategoria'] = array('trim', 'required', 'min_length[3]');
				break;
			default:
				$rules['subcategoria'] = array('trim', 'required', 'min_length[3]');
				break;
		}
		$this->form_validation->set_rules('subcategoria', 'subcategoria', $rules['subcategoria']);
		//$this->form_validation->set_rules('email', 'Email', $rules['email']);
		return $this->form_validation->run();
	}
}
