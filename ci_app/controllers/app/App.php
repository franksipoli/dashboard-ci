<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('app/App_model');
	}

	/**
	* Função para configurar os dados da aplicação
	* @access public
	* @param Integer ID da aplicação
	* @return View com os dados da aplicação
	*/

	public function config( $app_id )
	{

		if( $app = $this->App_model->open( $app_id ) )
		{
			$this->title = 'Configurar campos em '.$app['app_name'];
			$this->data['app_id'] = $app_id;
			$this->data['fields'] = $app['fields'];
			$this->loadview('app/config_view', $this->data);
		} else {
			show_404();
		}

	}

	/**
	* Função para caso seja chamado o controlador sem método
	* @access public
	* @return chamada do método de visualizar
	*/	

	public function index()
	{
		$this->visualizar();
	}

	/**
	* Função para lista todas as aplicações do sistema
	* @access public
	* @return View com a lista de aplicações
	*/	

	public function visualizar()
	{
		
		$this->data['apps'] = $this->App_model->getAll();

		$this->title = "Aplicações - Campos Obrigatórios";

		$this->loadview("app/app_view", $this->data);

	}

	/**
	* Função para atualizar os dados da aplicação
	* @access public
	* @param Integer ID da aplicação
	* @return Redirect para a edição da aplicação com a mensagem de sucesso
	*/

	public function update( $app_id )
	{

		if( $app = $this->App_model->open( $app_id ) )
		{

			/* Recebe um array com os campos obrigatórios */

			$required = $this->input->post("required");

			$this->App_model->atualizarValidacoes( $required );

			$this->session->set_flashdata('sucesso','Validações atualizadas com sucesso');

			redirect( makeUrl('app/app','config',$app_id) );

			exit();

		} else {

			show_404();
		
		}

	}

}


