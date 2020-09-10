<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoocupacao extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipoocupacao_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$ocu = Tipoocupacao_model::getById($this->input->get('id'));
		if (!$ocu){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipoocupacao','visualizar'));
			exit();
		}
		return $ocu;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de ocupação - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoocupacao/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$ocu = $this->validateGetId();
		$this->data['tipoocupacao'] = $ocu;
		$this->title = "Editar tipo de ocupação - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoocupacao/inserir');
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
		$this->title = "Visualizar tipos de ocupação - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoocupacao_model->getAll();
		$this->loadview('dci/tipoocupacao/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoocupacao_model->descricao = $this->input->post('cnomeocu');
		if ($this->Tipoocupacao_model->validaInsercao()){
			$this->Tipoocupacao_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipoocupacao','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoocupacao_model->error);
			$this->session->set_flashdata('cnomeocu',$this->Tipoocupacao_model->descricao);
			redirect(makeUrl('dci','tipoocupacao','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoocupacao_model->id = $this->validateGetId()->nidtbxocu;
		$this->Tipoocupacao_model->descricao = $this->input->post('cnomeocu');
		if ($this->Tipoocupacao_model->validaAtualizacao()){
			$this->Tipoocupacao_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipoocupacao','editar','?id='.$this->Tipoocupacao_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoocupacao_model->error);
		$this->session->set_flashdata('cnomeocu',$this->Tipoocupacao_model->descricao);
		redirect(makeUrl('dci','tipoocupacao','editar','?id='.$this->Tipoocupacao_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipoocupacao_model->id = $this->validateGetId()->nidtbxocu;
		if ($this->Tipoocupacao_model->isAtivo()){
			$this->Tipoocupacao_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoocupacao_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipoocupacao','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoocupacao_model->error);
		redirect(makeUrl('dci','tipoocupacao','visualizar'));
	}
}