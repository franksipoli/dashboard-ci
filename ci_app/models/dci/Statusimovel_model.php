<?php
	class Statusimovel_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxsti";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxsti";
		
		public $finalidade;

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
			/* Verifica se já existe um status de Imóvel com esta descrição e mesma finalidade */
			$sti = $this->db->where(['cdescristi'=>$this->descricao, 'nidtbxfin'=>$this->finalidade, 'nativo'=>1])->get(self::$_table)->row();
			if ($sti){
				$this->error = 'Já existe um status de Produto com a descrição "'.$this->descricao.'"';
				return false;
			}
			if (!$this->finalidade){
				$this->error = 'Finalidade em branco';
				return false;
			}
			/* Verifica se a finalidade informada existe */
			$fin = $this->db->where('nidtbxfin', $this->finalidade)->get('tbxfin')->row();
			if (!$fin){
				$this->error = 'Finalidade não encontrada';
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
			/* Verifica se já existe um status de Imóvel com esta descrição e ID diferente deste */
			$sti = $this->db->where(['cdescristi'=>$this->descricao, 'nidtbxfin'=>$this->finalidade, 'nativo'=>1])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($sti){
				$this->error = 'Já existe um status do Produto com a descrição "'.$this->descricao.'"';
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
					'cdescristi'=>$this->descricao,
					'nidtbxfin'=>$this->finalidade
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cdescristi'=>$this->descricao,
					'nidtbxfin'=>$this->finalidade
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		* Função para obter os status de Imóvel de uma finalidade
		* @param integer ID da finalidade
		* @return array lista de status de imóveis
		* @access public
		*/

		public function getByFinalidade($nidtbxfin){
			$this->db->where(['nativo'=>1, 'nidtbxfin'=>$nidtbxfin]);
			$this->db->order_by('cdescristi', 'ASC');
			return $this->db->get('tbxsti')->result();
		}

	}