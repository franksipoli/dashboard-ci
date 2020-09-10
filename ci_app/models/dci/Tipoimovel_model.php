<?php
	class Tipoimovel_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxtpi";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtpi";

		public $grupos;
		
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
			/* Verifica se já existe um tipo de Imóvel com esta descrição */
			$tpi = $this->db->where(array('cnometpi'=>$this->descricao, 'nativo'=>1))->get(self::$_table)->row();
			if ($tpi){
				$this->error = 'Já existe um tipo de Imóvel com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um tipo de Imóvel com esta descrição e ID diferente deste */
			$tpi = $this->db->where(array('cnometpi'=>$this->descricao, 'nativo'=>1))->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tpi){
				$this->error = 'Já existe um tipo de Imóvel com a descrição "'.$this->descricao.'"';
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
					'cnometpi'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
			} else {
				/* Criar */
				$data = array(
					'cnometpi'=>$this->descricao,
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
			}
			$this->setGrupos();
			return $this->id;
		}

		/**
		* Função para setar os grupos de um tipo de Imóvel
		* @access private
		* @param none
		* @return boolean true
		*/

		private function setGrupos()
		{
			$this->db->where('nidtbxtpi', $this->id);
			$this->db->delete('tagtgc');
			foreach ($this->grupos as $grupo){
				$data = array(
					'nidtbxtpi'=>$this->id,
					'nidtbxgrc'=>$grupo
				);
				$this->db->insert('tagtgc', $data);
			}
			return true;
		}

	}