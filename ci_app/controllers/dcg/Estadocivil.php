<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadocivil extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Estadocivil_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/

	private function validateGetId()
	{
		$est = Estadocivil_model::getById($this->input->get('id'));
		if (!$est){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','estadocivil','visualizar'));
			exit();
		}
		return $est;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir estado civil - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/estadocivil/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$est = $this->validateGetId();
		$this->data['estadocivil'] = $est;
		$this->title = "Editar estado civil - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/estadocivil/inserir');
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
		$this->title = "Visualizar estados civis - Yoopay - Soluções Tecnológicas";
		$this->data['estadoscivis'] = $this->Estadocivil_model->getAll();
		$this->loadview('dcg/estadocivil/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Estadocivil_model->descricao = $this->input->post('cdescriest');
		if ($this->Estadocivil_model->validaInsercao()){
			$this->Estadocivil_model->save();
			$this->session->set_flashdata('sucesso','Estado civil cadastrado com sucesso');
			redirect(makeUrl('dcg','estadocivil','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Estadocivil_model->error);
			$this->session->set_flashdata('cdescriest',$this->Estadocivil_model->descricao);
			redirect(makeUrl('dcg','estadocivil','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Estadocivil_model->id = $this->validateGetId()->nidtbxest;
		$this->Estadocivil_model->descricao = $this->input->post('cdescriest');
		if ($this->Estadocivil_model->validaAtualizacao()){
			$this->Estadocivil_model->save();
			$this->session->set_flashdata('sucesso','Estado civil atualizado com sucesso');
			redirect(makeUrl('dcg','estadocivil','editar','?id='.$this->Estadocivil_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Estadocivil_model->error);
		$this->session->set_flashdata('cdescriest',$this->Estadocivil_model->descricao);
		redirect(makeUrl('dcg','estadocivil','editar','?id='.$this->Estadocivil_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Estadocivil_model->id = $this->validateGetId()->nidtbxest;
		if ($this->Estadocivil_model->isAtivo()){
			$this->Estadocivil_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Estadocivil_model->delete();
			$this->session->set_flashdata('sucesso','Estado civil desativado com sucesso');
			redirect(makeUrl('dcg','estadocivil','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Estadocivil_model->error);
		redirect(makeUrl('dcg','estadocivil','visualizar'));
	}
	
}