<?php
	class Grupocaracteristica_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxgrc";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxgrc";
		
		public $caracteristicas;

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
			/* Verifica se já existe um grupo com esta descrição */
			$grc = $this->db->where(['nativo'=>1, 'cnomegrc'=>$this->descricao])->get(self::$_table)->row();
			if ($grc){
				$this->error = 'Já existe um grupo com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um grupo com esta descrição e ID diferente deste */
			$grc = $this->db->where(['nativo'=>1, 'cnomegrc'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($grc){
				$this->error = 'Já existe um grupo com a descrição "'.$this->descricao.'"';
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
					'cnomegrc'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
			} else {
				/* Criar */
				$data = array(
					'cnomegrc'=>$this->descricao
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
			}
			$this->setCaracteristicas();
			return $this->id;
		}

		/**
		* Função para setar as características de um grupo
		* @access private
		* @param none
		* @return boolean true
		*/

		private function setCaracteristicas()
		{
			$this->db->where('nidtbxgrc', $this->id);
			$this->db->delete('tagcag');
			foreach ($this->caracteristicas as $caracteristica){
				$data = array(
					'nidtbxgrc'=>$this->id,
					'nidtbxcar'=>$caracteristica
				);
				$this->db->insert('tagcag', $data);
			}
			return true;
		}

		/**
		* Função para pegar os os grupos de um tipo de Imóvel
		* @access public
		* @param int $id ID do tipo de Imóvel
		* @return array lista dos IDS dos grupos elencados
		*/

		public function getByTipoImovel( $id )
		{
			$this->db->where('nidtbxtpi', $id);
			$result = $this->db->get('tagtgc')->result();
			$result_id = array();
			foreach ($result as $item){
				if (!in_array($item->nidtbxgrc, $result_id)){
					$result_id[] = $item->nidtbxgrc;
				}
			}
			return $result_id;
		}

		/**
		* Função para pegar os os grupos de uma finalidade
		* @access public
		* @param int $id ID da finalidade
		* @return array lista dos IDS dos grupos elencados
		*/

		public function getByFinalidade( $id )
		{
			$this->db->where('nidtbxfin', $id);
			$result = $this->db->get('tagfgc')->result();
			$result_id = array();
			foreach ($result as $item){
				if (!in_array($item->nidtbxgrc, $result_id)){
					$result_id[] = $item->nidtbxgrc;
				}
			}
			return $result_id;
		}

	}