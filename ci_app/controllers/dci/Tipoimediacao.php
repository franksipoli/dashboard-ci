<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoimediacao extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipoimediacao_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tim = Tipoimediacao_model::getById($this->input->get('id'));
		if (!$tim){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipoimediacao','visualizar'));
			exit();
		}
		return $tim;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de imediação - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoimediacao/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tim = $this->validateGetId();
		$this->data['tipoimediacao'] = $tim;
		$this->title = "Editar tipo de imediação - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoimediacao/inserir');
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
		$this->title = "Visualizar tipos de imediação - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoimediacao_model->getAll();
		$this->loadview('dci/tipoimediacao/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoimediacao_model->descricao = $this->input->post('cnometim');
		if ($this->Tipoimediacao_model->validaInsercao()){
			$this->Tipoimediacao_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipoimediacao','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoimediacao_model->error);
			$this->session->set_flashdata('cnometim',$this->Tipoimediacao_model->descricao);
			redirect(makeUrl('dci','tipoimediacao','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoimediacao_model->id = $this->validateGetId()->nidtbxtim;
		$this->Tipoimediacao_model->descricao = $this->input->post('cnometim');
		if ($this->Tipoimediacao_model->validaAtualizacao()){
			$this->Tipoimediacao_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipoimediacao','editar','?id='.$this->Tipoimediacao_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoimediacao_model->error);
		$this->session->set_flashdata('cnometim',$this->Tipoimediacao_model->descricao);
		redirect(makeUrl('dci','tipoimediacao','editar','?id='.$this->Tipoimediacao_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipoimediacao_model->id = $this->validateGetId()->nidtbxtim;
		if ($this->Tipoimediacao_model->isAtivo()){
			$this->Tipoimediacao_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoimediacao_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipoimediacao','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoimediacao_model->error);
		redirect(makeUrl('dci','tipoimediacao','visualizar'));
	}
}