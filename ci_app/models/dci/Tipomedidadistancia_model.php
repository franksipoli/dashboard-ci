<?php
	class Tipomedidadistancia_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxtmd";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtmd";
		
		/* Sigla do tipo de medida da distância */

		public $sigla;

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
			if (!$this->sigla){
				$this->error = 'Campo em branco';
				return false;					
			}
			/* Verifica se já existe um tipo de medida de distância com esta descrição */
			$tmd = $this->db->where(['nativo'=>1, 'cnometmd'=>$this->descricao])->get(self::$_table)->row();
			if ($tmd){
				$this->error = 'Já existe um tipo de medida de distância com a descrição "'.$this->descricao.'"';
				return false;
			}
			/* Verifica se já existe um tipo de medida de distância com esta sigla */
			$tmd = $this->db->where(['nativo'=>1, 'csiglatmd'=>$this->sigla])->get(self::$_table)->row();
			if ($tmd){
				$this->error = 'Já existe um tipo de medida de distância com a sigla "'.$this->descricao.'"';
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
			if (!$this->sigla){
				$this->error = 'Campo em branco';
				return false;
			}
			/* Verifica se já existe um tipo de medida de distância com esta descrição e ID diferente deste */
			$tmd = $this->db->where(['nativo'=>1, 'cnometmd'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tmd){
				$this->error = 'Já existe um tipo de medida de distância com a descrição "'.$this->descricao.'"';
				return false;
			}
			/* Verifica se já existe um tipo de medida de distância com esta sigla e ID diferente deste */
			$tmd = $this->db->where(['nativo'=>1, 'csiglatmd'=>$this->sigla])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tmd){
				$this->error = 'Já existe um tipo de distância com a sigla "'.$this->descricao.'"';
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
					'cnometmd'=>$this->descricao,
					'csiglatmd'=>$this->sigla
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnometmd'=>$this->descricao,
					'csiglatmd'=>$this->sigla
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

	}