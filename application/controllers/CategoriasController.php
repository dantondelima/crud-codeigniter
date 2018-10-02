<?php
class CategoriasController extends CI_Controller{
  
    /*function index(){
        $categorias = $this->CategoriaModel->GetAll('categoria');
        $dados = array("categorias" => $categorias);
		$this->template->load('layout', 'categorias/listar', $dados);
    }*/

    public function Index()
	{
		// Recupera os contatos através do model
		$categorias = $this->CategoriaModel->GetAll('categoria');
		// Passa os contatos para o array que será enviado à home
		$dados['categorias'] =$this->CategoriaModel->Formatar($categorias);
		// Chama a home enviando um array de dados a serem exibidos
		$this->template->load('layout', 'categorias/listar', $dados);
    }
    
    public function Form() {
        $this->template->load('layout', 'categorias/cadastrar');              
    }
	/**
     * Processa o formulário para salvar os dados
     */
	public function Salvar(){
		// Recupera os contatos através do model
		$categorias = $this->CategoriaModel->GetAll('categoria');
		// Passa os contatos para o array que será enviado à home
		$dados['categorias'] =$this->CategoriaModel->Formatar($categorias);
		// Executa o processo de validação do formulário
		//$validacao = self::Validar();

		//if($validacao){
			// Recupera os dados do formulário
			$categoria = $this->input->post();
			// Insere os dados no banco recuperando o status dessa operação
			$status = $this->CategoriaModel->Inserir($categoria);
			// Checa o status da operação gravando a mensagem na seção
			if(!$status){
				$this->session->set_flashdata('error', 'Não foi possível inserir o contato.');
			}else{
				$this->session->set_flashdata('success', 'Contato inserido com sucesso.');
				// Redireciona o usuário para a home
			}
		/*}else{
			$this->session->set_flashdata('error', validation_errors('<p>','</p>'));
        }*/
		// Carrega a home
		$this->template->load('layout', 'categorias/listar',$dados);
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
		// Realiza o processo de validação dos dados
        $validacao = self::Validar('update');
		if(!$validacao){
			// Recupera os dados do formulário
            $categoria = $this->input->post();
           
			// Atualiza os dados no banco recuperando o status dessa operação
            $status = $this->CategoriaModel->Atualizar($categoria['id_categoria'], $categoria, 'categoria');
			// Checa o status da operação gravando a mensagem na seção
			if(!$status){
				$dados['categoria'] = $this->CategoriaModel->GetById($categoria['id_categoria'], 'categoria');
                $this->session->set_flashdata('error', 'Não foi possível atualizar o contato.');
                $this->template->load('layout', 'categorias/alterar', $dados);
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
	/**
     * Realiza o processo de exclusão dos dados
     */
	public function Excluir(){
		// Recupera o ID do registro - através da URL - a ser editado
		$id = $this->uri->segment(3);
		// Se não foi passado um ID, então redireciona para a home
		if(is_null($id))
			redirect();
		// Remove o registro do banco de dados recuperando o status dessa operação
		$status = $this->CategoriaModel->Excluir($id, 'categoria');
		// Checa o status da operação gravando a mensagem na seção
		if($status){
			$this->session->set_flashdata('success', '<p>Contato excluído com sucesso.</p>');
		}else{
			$this->session->set_flashdata('error', '<p>Não foi possível excluir o contato.</p>');
        }
        
        // Recupera os contatos através do model
		$this->Index();
	}
	/**
	* Valida os dados do formulário
	*
	* @param string $operacao Operação realizada no formulário: insert ou update
	*
	* @return boolean
	*/
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
