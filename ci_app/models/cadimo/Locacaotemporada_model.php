<?php
	
	class Locacaotemporada_model extends MY_Model {

		/* Variável que armazena a etapa do cadastro (wizard) */
		public $etapa;
		
		protected $data_criacao;
		protected $data_atualizacao;

		public $imovel;
		public $cliente;
		public $data_inicial;
		public $data_final;
		public $comissao_vendedor;
		public $comissao_imobiliaria;
		public $valor_total;
		public $taxa_administrativa;
		public $quantidade_parcelas;

		/* Variáveis que armazenam os usuários que fizeram as operações */

		public $usuario_criacao;
		public $usuario_atualizacao;


		/* Nome da tabela que armazena os parâmetros */
		protected static $_table = "cadloc";
		/* Nome do ID field da tabela */
		protected static $_idfield = "nidcadloc";

		public function __construct()
		{
			parent::__construct();
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

				/* O registro não possui ID. Portanto, trata-se de um create (etapa geral) */

				$data = array(
					"nidcadimo" => $this->imovel,
					"nidcadgrl" => $this->cliente,
					"ddatainicial" => toDbDate($this->data_inicial),
					"ddatafinal" => toDbDate($this->data_final),
					"nvalor" => number_format($this->valor_total, 2, ".", ""),
					"ntaxaadm" => $this->taxa_administrativa,
					"nquantidadeparcelas" => $this->quantidade_parcelas,
					"dtdatacriacao" => date('Y-m-d H:i:s'),
					"nidtbxsegusu_criacao" => $this->usuario_criacao
				);
				$this->db->insert(self::$_table, $data);
				/* Retorna o ID do registro que acabou de ser inserido e adiciona ele como um atributo do objeto */
				$this->id = $this->db->insert_id();

			} else {

				/* O registro possui ID. Portanto, trata-se de um update */

			}

			return $this->id;
		}

		/**
		* Função para salvar as parcelas de uma locação no banco
		* @param int ID da locação
		* @param array lista de parâmetros enviados no formulário
		* @access public
		*/

		public function saveParcelas($cadloc, $params_array){
			$result_parcelamento = array();
			$this->load->model('fin/Financeiro_model');
			$this->load->model('fin/Tipofinanceiro_model');
			$this->load->model('fin/Boleto_model');
			$this->load->model('cadgrl/Cadastro_model');
			$this->load->model('cadgrl/Enderecocadastrogeral_model');
			$this->load->model('cadimo/Imovel_model');
			$this->load->model('cadimo/Proprietarioimovel_model');

			$imovel = $this->Imovel_model->getById($params_array['imovelid']);

			$proprietarios = $this->Proprietarioimovel_model->getByImovel($imovel->nidcadimo);

			$quantidade_parcelas = $params_array['quantidade_parcelas'];
			$total_percentual_comissoes = Locacaotemporada_model::getTotalPercentualComissoes($cadloc);
			$dias_transferir_cliente = Parametro_model::get('quantidade_dias_depositar_cliente');
			for ($i=1; $i<=$quantidade_parcelas; $i++){
				
				$cadimo = $this->Imovel_model->getById($params_array['imovelid']);
				$fin_receber = new Financeiro_model();
				$fin_receber->nidcadgrl = $params_array['clienteid'];
				$fin_receber->nidcadloc = $cadloc;
				$fin_receber->nidcadimo = $params_array['imovelid'];
				$fin_receber->nidtbxfpa = $params_array['forma_pagamento'][$i];
				$fin_receber->nidtbxstp = Parametro_model::get("id_status_pagamento_pendente");
				$fin_receber->valor = $params_array['valor_parcela'][$i];
				$fin_receber->data_pagamento = toDbDate($params_array['data'][$i]);
				$fin_receber->tipo_transacao = "C";
				$fin_receber->tipo = Tipofinanceiro_model::getIdByCod("loc");
				$fin_receber->data_status = date('d/m/Y');
				$fin_receber->descricao = $params_array['pagamento'];
				$fin_receber->observacoes = $params_array['observacoes'][$i];
				if ($fin_receber->validaInsercao()){
					$fin_receber_id = $fin_receber->save();
					$result_parcelamento[] = "Salvou o valor a receber com o id ".$fin_receber_id;
				}
				
				/* Salva para cada proprietário */

				foreach ($proprietarios as $proprietario){

					/* Verifica a quantidade de parcelas e, se for uma, divide em duas pra pagar ao proprietário */

					if ($quantidade_parcelas > 1){

						$fin_pagar = new Financeiro_model();
						$valor_depositar = $params_array['valor_parcela'][$i] - $params_array['valor_parcela'][$i] * $total_percentual_comissoes;
						$fin_pagar->nidcadgrl = $proprietario->ipr->nidcadgrl;
						$fin_pagar->nidcadloc = $cadloc;
						$fin_pagar->nidcadfin = $fin_receber_id;
						$fin_pagar->nidcadimo = $params_array['imovelid'];
						$fin_pagar->nidtbxfpa = Parametro_model::get("forma_pagamento_pagar");
						$fin_pagar->nidtbxstp = Parametro_model::get("id_status_pagamento_pendente");
						$fin_pagar->valor = $valor_depositar*($proprietario->ipr->npercentual/100);
						
						$fin_pagar->tipo_transacao = "D";
						$fin_pagar->tipo = Tipofinanceiro_model::getIdByCod("loc");
						$fin_pagar->data_status = date('d/m/Y');
						$fin_pagar->descricao = $params_array['pagamento'];
						$fin_pagar->observacoes = $params_array['observacoes'][$i];

						if ($i == $quantidade_parcelas){

							// Trata-se da última parcela

							// Cinco dias após a saída

							$fin_pagar->data_pagamento = date('Y-m-d', strtotime(' +'.$dias_transferir_cliente.' day', strtotime(toDbDate($params_array['data_final']))));

						} else {

							// Cinco dias após o recebimento

							$fin_pagar->data_pagamento = date('Y-m-d', strtotime(' +'.$dias_transferir_cliente.' day', strtotime(toDbDate($params_array['data'][$i]))));

						}

						if ($fin_pagar->validaInsercao()){
							$fin_pagar_id = $fin_pagar->save();
							$criar_boleto = 1;
						}

					} else {

						/* Cliente pagou em apenas uma parcela */

						/* Salva a primeira parcela */

						$fin_pagar = new Financeiro_model();
						$valor_depositar = ($params_array['valor_parcela'][$i] - $params_array['valor_parcela'][$i] * $total_percentual_comissoes) / 2;
						$fin_pagar->nidcadgrl = $proprietario->ipr->nidcadgrl;
						$fin_pagar->nidcadloc = $cadloc;
						$fin_pagar->nidcadfin = $fin_receber_id;
						$fin_pagar->nidcadimo = $params_array['imovelid'];
						$fin_pagar->nidtbxfpa = Parametro_model::get("forma_pagamento_pagar");
						$fin_pagar->nidtbxstp = Parametro_model::get("id_status_pagamento_pendente");
						$fin_pagar->valor = $valor_depositar*($proprietario->ipr->npercentual/100);
						$fin_pagar->data_pagamento = date('Y-m-d', strtotime(' +'.$dias_transferir_cliente.' day', strtotime(toDbDate($params_array['data'][$i]))));
						$fin_pagar->tipo_transacao = "D";
						$fin_pagar->tipo = Tipofinanceiro_model::getIdByCod("loc");
						$fin_pagar->data_status = date('d/m/Y');
						$fin_pagar->descricao = $params_array['pagamento'];
						$fin_pagar->observacoes = $params_array['observacoes'][$i];
						if ($fin_pagar->validaInsercao()){
							$fin_pagar_id = $fin_pagar->save();
							$criar_boleto = 1;
						}

						/* Salva a segunda parcela */

						$fin_pagar = new Financeiro_model();
						$valor_depositar = ($params_array['valor_parcela'][$i] - $params_array['valor_parcela'][$i] * $total_percentual_comissoes) / 2;
						$fin_pagar->nidcadgrl = $proprietario->ipr->nidcadgrl;
						$fin_pagar->nidcadloc = $cadloc;
						$fin_pagar->nidcadfin = $fin_receber_id;
						$fin_pagar->nidcadimo = $params_array['imovelid'];
						$fin_pagar->nidtbxfpa = Parametro_model::get("forma_pagamento_pagar");
						$fin_pagar->nidtbxstp = Parametro_model::get("id_status_pagamento_pendente");
						$fin_pagar->valor = $valor_depositar*($proprietario->ipr->npercentual/100);
						$fin_pagar->data_pagamento = date('Y-m-d', strtotime(' +'.$dias_transferir_cliente.' day', strtotime(toDbDate($params_array['data_final']))));
						$fin_pagar->tipo_transacao = "D";
						$fin_pagar->tipo = Tipofinanceiro_model::getIdByCod("loc");
						$fin_pagar->data_status = date('d/m/Y');
						$fin_pagar->descricao = $params_array['pagamento'];
						$fin_pagar->observacoes = $params_array['observacoes'][$i];
						if ($fin_pagar->validaInsercao()){
							$fin_pagar_id = $fin_pagar->save();
							$criar_boleto = 1;
						}

					}

				}

				if ($criar_boleto){
					/* Criar o boleto */
					if ($fin_receber->nidtbxfpa == Parametro_model::get('id_forma_pagamento_boleto')){
						$result_parcelamento[] = "Registra boleto";

						$nrdoc_x = "00".str_pad($cadloc, 6, "0", STR_PAD_RIGHT).str_pad($i, 3, "0", STR_PAD_LEFT);

			            $nrdoc = str_pad($nrdoc_x,11,"0",STR_PAD_LEFT);

						$cadgrl = $this->Cadastro_model->getById($params_array['clienteid']);
						$enderecos = $this->Enderecocadastrogeral_model->getByCadastroGeral($params_array['clienteid']);
						$this->Boleto_model = new Boleto_model();
						$this->Boleto_model->cadfin = $fin_receber_id;
						$this->Boleto_model->data_vencimento = toDbDate($params_array['data'][$i]);
						$this->Boleto_model->valor = $params_array['valor_parcela'][$i];
						$this->Boleto_model->nosso_numero_3 = $nrdoc;
						$this->Boleto_model->numero_documento = $nrdoc;
						$this->Boleto_model->sacado = $cadgrl->cnomegrl;
						$this->Boleto_model->endereco1 = $enderecos[0]['cdescrilog'].", ".$enderecos[0]['cnumero'].", ".$enderecos[0]['ccomplemento'];
						$this->Boleto_model->endereco2 = $enderecos[0]['cdescribai'].", ".$enderecos[0]['cdescriloc'].", ".$enderecos[0]['cdescriuf'];
						$this->Boleto_model->demonstrativo1 = 'Locação temporada - '.$cadimo->creferencia;
						$this->Boleto_model->demonstrativo2 = '';
						$this->Boleto_model->demonstrativo3 = 'Data de Entrada '.$params_array['data_inicial'].' a '.$params_array['data_final'];
						$this->Boleto_model->instrucoes1 = '';
						$this->Boleto_model->instrucoes2 = 'Sr. Caixa, favor não receber após o Vencimento!!';
						$this->Boleto_model->instrucoes3 = '';
						$this->Boleto_model->instrucoes4 = 'Sr. Caixa, Não receber CHEQUE para pagamento desse BOLETO!!';	
						$this->Boleto_model->usuario_criacao = $this->usuario_criacao;	
						if ($this->Boleto_model->validaInsercao()){
							$result_parcelamento[] = "Boleto passou pela validação (".json_encode($this->Boleto_model).")";
							$id = $this->Boleto_model->save();
							$this->Boleto_model->gerarRemessa($id);
						} else {
							$result_parcelamento[] = "Boleto não passou pela validação";
						}
					} else {
						$result_parcelamento[] = "Não registra boleto";
					}
				}
			}
			return $result_parcelamento;

		}

		/**
		* Função para salvar as comissões de uma locação no banco
		* @param int ID da locação
		* @param array lista de parâmetros enviados no formulário
		* @access public
		*/

		public function saveComissoes($cadloc){
			$this->load->model('dci/Tipocomissao_model');
			$this->db->where('nidcadloc', $cadloc);
			$loc = $this->db->get('cadloc')->row();
			$this->db->where('nidcadimo', $loc->nidcadimo);
			$comissoes = $this->db->get('tagicm')->result();
			foreach ($comissoes as $comissao){
				$data = array("nidcadloc"=>$cadloc,"nidtbxtcm"=>$comissao->nidtbxtcm,"nvalor"=>$comissao->nvalor,"nidtbxstp"=>Parametro_model::get("id_status_pagamento_pendente"));
				$this->db->insert('taglcm', $data);
			}
			return true;

		}

		/**
		* Função para pegar a soma das comissões de uma locação no banco
		* @param int ID da locação
		* @param decimal soma de valores da locação
		* @access public
		*/

		public static function getTotalComissoes($cadloc){
			self::$db->where('nidcadloc', $cadloc);
			self::$db->where('nativo', 1);
			$locacao = self::$db->get('cadloc')->row();
			self::$db->where('nidcadloc', $locacao->nidcadloc);
			$comissoes = self::$db->get('taglcm')->result();
			$comissao_total = 0;
			foreach ($comissoes as $comissao){
				$comissao_total += ($comissao->nvalor/100) * ($locacao->nvalor - $locacao->ntaxaadm);
			}
			return $comissao_total;
		}

		/**
		* Função para pegar a soma dos percentuais de comissão de uma locação
		* @param int ID da locação
		* @param decimal soma de percentuais de comissão
		* @access public
		*/

		public static function getTotalPercentualComissoes($cadloc){
			self::$db->select('nvalor');
			self::$db->from('taglcm');
			self::$db->where('nidcadloc', $cadloc);
			$comissoes = self::$db->get()->result();
			$total = 0;
			foreach ($comissoes as $comissao){
				$total+= $comissao->nvalor / 100;
			}
			return $total;
		}

		/**
		* Função para pegar dados do locatário
		* @param nenhum. Os dados inseridos são atributos do objeto
		* @return json array
		* @access public
		*/

		public function getDadosLocatario(){
			$this->db->where('nidcadloc', $this->id);
			$loc = $this->db->get('cadloc')->row();
			$this->db->where('nidcadgrl', $loc->nidcadgrl);
			$cadgrl = $this->db->get('cadgrl')->row();
			$result = array('nome'=>$cadgrl->cnomegrl, 'cpf'=>$cadgrl->ccpfcnpj, 'rg'=>$cadgrl->crgie );
			$this->db->where('nidcadgrl', $cadgrl->nidcadgrl);
			if ($cadgrl->ctipopessoa == "f"){
				$cadfis = $this->db->get('cadfis')->row();	
				$result['data_nascimento'] = toUserDate($cadfis->ddtnasc);
			} else {
				$cadjur = $this->db->get('cadjur')->row();
				$result['data_nascimento'] = toUserDate($cadjur->ddtfundacao);
			}
			
			// telefone

			$this->db->where('nidcadgrl', $cadgrl->nidcadgrl);
			$tel = $this->db->get('tagtel')->row();
			$result['telefone'] = $tel->cdescritel;

			// cidade

			$this->db->where('nidcadgrl', $cadgrl->nidcadgrl);
			$edc = $this->db->get('tagedc')->row();
			$this->db->where('nidtbxend', $edc->nidtbxend);
			$end = $this->db->get('tbxend')->row();

			$this->db->where('nidcadlog', $end->nidcadlog);
			$log = $this->db->get('cadlog')->row();

			$this->db->where('nidtbxbai', $log->nidtbxbai);
			$bai = $this->db->get('tbxbai')->row();

			$this->db->where('nidtbxloc', $bai->nidtbxloc);
			$loc = $this->db->get('tbxloc')->row();

			$result['cidade'] = $loc->cdescriloc;

			$this->db->where('nidtbxuf', $loc->nidtbxuf);
			$uf = $this->db->get('tbxuf')->row();	
			
			$result['uf'] = $uf->csiglauf;		

			if ($cadgrl->ctipopessoa == "f"){

				$date = new DateTime( $cadfis->ddtnasc ); // data de nascimento
			
			} else {

				$date = new DateTime( $cadjur->ddtfundacao ); // data de fundação

			}

			$interval = $date->diff( new DateTime( date('Y-m-d') ) ); // data definida

			$result['idade'] = $interval->format( '%Y' );

			return json_encode($result);

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
				'l.nidcadloc',
				'l.ddatainicial AS data_inicial'
				,'i.creferencia AS referencia'
				,'c.cnomegrl AS cliente'
				,'l.dtdatacriacao AS data_cadastro'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from( self::$_table.' l' )
				->join( 'cadimo i' , 'l.nidcadimo = i.nidcadimo', 'LEFT') // Imóvel
				->join( 'cadgrl c' , 'l.nidcadgrl = c.nidcadgrl', 'LEFT'); // cadastro geral

			// condições
			$sql->where('l.nativo', 1);
			$sql->where('l.nidtbxsegusu_exclusao IS NULL');
			$sql->where('l.dtdataexc IS NULL');

			if(isset($params['usuario'])) $sql->where(array('l.nidtbxsegusu_criacao'=>$params['usuario'])); // usuário

			if(isset($params['referencia'])) $sql->where(array('i.creferencia'=>$params['referencia'])); // referência

			if (isset($params['datai']) && isset($params['dataf']) && isset($params['type'])){
				if ($params['type']=="locacao"){
					$sql->where("(l.ddatainicial >= '".$params['datai']."' AND l.ddatainicial <= '".$params['dataf']."') OR (l.ddatafinal >= '".$params['datai']."' AND l.ddatafinal <= '".$params['dataf']."') OR (l.ddatainicial <= '".$params['datai']."' AND l.ddatafinal >= '".$params['dataf']."') OR (l.ddatainicial >= '".$params['datai']."' AND l.ddatafinal <= '".$params['dataf']."')");
				} elseif($params['type']=="cadastro"){
					$sql->where("(l.dtdatacriacao >= '".$params['datai']."' AND l.dtdatacriacao <= '".$params['dataf']."')");
				}
			}

			switch ($fase) {
				case 'records':
					$query = $sql->order_by( 'l.dtdatacriacao', 'DESC' )
								->limit( $limit, $offset )
								->get();
					if($query) return $query->result();
					break;

				case 'recordsFiltered':
					return $sql->count_all_results();
					break;

				case 'recordsTotal':
					$this->db->get(self::$_table);
					$this->db->where('nativo',1);
					return $this->db->count_all_results(self::$_table);
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

			$this->removeTipoImovelSecundario();
			
			/* Varre os itens enviados e os adiciona */
			
			foreach ( $ti2 as $item ):

				$data = array(
					"nidcadimo" => $this->id,
					"nidtagti2" => $item
				);

				$this->db->insert('tagt2i', $data );

			endforeach;
			
			return true;
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
			/* Indica que o ID do Imóvel é o id do objeto */
			$this->db->where('nidcadimo', $this->id);
			/* Faz a remoção */
			$this->db->delete('tagt2i');
			return true;
		}

		/**
		* Função para setar as características de um cadastro de Imóvel
		* @param array com os id's das características
		* @access public
		* @return true
		*/

		public function setCaracteristicas( $car = array() )
		{

			$this->removeCaracteristicas();
			
			/* Varre os itens enviados e os adiciona */
			
			foreach ( $car as $item ):

				$data = array(
					"nidcadimo" => $this->id,
					"nidtbxcar" => $item
				);

				$this->db->insert('tagcim', $data );

			endforeach;
			
			return true;
		}

		/**
		* Função para setar os tipos de permuta de um cadastro de Imóvel
		* @access private
		* @return true
		*/

		private function setTipoPermuta()
		{

			$this->removeTipospermuta();
			
			/* Varre os itens enviados e os adiciona */

			foreach ( $this->tipos_permuta as $item ):

				$data = array(
					"nidcadimo" => $this->id,
					"nidtbxtpp" => $item,
					"cdescriipe" => $this->descricao_permuta[$item]
				);

				$this->db->insert('tagipe', $data );

			endforeach;
			
			return true;
		}

		/**
		* Função para remover todas as características de um cadastro de Imóvel
		* @access protected
		* @return true
		*/

		protected function removeCaracteristicas()
		{
			/* Indica que o ID do Imóvel é o id do objeto */
			$this->db->where('nidcadimo', $this->id);
			/* Faz a remoção */
			$this->db->delete('tagcim');
			return true;
		}

		/**
		* Função para remover todos os tipos de permuta de um cadastro de Imóvel
		* @access protected
		* @return true
		*/

		protected function removeTipospermuta()
		{
			/* Indica que o ID do Imóvel é o id do objeto */
			$this->db->where('nidcadimo', $this->id);
			/* Faz a remoção */
			$this->db->delete('tagipe');
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
		* Função para obter reservas com base na entrada
		* @access public
		* @param integer id do Imóvel
		* @param date formato user - data de início do período
		* @param date formato user - data de fim do período
		* @return array de objetos
		*/

		public function getEntradas($imovel = false, $data_inicio, $data_fim){

			if ($data_inicio && $data_fim){

				$this->db->where('ddatainicial >=', toDbDate($data_inicio));
				$this->db->where('ddatainicial <=', toDbDate($data_fim));

			}

			$this->db->where('nativo', 1);

			$reservas = $this->db->get('cadloc')->result();

			$result = array();

			foreach ($reservas as $reserva){

				$item = new stdClass();

				$item->reserva = $reserva;
				$item->imovel = $this->db->where('nidcadimo', $reserva->nidcadimo)->get('cadimo')->row();
				$item->locatario = $this->db->where('nidcadgrl', $reserva->nidcadgrl)->get('cadgrl')->row();

				$result[] = $item;

			}

			return $result;

		}

		/**
		* Função para obter reservas com base na saída
		* @access public
		* @param integer id do Imóvel
		* @param date formato user - data de início do período
		* @param date formato user - data de fim do período
		* @return array de objetos
		*/

		public function getSaidas($imovel = false, $data_inicio, $data_fim){

			if ($data_inicio && $data_fim){

				$this->db->where('ddatafinal >=', toDbDate($data_inicio));
				$this->db->where('ddatafinal <=', toDbDate($data_fim));

			}

			$this->db->where('nativo', 1);

			$reservas = $this->db->get('cadloc')->result();

			$result = array();

			foreach ($reservas as $reserva){

				$item = new stdClass();

				$item->reserva = $reserva;
				$item->imovel = $this->db->where('nidcadimo', $reserva->nidcadimo)->get('cadimo')->row();
				$item->locatario = $this->db->where('nidcadgrl', $reserva->nidcadgrl)->get('cadgrl')->row();

				$result[] = $item;

			}

			return $result;

		}

		/**
		* Função para obter reservas com base no período de utilização ou na data de reserva
		* @access public
		* @param date formato user - data de início do período
		* @param date formato user - data de fim do período
		* @param integer ID do usuário
		* @return array de objetos
		*/

		public function getByCampo($imovel = false, $data_inicio, $data_fim, $campo, $usuario = false, $referencia = false){

			if ($usuario){
				$this->db->where('nidtbxsegusu_criacao', $usuario);
			}

			if ($imovel){
				$this->db->where('nidcadimo', $imovel);
			}

			if ($referencia){
				$this->db->join('cadimo i', 'cadloc.nidcadimo = i.nidcadimo', 'INNER');
				$this->db->where('i.creferencia', $referencia);
			}

			if ($campo == "utilizacao"){

				if ($data_inicio)
					$this->db->where('ddatainicial >=', toDbDate($data_inicio));
	
				if ($data_fim)
					$this->db->where('ddatafinal <=', toDbDate($data_fim));

			} elseif ($campo == "reserva"){


				if ($data_inicio)
					$this->db->where('dtdatacriacao >=', toDbDate($data_inicio));

				if ($data_fim)
					$this->db->where('dtdatacriacao <=', toDbDate($data_fim));	

			}

			$this->db->where('cadloc.nativo', 1);

			$reservas = $this->db->get('cadloc')->result();

			$result = array();

			foreach ($reservas as $reserva){

				$item = new stdClass();

				$item->reserva = $reserva;
				$item->imovel = $this->db->where('nidcadimo', $reserva->nidcadimo)->get('cadimo')->row();
				$item->locatario = $this->db->where('nidcadgrl', $reserva->nidcadgrl)->get('cadgrl')->row();

				$result[] = $item;

			}

			return $result;

		}

		/**
		* Função para obter os boletos de uma reserva
		* @access public
		* @param integer ID da locação
		* @return array de boletos
		*/

		public function getBoletos($locacao){
			$this->db->where('ctipotransacao', 'C');
			$this->db->where('nidcadloc', $locacao);
			$fin = $this->db->get('cadfin')->result();
			$boletos = array();
			foreach ($fin as $item){
				$this->db->where('nidcadfin', $item->nidcadfin);
				$this->db->where('nativo', 1);
				$boleto = $this->db->get('cadbol')->row();
				if (!$boleto)
					continue;
				$boleto->data_vencimento = toUserDate($boleto->ddatavencimento);
				$boleto->valor = number_format($boleto->nvalor, 2, ",", ".");
				$boletos[] = $boleto;
			}
			return $boletos;
		}

		/**
		* Função para obter as locações excluídas
		* @access public
		* @return array de locações
		*/

		public function getExcluidas(){
			$this->db->where('nativo', 0);
			$this->db->where('nidtbxsegusu_exclusao IS NOT NULL', null, false);
			$this->db->where('dtdataexc IS NOT NULL', null, false);
			$this->db->order_by('dtdataexc', 'DESC');
			return $this->db->get('cadloc')->result();
		}

		/**
		* Função para retornar as locações excluídas em um json
		* @access public
		* @return array de locações
		*/

		public function listar_excluidas_data($fase='records', $offset=0, $limit=10, $params=NULL){

			// Construção da consulta
			// campos

			$select = array(
				'l.nidcadloc',
				'l.ddatainicial',
				'l.dtdatacriacao',
				'l.dtdataexc',
				'i.nidcadimo',
				'i.creferencia',
				'g.nidcadgrl',
				'g.cnomegrl',
				'u.cnome AS usuario',
				'u.nidtbxsegusu',
				'u2.cnome AS usuario_criacao'
			);

			// query builder
			$sql = $this->db->select( $select )
				->from('cadloc l')
				->join('cadgrl g', 'l.nidcadgrl = g.nidcadgrl', 'INNER')
				->join('tbxsegusu u', 'l.nidtbxsegusu_exclusao = u.nidtbxsegusu', 'INNER')
				->join('tbxsegusu u2', 'l.nidtbxsegusu_criacao = u2.nidtbxsegusu', 'INNER')
				->join('cadimo i', 'l.nidcadimo = i.nidcadimo', 'INNER');

			// condições
			$sql->where('l.nativo', 0);

			if(isset($params['usuario'])) $sql->where(array('l.nidtbxsegusu_exclusao'=>$params['usuario'])); // usuário

			switch ($fase) {
				case 'records':
					$query = $sql->order_by( 'l.dtdataexc', 'DESC' )
								->limit( $limit, $offset )
								->get();
					$result = $query->result();
					$locacoes = array();
					foreach ($result as $locacao){
						$locacao->dtdataexc = toUserDateTime($locacao->dtdataexc, ' ');
						$locacao->dtdatacriacao = toUserDateTime($locacao->dtdatacriacao, ' ');
						$locacao->ddatainicial = toUserDate($locacao->ddatainicial);
						$locacoes[] = $locacao;
					}
					if($query) return $locacoes;
					break;

				case 'recordsFiltered':
					return $sql->count_all_results();
					break;

				case 'recordsTotal':
					$this->db->where('l.nativo', '0');
					return $this->db->count_all_results(self::$_table);
					break;
			}

		}
		

	}

	?>