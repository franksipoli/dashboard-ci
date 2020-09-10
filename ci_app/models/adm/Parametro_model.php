<?php
	class Parametro_model extends MY_Model {

		/* Chave do parâmetro no banco de dados */	
		public $chave;
		/* Valor do parâmetro */
		public $valor;
		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tbxprm";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtbxprm";
		
		/**
		* Função para validar a inserção de um parâmetro
		* @return true caso a chave e o valor não estejam em branco e não houver nenhum outro parâmetro com a mesma chave cadastrado
		*/
		
		public function validaInsercao()
		{
			if (!$this->chave){
				$this->error = 'Campo chave em branco';
				return false;					
			}
			/* Verifica se já existe um parâmetro com esta chave */
			$prm = $this->db->where(['nativo' => 1, 'cchave' => $this->chave])->get(self::$_table)->row();
			if ($prm){
				$this->error = 'Já existe um parâmetro com a chave "'.$this->chave.'"';
				return false;
			}
			return true;
		}
		
		/**
		* Função para validar a atualização de um parâmetro
		* @return true caso a chave e o valor não estejam em branco e não houver nenhum outro parâmetro (diferente do que está sendo editado) com a mesma chave
		*/
		
		public function validaAtualizacao()
		{
			if (!$this->chave){
				$this->error = 'Campo chave em branco';
				return false;					
			}
			/* Verifica se já existe um parâmetro com esta chave e ID diferente deste */
			$prm = $this->db->where(['nativo' => 1, 'cchave' => $this->chave])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($prm){
				$this->error = 'Já existe um parâmetro com a chave "'.$this->chave.'"';
				return false;
			}
			return true;
		}
		
		/**
		* Função para salvar o parâmetro no banco
		* @return ID do parâmetro
		* @access public
		*/
		
		public function save()
		{
			if ($this->id){
				/* Atualizar */
				$data = array(
					'cchave'=>$this->chave,
					'cvalor'=>$this->valor
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;
			} else {
				/* Criar */
				$data = array(
					'cchave'=>$this->chave,
					'cvalor'=>$this->valor
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		* Função para pegar valor do parâmetro pela chave
		* @param chave do parâmetro
		* @return valor do parâmetro caso o mesmo existir, false em caso contrário
		* @access public
		*/
		 
		public static function get($chave)
		{
			self::$db = &get_instance()->db;
		 	self::$db->where('cchave', $chave);
			self::$db->where('nativo', 1);
			$param = self::$db->get(self::$_table)->row();
			/* Caso o parâmetro com a chave $chave existir, retorna o objeto. Caso contrário, retorna false */
		 	return $param ? $param->cvalor : false;
		}

	}