<?php
	
	class Imovelobservacao_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $tipo;
		public $observacao;
		public $imovel;
		public $data_insercao;
		public $data_atualizacao;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagiob";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagiob";

		public function __construct()
		{
			parent::__construct();
		}

		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao(){

			if (!$this->observacao){
				$this->error = 'Observação em branco';
				return false;					
			}

			if (!$this->imovel){
				$this->error = 'Imóvel em branco';
				return false;					
			}

			/* Verifica se o tipo de observação informado no select realmente existe */
			$obs = $this->db->where('nidtbxobs',$this->tipo)->get("tbxobs")->row();
			if (!$obs){
				$this->error = 'O tipo de observação selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se o Imóvel informado no select realmente existe */
			$imo = $this->db->where('nidcadimo',$this->imovel)->get("cadimo")->row();
			if (!$imo){
				$this->error = 'O Imóvel selecionado na lista não está cadastrado';
				return false;
			}

			return true;
		}

		/**
		* Função para salvar o registro no banco de dados
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return Int ID do registro inserido ou atualizado
		* @access public
		*/

		public function save()
		{
			if ( ! $this->id ) {
				/* O registro não possui ID. Portanto, trata-se de um create */
				$data = array(
					"cdescriiob" => $this->observacao,
					"nidcadimo" => $this->imovel,
					"nidtbxobs" => $this->tipo,
					"ddatacriacao" => date('Y-m-d H:i:s')
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();
				return $this->id;
			} else {
				// TODO atualização de número ou complemento
			}

		}

		/**
		* Função para excluir as observações de um determinado Imóvel
		* @param integer ID do Imóvel
		* @access public
		*/

		public function deleteByImovel( $id )
		{
			
			if ( !$id )
				return false;

			/* Verifica se o Imóvel existe */

			$this->db->where('nidcadimo', $id);
			$cadimo = $this->db->get('cadimo')->row();
			
			if (!$cadimo)
				return false;

			$this->db->where('nidcadimo', $id);
			$this->db->delete('tagiob');

			return true;

		}


		/**
		* Função para pegar as observações de um determinado Imóvel
		* @param integer ID do Imóvel
		* @param return array lista de observações
		* @access public
		*/

		public function getByImovel( $id )
		{
			if ( !$id )
				return false;

			/* Verifica se o Imóvel existe */

			$this->db->where('nidcadimo', $id);
			$cadimo = $this->db->get('cadimo')->row();
			
			if (!$cadimo)
				return false;

			$this->db->where('nidcadimo', $id);
			$observacoes = $this->db->get('tagiob')->result();

			$result = array();

			foreach ($observacoes as $observacao):

				$result_part = array();

				$result_part['nidtagimo'] = $observacao->nidtagimo;

				$result_part['ddatacriacao'] = $observacao->ddatacriacao;

				$result_part['cdescriiob'] = $observacao->cdescriiob;

				/* Pega o tipo de observação com base na observação */

				$this->db->where('nidtbxobs', $observacao->nidtbxobs);

				$obs = $this->db->get('tbxobs')->row();

				$result_part['obs'] = $obs->cnomeobs;

				$result_part['nidtbxobs'] = $obs->nidtbxobs;

				/* Adiciona o array parcial ao array total */

				$result[] = $result_part;

			endforeach;

			return $result;

		}

	}
?>