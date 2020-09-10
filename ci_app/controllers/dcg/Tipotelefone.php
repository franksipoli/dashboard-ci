<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipotelefone extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Tipotelefone_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$ttl = Tipotelefone_model::getById($this->input->get('id'));
		if (!$ttl){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','tipotelefone','visualizar'));
			exit();
		}
		return $ttl;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de telefone - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipotelefone/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$ttl = $this->validateGetId();
		$this->data['tipotelefone'] = $ttl;
		$this->title = "Editar tipo de telefone - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipotelefone/inserir');
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
		$this->title = "Visualizar tipos de telefone - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipotelefone_model->getAll();
		$this->loadview('dcg/tipotelefone/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipotelefone_model->descricao = $this->input->post('cdescrittl');
		if ($this->Tipotelefone_model->validaInsercao()){
			$this->Tipotelefone_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dcg','tipotelefone','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipotelefone_model->error);
			$this->session->set_flashdata('cdescrittl',$this->Tipotelefone_model->descricao);
			redirect(makeUrl('dcg','tipotelefone','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipotelefone_model->id = $this->validateGetId()->nidtbxttl;
		$this->Tipotelefone_model->descricao = $this->input->post('cdescrittl');
		if ($this->Tipotelefone_model->validaAtualizacao()){
			$this->Tipotelefone_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dcg','tipotelefone','editar','?id='.$this->Tipotelefone_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipotelefone_model->error);
		$this->session->set_flashdata('cdescrittl',$this->Tipotelefone_model->descricao);
		redirect(makeUrl('dcg','tipotelefone','editar','?id='.$this->Tipotelefone_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/
	
	public function excluir()
	{
	 	$this->Tipotelefone_model->id = $this->validateGetId()->nidtbxttl;
		if ($this->Tipotelefone_model->isAtivo()){
			$this->Tipotelefone_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipotelefone_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dcg','tipotelefone','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipotelefone_model->error);
		redirect(makeUrl('dcg','tipotelefone','visualizar'));
	}
}