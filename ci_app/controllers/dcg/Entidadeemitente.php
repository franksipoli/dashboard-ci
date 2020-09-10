<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entidadeemitente extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Entidadeemitente_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/

	private function validateGetId()
	{
		$emi = Entidadeemitente_model::getById($this->input->get('id'));
		if (!$emi){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','entidadeemitente','visualizar'));
			exit();
		}
		return $emi;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir entidade emitente - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/entidadeemitente/inserir');
	}
	
	/**
	* Editar registro
	*/

	public function editar()
	{
		$emi = $this->validateGetId();
		$this->data['entidadeemitente'] = $emi;
		$this->title = "Editar entidade emitente - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/entidadeemitente/inserir');
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
		$this->title = "Visualizar entidades emitentes - Yoopay - Soluções Tecnológicas";
		$this->data['entidadesemitentes'] = $this->Entidadeemitente_model->getAll();
		$this->loadview('dcg/entidadeemitente/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Entidadeemitente_model->descricao = $this->input->post('cdescriemi');
		if ($this->Entidadeemitente_model->validaInsercao()){
			$this->Entidadeemitente_model->save();
			$this->session->set_flashdata('sucesso','Entidade emitente cadastrada com sucesso');
			redirect(makeUrl('dcg','entidadeemitente','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Entidadeemitente_model->error);
			$this->session->set_flashdata('cdescriemi',$this->Entidadeemitente_model->descricao);
			redirect(makeUrl('dcg','entidadeemitente','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Entidadeemitente_model->id = $this->validateGetId()->nidtbxemi;
		$this->Entidadeemitente_model->descricao = $this->input->post('cdescriemi');
		if ($this->Entidadeemitente_model->validaAtualizacao()){
			$this->Entidadeemitente_model->save();
			$this->session->set_flashdata('sucesso','Entidade emitente atualizada com sucesso');
			redirect(makeUrl('dcg','entidadeemitente','editar','?id='.$this->Entidadeemitente_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Entidadeemitente_model->error);
		$this->session->set_flashdata('cdescriemi',$this->Entidadeemitente_model->descricao);
		redirect(makeUrl('dcg','entidadeemitente','editar','?id='.$this->Entidadeemitente_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Entidadeemitente_model->id = $this->validateGetId()->nidtbxemi;
		if ($this->Entidadeemitente_model->isAtivo()){
			$this->Entidadeemitente_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Entidadeemitente_model->delete();
			$this->session->set_flashdata('sucesso','Entidade emitente desativada com sucesso');
			redirect(makeUrl('dcg','entidadeemitente','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Entidadeemitente_model->error);
		redirect(makeUrl('dcg','entidadeemitente','visualizar'));
	}
	
}