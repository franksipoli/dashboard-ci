<?php
	class Midiatipomidia_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tagim2";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtagim2";

		public $midia;
		public $tipo;
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
		{
			if (!$this->midia){
				$this->error = 'Campo em branco';
				return false;					
			}
			if (!$this->tipo){
				$this->error = 'Campo em branco';
				return false;					
			}
			/* Verifica se a mídia realmente existe */
			$imi = $this->db->where('nidtagimi',$this->midia)->get(self::$_table)->row();
			if ($imi){
				$this->error = 'A mídia solicitada não existe';
				return false;
			}
			/* Verifica se o tipo realmente existe */
			$mid = $this->db->where('nidtbxmid',$this->tipo)->get("tbxmid")->row();
			if ($mid){
				$this->error = 'A tipo solicitado não existe';
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
			if (!$this->midia){
				$this->error = 'Campo em branco';
				return false;					
			}
			if (!$this->tipo){
				$this->error = 'Campo em branco';
				return false;					
			}
			/* Verifica se a mídia realmente existe */
			$imi = $this->db->where('nidtagimi',$this->midia)->get(self::$_table)->row();
			if ($imi){
				$this->error = 'A mídia solicitada não existe';
				return false;
			}
			/* Verifica se o tipo realmente existe */
			$mid = $this->db->where('nidtbxmid',$this->tipo)->get("tbxmid")->row();
			if ($mid){
				$this->error = 'A tipo solicitado não existe';
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
					'nidtagimi'=>$this->midia,
					'nidtbxmid'=>$this->tipo
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
			} else {
				/* Criar */
				$data = array(
					'nidtagimi'=>$this->midia,
					'nidtbxmid'=>$this->tipo
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
			}
			return $this->id;
		}

	}