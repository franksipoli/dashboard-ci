<?php
	class Entidade_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxent";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxent";
		
		public $creci_juridico;
		public $cadgrl;
		public $cadjur;

		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		 
		public function validaInsercao()
		{

			/* Verifica se foi preenchido o cadastro geral ou o cadastro de pessoa jurídica */
			if (!$this->cadgrl && !$this->cadjur){
				$this->error = 'O cadastro geral ou o cadastro de pessoa jurídica devem ser preenchidos';
				return false;
			}

			if ($this->cadgrl){
				$cadgrl = $this->db->where('nidcadgrl', $this->cadgrl)->get('cadgrl')->row();
				if (!$cadgrl){
					$this->error = 'Cadastro geral não encontrado';
					return false;
				}
			}

			if (!$this->cadjur){
				$cadjur = $this->db->where('nidcadjur', $this->cadjur)->get('cadjur')->row();
				if (!$cadjur){
					$this->error = 'Cadastro de pessoa jurídica não encontrado';
					return false;
				}
			}

			return true;
		}
		
		/**
		* Função que valida se o registro pode ser atualizado no banco de dados
		* @access public
		* @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		*/
		
		public function validaAtualizacao()
		{
			/* Verifica se foi preenchido o cadastro geral ou o cadastro de pessoa jurídica */
			if (!$this->cadgrl && !$this->cadjur){
				$this->error = 'O cadastro geral ou o cadastro de pessoa jurídica devem ser preenchidos';
				return false;
			}

			if ($this->cadgrl){
				$cadgrl = $this->db->where('nidcadgrl', $this->cadgrl)->get('cadgrl')->row();
				if (!$cadgrl){
					$this->error = 'Cadastro geral não encontrado';
					return false;
				}
			}

			if (!$this->cadjur){
				$cadjur = $this->db->where('nidcadjur', $this->cadjur)->get('cadjur')->row();
				if (!$cadjur){
					$this->error = 'Cadastro de pessoa jurídica não encontrado';
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
			if ($this->id){
				/* Atualizar */
				$data = array(
					'ccrecijuridico'=>$this->creci_juridico,
					'nidcadgrl'=>$this->cadgrl,
					'nidcadjur'=>$this->cadjur,
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'crecijuridico'=>$this->creci_juridico,
					'nidcadgrl'=>$this->cadgrl,
					'nidcadjur'=>$this->cadjur
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		* Função que retorna as entidades que são pais, ou seja, não possuem registro na tabela de filial
		* @return array lista de entidades
		* @access public
		*/

		public function getPais()
		{
			$this->db->where('NOT EXISTS(SELECT 1 FROM tagfil WHERE nidtbxent_pai = tbxent.nidtbxent)', null, false);
			$ent = $this->db->get('tbxent')->result();
			$result = array();
			foreach ($ent as $item){
				$nome = '';
				if ($item->nidcadgrl){
					$this->db->where('nidcadgrl', $item->nidcadgrl);
					$cadgrl = $this->db->get('cadgrl')->row();
					$nome = $cadgrl->cnomegrl;
				} elseif($item->nidcadjur){
					$this->db->where('nidcadjur', $item->nidcadjur);
					$cadjur = $this->db->get('cadjur')->row();
					$nome = $cadjur->cnomefant;
				}
				$result[] = array("nidtbxent"=>$item->nidtbxent,"nome"=>$nome);
			}
			return $result;
		}

		/**
		* Função que retorna uma entidade com base no ID da pessoa jurídica
		* @param integer ID da pessoa jurídica
		* @return array lista de entidades
		* @access public
		*/

		public function getByPessoaJuridica($nidcadjur)
		{
			$this->db->where('nidcadjur', $nidcadjur);
			$this->db->where('nativo', 1);
			$ent = $this->db->get('tbxent')->row();
			return $ent;
		}

	}