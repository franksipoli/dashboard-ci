<?php
	class Caracteristica_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxcar";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxcar";
		
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
			/* Verifica se já existe uma característica com esta descrição */
			$car = $this->db->where(['nativo'=>1, 'cnomecar'=>$this->descricao])->get(self::$_table)->row();
			if ($car){
				$this->error = 'Já existe uma característica com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe uma característica com esta descrição e ID diferente deste */
			$car = $this->db->where(['nativo'=>1, 'cnomecar'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($car){
				$this->error = 'Já existe uma característica com a descrição "'.$this->descricao.'"';
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
					'cnomecar'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnomecar'=>$this->descricao
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		* Função para pegar os as características de um grupo selecionado
		* @access public
		* @param int $id ID do grupo de características
		* @return array lista dos IDS das características elencadas
		*/

		public function getByGrupo( $id )
		{
			$this->db->where('nidtbxgrc', $id);
			$result = $this->db->get('tagcag')->result();
			$result_id = array();
			foreach ($result as $item){
				if (!in_array($item->nidtbxcar, $result_id)){
					$result_id[] = $item->nidtbxcar;
				}
			}
			return $result_id;
		}

	}