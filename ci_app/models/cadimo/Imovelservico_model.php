<?php
	
	class Imovelservico_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $tipo;
		public $imovel;
		public $cadastro;
		public $valor;
		public $usuario;
		public $data_insercao;
		public $data_atualizacao;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagise";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagise";

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

			if (!$this->tipo){
				$this->error = "É obrigatório selecionar um tipo de serviço";
				return false;
			}
			if (!$this->cadastro){
				$this->error = "É obrigatório selecionar um prestador de serviço";
				return false;
			}
			if (!$this->imovel){
				$this->error = "É obrigatório selecionar um Imóvel";
				return false;
			}
			if (!$this->valor){
				$this->error = "É obrigatório preencher um valor";
				return false;
			}

			/* Verifica se já existe um serviço deste mesmo tipo cadastrado para este Imóvel */

			$this->db->where("nidcadimo", $this->imovel);
			$this->db->where("nidtbxtps", $this->tipo);

			$ise = $this->db->get('tagise')->row();

			if ($ise){
				$this->erro = "Já existe um serviço deste tipo para este Imóvel";
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
					"nidcadimo" => $this->imovel,
					"nidcadgrl" => $this->cadastro,
					"nidtbxtps" => $this->tipo,
					"nvalor" => $this->valor,
					"nidtbxsegusu_criacao"=>$this->usuario,
					"dtdatacriacao" => date('Y-m-d H:i:s')
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();
				return $this->id;
			} else {
				/* O registro possui ID. Portanto, trata-se de um update */
				$data = array(
					"nidcadimo" => $this->imovel,
					"nidcadgrl" => $this->cadastro,
					"nidtbxtps" => $this->tipo,
					"nvalor" => $this->valor,
					"nidtbxsegusu_criacao"=>$this->usuario
				);
				$this->db->where('nidtagise', $this->id);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();
				return $this->id;
			}

		}


		/**
		* Função para pegar os serviços de um determinado Imóvel
		* @param integer ID do Imóvel
		* @param return array lista de serviços
		* @access public
		*/

		public function getByImovel( $id )
		{
			if ( !$id )
				return false;

			/* Verifica se o Imóvel existe */

			$this->db->where('nidcadimo', $id);
			$cadimo = $this->db->get('cadimo')->row();
			
			if (!$cadimo)
				return false;

			$this->db->where('nativo', 1);
			$this->db->where('nidcadimo', $id);
			$servicos = $this->db->get('tagise')->result();

			$result = array();

			foreach ($servicos as $servico):

				$this->db->where('nidcadgrl', $servico->nidcadgrl);
				
				$servico->cadgrl = $this->db->get('cadgrl')->row();

				$this->db->where('nidtbxtps', $servico->nidtbxtps);

				$servico->tbxtps = $this->db->get('tbxtps')->row();

				$result[] = $servico;

			endforeach;

			return $result;

		}

	}
?>