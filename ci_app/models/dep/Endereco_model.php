<?php
	
	class Endereco_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $tipoendereco;
		public $logradouro;
		public $numero;
		public $complemento;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tbxend";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtbxend";

		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao(){

			if (!$this->logradouro){
				$this->error = 'Logradouro em branco';
				return false;					
			}

			if (!$this->numero){
				$this->error = 'Número em branco';
				return false;
			}

			if ($this->tipoendereco){

				/* Verifica se o tipo de endereço informado no select realmente existe */
				$tpe = $this->db->where(['nativo'=>1, 'nidtbxtpe'=>$this->tipoendereco])->get("tbxtpe")->row();
				if (!$tpe){
					$this->error = 'O tipo de endereço selecionado na lista não está cadastrado';
					return false;
				}

			}

			return true;
		}

		/**
		* Função para salvar o registro no banco de dados
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return Int ID do registro inserido ou atualizado
		* @access public
		*/

		public function save()
		{
			if ( ! $this->id ) {
				/* O registro não possui ID. Portanto, trata-se de um create */
				$data = array(
					"nidcadlog" => $this->logradouro,
					"nidtbxtpe" => $this->tipoendereco,
					"cnumero" => $this->numero,
					"ccomplemento" => $this->complemento
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();
				return $this->id;
			} else {
				// TODO atualização de número ou complemento
			}

		}

	}
?>