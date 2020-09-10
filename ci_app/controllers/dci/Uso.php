<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uso extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Uso_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$uso = Uso_model::getById($this->input->get('id'));
		if (!$uso){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','uso','visualizar'));
			exit();
		}
		return $uso;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir uso - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/uso/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$uso = $this->validateGetId();
		$this->data['uso'] = $uso;
		$this->title = "Editar uso - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/uso/inserir');
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
		$this->title = "Visualizar usos - Yoopay - Soluções Tecnológicas";
		$this->data['usos'] = $this->Uso_model->getAll();
		$this->loadview('dci/uso/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Uso_model->descricao = $this->input->post('cdescriuso');
		if ($this->Uso_model->validaInsercao()){
			$this->Uso_model->save();
			$this->session->set_flashdata('sucesso','Uso cadastrado com sucesso');
			redirect(makeUrl('dci','uso','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Uso_model->error);
			$this->session->set_flashdata('cdescriuso',$this->Uso_model->descricao);
			redirect(makeUrl('dci','uso','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Uso_model->id = $this->validateGetId()->nidtbxuso;
		$this->Uso_model->descricao = $this->input->post('cdescriuso');
		if ($this->Uso_model->validaAtualizacao()){
			$this->Uso_model->save();
			$this->session->set_flashdata('sucesso','Uso atualizado com sucesso');
			redirect(makeUrl('dci','uso','editar','?id='.$this->Uso_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Uso_model->error);
		$this->session->set_flashdata('cdescriuso',$this->Uso_model->descricao);
		redirect(makeUrl('dci','uso','editar','?id='.$this->Uso_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Uso_model->id = $this->validateGetId()->nidtbxuso;
		if ($this->Uso_model->isAtivo()){
			$this->Uso_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Uso_model->delete();
			$this->session->set_flashdata('sucesso','Uso desativado com sucesso');
			redirect(makeUrl('dci','uso','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Uso_model->error);
		redirect(makeUrl('dci','uso','visualizar'));
	}
}