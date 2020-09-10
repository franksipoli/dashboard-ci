<?php
	class MY_Controller extends CI_Controller {
		/** Array de variáveis que serão enviadas para a view */	
		public $data;
		/** Título da página que será enviado ao template */
		public $title;
		/** Variável que carrega o menu recursivo */
		public $menu;
		/** Lista de scripts a serem carregados no fim da página */
		public $scripts = array();
		/** Lista de arquivos HTML/PHP a serem carregados antes do </body> */
		public $includes_html = array();
		/** Lista de folhas de estilo a serem carregadas no início da página */
		public $styles = array();
		/** Caminho para o template que está sendo utilizado */
		protected $template_path = 'angle/index';
		
		public function __construct(){
			parent::__construct();
			$this->load->helper('url');
			$this->load->helper('custom');
			$this->load->model('seg/Segmenu_model');
			$this->menu = $this->Segmenu_model->loadLevel1(); 
			$this->enqueue_script('vendor/jquery-validation/dist/jquery.validate.js');
			if ($this->uri->segment(2)!="login"){
				$this->verificarLogin();
			}
		}
		
		/**
		 * Função para verificar se o usuário está logado. Verificação de permissões.
		 * @return redirect para a página de login caso não houver informação sobre o usuário na sessão
		 * @access private
		 */
		 
		private function verificarLogin(){
			$userdata = $this->session->userdata("nidtbxtipousu");
			// TODO verificar permissões
			if (!$userdata){
				redirect('seg/login');
			}
		}
		
		/**
		 * Função para adicionar um arquivo javascript ao rodapé da página
		 * @param URL relativa ao tema do script
		 * @access protected
		 * @return adiciona ao array de script o arquivo solicitado
		 */
		 
		protected function enqueue_script($url){
			if (strpos($url, '//') === false){
				$this->scripts[] = base_url('assets/'.$url);	
			} else {
				$this->scripts[] = $url;
			}
		}

		/**
		 * Função para adicionar um arquivo html/php ao rodapé da página
		 * @param URL relativa ao arquivo
		 * @access protected
		 * @return adiciona ao array de html o arquivo solicitado
		 */
		 
		protected function enqueue_html($url){
			$this->includes_html[] = $url;
		}
		
		/**
		 * Função para adicionar uma folha de estilos ao cabeçalho da página
		 * @param URL relativa ao tema do estilo
		 * @access protected
		 * @return adiciona ao array de estilos o arquivo solicitado
		 */
		 
		protected function enqueue_style($url){
			if (strpos($url, '//') === false){
				$this->styles[] = base_url('assets/'.$url);
			} else {
				$this->styles[] = $url;
			}
		}
		
		/**
		 * Função para carregar a view com base nas variáveis carregadas no controlador
		 * @param View que será carregada
		 * @access public
		 * @return template setado na variável $template_path com a view solicitada pelo controlador
		 */
		 
		public function loadview($view){
			$this->data['title'] = $this->title;
			$this->data['menu'] = $this->menu;
			$this->data['scripts'] = $this->scripts;
			$this->data['styles'] = $this->styles;
			$this->data['includes_html'] = $this->includes_html;
			$this->template->set('menuname', 'Menu Yoopay');
			$this->template->load('templates/'.$this->template_path,$view, $this->data);
		}

		/**
		 * Função para trazer o usuário que está logado
		 * @param none
		 * @access public
		 * @return integer ID do usuário logado
		 */

		public function getCurrentUser(){
			$userdata = $this->session->userdata("nidtbxsegusu");
			return !empty($userdata) ? $userdata : false;
		}
		
	}
?>