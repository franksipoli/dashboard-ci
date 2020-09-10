<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipocontrato extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cadimo/Tipocontrato_model');
		$this->enqueue_script('vendor/bootstrap-wysiwyg/bootstrap-wysiwyg.js');
		$this->enqueue_script('vendor/bootstrap-wysiwyg/external/jquery.hotkeys.js');
		$this->enqueue_script('app/js/wysiwyg.js');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$con = Tipocontrato_model::getById($this->input->get('id'));
		if (!$con){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('cadimo','tipocontrato','visualizar'));
			exit();
		}
		return $con;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de contrato - Yoopay - Soluções Tecnológicas";
		$this->loadview('imovel/tipocontrato/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$con = $this->validateGetId();
		$this->data['tipocontrato'] = $con;
		$this->title = "Editar tipo de contrato - Yoopay - Soluções Tecnológicas";
		$this->loadview('imovel/tipocontrato/inserir');
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
		$this->title = "Visualizar tipos de contrato - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipocontrato_model->getAll();
		$this->loadview('imovel/tipocontrato/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipocontrato_model->descricao = $this->input->post('cnomecon');
		$this->Tipocontrato_model->conteudo = $this->input->post('tconteudo');
		$this->Tipocontrato_model->codigo = $this->input->post('ccodcon');
		if ($this->Tipocontrato_model->validaInsercao()){
			$this->Tipocontrato_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('cadimo','tipocontrato','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipocontrato_model->error);
			$this->session->set_flashdata('cnomecon',$this->Tipocontrato_model->descricao);
			$this->session->set_flashdata('tconteudo',$this->Tipocontrato_model->conteudo);
			redirect(makeUrl('cadimo','tipocontrato','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipocontrato_model->id = $this->validateGetId()->nidtbxcon;
		$this->Tipocontrato_model->descricao = $this->input->post('cnomecon');
		$this->Tipocontrato_model->codigo = $this->input->post('ccodcon');
		$this->Tipocontrato_model->conteudo = $this->input->post('tconteudo');
		if ($this->Tipocontrato_model->validaAtualizacao()){
			$this->Tipocontrato_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('cadimo','tipocontrato','editar','?id='.$this->Tipocontrato_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocontrato_model->error);
		$this->session->set_flashdata('cnomecon',$this->Tipocontrato_model->descricao);
		$this->session->set_flashdata('tconteudo',$this->Tipocontrato_model->conteudo);
		redirect(makeUrl('cadimo','tipocontrato','editar','?id='.$this->Tipocontrato_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipocontrato_model->id = $this->validateGetId()->nidtbxcon;
		if ($this->Tipocontrato_model->isAtivo()){
			$this->Tipocontrato_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipocontrato_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('cadimo','tipocontrato','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipocontrato_model->error);
		redirect(makeUrl('cadimo','tipocontrato','visualizar'));
	}

}