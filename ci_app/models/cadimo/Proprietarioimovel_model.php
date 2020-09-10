<?php
	
	class Proprietarioimovel_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $cadastro;
		public $percentual;
		public $imovel;
		public $data_insercao;
		public $data_atualizacao;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagipr";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagipr";

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

			if (!$this->imovel){
				$this->error = 'Imóvel em branco';
				return false;					
			}

			if (!$this->percentual){
				$this->error = 'Percentual em branco';
				return false;					
			}

			if ($this->percentual < 0 || $this->percentual>100){
				$this->error = 'Percentual deve estar entre 0 e 100 ('.$this->percentual.' informado)';
				return false;					
			}

			/* Verifica se o tipo de Imóvel informado no select realmente existe */
			$imo = $this->db->where('nidcadimo',$this->imovel)->get("cadimo")->row();
			if (!$imo){
				$this->error = 'O Imóvel selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se o cadastro informado no select realmente existe */
			$cad = $this->db->where('nidcadgrl',$this->cadastro)->get("cadgrl")->row();
			if (!$cad){
				$this->error = 'O cadastro selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se não existe um registro com este Imóvel e este cadastro */
			$ipr = $this->db->where('nidcadgrl',$this->cadastro)->where('nidcadimo',$this->imovel)->get('tagipr')->row();
			if ($ipr){
				$this->error = 'Este cadastrado já está registrado para este Imóvel';
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
					"nidcadgrl" => $this->cadastro,
					"nidcadimo" => $this->imovel,
					"npercentual" => $this->percentual,
					"dtdatacriacao" => date('Y-m-d H:i:s')
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
		* Função para trazer os proprietários de um Imóvel
		* @param Integer ID do Imóvel
		* @return array de proprietários
		* @access public
		*/

		public function getByImovel($id)
		{

			$this->db->where('nidcadimo', $id);
			$ipr = $this->db->get('tagipr')->result();

			$result = array();

			foreach ($ipr as $item){

				$this->db->where('nidcadgrl', $item->nidcadgrl);
				$cadgrl = $this->db->get('cadgrl')->row();

				$r = new stdClass;

				$r->cadgrl = $cadgrl;
				$r->ipr = $item;

				$result[] = $r;

			}

			return $result;

		}

	}
?>