<?php
	class Proposta_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxpro";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxpro";

		public $imovel;
		public $cliente;
		public $texto;
		public $data;
		public $tipo;
		public $usuario_criacao;
		public $data_criacao;
		public $usuario_alteracao;
		public $data_alteracao;
		public $usuario_exclusao;
		public $data_exclusao;
		public $status = 1;
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
		{
			
			if (!$this->imovel){
				$this->error = 'Imóvel em branco';
				return false;					
			}

			$this->db->where('nidcadimo', $this->imovel);
			$imo = $this->db->get('cadimo')->row();
			if (!$imo){
				$this->error = 'Imóvel não encontrado';
				return false;
			}

			if (!$this->cliente){
				$this->error = 'Cliente em branco';
				return false;
			}

			$this->db->where('nidcadgrl', $this->cliente);
			$cadgrl = $this->db->get('cadgrl')->row();
			if (!$cadgrl){
				$this->error = 'Cadastro não encontrado';
				return false;
			}

			if (!$this->data){
				$this->error = 'Data em branco';
				return false;
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
				$this->db->where(self::$_idfield, $this->id);
				/* Atualizar */
				$data = array(
					'nidcadimo'=>$this->imovel,
					'nidcadgrl'=>$this->cliente,
					'nidtbxtpr'=>$this->tipo,
					'tdescricao'=>$this->texto,
					'dtdata'=>$this->data,
					'nidtbxsegusu_atualizacao'=>$this->usuario_alteracao,
					'dtdataatualizacao'=>$this->data_alteracao,
					'nstatus'=>$this->status
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'nidcadimo'=>$this->imovel,
					'nidcadgrl'=>$this->cliente,
					'nidtbxtpr'=>$this->tipo,
					'tdescricao'=>$this->texto,
					'dtdata'=>$this->data,
					'nidtbxsegusu_criacao'=>$this->usuario_criacao,
					'dtdatacriacao'=>$this->data_criacao,
					'nstatus'=>$this->status
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
				return $this->id;
			}
		}

		/**
		* Função para obter as propostas de um Imóvel
		* @param integer ID do Imóvel
		* @return array lista de propostas
		* @access public
		*/

		public function getByImovel($nidcadimo){
			$this->db->where('nidcadimo', $nidcadimo);
			$this->db->where('nativo', 1);
			$this->db->order_by('dtdata', 'ASC');
			$propostas = $this->db->get('tbxpro')->result();
			$result = array();
			foreach ($propostas as $proposta){
				$this->db->where('nidtbxtpr', $proposta->nidtbxtpr);
				$tipo = $this->db->get('tbxtpr')->row();
				$this->db->where('nidcadgrl', $proposta->nidcadgrl);
				$cliente = $this->db->get('cadgrl')->row();
				$proposta->tipo = $tipo->cnome;
				$proposta->data = toUserDate($proposta->dtdata);
				$proposta->cliente = $cliente;
				$this->db->where('nidtbxsegusu', $proposta->nidtbxsegusu_criacao);
				$segusu_criacao = $this->db->get('tbxsegusu')->row();
				$proposta->vendedor = $segusu_criacao->cnome;
				$result[] = $proposta;
			}
			return $result;
		}

}