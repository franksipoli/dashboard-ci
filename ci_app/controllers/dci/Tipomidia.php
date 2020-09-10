<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipomidia extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipomidia_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$mid = Tipomidia_model::getById($this->input->get('id'));
		if (!$mid){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipomidia','visualizar'));
			exit();
		}
		return $mid;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de mídia - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipomidia/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$mid = $this->validateGetId();
		$this->data['tipomidia'] = $mid;
		$this->title = "Editar tipo de mídia - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipomidia/inserir');
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
		$this->title = "Visualizar tipos de mídia - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipomidia_model->getAll();
		$this->loadview('dci/tipomidia/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipomidia_model->nome = $this->input->post('cnomemid');
		$this->Tipomidia_model->descricao = $this->input->post('cdescrimid');
		$this->Tipomidia_model->largura = $this->input->post('nwidth');
		$this->Tipomidia_model->altura = $this->input->post('nheight');
		$this->Tipomidia_model->largura_thumb = $this->input->post('nwidththu');
		$this->Tipomidia_model->altura_thumb = $this->input->post('nheightthu');
		$this->Tipomidia_model->pasta = $this->input->post('cfoldermid');
		if ($this->Tipomidia_model->validaInsercao()){
			$this->Tipomidia_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipomidia','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipomidia_model->error);
			$this->session->set_flashdata('cnomemid',$this->Tipomidia_model->nome);
			$this->session->set_flashdata('cdescrimid',$this->Tipomidia_model->descricao);
			$this->session->set_flashdata('nwidth',$this->Tipomidia_model->largura);
			$this->session->set_flashdata('nheight',$this->Tipomidia_model->altura);
			$this->session->set_flashdata('nwidththu',$this->Tipomidia_model->largura_thumb);
			$this->session->set_flashdata('nheightthu',$this->Tipomidia_model->altura_thumb);
			$this->session->set_flashdata('cfoldermid',$this->Tipomidia_model->pasta);
			redirect(makeUrl('dci','tipomidia','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipomidia_model->id = $this->validateGetId()->nidtbxmid;
		$this->Tipomidia_model->nome = $this->input->post('cnomemid');
		$this->Tipomidia_model->descricao = $this->input->post('cdescrimid');
		$this->Tipomidia_model->largura = $this->input->post('nwidth');
		$this->Tipomidia_model->altura = $this->input->post('nheight');
		$this->Tipomidia_model->largura_thumb = $this->input->post('nwidththu');
		$this->Tipomidia_model->altura_thumb = $this->input->post('nheightthu');
		$this->Tipomidia_model->pasta = $this->input->post('cfoldermid');
		if ($this->Tipomidia_model->validaAtualizacao()){
			$this->Tipomidia_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipomidia','editar','?id='.$this->Tipomidia_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipomidia_model->error);
		$this->session->set_flashdata('cnomemid',$this->Tipomidia_model->nome);
		$this->session->set_flashdata('cdescrimid',$this->Tipomidia_model->descricao);
		$this->session->set_flashdata('nwidth',$this->Tipomidia_model->largura);
		$this->session->set_flashdata('nheight',$this->Tipomidia_model->altura);
		$this->session->set_flashdata('nwidththu',$this->Tipomidia_model->largura_thumb);
		$this->session->set_flashdata('nheightthu',$this->Tipomidia_model->altura_thumb);
		$this->session->set_flashdata('cfoldermid',$this->Tipomidia_model->pasta);
		redirect(makeUrl('dci','tipomidia','editar','?id='.$this->Tipomidia_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipomidia_model->id = $this->validateGetId()->nidtbxmid;
		if ($this->Tipomidia_model->isAtivo()){
			$this->Tipomidia_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipomidia_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipomidia','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipomidia_model->error);
		redirect(makeUrl('dci','tipomidia','visualizar'));
	}
}