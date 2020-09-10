<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipogaragem extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipogaragem_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tpg = Tipogaragem_model::getById($this->input->get('id'));
		if (!$tpg){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipogaragem','visualizar'));
			exit();
		}
		return $tpg;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de garagem - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipogaragem/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpg = $this->validateGetId();
		$this->data['tipogaragem'] = $tpg;
		$this->title = "Editar tipo de garagem - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipogaragem/inserir');
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
		$this->title = "Visualizar tipos de garagem - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipogaragem_model->getAll();
		$this->loadview('dci/tipogaragem/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipogaragem_model->descricao = $this->input->post('cdescritpg');
		if ($this->Tipogaragem_model->validaInsercao()){
			$this->Tipogaragem_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipogaragem','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipogaragem_model->error);
			$this->session->set_flashdata('cdescritpg',$this->Tipogaragem_model->descricao);
			redirect(makeUrl('dci','tipogaragem','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipogaragem_model->id = $this->validateGetId()->nidtbxtpg;
		$this->Tipogaragem_model->descricao = $this->input->post('cdescritpg');
		if ($this->Tipogaragem_model->validaAtualizacao()){
			$this->Tipogaragem_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipogaragem','editar','?id='.$this->Tipogaragem_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipogaragem_model->error);
		$this->session->set_flashdata('cdescritpg',$this->Tipogaragem_model->descricao);
		redirect(makeUrl('dci','tipogaragem','editar','?id='.$this->Tipogaragem_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipogaragem_model->id = $this->validateGetId()->nidtbxtpg;
		if ($this->Tipogaragem_model->isAtivo()){
			$this->Tipogaragem_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipogaragem_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipogaragem','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipogaragem_model->error);
		redirect(makeUrl('dci','tipogaragem','visualizar'));
	}
}