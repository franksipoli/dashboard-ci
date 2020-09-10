<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('seg/Segusuariotipo_model');
		$this->load->model('seg/Segusuario_model');
	}

	/* Chamada do controlador sem nenhum método definido */

	public function index()
	{
		$this->visualizar();
	}

	/* Visualização de registro */

	public function visualizar()
	{
		$this->title = "Visualizar Usuários - Yoopay - Soluções Tecnologicas";
		$this->data['usuarios'] = $this->Segusuario_model->getAll();
		$this->loadview('seg/usuario/lista');
	}

	/* Tela para inserção de registro */

	public function inserir()
	{
		$this->title = "Inserir Usuário - Yoopay - Soluções Tecnologicas";
		$this->enqueue_script('vendor/jquery-validation/dist/jquery.validate.js');
		$this->enqueue_script('app/js/usuario.js');
		$this->data['tipos'] = $this->Segusuariotipo_model->getAll();
		$this->loadview('seg/usuario/inserir');
	}

	/* Função para cadastrar registro no banco */

	public function insert()
	{
		$this->Segusuario_model->nome = $this->input->post('cnome');
		$this->Segusuario_model->login = $this->input->post('clogin');
		$this->Segusuario_model->tipo = $this->input->post('nidtbxtipousu');
		$this->Segusuario_model->senha = $this->input->post('senha');
		if ($this->Segusuario_model->validaInsercao()){
			/* Caso a validação de inserção retorne true, salva o registro */
			$this->Segusuario_model->save();
			$this->session->set_flashdata('sucesso','Usuário cadastrado com sucesso');
			redirect(makeUrl('seg','usuario','visualizar'));
		} else {
			/* Caso a validação da inserção retorne false, salva os dados preenchidos na sessão e retorna para a tela de cadastro */
			$this->session->set_flashdata('erro',$this->Segusuario_model->error);
			$this->session->set_flashdata('nome',$this->Segusuario_model->nome);
			$this->session->set_flashdata('login',$this->Segusuario_model->login);
			$this->session->set_flashdata('tipo',$this->Segusuario_model->tipo);
			redirect(makeUrl('seg','usuario','inserir'));
			return;
		}
	}

	/**
	* Função para trazer a lista de usuários através da busca por nome via AJAX
	* @access public
	* @param none
	* @return json lista de objetos
	*/

	public function buscarAjaxNome() {
		$term = $this->input->get('term');
		if (!$term)
			die();
		$results = $this->Segusuario_model->getByNome($term);
		$ui = array();
		foreach ($results as $result){
			$ui[] = array("id"=>$result->nidtbxsegusu,"value"=>$result->cnome,"label"=>$result->cnome);
		}
		die(json_encode($ui));
	}
	
}
