<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipopermuta extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipopermuta_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tpp = Tipopermuta_model::getById($this->input->get('id'));
		if (!$tpp){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipopermuta','visualizar'));
			exit();
		}
		return $tpp;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de permuta - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipopermuta/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpp = $this->validateGetId();
		$this->data['tipopermuta'] = $tpp;
		$this->title = "Editar tipo de permuta - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipopermuta/inserir');
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
		$this->title = "Visualizar tipos de permuta - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipopermuta_model->getAll();
		$this->loadview('dci/tipopermuta/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipopermuta_model->descricao = $this->input->post('cnometpp');
		if ($this->Tipopermuta_model->validaInsercao()){
			$this->Tipopermuta_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipopermuta','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipopermuta_model->error);
			$this->session->set_flashdata('cnometpp',$this->Tipopermuta_model->descricao);
			redirect(makeUrl('dci','tipopermuta','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipopermuta_model->id = $this->validateGetId()->nidtbxtpp;
		$this->Tipopermuta_model->descricao = $this->input->post('cnometpp');
		if ($this->Tipopermuta_model->validaAtualizacao()){
			$this->Tipopermuta_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipopermuta','editar','?id='.$this->Tipopermuta_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipopermuta_model->error);
		$this->session->set_flashdata('cnometpp',$this->Tipopermuta_model->descricao);
		redirect(makeUrl('dci','tipopermuta','editar','?id='.$this->Tipopermuta_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipopermuta_model->id = $this->validateGetId()->nidtbxtpp;
		if ($this->Tipopermuta_model->isAtivo()){
			$this->Tipopermuta_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipopermuta_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipopermuta','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipopermuta_model->error);
		redirect(makeUrl('dci','tipopermuta','visualizar'));
	}
}