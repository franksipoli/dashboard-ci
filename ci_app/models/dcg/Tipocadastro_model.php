<?php
	class Tipocadastro_model extends MY_Model {
		
		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxtcg";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtcg";
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function listar()
		{
			if($query = $this->db->order_by('cdescritcg')->get(self::$_table)) return $query->result();
			return false;
		}

		/**
		* Função que traz os tipos de um dado cadastro geral
		* @access public
		* @param integer ID do cadastro geral
		* @return array lista de objetos de tipos de cadastro geral
		*/

		public function getByCadastroGeral( $id )
		{
			$this->db->where('nidcadgrl', $id);
			$tagtcg = $this->db->get('tagtcg')->result();
			$result = array();
			foreach ($tagtcg as $item){
				$this->db->where('nidtbxtcg', $item->nidtbxtcg);
				$result[] = $this->db->get('tbxtcg')->row();
			}
			return $result;
		}
		
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
			/* Verifica se já existe um tipo de cadastro com esta descrição */
			$tcg = $this->db->where(['nativo'=>1, 'cdescritcg'=>$this->descricao])->get(self::$_table)->row();
			if ($tcg){
				$this->error = 'Já existe um tipo de cadastro com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um tipo de cadastro com esta descrição e ID diferente deste */
			$tcg = $this->db->where(['nativo'=>1, 'cdescritcg'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tcg){
				$this->error = 'Já existe um tipo de cadastro com a descrição "'.$this->descricao.'"';
				return false;
			}
			return true;
		}

		public function save()
		{
			if ($this->id){
				/* Atualizar registro */
				$data = array(
					'cdescritcg'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar registro */
				$data = array(
					'cdescritcg'=>$this->descricao
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

	}