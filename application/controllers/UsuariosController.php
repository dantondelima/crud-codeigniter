<?php
class UsuariosController extends CI_Controller{
  
    function index(){
        /*carrega a view */
        $this->template->load('layout', 'inicio');
    }

    function Form(){
        /*carrega a view */
        $this->template->load('layout', 'usuarios/cadastrar');
    }

    
}
