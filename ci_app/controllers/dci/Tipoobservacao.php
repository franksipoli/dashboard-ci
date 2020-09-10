<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoobservacao extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipoobservacao_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$obs = Tipoobservacao_model::getById($this->input->get('id'));
		if (!$obs){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipoobservacao','visualizar'));
			exit();
		}
		return $obs;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de observação - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoobservacao/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$obs = $this->validateGetId();
		$this->data['tipoobservacao'] = $obs;
		$this->title = "Editar tipo de observação - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoobservacao/inserir');
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
		$this->title = "Visualizar tipos de observação - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoobservacao_model->getAll();
		$this->loadview('dci/tipoobservacao/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoobservacao_model->descricao = $this->input->post('cnomeobs');
		if ($this->Tipoobservacao_model->validaInsercao()){
			$this->Tipoobservacao_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipoobservacao','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoobservacao_model->error);
			$this->session->set_flashdata('cnomeobs',$this->Tipoobservacao_model->descricao);
			redirect(makeUrl('dci','tipoobservacao','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoobservacao_model->id = $this->validateGetId()->nidtbxobs;
		$this->Tipoobservacao_model->descricao = $this->input->post('cnomeobs');
		if ($this->Tipoobservacao_model->validaAtualizacao()){
			$this->Tipoobservacao_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipoobservacao','editar','?id='.$this->Tipoobservacao_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoobservacao_model->error);
		$this->session->set_flashdata('cnomeobs',$this->Tipoobservacao_model->descricao);
		redirect(makeUrl('dci','tipoobservacao','editar','?id='.$this->Tipoobservacao_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipoobservacao_model->id = $this->validateGetId()->nidtbxobs;
		if ($this->Tipoobservacao_model->isAtivo()){
			$this->Tipoobservacao_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoobservacao_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipoobservacao','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoobservacao_model->error);
		redirect(makeUrl('dci','tipoobservacao','visualizar'));
	}
}