<?php
	class Tiposervico_model extends MY_Model {
		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxtps";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtps";
		
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
			$tps = $this->db->where(['nativo'=>1, 'cdescritps'=>$this->descricao])->get(self::$_table)->row();
			if ($tps){
				$this->error = 'Já existe um tipo de serviço com a descrição "'.$this->descricao.'"';
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
			$tps = $this->db->where(['nativo'=>1, 'cdescritps'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tps){
				$this->error = 'Já existe um tipo de serviço com a descrição "'.$this->descricao.'"';
				return false;
			}
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
					'cdescritps'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				$data = array(
					'cdescritps'=>$this->descricao
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		 * Função que pega o tipo de serviço baseado no ID do cadastro geral
		 * @param ID do cadastro geral
		 * @return objeto Tipo de serviço
		 * @access public
		 */

		public static function getByPrestador($id){
			self::$db->where('nidcadgrl', $id);
			self::$db->where('nidtbxtps IS NOT NULL', null, false);
			$tcg = self::$db->get('tagtcg')->result();
			$lista = array();
			foreach ($tcg as $item){
				self::$db->where('nidtbxtps', $item->nidtbxtps);
				$tps = self::$db->get('tbxtps')->row();
				$lista[] = $tps;
			}
			$result = array();
			foreach ($lista as $item){
				$result[] = array('nome'=>$item->cdescritps, 'id'=>$item->nidtbxtps);
			}
			return $result;
		}

		/**
		 * Função que retorna os prestadores de serviço com base em um termo
		 * @param string termo a ser buscado no nome
		 * @return array lista de prestadores
		 * @access public
		 */

		public function getPrestadores($term = false){
			$id_tipo_cadastro_prestador_servicos = Parametro_model::get('id_tipo_cadastro_prestador_servicos');
			if ($term){
				$this->db->like('cnomegrl', $term);
			}
			$this->db->where('nativo', 1);
			$this->db->where('EXISTS(SELECT 1 FROM tagtcg WHERE nidcadgrl = cadgrl.nidcadgrl AND nidtbxtcg = "'.$id_tipo_cadastro_prestador_servicos.'")');
			$this->db->order_by('cnomegrl', 'ASC');
			$lista = $this->db->get('cadgrl')->result();
			return $lista;
		}

	}
?>