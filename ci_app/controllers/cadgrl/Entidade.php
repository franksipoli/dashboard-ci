<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entidade extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cadgrl/Entidade_model');
		$this->load->model('cadgrl/Cadastro_model');
		$this->load->model('cadgrl/Pessoajuridica_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$ent = Entidade_model::getById($this->input->get('id'));
		if (!$ent){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('cadgrl','entidade','visualizar'));
			exit();
		}
		return $ent;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir entidade - Yoopay - Soluções Tecnológicas";
		$this->data['entidades'] = $this->Entidade_model->getPais();
		$this->enqueue_script('app/js/entidade/entidade.js?v='.rand(1,9999));
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->loadview('entidade/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$ent = $this->validateGetId();
		$this->data['entidade'] = $ent;
		$this->title = "Editar entidade - Yoopay - Soluções Tecnológicas";
		$this->loadview('entidade/inserir');
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
		$this->title = "Visualizar entidades - Yoopay - Soluções Tecnológicas";
		$entidades = $this->Entidade_model->getAll();
		foreach ($entidades as $entidade){
			$data = array("nidtbxent"=>$entidade->nidtbxent);
			if ($entidade->nidcadgrl){
				$data['cadgrl'] = $this->Cadastro_model->getById($entidade->nidcadgrl);
			} elseif ($entidade->nidcadjur){
				$data['cadjur'] = $this->Pessoajuridica_model->getById($entidade->nidcadjur);
			}
			$this->data['entidades'][] = $data;
		}
		$this->loadview('entidade/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Caracteristica_model->descricao = $this->input->post('cnomecar');
		if ($this->Caracteristica_model->validaInsercao()){
			$this->Caracteristica_model->save();
			$this->session->set_flashdata('sucesso','Característica cadastrada com sucesso');
			redirect(makeUrl('cadgrl','entidade','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Caracteristica_model->error);
			$this->session->set_flashdata('cnomecar',$this->Caracteristica_model->descricao);
			redirect(makeUrl('cadgrl','entidade','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Caracteristica_model->id = $this->validateGetId()->nidtbxcar;
		$this->Caracteristica_model->descricao = $this->input->post('cnomecar');
		if ($this->Caracteristica_model->validaAtualizacao()){
			$this->Caracteristica_model->save();
			$this->session->set_flashdata('sucesso','Característica atualizada com sucesso');
			redirect(makeUrl('cadgrl','entidade','editar','?id='.$this->Caracteristica_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Caracteristica_model->error);
		$this->session->set_flashdata('cnomecar',$this->Caracteristica_model->descricao);
		redirect(makeUrl('cadgrl','entidade','editar','?id='.$this->Caracteristica_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Entidade_model->id = $this->validateGetId()->nidtbxent;
		if ($this->Entidade_model->isAtivo()){
			$this->Entidade_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Entidade_model->delete();
			$this->session->set_flashdata('sucesso','Entidade desativada com sucesso');
			redirect(makeUrl('cadgrl','entidade','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Entidade_model->error);
		redirect(makeUrl('cadgrl','entidade','visualizar'));
	}
}