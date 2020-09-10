<?php
	class Statusatendimento_model extends MY_Model {

		public static $_table = 'tbxsat';
		public static $_idfield = 'nidtbxsat';

		public function getByCodigo($codigo){

			$this->db->where('ccodigo', $codigo);
			return $this->db->get(self::$_table)->row();

		}

	}