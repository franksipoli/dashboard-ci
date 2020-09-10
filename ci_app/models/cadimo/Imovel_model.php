<?php
	
	class Imovel_model extends MY_Model {

		/* Variável que armazena a etapa do cadastro (wizard) */
		public $etapa;

		public $edit;
		
		protected $data_criacao;
		protected $data_atualizacao;

		public $status;
		public $entidade;
		public $finalidade;
		public $tipo_imovel;
		public $tipos_secundarios;
		public $titulo;
		public $referencia;
		public $construtora;
		public $ano_construcao;
		public $status_construcao;
		public $condominio;
		public $unidades;
		public $descricao;

		public $data_inicio_contrato;
		public $data_fim_contrato;

		public $area_construida;
		public $area_averbada;
		public $area_terreno;
		public $area_util;
		public $area_privativa;
		public $area_comercial;

		public $quartos;
		public $acomodacoes;
		public $suites;

		public $taxa_administrativa;
		public $valores;
		public $comissoes;

		public $aceita_permuta;
		public $tipos_permuta;
		public $descricao_permuta;

		public $matricula_luz;
		public $luz_ligada;
		public $matricula_agua;
		public $agua_ligada;

		public $matricula;
		public $lote;
		public $quadra;
		public $planta;

		public $latitude;
		public $longitude;

		public $publicar_imovel;
		public $publicar_endereco;

		/* Variáveis que armazenam os usuários que fizeram as operações */

		public $usuario_criacao;
		public $usuario_atualizacao;


		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "cadimo";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidcadimo";

		public function __construct()
		{
			parent::__construct();
			$this->tipos_secundarios = array();
		}

		/**
		* Função que replica um Imóvel até o número de unidades informadas pelo administrador
		* @param nenhum. Os dados inseridos são atributos do objeto.
		* @return boolean true caso a operação tenha sido realizada
		* @access private
		*/

		private function replicar(){
			$id = $this->id;
			$unidades = $this->unidades;
			$imovel = $this->getById($id);
			for ($i=2; $i<=$unidades; $i++){
				/* Salvando os dados gerais */
				$data = array(
					"nidtbxent" => $imovel->nidtbxent,
					"nidtbxsti" => $imovel->nidtbxsti,
					"creferencia" => $imovel->creferencia,
					"nidtbxfin" => $imovel->nidtbxfin,
					"nidtbxtpi" => $imovel->nidtbxtpi,
					"ctitulo" => $imovel->ctitulo,
					"tdescricao" => $imovel->tdescricao,
					"cconstrutora" => $imovel->cconstrutora,
					"ccondominio" => $imovel->ccondominio,
					"nunidades" => $imovel->nunidades,
					"dtdatainicial_contrato" => $imovel->dtdatainicial_contrato,
					"dtdatafinal_contrato" => $imovel->dtdatafinal_contrato,
					"nunidade" => $i,
					"nanocons" => $imovel->nanocons,
					"nidtbxtsc" => $imovel->nidtbxtsc,
					"nidcadimo_principal" => $imovel->nidcadimo
				);
				$data["dtdatacriacao"] = date('Y-m-d H:i:s');
				$data["nidtbxsegusu_criacao"] = $this->usuario_criacao;
				$this->db->insert('cadimo', $data);
				/* Salvando as dependências */
				$id_sub = $this->db->insert_id();
			}
		}

		/**
		* Função para salvar o registro no banco de dados
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return Int ID do registro inserido ou atualizado
		* @access public
		*/

		public function save()
		{

			if ($this->etapa == "geral"){

				$data = array(
					"nidtbxsti" => $this->status,
					"nidtbxent" => $this->entidade,
					"creferencia" => $this->referencia,
					"nidtbxfin" => $this->finalidade,
					"nidtbxtpi" => $this->tipo_imovel,
					"ctitulo" => $this->titulo,
					"dtdatainicial_contrato" => toDbDate($this->data_inicio_contrato),
					"dtdatafinal_contrato" => toDbDate($this->data_fim_contrato),
					"tdescricao" => $this->descricao,
					"cconstrutora" => $this->construtora,
					"ccondominio" => $this->condominio,
					"nanocons" => $this->ano_construcao,
					"nidtbxtsc" => $this->status_construcao
				);

				if ($this->edit){
					$data["dtdataatualizacao"] = date('Y-m-d H:i:s');
					$data["nidtbxsegusu_atualizacao"] = $this->usuario_criacao;
					$this->db->where('nidcadimo', $this->id);
					$this->db->update(self::$_table, $data);
				} else {
					$data["nunidades"] = $this->unidades;
					$data["nunidade"] = 1;
					$data["dtdatacriacao"] = date('Y-m-d H:i:s');
					$data["nidtbxsegusu_criacao"] = $this->usuario_criacao;
					$this->db->insert(self::$_table, $data);
					/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
					$this->id = $this->db->insert_id();
					if ($this->unidades > 1){
						$this->replicar();
					}
				}

			} else {

				/* O registro possui ID. Portanto, trata-se de um update */

				if ($this->etapa == "area"){

					$imoveis_ids = array($this->id);

					/* Caso seja uma inserção, aplica a atualização para todos os imóveis relacionados também. A edição é realizada um a um */

					if (!$this->edit){
						/* Preencher com todos os imóveis que serão atualizados */
						$imoveis_ids = array_merge($imoveis_ids, $this->getIdsImoveisRelacionados());
					}

					foreach ($imoveis_ids as $imovel_id){

						$data = array(
							"nareacons" => $this->area_construida,
							"nareaaverbada" => $this->area_averbada,
							"nareaterreno" => $this->area_terreno,
							"nareautil" => $this->area_util,
							"nareapriv" => $this->area_privativa,
							"nareacom" => $this->area_comercial,
							"nquartos" => $this->quartos,
							"nacomodacoes" => $this->acomodacoes,
							"nsuites" => $this->suites,
							"ntaxaadm" => $this->taxa_administrativa
						);

						$this->db->where(self::$_idfield, $imovel_id);

						$this->db->update(self::$_table, $data);

						/* Atualizar valores */

						$this->db->where('nidcadimo', $imovel_id);

						$this->db->delete('tbxiva');

						foreach ($this->valores as $nidtagfva=>$valor){

							/* Verifica se a finalidade é a selecionada */

							$imovel = $this->db->where('nidcadimo', $imovel_id)->get('cadimo')->row();

							$fva = $this->db->where('nidtagfva', $nidtagfva)->get('tagfva')->row();

							/* Verifica se a finalidade relacionada ao tipo de valor é a mesma do Imóvel */

							if ($imovel->nidtbxfin == $fva->nidtbxfin){

								$data = array(
									"nidcadimo"=>$imovel_id,
									"nidtagfva"=>$nidtagfva,
									"nvalor"=>str_replace(",", ".", str_replace(".", "", $valor))
								);
								$this->db->insert('tbxiva', $data);

							}

						}

						/* Atualizar comissões */

						$this->db->where('nidcadimo', $imovel_id);

						$this->db->delete('tagicm');

						foreach ($this->comissoes as $nidtbxtcm=>$valor){

							$data = array(
								"nidcadimo"=>$imovel_id,
								"nidtbxtcm"=>$nidtbxtcm,
								"nvalor"=>$valor
							);
							$this->db->insert('tagicm', $data);

						}

					}

				} else {

					$imoveis_ids = array($this->id);

					/* Caso seja uma inserção, aplica a atualização para todos os imóveis relacionados também. A edição é realizada um a um */

					if (!$this->edit){
						/* Preencher com todos os imóveis que serão atualizados */
						$imoveis_ids = array_merge($imoveis_ids, $this->getIdsImoveisRelacionados());
					}

					/* O registro possui ID */

					if ($this->etapa == "permuta"){

						$this->setTipoPermuta($imoveis_ids);

							$data = array(
								"cmatluz" => $this->matricula_luz,
								"npermuta" => $this->aceita_permuta,
								"nluzligada" => $this->luz_ligada,
								"cmatagua" => $this->matricula_agua,
								"nagualigada" => $this->agua_ligada,
								"cmatricula" => $this->matricula,
								"clote" => $this->lote,
								"cquadra" => $this->quadra,
								"cplanta" => $this->planta
							);

						foreach ($imoveis_ids as $imo){

							$this->db->where(self::$_idfield, $imo);
							$this->db->update(self::$_table,$data);

						}

					} else {

						/* O registro possui ID */

						if ($this->etapa == "endereco"){

							$data = array(
								"clatitude" => $this->latitude,
								"clongitude" => $this->longitude,
								"npublicarsite" => $this->publicar_imovel,
								"npublicarendereco" => $this->publicar_endereco
							);

							foreach ($imoveis_ids as $imo){

								$this->db->where(self::$_idfield, $imo);
								$this->db->update(self::$_table,$data);

							}

						}

					}

				}

			}

			return $this->id;
		}

		/**
		* Função para pegar a lista de IDS dos imóveis relacionados (venda)
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return array lista de IDS
		* @access public
		*/

		public function getIdsImoveisRelacionados(){
			$this->db->where('nidcadimo_principal', $this->id);
			$imoveis_relacionados = $this->db->get('cadimo')->result();
			$imoveis_ids = array();
			foreach ($imoveis_relacionados as $imo){
				$imoveis_ids[$imo->nidcadimo] = $imo->nidcadimo;
			}
			return $imoveis_ids;
		}

		/**
		* Função para pegar a lista de imóveis relacionados
		* @param integer ID do Imóvel
		* @return array lista de imóveis
		* @access public
		*/

		public function getAllRelacionados($id){
			$imovel = $this->getById($id);
			$this->db->where('nidcadimo_principal', $imovel->nidcadimo);
			if ($imovel->nidcadimo_principal){
				$this->db->or_where('nidcadimo_principal', $imovel->nidcadimo_principal);
			}
			$this->db->order_by('nunidade', 'ASC');
			$imoveis_relacionados = $this->db->get('cadimo')->result();
			return $imoveis_relacionados;
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

		public function listar_data( $fase='records', $offset=0, $limit=10, $params=NULL )
		{

			//var_dump($params); exit();

			// Construção da consulta
			// campos
			$select = array(
				'i.nidcadimo'
				,'i.nidtbxsti'
				,'i.creferencia'
				,'i.nunidade'
				,'i.ctitulo'
				,'i.dtdatacriacao'
				,'t.cnometpi'
				,'f.cnomefin'
				,'f.clabel as codigo_finalidade'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table.' i' )
				->join( 'tbxtpi t' , 't.nidtbxtpi = i.nidtbxtpi', 'LEFT') // tipo de Imóvel
				->join( 'tbxfin f' , 'f.nidtbxfin = i.nidtbxfin', 'LEFT'); // email

			if ($params['proprietario_id']){
				$sql->join('tagipr ipr', 'ipr.nidcadimo = i.nidcadimo', 'INNER');
				$sql->where('ipr.nidcadgrl', $params['proprietario_id']);
			}

			// condições
			$sql->where('i.nativo', 1);
			$sql->where('i.nidtbxsegusu_exclusao IS NULL');
			$sql->where('i.dtdataexc IS NULL');

			if(isset($params['tipo_imovel'])) $sql->where(array('i.nidtbxtpi'=>$params['tipo_imovel'])); // tipo de Imóvel

			if(isset($params['status'])) $sql->where(array('i.nidtbxsti'=>$params['status'])); // status

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

			switch ($fase) {
				case 'records':
					$query = $sql->order_by( 'i.dtdatacriacao', 'DESC' )
								->limit( $limit, $offset )
								->get();
					if($query) return $query->result();
					break;

				case 'recordsFiltered':
					return $sql->count_all_results();
					break;

				case 'recordsTotal':
					$this->db->get();
					return $this->db->where('nativo', 1)->count_all_results(self::$_table);
					break;
			}

		}

		/**
		* Função para setar os tipos de Imóvel secundários de um cadastro de Imóvel
		* @param array com os id's dos tipos de Imóvel secundários
		* @access public
		* @return true
		*/

		public function setTipoImovelSecundario( $ti2 = array() )
		{

			$imoveis_ids = array($this->id);

			/* Caso seja uma inserção, aplica a atualização para todos os imóveis relacionados também. A edição é realizada um a um */

			if (!$this->edit){
				/* Preencher com todos os imóveis que serão atualizados */
				$imoveis_ids = array_merge($imoveis_ids, $this->getIdsImoveisRelacionados());
			}

			$this->removeTipoImovelSecundario();
			
			foreach ($imoveis_ids as $imo){

				/* Varre os itens enviados e os adiciona */
				
				foreach ( $ti2 as $item ):

					$data = array(
						"nidcadimo" => $imo,
						"nidtagti2" => $item
					);

					$this->db->insert('tagt2i', $data );

				endforeach;

			}
			
			return true;
		}

		/**
		* Função para trazer a comissão de um Imóvel em relação a um tipo de comissão
		* @param int Id do Imóvel
		* @param int Id do tipo de comissão
		* @access public
		* @return decimal valor da comissão
		*/

		public static function getComissao($nidcadimo, $nidtbxtcm){
			self::$db->where('nidcadimo', $nidcadimo);
			self::$db->where('nidtbxtcm', $nidtbxtcm);
			$comissao = self::$db->get('tagicm')->row()->nvalor;
			return $comissao;
		}

		/**
		* Função para trazer as comissões de um Imóvel
		* @param int Id do Imóvel
		* @access public
		* @return array lista de comissões
		*/

		public function getComissoes($nidcadimo){
			$this->db->where('nidcadimo', $nidcadimo);
			$comissoes = $this->db->get('tagicm')->result();
			$result = array();
			foreach ($comissoes as $comissao){
				$result[$comissao->nidtbxtcm] = $comissao->nvalor;
 			}
			return $result;
		}

		/**
		* Função para trazer as permutas de um Imóvel
		* @param int Id do Imóvel
		* @access public
		* @return array lista de permutas
		*/

		public function getPermutas($nidcadimo){
			$this->db->where('nidcadimo', $nidcadimo);
			$permutas = $this->db->get('tagipe')->result();
			$result = array();
			foreach ($permutas as $permuta){
				$result[$permuta->nidtbxtpp] = $permuta->cdescriipe;
 			}
			return $result;
		}

		/**
		* Função para trazer os tipos de Imóvel secundários de um cadastro de Imóvel
		* @param none
		* @access public
		* @return array com a lista de objetos
		*/

		public function getTiposSecundarios()
		{

			$this->db->where('nidcadimo', $this->id);
			$t2i = $this->db->get('tagt2i')->result();

			$result = array();

			foreach ($t2i as $item){

				$this->db->where('nidtagti2', $item->nidtagti2);
				$ti2 = $this->db->get('tagti2')->row();

				$this->db->where('nidtbxtp2', $ti2->nidtbxtp2);
				$tp2 = $this->db->get('tbxtp2')->row();

				$result[] = $tp2;

			}

			return $result;
		}

		/**
		* Função para remover todos os tipos de Imóvel secundários de um cadastro de Imóvel
		* @access protected
		* @return true
		*/

		protected function removeTipoImovelSecundario()
		{
			$imoveis_ids = array($this->id);

			/* Caso seja uma inserção, aplica a atualização para todos os imóveis relacionados também. A edição é realizada um a um */

			if (!$this->edit){
				/* Preencher com todos os imóveis que serão atualizados */
				$imoveis_ids = array_merge($imoveis_ids, $this->getIdsImoveisRelacionados());
			}

			foreach ($imoveis_ids as $imo){

				/* Indica que o ID do Imóvel é o id do objeto */
				$this->db->where('nidcadimo', $imo);
				/* Faz a remoção */
				$this->db->delete('tagt2i');

			}

			return true;
		}

		/**
		* Função para obter as características de um cadastro de Imóvel
		* @param integer id do Imóvel
		* @access public
		* @return true
		*/

		public function getCaracteristicas( $cadimo )
		{

			$this->db->where('nidcadimo', $cadimo);
			$result = $this->db->get('tagcim')->result();
			$car = array();
			foreach ($result as $item){
				$car[] = $item->nidtbxcar;
			}
			return $car;

		}

		/**
		* Função para setar as características de um cadastro de Imóvel
		* @param array com os id's das características
		* @access public
		* @return true
		*/

		public function setCaracteristicas( $car = array() )
		{

			$imoveis_ids = array($this->id);

			/* Caso seja uma inserção, aplica a atualização para todos os imóveis relacionados também. A edição é realizada um a um */

			if (!$this->edit){
				/* Preencher com todos os imóveis que serão atualizados */
				$imoveis_ids = array_merge($imoveis_ids, $this->getIdsImoveisRelacionados());
			}

			$this->removeCaracteristicas();
			
			foreach ($imoveis_ids as $imo){

				/* Varre os itens enviados e os adiciona */
				
				foreach ( $car as $item ):

					$data = array(
						"nidcadimo" => $imo,
						"nidtbxcar" => $item
					);

					$this->db->insert('tagcim', $data );

				endforeach;

			}
			
			return true;
		}

		/**
		* Função para setar os tipos de permuta de um cadastro de Imóvel
		* @param array lista de ids dos imóveis
		* @access private
		* @return true
		*/

		private function setTipoPermuta($imoveis_ids)
		{

			$this->removeTipospermuta();
			
			foreach ($imoveis_ids as $imo){

				/* Varre os itens enviados e os adiciona */

				foreach ( $this->tipos_permuta as $item ):

					$data = array(
						"nidcadimo" => $imo,
						"nidtbxtpp" => $item,
						"cdescriipe" => $this->descricao_permuta[$item]
					);

					$this->db->insert('tagipe', $data );

				endforeach;

			}
			
			return true;
		}

		/**
		* Função para remover todas as características de um cadastro de Imóvel
		* @access protected
		* @return true
		*/

		protected function removeCaracteristicas()
		{

			$imoveis_ids = array($this->id);

			/* Caso seja uma inserção, aplica a atualização para todos os imóveis relacionados também. A edição é realizada um a um */

			if (!$this->edit){
				/* Preencher com todos os imóveis que serão atualizados */
				$imoveis_ids = array_merge($imoveis_ids, $this->getIdsImoveisRelacionados());
			}

			foreach ($imoveis_ids as $imo){

				/* Indica que o ID do Imóvel é o id do objeto */
				$this->db->where('nidcadimo', $imo);
				/* Faz a remoção */
				$this->db->delete('tagcim');

			}

			return true;
		}

		/**
		* Função para remover todos os tipos de permuta de um cadastro de Imóvel
		* @param array lista de ids de imóveis
		* @access protected
		* @return true
		*/

		protected function removeTipospermuta()
		{

			$imoveis_ids = array($this->id);

			/* Caso seja uma inserção, aplica a atualização para todos os imóveis relacionados também. A edição é realizada um a um */

			if (!$this->edit){
				/* Preencher com todos os imóveis que serão atualizados */
				$imoveis_ids = array_merge($imoveis_ids, $this->getIdsImoveisRelacionados());
			}

			foreach ($imoveis_ids as $imo){

				/* Indica que o ID do Imóvel é o id do objeto */
				$this->db->where('nidcadimo', $imo);
				/* Faz a remoção */
				$this->db->delete('tagipe');

			}

			return true;
		}

		/**
		* Função para buscar registros com base no título ou referência
		* @access public
		* @param string título ou referência do Imóvel
		* @return array de objetos
		*/


		public function getByTituloReferencia($term)
		{
			$this->db->where('dtdataexc IS NULL AND nidtbxsegusu_exclusao IS NULL AND nativo = 1 AND (ctitulo LIKE "%'.$term.'%" OR creferencia = "'.$term.'")', null, false);

			$result = $this->db->get('cadimo')->result();
			return $result;
		}

		/**
		* Função para buscar a primeira foto do Imóvel
		* @access public
		* @param integer ID do Imóvel
		* @return string url da imagem
		*/

		public static function getPrimeiraFoto($id)
		{

			self::$db = &get_instance()->db;

			$tpm = new Tipomidia_model();

			$pasta = $tpm->getMenorLargura()->cfoldermid;

			self::$db->where('nidcadimo', $id);

			self::$db->where('nativo', 1);

			self::$db->order_by('nord', 'ASC');

			$img = self::$db->get("tagimi")->row();

			if ($img){

				return base_url("imagens/".$pasta."/".$img->nidtagimi.".jpg");

			} else {

				return false;

			}


		}

		/**
		* Função para buscar as fotos do Imóvel
		* @access public
		* @param integer ID do Imóvel
		* @return array lista de imagens
		*/

		public function getFotos($id)
		{

			$result = array();

			$tpm = new Tipomidia_model();

			$pasta = $tpm->getMaiorLargura()->cfoldermid;

			$this->db->where('nidcadimo', $id);

			$this->db->where('nativo', 1);

			$this->db->order_by('nord', 'ASC');

			$img = $this->db->get("tagimi")->result();

			foreach ($img as $item){

				$result[] = base_url("imagens/".$pasta."/".$item->nidtagimi.".jpg");

			}

			return $result;

		}

		/**
		* Função para buscar os dias em que um Imóvel está ocupado
		* @access public
		* @param integer ID do Imóvel
		* @return array lista de dias no formato d/m/Y
		*/

		public static function getDiasOcupados($id)
		{
			
			self::$db = &get_instance()->db;
			self::$db->where('nidcadimo', $id);
			self::$db->where('nativo', 1);
			$results = self::$db->get('cadloc')->result();

			$datas = array();

			foreach ($results as $item){

				$data_inicial = $item->ddatainicial;
				$data_final = $item->ddatafinal;

				$datas = array_merge($datas, createDateRangeArray($data_inicial, $data_final));
				
			}

			return $datas;
			
		}

		/**
		* Função para trazer o maior valor de diária de um Imóvel
		* @access public
		* @param integer ID do Imóvel
		* @return decimal valor da diária
		*/

		public static function getMaiorDiaria($id)
		{
			
			self::$db = &get_instance()->db;
			self::$db->where('nidcadimo', $id);
			self::$db->order_by('nvalor', 'DESC');
			
			$iva = self::$db->get('tbxiva')->row();
			
			return $iva->nvalor;
			
		}

		/**
		* Função para salvar os pacotes de um Imóvel
		* @access public
		* @param array IDS dos pacotes selecionados
		* @param array Valores das diárias
		* @param array Mínimos de dias
		* @param array Valores dos pacotes
		* @return boolean
		*/

		public function savePacotes($ids_pacotes, $valores_diarias, $minimo_dias, $valores_pacotes){

			if (!$this->id)
				return false;
			$this->db->where('nidcadimo', $this->id);
			$this->db->delete('tagpci');
			foreach ($ids_pacotes as $id_pacote){
				$data = array(
					'nidcadimo' => $this->id,
					'nidtbxpac' => $id_pacote,
					'nvlrdiaria' => $valores_diarias[$id_pacote],
					'nmindias' => $minimo_dias[$id_pacote],
					'nvlrpacote' => $valores_pacotes[$id_pacote]
				);
				$this->db->insert('tagpci', $data);
			}
			return true;

		}

		/**
		* Função para pegar os pacotes de um Imóvel
		* @access public
		* @return array lista de pacotes
		*/

		public function getPacotes(){

			if (!$this->id)
				return false;
			$this->db->where('nidcadimo', $this->id);
			$pacotes = $this->db->get('tagpci')->result();
			$result = array();
			foreach ($pacotes as $pacote){
				$result[$pacote->nidtbxpac] = array(
					'nvlrdiaria'=>$pacote->nvlrdiaria,
					'nmindias'=>$pacote->nmindias,
					'nvlrpacote'=>$pacote->nvlrpacote
				);
			}
			return $result;

		}

		/**
		* Função para atualizar a lista de bens de um Imóvel
		* @param array lista de grupos e bens
		* @access public
		* @return true
		*/

		public function atualizarBens($params){
			$this->db->where('nidcadimo', $this->id);
			$bbi = $this->db->get('tagbbi')->result();
			foreach ($bbi as $item_bbi){
				$this->db->where('nidtagbbi', $item_bbi->nidtagbbi);
				$this->db->delete('tagibi');
			}
			$this->db->where('nidcadimo', $this->id);
			$this->db->delete('tagbbi');
			$this->db->where('nidcadimo', $this->id);
			$this->db->delete('taggbi');
			foreach ($params as $linha){
				$grupo = $linha['grupo'];
				$bens = $linha['bens'];
				if (!$grupo){
					foreach ($bens as $bem){
						$informacoes = explode("|", $bem['informacoes']);
						$data = array("nidcadimo"=>$this->id, "nidtbxbem"=>$bem['nidtbxbem'], "nquantidade"=>$bem['quantidade'], "tobservacoes"=>serialize($informacoes));
						$this->db->insert("tagbbi", $data);
						$nidtagbbi = $this->db->insert_id();
					}
				} else {
					$data = array("nidtbxgrb"=>$grupo, "nidcadimo"=>$this->id);
					$this->db->insert("taggbi", $data);
					$grupoimovel = $this->db->insert_id();
					foreach ($bens as $bem){
						$informacoes = explode("|", $bem['informacoes']);
						$data = array("nidtaggbi"=>$grupoimovel, "nidcadimo"=>$this->id, "nidtbxbem"=>$bem['nidtbxbem'], "nquantidade"=>$bem['quantidade'], "tobservacoes"=>serialize($informacoes));
						$this->db->insert("tagbbi", $data);
						$nidtagbbi = $this->db->insert_id();
					}
				}
			}
			return true;
		}

		/**
		* Função para trazer a lista de proprietários de um Imóvel
		* @param integer id do Imóvel
		* @access public
		* @return array lista de proprietários
		*/		

		public function getProprietarios($id){
			$this->db->where('nidcadimo', $id);
			$ipr = $this->db->get('tagipr')->result();
			$result = array();
			foreach ($ipr as $proprietario){
				$this->db->where('nidcadgrl', $proprietario->nidcadgrl);
				$result[] = array('ipr'=>$proprietario, 'cadgrl'=>$this->db->get('cadgrl')->row());
			}
			return $result;
		}

		/**
		* Função para trazer a lista de angariadores de um Imóvel
		* @param integer id do Imóvel
		* @access public
		* @return array lista de angariadores
		*/		

		public function getAngariadores($id){
			$this->db->where('nidcadimo', $id);
			$ang = $this->db->get('tagang')->result();
			$result = array();
			foreach ($ang as $angariador){
				$this->db->where('nidtbxsegusu', $angariador->nidtbxsegusu);
				$result[] = array('ang'=>$angariador, 'segusu'=>$this->db->get('tbxsegusu')->row());
			}
			return $result;
		}

		/**
		* Função para remover os proprietários de um Imóvel
		* @access public
		* @return true
		*/		

		public function removeProprietarios(){
			$this->db->where('nidcadimo', $this->id);
			$this->db->delete('tagipr');
			return true;
		}

		/**
		* Função para remover os angariadores de um Imóvel
		* @access public
		* @return true
		*/	

		public function removeAngariadores(){
			$this->db->where('nidcadimo', $this->id);
			$this->db->delete('tagang');
			return true;
		}

		/**
		* Função para trazer a lista de valores de um Imóvel
		* @param integer id do Imóvel
		* @access public
		* @return array lista de valores
		*/		

		public function getValores($id){
			$this->db->where('nidcadimo', $id);
			$iva = $this->db->get('tbxiva')->result();
			$return = array();
			foreach ($iva as $item){
				$return[$item->nidtagfva] = $item->nvalor;
			}
			return $return;
		}

		/**
		* Função para trazer as observações de um Imóvel
		* @param integer id do Imóvel
		* @access public
		* @return array lista de observações
		*/		

		public function getObservacoes($id){
			$this->db->where('nidcadimo', $id);
			$iob = $this->db->get('tagiob')->result();
			$return = array();
			foreach ($iob as $item){
				$return[] = array("nidtbxobs"=>$item->nidtbxobs, "observacao"=>$item->cdescriiob);
			}
			return $return;
		}

	}

	?>