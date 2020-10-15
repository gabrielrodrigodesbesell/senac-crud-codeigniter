<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contatos extends MY_Controller {
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
		    $contato = $this->Contatos_model->get_where(array('id'=>$id));
		    if($contato) {
		        unlink('uploads/contatos/'.$contato->arquivo);
                $this->Contatos_model->delete(array('id' => $id));
                $this->session->set_flashdata('mensagem', 'Contato removido com sucesso');
            }else{
                $this->session->set_flashdata('mensagem', 'Contato não existe.');
            }
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
		$this->_validationRules();
		if ($this->form_validation->run() == FALSE){
			$this->create();
		}else{
			$insert = array(
				'nome'=>$this->input->post('nome'),
				'email'=>$this->input->post('email'),
			);
			$contato = $this->Contatos_model->insert($insert);
			if($contato){
               $this->_configsUpload();
                if (!$this->upload->do_upload('arquivo')){
                    $this->session->set_flashdata('mensagem',$this->upload->display_errors());
                    redirect(base_url('contatos'));
                    exit();
                }else{
                  $upload = $this->upload->data();
                  $this->Contatos_model->update($contato,array('arquivo'=>$upload['file_name']));
                }
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
			$data['arquivo'] = $contato->arquivo;
			$this->load->view('contatos/form',$data);
		}else{
			$this->session->set_flashdata('mensagem','Contato não encontrado.');
			redirect(base_url('contatos'));
		}
	}
	public function update_action($id){
        $this->_validationRules();
		if ($this->form_validation->run() == FALSE){
			$this->update($id);
		}else{
            $arquivo = $this->input->post('arquivo_aux');
			if($_FILES['arquivo']['name']){
                $config = $this->_configsUpload();
                if (!$this->upload->do_upload('arquivo')){
                    $this->session->set_flashdata('mensagem',$this->upload->display_errors());
                    redirect(base_url('contatos'));
                    exit();
                }else{
                    unlink($config['upload_path'].$arquivo);
                    $upload = $this->upload->data();
                    $arquivo = $upload['file_name'];
                }
            }
            $update = array(
                'nome'=>$this->input->post('nome'),
                'email'=>$this->input->post('email'),
                'arquivo'=>$arquivo,
            );
			if($this->Contatos_model->update($id,$update)){
				$this->session->set_flashdata('mensagem','Contato alterar com sucesso');
			}else{
				$this->session->set_flashdata('mensagem','Falha ao alterar o contato');
			}
			redirect(base_url('contatos'));
		}
	}
    final function _configsUpload(){
        $config['upload_path']          = './uploads/contatos/';
        @mkdir($config['upload_path']);
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 2048;
        $config['max_width']            = 2048;
        $config['max_height']           = 2048;
        $config['encrypt_name']         = true;
        $this->load->library('upload', $config);
        return $config;
    }
    final function _validationRules(){
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    }
}
