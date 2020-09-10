<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My404 extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->title = "Yoopay - Soluções Tecnológicas - Em desenvolvimento";
	}

	/**
	* Chamada para o controlador sem nenhum método
	*/

	public function index()
	{
		$this->loadview('404');
	}
	
}