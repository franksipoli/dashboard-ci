<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feriado extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dep/Feriado_model');
	}
	
	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$fer = Feriado_model::getById($this->input->get('id'));
		if (!$fer){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dep','feriado','visualizar'));
			exit();
		}
		return $fer;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir feriado - Yoopay - Soluções Tecnológicas";
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('app/js/cadimo/feriado.js?v='.rand(1,9999));
		$this->loadview('dep/feriado/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$fer = $this->validateGetId();
		$this->data['feriado'] = $fer;
		$this->title = "Editar feriado - Yoopay - Soluções Tecnológicas";
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('app/js/cadimo/feriado.js?v='.rand(1,9999));
		$this->loadview('dep/feriado/inserir');
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
		$this->title = "Visualizar feriados - Yoopay - Soluções Tecnológicas";
		$this->data['feriados'] = $this->Feriado_model->getAll("ddata");
		$this->loadview('dep/feriado/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Feriado_model->descricao = $this->input->post('cdescrifer');
		$this->Feriado_model->data = $this->input->post('ddata');
		if ($this->Feriado_model->validaInsercao()){
			$this->Feriado_model->save();
			$this->session->set_flashdata('sucesso','Feriado cadastrado com sucesso');
			redirect(makeUrl('dep','feriado','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Feriado_model->error);
			$this->session->set_flashdata('cdescrifer',$this->Feriado_model->descricao);
			$this->session->set_flashdata('ddata', $this->Feriado_model->data);
			redirect(makeUrl('dep','feriado','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Feriado_model->id = $this->validateGetId()->nidtbxfer;
		$this->Feriado_model->descricao = $this->input->post('cdescrifer');
		$this->Feriado_model->data = $this->input->post('ddata');
		if ($this->Feriado_model->validaAtualizacao()){
			$this->Feriado_model->save();
			$this->session->set_flashdata('sucesso','Feriado atualizado com sucesso');
			redirect(makeUrl('dep','feriado','editar','?id='.$this->Feriado_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Feriado_model->error);
		$this->session->set_flashdata('cdescrifer',$this->Feriado_model->descricao);
		$this->session->set_flashdata('ddata',$this->Feriado_model->data);
		redirect(makeUrl('dep','feriado','editar','?id='.$this->Feriado_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Feriado_model->id = $this->validateGetId()->nidtbxfer;
		if ($this->Feriado_model->isAtivo()){
			$this->Feriado_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Feriado_model->delete();
			$this->session->set_flashdata('sucesso','Feriado desativado com sucesso');
			redirect(makeUrl('dep','feriado','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Feriado_model->error);
		redirect(makeUrl('dep','feriado','visualizar'));
	}
	
}