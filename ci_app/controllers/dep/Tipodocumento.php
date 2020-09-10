<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipodocumento extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dep/Tipodocumento_model');
		$this->load->model('app/App_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tdo = Tipodocumento_model::getById($this->input->get('id'));
		if (!$tdo){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dep','tipodocumento','visualizar'));
			exit();
		}
		return $tdo;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de documento - Yoopay - Soluções Tecnológicas";
		$this->data['apps'] = $this->App_model->getAll();
		$this->loadview('dep/tipodocumento/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tdo = $this->validateGetId();
		$this->data['tipodocumento'] = $tdo;
		$this->data['apps'] = $this->App_model->getAll();
		$this->data['apps_escolhidos'] = $this->Tipodocumento_model->getAppIds($tdo->nidtbxtdo);
		$this->title = "Editar tipo de documento - Yoopay - Soluções Tecnológicas";
		$this->loadview('dep/tipodocumento/inserir');
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
		$this->title = "Visualizar tipos de documento - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipodocumento_model->getAll();
		$this->loadview('dep/tipodocumento/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipodocumento_model->descricao = $this->input->post('cnometdo');
		$this->Tipodocumento_model->apps = $this->input->post('nidtbxapp');
		$this->Tipodocumento_model->obrigatorio = $this->input->post('nbloqueia');
		if ($this->Tipodocumento_model->validaInsercao()){
			$this->Tipodocumento_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dep','tipodocumento','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipodocumento_model->error);
			$this->session->set_flashdata('cnometdo',$this->Tipodocumento_model->descricao);
			redirect(makeUrl('dep','tipodocumento','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipodocumento_model->id = $this->validateGetId()->nidtbxtdo;
		$this->Tipodocumento_model->descricao = $this->input->post('cnometdo');
		$this->Tipodocumento_model->apps = $this->input->post('nidtbxapp');
		$this->Tipodocumento_model->obrigatorio = $this->input->post('nbloqueia');
		if ($this->Tipodocumento_model->validaAtualizacao()){
			$this->Tipodocumento_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dep','tipodocumento','editar','?id='.$this->Tipodocumento_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipodocumento_model->error);
		$this->session->set_flashdata('cnometdo',$this->Tipodocumento_model->descricao);
		redirect(makeUrl('dep','tipodocumento','editar','?id='.$this->Tipodocumento_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Tipodocumento_model->id = $this->validateGetId()->nidtbxtdo;
		if ($this->Tipodocumento_model->isAtivo()){
			$this->Tipodocumento_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipodocumento_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dep','tipodocumento','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipodocumento_model->error);
		redirect(makeUrl('dep','tipodocumento','visualizar'));
	}
	
}