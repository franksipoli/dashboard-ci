<?php
	
	class Pessoajuridica_model extends MY_Model {

		public $id;
		public $cadgrl;
		public $nome_fantasia;
		public $atividade;
		public $data_fundacao;
		public $capital_social;
		public $ie_isento;

		protected $data_criacao;
		protected $data_atualizacao;


		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "cadjur";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidcadjur";

		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Função que valida a inserção dos dados básicos do cadastro de pessoa física no banco de dados
		* @access public
		* @return true caso o cadastro estiver com os dados obrigatórios preenchidos e as validações específicas retornarem true ou false em caso contrário
		* A função também armazena na variável $error os erros de validação 
		*/

		public function validaInsercao()
		{			
			if (!$this->cadgrl){
				$this->error = 'Um cadastro geral deve ser selecionado';
				return false;					
			}

			/* Verifica se o cadastro geral existe */

			$cad = $this->db->where('nidcadgrl', $this->cadgrl)->get('cadgrl')->row();
			if (!$cad){
				$this->error = 'O cadastro geral selecionado não existe';
				return false;
			}

			return true;

			// TODO validações de pessoa jurídica

		}

		/**
		* Função que valida a atualização dos dados básicos do cadastro de pessoa jurídica no banco de dados
		* @access public
		* @return true caso o cadastro estiver com os dados obrigatórios preenchidos e as validações específicas retornarem true ou false em caso contrário
		* A função também armazena na variável $error os erros de validação 
		*/

		public function validaAtualizacao()
		{
			
			if (!$this->cadgrl){
				$this->error = 'Um cadastro geral deve ser selecionado';
				return false;					
			}

			/* Verifica se o cadastro geral existe */

			$cad = $this->db->where('nidcadgrl', $this->cadgrl)->get('cadgrl')->row();
			if (!$cad){
				$this->error = 'O cadastro geral selecionado não existe';
				return false;
			}

			return true;

			// TODO validações de pessoa jurídica

		}

		/**
		* Função para salvar o registro no banco de dados
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return Int ID do registro inserido ou atualizado
		* @access public
		*/

		public function save()
		{

			$cadjur = $this->db->where('nidcadgrl', $this->cadgrl)->get('cadjur')->row();

			if (!$cadjur){

				/* O registro não possui ID. Portanto, trata-se de um create */
				$data = array(
					"nidcadgrl" => $this->cadgrl,
					"nidtbxatv" => $this->atividade,
					"cnomefant" => $this->nome_fantasia,
					"ddtfundacao" => toDbDate($this->data_fundacao),
					"ncaptsocial" => $this->capital_social,
					"nieisento" => $this->ie_isento ? "1" : "0"
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();

			} else {

				/* O registro possui ID. Portanto, trata-se de um update */
				
				$data = array(
					"nidcadgrl" => $this->cadgrl,
					"nidtbxatv" => $this->atividade,
					"cnomefant" => $this->nome_fantasia,
					"ddtfundacao" => toDbDate($this->data_fundacao),
					"ncaptsocial" => $this->capital_social,
					"nieisento" => $this->ie_isento ? "1" : "0"
				);

				$this->db->where('nidcadjur', $cadjur->nidcadjur);

				$this->db->update(self::$_table, $data);

			}

			return $this->id;
		}

		/**
		* Função para retornar o registro de pessoa jurídica com base no cadastro geral
		* @param integer ID do cadastro geral
		* @return object registro de pessoa jurídica
		* @access public
		*/

		public function getByCadastroGeral($nidcadgrl)
		{
			$this->db->where('nidcadgrl', $nidcadgrl);
			$this->db->where('nativo', 1);
			return $this->db->get('cadjur')->row();
		}

	}
?>