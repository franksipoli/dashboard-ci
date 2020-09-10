<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banco extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dcg/Banco_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$bco = Banco_model::getById($this->input->get('id'));
		if (!$bco){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dcg','banco','visualizar'));
			exit();
		}
		return $bco;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir banco - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/banco/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$bco = $this->validateGetId();
		$this->data['banco'] = $bco;
		$this->title = "Editar banco - Yoopay - Soluções Tecnológicas";
		$this->loadview('dcg/banco/inserir');
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
		$this->title = "Visualizar bancos - Yoopay - Soluções Tecnológicas";
		$this->data['bancos'] = $this->Banco_model->getAll();
		$this->loadview('dcg/banco/lista');
	}

	/**
	* Excluir ícone do registro
	*/

	public function excluiricone($id){
		$banco = $this->Banco_model->getById($id);
		@unlink('assets/app/img/banco/'.$banco->cicone);
		$this->Banco_model->id = $id;
		$this->Banco_model->removerIcone();
		$this->session->set_flashdata('sucesso', 'Ícone removido com sucesso');
		redirect(makeUrl("dcg", "banco", "editar", "?id=".$id));
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Banco_model->descricao = $this->input->post('cnomebco');
		$this->Banco_model->codigo = $this->input->post('ccodigo');
		if ($this->Banco_model->validaInsercao()){
			$r = move_uploaded_file($_FILES['userfile']['tmp_name'], 'assets/app/img/banco/'.$_FILES['userfile']['name']);
			$this->Banco_model->icone = $_FILES['userfile']['name'];
			$id = $this->Banco_model->save();
			$this->session->set_flashdata('sucesso','Banco cadastrado com sucesso');
			redirect(makeUrl('dcg','banco','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Banco_model->error);
			$this->session->set_flashdata('cnomebco',$this->Banco_model->descricao);
			redirect(makeUrl('dcg','banco','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Banco_model->id = $this->validateGetId()->nidtbxbco;
		$this->Banco_model->descricao = $this->input->post('cnomebco');
		$this->Banco_model->codigo = $this->input->post('ccodigo');
		if ($this->Banco_model->validaAtualizacao()){
			$r = move_uploaded_file($_FILES['userfile']['tmp_name'], 'assets/app/img/banco/'.$_FILES['userfile']['name']);
			if ($r){
				$this->Banco_model->icone = $_FILES['userfile']['name'];
			}
			$id = $this->Banco_model->save();
			$this->session->set_flashdata('sucesso','Banco atualizado com sucesso');
			redirect(makeUrl('dcg','banco','editar','?id='.$this->Banco_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Banco_model->error);
		$this->session->set_flashdata('cnomebco',$this->Banco_model->descricao);
		$this->session->set_flashdata('ccodigo',$this->Banco_model->codigo);
		redirect(makeUrl('dcg','banco','editar','?id='.$this->Banco_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir(){
	 	$this->Banco_model->id = $this->validateGetId()->nidtbxbco;
		if ($this->Banco_model->isAtivo()){
			$this->Banco_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Banco_model->delete();
			$this->session->set_flashdata('sucesso','Banco desativado com sucesso');
			redirect(makeUrl('dcg','banco','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Banco_model->error);
		redirect(makeUrl('dcg','banco','visualizar'));
	}
	
}