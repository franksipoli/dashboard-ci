<?php
	
	class Enderecoimovel_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $endereco;
		public $imovel;
		public $data_insercao;
		public $data_atualizacao;

		public static $staticdb;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagedi";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagedi";

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

			if (!$this->endereco){
				$this->error = 'Endereço em branco';
				return false;					
			}

			if (!$this->imovel){
				$this->error = 'Imóvel em branco';
				return false;					
			}

			/* Verifica se o endereço informado no select realmente existe */
			$end = $this->db->where('nidtbxend',$this->endereco)->get("tbxend")->row();
			if (!$end){
				$this->error = 'O endereço selecionado na lista não está cadastrado';
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
					"nidtbxend" => $this->endereco,
					"nidcadimo" => $this->imovel,
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
		* Função para excluir os endereços de um determinado Imóvel
		* @param integer ID do Imóvel
		* @param return array lista de endereços
		* @access public
		*/

		public function deleteByImovel( $id )
		{
			$this->db->where('nidcadimo', $id);
			$this->db->delete('tagedi');
			return true;
		}

		/**
		* Função para pegar os endereços de um determinado Imóvel
		* @param integer ID do Imóvel
		* @param return array lista de endereços
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
			$enderecos = $this->db->get('tagedi')->result();

			$result = array();

			foreach ($enderecos as $endereco):

				$result_part = array();

				$result_part['nidtagedi'] = $endereco->nidtagedi;

				$result_part['ddatacriacao'] = $endereco->ddatacriacao;

				$result_part['ddataatualizacao'] = $endereco->ddataatualizacao;

				/* Pega o objeto endereço com base no objeto endereço para Imóvel (tag) */

				$this->db->where('nidtbxend', $endereco->nidtbxend);

				$end = $this->db->get('tbxend')->row();

				$result_part['cnumero'] = $end->cnumero;

				$result_part['ccomplemento'] = $end->ccomplemento;

				/* Pega o logradouro com base no endereço */

				$this->db->where('nidcadlog', $end->nidcadlog);

				$log = $this->db->get('cadlog')->row();

				$result_part['nidtbxtpl'] = $log->nidtbxtpl;

				$result_part['cdescrilog'] = $log->cdescrilog;

				$result_part['ccep_log'] = $log->ccep;

				/* Pega o tipo de logradouro com base no logradouro */

				$this->db->where('nidtbxtpl', $log->nidtbxtpl);

				$tpl = $this->db->get('tbxtpl')->row();

				$result_part['cnometpl'] = $tpl->cnometpl;

				/* Pega o bairro com base no logradouro */

				$this->db->where('nidtbxbai', $log->nidtbxbai);

				$bai = $this->db->get('tbxbai')->row();

				$result_part['cdescribai'] = $bai->cdescribai;

				/* Pega a localidade com base no bairro */

				$this->db->where('nidtbxloc', $bai->nidtbxloc);

				$loc = $this->db->get('tbxloc')->row();

				$result_part['cdescriloc'] = $loc->cdescriloc;

				$result_part['nidtbxloc'] = $loc->nidtbxloc;

				$result_part['ccep_loc'] = $loc->ccep;

				/* Pega a UF com base na localidade */

				$this->db->where('nidtbxuf', $loc->nidtbxuf);

				$uf = $this->db->get('tbxuf')->row();

				$result_part['cdescriuf'] = $uf->cdescriuf;

				$result_part['nidtbxuf'] = $uf->nidtbxuf;

				/* Pega o país com base na UF */

				$this->db->where('nidtbxpas', $uf->nidtbxpas);

				$pas = $this->db->get('tbxpas')->row();

				$result_part['cdescripas'] = $pas->cdescripas;

				/* Adiciona o array parcial ao array total */

				$result[] = $result_part;

			endforeach;

			return $result;

		}

		/**
		* Função para pegar o endereço em formato de string determinado Imóvel
		* @param integer ID do Imóvel
		* @param return string endereço completo
		* @access public
		*/

		public static function getString( $id )
		{
			if ( !$id )
				return false;

			self::$staticdb = &get_instance()->db;

			/* Verifica se o Imóvel existe */

			self::$staticdb->where('nidcadimo', $id);
			$cadimo = self::$db->get('cadimo')->row();
			
			if (!$cadimo)
				return false;

			self::$staticdb->where('nidcadimo', $id);
			$endereco = self::$staticdb->get('tagedi')->row();

			$result_part = array();

			$result_part['nidtagedi'] = $endereco->nidtagedi;

			$result_part['ddatacriacao'] = $endereco->ddatacriacao;

			$result_part['ddataatualizacao'] = $endereco->ddataatualizacao;

			/* Pega o objeto endereço com base no objeto endereço para Imóvel (tag) */

			self::$staticdb->where('nidtbxend', $endereco->nidtbxend);

			$end = self::$staticdb->get('tbxend')->row();

			$result_part['cnumero'] = $end->cnumero;

			$result_part['ccomplemento'] = $end->ccomplemento;

			/* Pega o logradouro com base no endereço */

			self::$staticdb->where('nidcadlog', $end->nidcadlog);

			$log = self::$staticdb->get('cadlog')->row();

			$result_part['cdescrilog'] = $log->cdescrilog;

			$result_part['ccep_log'] = $log->ccep;

			/* Pega o tipo de logradouro com base no logradouro */

			self::$staticdb->where('nidtbxtpl', $log->nidtbxtpl);

			$tpl = self::$staticdb->get('tbxtpl')->row();

			$result_part['cnometpl'] = $tpl->cnometpl;

			/* Pega o bairro com base no logradouro */

			self::$staticdb->where('nidtbxbai', $log->nidtbxbai);

			$bai = self::$staticdb->get('tbxbai')->row();

			$result_part['cdescribai'] = $bai->cdescribai;

			/* Pega a localidade com base no bairro */

			self::$staticdb->where('nidtbxloc', $bai->nidtbxloc);

			$loc = self::$staticdb->get('tbxloc')->row();

			$result_part['cdescriloc'] = $loc->cdescriloc;

			$result_part['ccep_loc'] = $loc->ccep;

			/* Pega a UF com base na localidade */

			self::$staticdb->where('nidtbxuf', $loc->nidtbxuf);

			$uf = self::$staticdb->get('tbxuf')->row();

			$result_part['cdescriuf'] = $uf->cdescriuf;

			$result_part['nidtbxuf'] = $uf->nidtbxuf;

			/* Pega o país com base na UF */

			self::$staticdb->where('nidtbxpas', $uf->nidtbxpas);

			$pas = self::$staticdb->get('tbxpas')->row();

			$result_part['cdescripas'] = $pas->cdescripas;

			return $result_part['cnometpl']." ".$result_part['cdescrilog'].", ".$result_part['cnumero'].($result_part['ccomplemento'] ? " - ".$result_part['ccomplemento'] : "");

		}

	}
?>