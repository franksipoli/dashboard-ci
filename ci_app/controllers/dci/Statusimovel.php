<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statusimovel extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Statusimovel_model');
		$this->load->model('dci/Finalidade_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$sti = Statusimovel_model::getById($this->input->get('id'));
		if (!$sti){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','statusimovel','visualizar'));
			exit();
		}
		return $sti;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir status do Produto - Yoopay - Soluções Tecnológicas";
		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		$this->loadview('dci/statusimovel/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$sti = $this->validateGetId();
		$this->data['statusimovel'] = $sti;
		$this->data['finalidades'] = $this->Finalidade_model->getAll();
		$this->title = "Editar status do Produto - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/statusimovel/inserir');
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
		$this->title = "Visualizar status do Produto - Yoopay - Soluções Tecnológicas";
		$this->data['status'] = $this->Statusimovel_model->getAll();
		$this->loadview('dci/statusimovel/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Statusimovel_model->descricao = $this->input->post('cdescristi');
		$this->Statusimovel_model->finalidade = $this->input->post('nidtbxfin');
		if ($this->Statusimovel_model->validaInsercao()){
			$this->Statusimovel_model->save();
			$this->session->set_flashdata('sucesso','Status cadastrado com sucesso');
			redirect(makeUrl('dci','statusimovel','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Statusimovel_model->error);
			$this->session->set_flashdata('cdescristi',$this->Statusimovel_model->descricao);
			$this->session->set_flashdata('nidtbxfin',$this->Statusimovel_model->finalidade);
			redirect(makeUrl('dci','statusimovel','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Statusimovel_model->id = $this->validateGetId()->nidtbxsti;
		$this->Statusimovel_model->descricao = $this->input->post('cdescristi');
		$this->Statusimovel_model->finalidade = $this->input->post('nidtbxfin');
		if ($this->Statusimovel_model->validaAtualizacao()){
			$this->Statusimovel_model->save();
			$this->session->set_flashdata('sucesso','Status atualizado com sucesso');
			redirect(makeUrl('dci','statusimovel','editar','?id='.$this->Statusimovel_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Statusimovel_model->error);
		$this->session->set_flashdata('cdescristi',$this->Statusimovel_model->descricao);
		$this->session->set_flashdata('nidtbxfin',$this->Statusimovel_model->finalidade);
		redirect(makeUrl('dci','statusimovel','editar','?id='.$this->Statusimovel_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Statusimovel_model->id = $this->validateGetId()->nidtbxsti;
		if ($this->Statusimovel_model->isAtivo()){
			$this->Statusimovel_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Statusimovel_model->delete();
			$this->session->set_flashdata('sucesso','Status desativado com sucesso');
			redirect(makeUrl('dci','statusimovel','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Statusimovel_model->error);
		redirect(makeUrl('dci','statusimovel','visualizar'));
	}

	/**
	* Função para obter a lista de status de imóveis que pertencem a uma finalidade
	*/

	public function getByFinalidade(){
		$nidtbxfin = $this->input->post('nidtbxfin');
		if (!$nidtbxfin){
			die(json_encode(""));
		}
		$status = $this->Statusimovel_model->getByFinalidade($nidtbxfin);
		die(json_encode($status));
	}

}