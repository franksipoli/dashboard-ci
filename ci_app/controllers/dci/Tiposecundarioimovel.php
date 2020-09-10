<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiposecundarioimovel extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tiposecundarioimovel_model');
		$this->load->model('dci/Tipoimovel_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tp2 = Tiposecundarioimovel_model::getById($this->input->get('id'));
		if (!$tp2){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tiposecundarioimovel','visualizar'));
			exit();
		}
		return $tp2;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo secundário no Produto - Yoopay - Soluções Tecnológicas";
		$this->data['tpi'] = $this->Tipoimovel_model->getAll();
		$this->loadview('dci/tiposecundarioimovel/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tp2 = $this->validateGetId();
		$this->data['tiposecundarioimovel'] = $tp2;
		$this->data['tpi'] = $this->Tipoimovel_model->getAll();
		$this->data['tipos_selecionados'] = $this->Tiposecundarioimovel_model->getPrimarios($tp2->nidtbxtp2);
		$this->title = "Editar tipo secundário no Produto - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tiposecundarioimovel/inserir');
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
		$this->title = "Visualizar tipos secundários no Produto - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tiposecundarioimovel_model->getAll();
		$this->loadview('dci/tiposecundarioimovel/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tiposecundarioimovel_model->descricao = $this->input->post('cnometp2');
		$this->Tiposecundarioimovel_model->tipos_primarios = $this->input->post('nidtbxtpi');
		if ($this->Tiposecundarioimovel_model->validaInsercao()){
			$this->Tiposecundarioimovel_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tiposecundarioimovel','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tiposecundarioimovel_model->error);
			$this->session->set_flashdata('cnometp2',$this->Tiposecundarioimovel_model->descricao);
			redirect(makeUrl('dci','tiposecundarioimovel','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tiposecundarioimovel_model->id = $this->validateGetId()->nidtbxtp2;
		$this->Tiposecundarioimovel_model->descricao = $this->input->post('cnometp2');
		$this->Tiposecundarioimovel_model->tipos_primarios = $this->input->post('nidtbxtpi');
		if ($this->Tiposecundarioimovel_model->validaAtualizacao()){
			$this->Tiposecundarioimovel_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tiposecundarioimovel','editar','?id='.$this->Tiposecundarioimovel_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tiposecundarioimovel_model->error);
		$this->session->set_flashdata('cnometp2',$this->Tiposecundarioimovel_model->descricao);
		redirect(makeUrl('dci','tiposecundarioimovel','editar','?id='.$this->Tiposecundarioimovel_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tiposecundarioimovel_model->id = $this->validateGetId()->nidtbxtp2;
		if ($this->Tiposecundarioimovel_model->isAtivo()){
			$this->Tiposecundarioimovel_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tiposecundarioimovel_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tiposecundarioimovel','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tiposecundarioimovel_model->error);
		redirect(makeUrl('dci','tiposecundarioimovel','visualizar'));
	}
}