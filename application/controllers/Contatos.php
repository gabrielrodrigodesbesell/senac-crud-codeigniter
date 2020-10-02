<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contatos extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Contatos_model');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$data['contatos'] = $this->Contatos_model->get_all();
		$this->load->view('contatos/list',$data);
	}
	public function delete($id){
		if(!empty($id) && is_numeric($id)){
			$this->Contatos_model->delete(array('id'=>$id));
			$this->session->set_flashdata('mensagem','Contato removido com sucesso');
		}else{
			$this->session->set_flashdata('mensagem','Contato não encontrado');
		}
		redirect(base_url('contatos'));
	}
	public function create(){
		$data['titulo'] = 'Cadastrar contato';
		$data['id'] = '';
		$data['action'] = base_url('contatos/create_action');
		$data['nome'] = set_value('nome');
		$data['email'] = set_value('email');
		$this->load->view('contatos/form',$data);
	}
	public function create_action(){
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE){
			$this->cadastrar();
		}else{
			$insert = array(
				'nome'=>$this->input->post('nome'),
				'email'=>$this->input->post('email'),
			);
			if($this->Contatos_model->insert($insert)){
				$this->session->set_flashdata('mensagem','Contato cadastrado com sucesso');
			}else{
				$this->session->set_flashdata('mensagem','Falha ao cadastrar o contato');
			}
			redirect(base_url('contatos'));
		}
	}
	public function update($id){
		$contato = $this->Contatos_model->get_where(array('id'=>$id));
		if($contato){
			$data['titulo'] = 'Alterar contato';
			$data['id'] = $contato->id;
			$data['action'] = base_url('contatos/update_action/'.$contato->id);
			$data['nome'] = set_value('nome',$contato->nome);
			$data['email'] = set_value('email',$contato->email);
			$this->load->view('contatos/form',$data);
		}else{
			$this->session->set_flashdata('mensagem','Contato não encontrado.');
			redirect(base_url('contatos'));
		}
	}
	public function update_action($id){
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE){
			$this->alterar($id);
		}else{
			$update = array(
				'nome'=>$this->input->post('nome'),
				'email'=>$this->input->post('email'),
			);
			if($this->Contatos_model->update($id,$update)){
				$this->session->set_flashdata('mensagem','Contato alterar com sucesso');
			}else{
				$this->session->set_flashdata('mensagem','Falha ao alterar o contato');
			}
			redirect(base_url('contatos'));
		}
	}

}
