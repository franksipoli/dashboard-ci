<?php
	class Segmenu_model extends MY_Model {
		
		/**
		* Função estática para retornar os itens do menu que não possuem pai, ordenados pelo campo ordem
		* @return array com objetos do menu
		* @access public
		*/

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tbxmen";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtbxmen";
		
		static function loadLevel1(){
			$arraydewhere = array('nidpai' => null, 'cparameters' => null);
			$items = self::$db->order_by('ordem','ASC')->where($arraydewhere)->get(self::$_table)->result();
			return $items;
		}
		
		/**
		* Função estática para retornar os itens do menu que são filhos de um pai informado, ordenados pelo campo ordem
		* @param ID do menu pai, obtido através da função loadLevel1
		* @return array com objetos do menu
		* @access public
		*/
		
		static function getByParent($parent_id){
			$arraydeparent = array('nidpai' => $parent_id, 'cparameters' => null);
			$items = self::$db->order_by('ordem','ASC')->where($arraydeparent)->get(self::$_table)->result();
			return $items;
		}

	}