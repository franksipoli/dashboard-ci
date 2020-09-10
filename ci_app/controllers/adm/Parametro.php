<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parametro extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('adm/Parametro_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/

	private function validateGetId()
	{
		$prm = Parametro_model::getById($this->input->get('id'));
		if (!$prm){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('adm','parametro','visualizar'));
			exit();
		}
		return $prm;
	}

	/**
	* Método que chama a tela de inserção
	*/

	public function inserir()
	{
		$this->title = "Inserir parâmetro - Yoopay - Soluções Tecnológicas";
		$this->loadview('adm/parametro/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$prm = $this->validateGetId();
		$this->data['parametro'] = $prm;
		$this->title = "Editar parâmetro - Yoopay - Soluções Tecnológicas";
		$this->loadview('adm/parametro/inserir');
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
		$this->title = "Visualizar parâmetros - Yoopay - Soluções Tecnológicas";
		$this->data['parametros'] = $this->Parametro_model->getAll();
		$this->loadview('adm/parametro/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{

		$this->Parametro_model->chave = $this->input->post('cchave');
		$this->Parametro_model->valor = $this->input->post('cvalor');
		if ($this->Parametro_model->validaInsercao()){
			$this->Parametro_model->save();
			$this->session->set_flashdata('sucesso','Parâmetro cadastrado com sucesso');
			redirect(makeUrl('adm','parametro','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Parametro_model->error);
			$this->session->set_flashdata('cchave',$this->Parametro_model->chave);
			$this->session->set_flashdata('cvalor',$this->Parametro_model->valor);
			redirect(makeUrl('adm','parametro','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Parametro_model->id = $this->validateGetId()->nidtbxprm;
		$this->Parametro_model->chave = $this->input->post('cchave');
		$this->Parametro_model->valor = $this->input->post('cvalor');
		if ($this->Parametro_model->validaAtualizacao()){
			$this->Parametro_model->save();
			$this->session->set_flashdata('sucesso','Parâmetro atualizado com sucesso');
			redirect(makeUrl('adm','parametro','editar','?id='.$this->Parametro_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Parametro_model->error);
		$this->session->set_flashdata('cchave',$this->Parametro_model->chave);
		$this->session->set_flashdata('cvalor',$this->Parametro_model->valor);
		redirect(makeUrl('adm','parametro','editar','?id='.$this->Parametro_model->id));
		return;
	}

	/**
	 * Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Parametro_model->id = $this->validateGetId()->nidtbxprm;
		if ($this->Parametro_model->isAtivo()){
			$this->Parametro_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Parametro_model->delete();
			$this->session->set_flashdata('sucesso','Parâmetro desativado com sucesso');
			redirect(makeUrl('adm','parametro','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Parametro_model->error);
		redirect(makeUrl('adm','parametro','visualizar'));
	}
}