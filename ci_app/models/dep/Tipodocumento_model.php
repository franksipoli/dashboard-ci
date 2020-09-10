<?php
	class Tipodocumento_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxtdo";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxtdo";

		public $obrigatorio;
		public $apps;
		
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
			/* Verifica se já existe um tipo de documento com esta descrição */
			$tdo = $this->db->where(['nativo'=>1, 'cnometdo'=>$this->descricao])->get(self::$_table)->row();
			if ($tdo){
				$this->error = 'Já existe um tipo de documento com a descrição "'.$this->descricao.'"';
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
			/* Verifica se já existe um tipo de documento com esta descrição e ID diferente deste */
			$tdo = $this->db->where(['nativo'=>1, 'cnometdo'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($tdo){
				$this->error = 'Já existe um tipo de documento com a descrição "'.$this->descricao.'"';
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
					'cnometdo'=>$this->descricao,
					'nbloqueia'=>$this->obrigatorio ? 1 : 0
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
			} else {
				/* Criar */
				$data = array(
					'cnometdo'=>$this->descricao,
					'nbloqueia'=>$this->obrigatorio ? 1 : 0
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
			}
			/* Seta os apps */
			$this->db->where('nidtbxtdo', $this->id);
			$this->db->delete('tagapd');
			if (is_array($this->apps)){
				foreach ($this->apps as $app){
					$data = array('nidtbxtdo'=>$this->id, 'nidtbxapp'=>$app);
					$this->db->insert('tagapd', $data);
				}
			}
			return $this->id;
		}

		/**
		* Função que retorna um array com os ids das aplicações às quais um tipo de documento pertence
		* @param Integer ID do tipo de documento
		* @return array lista de IDS de apps
		* @access public
		*/

		public function getAppIds($nidtbxtdo){
			$this->db->where('nidtbxtdo', $nidtbxtdo);
			$result = $this->db->get('tagapd')->result();
			$result_id = array();
			foreach ($result as $item){
				$result_id[] = $item->nidtbxapp;
			}
			return $result_id;
		}

		/**
		* Função que retorna a lista de tipos de documentos disponíveis para uma aplicação
		* @param integer|string ID ou slug da aplicação
		* @return array lista de tipos
		* @access public
		*/

		public function getByApp($app){
			$this->load->model("app/App_model");
			if (!is_numeric($app)){
				$app = $this->App_model->getByName($app)->nidtbxapp;
			}
			$this->db->select('tbxtdo.*');
			$this->db->from('tbxtdo');
			$this->db->join('tagapd', 'tagapd.nidtbxtdo=tbxtdo.nidtbxtdo', 'inner');
			$this->db->where('tbxtdo.nativo', 1);
			$this->db->order_by('tbxtdo.cnometdo', 'ASC');
			$this->db->where('tagapd.nidtbxapp', $app);
			$this->db->where('nidtbxapp', $app);
			$result = $this->db->get()->result();
			return $result;
		}

		/**
		* Função para obter o nome de um tipo de documento
		* @static
		* @param integer ID do tipo de documento
		* @return string nome do tipo de documento
		*/

		public static function getNome($nidtbxtdo){
			$db = &get_instance()->db;
			$db->where('nidtbxtdo', $nidtbxtdo);
			$db->where('nativo', 1);
			$obj = $db->get('tbxtdo')->row();
			return $obj->cnometdo;
		}

	}