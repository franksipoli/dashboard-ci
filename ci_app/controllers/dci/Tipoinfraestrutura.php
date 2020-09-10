<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoinfraestrutura extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipoinfraestrutura_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tin = Tipoinfraestrutura_model::getById($this->input->get('id'));
		if (!$tin){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipoinfraestrutura','visualizar'));
			exit();
		}
		return $tin;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de infraestrutura - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoinfraestrutura/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tin = $this->validateGetId();
		$this->data['tipoinfraestrutura'] = $tin;
		$this->title = "Editar tipo de infraestrutura - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoinfraestrutura/inserir');
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
		$this->title = "Visualizar tipos de infraestrutura - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoinfraestrutura_model->getAll();
		$this->loadview('dci/tipoinfraestrutura/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoinfraestrutura_model->descricao = $this->input->post('cdescritin');
		if ($this->Tipoinfraestrutura_model->validaInsercao()){
			$this->Tipoinfraestrutura_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipoinfraestrutura','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoinfraestrutura_model->error);
			$this->session->set_flashdata('cdescritin',$this->Tipoinfraestrutura_model->descricao);
			redirect(makeUrl('dci','tipoinfraestrutura','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoinfraestrutura_model->id = $this->validateGetId()->nidtbxtin;
		$this->Tipoinfraestrutura_model->descricao = $this->input->post('cdescritin');
		if ($this->Tipoinfraestrutura_model->validaAtualizacao()){
			$this->Tipoinfraestrutura_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipoinfraestrutura','editar','?id='.$this->Tipoinfraestrutura_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoinfraestrutura_model->error);
		$this->session->set_flashdata('cdescritin',$this->Tipoinfraestrutura_model->descricao);
		redirect(makeUrl('dci','tipoinfraestrutura','editar','?id='.$this->Tipoinfraestrutura_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipoinfraestrutura_model->id = $this->validateGetId()->nidtbxtin;
		if ($this->Tipoinfraestrutura_model->isAtivo()){
			$this->Tipoinfraestrutura_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoinfraestrutura_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipoinfraestrutura','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoinfraestrutura_model->error);
		redirect(makeUrl('dci','tipoinfraestrutura','visualizar'));
	}
}