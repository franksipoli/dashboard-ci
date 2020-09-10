<?php
	class Dashboard_model extends CI_model {

		public static $db;

		public static function getDadosCarteiras(){

			self::$db = &get_instance()->db;
			$quantidade = self::$db->where('nativo', 1)->count_all_results('cadgrl');
			$result = new stdClass();
			$result->quantidade = $quantidade;
			return $result;

		}

		public static function getAtendimentosAbertos(){

			self::$db = &get_instance()->db;
			$quantidade = self::$db->where('nativo', 1)->where('nlibera', 1)->count_all_results('cadate');
			$result = new stdClass();
			$result->quantidade = $quantidade;
			return $result;

		}

		public static function getLocacoesHoje(){

			self::$db = &get_instance()->db;
			self::$db->where('dtdatacriacao >= "'.date('Y-m-d').' 00:00:00"',null,false);
			self::$db->where('dtdatacriacao <= "'.date('Y-m-d').' 23:59:59"',null,false);

			self::$db->where('nativo', 1);

			$quantidade = self::$db->count_all_results('cadloc');

			$result = new stdClass();

			$result->quantidade = $quantidade;
			return $result;

		}

		public static function getLocacoesAno(){

			self::$db = &get_instance()->db;
			self::$db->where('dtdatacriacao >= "'.date('Y').'-01-01 00:00:00"',null,false);
			self::$db->where('dtdatacriacao <= "'.date('Y').'-12-31 23:59:59"',null,false);

			self::$db->where('nativo', 1);

			$result = new stdClass();

			$result->total_locacoes_ano = self::$db->count_all_results('cadloc');

			self::$db->where('nativo', 1);
			self::$db->where('nidtbxfin', Parametro_model::get('finalidade_locacao_id'));
			self::$db->where('EXISTS(SELECT 1 FROM cadloc WHERE cadloc.nidcadimo = cadimo.nidcadimo AND cadloc.nativo="1")', null, false);
			$imoveis_com_locacao = self::$db->count_all_results('cadimo');

			$imoveis_total = self::$db->where(['nativo'=>1, 'nidtbxfin'=>Parametro_model::get('finalidade_locacao_id')])->count_all_results('cadimo');

			$result->imoveis_com_locacao = $imoveis_com_locacao;
			$result->imoveis_total = $imoveis_total;

			$percentual = floor(100*($imoveis_com_locacao / $imoveis_total));

			$result->percentual = $percentual;

			return $result;

		}

		public static function getNumeroLocacoesDia($mysql_date){

			self::$db = &get_instance()->db;
			self::$db->where('dtdatacriacao >= "'.$mysql_date.' 00:00:00"',null,false);
			self::$db->where('dtdatacriacao <= "'.$mysql_date.' 23:59:59"',null,false);

			self::$db->where('nativo', 1);

			$total_locacoes = self::$db->count_all_results('cadloc');

			return $total_locacoes;

		}

		public static function getNumeroVendasDia($mysql_date){
			self::$db = &get_instance()->db;
			self::$db->where('dtdatacriacao >= "'.$mysql_date.' 00:00:00"',null,false);
			self::$db->where('dtdatacriacao <= "'.$mysql_date.' 23:59:59"',null,false);
			self::$db->where('nativo', 1);
			$total_vendas = self::$db->count_all_results('cadven');

			return $total_vendas;
		}

		public static function getTotalImoveis($finalidade){

			switch ($finalidade){
				case "venda":
					$id = 3;
					break;
				case "locacao":
					$id = 4;
					break;
			}	

			self::$db->where('nidtbxfin', $id);
			self::$db->where('nativo', 1);

			$total = self::$db->count_all_results('cadimo');

			return $total;

		}

	}