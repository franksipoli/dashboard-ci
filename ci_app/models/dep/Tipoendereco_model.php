<?php
	class Tipoendereco_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxtpe";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtpe";
		
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
			/* Verifica se já existe um tipo de endereço com esta descrição */
			$tpe = $this->db->where(['nativo'=>1, 'cdescritpe'=>$this->descricao])->get(self::$_table)->row();
			if ($tpe){
				$this->error = 'Já existe um tipo de endereço com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um tipo de endereço com esta descrição e ID diferente deste */
			$tpe = $this->db->where(['nativo'=>1, 'cdescritpe'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tpe){
				$this->error = 'Já existe um tipo de endereço com a descrição "'.$this->descricao.'"';
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
					'cdescritpe'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cdescritpe'=>$this->descricao
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}
		
	}