<?php
	class Tipofinanceiro_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxtpf";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtpf";

		/**
		* Função que retorna o ID do tipo de financeiro através do código
		* @param string código do tipo
		* @return ID do tipo
		* @access public
		*/

		public static function getIdByCod($cod){
			self::$db->where('ccodigo', $cod);
			$tpf = self::$db->get('tbxtpf')->row();
			return $tpf->nidtbxtpf;
		}

	}