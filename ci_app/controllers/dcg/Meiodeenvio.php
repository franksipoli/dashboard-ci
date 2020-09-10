<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meiodeenvio extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Meiodeenvio_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$env = Meiodeenvio_model::getById($this->input->get('id'));
		if (!$env){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','meiodeenvio','visualizar'));
			exit();
		}
		return $env;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir meio de envio - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/meiodeenvio/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$env = $this->validateGetId();
		$this->data['meiodeenvio'] = $env;
		$this->title = "Editar meio de envio - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/meiodeenvio/inserir');
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
		$this->title = "Visualizar meios de envio - Yoopay - Soluções Tecnológicas";
		$this->data['meiosdeenvio'] = $this->Meiodeenvio_model->getAll();
		$this->loadview('dcg/meiodeenvio/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Meiodeenvio_model->descricao = $this->input->post('cdescrienv');
		if ($this->Meiodeenvio_model->validaInsercao()){
			$this->Meiodeenvio_model->save();
			$this->session->set_flashdata('sucesso','Meio de envio cadastrado com sucesso');
			redirect(makeUrl('dcg','meiodeenvio','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Meiodeenvio_model->error);
			$this->session->set_flashdata('cdescrienv',$this->Meiodeenvio_model->descricao);
			redirect(makeUrl('dcg','meiodeenvio','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Meiodeenvio_model->id = $this->validateGetId()->nidtbxenv;
		$this->Meiodeenvio_model->descricao = $this->input->post('cdescrienv');
		if ($this->Meiodeenvio_model->validaAtualizacao()){
			$this->Meiodeenvio_model->save();
			$this->session->set_flashdata('sucesso','Meio de envio atualizado com sucesso');
			redirect(makeUrl('dcg','meiodeenvio','editar','?id='.$this->Meiodeenvio_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Meiodeenvio_model->error);
		$this->session->set_flashdata('cdescrienv',$this->Meiodeenvio_model->descricao);
		redirect(makeUrl('dcg','meiodeenvio','editar','?id='.$this->Meiodeenvio_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Meiodeenvio_model->id = $this->validateGetId()->nidtbxenv;
		if ($this->Meiodeenvio_model->isAtivo()){
			$this->Meiodeenvio_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Meiodeenvio_model->delete();
			$this->session->set_flashdata('sucesso','Meio de envio desativado com sucesso');
			redirect(makeUrl('dcg','meiodeenvio','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Meiodeenvio_model->error);
		redirect(makeUrl('dcg','meiodeenvio','visualizar'));
	}
	
}