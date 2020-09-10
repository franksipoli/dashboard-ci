<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipovalor extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipovalor_model');
		$this->load->model('dci/Finalidade_model');
		$this->load->model('cadimo/Finalidadetipovalor_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tpv = Tipovalor_model::getById($this->input->get('id'));
		if (!$tpv){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipovalor','visualizar'));
			exit();
		}
		return $tpv;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de valor - Yoopay - Soluções Tecnológicas";
		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		$this->loadview('dci/tipovalor/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpv = $this->validateGetId();
		$this->data['tipovalor'] = $tpv;
		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		$this->data['finalidades_escolhidas'] = $this->Finalidadetipovalor_model->getByTipoValor($tpv->nidtbxtpv);
		$this->data['principais'] = $this->Finalidadetipovalor_model->getByTipoValor($tpv->nidtbxtpv, true);
		$this->title = "Editar tipo de valor - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipovalor/inserir');
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
		$this->title = "Visualizar tipos de valor - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipovalor_model->getAll();
		$this->loadview('dci/tipovalor/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipovalor_model->descricao = $this->input->post('cnometpv');
		$this->Tipovalor_model->rotulo = $this->input->post('clabel');
		$this->Tipovalor_model->finalidades = $this->input->post('nidtbxfin');
		$this->Tipovalor_model->principais = $this->input->post('nprincipal');
		if ($this->Tipovalor_model->validaInsercao()){
			$this->Tipovalor_model->save();
			$this->Tipovalor_model->setFinalidades();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipovalor','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipovalor_model->error);
			$this->session->set_flashdata('cnometpv',$this->Tipovalor_model->descricao);
			redirect(makeUrl('dci','tipovalor','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipovalor_model->id = $this->validateGetId()->nidtbxtpv;
		$this->Tipovalor_model->descricao = $this->input->post('cnometpv');
		$this->Tipovalor_model->rotulo = $this->input->post('clabel');
		$this->Tipovalor_model->finalidades = $this->input->post('nidtbxfin');
		$this->Tipovalor_model->principais = $this->input->post('nprincipal');
		if ($this->Tipovalor_model->validaAtualizacao()){
			$this->Tipovalor_model->save();
			$this->Tipovalor_model->setFinalidades();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipovalor','editar','?id='.$this->Tipovalor_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipovalor_model->error);
		$this->session->set_flashdata('cnometpv',$this->Tipovalor_model->descricao);
		redirect(makeUrl('dci','tipovalor','editar','?id='.$this->Tipovalor_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipovalor_model->id = $this->validateGetId()->nidtbxtpv;
		if ($this->Tipovalor_model->isAtivo()){
			$this->Tipovalor_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipovalor_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipovalor','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipovalor_model->error);
		redirect(makeUrl('dci','tipovalor','visualizar'));
	}
}