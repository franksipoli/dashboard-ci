<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoparentesco extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Tipoparentesco_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tpt = Tipoparentesco_model::getById($this->input->get('id'));
		if (!$tpt){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','tipoparentesco','visualizar'));
			exit();
		}
		return $tpt;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de parentesco - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipoparentesco/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpt = $this->validateGetId();
		$this->data['tipoparentesco'] = $tpt;
		$this->title = "Editar tipo de parentesco - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/tipoparentesco/inserir');
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
		$this->title = "Visualizar tipos de parentesco - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoparentesco_model->getAll();
		$this->loadview('dcg/tipoparentesco/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoparentesco_model->descricao = $this->input->post('cdescritpt');
		if ($this->Tipoparentesco_model->validaInsercao()){
			$this->Tipoparentesco_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dcg','tipoparentesco','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoparentesco_model->error);
			$this->session->set_flashdata('cdescritpt',$this->Tipoparentesco_model->descricao);
			redirect(makeUrl('dcg','tipoparentesco','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoparentesco_model->id = $this->validateGetId()->nidtbxtpt;
		$this->Tipoparentesco_model->descricao = $this->input->post('cdescritpt');
		if ($this->Tipoparentesco_model->validaAtualizacao()){
			$this->Tipoparentesco_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dcg','tipoparentesco','editar','?id='.$this->Tipoparentesco_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoparentesco_model->error);
		$this->session->set_flashdata('cdescritpt',$this->Tipoparentesco_model->descricao);
		redirect(makeUrl('dcg','tipoparentesco','editar','?id='.$this->Tipoparentesco_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipoparentesco_model->id = $this->validateGetId()->nidtbxtpt;
		if ($this->Tipoparentesco_model->isAtivo()){
			$this->Tipoparentesco_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoparentesco_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dcg','tipoparentesco','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoparentesco_model->error);
		redirect(makeUrl('dcg','tipoparentesco','visualizar'));
	}
}