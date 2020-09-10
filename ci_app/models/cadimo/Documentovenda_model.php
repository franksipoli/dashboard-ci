<?php
	
	class Documentovenda_model extends MY_Model {

		public $venda;
		public $nome;
		public $data;
		public $observacoes;
		public $arquivo;
		public $usuario_criacao;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tbxdve";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtbxdve";

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
				'nidcadven'=>$this->venda,
				'ddata'=>toDbDate($this->data),
				'cdocumento'=>$this->nome,
				'tobservacoes'=>$this->observacoes,
				'carquivo'=>$this->arquivo,
				'nidtbxsegusu_criacao'=>$this->usuario_criacao,
				'dtdatacriacao'=>date('Y-m-d H:i:s')
			);
			$this->db->insert(self::$_table, $data);
			return $this->db->insert_id();
		}

		/**
		* Função que retorna os documentos de uma venda
		* @param integer ID da venda
		* @return array lista de documentos
		*/

		public function getByVenda($nidcadven){
			$this->db->where('nidcadven', $nidcadven);
			$this->db->order_by('dtdatacriacao', 'DESC');
			$this->db->where('nativo', 1);
			return $this->db->get('tbxdve')->result();
		}

	}

	?>