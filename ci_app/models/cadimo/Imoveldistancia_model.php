<?php
	
	class Imoveldistancia_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $tipodistancia;
		public $tipomedida;
		public $tiporeferencia;
		public $distancia;
		public $imovel;
		public $data_insercao;
		public $data_atualizacao;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagdii";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagdii";

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

			if (!$this->tipodistancia){
				$this->error = 'Tipo de distância em branco';
			}

			if (!$this->tipomedida){
				$this->error = 'Tipo de medida em branco';
			}

			if (!$this->distancia){
				$this->error = 'Distância em branco';
				return false;					
			}

			if (!$this->imovel){
				$this->error = 'Imóvel em branco';
				return false;					
			}

			/* Verifica se o tipo de distância informado no select realmente existe */
			$tpd = $this->db->where('nidtbxtpd',$this->tipodistancia)->get("tbxtpd")->row();
			if (!$tpd){
				$this->error = 'O tipo de distância selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se o tipo de medida de distância informado no select realmente existe */
			$tmd = $this->db->where('nidtbxtmd',$this->tipomedida)->get("tbxtmd")->row();
			if (!$tmd){
				$this->error = 'O tipo de medida da distância selecionado na lista não está cadastrado';
				return false;
			}

			if ($this->tiporeferencia){

				/* Verifica se o tipo de referência de distância informado no select realmente existe */
				$trd = $this->db->where('nidtbxtrd',$this->tiporeferencia)->get("tbxtrd")->row();
				if (!$trd){
					$this->error = 'O tipo de referência de distância selecionado na lista não está cadastrado';
					return false;
				}

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
					"nidtbxtpd" => $this->tipodistancia,
					"nidtbxtmd" => $this->tipomedida,
					"nidtbxtrd" => $this->tiporeferencia,
					"nidcadimo" => $this->imovel,
					"ndistancia" => $this->distancia,
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
			$this->db->delete('tagdii');

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
			$distancias = $this->db->get('tagdii')->result();

			$result = array();

			foreach ($distancias as $distancia):

				$result_part = array();

				$result_part['nidtagdii'] = $distancia->nidtagdii;

				$result_part['ddatacriacao'] = $distancia->ddatacriacao;

				$result_part['ndistancia'] = $distancia->ndistancia;

				/* Pega o tipo de distância com base na distância */

				$this->db->where('nidtbxtpd', $distancia->nidtbxtpd);

				$tpd = $this->db->get('tbxtpd')->row();

				$result_part['tpd'] = $tpd->cnometpd;

				$result_part['nidtbxtpd'] = $tpd->nidtbxtpd;

				/* Pega o tipo de medida da distância com base na distância */

				$this->db->where('nidtbxtmd', $distancia->nidtbxtmd);

				$tmd = $this->db->get('tbxtmd')->row();

				$result_part['tmd'] = $tmd->cnometmd;

				$result_part['nidtbxtmd'] = $tmd->nidtbxtmd;

				/* Pega o tipo de referência da distância com base na distância */

				$this->db->where('nidtbxtrd', $distancia->nidtbxtrd);

				$trd = $this->db->get('tbxtrd')->row();

				$result_part['trd'] = $trd->cnometrd;

				$result_part['nidtbxtrd'] = $trd->nidtbxtrd;

				/* Adiciona o array parcial ao array total */

				$result[] = $result_part;

			endforeach;

			return $result;

		}

	}
?>