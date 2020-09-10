<?php
	class Finalidade_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxfin";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxfin";

		public $grupos;

		public $tipos_contrato;
		
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
			/* Verifica se já existe uma finalidade com esta descrição */
			$fin = $this->db->where(['nativo'=>1, 'cnomefin'=>$this->descricao])->get(self::$_table)->row();
			if ($fin){
				$this->error = 'Já existe uma finalidade com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe uma finalidade com esta descrição e ID diferente deste */
			$fin = $this->db->where(['nativo'=>1, 'cnomefin'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($fin){
				$this->error = 'Já existe uma finalidade com a descrição "'.$this->descricao.'"';
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
					'cnomefin'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
			} else {
				/* Criar */
				$data = array(
					'cnomefin'=>$this->descricao
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
			}
			$this->setGrupos();
			$this->setTiposContrato();
			return $this->id;
		}

		/**
		* Função para setar os tipos de contrato de uma finalidade
		* @access private
		* @param none
		* @return boolean true
		*/

		private function setTiposContrato()
		{
			$this->db->where('nidtbxfin', $this->id);
			$this->db->delete('tagcfi');
			foreach ($this->tipos_contrato as $tipo){
				$data = array(
					'nidtbxfin'=>$this->id,
					'nidtbxcon'=>$tipo
				);
				$this->db->insert('tagcfi', $data);
			}
			return true;
		}

		/**
		* Função para setar os grupos de uma finalidade
		* @access private
		* @param none
		* @return boolean true
		*/

		private function setGrupos()
		{
			$this->db->where('nidtbxfin', $this->id);
			$this->db->delete('tagfgc');
			foreach ($this->grupos as $grupo){
				$data = array(
					'nidtbxfin'=>$this->id,
					'nidtbxgrc'=>$grupo
				);
				$this->db->insert('tagfgc', $data);
			}
			return true;
		}

		/**
		* Função para trazer o nome da finalidade
		* @access public
		* @param integer id da finalidade
		* @return string nome da finalidade
		* @static
		*/

		public static function getNome($id)
		{
			$db = &get_instance()->db;
			$db->where('nidtbxfin', $id);
			$fin = $db->get('tbxfin')->row();
			return $fin->cnomefin;
		}

	}