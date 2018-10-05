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
            // Recupera os dados da imagem
            $dadosImagem = $this->upload->data();
 
            // Calcula os tamanhos de ponto de corte e posição
            // de forma proporcional em relação ao tamanho da
            // imagem original
            $tamanhos = $this->CalculaPercetual($this->input->post());
 
            // Define as configurações para o recorte da imagem
            // Biblioteca a ser utilizada
            $configCrop['image_library'] = 'gd2';
            //Path da imagem a ser recortada
            $configCrop['source_image']  = $dadosImagem['full_path'];
            // Diretório onde a imagem recortada será gravada
            $configCrop['new_image']  = './uploads/crops/';
            // Proporção
            $configCrop['maintain_ratio']= FALSE;
            // Qualidade da imagem
            $configCrop['quality']             = 100;
            // Tamanho do recorte
            $configCrop['width']  = $tamanhos['wcrop'];
            $configCrop['height'] = $tamanhos['hcrop'];
            // Ponto de corte (eixos x e y)
            $configCrop['x_axis']        = $tamanhos['x'];
            $configCrop['y_axis']        = $tamanhos['y'];
 
            // Aplica as configurações para a library image_lib
            $this->image_lib->initialize($configCrop);
 
            // Verifica se o recorte foi efetuado ou não
            // Em caso de erro carrega a home exibindo as mensagens
            // Em caso de sucesso envia o usuário para a tela
            // de visualização do recorte
            if ( ! $this->image_lib->crop())
            {
                // Recupera as mensagens de erro e envia o usuário para a home
                $data = array('error' => $this->image_lib->display_errors());
                $this->load->view('home',$data);
            }
            else
            {
                // Define a URL da imagem gerada após o recorte
                $urlImagem = base_url('uploads/crops/'.$dadosImagem['file_name']);
 
                // Grava a informação na sessão
                $this->session->set_flashdata('urlImagem', $urlImagem);
 
                // Grava os dados da imagem recortada na sessão
                $this->session->set_flashdata('dadosImagem', $dadosImagem);
 
                // Grava os dados da imagem original na sessão
                $this->session->set_flashdata('dadosCrop', $tamanhos);
 
                // Redireciona o usuário para a tela de visualização dos dados
                redirect('visualizacao');
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
        $this->ckeditor->config['height'] = '300px';

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
