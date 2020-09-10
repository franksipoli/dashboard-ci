<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caracteristica extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Caracteristica_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$car = Caracteristica_model::getById($this->input->get('id'));
		if (!$car){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','caracteristica','visualizar'));
			exit();
		}
		return $car;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir característica - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/caracteristica/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$car = $this->validateGetId();
		$this->data['caracteristica'] = $car;
		$this->title = "Editar característica - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/caracteristica/inserir');
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
		$this->title = "Visualizar características - Yoopay - Soluções Tecnológicas";
		$this->data['caracteristicas'] = $this->Caracteristica_model->getAll();
		$this->loadview('dci/caracteristica/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Caracteristica_model->descricao = $this->input->post('cnomecar');
		if ($this->Caracteristica_model->validaInsercao()){
			$this->Caracteristica_model->save();
			$this->session->set_flashdata('sucesso','Característica cadastrada com sucesso');
			redirect(makeUrl('dci','caracteristica','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Caracteristica_model->error);
			$this->session->set_flashdata('cnomecar',$this->Caracteristica_model->descricao);
			redirect(makeUrl('dci','caracteristica','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Caracteristica_model->id = $this->validateGetId()->nidtbxcar;
		$this->Caracteristica_model->descricao = $this->input->post('cnomecar');
		if ($this->Caracteristica_model->validaAtualizacao()){
			$this->Caracteristica_model->save();
			$this->session->set_flashdata('sucesso','Característica atualizada com sucesso');
			redirect(makeUrl('dci','caracteristica','editar','?id='.$this->Caracteristica_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Caracteristica_model->error);
		$this->session->set_flashdata('cnomecar',$this->Caracteristica_model->descricao);
		redirect(makeUrl('dci','caracteristica','editar','?id='.$this->Caracteristica_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Caracteristica_model->id = $this->validateGetId()->nidtbxcar;
		if ($this->Caracteristica_model->isAtivo()){
			$this->Caracteristica_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Caracteristica_model->delete();
			$this->session->set_flashdata('sucesso','Característica desativada com sucesso');
			redirect(makeUrl('dci','caracteristica','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Caracteristica_model->error);
		redirect(makeUrl('dci','caracteristica','visualizar'));
	}
}