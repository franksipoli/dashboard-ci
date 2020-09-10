<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiposervico extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Tiposervico_model');
	}
	
	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tps = Tiposervico_model::getById($this->input->get('id'));
		if (!$tps){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','tiposervico','visualizar'));
			exit();
		}
		return $tps;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de serviço - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tiposervico/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tps = $this->validateGetId();
		$this->data['tiposervico'] = $tps;
		$this->title = "Editar tipo de serviço - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tiposervico/inserir');
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
		$this->title = "Visualizar tipos de serviço - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tiposervico_model->getAll();
		$this->loadview('dcg/tiposervico/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tiposervico_model->descricao = $this->input->post('cdescritps');
		if ($this->Tiposervico_model->validaInsercao()){
			$this->Tiposervico_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dcg','tiposervico','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tiposervico_model->error);
			$this->session->set_flashdata('cdescritps',$this->Tiposervico_model->descricao);
			redirect(makeUrl('dcg','tiposervico','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tiposervico_model->id = $this->validateGetId()->nidtbxtps;
		$this->Tiposervico_model->descricao = $this->input->post('cdescritps');
		if ($this->Tiposervico_model->validaAtualizacao()){
			$this->Tiposervico_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dcg','tiposervico','editar','?id='.$this->Tiposervico_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tiposervico_model->error);
		$this->session->set_flashdata('cdescritps',$this->Tiposervico_model->descricao);
		redirect(makeUrl('dcg','tiposervico','editar','?id='.$this->Tiposervico_model->id));
		return;
	}
	
	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tiposervico_model->id = $this->validateGetId()->nidtbxtps;
		if ($this->Tiposervico_model->isAtivo()){
			$this->Tiposervico_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tiposervico_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dcg','tiposervico','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tiposervico_model->error);
		redirect(makeUrl('dcg','tiposervico','visualizar'));
	}
}