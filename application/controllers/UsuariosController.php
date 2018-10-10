<?php
class UsuariosController extends CI_Controller{
  
    public function __construct(){
        parent::__construct();
        $this->load->library(['session','upload','image_lib']);
    }

    function index(){
        $this->template->load('layout', 'inicio');
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
                'desc' => $usuario['desc']
            ];
			
			$status = $this->UserModel->Inserir($post);
			if(!$status){
				$this->session->set_flashdata('error', 'Não foi possível inserir o contato.');
			}else{
				$this->session->set_flashdata('success', 'Contato inserido com sucesso.');
				$this->template->load('layout', 'inicio');			}
		}else{
			$this->session->set_flashdata('error', validation_errors('<p>','</p>'));
			return var_dump($usuario);
        }
    }

    public function Recortar(){
        $configUpload['upload_path']   = './uploads/';
        $configUpload['allowed_types'] = 'jpg|png';
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
            $configCrop['new_image']  = './uploads/crops/';
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
                $this->load->view('home',$data);
            }
            else
            {
                $urlImagem = base_url('uploads/crops/'.$dadosImagem['file_name']);
                unlink($dadosImagem['full_path']);
                return $urlImagem;
            }
        }
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');

        $this->ckeditor->basePath = base_url().'assets/ckeditor/';
        $this->ckeditor->config['toolbar'] = array(
                        array( 'Source', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
                                                            );
        $this->ckeditor->config['language'] = 'it';
        $this->ckeditor->config['width'] = '730px';
        $this->ckeditor->config['height'] = '200px';
        $this->ckfinder->SetupCKEditor($this->ckeditor,'assets/ckfinder/'); 
    }

    private function CalculaPercetual($dimensoes){
        // Verifica se a largura da imagem original é
        // maior que a da área de recorte, se for calcula o tamanho proporcional
        if($dimensoes['woriginal'] > $dimensoes['wvisualizacao']){
            $percentual = $dimensoes['woriginal'] / $dimensoes['wvisualizacao'];
 
            $dimensoes['x'] = round($dimensoes['x'] * $percentual);
            $dimensoes['y'] = round($dimensoes['y'] * $percentual);
            $dimensoes['wcrop'] = round($dimensoes['wcrop'] * $percentual);
            $dimensoes['hcrop'] = round($dimensoes['hcrop'] * $percentual);
        }
 
        // Retorna os valores a serem utilizados no processo de recorte da imagem
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
                $rules['email'] = array('trim', 'required', 'min_length[3]', 'max_length[100]','is_unique[users.email]');
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
        $this->form_validation->set_rules('email', 'E-mail', $rules['email']);
        $this->form_validation->set_rules('data_nasc', 'Data', $rules['data_nasc']);
        $this->form_validation->set_rules('categoria', 'Categoria', $rules['categoria']);
        $this->form_validation->set_rules('subcategoria', 'Subcategoria', $rules['subcategoria']);
		return $this->form_validation->run();
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
    
    
    
    */

}
