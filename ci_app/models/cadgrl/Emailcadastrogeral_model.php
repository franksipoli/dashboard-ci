<?php
	
	class Emailcadastrogeral_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $tipo;
		public $email;
		public $cadastro;
		public $data_insercao;
		public $data_atualizacao;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagema";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagema";

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

			if (!$this->email){
				$this->error = 'E-mail em branco';
				return false;					
			}

			if (!$this->cadastro){
				$this->error = 'Cadastro em branco';
				return false;					
			}

			/* Verifica se o tipo de e-mail informado no select realmente existe */
			$tem = $this->db->where('nidtbxtem',$this->tipo)->get("tbxtem")->row();
			if (!$tem){
				$this->error = 'O tipo de e-mail selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se o cadastro informado no select realmente existe */
			$cad = $this->db->where(['nativo'=>1, 'nidcadgrl'=>$this->cadastro])->get("cadgrl")->row();
			if (!$cad){
				$this->error = 'O cadastro selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se o e-mail informado já está registrado para este cadastro */
			$ema = $this->db->where('nidcadgrl',$this->cadastro)->where('nidtbxtem',$this->tipo)->where('cdescriemail',$this->email)->get(self::$_table)->row();
			if ($ema){
				$this->error = 'O e-mail já está registrado para este cadastro geral';
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
					"cdescriemail" => $this->email,
					"nidcadgrl" => $this->cadastro,
					"nidtbxtem" => $this->tipo,
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
		* Função para pegar os e-mails de um determinado cadastro geral
		* @param integer ID do cadastro geral
		* @param return array lista de e-mails
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
			$emails = $this->db->get('tagema')->result();

			$result = array();

			foreach ($emails as $email):

				$result_part = array();

				$result_part['nidtagema'] = $email->nidtagema;

				$result_part['ddatacriacao'] = $email->ddatacriacao;

				$result_part['cdescriemail'] = $email->cdescriemail;

				/* Pega o tipo de e-mail com base no telefone */

				$this->db->where('nidtbxtem', $email->nidtbxtem);

				$tem = $this->db->get('tbxtem')->row();

				$result_part['tem'] = $tem->cdescritem;

				$result_part['nidtbxtem'] = $tem->nidtbxtem;

				/* Adiciona o array parcial ao array total */

				$result[] = $result_part;

			endforeach;

			return $result;

		}

		/**
		* Função para remover os e-mails de um cadastro geral
		* @param integer ID do cadastro geral
		* @param boolean true
		* @access public
		*/

		public function removeByCadastro( $id )
		{
			$this->db->where('nidcadgrl', $id);
			$this->db->delete('tagema');
			return true;
		}

	}
?>