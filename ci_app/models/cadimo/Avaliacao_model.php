<?php
	
	class Avaliacao_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $imovel;
		public $referencia;
		public $titulo;
		public $metragem;
		public $cliente;
		public $imoveis_ponderados;
		public $usuario_criacao;
		public $atendimento;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tbxava";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtbxava";

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

			if (!$this->imovel && !$metragem->this){
				$this->error = 'É obrigatório preencher a metragem';
				return false;
			}

			if (!$this->titulo){
				$this->error = 'É obrigatório preencher o título';
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
					"creferencia" => $this->referencia,
					"tdescricao" => $this->descricao,
					"ctitulo" => $this->titulo,
					"nmetragem" => $this->metragem,
					"nidcadgrl" => $this->cliente,
					"dtdatacriacao" => date('Y-m-d H:i:s'),
					"nidtbxsegusu_criacao" => $this->usuario_criacao
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();

				/* Cadastrar imóveis ponderados */

				if (is_array($this->imoveis_ponderados)){

					foreach ($this->imoveis_ponderados as $imo){

						$data = array(
							"nidtbxava" => $this->id,
							"nidcadimo" => $imo
						);

						$this->db->insert("tagiav", $data);

					}

				}

				if ($this->atendimento){

					$data = array("nidtbxava"=> $this->id, "nidcadate"=>$this->atendimento);

					$this->db->insert("tagata", $data);

				}

				return $this->id;
			}

		}

		/**
		* Função para obter a lista de imóveis de uma avaliação
		* @param integer ID da avaliação
		* @return array objetos de imóveis
		*/

		public function getImoveis($id){
			$this->db->where('nidtbxava', $id);
			$imoveis = $this->db->get('tagiav')->result();
			$result = array();
			foreach ($imoveis as $imovel){
				$this->db->where('nidcadimo', $imovel->nidcadimo);
				$result[] = $this->db->get('cadimo')->row();
			}
			return $result;
		}

		/**
		* Função para retornar os atendimentos de um Imóvel
		*/

		public function getByAtendimento($ate_id){

			$this->db->where('EXISTS(SELECT 1 FROM tagata WHERE tagata.nidtbxava = tbxava.nidtbxava AND tagata.nidcadate = "'.$ate_id.'")', null, false);

			return $this->db->get('tbxava')->result();

		}

	}
?>