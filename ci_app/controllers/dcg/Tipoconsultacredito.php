<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoconsultacredito extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Tipoconsultacredito_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tcc = Tipoconsultacredito_model::getById($this->input->get('id'));
		if (!$tcc){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','tipoconsultacredito','visualizar'));
			exit();
		}
		return $tcc;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de consulta de crédito - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipoconsultacredito/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tcc = $this->validateGetId();
		$this->data['tipoconsultacredito'] = $tcc;
		$this->title = "Editar tipo de consulta de crédito - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipoconsultacredito/inserir');
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
		$this->title = "Visualizar tipos de consulta de crédito - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoconsultacredito_model->getAll();
		$this->loadview('dcg/tipoconsultacredito/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoconsultacredito_model->descricao = $this->input->post('cdescritcc');
		$this->Tipoconsultacredito_model->link = $this->input->post('clink');
		if ($this->Tipoconsultacredito_model->validaInsercao()){
			$this->Tipoconsultacredito_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dcg','tipoconsultacredito','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoconsultacredito_model->error);
			$this->session->set_flashdata('cdescritcc',$this->Tipoconsultacredito_model->descricao);
			$this->session->set_flashdata('clink',$this->Tipoconsultacredito_model->link);
			redirect(makeUrl('dcg','tipoconsultacredito','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update(){
		$this->Tipoconsultacredito_model->id = $this->validateGetId()->nidtbxtcc;
		$this->Tipoconsultacredito_model->descricao = $this->input->post('cdescritcc');
		$this->Tipoconsultacredito_model->link = $this->input->post('clink');
		if ($this->Tipoconsultacredito_model->validaAtualizacao()){
			$this->Tipoconsultacredito_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dcg','tipoconsultacredito','editar','?id='.$this->Tipoconsultacredito_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoconsultacredito_model->error);
		$this->session->set_flashdata('cdescritcc',$this->Tipoconsultacredito_model->descricao);
		$this->session->set_flashdata('clink',$this->Tipoconsultacredito_model->link);
		redirect(makeUrl('dcg','tipoconsultacredito','editar','?id='.$this->Tipoconsultacredito_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipoconsultacredito_model->id = $this->validateGetId()->nidtbxtcc;
		if ($this->Tipoconsultacredito_model->isAtivo()){
			$this->Tipoconsultacredito_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoconsultacredito_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dcg','tipoconsultacredito','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoconsultacredito_model->error);
		redirect(makeUrl('dcg','tipoconsultacredito','visualizar'));
	}
	
}