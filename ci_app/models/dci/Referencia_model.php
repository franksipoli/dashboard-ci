<?php
	class Referencia_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "cadref";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidcadref";
		
		public $id;
		public $imovel;
		public $usuario_criacao;
	
		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/		
		
		public function save()
		{
			if ($this->id){
				/* Atualizar */
				$data = array(
					'nidcadimo' => $this->imovel
				);
				$this->db->where('nidcadref', $this->id);
				$this->db->update('cadref', $data);
				return true;				
			} else {
				/* Criar */
				$data = array(
					'nidtbxsegusu_criacao'=>$this->usuario_criacao,
					'dtdatacriacao'=>date('Y-m-d H:i:s')
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

	}