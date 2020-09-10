<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipocomissao extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipocomissao_model');
		$this->load->model('dci/Finalidade_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tcm = Tipocomissao_model::getById($this->input->get('id'));
		if (!$tcm){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipocomissao','visualizar'));
			exit();
		}
		return $tcm;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de comissão - Yoopay - Soluções Tecnológicas";
		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		$this->loadview('dci/tipocomissao/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tcm = $this->validateGetId();
		$this->data['tipocomissao'] = $tcm;
		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		$this->data['valores'] = $this->Tipocomissao_model->getValoresPadrao($tcm->nidtbxtcm);
		$this->title = "Editar tipo de comissão - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipocomissao/inserir');
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
		$this->title = "Visualizar tipos de comissão - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipocomissao_model->getAll();
		$this->loadview('dci/tipocomissao/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipocomissao_model->descricao = $this->input->post('cdescritcm');
		$this->Tipocomissao_model->valor_padrao = $this->input->post('nvalorpadrao');
		$this->Tipocomissao_model->principal = $this->input->post('nprincipal');
		if ($this->Tipocomissao_model->validaInsercao()){
			$this->Tipocomissao_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipocomissao','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipocomissao_model->error);
			$this->session->set_flashdata('cdescritcm',$this->Tipocomissao_model->descricao);
			redirect(makeUrl('dci','tipocomissao','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipocomissao_model->id = $this->validateGetId()->nidtbxtcm;
		$this->Tipocomissao_model->descricao = $this->input->post('cdescritcm');
		$this->Tipocomissao_model->valor_padrao = $this->input->post('nvalorpadrao');
		$this->Tipocomissao_model->principal = $this->input->post('nprincipal');
		if ($this->Tipocomissao_model->validaAtualizacao()){
			$this->Tipocomissao_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipocomissao','editar','?id='.$this->Tipocomissao_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocomissao_model->error);
		$this->session->set_flashdata('cdescritcm',$this->Tipocomissao_model->descricao);
		redirect(makeUrl('dci','tipocomissao','editar','?id='.$this->Tipocomissao_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipocomissao_model->id = $this->validateGetId()->nidtbxtcm;
		if ($this->Tipocomissao_model->isAtivo()){
			$this->Tipocomissao_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipocomissao_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipocomissao','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocomissao_model->error);
		redirect(makeUrl('dci','tipocomissao','visualizar'));
	}
}