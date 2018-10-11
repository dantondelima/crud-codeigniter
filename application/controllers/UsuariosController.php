<?php
class UsuariosController extends CI_Controller{
  
    public function __construct(){
        parent::__construct();
        $this->load->library(['session','upload','image_lib']);
    }

    function index(){
        $usuarios = $this->UserModel->GetAll('nome');
		$dados['usuarios'] = $this->UserModel->Formatar($usuarios);
        $this->template->load('layout', 'usuarios/listar', $dados);
    }
    
    function Form(){
        $this->template->load('layout', 'usuarios/cadastrar');
    }

    public function Subcategoria(){
        $id = $this->uri->segment(3);
        $dados = $this->UserModel->selectSubcategoria($id);
        echo json_encode($dados);
    }
    
    public function Salvar(){
        $validacao = self::Validar();
        $usuario = $this->input->post();
		if($validacao){
             $post = [
                'nome' => $usuario['nome'],
                'email' => $usuario['email'],
                'data_nasc' => $usuario['data_nasc'],
                'categoria' => $usuario['categoria'],
                'subcategoria' => $usuario['subcategoria'],
                'imagem' => $this->Recortar(),
                'descricao' => $usuario['desc']
            ];
			
			$status = $this->UserModel->Inserir($post);
			if(!$status){
				$this->session->set_flashdata('error', 'Não foi possível inserir o contato.');
			}else{
				$this->session->set_flashdata('success', 'Contato inserido com sucesso.');
                $this->template->load('layout', 'inicio');			
            }
		}else{
            $this->session->set_flashdata('error', validation_errors('<p>','</p>'));
            var_dump($this);
			$this->template->load('layout', 'inicio');
        }
    }

    public function Editar(){
		$id = $this->uri->segment(3);
		if(is_null($id))
            redirect();
        $dados['usuario'] = $this->UserModel->GetById($id, 'usuario');
		$this->template->load('layout', 'usuarios/alterar', $dados);
	}

    public function Atualizar(){
		$validacao = self::Validar('update');
		if($validacao){
			$usuario = $this->input->post();
            $status = $this->UserModel->Atualizar($usuario['id_usuario'], $usuario, 'usuario');
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
        }
	}

    public function Recortar(){
        $configUpload['upload_path']   = './assets/uploads/';
        $configUpload['allowed_types'] = 'jpg|png|jpeg';
        $configUpload['encrypt_name']  = TRUE;
 
        $this->upload->initialize($configUpload);

        if ( !$this->upload->do_upload('imagem'))
        {
            return $data= array('error' => $this->upload->display_errors());
        }
        else
        {
            $dadosImagem = $this->upload->data();
            $tamanhos = $this->CalculaPercetual($this->input->post());
            $configCrop['image_library'] = 'gd2';
            $configCrop['source_image']  = $dadosImagem['full_path'];
            $configCrop['new_image']  = './assets/uploads/crops/';
            $configCrop['maintain_ratio']= FALSE;
            $configCrop['quality'] = 100;
            $configCrop['width']  = $tamanhos['wcrop'];
            $configCrop['height'] = $tamanhos['hcrop'];
            $configCrop['x_axis'] = $tamanhos['x'];
            $configCrop['y_axis'] = $tamanhos['y'];
            $this->image_lib->initialize($configCrop);
            if ( ! $this->image_lib->crop())
            {
                $data = array('error' => $this->image_lib->display_errors());
            }
            else
            {
                $urlImagem = base_url('uploads/crops/'.$dadosImagem['file_name']);
                unlink($dadosImagem['full_path']);
                return $urlImagem;
            }
        }
        
    }

    public function PegaDados(){
        $pegadados = $this->UserModel->criar_datatable();
        $dados = array();
        foreach ($pegadados as $row) {
            $sub_dados = array();
            $sub_dados[] = $row->id_usuario;
            $sub_dados[] = $row->nome;
            $sub_dados[] = $row->email;
            $sub_dados[] = $row->data_nasc;
            $sub_dados[] = $row->subcategoria;
            $sub_dados[] = $row->categoria;
            $sub_dados[] = "<img src='".$row->imagem."' style='height:100px;width:100px;'/>";
            $sub_dados[] = "<a href='".base_url('usuario/editar')."/".$row->id_usuario."' role='button' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span></a>";
            $sub_dados[] = "<a href='".base_url('usuario/excluir')."/".$row->id_usuario."' role='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></a>";
            $dados[] = $sub_dados;
        }
        $output = array (
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => $this->UserModel->getAllData(), 
            "recordsFiltered" => $this->UserModel->getFilteredData(),
            "data" => $dados
        );
        echo json_encode($output);    
    }

    private function CalculaPercetual($dimensoes){
        if($dimensoes['woriginal'] > $dimensoes['wvisualizacao']){
            $percentual = $dimensoes['woriginal'] / $dimensoes['wvisualizacao'];
            $dimensoes['x'] = round($dimensoes['x'] * $percentual);
            $dimensoes['y'] = round($dimensoes['y'] * $percentual);
            $dimensoes['wcrop'] = round($dimensoes['wcrop'] * $percentual);
            $dimensoes['hcrop'] = round($dimensoes['hcrop'] * $percentual);
        }
        return $dimensoes;
    }

    private function Validar($operacao = 'insert'){
		switch($operacao){
			case 'insert':
                $rules['nome'] = array('trim', 'required', 'min_length[3]', 'max_length[100]');
                $rules['email'] = array('trim', 'required', 'min_length[3]', 'max_length[100]','is_unique[users.email]');
                $rules['data_nasc'] = array('trim', 'required', 'min_length[3]', 'max_length[20]');
                $rules['categoria'] = array('trim', 'required');
                $rules['subcategoria'] = array('trim', 'required');
                $rules['subcategoria'] = array('trim', 'required');
				break;
			case 'update':
                $rules['nome'] = array('trim', 'required', 'min_length[3]', 'max_length[100]');
                $rules['data_nasc'] = array('trim', 'required', 'min_length[3]', 'max_length[20]');
                $rules['categoria'] = array('trim', 'required');
                $rules['subcategoria'] = array('trim', 'required');
                break;
			default:
                $rules['nome'] = array('trim', 'required', 'min_length[3]', 'max_length[100]');
                $rules['email'] = array('trim', 'required', 'min_length[3]', 'max_length[100]','is_unique[users.email]');
                $rules['data_nasc'] = array('trim', 'required', 'min_length[3]', 'max_length[20]');
                $rules['categoria'] = array('trim', 'required');
                $rules['subcategoria'] = array('trim', 'required');
                break;
		}
        $this->form_validation->set_rules('nome', 'Usuario', $rules['nome']);
        if($operacao == 'insert')
            $this->form_validation->set_rules('email', 'E-mail', $rules['email']);

        $this->form_validation->set_rules('data_nasc', 'Data', $rules['data_nasc']);
        $this->form_validation->set_rules('categoria', 'Categoria', $rules['categoria']);
        $this->form_validation->set_rules('subcategoria', 'Subcategoria', $rules['subcategoria']);
		return $this->form_validation->run();
    }
    
    public function Excluir(){
		$id = $this->uri->segment(3);
		if(is_null($id))
			redirect();
		$status = $this->UserModel->Excluir($id, 'usuario');
		if($status){
			$this->session->set_flashdata('success', '<p>Contato excluído com sucesso.</p>');
		}else{
			$this->session->set_flashdata('error', '<p>Não foi possível excluir o contato.</p>');
        }
        $this->index();
    }

    /*public function PegaDados(){
        $pegadados = $this->user_model->criar_datatable();
        $dados = array();
        foreach ($pegadados as $row) {
            $sub_dados = array();
            $sub_dados[] = $row->usuario_id;
            $sub_dados[] = $row->usuario_nome;
            $sub_dados[] = $row->usuario_email;
            $sub_dados[] = $row->usuario_data;
            $sub_dados[] = $row->subcategoria_nome;
            $sub_dados[] = $row->categoria_nome;
            $sub_dados[] = "<a href='".base_url('usuario/editar')."/".$row->usuario_id."' role='button' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span></a>";
            $sub_dados[] = "<a href='".base_url('usuario/excluir')."/".$row->usuario_id."' role='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></a>";
            $dados[] = $sub_dados;
        }
        
        $output = array (
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => $this->user_model->getAllData(), 
            "recordsFiltered" => $this->user_model->getFilteredData(),
            "data" => $dados
        );
        echo json_encode($output);
    }
    
    public function Atualizar(){
            $urlImagem = $this->Recortar();
                if ($urlImagem != NULL) {
                    unlink(substr($this->input->post('post_foto_antiga'), 35));
                }
                else 
                {
                    $urlImagem = $this->input->post("post_foto_antiga");
                }
            $validacao = self::Validar('update');
                $post = [
                   'usuario_fk' => $this->input->post('usuario_fk'), 
                   'post_titulo' => $this->input->post('post_titulo'), 
                   'post_conteudo' => $this->input->post('post_titulo'), 
                   'post_foto' => $urlImagem
                ];
                $id = intval($this->input->post('post_id'));
                if($validacao){
                    $status = $this->posts_model->Atualizar($id, $post, 'post');
                    if(!$status){
                        $dados['post'] = $this->posts_model->GetIdJoin($id, 'post');
                        $this->session->set_flashdata('error', 'Não foi possível atualizar o Post.');
                        $this->template->load('template', 'posts/form-alteracao', $dados);
                    }else{
                        $this->session->set_flashdata('success', 'Post atualizado com sucesso.');
                        $dados = $this->posts_model->GetByTitulo($post['post_titulo']);
                        $this->EnviarEmailPosts($dados['usuario_nome'], $dados['usuario_email'], $dados['post_conteudo'], $dados['post_titulo'], $dados['post_foto'], 'Post atualizado com sucesso');
                        redirect(base_url('posts'));
                    }
                }else{
                    $dados['post'] = $this->posts_model->GetIdJoin($id, 'post');
                    $this->session->set_flashdata('error', validation_errors());
                    $this->template->load('template', 'posts/form-alteracao', $dados);
                }
            }
    
    */

}
