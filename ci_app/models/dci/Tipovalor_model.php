<?php
	class Tipovalor_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxtpv";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtpv";
		
		public $rotulo;
		public $finalidades;
		public $principais;

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

			if (!$this->rotulo){
				$this->error = 'Campo em branco';
				return false;
			}

			/* Verifica se já existe um tipo de valor com esta descrição */
			$tpv = $this->db->where(['nativo'=>1, 'cnometpv'=>$this->descricao])->get(self::$_table)->row();
			if ($tpv){
				$this->error = 'Já existe um tipo de valor com a descrição "'.$this->descricao.'"';
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

			if (!$this->rotulo){
				$this->error = 'Campo em branco';
				return false;
			}

			/* Verifica se já existe um tipo de valor com esta descrição e ID diferente deste */
			$tpv = $this->db->where(['nativo'=>1, 'cnometpv'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tpv){
				$this->error = 'Já existe um tipo de valor com a descrição "'.$this->descricao.'"';
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
				$this->db->where('nidtbxtpv', $this->id);
				/* Atualizar */
				$data = array(
					'cnometpv'=>$this->descricao,
					'clabel'=>$this->rotulo
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnometpv'=>$this->descricao,
					'clabel'=>$this->rotulo
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
				return $this->id;
			}
		}

		/**
		* Função que salva as finalidades de um tipo de valor
		* @return none
		* @access public
		*/

		public function setFinalidades()
		{
			$this->db->where('nidtbxtpv', $this->id);
			$this->db->delete('tagfva');
			if (is_array($this->finalidades)){
				foreach ($this->finalidades as $item){
					$data = array(
						"nidtbxtpv"=>$this->id,
						"nidtbxfin"=>$item
					);
					if (in_array($item, $this->principais)){
						$this->db->where('nidtbxfin', $item);
						$this->db->update('tagfva', array('nprincipal' => 0));
						$data['nprincipal'] = 1;
					}
					$this->db->insert('tagfva', $data);
				}
			}
		}

}