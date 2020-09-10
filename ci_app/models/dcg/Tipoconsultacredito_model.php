<?php
	class Tipoconsultacredito_model extends MY_Model {
		
		/* Link da consulta de crédito */	
		public $link;
		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxtcc";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtcc";
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se os campos não estão em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
		{
			if (!$this->descricao){
				$this->error = 'Campo descrição em branco';
				return false;					
			}
			if (!$this->link){
				$this->error = 'Campo link em branco';
				return false;
			}
			/* Verifica se já existe um tipo de consulta de crédito com esta descrição */
			$tcc = $this->db->where(['nativo'=>1, 'cdescritcc'=>$this->descricao])->get(self::$_table)->row();
			if ($tcc){
				$this->error = 'Já existe um tipo de consulta de crédito com a descrição "'.$this->descricao.'"';
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
				$this->error = 'Campo descrição em branco';
				return false;
			}
			if (!$this->link){
				$this->error = 'Campo link em branco';
				return false;
			}
			/* Verifica se já existe um tipo de consulta de crédito com esta descrição e ID diferente deste */
			$tcc = $this->db->where(['nativo'=>1, 'cdescritcc'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tcc){
				$this->error = 'Já existe um tipo de consulta de crédito com a descrição "'.$this->descricao.'"';
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
					'cdescritcc'=>$this->descricao,
					'clink'=>$this->link
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cdescritcc'=>$this->descricao,
					'clink'=>$this->link
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

	}