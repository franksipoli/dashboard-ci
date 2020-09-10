<?php
	
	class Veiculo_model extends MY_Model {

		public $locacao;
		public $modelo;
		public $placa;
		public $cor;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "cadvei";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidcadvei";

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
				$data = array(
					'nidcadloc'=>$this->locacao,
					'cmodelo'=>$this->modelo,
					'cplaca'=>$this->placa,
					'ccor'=>$this->cor
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'nidcadloc'=>$this->locacao,
					'cmodelo'=>$this->modelo,
					'cplaca'=>$this->placa,
					'ccor'=>$this->cor
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		public function listar_data($fase='records', $offset=0, $limit=10, $params=NULL){

			// Construção da consulta
			// campos
			$select = array(
				'v.nidcadvei'
				,'v.cmodelo AS modelo'
				,'v.cplaca AS placa'
				,'v.ccor AS cor'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( 'cadvei v' );

			// condições
			$sql->where('v.nativo', 1);
			$sql->where('v.nidtbxsegusu_exclusao IS NULL');
			$sql->where('v.dtdataexc IS NULL');

			$sql->where('v.nidcadloc', $params['nidcadloc']);
			$sql->order_by('v.cmodelo', 'ASC');

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
					$total = $this->db->where('nidcadloc', $params['nidcadloc'])->where('nativo', 1)->from('cadvei')->count_all_results();
					return $total;
					break;
			}

		}

		public function removerPorLocacao($nidcadloc){
			$this->db->where('nidcadloc', $nidcadloc);
			$vei = $this->db->get('cadvei')->result();
			foreach ($vei as $veiculo){
				$this->id = $veiculo->nidcadvei;
				$this->delete();
			}
			return true;
		}

	}

	?>