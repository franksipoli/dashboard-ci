<?php
	class Segacesso extends CI_Model {
		/* Variável que armazenará a instância do banco de dados */	
		private static $db;
		/* ID do usuário que será registrado */
		public $usuario_id;
		
		function __construct(){
			parent::__construct();
			self::$db = &get_instance()->db;
		}
		
		/**
		 * Função para fazer o registro de acesso do usuário
		 * @return ID do acesso que foi registrado ou false caso o usuário não tenha sido encontrado
		 * @access public
		 */
		
		public function registrar(){
			$usuario = $this->db->where('nidtbxsegusu',$this->usuario_id)->get('tbxsegusu')->row();
			/* Caso não for encontrado um usuário, retornar false */
			if (!$usuario)
				return false;
			$data = array("nidtbxsegusu"=>$usuario->nidtbxsegusu,"dtdatahora"=>date('Y-m-d H:i:s'),"clogin"=>$usuario->clogin);
			$this->db->insert('tbxace',$data);
			return $this->db->insert_id();
		}
	}
?>