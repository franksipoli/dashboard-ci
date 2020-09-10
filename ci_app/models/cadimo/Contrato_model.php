<?php
	class Contrato_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "cadcon";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidcadcon";

		public $tipo;
		public $caminho;
		public $locacao;
		public $sinal;

		public $usuario_criacao;

		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
		{
			if (!$this->tipo){
				$this->error = 'Tipo em branco';
				return false;					
			}
			/* Verifica se já existe um tipo de contrato com este ID */
			$con = $this->db->where('nidtbxcon',$this->tipo)->get(self::$_table)->row();
			if (!$con){
				$this->error = 'O tipo de contrato informado não existe"';
				return false;
			}
			if (!$this->locacao && !$this->sinal){
				$this->error = 'Locação e Sinal em branco';
				return false;					
			}

			if ($this->locacao){

				/* Verifica se já existe uma locação */
				$loc = $this->db->where('nidcadloc',$this->locacao)->get("cadloc")->row();
				if (!$loc){
					$this->error = 'A locação informada não existe"';
					return false;
				}

			}

			if ($this->sinal){

				/* Verifica se já existe um sinal */
				$sin = $this->db->where('nidtbxsin', $this->sinal)->get("tbxsin")->row();
				if (!$sin){
					$this->error = 'O sinal informado não existe';
					return false;
				}

			}

			return true;
		}
		
		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/		
		
		public function save()
		{
			$data = array(
				'nidtbxcon'=>$this->tipo,
				'dtdatacriacao'=>date('Y-m-d H:i:s'),
				'nidtbxsegusu_criacao'=>$this->usuario_criacao,
				'ccaminho'=>$this->caminho
			);
			if ($this->locacao){
				$data['nidcadloc'] = $this->locacao;
			}
			if ($this->sinal){
				$data['nidtbxsin'] = $this->sinal;
			}
			$this->db->insert('cadcon', $data);
			return $this->db->insert_id();
		}

		/**
		* Função para retornar JSON com os contratos para o controlador
		*/

		public function listar_data( $fase='records', $offset=0, $limit=10, $params=NULL )
		{

			//var_dump($params); exit();

			// Construção da consulta
			// campos
			$select = array(
				'c.nidcadcon',
				'c.dtdatacriacao AS data_criacao'
				,'c.ccaminho AS caminho'
				,'u.cnome AS criado_por'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table.' c' )
				->join( 'tbxsegusu u' , 'c.nidtbxsegusu_criacao = u.nidtbxsegusu', 'LEFT'); // usuário

			// condições
			$sql->where('c.nativo', 1);
			$sql->where('c.nidtbxsegusu_exclusao IS NULL');
			$sql->where('c.dtdataexc IS NULL');

			if(isset($params['nidcadloc'])) $sql->where(array('c.nidcadloc'=>$params['nidcadloc'])); // locação

			switch ($fase) {
				case 'records':
					$query = $sql->order_by( 'c.dtdatacriacao', 'DESC' )
								->limit( $limit, $offset )
								->get();
					if($query) return $query->result();
					break;

				case 'recordsFiltered':
					return $sql->count_all_results();
					break;

				case 'recordsTotal':
					return $this->db->count_all(self::$_table);
					break;
			}

		}

		/**
		* Função que pega o contrato por locação
		* @param int ID da locação
		* @return array lista de contratos
		* @access public
		*/		
		
		public function getByLocacao($id)
		{
			$this->db->where('nidcadloc', $id);
			return $this->db->get('cadcon')->result();
		}

		/**
		* Função que pega o contrato por sinal
		* @param int ID do sinal
		* @return array lista de contratos
		* @access public
		*/		
		
		public function getBySinal($id)
		{
			$this->db->where('nidtbxsin', $id);
			return $this->db->get('cadcon')->row();
		}

	}