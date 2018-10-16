<?php
class MY_Controller extends CI_Controller{
    private $config;

    private function carregarLibrary(){
        $this->config['protocol'] = 'smtp';
        $this->config['validate'] = TRUE;
        $this->config['mailtype'] = 'html';
        $this->config['smtp_host'] = 'ssl://smtp.gmail.com';
        $this->config['smtp_user'] = 'testekbr@gmail.com';
        $this->config['smtp_pass'] = 'K,.b,.r,.tec123';
        $this->config['smtp_port'] = '465';
        $this->config['charset']   = 'utf-8';
        $this->config['newline']   = "\r\n";
    }
    
    public function EnviarEmailUsuario($email, $nome, $categoria, $subcategoria, $data, $imagem, $descricao) {
        $this->carregarLibrary();
        $this->email->initialize($this->config);
        $this->email->from('testekbr@gmail.com', 'KBRTEC-TESTES');
        $this->email->to($email, $nome);
        $this->email->subject('sucesso, segue seus dados');
        $this->email->attach($imagem);
        $imagemNoCorpo = $this->email->attachment_cid($imagem);
        $dados = [
                'nome' => $nome
            ,   'email' => $email
            ,   'data' => $data
            ,   'categoria' => $categoria
            ,   'subcategoria' => $subcategoria
            ,   'descricao' => $descricao
            ,   'imagem' => $imagemNoCorpo
            ,   
        ];
        $this->email->message($this->load->view('usuarios/email', $dados, TRUE));
        return $this->email->send(); 
    }
}