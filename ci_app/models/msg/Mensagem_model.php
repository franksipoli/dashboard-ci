<?php
	class Mensagem_model extends MY_Model {

		/* Nome das tabelas no banco de dados */	
		protected static $_table = "tagmsg";
		protected static $_table_usu = "tagmsgusu";
		
		/* Variável que contém a lista de erros */
		public $error;
		
		/**
		* Variável que contém o objeto do usuário para ser salvo na sessão
		* @access private
		*/
		private $mensagem;
		
		public function __construct(){
			parent::__construct();
			$this->user_id = $this->session->userdata('nidtbxsegusu');
		}
		
		/**
		* Função para visualizar uma mensagem
		* @return array
		* @access public
		*/

		public function visualizar( $msg_id )
		{
			$select = array(
				'um.nidtagmsgusu'
				,'um.nidtagmsg AS msg_id'
				,'m.dtini AS send_date'
				,'m.nidtbxsegusu as sender_id'
				,'m.cassunto AS subject'
				,'m.tmensagem AS message'
				,'u.cnome AS sender_name'
			);

			$where = array(
				'm.nidtagmsg' => $msg_id
				,'m.nativo' => 1
				,'um.nativo' => 1
				,'(um.nidtbxsegusu = '.$this->user_id.' OR m.nidtbxsegusu = '.$this->user_id.')'
			);

			$sql = $this->db->select( $select )
				->from( self::$_table_usu.' um' )
				->join( self::$_table.' m' , 'm.nidtagmsg = um.nidtagmsg')
				->join( 'tbxsegusu u' , 'u.nidtbxsegusu = um.nidtbxsegusu')
				->where( $where )
				->get();

			if( $query = $sql->result() ){ 
				$this->mark_as_read( $query[0]->nidtagmsgusu );
				return $query[0];
			}
			
			return false;
		}
		
		/**
		* Função para inserir a mensagem no banco
		* @return ID da mensagem
		* @access public
		*/

		public function save()
		{
			$data = array(
				'nidtbxsegusu' => $this->user_id
				,'dtini' => date('Y-m-d H:i:s')
				,'cassunto' => $this->assunto
				,'tmensagem' => $this->msg_txt
			);

			if($this->db->insert(self::$_table, $data))
			{
				$msg_id = $this->db->insert_id();
				foreach ($this->destinatarios as $to)
				{
					$d = array(
						'nidtagmsg' => $msg_id
						,'nidtbxsegusu' => $to
					);
					$this->db->insert(self::$_table_usu, $d);
				}
				return $msg_id;
			}
			return false;
		}


		/**
		* Função para listar as mensagem recebidas
		* @access public
		*/

		public function list_inbox( $offset=0, $limit=10, $keyword=NULL )
		{

			// Construção da consulta
			// campos
			$select = array(
				'um.nidtagmsg AS msg_id'
				,'um.dtlido AS readed'
				,'m.nidtbxsegusu AS sender_id'
				,'m.dtini AS send_date'
				,'m.cassunto AS subject'
				,'u.cnome AS sender_name'
			);

			// condições
			$where = array(
				'um.nidtbxsegusu' => $this->user_id
				,'um.nativo' => 1
				,'m.nativo' => 1
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table_usu.' um' )
				->join( self::$_table.' m' , 'm.nidtagmsg = um.nidtagmsg', 'INNER')
				->join( 'tbxsegusu u' , 'u.nidtbxsegusu = m.nidtbxsegusu', 'INNER')
				->where( $where );

			// se houver busca acrescenta as condições no query builder
			if($keyword){
				$sql->like( array('m.cassunto' => $keyword) )
					->or_like( array(
						'm.tmensagem' => $keyword
						,'u.cnome' => $keyword
					)
				);
			}		
			
			// finalizando a consulta
			$sql->order_by( 'm.dtini', 'DESC' )
				->limit( $limit, $offset );

			// Retorno
			// Lista de registros
			$result['records'] = ($query = $sql->get()) 
				? $query->result() 
				: false;

			// Total de reguistros retornadas na query (com filtros)
			$result['recordsFiltered'] = count($result['records']);

			// Total de reguistros retornadas na query (sem filtros)
			$result['recordsTotal'] = $this->db
				->where( $where )
				->from( self::$_table_usu.' um' )
				->join( self::$_table.' m' , 'm.nidtagmsg = um.nidtagmsg', 'INNER')
				->count_all_results();

			return $result;
		}

		/**
		* Função para checar novas mensagem recebidas
		* @access public
		*/

		public function check()
		{

			// Construção da consulta
			// campos
			$select = array(
				'um.nidtagmsg AS msg_id'
				,'m.cassunto AS subject'
				,'u.cnome AS sender_name'
			);

			// condições
			$where = array(
				'um.nidtbxsegusu' => $this->user_id
				,'um.dtlido' => NULL
				,'um.nativo' => 1
				,'m.nativo' => 1
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table_usu.' um' )
				->join( self::$_table.' m' , 'm.nidtagmsg = um.nidtagmsg', 'INNER')
				->join( 'tbxsegusu u' , 'u.nidtbxsegusu = m.nidtbxsegusu', 'INNER')
				->where( $where )
				->order_by( 'm.dtini', 'DESC' );

			
			// Array de mensagens não lidas
			$result = ($query = $sql->get()) 
				? $query->result() 
				: false;

			return $result;
		}


		/**
		* Função para listar as mensagem enviadas
		* @access public
		*/

		public function list_send( $offset, $limit )
		{
			$select = array(
				'm.nidtagmsg AS msg_id'
				,'m.nidtbxsegusu'
				,'m.dtini AS send_date'
				,'m.cassunto AS subject'
				,'(SELECT COUNT(*) FROM tagmsgusu mu WHERE mu.nidtagmsg = m.nidtagmsg ) AS msg_total'
			);

			$where = array(
				'm.nidtbxsegusu' => $this->user_id
				,'m.dtdel' => NULL
				,'m.nativo' => 1
			);

			$this->db->select( $select )
				->from( self::$_table.' m' )
				->where( $where )
				->order_by( 'm.dtini', 'DESC' )
				->limit( $limit, $offset );

			return ($query = $this->db->get()) 
				? $query->result() 
				: false;
		}


		/**
		* Função para marcar a mensagem como lida
		* @access public
		*/

		public function mark_as_read( $id )
		{
			$where = array(
				'nidtagmsgusu' => $id
			);

			$data = array(
				'dtlido' => date('Y-m-d H:i:s')
			);

			if($this->db->where($where)->update(self::$_table_usu, $data)) return true;
			return false;
		}


		/**
		* Função para marcar a mensagem como não lida
		* @access public
		*/

		public function mark_as_unread()
		{
			$where = array(
				'nidtagmsg' => $this->msg_id
				,'nidtbxsegusu' => $this->user_id
			);

			$data = array(
				'dtlido' => NULL
			);

			if($this->db->where($where)->update(self::$_table_usu, $data))
				return $msg_id;

			return false;
		}


		/**
		* Função para "excluir" a mensagem no banco
		* @access public
		*/

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
		
	}