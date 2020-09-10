<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipodistancia extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipodistancia_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tpd = Tipodistancia_model::getById($this->input->get('id'));
		if (!$tpd){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipodistancia','visualizar'));
			exit();
		}
		return $tpd;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de distância - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipodistancia/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpd = $this->validateGetId();
		$this->data['tipodistancia'] = $tpd;
		$this->title = "Editar tipo de distância - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipodistancia/inserir');
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
		$this->title = "Visualizar tipos de distância - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipodistancia_model->getAll();
		$this->loadview('dci/tipodistancia/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipodistancia_model->descricao = $this->input->post('cnometpd');
		if ($this->Tipodistancia_model->validaInsercao()){
			$this->Tipodistancia_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipodistancia','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipodistancia_model->error);
			$this->session->set_flashdata('cnometpd',$this->Tipodistancia_model->descricao);
			redirect(makeUrl('dci','tipodistancia','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipodistancia_model->id = $this->validateGetId()->nidtbxtpd;
		$this->Tipodistancia_model->descricao = $this->input->post('cnometpd');
		if ($this->Tipodistancia_model->validaAtualizacao()){
			$this->Tipodistancia_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipodistancia','editar','?id='.$this->Tipodistancia_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipodistancia_model->error);
		$this->session->set_flashdata('cnometpd',$this->Tipodistancia_model->descricao);
		redirect(makeUrl('dci','tipodistancia','editar','?id='.$this->Tipodistancia_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipodistancia_model->id = $this->validateGetId()->nidtbxtpd;
		if ($this->Tipodistancia_model->isAtivo()){
			$this->Tipodistancia_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipodistancia_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipodistancia','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipodistancia_model->error);
		redirect(makeUrl('dci','tipodistancia','visualizar'));
	}
}