<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pais extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dep/Pais_model');
	}
	
	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$pas = Pais_model::getById($this->input->get('id'));
		if (!$pas){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dep','pais','visualizar'));
			exit();
		}
		return $pas;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir país - Yoopay - Soluções Tecnológicas";
		$this->loadview('dep/pais/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$pas = $this->validateGetId();
		$this->data['pais'] = $pas;
		$this->title = "Editar país - Yoopay - Soluções Tecnológicas";
		$this->loadview('dep/pais/inserir');
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
		$this->title = "Visualizar países - Yoopay - Soluções Tecnológicas";
		$this->data['paises'] = $this->Pais_model->getAll();
		$this->loadview('dep/pais/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Pais_model->descricao = $this->input->post('cdescripas');
		if ($this->Pais_model->validaInsercao()){
			$this->Pais_model->save();
			$this->session->set_flashdata('sucesso','País cadastrado com sucesso');
			redirect(makeUrl('dep','pais','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Pais_model->error);
			$this->session->set_flashdata('cdescripas',$this->Pais_model->descricao);
			redirect(makeUrl('dep','pais','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Pais_model->id = $this->validateGetId()->nidtbxpas;
		$this->Pais_model->descricao = $this->input->post('cdescripas');
		if ($this->Pais_model->validaAtualizacao()){
			$this->Pais_model->save();
			$this->session->set_flashdata('sucesso','País atualizado com sucesso');
			redirect(makeUrl('dep','pais','editar','?id='.$this->Pais_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Pais_model->error);
		$this->session->set_flashdata('cdescripas',$this->Pais_model->descricao);
		redirect(makeUrl('dep','pais','editar','?id='.$this->Pais_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Pais_model->id = $this->validateGetId()->nidtbxpas;
		if ($this->Pais_model->isAtivo()){
			$this->Pais_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Pais_model->delete();
			$this->session->set_flashdata('sucesso','País desativado com sucesso');
			redirect(makeUrl('dep','pais','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Pais_model->error);
		redirect(makeUrl('dep','pais','visualizar'));
	}
	
}