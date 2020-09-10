<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupocaracteristica extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Grupocaracteristica_model');
		$this->load->model('dci/Caracteristica_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$grc = Grupocaracteristica_model::getById($this->input->get('id'));
		if (!$grc){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','grupocaracteristica','visualizar'));
			exit();
		}
		return $grc;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir grupo de características - Yoopay - Soluções Tecnológicas";
		$this->data['caracteristicas'] = $this->Caracteristica_model->getAll();
		$this->loadview('dci/grupocaracteristica/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$grc = $this->validateGetId();
		$this->data['grupo'] = $grc;
		$this->data['caracteristicas'] = $this->Caracteristica_model->getAll();
		$this->data['caracteristicas_selecionadas'] = $this->Caracteristica_model->getByGrupo($grc->nidtbxgrc);
		$this->title = "Editar grupo de características - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/grupocaracteristica/inserir');
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
		$this->title = "Visualizar grupos de características - Yoopay - Soluções Tecnológicas";
		$this->data['grupos'] = $this->Grupocaracteristica_model->getAll();
		$this->loadview('dci/grupocaracteristica/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Grupocaracteristica_model->descricao = $this->input->post('cnomegrc');
		$this->Grupocaracteristica_model->caracteristicas = $this->input->post('nidtbxcar');
		if ($this->Grupocaracteristica_model->validaInsercao()){
			$this->Grupocaracteristica_model->save();
			$this->session->set_flashdata('sucesso','Grupo de características cadastrado com sucesso');
			redirect(makeUrl('dci','grupocaracteristica','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Grupocaracteristica_model->error);
			$this->session->set_flashdata('cnomegrc',$this->Grupocaracteristica_model->descricao);
			redirect(makeUrl('dci','grupocaracteristica','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Grupocaracteristica_model->id = $this->validateGetId()->nidtbxgrc;
		$this->Grupocaracteristica_model->descricao = $this->input->post('cnomegrc');
		$this->Grupocaracteristica_model->caracteristicas = $this->input->post('nidtbxcar');
		if ($this->Grupocaracteristica_model->validaAtualizacao()){
			$this->Grupocaracteristica_model->save();
			$this->session->set_flashdata('sucesso','Grupo de características atualizado com sucesso');
			redirect(makeUrl('dci','grupocaracteristica','editar','?id='.$this->Grupocaracteristica_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Grupocaracteristica_model->error);
		$this->session->set_flashdata('cnomegrc',$this->Grupocaracteristica_model->descricao);
		redirect(makeUrl('dci','grupocaracteristica','editar','?id='.$this->Grupocaracteristica_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Grupocaracteristica_model->id = $this->validateGetId()->nidtbxgrc;
		if ($this->Grupocaracteristica_model->isAtivo()){
			$this->Grupocaracteristica_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Grupocaracteristica_model->delete();
			$this->session->set_flashdata('sucesso','Grupo de características desativada com sucesso');
			redirect(makeUrl('dci','grupocaracteristica','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Grupocaracteristica_model->error);
		redirect(makeUrl('dci','grupocaracteristica','visualizar'));
	}
}