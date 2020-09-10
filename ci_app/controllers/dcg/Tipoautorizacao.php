<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoautorizacao extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Tipoautorizacao_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tpa = Tipoautorizacao_model::getById($this->input->get('id'));
		if (!$tpa){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','tipoautorizacao','visualizar'));
			exit();
		}
		return $tpa;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de autorização - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipoautorizacao/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpa = $this->validateGetId();
		$this->data['tipoautorizacao'] = $tpa;
		$this->title = "Editar tipo de autorização - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipoautorizacao/inserir');
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
		$this->title = "Visualizar tipos de autorização - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoautorizacao_model->getAll();
		$this->loadview('dcg/tipoautorizacao/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoautorizacao_model->descricao = $this->input->post('cdescritpa');
		if ($this->Tipoautorizacao_model->validaInsercao()){
			$this->Tipoautorizacao_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dcg','tipoautorizacao','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoautorizacao_model->error);
			$this->session->set_flashdata('cdescritpa',$this->Tipoautorizacao_model->descricao);
			redirect(makeUrl('dcg','tipoautorizacao','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoautorizacao_model->id = $this->validateGetId()->nidtbxtpa;
		$this->Tipoautorizacao_model->descricao = $this->input->post('cdescritpa');
		if ($this->Tipoautorizacao_model->validaAtualizacao()){
			$this->Tipoautorizacao_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dcg','tipoautorizacao','editar','?id='.$this->Tipoautorizacao_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoautorizacao_model->error);
		$this->session->set_flashdata('cdescritpa',$this->Tipoautorizacao_model->descricao);
		redirect(makeUrl('dcg','tipoautorizacao','editar','?id='.$this->Tipoautorizacao_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Tipoautorizacao_model->id = $this->validateGetId()->nidtbxtpa;
		if ($this->Tipoautorizacao_model->isAtivo()){
			$this->Tipoautorizacao_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoautorizacao_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dcg','tipoautorizacao','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoautorizacao_model->error);
		redirect(makeUrl('dcg','tipoautorizacao','visualizar'));
	}
	
}