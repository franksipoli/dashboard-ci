<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comochegou extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Comochegou_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/

	private function validateGetId()
	{
		$chg = Comochegou_model::getById($this->input->get('id'));
		if (!$chg){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','comochegou','visualizar'));
			exit();
		}
		return $chg;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = 'Inserir item de "como chegou" - Yoopay - Soluções Tecnológicas';
		$this->loadview('dcg/comochegou/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$chg = $this->validateGetId();
		$this->data['comochegou'] = $chg;
		$this->title = 'Editar item de "como chegou" - Yoopay - Soluções Tecnológicas';
		$this->loadview('dcg/comochegou/inserir');
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
		$this->title = 'Visualizar itens de "como chegou" - Yoopay - Soluções Tecnológicas';
		$this->data['itens'] = $this->Comochegou_model->getAll();
		$this->loadview('dcg/comochegou/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Comochegou_model->descricao = $this->input->post('cdescrichg');
		if ($this->Comochegou_model->validaInsercao()){
			$this->Comochegou_model->save();
			$this->session->set_flashdata('sucesso','Item cadastrado com sucesso');
			redirect(makeUrl('dcg','comochegou','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Comochegou_model->error);
			$this->session->set_flashdata('cdescrichg',$this->Comochegou_model->descricao);
			redirect(makeUrl('dcg','comochegou','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Comochegou_model->id = $this->validateGetId()->nidtbxchg;
		$this->Comochegou_model->descricao = $this->input->post('cdescrichg');
		if ($this->Comochegou_model->validaAtualizacao()){
			$this->Comochegou_model->save();
			$this->session->set_flashdata('sucesso','Item atualizado com sucesso');
			redirect(makeUrl('dcg','comochegou','editar','?id='.$this->Comochegou_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Comochegou_model->error);
		$this->session->set_flashdata('cdescrichg',$this->Comochegou_model->descricao);
		redirect(makeUrl('dcg','comochegou','editar','?id='.$this->Comochegou_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Comochegou_model->id = $this->validateGetId()->nidtbxchg;
		if ($this->Comochegou_model->isAtivo()){
			$this->Comochegou_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Comochegou_model->delete();
			$this->session->set_flashdata('sucesso','Item desativado com sucesso');
			redirect(makeUrl('dcg','comochegou','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Comochegou_model->error);
		redirect(makeUrl('dcg','comochegou','visualizar'));
	}
	
}