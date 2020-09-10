<?php
	
	class Parente_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $cadastro;
		public $cadastro_pai;
		public $tipo;
		public $observacoes;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagpar";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagpar";

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

			if (!$this->cadastro){
				$this->error = 'Cadastro em branco';
				return false;					
			}

			/* Verifica se o cadastro informado no select realmente existe */
			$cad = $this->db->where('nidcadgrl',$this->cadastro)->get("cadgrl")->row();
			if (!$cad){
				$this->error = 'O cadastro selecionado na lista não está cadastrado';
				return false;
			}

			if (!$this->cadastro_pai){
				$this->error = 'Cadastro pai em branco';
				return false;					
			}

			/* Verifica se o cadastro informado no select realmente existe */
			$cad_pai = $this->db->where('nidcadgrl',$this->cadastro_pai)->get("cadgrl")->row();
			if (!$cad_pai){
				$this->error = 'O cadastro pai selecionado na lista não está cadastrado';
				return false;
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
					"nidtbxtpt" => $this->tipo,
					"nidcadpai_nidcadgrl" => $this->cadastro_pai,
					"nidcadgrl" => $this->cadastro,
					"cobs" => $this->observacoes
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();
				return $this->id;
			} else {
				// TODO atualização de número ou complemento
			}

		}

		/**
		* Função para pegar os endereços de um determinado cadastro geral
		* @param integer ID do cadastro geral
		* @param return array lista de endereços
		* @access public
		*/

		public function getByCadastroGeral( $id )
		{
			if ( !$id )
				return false;

			/* Verifica se o cadastro geral existe */

			$this->db->where('nidcadgrl', $id);
			$cadgrl = $this->db->get('cadgrl')->row();
			
			if (!$cadgrl)
				return false;

			$this->db->where('nidcadpai_nidcadgrl', $id);
			$parentes = $this->db->get('tagpar')->result();

			$result = array();

			foreach ($parentes as $parente):

				$result_part = array();

				$result_part['nidtagpar'] = $parente->nidcadpar;

				$result_part['nidtbxtpt'] = $parente->nidtbxtpt;

				$result_part['nidcadpai_nidcadgrl'] = $parente->nidcadpai_nidcadgrl;

				$this->db->where('nidcadgrl', $parente->nidcadgrl);

				$cadgrl = $this->db->get('cadgrl')->row();

				$result_part['nidcadgrl'] = $parente->nidcadgrl;

				$result_part['cnomegrl'] = $cadgrl->cnomegrl;

				/* Adiciona o array parcial ao array total */

				$result[] = $result_part;

			endforeach;

			return $result;

		}

		/**
		* Função para apagar os parentes de um cadastro geral
		* @param integer ID do cadastro geral
		* @param boolean true
		* @access public
		*/

		public function removeByCadastro( $id )
		{
			
			$this->db->where('nidcadpai_nidcadgrl', $id);

			$this->db->delete('tagpar');

			return true;

		}

	}
?>