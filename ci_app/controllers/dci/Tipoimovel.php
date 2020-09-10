<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipoimovel extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipoimovel_model');
		$this->load->model('dci/Tiposecundarioimovel_model');
		$this->load->model('dci/Grupocaracteristica_model');
		$this->load->model('dci/Caracteristica_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tpi = Tipoimovel_model::getById($this->input->get('id'));
		if (!$tpi){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipoimovel','visualizar'));
			exit();
		}
		return $tpi;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de Imóvel - Yoopay - Soluções Tecnológicas";
		$this->data['grupos'] = $this->Grupocaracteristica_model->getAll();
		$this->loadview('dci/tipoimovel/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tpi = $this->validateGetId();
		$this->data['tipoimovel'] = $tpi;
		$this->data['grupos'] = $this->Grupocaracteristica_model->getAll();
		$this->data['grupos_escolhidos'] = $this->Grupocaracteristica_model->getByTipoImovel($tpi->nidtbxtpi);
		$this->title = "Editar tipo de Imóvel - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipoimovel/inserir');
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
		$this->title = "Visualizar tipos de Imóvel - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipoimovel_model->getAll();
		$this->loadview('dci/tipoimovel/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipoimovel_model->descricao = $this->input->post('cnometpi');
		$this->Tipoimovel_model->grupos = $this->input->post('nidtbxgrc');
		if ($this->Tipoimovel_model->validaInsercao()){
			$this->Tipoimovel_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipoimovel','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipoimovel_model->error);
			$this->session->set_flashdata('cnometpi',$this->Tipoimovel_model->descricao);
			redirect(makeUrl('dci','tipoimovel','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipoimovel_model->id = $this->validateGetId()->nidtbxtpi;
		$this->Tipoimovel_model->descricao = $this->input->post('cnometpi');
		$this->Tipoimovel_model->grupos = $this->input->post('nidtbxgrc');
		if ($this->Tipoimovel_model->validaAtualizacao()){
			$this->Tipoimovel_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipoimovel','editar','?id='.$this->Tipoimovel_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoimovel_model->error);
		$this->session->set_flashdata('cnometpi',$this->Tipoimovel_model->descricao);
		redirect(makeUrl('dci','tipoimovel','editar','?id='.$this->Tipoimovel_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipoimovel_model->id = $this->validateGetId()->nidtbxtpi;
		if ($this->Tipoimovel_model->isAtivo()){
			$this->Tipoimovel_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipoimovel_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipoimovel','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipoimovel_model->error);
		redirect(makeUrl('dci','tipoimovel','visualizar'));
	}

	/*
	* Trazer os tipos secundários elencados com este tipo primário
	*/

	public function getSecundarios(){
		$nidtbxtpi = $this->input->post('nidtbxtpi');
		if (!$nidtbxtpi)
			die(json_encode(array('error'=>1,'message'=>'Tipo de Imóvel deve ser enviado')));
		$result = $this->Tiposecundarioimovel_model->getByTipoImovel($nidtbxtpi);
		die(json_encode($result));
	}

	/*
	* Trazer as características elencadas com este tipo primário
	*/

	public function getCaracteristicas(){
		$nidtbxtpi = $this->input->post('nidtbxtpi');
		$nidtbxfin = $this->input->post('nidtbxfin');
		if (!$nidtbxtpi)
			die(json_encode(array('error'=>1,'message'=>'Tipo de Imóvel deve ser enviado')));
		if (!$nidtbxfin)
			die(json_encode(array('error'=>1,'message'=>'Finalidade deve ser enviada')));
		$grupos_tpi = $this->Grupocaracteristica_model->getByTipoImovel($nidtbxtpi);
		$grupos_fin = $this->Grupocaracteristica_model->getByFinalidade($nidtbxfin);
		$result_id = array();
		$result = array();
		foreach ($grupos_tpi as $grupo){
			if (in_array($grupo, $grupos_fin)){
				/* Traz apenas as características que estejam em grupos comuns tanto ao tipo de Imóvel quanto à finalidade */
				$caracteristicas = $this->Caracteristica_model->getByGrupo($grupo);
				foreach ($caracteristicas as $caracteristica){
					if (!in_array($caracteristica, $result_id)){
						$result_id[] = $caracteristica;
						$car = $this->Caracteristica_model->getById($caracteristica);
						$result[] = array("id"=>$caracteristica,"nome"=>$car->cnomecar);
					}
				}
			}
		}
		die(json_encode($result));
	}

}