<?php
	
	class Socio_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $cadastro;
		public $empresa;
		public $observacoes;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagsoc";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagsoc";

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

			if (!$this->empresa){
				$this->error = 'Empresa em branco';
				return false;					
			}

			if (!$this->cadastro){
				$this->error = 'Cadastro em branco';
				return false;					
			}

			/* Verifica se a empresa informada realmente existe */
			$cadjur = $this->db->where('nidcadjur',$this->empresa)->get("cadjur")->row();
			if (!$cadjur){
				$this->error = 'A empresa informada não está cadastrada';
				return false;
			}

			/* Verifica se o cadastro informado no select realmente existe */
			$cad = $this->db->where('nidcadgrl',$this->cadastro)->get("cadgrl")->row();
			if (!$cad){
				$this->error = 'O cadastro informado não está cadastrado';
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
					"nidcadjur" => $this->empresa,
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
		* Função para pegar os sócios de uma determinada empresa
		* @param integer ID da empresa
		* @param return array lista de sócios
		* @access public
		*/

		public function getByEmpresa( $id )
		{
			if ( !$id )
				return false;

			/* Verifica se a empresa existe */

			$this->db->where('nidcadjur', $id);
			$cadjur = $this->db->get('cadjur')->row();
			
			if (!$cadjur)
				return false;

			$this->db->where('nidcadjur', $id);
			$socios = $this->db->get('tagsoc')->result();

			$result = array();

			foreach ($socios as $socio):

				$result_part = array();

				$result_part['nidtagsoc'] = $socio->nidtagsoc;

				$result_part['cobs'] = $socio->cobs;

				/* Pega o objeto endereço com base no objeto endereço para cadastro geral (tag) */

				$this->db->where('nidcadgrl', $socio->nidcadgrl);

				$cadgrl = $this->db->get('cadgrl')->row();

				$result_part['cnomegrl'] = $cadgrl->cnomegrl;

				$result_part['nidcadgrl'] = $cadgrl->nidcadgrl;

				/* Adiciona o array parcial ao array total */

				$result[] = $result_part;

			endforeach;

			return $result;

		}

		/**
		* Função para apagar os sócios de uma empresa
		* @param integer ID da empresa
		* @param boolean true
		* @access public
		*/

		public function removeByEmpresa( $id )
		{
			
			$this->db->where('nidcadjur', $id);

			$this->db->delete('tagsoc');

			return true;

		}

	}
?>