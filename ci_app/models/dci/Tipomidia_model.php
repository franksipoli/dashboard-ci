<?php
	class Tipomidia_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxmid";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxmid";

		public $nome;
		public $descricao;
		public $largura;
		public $altura;
		public $largura_thumb;
		public $altura_thumb;
		public $pasta;
		
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
			/* Verifica se já existe um tipo de mídia com esta descrição */
			$mid = $this->db->where(['nativo'=>1, 'cnomemid'=>$this->descricao])->get(self::$_table)->row();
			if ($mid){
				$this->error = 'Já existe um tipo de mídia com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um tipo de mídia com esta descrição e ID diferente deste */
			$mid = $this->db->where(['nativo'=>1, 'cnomemid'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($mid){
				$this->error = 'Já existe um tipo de mídia com a descrição "'.$this->descricao.'"';
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
					'cnomemid'=>$this->nome,
					'cdescrimid'=>$this->descricao,
					'nwidth'=>$this->largura,
					'nheight'=>$this->altura,
					'nwidththu'=>$this->largura_thumb,
					'nheightthu'=>$this->altura_thumb,
					'cfoldermid'=>$this->pasta
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnomemid'=>$this->nome,
					'cdescrimid'=>$this->descricao,
					'nwidth'=>$this->largura,
					'nheight'=>$this->altura,
					'nwidththu'=>$this->largura_thumb,
					'nheightthu'=>$this->altura_thumb,
					'cfoldermid'=>$this->pasta
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		* Função que retorna o tipo de mídia que possui a menor largura
		* @return object tipo de mídia
		* @access public
		*/

		public function getMenorLargura(){

			$this->db->order_by('nwidth', 'ASC');
			$this->db->limit(1);
			return $this->db->get('tbxmid')->row();

		}

		/**
		* Função que retorna o tipo de mídia que possui a maior largura
		* @return object tipo de mídia
		* @access public
		*/

		public function getMaiorLargura(){

			$this->db->order_by('nwidth', 'DESC');
			$this->db->limit(1);
			return $this->db->get('tbxmid')->row();

		}

	}