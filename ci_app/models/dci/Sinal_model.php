<?php
	class Sinal_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxsin";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxsin";

		public $imovel;
		public $comprador;
		public $texto;
		public $data;
		public $valor;
		public $status;
		public $usuario_criacao;
		public $data_criacao;
		public $usuario_alteracao;
		public $data_alteracao;
		public $usuario_exclusao;
		public $data_exclusao;
		
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

			if (!$this->comprador){
				$this->error = 'Comprador em branco';
				return false;
			}

			$this->db->where('nidcadgrl', $this->comprador);
			$cadgrl = $this->db->get('cadgrl')->row();
			if (!$cadgrl){
				$this->error = 'Cadastro não encontrado';
				return false;
			}

			if (!$this->data){
				$this->error = 'Data em branco';
				return false;
			}

			if (!$this->valor){
				$this->error = 'Valor em branco ou zero';
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
					'nidcadgrl'=>$this->comprador,
					'tdescricao'=>$this->texto,
					'dtdata'=>$this->data,
					'nvalor'=>$this->valor,
					'nidtbxssi'=>$this->status,
					'nidtbxsegusu_alteracao'=>$this->usuario_alteracao,
					'dtdataalteracao'=>$this->data_alteracao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'nidcadimo'=>$this->imovel,
					'nidcadgrl'=>$this->comprador,
					'tdescricao'=>$this->texto,
					'dtdata'=>$this->data,
					'nvalor'=>$this->valor,
					'nidtbxssi'=>$this->status,
					'nidtbxsegusu_criacao'=>$this->usuario_criacao,
					'dtdatacriacao'=>$this->data_criacao
				);
				$this->db->insert(self::$_table, $data);
				$this->id = $this->db->insert_id();
				return $this->id;
			}
		}

		/**
		* Função para obter os sinais de um Imóvel
		* @param integer ID do Imóvel
		* @return array lista de sinais
		* @access public
		*/

		public function getByImovel($nidcadimo){
			$this->db->where('nidcadimo', $nidcadimo);
			$this->db->where('nativo', 1);
			$this->db->order_by('dtdata', 'ASC');
			$sinais = $this->db->get('tbxsin')->result();
			$result = array();
			foreach ($sinais as $sinal){
				$this->db->where('nidtbxssi', $sinal->nidtbxssi);
				$status = $this->db->get('tbxssi')->row();
				$this->db->where('nidcadgrl', $sinal->nidcadgrl);
				$comprador = $this->db->get('cadgrl')->row();
				$sinal->status = $status->cdescricao;
				$sinal->data = toUserDate($sinal->dtdata);
				$sinal->valor = toUserCurrency($sinal->nvalor);
				$sinal->comprador = $comprador;
				$this->db->where('nidtbxsegusu', $sinal->nidtbxsegusu_criacao);
				$segusu_criacao = $this->db->get('tbxsegusu')->row();
				$sinal->vendedor = $segusu_criacao->cnome;
				$result[] = $sinal;
			}
			return $result;
		}

}