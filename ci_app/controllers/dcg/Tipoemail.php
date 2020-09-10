<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoemail extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Tipoemail_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tem = Tipoemail_model::getById($this->input->get('id'));
		if (!$tem){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','tipoemail','visualizar'));
			exit();
		}
		return $tem;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de e-mail - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipoemail/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tem = $this->validateGetId();
		$this->data['tipoemail'] = $tem;
		$this->title = "Editar tipo de e-mail - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipoemail/inserir');
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
		$this->title = "Visualizar tipos de e-mail - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoemail_model->getAll();
		$this->loadview('dcg/tipoemail/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoemail_model->descricao = $this->input->post('cdescritem');
		if ($this->Tipoemail_model->validaInsercao()){
			$this->Tipoemail_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dcg','tipoemail','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoemail_model->error);
			$this->session->set_flashdata('cdescritem',$this->Tipoemail_model->descricao);
			redirect(makeUrl('dcg','tipoemail','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoemail_model->id = $this->validateGetId()->nidtbxtem;
		$this->Tipoemail_model->descricao = $this->input->post('cdescritem');
		if ($this->Tipoemail_model->validaAtualizacao()){
			$this->Tipoemail_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dcg','tipoemail','editar','?id='.$this->Tipoemail_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoemail_model->error);
		$this->session->set_flashdata('cdescritem',$this->Tipoemail_model->descricao);
		redirect(makeUrl('dcg','tipoemail','editar','?id='.$this->Tipoemail_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/
	
	public function excluir()
	{
	 	$this->Tipoemail_model->id = $this->validateGetId()->nidtbxtem;
		if ($this->Tipoemail_model->isAtivo()){
			$this->Tipoemail_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoemail_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dcg','tipoemail','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoemail_model->error);
		redirect(makeUrl('dcg','tipoemail','visualizar'));
	}
}