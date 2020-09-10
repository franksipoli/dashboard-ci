<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupobem extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Grupobem_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$grb = Grupobem_model::getById($this->input->get('id'));
		if (!$grb){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','grupobem','visualizar'));
			exit();
		}
		return $grb;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir grupo de bens - Yoopay - Soluções Tecnológicas";
		$this->enqueue_script('vendor/bootstrap-formhelpers/js/bootstrap-formhelpers.min.js');
		$this->enqueue_style('vendor/bootstrap-formhelpers/css/bootstrap-formhelpers.min.css');
		$this->loadview('dci/grupobem/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$grb = $this->validateGetId();
		$this->data['grb'] = $grb;
		$this->enqueue_script('vendor/bootstrap-formhelpers/js/bootstrap-formhelpers.min.js');
		$this->enqueue_style('vendor/bootstrap-formhelpers/css/bootstrap-formhelpers.min.css');
		$this->title = "Editar grupo de bens - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/grupobem/inserir');
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
		$this->title = "Visualizar grupos de bens - Yoopay - Soluções Tecnológicas";
		$this->data['grupos'] = $this->Grupobem_model->getAll();
		$this->loadview('dci/grupobem/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Grupobem_model->descricao = $this->input->post('cnomegrb');
		$this->Grupobem_model->cor = $this->input->post('ccor');
		if ($this->Grupobem_model->validaInsercao()){
			$this->Grupobem_model->save();
			$this->session->set_flashdata('sucesso','Grupo de bens cadastrado com sucesso');
			redirect(makeUrl('dci','grupobem','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Grupobem_model->error);
			$this->session->set_flashdata('cnomegrb',$this->Grupobem_model->descricao);
			$this->session->set_flashdata('ccor', $this->Grupobem->cor);
			redirect(makeUrl('dci','grupobem','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Grupobem_model->id = $this->validateGetId()->nidtbxgrb;
		$this->Grupobem_model->descricao = $this->input->post('cnomegrb');
		$this->Grupobem_model->cor = $this->input->post('ccor');
		if ($this->Grupobem_model->validaAtualizacao()){
			$this->Grupobem_model->save();
			$this->session->set_flashdata('sucesso','Grupo de bens atualizado com sucesso');
			redirect(makeUrl('dci','grupobem','editar','?id='.$this->Grupobem_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Grupobem_model->error);
		$this->session->set_flashdata('cnomegrb',$this->Grupobem_model->descricao);
		$this->session->set_flashdata('ccor',$this->Grupobem_model->cor);
		redirect(makeUrl('dci','grupobem','editar','?id='.$this->Grupobem_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Grupobem_model->id = $this->validateGetId()->nidtbxgrb;
		if ($this->Grupobem_model->isAtivo()){
			$this->Grupobem_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Grupobem_model->delete();
			$this->session->set_flashdata('sucesso','Grupo de bens desativado com sucesso');
			redirect(makeUrl('dci','grupobem','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Grupobem_model->error);
		redirect(makeUrl('dci','grupobem','visualizar'));
	}
}