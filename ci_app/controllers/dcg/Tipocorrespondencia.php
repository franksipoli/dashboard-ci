<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipocorrespondencia extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Tipocorrespondencia_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tco = Tipocorrespondencia_model::getById($this->input->get('id'));
		if (!$tco){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','tipocorrespondencia','visualizar'));
			exit();
		}
		return $tco;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de correspondência - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipocorrespondencia/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpc = $this->validateGetId();
		$this->data['tipocorrespondencia'] = $tpc;
		$this->title = "Editar tipo de correspondência - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipocorrespondencia/inserir');
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
		$this->title = "Visualizar tipos de correspondência - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipocorrespondencia_model->getAll();
		$this->loadview('dcg/tipocorrespondencia/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipocorrespondencia_model->descricao = $this->input->post('cdescritco');
		if ($this->Tipocorrespondencia_model->validaInsercao()){
			$this->Tipocorrespondencia_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dcg','tipocorrespondencia','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipocorrespondencia_model->error);
			$this->session->set_flashdata('cdescritco',$this->Tipocorrespondencia_model->descricao);
			redirect(makeUrl('dcg','tipocorrespondencia','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipocorrespondencia_model->id = $this->validateGetId()->nidtbxtco;
		$this->Tipocorrespondencia_model->descricao = $this->input->post('cdescritco');
		if ($this->Tipocorrespondencia_model->validaAtualizacao()){
			$this->Tipocorrespondencia_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dcg','tipocorrespondencia','editar','?id='.$this->Tipocorrespondencia_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocorrespondencia_model->error);
		$this->session->set_flashdata('cdescritco',$this->Tipocorrespondencia_model->descricao);
		redirect(makeUrl('dcg','tipocorrespondencia','editar','?id='.$this->Tipocorrespondencia_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipocorrespondencia_model->id = $this->validateGetId()->nidtbxtco;
		if ($this->Tipocorrespondencia_model->isAtivo()){
			$this->Tipocorrespondencia_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipocorrespondencia_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dcg','tipocorrespondencia','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocorrespondencia_model->error);
		redirect(makeUrl('dcg','tipocorrespondencia','visualizar'));
	}
	
}