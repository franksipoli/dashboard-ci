<?php
	
	class Venda_model extends MY_Model {

		/* Variável que armazena a etapa do cadastro (wizard) */
		public $etapa;
		
		protected $data_criacao;
		protected $data_atualizacao;

		public $imovel;
		public $cliente;
		public $sinal;
		public $comissao_vendedor;
		public $comissao_imobiliaria;
		public $valor_total;
		public $quantidade_parcelas;

		/* Variáveis que armazenam os usuários que fizeram as operações */

		public $usuario_criacao;
		public $usuario_atualizacao;


		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "cadven";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidcadven";

		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Função para salvar o registro no banco de dados
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return Int ID do registro inserido ou atualizado
		* @access public
		*/

		public function save()
		{

			if (!$this->id){

				/* O registro não possui ID. Portanto, trata-se de um create (etapa geral) */

				$data = array(
					"nidcadimo" => $this->imovel,
					"nidcadgrl" => $this->cliente,
					"nidtbxsin" => $this->sinal,
					"nvalor" => number_format($this->valor_total, 2, ".", ""),
					"nquantidadeparcelas" => $this->quantidade_parcelas,
					"dtdatacriacao" => date('Y-m-d H:i:s'),
					"nidtbxsegusu_criacao" => $this->usuario_criacao
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();

			} else {

				/* O registro possui ID. Portanto, trata-se de um update */

			}

			return $this->id;
		}

		/**
		* Função para retornar uma venda através do id de um Imóvel
		* @param int ID do Imóvel
		* @return object venda
		* @access public
		*/

		public function getByImovel($nidcadimo){
			$this->db->where('nidcadimo', $nidcadimo);
			$this->db->where('nativo', 1);
			$venda = $this->db->get('cadven')->row();
			return $venda;
		}

		/**
		* Função para salvar as comissões de uma venda no banco
		* @param int ID da venda
		* @param array lista de parâmetros enviados no formulário
		* @access public
		*/

		public function saveComissoes($cadven){
			$this->load->model('dci/Tipocomissao_model');
			$this->db->where('nidcadven', $cadven);
			$ven = $this->db->get('cadven')->row();
			$this->db->where('nidcadimo', $ven->nidcadimo);
			$comissoes = $this->db->get('tagicm')->result();
			foreach ($comissoes as $comissao){
				$data = array("nidcadven"=>$cadven,"nidtbxtcm"=>$comissao->nidtbxtcm,"nvalor"=>$comissao->nvalor, "nidtbxstp"=>Parametro_model::get("id_status_pagamento_pendente"));
				$this->db->insert('taglcm', $data);
			}
			return true;

		}

		/**
		* Função para confirmar o pagamento de uma comissão
		* @param int ID da comissão
		* @return boolean true
		*/

		public function confirmarcomissao($lcm){
			$data = array('nidtbxstp'=> Parametro_model::get('id_status_pagamento_pago'), 'dtdatapagamento'=>date('Y-m-d H:i:s'));
			$this->db->where('nidtaglcm', $lcm);
			$this->db->update('taglcm', $data);
			return true;
		}

		/**
		* Função para cancelar o pagamento de uma comissão
		* @param int ID da comissão
		* @return boolean true
		*/

		public function cancelarcomissao($lcm){
			$data = array('nidtbxstp'=> Parametro_model::get('id_status_pagamento_pendente'), 'dtdatapagamento'=>null);
			$this->db->where('nidtaglcm', $lcm);
			$this->db->update('taglcm', $data);
			return true;
		}

		/**
		* Função para pegar as comissões de uma venda no banco
		* @param int ID da venda
		* @param array lista de parâmetros enviados no formulário
		* @access public
		*/

		public function getComissoes($cadven){
			$this->load->model('dci/Tipocomissao_model');
			$this->db->where('nidcadven', $cadven);
			$lcm = $this->db->get('taglcm')->result();
			foreach ($lcm as $key=>$item){
				$this->db->where('nidtbxtcm', $item->nidtbxtcm);
				$tcm = $this->db->get('tbxtcm')->row();
				$item->tcm = $tcm;
				$lcm[$key] = $item;
			}
			return $lcm;
		}

		/**
		* Função que pega o valor de uma comissão específica
		* @param int ID da relação entre venda e comissão
		* @return decimal percentual da comissão
		*/

		public static function getValorComissao($nidtaglcm){
			self::$db->where('nidtaglcm', $nidtaglcm);
			$lcm = self::$db->get('taglcm')->row();

			/* Pega o tipo de comissão */

			self::$db->where('nidtbxtcm', $lcm->nidtbxtcm);
			$tcm = self::$db->get('tbxtcm')->row();

			if ($tcm->nprincipal){
				return $lcm->nvalor / 100;
			} else {
				
				/* Pega o tipo principal de comissão */
				self::$db->where('nprincipal', 1);
				$tcm_principal = self::$db->get('tbxtcm')->row();

				/* Pega o valor da comissão principal */
				self::$db->where('nidtbxtcm', $tcm_principal->nidtbxtcm);
				if ($lcm->nidcadloc){
					self::$db->where('nidcadloc', $lcm->nidcadloc);
				} else {
					self::$db->where('nidcadven', $lcm->nidcadven);
				}
				$valor_principal = self::$db->get('taglcm')->row();

				return ($valor_principal->nvalor / 100) * ($lcm->nvalor / 100);

			}

		}

		/**
		* Função para pegar a soma das comissões de uma venda no banco
		* @param int ID da locação
		* @param decimal soma de valores da venda
		* @access public
		*/

		public static function getTotalComissoes($cadven){
			self::$db->where('nidcadven', $cadven);
			self::$db->where('nativo', 1);
			$venda = self::$db->get('cadven')->row();
			self::$db->where('nidcadven', $venda->nidcadven);
			$comissoes = self::$db->get('taglcm')->result();
			$comissao_total = 0;
			foreach ($comissoes as $comissao){
				self::$db->where('nidtbxtcm', $comissao->nidtbxtcm);
				$tcm = self::$db->get('tbxtcm')->row();
				if ($tcm->nprincipal){
					$comissao_total += ($comissao->nvalor/100) * $venda->nvalor;
				}
			}
			return $comissao_total;
		}

		/**
		* Função para pegar a soma dos percentuais de comissão de uma venda
		* @param int ID da locação
		* @param decimal soma de percentuais de comissão
		* @access public
		*/

		public static function getTotalPercentualComissoes($cadven){
			self::$db->select('nvalor');
			self::$db->from('taglcm');
			self::$db->where('nidcadven', $cadven);
			$comissoes = self::$db->get()->result();
			$total = 0;
			foreach ($comissoes as $comissao){
				$total+= $comissao->nvalor / 100;
			}
			return $total;
		}

		/**
		* Função para obter vendas
		* @access public
		* @param date formato user - data de início do período
		* @param date formato user - data de fim do período
		* @param integer ID do usuário
		* @return array de objetos
		*/

		public function getVendas($data_inicio = false, $data_fim = false, $usuario = false, $corretor = false, $tipo = false){

			$this->db->select('cadven.*');

			$this->db->join('cadimo i', 'cadven.nidcadimo = i.nidcadimo', 'INNER');

			if ($usuario){
				$this->db->where('cadven.nidtbxsegusu_criacao', $usuario);
			}

			if ($corretor){
				$this->db->join('tagang ang', 'ang.nidcadimo = i.nidcadimo', 'INNER');
				$this->db->where('ang.nidtbxsegusu', $corretor);
			}

			if ($data_inicio)
				$this->db->where('dtdatacriacao >=', toDbDate($data_inicio)." 00:00:00");

			if ($data_fim)
				$this->db->where('dtdatacriacao <=', toDbDate($data_fim)." 00:00:00");

			if ($tipo){
				$this->db->where('i.nidtbxtpi', $tipo);
			}

			$this->db->where('cadven.nativo', 1);

			$vendas = $this->db->get('cadven')->result();

			$result = array();

			foreach ($vendas as $venda){

				$item = new stdClass();

				$item->venda = $venda;
				$item->imovel = $this->db->where('nidcadimo', $venda->nidcadimo)->get('cadimo')->row();
				$item->comprador = $this->db->where('nidcadgrl', $venda->nidcadgrl)->get('cadgrl')->row();

				$result[] = $item;

			}

			return $result;

		}

		/**
		* Função para obter os boletos de uma venda
		* @access public
		* @param integer ID da venda
		* @return array de boletos
		*/

		public function getBoletos($venda){
			$this->db->where('ctipotransacao', 'C');
			$this->db->where('nidcadven', $venda);
			$fin = $this->db->get('cadfin')->result();
			$boletos = array();
			foreach ($fin as $item){
				$this->db->where('nidcadfin', $item->nidcadfin);
				$this->db->where('nativo', 1);
				$boleto = $this->db->get('cadbol')->row();
				if (!$boleto)
					continue;
				$boleto->data_vencimento = toUserDate($boleto->ddatavencimento);
				$boleto->valor = number_format($boleto->nvalor, 2, ",", ".");
				$boletos[] = $boleto;
			}
			return $boletos;
		}
		

	}

	?>