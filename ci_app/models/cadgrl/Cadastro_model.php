<?php
	
	/** Esta classe deveria ser abstrata, mas a inclusão de classes abstratas no Codeigniter não é permitida devido à instância automática. */

	class Cadastro_model extends MY_Model {

		/* Dados básicos */

		public $tipo_pessoa;
		public $id;
		public $comochegou;
		public $nome;
		public $cpfcnpj;
		public $rgie;
		public $obs;
		public $creci;
		public $senha_chave;

		/* Dados de endereço */

		public $endereco;
		public $numero;
		public $complemento;
		public $bairro;
		public $cidade;
		public $uf;

		/* Variável que armazena a etapa do cadastro (wizard) */
		public $etapa;
		
		protected $data_criacao;
		protected $data_atualizacao;

		/* Variáveis que armazenam os usuários que fizeram as operações */

		public $usuario_criacao;
		public $usuario_atualizacao;


		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "cadgrl";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidcadgrl";

		public function __construct()
		{
			parent::__construct();
			$this->tipos_cadastro = array();
		}

		/**
		* Função que valida a inserção dos dados básicos do cadastro geral no banco de dados
		* @access public
		* @return true caso o cadastro estiver com os dados obrigatórios preenchidos e as validações específicas retornarem true ou false em caso contrário
		* A função também armazena na variável $error os erros de validação 
		*/

		public function validarCadastroBasico()
		{

		}

		/**
		* Função para setar os tipos de cadastro de um cadastro geral
		* @param array com os id's dos tipos de cadastro
		* @param array com os id's dos tipos de serviço
		* @param int parâmetro com o ID do cadastro geral que é pai dos tipos de serviço
		* @access public
		* @return true
		*/

		public function setTipoCadastroGeral( $tcg = array() , $tps = array(), $tipocadastro_tiposervico = null )
		{
			$this->removeTipoCadastroGeral();
			/* Varre os itens enviados e os adiciona */
			
			foreach ( $tcg as $item ):

				/* Verifica se o ID do tipo de cadastro geral é o pai dos tipos de serviço */
				
				if ($item == $tipocadastro_tiposervico){

					/* Varre o array de tipos de serviço e insere todos eles, linkados ao respectivo valor do tipo do cadastro geral, na agrupadora de tipo de cadastro geral */

					foreach ($tps as $item_servico) {
						
						$data = array(
							"nidcadgrl" => $this->id,
							"nidtbxtcg" => $item,
							"nidtbxtps" => $item_servico
						); 

						$this->db->insert('tagtcg', $data);

					}

				} else {
					
					$data = array(
						"nidcadgrl" => $this->id,
						"nidtbxtcg" => $item
					);

					$this->db->insert('tagtcg', $data );

				}

			endforeach;
			
			return true;
		}

		/**
		* Função para remover todos os tipos de cadastro de um cadastro geral
		* @access protected
		* @return true
		*/

		protected function removeTipoCadastroGeral()
		{
			/* Indica que o ID do cadastro geral é o id do objeto */
			$this->db->where('nidcadgrl', $this->id);
			/* Faz a remoção */
			$this->db->delete('tagtcg');
			return true;
		}

		/**
		* Função para obter a data de criação de um cadastro
		* @return data de criação
		* @access public
		*/

		public function getDataCriacao()
		{
			return $this->data_criacao;
		}

		/**
		* Função para obter a data de atualização de um cadastro
		* @return data de atualização
		* @access public
		*/

		public function getDataAtualizacao()
		{
			return $this->data_atualizacao;
		}

		/**
		* Função para salvar o registro no banco de dados
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return Int ID do registro inserido ou atualizado
		* @access public
		*/

		public function save()
		{

			if (!$this->id){

				/* O registro não possui ID. Portanto, trata-se de um create */
				$data = array(
					"ctipopessoa" => $this->tipo_pessoa,
					"nidtbxchg" => $this->comochegou,
					"ccpfcnpj" => cleanToNumber($this->cpfcnpj),
					"cnomegrl" => $this->nome,
					"crgie" => $this->rgie,
					"cobs" => $this->obs,
					"dtdatacriacao" => date('Y-m-d H:i:s'),
					"ccreci" => $this->creci,
					"cobs" => $this->obs,
					"csenhachave" => md5($this->senha_chave),
					"nidtbxsegusu_criacao" => $this->usuario_criacao
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();

			} else {

				/* O registro possui ID. Portanto, trata-se de um update */
				$data = array(
					"ctipopessoa" => $this->tipo_pessoa,
					"nidtbxchg" => $this->comochegou,
					"ccpfcnpj" => cleanToNumber($this->cpfcnpj),
					"cnomegrl" => $this->nome,
					"crgie" => $this->rgie,
					"cobs" => $this->obs,
					"dtdataatualizacao" => date('Y-m-d H:i:s'),
					"ccreci" => $this->creci,
					"cobs" => $this->obs,
					"nidtbxsegusu_atualizacao" => $this->usuario_atualizacao
				);

				if ($this->senha_chave){
					$data["csenhachave"] = md5($this->senha_chave);
				}

				$this->db->where(self::$_idfield, $this->id);

				$this->db->update(self::$_table, $data);

			}

			return $this->id;
		}

		/**
		* Função para listar os registros
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return object
		* @access public
		*/

		public function lista( $offset=0, $limit=10, $keyword=NULL )
		{

			// Construção da consulta
			// campos
			$select = array(
				'nidcadgrl'
				,'cnomegrl'
				,'dtdatacriacao'
			);

			// condições
			$where = array(
				'nativo' => 1,
				'nidtbxsegusu_exclusao' => null,
				'dtdataexc' => null,
				'eatendimento' => 0
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table.' um' )
				->where( $where );

			// se houver busca acrescenta as condições no query builder
			if($keyword){
				$sql->like( array('cnomegrl' => $keyword) );
			}
			
			// finalizando a consulta
			$sql->order_by( 'dtdatacriacao', 'DESC' )
				->limit( $limit, $offset );

			// Retorno
			// Lista de registros
			$result['records'] = ($query = $sql->get()) 
				? $query->result() 
				: false;

			// Total de reguistros retornadas na query (com filtros)
			$result['recordsFiltered'] = $this->db->where($where)->count_all_results(self::$_table);

			// Total de reguistros retornadas na query (sem filtros)
			$result['recordsTotal'] = $this->db->where($where)->count_all_results(self::$_table);

			return $result;

		}

		/**
		* Função para buscar registros com base no nome, cpf ou cnpj
		* @access public
		* @param string nome ou cpf do cadastro geral
		* @return array de objetos
		*/


		public function getByNomeCPF($term)
		{
			$this->db->where('dtdataexc IS NULL AND nidtbxsegusu_exclusao IS NULL AND nativo = 1 AND (cnomegrl LIKE "%'.$term.'%" OR ccpfcnpj = "'.$term.'" OR ccpfcnpj = "'.str_replace(array("-", ".", "/"), "", $term).'")', null, false);

			$result = $this->db->get('cadgrl')->result();
			return $result;
		}

		public function listar_data( $fase='records', $offset=0, $limit=10, $params=NULL )
		{

			//var_dump($params); exit();

			// Construção da consulta
			// campos
			$select = array(
				'g.nidcadgrl'
				,'g.ctipopessoa'
				,'g.cnomegrl'
				,'g.ccpfcnpj'
				,'g.crgie'
				,'g.dtdatacriacao'
				,'t.cdescritel'
				,'e.cdescriemail'
				,'pj.nieisento'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table.' g' )
				->join( 'tagtel t' , 't.nidcadgrl = g.nidcadgrl', 'LEFT') // telefone
				->join( 'tagema e' , 'e.nidcadgrl = g.nidcadgrl', 'LEFT') // email
				->join( 'cadfis pf' , 'pf.nidcadgrl = g.nidcadgrl', 'LEFT') // dados de pessoa física
				->join( 'cadjur pj', 'pj.nidcadgrl = g.nidcadgrl', 'LEFT') // dados da pessoa jurídica
				->join( 'tbxest es' , 'es.nidtbxest = pf.nidtbxest', 'LEFT') // estado civil
				->join( 'tagedc edc' , 'edc.nidcadgrl = g.nidcadgrl', 'LEFT') // junção para endereço do cadastro geral
				->join( 'tbxend end' , 'end.nidtbxend = edc.nidtbxend', 'LEFT') // endereço do cadastro geral
				->join( 'cadlog log' , 'log.nidcadlog = end.nidcadlog', 'LEFT') // logradouro do cadastro geral
				->join( 'tbxbai bai' , 'bai.nidtbxbai = log.nidtbxbai', 'LEFT') // bairro
				->join( 'tbxloc loc' , 'loc.nidtbxloc = bai.nidtbxloc', 'LEFT'); // cidade (localidade)
			if(isset($params['tipo_cadastro'])) $sql->join( 'tagtcg c' , 'c.nidcadgrl = g.nidcadgrl', 'LEFT'); // tipo de cadastro

			// condições
			$sql->where('g.nativo', 1);
			$sql->where('g.nidtbxsegusu_exclusao IS NULL');
			$sql->where('g.dtdataexc IS NULL');

			if(isset($params['tipo_cadastro'])) $sql->where(array('c.nidtbxtcg'=>$params['tipo_cadastro'])); // tipo de cadastro
			if(isset($params['estadocivil'])) $sql->where(array('es.nidtbxest'=>$params['estadocivil'])); // estado civil
			if(isset($params['daten'])) $sql->where(array('pf.ddtnasc'=>$params['daten'])); // data de nascimento

			// datas de cadastro e atendimento
			if( isset($params['date']) && count($params['date'])>1 )
			{
				foreach($params['date'] as $key => $value){
					$sql->where(array($key=>$value));
				}
			}

			if(isset($params['like']))
			{
				$count = 0;
				foreach($params['like'] as $key => $value){
					if($count==0){
						$sql->like(array($key=>$value));
					}else{
						$sql->or_like(array($key=>$value));
					}
					$count++;
				}
			}

			$sql->group_by('g.nidcadgrl');

			switch ($fase) {
				case 'records':
					$query = $sql->order_by( 'g.dtdatacriacao', 'DESC' )
								->limit( $limit, $offset )
								->get();
					if(!$query)
						return false;

					$result_dirty = $query->result();

					$result = array();

					foreach ($result_dirty as $item){
						
						if ($item->ctipopessoa == "f"){
							$item->ccpfcnpj = toUserCpf($item->ccpfcnpj);
						} else {
							$item->ccpfcnpj = toUserCnpj($item->ccpfcnpj);
						}

						$result[] = $item;
					}

					return $result;

					break;

				case 'recordsFiltered':
					$query = $sql->order_by( 'g.dtdatacriacao', 'DESC' )
					->get();
					return $query->num_rows();
					break;

				case 'recordsTotal':
					$this->db->get();
					return $this->db->where('nativo', 1)->from(self::$_table)->count_all_results();
					break;
			}

		}

		public function listar_dadosbancarios( $fase='records', $offset=0, $limit=10, $params=NULL )
		{

			// Construção da consulta
			// campos
			$select = array(
				't.nidtagbco'
				,'t.ctitular'
				,'t.cagencia'
				,'t.cconta'
				,'t.nprincipal'
				,'t.ddtclientedesde'
				,'t.ccodtipoconta'
				,'b.cnomebco'
				,'b.cicone'
				,'i.cnometic'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( 'tagbco t' )
				->join( 'tbxbco b' , 't.nidtbxbco = b.nidtbxbco', 'INNER') // banco
				->join( 'tbxtic i' , 't.nidtbxtic = i.nidtbxtic', 'INNER'); // tipo de conta

			// condições
			$sql->where('t.nidcadgrl', $params['nidcadgrl']);

			$sql->where('t.nativo', 1);

			$sql->order_by('b.cnomebco', 'ASC');

			switch ($fase) {
				case 'records':
					$query = $sql->limit( $limit, $offset )
								->get();
					if(!$query)
						return false;

					return $query->result();

					break;

				case 'recordsFiltered':
					$query = $sql->get();
					return $query->num_rows();
					break;

				case 'recordsTotal':
					$this->db->get();
					return $this->db->where(['nidcadgrl'=>$params['nidcadgrl'], 'nativo'=>1])->from('tagbco')->count_all_results();
					break;
			}

		}

		public function listar($offset=0, $limit=10, $params=NULL)
		{

			$result['records'] = $this->listar_data( 'records', $offset, $limit, $params );
			$result['recordsTotal'] = $this->listar_data( 'recordsTotal', $offset, $limit, $params );
			$result['recordsFiltered'] = $this->listar_data( 'recordsFiltered', $offset, $limit, $params );
			return $result;
			
		}

		/**
		* Função para pegar os tipos de cadastro para um cadastro geral
		* @param integer ID do cadastro geral
		* @return array lista de tipos de cadastro relacionados a este cadastro
		* @access public
		*/

		public function getTiposCadastro($id){
			$this->db->where('nidcadgrl', $id);
			$result = array();
			$tipos = $this->db->get('tagtcg')->result();
			foreach ($tipos as $tipo){
				$result[] = $tipo->nidtbxtcg;
			}
			return $result;
		}

		/**
		* Função para pegar os tipos de serviço para um cadastro geral
		* @param integer ID do cadastro geral
		* @return array lista de tipos de serviço relacionados a este cadastro
		* @access public
		*/

		public function getTiposServico($id){
			$this->db->where('nidcadgrl', $id);
			$this->db->where('nidtbxtps IS NOT NULL', null, false);
			$result = array();
			$tipos = $this->db->get('tagtcg')->result();
			foreach ($tipos as $tipo){
				$result[] = $tipo->nidtbxtps;
			}
			return $result;
		}

		/**
		* Função para pegar a lista de prestadores de serviço
		* @return array lista de prestadores de serviço
		* @access public
		*/

		public function getPrestadores(){
			$this->db->where('EXISTS(SELECT 1 FROM tagtcg tcg WHERE tcg.nidcadgrl = cadgrl.nidcadgrl AND tcg.nidtbxtcg = "'.Parametro_model::get('id_tipo_cadastro_prestador_servicos').'")', null, false);
			$this->db->order_by('cnomegrl', 'ASC');
			$cadgrl = $this->db->get('cadgrl')->result();
			return $cadgrl;
		}

		/**
		* Função para pegar o nome de um cadastro geral
		* @return string nome
		* @access public
		*/

		public static function getNome($id){
			$db = &get_instance()->db;
			$db->where('nidcadgrl', $id);
			return $db->get('cadgrl')->row()->cnomegrl;
		}

	}
?>