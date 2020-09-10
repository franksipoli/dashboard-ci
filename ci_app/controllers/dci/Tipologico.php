<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipologico extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipologico_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$log = Tipologico_model::getById($this->input->get('id'));
		if (!$log){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipologico','visualizar'));
			exit();
		}
		return $log;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo lógico - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipologico/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$log = $this->validateGetId();
		$this->data['tipologico'] = $log;
		$this->title = "Editar tipo lógico - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipologico/inserir');
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
		$this->title = "Visualizar tipos lógicos - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipologico_model->getAll();
		$this->loadview('dci/tipologico/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipologico_model->descricao = $this->input->post('cdescrilog');
		if ($this->Tipologico_model->validaInsercao()){
			$this->Tipologico_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipologico','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipologico_model->error);
			$this->session->set_flashdata('cdescrilog',$this->Tipologico_model->descricao);
			redirect(makeUrl('dci','tipologico','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipologico_model->id = $this->validateGetId()->nidtbxlog;
		$this->Tipologico_model->descricao = $this->input->post('cdescrilog');
		if ($this->Tipologico_model->validaAtualizacao()){
			$this->Tipologico_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipologico','editar','?id='.$this->Tipologico_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipologico_model->error);
		$this->session->set_flashdata('cdescrilog',$this->Tipologico_model->descricao);
		redirect(makeUrl('dci','tipologico','editar','?id='.$this->Tipologico_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipologico_model->id = $this->validateGetId()->nidtbxlog;
		if ($this->Tipologico_model->isAtivo()){
			$this->Tipologico_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipologico_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipologico','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipologico_model->error);
		redirect(makeUrl('dci','tipologico','visualizar'));
	}
}