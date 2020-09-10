<?php
	class Atendimento_model extends MY_Model {

		/* Nome das tabelas no banco de dados */	
		protected static $_table = "cadate";
		protected static $_idfield = "nidcadate";
		
		/* Variável que contém a lista de erros */
		public $error;
		
		/**
		* Variável que contém o objeto do usuário para ser salvo na sessão
		* @access private
		*/
		private $atendimento;
		
		public function __construct(){
			parent::__construct();
			$this->user_id = $this->session->userdata('nidtbxsegusu');
		}

		/**
		* Função para visualizar um atendimento
		* @return array
		* @access public
		*/

		public function visualizar( $ate_id )
		{
			$select = array(
				'a.nidcadate'
				,'a.nidcadgrl AS geral'
				,'a.nidtbxsegusu'
				,'s.cnomesat AS cstatus'
				,'a.ddatastatus'
				,'a.nlibera AS clibera'
				,'a.nidtbxfin'
				,'a.didata'
				,'a.dudata'
				,'a.nidtbxsat'
				,'g.nidtbxchg'
				,'g.cobs'
				,'g.cnomegrl AS title' // nome do atendimenot no  cadastro geral
				,'t.cdescritel' // telefone
				,'tt.nidtbxttl' // id tipo de telefone
				,'tt.cdescrittl' // tipo de telefone
				,'e.cdescriemail AS email' // email do atendimento
				,'et.nidtbxtem' // id tipo de e-mail
				,'et.cdescritem' // tipo de e-mail
				,'u.nidtbxsegusu AS corretor' // id do corretor
				,'u.nidcadgrl' // cadastro geral do corretor
				,'ug.cnomegrl' // nome do corretor
				,'ue.cdescriemail' // email do corretor
				,'uc.cnome AS insertuser' // usuário que registrou o atendimento
				,'uu.cnome AS updateuser' // usuário que fez o último update
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table.' a' )
				->join( 'cadgrl g' , 'g.nidcadgrl = a.nidcadgrl', 'LEFT') // nome do atendimento cadastro geral
				->join( 'tagema e' , 'e.nidcadgrl = a.nidcadgrl', 'LEFT') // e-mail
				->join( 'tbxtem et' , 'et.nidtbxtem = e.nidtbxtem', 'LEFT') // tipo de e-mail
				->join( 'tagtel t' , 't.nidcadgrl = a.nidcadgrl', 'LEFT') // telefone
				->join( 'tbxttl tt' , 't.nidtbxttl = tt.nidtbxttl', 'LEFT') // tipo de telefone
				->join( 'tbxsegusu u' , 'u.nidtbxsegusu = a.nidtbxsegusu', 'LEFT') // cliberacorretor
				->join( 'cadgrl ug' , 'ug.nidcadgrl = u.nidcadgrl', 'LEFT') // cadastro geral do corretor
				->join( 'tagema ue' , 'ue.nidcadgrl = u.nidcadgrl', 'LEFT') // E-mail do corretor
				->join( 'tbxsat s', 'a.nidtbxsat = s.nidtbxsat', 'INNER' )
				->join( 'tbxsegusu uc' , 'uc.nidtbxsegusu = g.nidtbxsegusu_criacao', 'LEFT') // usuário que registrou o atendimento
				->join( 'tbxsegusu uu' , 'uu.nidtbxsegusu = g.nidtbxsegusu_atualizacao', 'LEFT') // usuário que fez o último update
				->where( array('a.nidcadate'=>$ate_id) )
				->get();

			if( $query = $sql->result() ){ 
				return $query[0];
			}
			
			return false;
		}

		/**
		* Função que retorna os atendimentos abertos de um usuário
		* @param integer id do usuário
		* @param integer id da finalidade
		* @return array lista de atendimentos
		*/

		public function getAbertos($usuario, $finalidade = null){

			$this->db->where('nidtbxsegusu', $usuario);
			if ($finalidade)
				$this->db->where('nidtbxfin', $finalidade);
			$this->db->where('nlibera', 1);
			$this->db->where('nativo', 1);
			$this->db->where('EXISTS(SELECT 1 FROM cadgrl WHERE cadate.nidcadgrl = cadgrl.nidcadgrl AND cadgrl.nativo = 1)', null, false);

			$this->db->order_by('didata', 'DESC');

			return $this->db->get('cadate')->result();

		}

		/**
		* Função que remove um Imóvel de um atendimento
		* @param integer id do atendimento
		* @param integer id do Imóvel
		* @access public
		*/

		public function removerImovel($cadate, $cadimo){

			$this->db->where('nidcadate', $cadate);

			$this->db->where('nidcadimo', $cadimo);

			$this->db->delete('tagiat');

			return true;

		}

		/**
		* Função que verifica se um Imóvel já faz parte de um atendimento
		* @param integer id do atendimento
		* @param integer id do Imóvel
		* @return boolean
		*/

		public function temAtendimentoImovel($cadate, $cadimo){

			$this->db->where('nidcadate', $cadate);
			$this->db->where('nidcadimo', $cadimo);

			$item = $this->db->get('tagiat')->row();

			return $item ? true : false;

		}

		/**
		* Função para adicionar um Imóvel a um atendimento
		* @param array dados a inserir
		* @access public
		*/

		public function salvarImovel($data){

			$this->db->insert('tagiat', $data);

			return true;

		}

		/**
		* Função que retorna os imóveis de um atendimento
		* @param integer id do atendimento
		* @access public
		*/

		public function getImoveis($cadate){

			$result = array();

			$this->db->where('nidcadate', $cadate);

			$lista = $this->db->get('tagiat')->result();

			foreach ($lista as $item){

				$this->db->where('nidcadimo', $item->nidcadimo);

				$result[] = $this->db->get('cadimo')->row();

			}

			return $result;

		}
		
		
		/**
		* Função para listar os atendimentos
		* @access public
		*/

		//public function listar_data( $fase='records', $offset=0, $limit=10, $data_ini=NULL, $data_end=NULL, $keyword=NULL, $tipo=NULL )
		public function listar_data( $fase='records', $offset=0, $limit=10, $params=NULL )
		{

			//var_dump($params); exit();

			// Construção da consulta
			// campos
			$select = array(
				'a.nidcadate'
				,'a.nidcadgrl'
				,'a.nidtbxsegusu'
				,'s.cnomesat AS cstatus'
				,'a.ddatastatus'
				,'a.nlibera AS clibera'
				,'a.nidtbxfin'
				,'a.didata'
				,'a.dudata'
				,'g.cnomegrl AS title' // nome do atendimenot no  cadastro geral
				,'g.cobs' // observação
				,'t.cdescritel' // telefone
				,'u.nidcadgrl' // cadastro geral do corretor
				,'ug.cnomegrl' // nome do corretor
				,'ue.cdescriemail' // email do corretor
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table.' a' )
				->join( 'cadgrl g' , 'g.nidcadgrl = a.nidcadgrl') // nome do atendimento cadastro geral
				->join( 'tagtel t' , 't.nidcadgrl = a.nidcadgrl', 'LEFT') // telefone
				->join( 'tbxsegusu u' , 'u.nidtbxsegusu = a.nidtbxsegusu') // corretor
				->join( 'tbxsat s', 'a.nidtbxsat = s.nidtbxsat', 'INNER')
				->join( 'cadgrl ug' , 'ug.nidcadgrl = u.nidcadgrl', 'LEFT') // cadastro geral do corretor
				->join( 'tagema ue' , 'ue.nidcadgrl = u.nidcadgrl', 'LEFT'); // email do corretor

			$sql->group_by('a.nidcadate');

			
			if(isset($params['type']))
			{
				$sql->where(array('a.nidtbxfin'=>$params['type']));
			}

			if(isset($params['status']))
			{
				$sql->where(array('a.nidtbxsat'=>$params['status']));
			}

			if( isset($params['date']) && count($params['date'])>1 )
			{
				foreach($params['date'] as $key => $value){
					$sql->where(array($key=>$value));
				}
			}

			if(isset($params['like']))
			{
				$count = 0;
				foreach($params['like'] as $key => $value){
					if($count==0){
						$sql->like(array($key=>$value));
					}else{
						$sql->or_like(array($key=>$value));
					}
					$count++;
				}
			}

			switch ($fase) {
				case 'records':
					$query = $sql->order_by( 'a.didata', 'DESC' )
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

		public function listar($offset=0, $limit=10, $keyword=NULL, $data_ini=NULL, $data_end=NULL)
		{
			$result['records'] = $this->listar_data( 'records', $offset, $limit, $keyword, $data_ini, $data_end );
			$result['recordsTotal'] = $this->listar_data( 'recordsTotal', $offset, $limit, $keyword, $data_ini, $data_end );
			$result['recordsFiltered'] = $this->listar_data( 'recordsFiltered', $offset, $limit, $keyword, $data_ini, $data_end );
			return $result;
		}

		
		private function recordsTotal()
		{
			return $this->db->count_all_results(self::$_table);
		}

		/**
		* Função para "excluir", na verdade desativar o registro
		* @access public
		*/
		/*
		public function del( $msg_id )
		{
			$where = array(
				'nidtagmsg' => $msg_id
				,'nidtbxsegusu' => $this->user_id
			);

			$data = array(
				'dtdel' => date('Y-m-d H:i:s')
				,'nativo' => 0
			);

			$query = $this->db->where($where)->update(self::$_table, $data);

			if($query) return true;
			return false;
		}
		*/


		
	}