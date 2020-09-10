<?php
	class Despesa_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxdes";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxdes";

		public $nidcadloc;
		public $nidcadgrl;
		public $valor_cobrado;
		public $valor_prestador;
		public $data;
		public $usuario_criacao;
		
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
				'nidcadgrl'=>$this->nidcadgrl,
				'nidtbxsegusu_criacao'=>$this->usuario_criacao,
				'ddata'=>$this->data,
				'nvlrcobrado'=>$this->valor_cobrado,
				'nvlrprestador'=>$this->valor_prestador,
				'cdescricao'=>$this->descricao,
				'dtdatacriacao'=>date('Y-m-d H:i:s')
			);
			$this->db->insert(self::$_table, $data);
			return $this->db->insert_id();
		}

		/**
		* Função que pega as despesas de uma locação via AJAX
		* @param integer ID da locação
		* @return array lista de despesas
		* @access public
		*/

		public function getByLocacao($locacao_id){
			$this->db->where('nidcadloc', $locacao_id);
			$this->db->where('nativo', 1);
			$loc = $this->db->get('cadloc')->row();
			$this->db->where('nidcadloc',$loc->nidcadloc);
			$this->db->where('nativo', 1);
			$this->db->where('dtdataexc IS NULL', null, false);
			$this->db->where('nidtbxsegusu_exclusao IS NULL', null, false);
			$this->db->order_by('ddata', 'ASC');
			$this->db->order_by('dtdatacriacao', 'ASC');
			$des = $this->db->get('tbxdes')->result();
			$result = array();
			foreach ($des as $item){
				$result_item = new stdClass();
				$result_item->despesa = new stdClass();
				$result_item->despesa->valor_cobrado = number_format($item->nvlrcobrado, 2, ".", ",");
				$result_item->despesa->valor_prestador = number_format($item->nvlrprestador, 2, ".", ",");
				$result_item->despesa->descricao = $item->cdescricao;
				$result_item->despesa->id = $item->nidtbxdes;
				$this->db->where('nidcadgrl', $item->nidcadgrl);
				$cadgrl = $this->db->get('cadgrl')->row();
				$result_item->prestador = $cadgrl;
				$result[] = $result_item;
			}
			return $result;
		}

		/**
		* Função que soma as despesas de uma locação (valor cobrado do cliente)
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
			$total = self::$db->get('tbxdes')->row()->nvlrcobrado;
			if ($total === false){
				$total = 0;
			}
			return $total;
		}

	}