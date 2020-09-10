<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipocadastro extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Tipocadastro_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId(){
		$tcg = Tipocadastro_model::getById($this->input->get('id'));
		if (!$tcg){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','tipocadastro','visualizar'));
			exit();
		}
		return $tcg;
	}
	
	/**
	* Inserir registro
	*/
	
	public function inserir()
	{
		$this->title = "Inserir tipo de cadastro - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipocadastro/inserir');
	}
	
	/**
	* Editar registro
	*/
	
	public function editar()
	{
		$tcg = $this->validateGetId();
		$this->data['tipocadastro'] = $tcg;
		$this->title = "Editar tipo de cadastro - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipocadastro/inserir');
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
		$this->title = "Visualizar tipos de cadastro - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipocadastro_model->getAll();
		$this->loadview('dcg/tipocadastro/lista');
	}
	
	/**
	* Validar registro e adicionar ao banco
	*/
	
	public function insert()
	{
		$this->Tipocadastro_model->descricao = $this->input->post('cdescritcg');
		if ($this->Tipocadastro_model->validaInsercao()){
			$this->Tipocadastro_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dcg','tipocadastro','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipocadastro_model->error);
			$this->session->set_flashdata('cdescritcg',$this->Tipocadastro_model->descricao);
			redirect(makeUrl('dcg','tipocadastro','inserir'));
			return;
		}
	}
	
	/**
	* Atualizar registro
	*/
	 
	public function update()
	{
		$this->Tipocadastro_model->id = $this->validateGetId()->nidtbxtcg;
		$this->Tipocadastro_model->descricao = $this->input->post('cdescritcg');
		if ($this->Tipocadastro_model->validaAtualizacao()){
			$this->Tipocadastro_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dcg','tipocadastro','editar','?id='.$this->Tipocadastro_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocadastro_model->error);
		$this->session->set_flashdata('cdescritcg',$this->Tipocadastro_model->descricao);
		redirect(makeUrl('dcg','tipocadastro','editar','?id='.$this->Tipocadastro_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/
	 
	public function excluir()
	{
	 	$this->Tipocadastro_model->id = $this->validateGetId()->nidtbxtcg;
		if ($this->Tipocadastro_model->isAtivo()){
			$this->Tipocadastro_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipocadastro_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dcg','tipocadastro','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocadastro_model->error);
		redirect(makeUrl('dcg','tipocadastro','visualizar'));
	}

}