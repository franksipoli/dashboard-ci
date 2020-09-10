<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipopacote extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipopacote_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$pac = Tipopacote_model::getById($this->input->get('id'));
		if (!$pac){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipopacote','visualizar'));
			exit();
		}
		return $pac;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de pacote - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipopacote/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$pac = $this->validateGetId();
		$this->data['tipopacote'] = $pac;
		$this->title = "Editar tipo de pacote - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipopacote/inserir');
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
		$this->title = "Visualizar tipos de pacote - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipopacote_model->getAll();
		$this->loadview('dci/tipopacote/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipopacote_model->descricao = $this->input->post('cnomepac');
		if ($this->Tipopacote_model->validaInsercao()){
			$this->Tipopacote_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipopacote','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipopacote_model->error);
			$this->session->set_flashdata('cnomepac',$this->Tipopacote_model->descricao);
			redirect(makeUrl('dci','tipopacote','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipopacote_model->id = $this->validateGetId()->nidtbxpac;
		$this->Tipopacote_model->descricao = $this->input->post('cnomepac');
		if ($this->Tipopacote_model->validaAtualizacao()){
			$this->Tipopacote_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipopacote','editar','?id='.$this->Tipopacote_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipopacote_model->error);
		$this->session->set_flashdata('cnomepac',$this->Tipopacote_model->descricao);
		redirect(makeUrl('dci','tipopacote','editar','?id='.$this->Tipopacote_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipopacote_model->id = $this->validateGetId()->nidtbxpac;
		if ($this->Tipopacote_model->isAtivo()){
			$this->Tipopacote_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipopacote_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipopacote','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipopacote_model->error);
		redirect(makeUrl('dci','tipopacote','visualizar'));
	}
}