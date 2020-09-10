<?php
	class Tipocontrato_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxcon";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxcon";

		public $conteudo;
		public $codigo;
		
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
			
			/* Verifica se já existe um tipo de contrato com esta descrição */
			$con = $this->db->where('cnomecon',$this->descricao)->get(self::$_table)->row();
			if ($con){
				$this->error = 'Já existe um tipo de contrato com a descrição "'.$this->descricao.'"';
				return false;
			}

			if (!$this->codigo){
				$this->error = 'Código em branco';
				return false;
			}

			/* Verifica se já existe um tipo de contrato com este código */
			$con = $this->db->where('ccodcon', $this->codigo)->get(self::$_table)->row();
			if ($con){
				$this->error = 'Já existe um tipo de contrato com o código "'.$this->codigo.'"';
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

			/* Verifica se já existe um tipo de contrato com esta descrição e ID diferente deste */
			$con = $this->db->where('cnomecon',$this->descricao)->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($con){
				$this->error = 'Já existe um tipo de contrato com a descrição "'.$this->descricao.'"';
				return false;
			}

			if (!$this->codigo){
				$this->error = 'Código em branco';
				return false;
			}

			/* Verifica se já existe um tipo de contrato com este código e ID diferente deste */
			$con = $this->db->where('ccodcon', $this->codigo)->wherE(self::$_idfield.'!=', $this->id)->get(self::$_table)->row();
			if ($con){
				$this->error = 'Já existe um tipo de contrato com o código "'.$this->codigo.'"';
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
					'cnomecon'=>$this->descricao,
					'ccodcon'=>$this->codigo,
					'tconteudo'=>$this->conteudo
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnomecon'=>$this->descricao,
					'ccodcon'=>$this->codigo,
					'tconteudo'=>$this->conteudo
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		* Função para pegar os os tipos de contrato de uma finalidade
		* @access public
		* @param int $id ID da finalidade
		* @return array lista dos IDS dos tipos elencados
		*/

		public function getByFinalidade( $id )
		{
			$this->db->where('nidtbxfin', $id);
			$result = $this->db->get('tagcfi')->result();
			$result_id = array();
			foreach ($result as $item){
				if (!in_array($item->nidtbxcon, $result_id)){
					$result_id[] = $item->nidtbxcon;
				}
			}
			return $result_id;
		}

		/**
		* Função para obter um tipo de contrato através do código
		* @access public
		* @param string código do tipo de contrato
		* @return object tipo de contrato
		*/

		public function getByCodigo($codigo = false){
			if (!$codigo){
				return false;
			}
			$this->db->where('ccodcon', $codigo);
			$con = $this->db->get(self::$_table)->row();
			return $con;
		}

	}