<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoconstrucao extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipoconstrucao_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tcn = Tipoconstrucao_model::getById($this->input->get('id'));
		if (!$tcn){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipoconstrucao','visualizar'));
			exit();
		}
		return $tcn;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de construção - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoconstrucao/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tcn = $this->validateGetId();
		$this->data['tipoconstrucao'] = $tcn;
		$this->title = "Editar tipo de construção - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoconstrucao/inserir');
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
		$this->title = "Visualizar tipos de construção - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoconstrucao_model->getAll();
		$this->loadview('dci/tipoconstrucao/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoconstrucao_model->descricao = $this->input->post('cnometcn');
		if ($this->Tipoconstrucao_model->validaInsercao()){
			$this->Tipoconstrucao_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipoconstrucao','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoconstrucao_model->error);
			$this->session->set_flashdata('cnometcn',$this->Tipoconstrucao_model->descricao);
			redirect(makeUrl('dci','tipoconstrucao','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoconstrucao_model->id = $this->validateGetId()->nidtbxtcn;
		$this->Tipoconstrucao_model->descricao = $this->input->post('cnometcn');
		if ($this->Tipoconstrucao_model->validaAtualizacao()){
			$this->Tipoconstrucao_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipoconstrucao','editar','?id='.$this->Tipoconstrucao_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoconstrucao_model->error);
		$this->session->set_flashdata('cnometcn',$this->Tipoconstrucao_model->descricao);
		redirect(makeUrl('dci','tipoconstrucao','editar','?id='.$this->Tipoconstrucao_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipoconstrucao_model->id = $this->validateGetId()->nidtbxtcn;
		if ($this->Tipoconstrucao_model->isAtivo()){
			$this->Tipoconstrucao_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoconstrucao_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipoconstrucao','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoconstrucao_model->error);
		redirect(makeUrl('dci','tipoconstrucao','visualizar'));
	}
}