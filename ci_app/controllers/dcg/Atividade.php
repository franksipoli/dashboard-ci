<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atividade extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Atividade_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/

	private function validateGetId()
	{
		$atv = Atividade_model::getById($this->input->get('id'));
		if (!$atv){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','atividade','visualizar'));
			exit();
		}
		return $atv;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir atividade - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/atividade/inserir');
	}
	
	/**
	* Editar registro
	*/

	public function editar()
	{
		$atv = $this->validateGetId();
		$this->data['atividade'] = $atv;
		$this->title = "Editar atividade - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/atividade/inserir');
	}
	
	/**
	* Chamada ao controlador sem nenhum método
	*/

	public function index()
	{
		$this->visualizar();
	}

	/**
	* Lista de registros
	*/

	public function visualizar()
	{
		$this->title = "Visualizar atividades - Yoopay - Soluções Tecnológicas";
		$this->data['atividades'] = $this->Atividade_model->getAll();
		$this->loadview('dcg/atividade/lista');
	}
	
	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Atividade_model->descricao = $this->input->post('cdescriatv');
		if ($this->Atividade_model->validaInsercao()){
			$this->Atividade_model->save();
			$this->session->set_flashdata('sucesso','Atividade cadastrada com sucesso');
			redirect(makeUrl('dcg','atividade','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Atividade_model->error);
			$this->session->set_flashdata('cdescriatv',$this->Atividade_model->descricao);
			redirect(makeUrl('dcg','atividade','inserir'));
			return;
		}
	}
	
	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Atividade_model->id = $this->validateGetId()->nidtbxatv;
		$this->Atividade_model->descricao = $this->input->post('cdescriatv');
		if ($this->Atividade_model->validaAtualizacao()){
			$this->Atividade_model->save();
			$this->session->set_flashdata('sucesso','Atividade atualizada com sucesso');
			redirect(makeUrl('dcg','atividade','editar','?id='.$this->Atividade_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Atividade_model->error);
		$this->session->set_flashdata('cdescriatv',$this->Atividade_model->descricao);
		redirect(makeUrl('dcg','atividade','editar','?id='.$this->Atividade_model->id));
		return;
	}
	
	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Atividade_model->id = $this->validateGetId()->nidtbxatv;
		if ($this->Atividade_model->isAtivo()){
			$this->Atividade_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Atividade_model->delete();
			$this->session->set_flashdata('sucesso','Atividade desativada com sucesso');
			redirect(makeUrl('dcg','atividade','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Atividade_model->error);
		redirect(makeUrl('dcg','atividade','visualizar'));
	}

}