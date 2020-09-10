<?php
	class Segmenu extends CI_Model {

		/* Variável estática que contém a instância do banco de dados */
		private static $db;
		
		public function __construct(){
			parent::__construct();
			self::$db = &get_instance()->db;
		}
		
		/**
		* Função estática para retornar os itens do menu que não possuem pai, ordenados pelo campo ordem
		* @return array com objetos do menu
		* @access public
		*/
		
		static function loadLevel1(){
			$items = self::$db->order_by('ordem','ASC')->where('nidpai',null)->get('tbxmen')->result();
			return $items;
		}
		
		/**
		* Função estática para retornar os itens do menu que são filhos de um pai informado, ordenados pelo campo ordem
		* @param ID do menu pai, obtido através da função loadLevel1
		* @return array com objetos do menu
		* @access public
		*/
		
		static function getByParent($parent_id){
			$items = self::$db->order_by('ordem','ASC')->where('nidpai',$parent_id)->get('tbxmen')->result();
			return $items;
		}

	}