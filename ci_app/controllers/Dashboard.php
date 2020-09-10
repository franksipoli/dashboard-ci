<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->title = "Yoopay - Soluções Tecnologicas";
	}

	/**
	* Chamada para o controlador sem nenhum método
	*/

	public function index()
	{
		$this->load->model('Dashboard_model');
		$this->enqueue_script('app/js/dashboard/dashboard.js');
		$this->loadview('dashboard');
	}
	
}