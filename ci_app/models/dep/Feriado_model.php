<?php
	class Feriado_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxfer";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxfer";

		public $data;
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
		{
			if (!$this->descricao){
				$this->error = 'Campo em branco';
				return false;					
			}
			if (!$this->data){
				$this->error = 'Data em branco';
				return false;					
			}
			return true;
		}
		
		/**
		* Função que valida se o registro pode ser atualizado no banco de dados
		* @access public
		* @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		*/
		
		public function validaAtualizacao()
		{
			if (!$this->descricao){
				$this->error = 'Campo em branco';
				return false;
			}
			if (!$this->data){
				$this->error = 'Data em branco';
			}
			return true;
		}
		
		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/
		
		public function save()
		{
			if ($this->id){
				/* Alterar */
				$data = array(
					'cdescrifer'=>$this->descricao,
					'ddata'=>toDbDate($this->data)
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cdescrifer'=>$this->descricao,
					'ddata'=>toDbDate($this->data)
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		public function getByData($data){
			$this->db->where('ddata', $data);
			$this->db->where('nativo', 1);
			$feriado = $this->db->get('tbxfer')->row();
			return $feriado ? $feriado : false;
		}

	}