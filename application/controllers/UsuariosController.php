<?php
class UsuariosController extends CI_Controller{
  
    public function __construct(){
        parent::__construct();
        // Carrega as libraries necessárias: session, upload e image_lib
        $this->load->library(['session','upload','image_lib']);
    }

    function index(){
        /*carrega a view */
        $this->template->load('layout', 'inicio');
        
    }

    function Form(){
        /*carrega a view */
        $this->template->load('layout', 'usuarios/cadastrar');
    }

    public function Subcategoria(){
        $id = $this->uri->segment(3);
        $dados = $this->UserModel->selectSubcategoria($id);
        echo json_encode($dados);
    }
    
    public function Salvar(){
		$validacao = self::Validar();
		if($validacao){
			$uuario = $this->input->post();
			$status = $this->UserModel->Inserir($usuario);
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
        // Tipos de imagem permitidos
        $configUpload['allowed_types'] = 'jpg|png';
        // Usar nome de arquivo aleatório, ignorando o nome original do arquivo
        $configUpload['encrypt_name']  = TRUE;
 
        // Aplica as configurações para a library upload
        $this->upload->initialize($configUpload);

        if ( !$this->upload->do_upload('imagem'))
        {
            // Recupera as mensagens de erro e envia o usuário para a home
            $data= array('error' => $this->upload->display_errors());
            $this->template->load('layout', 'teste', $data);
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
                $this->template->load('layout', 'teste');
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
    

    public function Visualizacao() {
        $this->template->load('layout', 'visualizacao');
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

}
