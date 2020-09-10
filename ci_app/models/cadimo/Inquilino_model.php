<?php
	
	class Inquilino_model extends MY_Model {

		public $locacao;
		public $nome;
		public $idade;
		public $cadgrl;
		public $telefone;
		public $rg;
		public $cpf;
		public $data_nascimento;
		public $cidade;
		public $uf;
		public $responsavel;


		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "cadinq";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidcadinq";

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
			if ($this->id){
				/* Atualizar */
				if ($this->responsavel){
					$data = array(
						'nidcadloc'=>$this->locacao,
						'cnome'=>$this->nome,
						'nidade'=>$this->idade,
						'nresponsavel'=>1,
						'ctelefone'=>$this->telefone,
						'crg'=>$this->rg,
						'ncpf'=>cleanToNumber($this->cpf),
						'cdatanasc'=>toDbDate($this->data_nascimento),
						'ccidade'=>$this->cidade,
						'cuf'=>$this->uf
					);
				} else {
					$data = array(
						'nidcadloc'=>$this->locacao,
						'cnome'=>$this->nome,
						'nidade'=>$this->idade
					);
				}
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				if ($this->responsavel){
					$data = array(
						'nidcadloc'=>$this->locacao,
						'cnome'=>$this->nome,
						'nidade'=>$this->idade,
						'nresponsavel'=>1,
						'ctelefone'=>$this->telefone,
						'crg'=>$this->rg,
						'ncpf'=>cleanToNumber($this->cpf),
						'cdatanasc'=>toDbDate($this->data_nascimento),
						'ccidade'=>$this->cidade,
						'cuf'=>$this->uf
					);
				} else {
					$data = array(
						'nidcadloc'=>$this->locacao,
						'cnome'=>$this->nome,
						'nidade'=>$this->idade
					);
				}
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		public function listar_data($fase='records', $offset=0, $limit=10, $params=NULL){
			// Construção da consulta
			// campos
			$select = array(
				'i.nidcadinq'
				,'i.cnome AS nome'
				,'i.nidade AS idade'
				,'i.nresponsavel AS responsavel'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( 'cadinq i' );

			// condições
			$sql->where('i.nativo', 1);
			$sql->where('i.nidtbxsegusu_exclusao IS NULL');
			$sql->where('i.dtdataexc IS NULL');

			$sql->where('i.nidcadloc', $params['nidcadloc']);
			$sql->order_by('i.nresponsavel', 'DESC');
			$sql->order_by('i.cnome', 'ASC');

			switch ($fase) {
				case 'records':
					$query = $sql->limit( $limit, $offset )->get();
					if ($query)
						return $query->result();
					break;

				case 'recordsFiltered':
					return $sql->count_all_results();
					break;

				case 'recordsTotal':
					$this->db->get();
					return $this->db->where('nidcadloc', $params['nidcadloc'])->where('nativo', 1)->from('cadinq i')->count_all_results();
					break;
			}
		}

		public function removerPorLocacao($nidcadloc){
			$this->db->where('nidcadloc', $nidcadloc);
			$inq = $this->db->get('cadinq')->result();
			foreach ($inq as $inquilino){
				$this->id = $inquilino->nidcadinq;
				$this->delete();
			}
			return true;
		}

	}

	?>