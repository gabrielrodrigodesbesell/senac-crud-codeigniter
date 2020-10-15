<?php

class MY_Controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('logado')!=true){
            $this->session->set_flashdata('mensagem','Realize o login primeiro');
            redirect(base_url('login'));
        }
        $this->_header();
    }
    public function __destruct()
    {
        $this->_footer();
    }
    public function _header(){
        $this->load->view('includes/header');
    }
    public function _footer(){
        ##faz a inclusão do arquivo do modo tradicional pois não tem mais acesso a CI_Controller
        require_once(APPPATH.'views/includes/footer.php');
    }
}