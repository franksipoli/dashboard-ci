<?php
	
	class Enderecocadastrogeral_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $endereco;
		public $cadastro;
		public $data_insercao;
		public $data_atualizacao;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagedc";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagedc";

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

			if (!$this->endereco){
				$this->error = 'Endereço em branco';
				return false;					
			}

			if (!$this->cadastro){
				$this->error = 'Cadastro em branco';
				return false;					
			}

			/* Verifica se o endereço informado no select realmente existe */
			$end = $this->db->where('nidtbxend',$this->endereco)->get("tbxend")->row();
			if (!$end){
				$this->error = 'O endereço selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se o cadastro informado no select realmente existe */
			$cad = $this->db->where('nidcadgrl',$this->cadastro)->get("cadgrl")->row();
			if (!$cad){
				$this->error = 'O cadastro selecionado na lista não está cadastrado';
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
					"nidtbxend" => $this->endereco,
					"nidcadgrl" => $this->cadastro,
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

			$this->db->where('nidcadgrl', $id);
			$enderecos = $this->db->get('tagedc')->result();

			$result = array();

			foreach ($enderecos as $endereco):

				$result_part = array();

				$result_part['nidtagedc'] = $endereco->nidtagedc;

				$result_part['ddatacriacao'] = $endereco->ddatacriacao;

				$result_part['ddataatualizacao'] = $endereco->ddataatualizacao;

				/* Pega o objeto endereço com base no objeto endereço para cadastro geral (tag) */

				$this->db->where('nidtbxend', $endereco->nidtbxend);

				$end = $this->db->get('tbxend')->row();

				$result_part['cnumero'] = $end->cnumero;

				$result_part['ccomplemento'] = $end->ccomplemento;

				/* Pega o tipo de endereço com base no endereço */

				$this->db->where('nidtbxtpe', $end->nidtbxtpe);

				$tpe = $this->db->get('tbxtpe')->row();

				$result_part['tpe'] = $tpe->cdescritpe;

				$result_part['nidtbxtpe'] = $tpe->nidtbxtpe;

				/* Pega o logradouro com base no endereço */

				$this->db->where('nidcadlog', $end->nidcadlog);

				$log = $this->db->get('cadlog')->row();

				$result_part['nidtbxtpl'] = $log->nidtbxtpl;

				$result_part['cdescrilog'] = $log->cdescrilog;

				$result_part['ccep_log'] = $log->ccep;

				/* Pega o bairro com base no logradouro */

				$this->db->where('nidtbxbai', $log->nidtbxbai);

				$bai = $this->db->get('tbxbai')->row();

				$result_part['cdescribai'] = $bai->cdescribai;

				/* Pega a localidade com base no bairro */

				$this->db->where('nidtbxloc', $bai->nidtbxloc);

				$loc = $this->db->get('tbxloc')->row();

				$result_part['cdescriloc'] = $loc->cdescriloc;

				$result_part['ccep_loc'] = $loc->ccep;

				/* Pega a UF com base na localidade */

				$this->db->where('nidtbxuf', $loc->nidtbxuf);

				$uf = $this->db->get('tbxuf')->row();

				$result_part['cdescriuf'] = $uf->cdescriuf;

				$result_part['nidtbxuf'] = $uf->nidtbxuf;

				/* Pega o país com base na UF */

				$this->db->where('nidtbxpas', $uf->nidtbxpas);

				$pas = $this->db->get('tbxpas')->row();

				$result_part['nidtbxpas'] = $pas->nidtbxpas;

				$result_part['cdescripas'] = $pas->cdescripas;

				/* Adiciona o array parcial ao array total */

				$result[] = $result_part;

			endforeach;

			return $result;

		}

		/**
		* Função para apagar os endereços de um cadastro geral
		* @param integer ID do cadastro geral
		* @param boolean true
		* @access public
		*/

		public function removeByCadastro( $id )
		{
			
			$this->db->where('nidcadgrl', $id);

			$this->db->delete('tagedc');

			return true;

		}

	}
?>