<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nacionalidade extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dep/Nacionalidade_model');
	}
	
	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$nac = Nacionalidade_model::getById($this->input->get('id'));
		if (!$nac){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dep','nacionalidade','visualizar'));
			exit();
		}
		return $nac;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir nacionalidade - Yoopay - Soluções Tecnológicas";
		$this->loadview('dep/nacionalidade/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$nac = $this->validateGetId();
		$this->data['nacionalidade'] = $nac;
		$this->title = "Editar nacionalidade - Yoopay - Soluções Tecnológicas";
		$this->loadview('dep/nacionalidade/inserir');
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
		$this->title = "Visualizar nacionalidades - Yoopay - Soluções Tecnológicas";
		$this->data['nacionalidades'] = $this->Nacionalidade_model->getAll(["nprincipal"=>"DESC", "cdescrinac"=>"ASC"]);
		$this->loadview('dep/nacionalidade/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Nacionalidade_model->descricao = $this->input->post('cdescrinac');
		if ($this->Nacionalidade_model->validaInsercao()){
			$this->Nacionalidade_model->save();
			$this->session->set_flashdata('sucesso','Nacionalidade cadastrada com sucesso');
			redirect(makeUrl('dep','nacionalidade','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Nacionalidade_model->error);
			$this->session->set_flashdata('cdescrinac',$this->Nacionalidade_model->descricao);
			redirect(makeUrl('dep','nacionalidade','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Nacionalidade_model->id = $this->validateGetId()->nidtbxnac;
		$this->Nacionalidade_model->descricao = $this->input->post('cdescrinac');
		if ($this->Nacionalidade_model->validaAtualizacao()){
			$this->Nacionalidade_model->save();
			$this->session->set_flashdata('sucesso','Nacionalidade atualizada com sucesso');
			redirect(makeUrl('dep','nacionalidade','editar','?id='.$this->Nacionalidade_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Nacionalidade_model->error);
		$this->session->set_flashdata('cdescrinac',$this->Nacionalidade_model->descricao);
		redirect(makeUrl('dep','nacionalidade','editar','?id='.$this->Nacionalidade_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Nacionalidade_model->id = $this->validateGetId()->nidtbxnac;
		if ($this->Nacionalidade_model->isAtivo()){
			$this->Nacionalidade_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Nacionalidade_model->delete();
			$this->session->set_flashdata('sucesso','Nacionalidade desativada com sucesso');
			redirect(makeUrl('dep','nacionalidade','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Nacionalidade_model->error);
		redirect(makeUrl('dep','nacionalidade','visualizar'));
	}
	
}