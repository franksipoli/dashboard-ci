<?php
	
	class Telefonecadastrogeral_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $tipo;
		public $telefone;
		public $cadastro;
		public $data_insercao;
		public $data_atualizacao;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagtel";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagtel";

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

			if (!$this->telefone){
				$this->error = 'Telefone em branco';
				return false;					
			}

			if (!$this->cadastro){
				$this->error = 'Cadastro em branco';
				return false;					
			}

			/* Verifica se o tipo de telefone informado no select realmente existe */
			$ttl = $this->db->where('nidtbxttl',$this->tipo)->get("tbxttl")->row();
			if (!$ttl){
				$this->error = 'O tipo de telefone selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se o cadastro informado no select realmente existe */
			$cad = $this->db->where('nidcadgrl',$this->cadastro)->get("cadgrl")->row();
			if (!$cad){
				$this->error = 'O cadastro selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se não existe um registro com este telefone, este tipo e este cadastro */
			$tel = $this->db->where('nidcadgrl',$this->cadastro)->where('nidtbxttl',$this->tipo)->where('cdescritel',$this->telefone)->get('tagtel')->row();
			if ($tel){
				$this->error = 'Este telefone já está registrado para este cadastro';
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
					"cdescritel" => $this->telefone,
					"nidcadgrl" => $this->cadastro,
					"nidtbxttl" => $this->tipo,
					"ddatacriacao" => date('Y-m-d H:i:s')
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
		* Função para pegar os telefones de um determinado cadastro geral
		* @param integer ID do cadastro geral
		* @param return array lista de telefones
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

			$this->db->where('nidcadgrl', $id);
			$telefones = $this->db->get('tagtel')->result();

			$result = array();

			foreach ($telefones as $telefone):

				$result_part = array();

				$result_part['nidtagtel'] = $telefone->nidtagtel;

				$result_part['ddatacriacao'] = $telefone->ddatacriacao;

				$result_part['cdescritel'] = $telefone->cdescritel;

				/* Pega o tipo de telefone com base no telefone */

				$this->db->where('nidtbxttl', $telefone->nidtbxttl);

				$ttl = $this->db->get('tbxttl')->row();

				$result_part['ttl'] = $ttl->cdescrittl;

				$result_part['nidtbxttl'] = $ttl->nidtbxttl;

				/* Adiciona o array parcial ao array total */

				$result[] = $result_part;

			endforeach;

			return $result;

		}

		/**
		* Função para remover os telefones de um cadastro geral
		* @param integer ID do cadastro geral
		* @param boolean true
		* @access public
		*/

		public function removeByCadastro( $id )
		{
			$this->db->where('nidcadgrl', $id);
			$this->db->delete('tagtel');
			return true;
		}

	}
?>