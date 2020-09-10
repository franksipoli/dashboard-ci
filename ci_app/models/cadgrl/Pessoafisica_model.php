<?php
	
	class Pessoafisica_model extends MY_Model {

		public $id;
		public $cadgrl;
		public $cadjur;
		public $estado_civil;
		public $profissao;
		public $entidade_emitente;
		public $nacionalidade;
		public $data_emissao;
		public $data_nascimento;
		public $data_admissao;
		public $renda_mensal;
		public $observacao_comercial;

		protected $data_criacao;
		protected $data_atualizacao;


		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "cadfis";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidcadfis";

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

			if (!$this->estado_civil){
				$this->error = 'Um estado civil deve ser selecionado';
				return false;					
			}

			/* Verifica se o estado civil existe */

			$est = $this->db->where('nidtbxest', $this->estado_civil)->get('tbxest')->row();
			if (!$est){
				$this->error = 'O estado civil selecionado não existe';
				return false;
			}

			return true;

			// TODO validações de pessoa física

		}

		/**
		* Função que valida a atualização dos dados básicos do cadastro de pessoa física no banco de dados
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

			if (!$this->estado_civil){
				$this->error = 'Um estado civil deve ser selecionado';
				return false;					
			}

			/* Verifica se o estado civil existe */

			$est = $this->db->where('nidtbxest', $this->estado_civil)->get('tbxest')->row();
			if (!$est){
				$this->error = 'O estado civil selecionado não existe';
				return false;
			}

			return true;

			// TODO validações de pessoa física

		}

		/**
		* Função para salvar o registro no banco de dados
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return Int ID do registro inserido ou atualizado
		* @access public
		*/

		public function save()
		{

			$cadfis = $this->db->where('nidcadgrl', $this->cadgrl)->get('cadfis')->row();

			if (!$cadfis){

				/* O registro não possui ID. Portanto, trata-se de um create */
				$data = array(
					"nidcadgrl" => $this->cadgrl,
					"nidcadjur" => $this->cadjur ? $this->cadjur : null,
					"nidtbxest" => $this->estado_civil ? $this->estado_civil : null,
					"nidtbxcbo" => $this->profissao ? $this->profissao : null,
					"nidtbxemi" => $this->entidade_emitente ? $this->entidade_emitente : null,
					"nidtbxnac" => $this->nacionalidade ? $this->nacionalidade : null,
					"ddtemirg" => $this->data_emissao ? $this->data_emissao : null,
					"ddtnasc" => $this->data_nascimento ? $this->data_nascimento : null,
					"ddtadmissao" => $this->data_admissao ? $this->data_admissao : null,
					"nrendamensal" => $this->renda_mensal ? $this->renda_mensal : null,
					"cobscomercial" => $this->observacao_comercial ? $this->observacao_comercial : null
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();

			} else {

				/* O registro possui ID. Portanto, trata-se de um update */
				$data = array(
					"nidcadjur" => $this->cadjur ? $this->cadjur : null,
					"nidtbxest" => $this->estado_civil ? $this->estado_civil : null,
					"nidtbxcbo" => $this->profissao ? $this->profissao : null,
					"nidtbxemi" => $this->entidade_emitente ? $this->entidade_emitente : null,
					"nidtbxnac" => $this->nacionalidade ? $this->nacionalidade : null,
					"ddtemirg" => $this->data_emissao ? $this->data_emissao : null,
					"ddtnasc" => $this->data_nascimento ? $this->data_nascimento : null,
					"ddtadmissao" => $this->data_admissao ? $this->data_admissao : null,
					"nrendamensal" => $this->renda_mensal ? $this->renda_mensal : null,
					"cobscomercial" => $this->observacao_comercial ? $this->observacao_comercial : null
				);

				$this->db->where('nidcadfis', $cadfis->nidcadfis);

				$this->db->update(self::$_table, $data);

			}

			return $this->id;
		}

		/**
		* Função para retornar o registro de pessoa física com base no cadastro geral
		* @param integer ID do cadastro geral
		* @return object registro de pessoa física
		* @access public
		*/

		public function getByCadastroGeral($nidcadgrl)
		{

			$this->db->where('nidcadgrl', $nidcadgrl);

			return $this->db->get('cadfis')->row();

		}

	}
?>