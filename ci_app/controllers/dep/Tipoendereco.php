<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoendereco extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dep/Tipoendereco_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tpe = Tipoendereco_model::getById($this->input->get('id'));
		if (!$tpe){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dep','tipoendereco','visualizar'));
			exit();
		}
		return $tpe;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de endereço - Yoopay - Soluções Tecnológicas";
		$this->loadview('dep/tipoendereco/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpe = $this->validateGetId();
		$this->data['tipoendereco'] = $tpe;
		$this->title = "Editar tipo de endereço - Yoopay - Soluções Tecnológicas";
		$this->loadview('dep/tipoendereco/inserir');
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
		$this->title = "Visualizar tipos de endereço - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoendereco_model->getAll();
		$this->loadview('dep/tipoendereco/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoendereco_model->descricao = $this->input->post('cdescritpe');
		if ($this->Tipoendereco_model->validaInsercao()){
			$this->Tipoendereco_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dep','tipoendereco','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoendereco_model->error);
			$this->session->set_flashdata('cdescritpe',$this->Tipoendereco_model->descricao);
			redirect(makeUrl('dep','tipoendereco','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoendereco_model->id = $this->validateGetId()->nidtbxtpe;
		$this->Tipoendereco_model->descricao = $this->input->post('cdescritpe');
		if ($this->Tipoendereco_model->validaAtualizacao()){
			$this->Tipoendereco_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dep','tipoendereco','editar','?id='.$this->Tipoendereco_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoendereco_model->error);
		$this->session->set_flashdata('cdescritpe',$this->Tipoendereco_model->descricao);
		redirect(makeUrl('dep','tipoendereco','editar','?id='.$this->Tipoendereco_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Tipoendereco_model->id = $this->validateGetId()->nidtbxtpe;
		if ($this->Tipoendereco_model->isAtivo()){
			$this->Tipoendereco_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoendereco_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dep','tipoendereco','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoendereco_model->error);
		redirect(makeUrl('dep','tipoendereco','visualizar'));
	}
	
}