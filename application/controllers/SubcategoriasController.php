<?php
class SubcategoriasController extends CI_Controller{
  
    function index(){
        // Recupera os contatos através do model
        $subcategorias = $this->SubcategoriaModel->selectCategoria();
		// Passa os contatos para o array que será enviado à home
		$dados['subcategorias'] = $this->SubcategoriaModel->Formatar($subcategorias);
		// Chama a home enviando um array de dados a serem exibidos
		$this->template->load('layout', 'subcategorias/listar', $dados);
    }

    public function Form() {
        $categorias = $this->CategoriaModel->GetAll('categoria');
		// Passa os contatos para o array que será enviado à home
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
			return var_dump($subcategoria);
        }
    }

    public function Editar(){
		// Recupera o ID do registro - através da URL - a ser editado
		$id = $this->uri->segment(3);
		// Se não foi passado um ID, então redireciona para a home
		if(is_null($id))
			redirect();
		// Recupera os dados do registro a ser editado
        $dados['subcategoria'] = $this->SubcategoriaModel->GetById($id, 'subcategoria');
        $categorias = $this->CategoriaModel->GetAll('categoria');
        $outros['categorias'] = $this->CategoriaModel->Formatar($categorias);
		// Carrega a view passando os dados do registro
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
		// Com base no parâmetro passado
		// determina as regras de validação
		switch($operacao){
			case 'insert':
				$rules['nome'] = array('trim', 'required', 'min_length[3]');
				//$rules['email'] = array('trim', 'required', 'valid_email', 'is_unique[contatos.email]');
				break;
			case 'update':
				$rules['nome'] = array('trim', 'required', 'min_length[3]');
				//$rules['email'] = array('trim', 'required', 'valid_email');
				break;
			default:
				$rules['nome'] = array('trim', 'required', 'min_length[3]');
				//$rules['email'] = array('trim', 'required', 'valid_email', 'is_unique[contatos.email]');
				break;
		}
		$this->form_validation->set_rules('nome', 'Nome', $rules['nome']);
		//$this->form_validation->set_rules('email', 'Email', $rules['email']);
		// Executa a validação e retorna o status
		return $this->form_validation->run();
	}
}
