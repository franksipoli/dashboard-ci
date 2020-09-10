<?php
	class Localidade_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxloc";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxloc";

		public $id;
		public $uf;
		public $descricao;
		public $cep;
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao(){

			if (!$this->uf){
				$this->error = 'UF em branco';
				return false;					
			}

			if (!$this->descricao){
				$this->error = 'Descrição em branco';
				return false;					
			}

			/* Verifica se o UF informado no select realmente existe */
			$uf = $this->db->where('nidtbxuf',$this->uf)->get('tbxuf')->row();
			if (!$uf){
				$this->error = 'A UF selecionada na lista não está cadastrada';
				return false;
			}

			/* Verifica se já existe uma Localidade com esta descrição nesta mesma UF */
			$loc = $this->db->where(['nativo'=>1, 'cdescriloc'=>$this->descricao])->where('ccep',$this->cep)->where('nidtbxuf',$this->uf)->get(self::$_table)->row();
			if ($loc){
				$this->error = 'Já existe uma localidade com a descrição "'.$this->descricao.'" para a UF e o CEP selecionados';
				return false;
			}

			return true;
		}

		/**
		* Função que verifica se já existe no banco de dados uma cidade com o nome e a UF apontados
		* @param int ID do UF que está sendo buscado
		* @param string Nome da localidade
		* @return object|boolean objeto da cidade caso a mesma existir, e false caso não existir
		* @access public
		*/

		public function getByNomeUF($uf, $descricao)
		{
			$this->db->where('nidtbxuf', $uf);
			$this->db->where('cdescriloc', $descricao);
			$loc = $this->db->get(self::$_table)->row();
			return !empty($loc) ? $loc : false;
		}

		/**
		* Função que valida se o registro pode ser atualizado no banco de dados
		* @access public
		* @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		*/

		public function validaAtualizacao(){
			if (!$this->uf){
				$this->error = 'UF em branco';
				return false;					
			}

			if (!$this->descricao){
				$this->error = 'Descrição em branco';
				return false;					
			}

			/* Verifica se o UF informado no select realmente existe */
			$uf = $this->db->where('nidtbxuf',$this->uf)->get('tbxuf')->row();
			if (!$uf){
				$this->error = 'A UF selecionada na lista não está cadastrada';
				return false;
			}

			/* Verifica se já existe uma Localidade com esta descrição nesta mesma UF e ID diferente */

			$this->db->where('cdescriloc', $this->descricao);
			$this->db->where('nidtbxuf', $this->uf);
			$this->db->where('nativo', 1);
			$this->db->where(self::$_idfield."!=".$this->id);

			if ( $this->cep ){
				$this->db->where('ccep', $this->cep);
			}

			$loc = $this->db->get(self::$_table)->row();
			if ($loc){
				$this->error = 'Já existe uma localidade com a descrição "'.$this->descricao.'" para a UF e o CEP selecionados';
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
				'nidtbxuf'=>$this->uf,
				'cdescriloc'=>$this->descricao,
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

		/**
		* Função para buscar registros com base no nome
		* @access public
		* @param string nome da localidade
		* @return array de objetos
		*/


		public function getByNome($term)
		{
			$this->db->where('dtdataexc IS NULL AND nidtbxsegusu_exclusao IS NULL AND nativo = 1 AND (cdescriloc LIKE "%'.$term.'%")', null, false);

			$result = $this->db->get('tbxloc')->result();
			return $result;
		}

	}