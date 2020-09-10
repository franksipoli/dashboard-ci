<?php
	class Tipologico_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxlog";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxlog";
		
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
			/* Verifica se já existe um tipo lógico com esta descrição */
			$log = $this->db->where(['nativo'=>1, 'cdescrilog'=>$this->descricao])->get(self::$_table)->row();
			if ($log){
				$this->error = 'Já existe um tipo lógico com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um tipo lógico com esta descrição e ID diferente deste */
			$log = $this->db->where(['nativo'=>1, 'cdescrilog'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($log){
				$this->error = 'Já existe um tipo lógico com a descrição "'.$this->descricao.'"';
				return false;
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
				/* Atualizar */
				$data = array(
					'cdescrilog'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cdescrilog'=>$this->descricao,
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

	}