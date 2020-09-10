<?php
	class Logradouro_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "cadlog";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidcadlog";

		public $id;
		public $tipo;
		public $bairro;
		public $descricao;
		public $cep;
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao(){

			if (!$this->bairro){
				$this->error = 'Bairro em branco';
				return false;					
			}

			if (!$this->descricao){
				$this->error = 'Descrição em branco';
				return false;					
			}

			/* Verifica se o bairro informado no select realmente existe */
			$bairro = $this->db->where('nidtbxbai',$this->bairro)->get("tbxbai")->row();
			if (!$bairro){
				$this->error = 'O bairro selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se já existe um logradouro com esta descrição no mesmo bairro e com o mesmo CEP */
			$log = $this->db->where(['nativo'=>1, 'cdescrilog'=>$this->descricao])->where('nidtbxtpl',$this->tipo)->where('ccep',$this->cep)->where('nidtbxbai',$this->bairro)->get(self::$_table)->row();
			if ($log){
				$this->error = 'Já existe um logradouro com a descrição "'.$this->descricao.'" para o bairro e o CEP selecionados';
				return false;
			}

			return true;
		}

		/**
		* Função que verifica se já existe no banco de dados um logradouro com o nome, o bairro e o CEP apontados
		* @param int ID do tipo de logradouro
		* @param int ID do bairro que está sendo buscado
		* @param string Nome do logradouro que está sendo buscado
		* @param string CEP do logradouro que está sendo buscado
		* @return object|boolean objeto do bairro caso o mesmo existir, e false caso não existir
		* @access public
		*/

		public function getByTipoNomeBairroCEP($tipo, $bairro, $descricao, $cep)
		{
			$this->db->where('nidtbxbai', $bairro);
			$this->db->where('nidtbxtpl', $tipo);
			$this->db->where('cdescrilog', $descricao);
			if ( $cep )
				$this->db->where('ccep', $cep);
			$log = $this->db->get(self::$_table)->row();
			return !empty($log) ? $log : false;
		}

		/**
		* Função que valida se o registro pode ser atualizado no banco de dados
		* @access public
		* @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		*/

		public function validaAtualizacao(){

			if (!$this->bairro){
				$this->error = 'Bairro em branco';
				return false;					
			}

			if (!$this->descricao){
				$this->error = 'Descrição em branco';
				return false;					
			}

			/* Verifica se o bairro informado no select realmente existe */

			$bairro = $this->db->where('nidtbxbai',$this->bairro)->get('tbxbai')->row();
			if (!$bairro){
				$this->error = 'O bairro selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se já existe um logradouro com esta descrição no mesmo bairro, mesmo cep e ID diferente */

			$this->db->where('cdescrilog', $this->descricao);
			$this->db->where('nidtbxbai', $this->bairro);
			$this->db->where('nidtbxtpl', $this->tipo);
			$this->db->where('nativo', 1);
			
			if ( $this->cep ){
				$this->db->where('ccep', $this->cep);
			}
		
			$this->db->where(self::$_idfield."!=".$this->id);

			$log = $this->db->get(self::$_table)->row();
			if ($log){
				$this->error = 'Já existe um logradouro com a descrição "'.$this->descricao.'" para o bairro e o CEP selecionados';
				return false;
			}

			return true;
		}

		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/

		public function save(){

			$data = array(
				'nidtbxtpl'=>$this->tipo,
				'nidtbxbai'=>$this->bairro,
				'cdescrilog'=>$this->descricao,
				'ccep'=>$this->cep
			);

			if ($this->id){

				/* Atualizar */

				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);

				return $this->id;	

			} else {

				/* Criar */

				$this->db->insert(self::$_table, $data);

				$this->id = $this->db->insert_id();

				return $this->id;
				
			}
		}

	}