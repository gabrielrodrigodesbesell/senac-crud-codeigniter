<?php

class Login extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Login_model');
    }

    public function index(){
        $this->load->view('login');
    }

    public function action(){
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('senha', 'senha', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            $where = array(
                'email'=>$this->input->post('email'),
                'senha'=>$this->input->post('senha')
            );
            $busca = $this->Login_model->get($where);
            if($busca){
                $sessao = array('logado'=>true,'nome'=>$busca->nome);
                $this->session->set_userdata($sessao);
                redirect(base_url('contatos'));
            }else{
                $this->session->set_flashdata('mensagem','Login inválido');
                redirect(base_url('login'));
            }
        }
    }

    public function logout(){
        session_destroy();
        redirect(base_url('login'));
    }
}