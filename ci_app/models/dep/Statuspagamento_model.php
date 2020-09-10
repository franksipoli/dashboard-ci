<?php
	class Statuspagamento_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxstp";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxstp";
		
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
			/* Verifica se já existe um status de pagamento com esta descrição */
			$stp = $this->db->where(['nativo'=>1, 'cnomestp'=>$this->descricao])->get(self::$_table)->row();
			if ($stp){
				$this->error = 'Já existe um status de pagamento com o nome "'.$this->descricao.'"';
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
			/* Verifica se já existe um status de pagamento com esta descrição e ID diferente desta */
			$stp = $this->db->where(['nativo'=>1, 'cnomestp'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($stp){
				$this->error = 'Já existe um status de pagamento com o nome "'.$this->descricao.'"';
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
					'cdescricao'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cdescricao'=>$this->descricao
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		* Função que pega o nome de um status de pagamento
		* @return ID do registro
		* @access public
		*/
		
		public static function getNome($id){
			$db = &get_instance()->db;
			$db->where('nidtbxstp', $id);
			return $db->get('tbxstp')->row()->cdescricao;
		}
		
	}