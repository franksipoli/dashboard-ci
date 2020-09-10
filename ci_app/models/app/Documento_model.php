<?php
	
	class Documento_model extends MY_Model {

		public $entidade;
		public $tipo;
		public $data;
		public $observacoes;
		public $arquivo;
		public $usuario_criacao;
		public $app;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "caddoc";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidcaddoc";

		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/		
		
		public function save()
		{
			/* Criar */
			$data = array(
				'ddata'=>toDbDate($this->data),
				'nidtbxtdo'=>$this->tipo,
				'tobservacoes'=>$this->observacoes,
				'carquivo'=>$this->arquivo,
				'nidtbxsegusu_criacao'=>$this->usuario_criacao,
				'dtdatacriacao'=>date('Y-m-d H:i:s')
			);
			switch ($this->app){
				case "Venda":
					$data['nidcadven'] = $this->entidade;
					break;
				case "Locação Temporada":
					$data['nidcadloc'] = $this->entidade;
					break;
				case "Imóvel":
					$data['nidcadimo'] = $this->entidade;
					break;
				case "Atendimento":
					$data['nidcadate'] = $this->entidade;
					break;
				case "Cadastro Geral":
					$data['nidcadgrl'] = $this->entidade;
					break;
			}
			$this->db->insert(self::$_table, $data);
			return $this->db->insert_id();
		}

		/**
		* Função que retorna os documentos de uma venda
		* @param integer ID da venda
		* @return array lista de documentos
		*/

		public function getByAplicacao($aplicacao, $id){
			if ($aplicacao == "Venda"){
				$this->db->where('nidcadven', $id);
			} elseif ($aplicacao == "Locação Temporada"){
				$this->db->where('nidcadloc', $id);
			} elseif ($aplicacao == "Atendimento"){
				$this->db->where('nidcadate', $id);
			} elseif ($aplicacao == "Imóvel"){
				$this->db->where('nidcadimo', $id);
			} elseif ($aplicacao == "Cadastro Geral"){
				$this->db->where('nidcadgrl', $id);
			} else {
				return false;
			}
			$this->db->order_by('dtdatacriacao', 'DESC');
			$this->db->where('nativo', 1);
			return $this->db->get(self::$_table)->result();
		}

		/**
		* Função para verificar se um registro tem todos os documentos obrigatórios enviados
		* @param string nome da entidade
		* @param integer id do registro
		* @return boolean tem todos os obrigatórios
		* @static
		*/

		public static function temTodosObrigatorios($entidade, $registro){
			$db = &get_instance()->db;
			$app = $db->where('cname', $entidade)->get('tbxapp')->row();
			$apd = $db->where(array('nidtbxapp'=>$app->nidtbxapp, 'nativo'=>1))->get('tagapd')->result();
			foreach ($apd as $item){
				$db->where('nidtbxtdo', $item->nidtbxtdo);
				$tdo = $db->get('tbxtdo')->row();
				if ($tdo->nbloqueia){
					$db->where('nidtbxtdo', $item->nidtbxtdo);
					$db->where('nativo', 1);
					switch ($entidade){
						case "Venda":
							$db->where('nidcadven', $registro);
						break;
						case "Locação Temporada":
							$db->where('nidcadloc', $registro);
						break;
						case "Cadastro geral":
							$db->where('nidcadgrl', $registro);
						break;
						case "Atendimento":
							$db->where('nidcadate', $registro);
						break;
						case "Imóvel":
							$db->where('nidcadimo', $registro);
						break;
					}
					$total = $db->count_all_results('caddoc');
					if (!$total){
						return false;
					}
				}
			}
			return true;
		}

	}

	?>