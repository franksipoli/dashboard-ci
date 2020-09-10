<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipocontato extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Tipocontato_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tpc = Tipocontato_model::getById($this->input->get('id'));
		if (!$tpc){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','tipocontato','visualizar'));
			exit();
		}
		return $tpc;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de contato - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipocontato/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpc = $this->validateGetId();
		$this->data['tipocontato'] = $tpc;
		$this->title = "Editar tipo de contato - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipocontato/inserir');
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
		$this->title = "Visualizar tipos de contato - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipocontato_model->getAll();
		$this->loadview('dcg/tipocontato/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipocontato_model->descricao = $this->input->post('cdescritpc');
		if ($this->Tipocontato_model->validaInsercao()){
			$this->Tipocontato_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dcg','tipocontato','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipocontato_model->error);
			$this->session->set_flashdata('cdescritpc',$this->Tipocontato_model->descricao);
			redirect(makeUrl('dcg','tipocontato','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipocontato_model->id = $this->validateGetId()->nidtbxtpc;
		$this->Tipocontato_model->descricao = $this->input->post('cdescritpc');
		if ($this->Tipocontato_model->validaAtualizacao()){
			$this->Tipocontato_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dcg','tipocontato','editar','?id='.$this->Tipocontato_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocontato_model->error);
		$this->session->set_flashdata('cdescritpc',$this->Tipocontato_model->descricao);
		redirect(makeUrl('dcg','tipocontato','editar','?id='.$this->Tipocontato_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/
	
	public function excluir()
	{
	 	$this->Tipocontato_model->id = $this->validateGetId()->nidtbxtpc;
		if ($this->Tipocontato_model->isAtivo()){
			$this->Tipocontato_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipocontato_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dcg','tipocontato','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocontato_model->error);
		redirect(makeUrl('dcg','tipocontato','visualizar'));
	}
}