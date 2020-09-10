<?php
	class MY_Model extends CI_Model {
		/** Campo id do registro no banco de dados */
		public $id;
		/** Array que armazena os erros de validação */
		public $error;
		/** Descrição do registro no banco de dados */
		public $descricao;
		/** Id do usuário que vai fazer a exclusão do registro */
		public $nidtbxsegusu_exclusao;
		/** Variável que contém informações sobre a conexão do banco de dados. Utilizada para métodos estáticos. */
		protected static $db;
		function __construct(){
			parent::__construct();
			self::$db = &get_instance()->db;
		}
		
		/**
		 * Função para verificar se o registro está ativo no banco de dados
		 * @return true caso o registro seja ativo e não possui uma data de exclusão
		 * @access public
		 */
		
		public function isAtivo(){
			$item = $this->db->where(static::$_idfield, $this->id)->get(static::$_table)->row();	
			if ($item->nativo && is_null($item->dtdataexc)){
				return true;
			}
			$this->error = "Este item já encontra-se desativado";
			return false;
		}
		
		/**
		 * Função para salvar no banco de dados
		 * @param (String) nome da tabela.
		 * @param (Array) Campos e valores correspondentes
		 * @return ID do registro
		 * @access public
		 */
		
		public function saveData($table=NULL, $data=NULL){
			if($this->db->insert($table, $data)) return $this->db->insert_id();
			return false;
		}
		
		/**
		 * Função para atualizar no banco de dados
		 * @param (String) nome da tabela.
		 * @param (Array) Condições para atualização
		 * @param (Array) Campos e valores correspondentes
		 * @return True/False
		 * @access public
		 */
		
		public function updateData($table=NULL, $where=NULL, $data=NULL){
			if(!$where) exit();
			if($this->db->where($where)->update($table, $data)) return true;
			return false;
		}

		/**
		 * Função para trazer todos os registros ativos no banco de dados
		 * @param (String|Array) campo para ordenação.
		 * @param (String) campo para setar se a ordem do campo escolhido no primeiro parâmetro é crescente ou decrescente
		 * @return Lista com todos os registros
		 * @access public
		 */
		
		public function getAll($field_order=null, $order = "ASC"){
			/** Caso o campo de ordenação vier em branco, escolhe o campo ID da tabela como padrão */	
			if (!$field_order)
				$field_order = static::$_idfield;
			/** Caso o campo de ordenação for um array, varre o array para listar múltiplos campos de ordenação */
			if (is_array($field_order)){
				foreach ($field_order AS $field=>$value){
					$this->db->order_by($field, $value);	
				}
			}
			$this->db->where('nativo', 1);
			$this->db->where('dtdataexc IS NULL');
			/** Obtém os registros da tabela setada no controlador */
			$items = $this->db->get(static::$_table)->result();
			return $items;
		}
		
		/**
		 * Função para trazer um determinado registro no banco de dados com base em seu id
		 * @param ID do registro no banco de dados
		 * @access public
		 * @return objeto que possui o ID na tabela setada no controlador
		 */
		
		static function getById($id, $ignorar_removidos = true){
			if ($ignorar_removidos){
				self::$db->where('nativo', 1);
				self::$db->where('dtdataexc IS NULL');
			}
			return self::$db->where(static::$_idfield,$id)->get(static::$_table)->row();
		}
		
		/**
		 * Função para deletar um determinado registro no banco de dados
		 * @access public
		 * @return true caso o registro tenha sido excluído
		 */
		
		public function delete(){
			/** Cria o array de dados de exclusão. Como os registros não são excluídos, a flag nativo é setada para zero. */
			$data = array(
				'nativo'=>0,
				'dtdataexc'=>date('Y-m-d H:i:s'),
				'nidtbxsegusu_exclusao'=>$this->nidtbxsegusu_exclusao
			);
			$this->db->where(static::$_idfield,$this->id);
			$this->db->update(static::$_table,$data);
			return true;
		}
	}
?>