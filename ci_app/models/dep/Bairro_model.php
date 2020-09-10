<?php
	class Bairro_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxbai";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxbai";

		public $id;
		public $cidade;
		public $descricao;
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao(){

			if (!$this->cidade){
				$this->error = 'Cidade em branco';
				return false;					
			}

			if (!$this->descricao){
				$this->error = 'Descrição em branco';
				return false;					
			}

			/* Verifica se o UF informado no select realmente existe */
			$cidade = $this->db->where('nidtbxloc',$this->cidade)->get('tbxloc')->row();
			if (!$cidade){
				$this->error = 'A cidade selecionada na lista não está cadastrada';
				return false;
			}

			/* Verifica se já existe um Bairro com esta descrição nesta mesma Cidade */
			$bairro = $this->db->where(['nativo'=>1, 'cdescribai'=>$this->descricao])->where('nidtbxloc',$this->cidade)->get(self::$_table)->row();
			if ($bairro){
				$this->error = 'Já existe um bairro com a descrição "'.$this->descricao.'" para a cidade selecionada';
				return false;
			}

			return true;
		}

		/**
		* Função que valida se o registro pode ser atualizado no banco de dados
		* @access public
		* @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		*/

		public function validaAtualizacao(){
			if (!$this->cidade){
				$this->error = 'Cidade em branco';
				return false;					
			}

			if (!$this->descricao){
				$this->error = 'Descrição em branco';
				return false;					
			}

			/* Verifica se a Cidade informada no select realmente existe */
			$cidade = $this->db->where('nidtbxloc',$this->cidade)->get('tbxloc')->row();
			if (!$cidade){
				$this->error = 'A cidade selecionada na lista não está cadastrada';
				return false;
			}

			/* Verifica se já existe um bairro com esta descrição nesta mesma cidade */

			$this->db->where('cdescribai', $this->descricao);
			$this->db->where('nidtbxloc', $this->cidade);
			$this->db->where(self::$_idfield."!=".$this->id);

			$bairro = $this->db->get(self::$_table)->row();
			if ($bairro){
				$this->error = 'Já existe um bairro com a descrição "'.$this->descricao.'" para a cidade selecionados';
				return false;
			}

			return true;
		}

		/**
		* Função que verifica se já existe no banco de dados um bairro com o nome e a cidade apontados
		* @param int ID da cidade que está sendo buscada
		* @param string Nome do bairro que está sendo buscado
		* @return object|boolean objeto do bairro caso o mesmo existir, e false caso não existir
		* @access public
		*/

		public function getByNomeCidade($cidade, $descricao)
		{
			$this->db->where('nidtbxloc', $cidade);
			$this->db->where('cdescribai', $descricao);
			$bairro = $this->db->get(self::$_table)->row();
			return !empty($bairro) ? $bairro : false;
		}



		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/

		public function save(){

			$data = array(
				'nidtbxloc'=>$this->cidade,
				'cdescribai'=>$this->descricao
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