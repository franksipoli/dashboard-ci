<?php
	class Segacesso_model extends MY_Model {

		/* ID do usuário que será registrado */
		public $usuario_id;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tbxace";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtbxace";

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