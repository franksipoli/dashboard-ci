<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bem extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Grupobem_model');
		$this->load->model('dci/Bem_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$bem = Bem_model::getById($this->input->get('id'));
		if (!$bem){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','bem','visualizar'));
			exit();
		}
		return $bem;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir bem - Yoopay - Soluções Tecnológicas";
		$this->enqueue_script('app/js/cadimo/inserirbem.js');
		$this->data['grb'] = $this->Grupobem_model->getAll();
		$this->loadview('dci/bem/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$bem = $this->validateGetId();
		$this->data['bem'] = $bem;
		$this->data['grb'] = $this->Grupobem_model->getAll();
		$this->enqueue_script('app/js/cadimo/inserirbem.js');
		$this->data['grupos_escolhidos'] = $this->Grupobem_model->getByBem($bem->nidtbxbem);
		$this->data['quantidades'] = $this->Grupobem_model->getQuantidades($bem->nidtbxbem);
		$this->title = "Editar bem - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/bem/inserir');
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
		$this->title = "Visualizar bens - Yoopay - Soluções Tecnológicas";
		$this->data['bens'] = $this->Bem_model->getAll();
		$this->loadview('dci/bem/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Bem_model->descricao = $this->input->post('cnomebem');
		$this->Bem_model->grupos = $this->input->post('nidtbxgrb');
		$this->Bem_model->quantidades = $this->input->post('quantidade');
		if ($this->Bem_model->validaInsercao()){
			$this->Bem_model->save();
			$this->session->set_flashdata('sucesso','Bem cadastrado com sucesso');
			redirect(makeUrl('dci','bem','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Bem_model->error);
			$this->session->set_flashdata('cnomebem',$this->Bem_model->descricao);
			redirect(makeUrl('dci','bem','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Bem_model->id = $this->validateGetId()->nidtbxbem;
		$this->Bem_model->descricao = $this->input->post('cnomebem');
		$this->Bem_model->grupos = $this->input->post('nidtbxgrb');
		$this->Bem_model->quantidades = $this->input->post('quantidade');
		if ($this->Bem_model->validaAtualizacao()){
			$this->Bem_model->save();
			$this->session->set_flashdata('sucesso','Bem atualizado com sucesso');
			redirect(makeUrl('dci','bem','editar','?id='.$this->Bem_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Bem_model->error);
		$this->session->set_flashdata('cnomebem',$this->Bem_model->descricao);
		redirect(makeUrl('dci','bem','editar','?id='.$this->Bem_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Bem_model->id = $this->validateGetId()->nidtbxbem;
		if ($this->Bem_model->isAtivo()){
			$this->Bem_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Bem_model->delete();
			$this->session->set_flashdata('sucesso','Bem desativado com sucesso');
			redirect(makeUrl('dci','bem','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Bem_model->error);
		redirect(makeUrl('dci','bem','visualizar'));
	}
}