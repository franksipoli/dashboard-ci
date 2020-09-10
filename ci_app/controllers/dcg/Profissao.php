<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profissao extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Profissao_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$cbo = Profissao_model::getById($this->input->get('id'));
		if (!$cbo){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','profissao','visualizar'));
			exit();
		}
		return $cbo;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir profissão - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/profissao/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$cbo = $this->validateGetId();
		$this->data['profissao'] = $cbo;
		$this->title = "Editar profissão - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/profissao/inserir');
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
		$this->title = "Visualizar profissões - Yoopay - Soluções Tecnológicas";
		$this->data['profissoes'] = $this->Profissao_model->getAll();
		$this->loadview('dcg/profissao/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Profissao_model->descricao = $this->input->post('cdescricbo');
		if ($this->Profissao_model->validaInsercao()){
			$this->Profissao_model->save();
			$this->session->set_flashdata('sucesso','Profissão cadastrada com sucesso');
			redirect(makeUrl('dcg','profissao','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Profissao_model->error);
			$this->session->set_flashdata('cdescricbo',$this->Profissao_model->descricao);
			redirect(makeUrl('dcg','profissao','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Profissao_model->id = $this->validateGetId()->nidtbxcbo;
		$this->Profissao_model->descricao = $this->input->post('cdescricbo');
		if ($this->Profissao_model->validaAtualizacao()){
			$this->Profissao_model->save();
			$this->session->set_flashdata('sucesso','Profissão atualizada com sucesso');
			redirect(makeUrl('dcg','profissao','editar','?id='.$this->Profissao_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Profissao_model->error);
		$this->session->set_flashdata('cdescricbo',$this->Profissao_model->descricao);
		redirect(makeUrl('dcg','profissao','editar','?id='.$this->Profissao_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Profissao_model->id = $this->validateGetId()->nidtbxcbo;
		if ($this->Profissao_model->isAtivo()){
			$this->Profissao_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Profissao_model->delete();
			$this->session->set_flashdata('sucesso','Profissão desativada com sucesso');
			redirect(makeUrl('dcg','profissao','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Profissao_model->error);
		redirect(makeUrl('dcg','profissao','visualizar'));
	}
	
}