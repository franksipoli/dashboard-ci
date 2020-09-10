<?php
	class Segusuariotipo extends CI_Model {
		/* Variável estática que contém a instância do banco de dados */	
		private static $db;
		function __construct(){
			parent::__construct();
			self::$db = &get_instance()->db;
		}
		
		/**
		 * Função para obter o usuário através do ID
		 * @param ID do usuário
		 * @return Objeto do usuário
		 * @access public
		 */
		
		static function getById($id){
			return self::$db->where('nidtbxsegtipo',$id)->get('tbxtipousu')->row();
		}
		
		/**
		 * Função para obter todos os tipos de usuário
		 * @return Array com a lista de tipos de usuário
		 * @access public
		 */
		
		public static function getAll(){
			$tipos = $this->db->get('tbxtipousu')->result();
			return $tipos;
		}
	}
?>