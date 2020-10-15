<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cursos extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cursos_model');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$data['cursos'] = $this->Cursos_model->get_all();
		$this->load->view('cursos/list',$data);
	}
	public function delete($id){
		if(!empty($id) && is_numeric($id)){
		    $curso = $this->Cursos_model->get_where(array('id'=>$id));
		    if($curso) {
		        unlink('uploads/cursos/'.$curso->imagem);
                $this->Cursos_model->delete(array('id' => $id));
                $this->session->set_flashdata('mensagem', 'Curso removido com sucesso');
            }else{
                $this->session->set_flashdata('mensagem', 'Curso não existe.');
            }
		}else{
			$this->session->set_flashdata('mensagem','Curso não encontrado');
		}
		redirect(base_url('cursos'));
	}
	public function create(){
		$data['title'] = 'Cadastrar curso';
		$data['id'] = '';
		$data['action'] = base_url('cursos/create_action');
		$data['titulo'] = set_value('titulo');
		$data['tipo'] = set_value('tipo');
		$data['descricao'] = set_value('descricao');
		$this->load->view('cursos/form',$data);
	}
	public function create_action(){
		$this->_validationRules();
		if ($this->form_validation->run() == FALSE){
			$this->create();
		}else{
			$insert = array(
				'titulo'=>$this->input->post('titulo'),
				'descricao'=>$this->input->post('descricao'),
				'tipo'=>$this->input->post('tipo'),
			);
			$curso = $this->Cursos_model->insert($insert);
			if($curso){
               $this->_configsUpload();
                if (!$this->upload->do_upload('imagem')){
                    $this->session->set_flashdata('mensagem',$this->upload->display_errors());
                    redirect(base_url('cursos'));
                    exit();
                }else{
                  $upload = $this->upload->data();
                  $this->Cursos_model->update($curso,array('imagem'=>$upload['file_name']));
                }
          		$this->session->set_flashdata('mensagem','Curso cadastrado com sucesso');
			}else{
				$this->session->set_flashdata('mensagem','Falha ao cadastrar o curso');
			}
			redirect(base_url('cursos'));
		}
	}
	public function update($id){
		$curso = $this->Cursos_model->get_where(array('id'=>$id));
		if($curso){
			$data['title'] = 'Alterar curso';
			$data['id'] = $curso->id;
			$data['action'] = base_url('cursos/update_action/'.$curso->id);
			$data['titulo'] = set_value('titulo',$curso->titulo);
			$data['tipo'] = $curso->tipo;
			$data['descricao'] = set_value('descricao',$curso->descricao);
			$data['imagem'] = $curso->imagem;
			$this->load->view('cursos/form',$data);
		}else{
			$this->session->set_flashdata('mensagem','Curso não encontrado.');
			redirect(base_url('cursos'));
		}
	}
	public function update_action($id){
        $this->_validationRules();
		if ($this->form_validation->run() == FALSE){
			$this->update($id);
		}else{
            $imagem = $this->input->post('imagem_aux');
			if($_FILES['imagem']['name']){
                $config = $this->_configsUpload();
                if (!$this->upload->do_upload('imagem')){
                    $this->session->set_flashdata('mensagem',$this->upload->display_errors());
                    redirect(base_url('cursos'));
                    exit();
                }else{
                    unlink($config['upload_path'].$imagem);
                    $upload = $this->upload->data();
                    $imagem = $upload['file_name'];
                }
            }
            $update = array(
                'titulo'=>$this->input->post('titulo'),
                'descricao'=>$this->input->post('descricao'),
                'tipo'=>$this->input->post('tipo'),
                'imagem'=>$imagem,
            );
			if($this->Cursos_model->update($id,$update)){
				$this->session->set_flashdata('mensagem','Curso alterar com sucesso');
			}else{
				$this->session->set_flashdata('mensagem','Falha ao alterar o curso');
			}
			redirect(base_url('cursos'));
		}
	}
    final function _configsUpload(){
        $config['upload_path']          = './uploads/cursos/';
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
        $this->form_validation->set_rules('titulo', 'Título', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $this->form_validation->set_rules('descricao', 'Descrição', 'required');
    }
}
