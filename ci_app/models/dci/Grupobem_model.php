<?php
	class Grupobem_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxgrb";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxgrb";

		/* Cor do grupo */
		public $cor;
		
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
			/* Verifica se já existe um grupo de bens com esta descrição */
			$grb = $this->db->where(['nativo'=>1, 'cnomegrb'=>$this->descricao])->get(self::$_table)->row();
			if ($grb){
				$this->error = 'Já existe um grupo de bens com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um grupo de bens com esta descrição e ID diferente deste */
			$grb = $this->db->where(['nativo'=>1, 'cnomegrb'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($grb){
				$this->error = 'Já existe um grupo de bens com a descrição "'.$this->descricao.'"';
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
					'cnomegrb'=>$this->descricao,
					'ccor'=>$this->cor
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnomegrb'=>$this->descricao,
					'ccor'=>$this->cor
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		* Função que retorna os IDS dos grupos selecionados para um bem
		* @param int ID do bem
		* @return array lista de grupos
		* @access public
		*/	

		public function getByBem($nidtbxbem){
			$this->db->where('nidtbxbem', $nidtbxbem);
			$gbb = $this->db->get('taggbb')->result();
			$result_array = array();
			foreach ($gbb as $item){
				$result_array[] = $item->nidtbxgrb;
			}
			return $result_array;
		}

		/**
		* Função que retorna as quantidades de um bem para cada grupo
		* @param int ID do bem
		* @return array lista de quantidades
		* @access public
		*/	

		public function getQuantidades($nidtbxbem){
			$this->db->where('nidtbxbem', $nidtbxbem);
			$gbb = $this->db->get('taggbb')->result();
			$result_array = array();
			foreach ($gbb as $item){
				$result_array[$item->nidtbxgrb] = $item->nquantidade;
			}
			return $result_array;
		}

	}