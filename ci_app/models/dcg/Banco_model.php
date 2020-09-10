<?php
	class Banco_model extends MY_Model {
		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxbco";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxbco";

		public $codigo;
		public $icone;
		
		/**
		 * Função que valida se o registro pode ser adicionado ao banco de dados
		 * @access public
		 * @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		 
		public function validaInsercao(){
			if (!$this->descricao){
				$this->error = 'Campo em branco';
				return false;					
			}
			$bco = $this->db->where(['nativo'=>1, 'cnomebco'=>$this->descricao])->get(self::$_table)->row();
			if ($bco){
				$this->error = 'Já existe um banco com o nome "'.$this->descricao.'"';
				return false;
			}
			return true;
		}
		
		/**
		 * Função que valida se o registro pode ser atualizado no banco de dados
		 * @access public
		 * @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		 */
		
		public function validaAtualizacao(){
			if (!$this->descricao){
				$this->error = 'Campo em branco';
				return false;
			}
			$bco = $this->db->where(['nativo'=>1, 'cnomebco'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($bco){
				$this->error = 'Já existe um banco com o nome "'.$this->descricao.'"';
				return false;
			}
			return true;
		}

		/**
		 * Função para excluir o ícone de um banco
		 * @access public
		*/

		public function removerIcone(){
			$data = array('cicone'=>null);
			$this->db->where('nidtbxbco', $this->id);
			$this->db->update('tbxbco', $data);
			return true;
		}
		
		/**
		 * Função que salva o registro no banco de dados
		 * @return ID do registro
		 * @access public
		 */
		
		public function save(){
			if ($this->id){
				/* Atualizar */
				$data = array(
					'cnomebco'=>$this->descricao,
					'ccodigo'=>$this->codigo
				);
				if ($this->icone){
					$data['cicone'] = $this->icone;
				}
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnomebco'=>$this->descricao,
					'ccodigo'=>$this->codigo,
					'cicone'=>$this->icone
				);

				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}
	}
?>