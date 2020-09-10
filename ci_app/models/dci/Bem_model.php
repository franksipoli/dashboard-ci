<?php
	class Bem_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxbem";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxbem";
		
		public $grupos;
		public $quantidades;

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
			/* Verifica se já existe um bem com esta descrição */
			$bem = $this->db->where(['nativo'=>1, 'cnomebem'=>$this->descricao])->get(self::$_table)->row();
			if ($bem){
				$this->error = 'Já existe um bem com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um bem com esta descrição e ID diferente deste */
			$bem = $this->db->where(['nativo'=>1, 'cnomebem'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($bem){
				$this->error = 'Já existe um bem com a descrição "'.$this->descricao.'"';
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
				$this->saveGrupos();
				/* Atualizar */
				$data = array(
					'cnomebem'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnomebem'=>$this->descricao,
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
				$this->saveGrupos();
				return $this->id;
			}
		}

		/**
		* Função que salva os grupos de um bem
		* @return true
		* @access public
		*/	

		public function saveGrupos(){
			$this->db->where('nidtbxbem', $this->id);
			$this->db->delete('taggbb');
			foreach ($this->grupos as $grupo){
				$data = array('nidtbxbem'=>$this->id, 'nidtbxgrb'=>$grupo, 'nquantidade'=>$this->quantidades[$grupo]);
				$this->db->insert('taggbb', $data);
			}
			return true;
		}

		/**
		* Função que retorna os bens referentes a um grupo
		* @param integer id do grupo
		* @return array lista de bens pertencentes a este grupo
		* @access public
		*/

		public static function getByGrupo($grupo){
			self::$db->where('nidtbxgrb', $grupo);
			$gbb = self::$db->get('taggbb')->result();
			$result = array();
			$i = 0;
			foreach ($gbb as $item){
				self::$db->where('nidtbxbem', $item->nidtbxbem);
				$result[$i] = self::$db->get('tbxbem')->row();
				$result[$i]->quantidade = $item->nquantidade;
				$i++;
			}
			return $result;
		}

		/**
		* Função que retorna a lista de todos os bens em ordem alfabética
		* @return array lista de bens
		* @access public
		*/

		public function getAllAlfabetico(){
			$this->db->where('nativo', 1);
			$this->db->order_by('cnomebem', 'ASC');
			return $this->db->get('tbxbem')->result();
		}

		/**
		* Função que retorna os bens referentes a um Imóvel
		* @param integer id do Imóvel
		* @return array lista de bens pertencentes a este Imóvel
		* @access public
		*/

		public function getByImovel($id){
			$this->db->where('nidcadimo', $id);
			$gbi = $this->db->get('taggbi')->result();
			$result = array();
			foreach ($gbi as $grupo){
				$this->db->where('nidtbxgrb', $grupo->nidtbxgrb);
				$grb = $this->db->get('tbxgrb')->row();
				$this->db->where('nidtaggbi', $grupo->nidtaggbi);
				$bens = $this->db->get('tagbbi')->result();
				$bens_array = array();
				foreach ($bens as $bem){
					$this->db->where('nidtbxbem', $bem->nidtbxbem);
					$bem_obj = $this->db->get('tbxbem')->row();
					$informacoes = unserialize($bem->tobservacoes);
					$bens_array[] = array("nome"=>$bem_obj->cnomebem, "id"=>$bem_obj->nidtbxbem, "quantidade"=>$bem->nquantidade, "informacoes"=>$informacoes);
				}
				$result[$grupo->nidtaggbi] = array("cor"=>$grb->ccor,"nome"=>$grb->cnomegrb,"id"=>$grb->nidtbxgrb,"bens"=>$bens_array);
 			}
 			$this->db->where('nidcadimo', $id);
 			$this->db->where('nidtaggbi IS NULL', null, false);
 			$bens = $this->db->get('tagbbi')->result();
 			$bens_array = array();
 			foreach ($bens as $bem){
				$informacoes = unserialize($bem->tobservacoes);
 				$this->db->where('nidtbxbem', $bem->nidtbxbem);
				$bem_obj = $this->db->get('tbxbem')->row();
				$bens_array[] = array("nome"=>$bem_obj->cnomebem, "id"=>$bem_obj->nidtbxbem, "quantidade"=>$bem->nquantidade, "informacoes"=>$informacoes);
 			}
 			$result[0] = $bens_array;
 			return $result;
		}

	}