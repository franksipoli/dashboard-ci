<?php
	class Uf_model extends MY_Model {
		/* Nome da tabela no banco de dados */
		protected static $_table = "tbxuf";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxuf";
		/* Sigla da UF */
		public $sigla;
		/* País da UF */
		public $pais;
		
		/**
		 * Função que valida se o registro pode ser adicionado ao banco de dados
		 * @access public
		 * @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao(){
			if (!$this->descricao){
				$this->error = 'Descrição em branco';
				return false;					
			}
			if (!$this->sigla){
				$this->error = 'Sigla em branco';
				return false;					
			}
			if (!$this->pais){
				$this->error = 'País em branco';
				return false;					
			}
			$pas = $this->db->where('nidtbxpas',$this->pais)->get('tbxpas')->row();
			if (!$pas){
				$this->error = 'O país selecionado na lista não está cadastrado';
				return false;
			}
			$uf = $this->db->where(['nativo'=>1, 'cdescriuf'=>$this->descricao])->where('nidtbxpas',$this->pais)->get(self::$_table)->row();
			if ($uf){
				$this->error = 'Já existe uma UF com a descrição "'.$this->descricao.'" para o país selecionado';
				return false;
			}
			$uf = $this->db->where(['nativo'=>1, 'csiglauf'=>$this->sigla])->where('nidtbxpas',$this->pais)->get(self::$_table)->row();
			if ($uf){
				$this->error = 'Já existe uma UF com a sigla "'.$this->sigla.'" para o país selecionado';
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
			if (!$this->descricao){
				$this->error = 'Descrição em branco';
				return false;					
			}
			if (!$this->sigla){
				$this->error = 'Sigla em branco';
				return false;					
			}
			if (!$this->pais){
				$this->error = 'País em branco';
				return false;					
			}
			$pas = $this->db->where('nidtbxpas',$this->pais)->get('tbxpas')->row();
			if (!$pas){
				$this->error = 'O país selecionado na lista não está cadastrado';
				return false;
			}
			$uf = $this->db->where(['nativo'=>1, 'cdescriuf'=>$this->descricao])->where('nidtbxpas',$this->pais)->where(self::$_idfield."!=".$this->id)->get(self::$_table)->row();
			if ($uf){
				$this->error = 'Já existe uma UF com a descrição "'.$this->descricao.'" para o país selecionado';
				return false;
			}
			$uf = $this->db->where(['nativo'=>1, 'csiglauf'=>$this->sigla])->where('nidtbxpas',$this->pais)->where(self::$_idfield."!=".$this->id)->get(self::$_table)->row();
			if ($uf){
				$this->error = 'Já existe uma UF com a sigla "'.$this->sigla.'" para o país selecionado';
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
			if ($this->id){
				/* Atualizar */
				$data = array(
					'nidtbxpas'=>$this->pais,
					'csiglauf'=>$this->sigla,
					'cdescriuf'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'nidtbxpas'=>$this->pais,
					'csiglauf'=>$this->sigla,
					'cdescriuf'=>$this->descricao
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		 * Função pa retornar a lista de estados de um país
		 * @param integer id do país
		 * @return array lista de estados
		 * @access public
		*/

		public function getByPais($pais){
			$this->db->where('nativo', 1);
			$this->db->where('nidtbxpas', $pais);
			$this->db->order_by('csiglauf', 'ASC');
			return $this->db->get('tbxuf')->result();
		}

	}
?>