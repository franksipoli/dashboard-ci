<?php
	class Tiposecundarioimovel_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxtp2";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtp2";

		/* Armazenamento dos tipos primários elencados */

		public $tipos_primarios;
		
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
			/* Verifica se já existe um tipo de Imóvel com esta descrição */
			$tp2 = $this->db->where(array('nativo'=>1, 'cnometp2'=>$this->descricao))->get(self::$_table)->row();
			if ($tp2){
				$this->error = 'Já existe um tipo secundário no Produto com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um tipo secundário de Imóvel com esta descrição e ID diferente deste */
			$tp2 = $this->db->where(array('nativo'=>1, 'cnometp2'=>$this->descricao))->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tp2){
				$this->error = 'Já existe um tipo secundário no Produto com a descrição "'.$this->descricao.'"';
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
					'cnometp2'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
			} else {
				/* Criar */
				$data = array(
					'cnometp2'=>$this->descricao,
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
			}
			$this->setTiposPrimarios();
			return $this->id;
		}

		/**
		* Função para setar os tipos primários de Imóvel elencados
		* @access private
		* @param none
		* @return boolean true
		*/

		public function setTiposPrimarios()
		{
			$this->db->where('nidtbxtp2', $this->id);
			$this->db->delete('tagti2');
			foreach ($this->tipos_primarios as $tipo){
				$data = array(
					'nidtbxtp2'=>$this->id,
					'nidtbxtpi'=>$tipo
				);
				$this->db->insert('tagti2', $data);
			}
			return true;
		}

		/**
		* Função para pegar os tipos de Imóvel elencados com o tipo secundário solicitado
		* @access public
		* @param int $id ID do tipo secundário do Imóvel
		* @return array lista de IDS dos tipos primários elencados
		*/

		public function getPrimarios( $id )
		{
			$this->db->where('nidtbxtp2', $id);
			$result = $this->db->get('tagti2')->result();
			$result_id = array();
			foreach ($result as $item){
				if (!in_array($item->nidtbxtpi, $result_id))
					$result_id[] = $item->nidtbxtpi;
			}
			return $result_id;
		}

		/**
		* Função para pegar os tipos secundários de Imóvel elencados com o tipo primário solicitado
		* @access public
		* @param int $id ID do tipo primário do Imóvel
		* @return array lista dos IDS dos tipos secundários elencados
		*/

		public function getByTipoImovel( $id )
		{
			$this->db->where('nidtbxtpi', $id);
			$result = $this->db->get('tagti2')->result();
			$result_id = array();
			foreach ($result as $item){
				if (!in_array($item->nidtagti2, $result_id)){
					$this->db->where('nidtbxtp2', $item->nidtbxtp2);
					$tp2 = $this->db->get('tbxtp2')->row();
					$result_id[] = array("id"=>$item->nidtagti2,"nome"=>$tp2->cnometp2);
				}
			}
			return $result_id;
		}

	}