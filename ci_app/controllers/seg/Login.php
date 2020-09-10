<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct()
	{
		
		parent::__construct();
		
		$this->title = 'Yoopay - Soluções Tecnologicas';
		
		/* Estendendo a variável template_path para a tela de login */
		$this->template_path = 'angle/login';
		
		/* Carregando o modelo de usuário */
		$this->load->model("seg/Segusuario_model");
		
		/* Carregando o modelo de registro de acesso */
		$this->load->model("seg/Segacesso_model");
	}
	
	/**
	* Chamada para o controlador sem nenhum método definido
	*/

	public function index()
	{
		$this->loadview('seg/login');
	}
	
	/**
	* Função para fazer logoff do usuário
	* @access public
	* @return redirecionar para a página de login com a sessão desfeita
	*/
	
	public function logoff()
	{
		$array_items = array('clogin', 'nidtbxtipousu', 'cnome', 'nidtbxsegusu');
		$this->session->unset_userdata($array_items);
		$this->session->set_flashdata('sucesso', 'Logoff realizado com sucesso');
		redirect('seg/login');
	}
	
	/**
	* Função para fazer o login do usuário
	* @access public
	* @return redirecionar para a página de dashboard em caso de sucesso e para a página de login em caso de erro
	*/
	
	public function login()
	{
		$login = $this->input->post('login');
		$senha = $this->input->post('senha');
		$this->Segusuario_model->login = $login;
		$this->Segusuario_model->senha = $senha;
		/* Tentar o login */
		$result = $this->Segusuario_model->dologin();
		if (isset($result['error'])){
			$this->session->set_flashdata('erro', $result['message']);
			redirect('seg/login');
		}
		/* Fazer registro de acesso */
		$this->Segacesso_model->usuario_id = $result['usuario']->nidtbxsegusu;
		$this->Segacesso_model->registrar();
		redirect('dashboard');
	}


	public function validarlogintoken()
	{
		


		$login = $this->input->post('login');
		$senha = $this->input->post('senha');
		$this->Segusuario_model->login = $login;
		$this->Segusuario_model->senha = $senha;
		/* Tentar o login */
		$result = $this->Segusuario_model->dologin();
		if (isset($result['error'])){
			$this->session->set_flashdata('erro', $result['message']);
			redirect('seg/login');
		}
		/* Fazer registro de acesso */
		$this->Segacesso_model->usuario_id = $result['usuario']->nidtbxsegusu;
		$this->Segacesso_model->registrar();
		redirect('dashboard');
	}
	
}
