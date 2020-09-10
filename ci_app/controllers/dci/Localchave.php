<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Localchave extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Localchave_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$lch = Localchave_model::getById($this->input->get('id'));
		if (!$lch){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','localchave','visualizar'));
			exit();
		}
		return $lch;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir local de chave - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/localchave/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$lch = $this->validateGetId();
		$this->data['localchave'] = $lch;
		$this->title = "Editar local de chave - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/localchave/inserir');
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
		$this->title = "Visualizar locais de chaves - Yoopay - Soluções Tecnológicas";
		$this->data['locais'] = $this->Localchave_model->getAll();
		$this->loadview('dci/localchave/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Localchave_model->descricao = $this->input->post('cnomelch');
		$this->Localchave_model->controle = $this->input->post('ncontrole');
		if ($this->Localchave_model->validaInsercao()){
			$this->Localchave_model->save();
			$this->session->set_flashdata('sucesso','Local cadastrado com sucesso');
			redirect(makeUrl('dci','localchave','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Localchave_model->error);
			$this->session->set_flashdata('cnomelch',$this->Localchave_model->descricao);
			$this->session->set_flashdata('ncontrole', $this->Localchave_model->controle);
			redirect(makeUrl('dci','localchave','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Localchave_model->id = $this->validateGetId()->nidtbxlch;
		$this->Localchave_model->controle = $this->input->post('ncontrole');
		$this->Localchave_model->descricao = $this->input->post('cnomelch');
		if ($this->Localchave_model->validaAtualizacao()){
			$this->Localchave_model->save();
			$this->session->set_flashdata('sucesso','Local atualizado com sucesso');
			redirect(makeUrl('dci','localchave','editar','?id='.$this->Localchave_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Localchave_model->error);
		$this->session->set_flashdata('ncontrole', $this->Localchave_model->controle);
		$this->session->set_flashdata('cnomelch',$this->Localchave_model->descricao);
		redirect(makeUrl('dci','localchave','editar','?id='.$this->Localchave_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Localchave_model->id = $this->validateGetId()->nidtbxlch;
		if ($this->Localchave_model->isAtivo()){
			$this->Localchave_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Localchave_model->delete();
			$this->session->set_flashdata('sucesso','Local desativado com sucesso');
			redirect(makeUrl('dci','localchave','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Localchave_model->error);
		redirect(makeUrl('dci','localchave','visualizar'));
	}
}