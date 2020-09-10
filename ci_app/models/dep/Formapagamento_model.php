<?php
	class Formapagamento_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxfpa";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxfpa";

		public $finalidades;
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao(){
			if (!$this->descricao){
				$this->error = 'Campo em branco';
				return false;					
			}
			/* Verifica se já existe uma forma de pagamento com esta descrição */
			$fpa = $this->db->where(['nativo'=>1, 'cnomefpa',$this->descricao])->get(self::$_table)->row();
			if ($fpa){
				$this->error = 'Já existe uma forma de pagamento com o nome "'.$this->descricao.'"';
				return false;
			}
			return true;
		}
		
		/**
		* Função que valida se o registro pode ser atualizado no banco de dados
		* @access public
		* @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		*/
		
		public function validaAtualizacao(){
			if (!$this->descricao){
				$this->error = 'Campo em branco';
				return false;
			}
			/* Verifica se já existe uma forma de pagamento com esta descrição e ID diferente desta */
			$fpa = $this->db->where(['nativo'=>1, 'cnomefpa'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($fpa){
				$this->error = 'Já existe uma forma de pagamento com o nome "'.$this->descricao.'"';
				return false;
			}
			return true;
		}
		
		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/
		
		public function save(){
			if ($this->id){
				/* Atualizar */
				$data = array(
					'cnomefpa'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				$this->db->where('nidtbxfpa', $this->id);
				$this->db->delete('tagffp');
				if (is_array($this->finalidades)){
					foreach ($this->finalidades as $fin){
						$data = array('nidtbxfin'=>$fin, 'nidtbxfpa'=>$this->id);
						$this->db->insert('tagffp', $data);
					}
				}
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnomefpa'=>$this->descricao
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
				if (is_array($this->finalidades)){
					foreach ($this->finalidades as $fin){
						$data = array('nidtbxfin'=>$fin, 'nidtbxfpa'=>$this->id);
						$this->db->insert('tagffp', $data);
					}
				}
				return $this->id;
			}
		}

		/**
		* Função que pega o nome de uma forma de pagamento
		* @return ID do registro
		* @access public
		*/
		
		public static function getNome($id){
			$db = &get_instance()->db;
			$db->where('nidtbxfpa', $id);
			return $db->get('tbxfpa')->row()->cnomefpa;
		}

		/**
		 * Função para trazer todos os registros ativos no banco de dados
		 * @param (String|Array) campo para ordenação.
		 * @param (String) campo para setar se a ordem do campo escolhido no primeiro parâmetro é crescente ou decrescente
		 * @return Lista com todos os registros
		 * @access public
		 */
		
		public function getAll($field_order=null, $order = "ASC", $finalidade = null){
			/** Caso o campo de ordenação vier em branco, escolhe o campo ID da tabela como padrão */	
			if (!$field_order)
				$field_order = static::$_idfield;
			/** Caso o campo de ordenação for um array, varre o array para listar múltiplos campos de ordenação */
			if (is_array($field_order)){
				foreach ($field_order AS $field=>$value){
					$this->db->order_by($field, $value);	
				}
			}
			if ($finalidade){
				$this->db->where('EXISTS(SELECT 1 FROM tagffp WHERE tagffp.nidtbxfpa = tbxfpa.nidtbxfpa AND tagffp.nidtbxfin = "'.$finalidade.'")', null, false);
			}
			$this->db->where('nativo', 1);
			$this->db->where('dtdataexc IS NULL');
			/** Obtém os registros da tabela setada no controlador */
			$items = $this->db->get(static::$_table)->result();
			return $items;
		}

		/**
		* Função que pega os IDS das finalidades relacionadas a uma forma de pagamento
		* @param integer ID da forma de pagamento
		* @return array lista de IDS de finalidades
		*/

		public function getIdsFinalidades($nidtbxfpa){
			$this->db->where('nidtbxfpa', $nidtbxfpa);
			$finalidades = $this->db->get('tagffp')->result();
			if (is_array($finalidades)){
				$ids = array();
				foreach ($finalidades as $finalidade){
					$ids[] = $finalidade->nidtbxfin;
				}
				return $ids;
			}
			return false;
		}
		
	}