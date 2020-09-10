<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipomedidadistancia extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipomedidadistancia_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tmd = Tipomedidadistancia_model::getById($this->input->get('id'));
		if (!$tmd){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipomedidadistancia','visualizar'));
			exit();
		}
		return $tmd;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de medida de distância - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipomedidadistancia/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tmd = $this->validateGetId();
		$this->data['tipomedidadistancia'] = $tmd;
		$this->title = "Editar tipo de medida de distância - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipomedidadistancia/inserir');
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
		$this->title = "Visualizar tipos de medida de distância - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipomedidadistancia_model->getAll();
		$this->loadview('dci/tipomedidadistancia/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipomedidadistancia_model->descricao = $this->input->post('cnometmd');
		$this->Tipomedidadistancia_model->sigla = $this->input->post('csiglatmd');
		if ($this->Tipomedidadistancia_model->validaInsercao()){
			$this->Tipomedidadistancia_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipomedidadistancia','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipomedidadistancia_model->error);
			$this->session->set_flashdata('cnometmd',$this->Tipomedidadistancia_model->descricao);
			$this->session->set_flashdata('csiglatmd',$this->Tipomedidadistancia_model->sigla);
			redirect(makeUrl('dci','tipomedidadistancia','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipomedidadistancia_model->id = $this->validateGetId()->nidtbxtmd;
		$this->Tipomedidadistancia_model->descricao = $this->input->post('cnometmd');
		$this->Tipomedidadistancia_model->sigla = $this->input->post('csiglatmd');
		if ($this->Tipomedidadistancia_model->validaAtualizacao()){
			$this->Tipomedidadistancia_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipomedidadistancia','editar','?id='.$this->Tipomedidadistancia_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipomedidadistancia_model->error);
		$this->session->set_flashdata('cnometmd',$this->Tipomedidadistancia_model->descricao);
		$this->session->set_flashdata('csiglatmd',$this->Tipomedidadistancia_model->sigla);
		redirect(makeUrl('dci','tipomedidadistancia','editar','?id='.$this->Tipomedidadistancia_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipomedidadistancia_model->id = $this->validateGetId()->nidtbxtmd;
		if ($this->Tipomedidadistancia_model->isAtivo()){
			$this->Tipomedidadistancia_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipomedidadistancia_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipomedidadistancia','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipomedidadistancia_model->error);
		redirect(makeUrl('dci','tipomedidadistancia','visualizar'));
	}
}