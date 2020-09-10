<?php
	class Finalidadetipovalor_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tagfva";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtagfva";

		public static $dbstatic;
		
		/**
		* Função que pega as finalidades selecionadas para um tipo de valor
		* @param int ID do tipo de valor
		* @param boolean Se a finalidade deve ser principal
		* @return Array lista de IDS das finalidades
		*/

		function getByTipoValor($id, $principal = false)
		{
			$this->db->where('nidtbxtpv', $id);
			if ($principal)
				$this->db->where('nprincipal', 1);
			$result = $this->db->get(self::$_table)->result();
			$result_id = array();
			foreach ($result as $item){
				if (!in_array($item->nidtbxfin, $result_id))
					$result_id[] = $item->nidtbxfin;
			}
			return $result_id;
		}

		/**
		* Função que pega as relações para serem exibidas
		* @return Array lista de IDS das finalidades
		*/		

		public function getAllFront(){
			$fva = $this->getAll('nprincipal', 'DESC');
			$result = array();
			foreach ($fva as $item){
				$this->db->where('nidtbxtpv', $item->nidtbxtpv);
				$tpv = $this->db->get('tbxtpv')->row();
				$result[] = array('nidtagfva'=>$item->nidtagfva,'nidtbxfin'=>$item->nidtbxfin,'nidtbxtpv'=>$item->nidtbxtpv,'nprincipal'=>$item->nprincipal,'cnometpv'=>$tpv->cnometpv);
			}
			return $result;
		}

		/**
		* Função que retorna o valor para um Imóvel dentro de uma finalidade
		* @return decimal valor da diária para o finalidade/valor informado
		*/

		public static function getByImovelFinalidade($imovel_id, $finalidadevalor_id){

			self::$dbstatic = &get_instance()->db;

			self::$dbstatic->where('nidcadimo', $imovel_id);

			self::$dbstatic->where('nidtagfva', $finalidadevalor_id);

			$valor = self::$dbstatic->get('tbxiva')->row();

			return $valor->nvalor;

		}

}