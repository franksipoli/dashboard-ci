<?php
	
	class Angariadorimovel_model extends MY_Model {

		/* Dados básicos */

		public $id;
		public $usuario;
		public $percentual;
		public $imovel;

		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "tagang";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidtagang";

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

			if (!$this->usuario){
				$this->error = 'Cadastro em branco';
				return false;					
			}

			if (!$this->imovel){
				$this->error = 'Imóvel em branco';
				return false;					
			}

			if (!$this->percentual){
				$this->error = 'Percentual em branco';
				return false;					
			}

			if ($this->percentual < 0 || $this->percentual>100){
				$this->error = 'Percentual deve estar entre 0 e 100 ('.$this->percentual.' informado)';
				return false;					
			}

			/* Verifica se o Imóvel informado no select realmente existe */
			$imo = $this->db->where('nidcadimo',$this->imovel)->get("cadimo")->row();
			if (!$imo){
				$this->error = 'O Imóvel selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se o usuário informado no select realmente existe */
			$usu = $this->db->where('nidtbxsegusu',$this->usuario)->get("tbxsegusu")->row();
			if (!$usu){
				$this->error = 'O usuário selecionado na lista não está cadastrado';
				return false;
			}

			/* Verifica se não existe um registro com este Imóvel e este cadastro */
			$ang = $this->db->where('nidtbxsegusu',$this->usuario)->where('nidcadimo',$this->imovel)->get('tagang')->row();
			if ($ang){
				$this->error = 'Este Parceiro já está registrado para este Imóvel';
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
					"nidtbxsegusu" => $this->usuario,
					"nidcadimo" => $this->imovel,
					"npercentual" => $this->percentual
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
		* Função para trazer os angariadores de um Imóvel
		* @param Integer ID do Imóvel
		* @return array de proprietários
		* @access public
		*/

		public function getByImovel($id)
		{

			$this->db->where('nidcadimo', $id);
			$ang = $this->db->get(self::$_table)->result();

			$result = array();

			foreach ($ang as $item){

				$this->db->where('nidtbxsegusu', $item->nidtbxsegusu);
				$segusu = $this->db->get('tbxsegusu')->row();

				$r = new stdClass;

				$r->segusu = $segusu;
				$r->ang = $item;

				$result[] = $r;

			}

			return $result;

		}

	}
?>