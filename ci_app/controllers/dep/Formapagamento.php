<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formapagamento extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dep/Formapagamento_model');
		$this->load->model('dci/Finalidade_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$fpa = Formapagamento_model::getById($this->input->get('id'));
		if (!$fpa){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dep','formapagamento','visualizar'));
			exit();
		}
		return $fpa;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir forma de pagamento - Yoopay - Soluções Tecnológicas";
		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		$this->loadview('dep/formapagamento/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$fpa = $this->validateGetId();
		$this->data['formapagamento'] = $fpa;
		$this->data['fin_escolhidas'] = $this->Formapagamento_model->getIdsFinalidades($fpa->nidtbxfpa);
		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		$this->title = "Editar forma de pagamento - Yoopay - Soluções Tecnológicas";
		$this->loadview('dep/formapagamento/inserir');
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
		$this->title = "Visualizar formas de pagamento - Yoopay - Soluções Tecnológicas";
		$this->data['formas'] = $this->Formapagamento_model->getAll();
		$this->loadview('dep/formapagamento/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Formapagamento_model->descricao = $this->input->post('cnomefpa');
		$this->Formapagamento_model->finalidades = $this->input->post('nidtbxfin');
		if ($this->Formapagamento_model->validaInsercao()){
			$this->Formapagamento_model->save();
			$this->session->set_flashdata('sucesso','Forma cadastrada com sucesso');
			redirect(makeUrl('dep','formapagamento','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Formapagamento_model->error);
			$this->session->set_flashdata('cnomefpa',$this->Formapagamento_model->descricao);
			redirect(makeUrl('dep','formapagamento','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Formapagamento_model->id = $this->validateGetId()->nidtbxfpa;
		$this->Formapagamento_model->descricao = $this->input->post('cnomefpa');
		$this->Formapagamento_model->finalidades = $this->input->post('nidtbxfin');
		if ($this->Formapagamento_model->validaAtualizacao()){
			$this->Formapagamento_model->save();
			$this->session->set_flashdata('sucesso','Forma atualizada com sucesso');
			redirect(makeUrl('dep','formapagamento','editar','?id='.$this->Formapagamento_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Formapagamento_model->error);
		$this->session->set_flashdata('cnomefpa',$this->Formapagamento_model->descricao);
		redirect(makeUrl('dep','formapagamento','editar','?id='.$this->Formapagamento_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Formapagamento_model->id = $this->validateGetId()->nidtbxfpa;
		if ($this->Formapagamento_model->isAtivo()){
			$this->Formapagamento_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Formapagamento_model->delete();
			$this->session->set_flashdata('sucesso','Forma desativada com sucesso');
			redirect(makeUrl('dep','formapagamento','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Formapagamento_model->error);
		redirect(makeUrl('dep','formapagamento','visualizar'));
	}
	
}