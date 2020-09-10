<?php
	
	class Tipologradouro_model extends MY_Model {

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tbxtpl";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtbxtpl";

		/**
		 * Função para trazer todos os registros ativos no banco de dados
		 * @param (String|Array) campo para ordenação.
		 * @param (String) campo para setar se a ordem do campo escolhido no primeiro parâmetro é crescente ou decrescente
		 * @return Lista com todos os registros
		 * @access public
		 */
		
		public function getAll($field_order=null, $order = "ASC"){
			$this->db->order_by('nordem', 'ASC');
			$this->db->where('nativo', 1);
			$this->db->where('dtdataexc IS NULL');
			/** Obtém os registros da tabela setada no controlador */
			$items = $this->db->get(self::$_table)->result();
			return $items;
		}

	}
?>