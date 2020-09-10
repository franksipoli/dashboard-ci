<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uf extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dep/Pais_model');
		$this->load->model('dep/Uf_model');
		$this->load->model('dep/Localidade_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$uf = Uf_model::getById($this->input->get('id'));
		if (!$uf){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dep','uf','visualizar'));
			exit();
		}
		return $uf;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir unidade federativa - Yoopay - Soluções Tecnológicas";
		$this->data['lista_paises'] = $this->Pais_model->getAll("cdescripas");
		$this->loadview('dep/uf/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$uf = $this->validateGetId();
		$this->data['uf'] = $uf;
		$this->data['lista_paises'] = $this->Pais_model->getAll("cdescripas");
		$this->title = "Editar Unidade Federativa - Yoopay - Soluções Tecnológicas";
		$this->loadview('dep/uf/inserir');
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
		$this->title = "Visualizar unidades federativas - Yoopay - Soluções Tecnológicas";
		$this->data['ufs'] = $this->Uf_model->getAll(array('nidtbxpas'=>'ASC','csiglauf'=>'ASC','cdescriuf'=>'ASC'));
		$this->loadview('dep/uf/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Uf_model->sigla = $this->input->post('csiglauf');
		$this->Uf_model->descricao = $this->input->post('cdescriuf');
		$this->Uf_model->pais = $this->input->post('nidtbxpas');
		if ($this->Uf_model->validaInsercao()){
			$this->Uf_model->save();
			$this->session->set_flashdata('sucesso','UF cadastrada com sucesso');
			redirect(makeUrl('dep','uf','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Uf_model->error);
			$this->session->set_flashdata('nidtbxpas',$this->Uf_model->pais);
			$this->session->set_flashdata('csiglauf',$this->Uf_model->sigla);
			$this->session->set_flashdata('cdescriuf',$this->Pais_model->descricao);
			redirect(makeUrl('dep','uf','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/
	public function update()
	{
		$this->Uf_model->id = $this->validateGetId()->nidtbxuf;
		$this->Uf_model->descricao = $this->input->post('cdescriuf');
		$this->Uf_model->sigla = $this->input->post('csiglauf');
		$this->Uf_model->pais = $this->input->post('nidtbxpas');
		if ($this->Uf_model->validaAtualizacao()){
			$this->Uf_model->save();
			$this->session->set_flashdata('sucesso','UF atualizada com sucesso');
			redirect(makeUrl('dep','uf','editar','?id='.$this->Uf_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Uf_model->error);
		$this->session->set_flashdata('cdescriuf',$this->Uf_model->descricao);
		$this->session->set_flashdata('csiglauf',$this->Uf_model->sigla);
		$this->session->set_flashdata('nidtbxpas',$this->Uf_model->pais);
		redirect(makeUrl('dep','uf','editar','?id='.$this->Uf_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/
	
	public function excluir()
	{
	 	$this->Uf_model->id = $this->validateGetId()->nidtbxuf;
		if ($this->Uf_model->isAtivo()){
			$this->Uf_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Uf_model->delete();
			$this->session->set_flashdata('sucesso','UF desativada com sucesso');
			redirect(makeUrl('dep','uf','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Uf_model->error);
		redirect(makeUrl('dep','uf','visualizar'));
	}

	/**
	* Função para trazer a lista de cidades através da busca por nome
	* @access public
	* @param none
	* @return json lista de objetos
	*/

	public function buscarAjaxLocalizacao() {
		$term = $this->input->get('term');
		if (!$term)
			die();
		$results = $this->Localidade_model->getByNome($term);
		$ui = array();
		foreach ($results as $result){
			$ui[] = array("id"=>$result->nidtbxloc,"value"=>$result->cdescriloc,"label"=>$result->cdescriloc);
		}
		die(json_encode($ui));
	}

	/**
	* Função para trazer a lista de estados com base em um país
	* @access public
	* @param none
	* @return json lista de objetos
	*/

	public function getByPais(){
		$pais = $this->input->get('pais');
		$result = array();
		if (!$pais){
			die(json_encode($result));
		}
		$results = $this->Uf_model->getByPais($pais);
		foreach ($results as $uf){
			$result[] = array("nidtbxuf"=>$uf->nidtbxuf, "cdescriuf"=>$uf->cdescriuf, "csiglauf"=>$uf->csiglauf);
		}
		die(json_encode($result));
	}
	
}