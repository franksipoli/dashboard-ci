<?php
	class App_model extends MY_Model {

		public $id;

		/* Nome das tabelas no banco de dados */	
		protected static $_table = "tbxapp";
		protected static $_idfield = "nidtbxapp";
		
		protected static $_field = "tbxfld";
		protected static $_app_field = "tagvld";
		
		/* Variável que contém a lista de erros */
		public $error;
		
		/**
		* Variável que contém o objeto do usuário para ser salvo na sessão
		* @access private
		*/
		
		public function __construct(){
			parent::__construct();
		}

		/**
		* Função para atualizar os campos obrigatórios em uma aplicação
		* @param array lista de campos obrigatórios
		* @return boolean true se sucesso
		* @access public
		*/	



		public function atualizarValidacoes( $required = array() )
		{

			/* Seta todos os campos para 0 (sem validação) */

			var_dump($this->id);

			$this->db->where("nidtbxapp", $this->id);

			$data = array(
				"nrequired" => 0
			);

			$this->db->update("tagvld", $data);

			foreach ($required as $field=>$is_required){

				$this->db->where('nidtagfld', $field);

				$data = array(
					"nrequired" => 1
				);

				$this->db->update('tagvld', $data);

			}

			return true;

		}
		
		/**
		* Função para visualizar abrir um app para edição
		* @param Integer ID da aplicação
		* @return array
		* @access public
		*/

		public function open( $app_id )
		{
			// Busca o app
			$app_sql = $this->db->select('cname')
						->from(self::$_table)
						->where(array(
							'nidtbxapp' => $app_id
							,'nativo' => 1
						))
						->get();

			// Busca os campos
			$fld_sql = $this->db->select(array(
							'af.nidtagfld'
							,'af.nidtbxapp AS app_id'
							,'af.nidtbxfld AS field_id'
							,'af.nrequired AS required'
							,'f.ctype AS field_type'
							,'f.clabel AS field_label'
						))
						->from(self::$_app_field.' af')
						->join( self::$_field.' f' , 'f.nidtbxfld = af.nidtbxfld')
						->where(array(
							'af.nidtbxapp' => $app_id
							,'af.nativo' => 1
							,'f.nativo' => 1
						))
						->get();

			// Se houver app
			if( $app = $app_sql->result() )
			{
				$data['app_name'] = $app[0]->cname;
				$data['fields'] = $fld_sql->result();

				$this->id = $app_id;

				return $data;
			}
			// caso não exista
			return false;
		}

		/**
		* Função para pegar os campos de preenchimento obrigatório de um formulário
		* @param String nome do formulário
		* @return array lista de campos obrigatórios
		* @access public
		*/

		public function getFieldsByAplicacao( $app )
		{
			$app = $this->db->where('cname', $app)->get(self::$_table)->row();
			if (!$app)
				return false;
			$fields = $this->db->where('nidtbxapp', $app->nidtbxapp)->where('nativo',1)->where('nrequired',1)->get(self::$_app_field)->result();
			$result = array();
			foreach ($fields as $field){
				$field_data = $this->db->where('nidtbxfld', $field->nidtbxfld)->get(self::$_field)->row();
				if (!in_array($field_data->clabel, $result))
					$result[] = $field_data->clabel;
			}
			return $result;
		}
		
		/**
		* Função para pegar uma aplicação pelo nome
		* @param string nome da aplicação
		* @return object Objeto da aplicação
		* @access public
		*/

		public function getByName($app){
			$app = $this->db->where('cname', $app)->get(self::$_table)->row();
			return $app;
		}
		
	}