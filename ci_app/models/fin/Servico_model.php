<?php
	class Servico_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxsrv";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxsrv";

		public $nidcadloc;
		public $nidtbxtps;
		public $valor_cobrado;
		public $data;
		public $usuario_criacao;
		public $status_pagamento;
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
		{
			return true;
		}
		
		/**
		* Função que valida se o registro pode ser atualizado no banco de dados
		* @access public
		* @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		*/
		
		public function validaAtualizacao()
		{
			return true;
		}
		
		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/
		
		public function save()
		{
			/* Criar */
			$data = array(
				'nidcadloc'=>$this->nidcadloc,
				'nidtbxtps'=>$this->nidtbxtps,
				'nidtbxsegusu_criacao'=>$this->usuario_criacao,
				'ddata'=>$this->data,
				'nvlrcobrado'=>$this->valor_cobrado,
				'nidtbxstp'=>$this->status_pagamento,
				'dtdatacriacao'=>date('Y-m-d H:i:s')
			);
			$this->db->insert(self::$_table, $data);
			return $this->db->insert_id();
		}

		/**
		* Função que pega os serviços de uma locação via AJAX
		* @param integer ID da locação
		* @return array lista de serviços
		* @access public
		*/

		public function getByLocacao($locacao_id){
			$this->db->where('nidcadloc',$locacao_id);
			$this->db->where('nativo', 1);
			$this->db->where('dtdataexc IS NULL', null, false);
			$this->db->where('nidtbxsegusu_exclusao IS NULL', null, false);
			$this->db->order_by('ddata', 'ASC');
			$this->db->order_by('dtdatacriacao', 'ASC');
			$srv = $this->db->get('tbxsrv')->result();
			$result = array();
			foreach ($srv as $item){
				$this->db->where('nidtbxstp', $item->nidtbxstp);
				$stp = $this->db->get('tbxstp')->row();
				$result_item = new stdClass();
				$result_item->servico = new stdClass();
				$result_item->servico->id = $item->nidtbxsrv;
				$result_item->status_pagamento = $stp;
				$result_item->servico->valor_cobrado = number_format($item->nvlrcobrado, 2, ",", ".");
				$result_item->servico->data_servico = toUserDate($item->ddata);
				$this->db->where('nidtbxtps', $item->nidtbxtps);
				$tps = $this->db->get('tbxtps')->row();
				$result_item->tiposervico = $tps;
				$result[] = $result_item;
			}
			return $result;
		}

		/**
		* Função que soma os serviços de uma locação
		* @param integer ID da locação
		* @return decimal valor total cobrado
		* @access public
		*/

		public static function getTotalCobradoLocacao($locacao_id){
			self::$db->select_sum('nvlrcobrado');
			self::$db->where('nidcadloc', $locacao_id);
			self::$db->where('dtdataexc IS NULL', null, false);
			self::$db->where('nativo', 1);
			self::$db->where('nidtbxsegusu_exclusao IS NULL', null, false);
			$total = self::$db->get('tbxsrv')->row()->nvlrcobrado;
			if ($total === false){
				$total = 0;
			}
			return $total;
		}

		/**
		* Função que paga um serviço e gera o recibo
		* @param integer ID do serviço
		* @return integer ID do recibo
		* @access public
		*/

		public function pagar(){
			$this->db->where('nidtbxsrv', $this->id);
			$data = array('nidtbxstp'=>$this->status_pagamento);
			$this->db->update('tbxsrv', $data);
			return null;
		}

	}