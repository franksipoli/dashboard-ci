<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finalidade extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Finalidade_model');
		$this->load->model('dci/Grupocaracteristica_model');
		$this->load->model('dci/Caracteristica_model');
		$this->load->model('cadimo/Tipocontrato_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$fin = Finalidade_model::getById($this->input->get('id'));
		if (!$fin){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','finalidade','visualizar'));
			exit();
		}
		return $fin;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir finalidade - Yoopay - Soluções Tecnológicas";
		$this->data['con'] = $this->Tipocontrato_model->getAll();
		$this->data['grupos'] = $this->Grupocaracteristica_model->getAll();
		$this->loadview('dci/finalidade/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$fin = $this->validateGetId();
		$this->data['finalidade'] = $fin;
		$this->title = "Editar finalidade - Yoopay - Soluções Tecnológicas";
		$this->data['grupos'] = $this->Grupocaracteristica_model->getAll();
		$this->data['con'] = $this->Tipocontrato_model->getAll();
		$this->data['grupos_escolhidos'] = $this->Grupocaracteristica_model->getByFinalidade($fin->nidtbxfin);
		$this->data['con_escolhidos'] = $this->Tipocontrato_model->getByFinalidade($fin->nidtbxfin);
		$this->loadview('dci/finalidade/inserir');
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
		$this->title = "Visualizar finalidades - Yoopay - Soluções Tecnológicas";
		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		$this->loadview('dci/finalidade/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Finalidade_model->descricao = $this->input->post('cnomefin');
		$this->Finalidade_model->grupos = $this->input->post('nidtbxgrc');
		$this->Finalidade_model->tipos_contrato = $this->input->post('nidtbxcon');
		if ($this->Finalidade_model->validaInsercao()){
			$this->Finalidade_model->save();
			$this->session->set_flashdata('sucesso','Finalidade cadastrada com sucesso');
			redirect(makeUrl('dci','finalidade','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Finalidade_model->error);
			$this->session->set_flashdata('cnomefin',$this->Finalidade_model->descricao);
			redirect(makeUrl('dci','finalidade','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Finalidade_model->id = $this->validateGetId()->nidtbxfin;
		$this->Finalidade_model->descricao = $this->input->post('cnomefin');
		$this->Finalidade_model->grupos = $this->input->post('nidtbxgrc');
		$this->Finalidade_model->tipos_contrato = $this->input->post('nidtbxcon');
		if ($this->Finalidade_model->validaAtualizacao()){
			$this->Finalidade_model->save();
			$this->session->set_flashdata('sucesso','Finalidade atualizada com sucesso');
			redirect(makeUrl('dci','finalidade','editar','?id='.$this->Finalidade_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Finalidade_model->error);
		$this->session->set_flashdata('cnomefin',$this->Finalidade_model->descricao);
		redirect(makeUrl('dci','finalidade','editar','?id='.$this->Finalidade_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Finalidade_model->id = $this->validateGetId()->nidtbxfin;
		if ($this->Finalidade_model->isAtivo()){
			$this->Finalidade_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Finalidade_model->delete();
			$this->session->set_flashdata('sucesso','Finalidade desativada com sucesso');
			redirect(makeUrl('dci','finalidade','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Finalidade_model->error);
		redirect(makeUrl('dci','finalidade','visualizar'));
	}
}