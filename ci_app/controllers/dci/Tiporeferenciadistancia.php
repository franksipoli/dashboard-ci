<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiporeferenciadistancia extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tiporeferenciadistancia_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$trd = Tiporeferenciadistancia_model::getById($this->input->get('id'));
		if (!$trd){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tiporeferenciadistancia','visualizar'));
			exit();
		}
		return $trd;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de referência de distância - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tiporeferenciadistancia/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$trd = $this->validateGetId();
		$this->data['tiporeferenciadistancia'] = $trd;
		$this->title = "Editar tipo de referência de distância - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tiporeferenciadistancia/inserir');
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
		$this->title = "Visualizar tipos de referência de distância - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tiporeferenciadistancia_model->getAll();
		$this->loadview('dci/tiporeferenciadistancia/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tiporeferenciadistancia_model->descricao = $this->input->post('cnometrd');
		if ($this->Tiporeferenciadistancia_model->validaInsercao()){
			$this->Tiporeferenciadistancia_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tiporeferenciadistancia','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tiporeferenciadistancia_model->error);
			$this->session->set_flashdata('cnometrd',$this->Tiporeferenciadistancia_model->descricao);
			redirect(makeUrl('dci','tiporeferenciadistancia','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tiporeferenciadistancia_model->id = $this->validateGetId()->nidtbxtrd;
		$this->Tiporeferenciadistancia_model->descricao = $this->input->post('cnometrd');
		if ($this->Tiporeferenciadistancia_model->validaAtualizacao()){
			$this->Tiporeferenciadistancia_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tiporeferenciadistancia','editar','?id='.$this->Tiporeferenciadistancia_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tiporeferenciadistancia_model->error);
		$this->session->set_flashdata('cnometrd',$this->Tiporeferenciadistancia_model->descricao);
		redirect(makeUrl('dci','tiporeferenciadistancia','editar','?id='.$this->Tiporeferenciadistancia_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tiporeferenciadistancia_model->id = $this->validateGetId()->nidtbxtrd;
		if ($this->Tiporeferenciadistancia_model->isAtivo()){
			$this->Tiporeferenciadistancia_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tiporeferenciadistancia_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tiporeferenciadistancia','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tiporeferenciadistancia_model->error);
		redirect(makeUrl('dci','tiporeferenciadistancia','visualizar'));
	}
}