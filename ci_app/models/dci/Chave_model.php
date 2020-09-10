<?php
	class Chave_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "cadchv";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidcadchv";
		
		public $imovel;
		public $local;
		public $usuario_criacao;

		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
		{
			if (!$this->usuario_criacao){
				$this->error = 'Usuário não encontrado (Criação)';
				return false;
			}
			if (!$this->imovel){
				$this->error = 'Imóvel em branco';
				return false;					
			}
			/* Verifica se o Imóvel existe */
			$imo = $this->db->where('nidcadimo', $this->imovel)->get('cadimo')->row();
			if (!$imo){
				$this->error = 'Imóvel não encontrado';
				return false;
			}
			if (!$this->local){
				$this->error = 'Local de chaves em branco';
				return false;
			}
			/* Verifica se o local de chaves existe */
			$lch = $this->db->where('nidtbxlch', $this->local)->get('tbxlch')->row();
			if (!$lch){
				$this->error = 'Local de chaves não encontrado';
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
			/* Criar */
			$data = array(
				'nidcadimo'=>$this->imovel,
				'nidtbxlch'=>$this->local,
				'nidtbxsegusu_criacao'=>$this->usuario_criacao,
				'dtdatacriacao'=>date('Y-m-d H:i:s')
			);
			$this->db->insert(self::$_table, $data);
			return $this->db->insert_id();
		}

		/**
		* Verifica se a chave está disponível para retirada
		* @param integer id da chave
		* @return boolean disponibilidade da chave para retirada
		*/

		public function disponivel($id)
		{
			$this->db->where('nidcadchv', $id);
			$this->db->where('dtdatadevolucao IS NULL', null, false);

			$retirada = $this->db->get('cadata')->row();
			if ($retirada){
				/* A chave possui uma retirada sem devolução */
				return false;
			} else {
				/* A chave não possui retirada sem devolução */
				return true;
			}	
		}

		/**
		* Função para retirar uma chave
		* @param integer ID da chave
		* @param integer ID do usuário
		* @return id da movimentação
		*/

		public function retirar($id, $cadastro, $observacoes){
			$data = array('nidcadchv'=>$id, "nidcadgrl_retirada"=>$cadastro, "cobservacoes"=>$observacoes,"nidtbxsegusu_criacao"=>$this->usuario_criacao,"dtdatacriacao"=>date('Y-m-d H:i:s'));
			$this->db->insert('cadata', $data);
			return $this->db->insert_id();
		}

		/**
		* Função para devolver uma chave
		* @param integer ID da chave
		* @param integer ID do usuário
		* @return id da movimentação
		*/

		public function devolver($id, $cadastro){
			$this->db->where('nidcadchv', $id);
			$this->db->where('dtdatadevolucao IS NULL', null, false);
			$data = array("nidcadgrl_devolucao"=>$cadastro, "dtdatadevolucao"=>date('Y-m-d H:i:s'));
			$this->db->update('cadata', $data);
			return $id;
		}

		/**
		* Função para listar as chaves utilizando json
		*/

		public function listar_data( $fase='records', $offset=0, $limit=10, $params=NULL )
		{

			// Construção da consulta
			// campos
			$select = array(
				'c.nidcadchv'
				,'c.nidtbxlch'
				,'DATE_FORMAT(c.dtdatacriacao, "%d/%m/%Y %H:%i") AS dtdatacriacao'
				,'l.cnomelch'
				,'l.ncontrole'
				,'i.creferencia'
				,'i.nunidade'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table.' c' )
				->where('c.nidcadimo', $params['imovel'])
				->join('cadimo i', 'c.nidcadimo = i.nidcadimo', 'INNER')
				->join( 'tbxlch l' , 'c.nidtbxlch = l.nidtbxlch', 'INNER'); // local de chave

			// condições
			$sql->where('c.nativo', 1);

			switch ($fase) {
				case 'records':
					$query = $sql->order_by( 'c.dtdatacriacao', 'DESC' )
								->get();
					if($query) return $query->result();
					break;

				case 'recordsFiltered':
					return $sql->count_all_results();
					break;

				case 'recordsTotal':
					$this->db->get();
					return $this->db->where('nidcadimo', $params['imovel'])->where('nativo', 1)->count_all_results(self::$_table);
					break;
			}

		}

		/**
		* Função para listar a ata de uma chave utilizando json
		*/

		public function listar_ata_data( $fase='records', $offset=0, $limit=10, $params=NULL )
		{

			// Construção da consulta
			// campos
			$select = array(
				'a.nidcadata'
				,'DATE_FORMAT(a.dtdatacriacao, "%d/%m/%Y %H:%i") AS dtdatacriacao'
				,'DATE_FORMAT(a.dtdatadevolucao, "%d/%m/%Y %H:%i") AS dtdatadevolucao'
				,'a.nidcadgrl_retirada'
				,'ur.cnomegrl AS usuario_retirada'
				,'ud.cnomegrl AS usuario_devolucao'
				,'a.nidcadgrl_devolucao'
				,'a.cobservacoes'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( 'cadata a' )
				->where('a.nidcadchv', $params['chave'])
				->join('cadgrl ur', 'a.nidcadgrl_retirada = ur.nidcadgrl', 'LEFT')
				->join('cadgrl ud' , 'a.nidcadgrl_devolucao = ud.nidcadgrl', 'LEFT'); // local de chave

			// condições
			$sql->where('a.nativo', 1);

			switch ($fase) {
				case 'records':
					$query = $sql->order_by( 'a.dtdatacriacao', 'DESC' )
								->get();
					if($query) return $query->result();
					break;

				case 'recordsFiltered':
					return $sql->count_all_results();
					break;

				case 'recordsTotal':
					$this->db->get();
					return $this->db->where('nidcadchv', $params['chave'])->where('nativo', 1)->count_all_results('cadata');
					break;
			}

		}

		/**
		* Função para obter a lista de chaves de um Imóvel
		* @param integer id do Imóvel
		* @return array lista de chaves
		*/

		public function getByImovel($id)
		{
			$this->db->where('nidcadimo', $id);
			$this->db->where('nativo', 1);
			$chaves = $this->db->get('cadchv')->result();
			foreach ($chaves as $key=>$chave){
				$this->db->where('nidtbxlch', $chave->nidtbxlch);
				$chaves[$key]->tipo = $this->db->get('tbxlch')->row();
			}
			return $chaves;
		}

	}