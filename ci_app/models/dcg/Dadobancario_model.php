<?php
	class Dadobancario_model extends MY_Model {
		
		public $id;		
		public $cadastro;
		public $banco;
		public $titular;
		public $agencia;
		public $conta;
		public $tipo_conta;
		public $codigo_tipo_conta;
		public $cliente_desde;
		public $principal = 0;

		/* Nome da tabela no banco de dados */
		protected static $_table = "tagbco";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtagbco";

		/**
		 * Função que valida se o registro pode ser adicionado ao banco de dados
		 * @access public
		 * @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		 
		public function validaInsercao(){
			if ($this->principal){
				$this->db->where('nprincipal', 1);
				$this->db->where('nidcadgrl', $this->cadastro);
				$this->db->where('nativo', 1);
				$principal = $this->db->get('tagbco')->row();
				if ($principal){
					$this->principal = 0;
				}
			}
			if (!$this->banco){
				$this->error = 'Banco em branco';
				return false;
			}
			if (!$this->conta){
				$this->error = 'Conta em branco';
				return false;
			}
			if (!$this->agencia){
				$this->error = 'Agência em branco';
				return false;
			}
			if (!$this->cadastro){
				$this->error = 'Campo em branco';
				return false;					
			}
			/* Procura cpor uma conta com os mesmos dados */
			$this->db->where('nidtbxbco', $this->banco);
			$this->db->where('cagencia', $this->agencia);
			$this->db->where('cconta', $this->conta);
			$this->db->where('nidtbxtic', $this->tipo_conta);
			$this->db->where('nidcadgrl', $this->cadastro);
			$conta_existente = $this->db->get('tagbco')->row();
			if ($conta_existente){
				$this->error = 'Esta conta já está cadastrada';
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
			if (!$this->cadastro){
				$this->error = 'Campo em branco';
				return false;
			}
			return true;
		}

		/**
		 * Função que torna a conta principal
		 * @access public
		 * @return true
		 */
		
		public function tornarPrincipal(){
			$dadobancario = $this->getById($this->id);
			$this->db->where('nidcadgrl', $dadobancario->nidcadgrl);
			$data = array('nprincipal'=>0);
			$this->db->update('tagbco', $data);
			$data = array('nprincipal'=>1);
			$this->db->where('nidtagbco', $this->id);
			$this->db->update('tagbco', $data);
			return true;
		}

		/**
		 * Função que desfaz a conta principal
		 * @access public
		 * @return true
		 */
		
		public function desfazerPrincipal(){
			$dadobancario = $this->getById($this->id);
			$data = array('nprincipal'=>0);
			$this->db->where('nidtagbco', $this->id);
			$this->db->update('tagbco', $data);
			return true;
		}

		/**
		 * Função para pegar os dados bancários através do cadastro geral
		 * @access public
		 * @return array lista de dados bancários
		*/

		public function getByCadastroGeral($nidcadgrl){
			$this->db->where('nativo', 1);
			$this->db->order_by('nprincipal', 'DESC');
			$this->db->where('nidcadgrl', $nidcadgrl);
			return $this->db->get('tagbco')->result();
		}

		/**
		 * Função para remover os dados bancários de um cadastro
		 * @access public
		 * @return true
		*/

		public function removeByCadastro($nidcadgrl){
			$this->db->where('nidcadgrl', $nidcadgrl);
			$this->db->delete('tagbco');
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
					'nidcadgrl'=>$this->cadastro,
					'ctitular'=>$this->titular,
					'nidtbxbco'=>$this->banco,
					'cagencia'=>$this->agencia,
					'cconta'=>$this->conta,
					'nidtbxtic'=>$this->tipo_conta,
					'ccodtipoconta'=>$this->codigo_tipo_conta,
					'ddtclientedesde'=>$this->cliente_desde,
					'nprincipal'=>$this->principal
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {

				/* Criar */
			
				$data = array(
					'nidcadgrl'=>$this->cadastro,
					'ctitular'=>$this->titular,
					'nidtbxbco'=>$this->banco,
					'cagencia'=>$this->agencia,
					'cconta'=>$this->conta,
					'nidtbxtic'=>$this->tipo_conta,
					'ccodtipoconta'=>$this->codigo_tipo_conta,
					'ddtclientedesde'=>$this->cliente_desde,
					'nprincipal'=>$this->principal ? 1 : 0
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}



	}