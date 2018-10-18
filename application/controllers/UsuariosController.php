<?php
class UsuariosController extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library(['session','upload','image_lib']);
        $this->load->library('CKEditor');
        $this->load->library('CKFinder');
        $this->ckeditor->basePath = base_url().'assets/ckeditor/';
        $this->ckeditor->config['language'] = 'pt';
        $this->ckeditor->config['width'] = '950px';
        $this->ckeditor->config['height'] = '100px'; 
        $this->ckfinder->SetupCKEditor($this->ckeditor,'/assets/ckfinder/');
    }

    function index(){
        $usuarios = $this->UserModel->GetAllJoin('nome');
        $dados['usuarios'] = $this->UserModel->Formatar($usuarios);
        $this->template->load('layout', 'usuarios/listar', $dados);
    }

    function Form(){
        $this->template->load('layout', 'usuarios/cadastrar');
    }

    public function Categoria(){
        $dados = $this->SubcategoriaModel->pegaCategoria();
        echo json_encode($dados);
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
                'categoria_fk' => $usuario['categoria'],
                'subcategoria_fk' => $usuario['subcategoria'],
                'imagem' => $this->Recortar(),
                'descricao' => $usuario['desc']
            ];
			
			$status = $this->UserModel->Inserir($post);
			if(!$status){
				$this->session->set_flashdata('error', 'Não foi possível inserir o contato.');
			}else{
                $this->session->set_flashdata('success', 'Usuario inserido com sucesso.');
                $dados = $this->UserModel->GetByEmail($usuario['email']);
                $hora = date('d-m-Y');
                $hora .= ' '.date('H:i:s');
                $this->EnviarEmailUsuario($dados['email'], $dados['nome'], $dados['categoria'], $dados['subcategoria'], $dados['data_nasc'], $dados['imagem'], $dados['descricao'], $hora);			
                $this->index(); 
            }
		}else{
            $this->session->set_flashdata('error', validation_errors('<p>','</p>'));
			$this->template->load('layout', 'usuarios/cadastrar');
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
        $usuario = $this->input->post();
        $post = [
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'data_nasc' => $usuario['data_nasc'],
            'categoria_fk' => $usuario['categoria'],
            'subcategoria_fk' => $usuario['subcategoria'],
            'imagem' => $this->Recortar(),
            'descricao' => $usuario['desc']
        ];
		if($validacao){
            $status = $this->UserModel->Atualizar($usuario['id_usuario'], $post, 'usuario');
			if(!$status){
				$dados['usuario'] = $this->UserModel->GetById($usuario['id_usuario'], 'usuario');
                $this->session->set_flashdata('error', 'Não foi possível atualizar o registro.');
                $this->template->load('layout', 'usuarios/alterar', $dados);
			}else{
				$this->session->set_flashdata('success', 'A alteração foi efetuada com sucesso.');
                $dados = $this->UserModel->GetByEmail($usuario['email']);
                $hora = date('d-m-Y');
                $hora .= ' '.date('H:i:s');
                $this->EnviarEmailUsuario($dados['email'], $dados['nome'], $dados['categoria'], $dados['subcategoria'], $dados['data_nasc'], $dados['imagem'], $dados['descricao'], $hora);                $this->index();
                $this->index(); 
            }
		}else{
            $dados['usuario'] = $this->UserModel->GetById($usuario['id_usuario'], 'usuario');
            $this->session->set_flashdata('error', validation_errors());
            $this->template->load('layout', 'usuarios/alterar', $dados);
        }
	}

    public function Recortar(){
        $configUpload['upload_path']   = './assets/uploads/';
        $configUpload['allowed_types'] = 'jpg|png|jpeg';
        $configUpload['encrypt_name']  = TRUE;
 
        $this->upload->initialize($configUpload);

        if ( !$this->upload->do_upload('imagem'))
        {
            $data= array('error' => $this->upload->display_errors());
            var_dump($data);
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
                $urlImagem = base_url('assets/uploads/crops/'.$dadosImagem['file_name']);
                unlink($dadosImagem['full_path']);
                return $urlImagem;
            }
        }
        
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
			$this->session->set_flashdata('success', '<p>Registro excluído com sucesso.</p>');
		}else{
			$this->session->set_flashdata('error', '<p>Não foi possível excluir o registro.</p>');
        }

        $this->index();
    }

    public function PegaDados(){
        $pegadados = $this->UserModel->criar_datatable();
        $dados = array();
        foreach ($pegadados as $row) {
            $sub_dados = array();
            $sub_dados[] = $row->nome;
            $sub_dados[] = $row->email;
            $sub_dados[] = $row->data_nasc;
            $sub_dados[] = $row->categoria;
            $sub_dados[] = $row->subcategoria;
            $sub_dados[] = "<img src='".$row->imagem."' style='height:50px;width:50px;'/>";
            $sub_dados[] = "<a href='".base_url('usuario/alterar')."/".$row->id_usuario."' role='button' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span></a>";
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

}
