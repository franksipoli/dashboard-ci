<?php
	class Tipocomissao_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxtcm";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtcm";
		
		public $valor_padrao;
		public $principal;

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
			/* Verifica se já existe um tipo de comissão com esta descrição */
			$tcm = $this->db->where(['nativo'=>1, 'cdescritcm'=>$this->descricao])->get(self::$_table)->row();
			if ($tcm){
				$this->error = 'Já existe um tipo de comissão com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um tipo de comissão com esta descrição e ID diferente deste */
			$tcm = $this->db->where(['nativo'=>1, 'cdescritcm'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tcm){
				$this->error = 'Já existe um tipo de comissão com a descrição "'.$this->descricao.'"';
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
					'cdescritcm'=>$this->descricao,
					'nprincipal'=>$this->principal
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				$return_id = $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cdescritcm'=>$this->descricao,
					'nprincipal'=>$this->principal
				);
				$this->db->insert(self::$_table, $data);
				$return_id = $this->db->insert_id();
			}

			/* Salva os valores padrão */

			$this->db->where('nidtbxtcm', $return_id);
			$this->db->delete('tagcmv');

			foreach ($this->valor_padrao as $finalidade_id=>$valor){
				$data = array(
					"nidtbxtcm" => $return_id,
					"nidtbxfin" => $finalidade_id,
					"nvalorpadrao" => $valor
				);
				$this->db->insert('tagcmv', $data);
			}

			return $return_id;

		}

		/**
		* Função que pega a lista de valores padrão de um tipo de comissão
		* @param integer ID do tipo de comissão
		* @return array lista de valores padrão para este tipo de comissão
		* @access public
		*/

		public function getValoresPadrao($nidtbxtcm){
			$this->db->where('nidtbxtcm', $nidtbxtcm);
			$valores = $this->db->get('tagcmv')->result();
			$result = array();
			foreach ($valores as $item){
				$result[$item->nidtbxfin] = $item->nvalorpadrao;
			}
			return $result;
		}

		/**
		* Função que pega a lista de valores padrão
		* @param integer ID da finalidade
		* @return array lista de valores padrão
		* @access public
		*/

		public function getValoresAll(){
			$valores = $this->db->get('tagcmv')->result();
			$result = array();
			foreach ($valores as $item){
				$result[$item->nidtbxfin][$item->nidtbxtcm] = $item->nvalorpadrao;
			}
			return $result;
		}

	}