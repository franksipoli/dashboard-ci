<?php
	class Boleto_model extends MY_Model {

		/* Nome da tabela no banco de dados */
		protected static $_table = "cadbol";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidcadbol";

		public $hash;
		public $cadfin;
		public $data_vencimento;
		public $valor;
		public $nosso_numero_3;
		public $numero_documento;
		public $numero_documento_antigo;
		public $sacado;
		public $endereco1;
		public $endereco2;
		public $demonstrativo1;
		public $demonstrativo2;
		public $demonstrativo3;
		public $instrucoes1;
		public $instrucoes2;
		public $instrucoes3;
		public $instrucoes4;
		public $usuario_criacao;
		public $usuario_exclusao;

		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
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

			$this->hash = md5($this->data_vencimento.date('YmdHis').$this->cadfin.$this->valor.$this->sacado.$this->numero_documento.rand(1,9999));

			/* Criar */
			$data = array(
				'chash'=>$this->hash,
				'dtdatacriacao'=>date('Y-m-d H:i:s'),
				'nidtbxsegusu_criacao'=>$this->usuario_criacao,
				'nidcadfin'=>$this->cadfin,
				'ddatavencimento'=>$this->data_vencimento,
				'nvalor'=>$this->valor,
				'cnumerodocumento'=>$this->numero_documento,
				'cnumerodocumento_antigo'=>$this->numero_documento_antigo,
				'csacado'=>$this->sacado,
				'cendereco1'=>$this->endereco1,
				'cendereco2'=>$this->endereco2,
				'cdemo1'=>$this->demonstrativo1,
				'cdemo2'=>$this->demonstrativo2,
				'cdemo3'=>$this->demonstrativo3,
				'cinst1'=>$this->instrucoes1,
				'cinst2'=>$this->instrucoes2,
				'cinst3'=>$this->instrucoes3,
				'cinst4'=>$this->instrucoes4
			);
			$this->db->insert(self::$_table, $data);
			return $this->db->insert_id();
		}

		/**
		* Função que gera um novo boleto para um depósito
		* @param integer id do depósito
		* @return string resultado da ação
		* @access public
		*/

		public function gerarNovoBoleto(){

			$this->db->where('nidcadfin', $this->cadfin);
			$this->db->where('nativo', 1);
			$boleto = $this->db->get('cadbol')->row();
			
			$data = array('nativo'=>0, 'nidtbxsegusu_exclusao'=>$this->usuario_exclusao, 'dtdataexc'=>date('Y-m-d H:i:s'));
			$this->db->where('nidcadfin', $this->cadfin);
			$this->db->update('cadbol', $data);

			$this->db->where('nidcadfin', $boleto->nidcadfin);
			$cadfin = $this->db->get('cadfin')->row();
			$cadloc = $this->db->where('nidcadloc', $cadfin->nidcadloc)->get('cadloc')->row();

			$this->db->select('b.cnumerodocumento');
			$this->db->from('cadbol b');
			$this->db->join('cadfin f', 'f.nidcadfin = b.nidcadfin', 'LEFT');
			$this->db->where('f.nidcadloc', $cadloc->nidcadloc);
			$total = count($this->db->get()->result());

			$nrdoc_x = str_pad($cadloc->nidcadloc, 6, "0", STR_PAD_RIGHT).str_pad($total+1, 3, "0", STR_PAD_LEFT);

            $nrdoc = str_pad($nrdoc_x,11,"0",STR_PAD_LEFT);
			
			$this->data_vencimento = $boleto->ddatavencimento;
			$this->valor = $boleto->nvalor;
			$this->nosso_numero_3 = $nrdoc;
			$this->numero_documento = $nrdoc;
			$this->numero_documento_antigo = $boleto->cnumerodocumento;
			$this->sacado = $boleto->csacado;
			$this->endereco1 = $boleto->cendereco1;
			$this->endereco2 = $boleto->cendereco2;
			$this->demonstrativo1 = $boleto->cdemo1;
			$this->demonstrativo2 = $boleto->cdemo2;
			$this->demonstrativo3 = $boleto->cdemo3;
			$this->instrucoes1 = $boleto->cinst1;
			$this->instrucoes2 = $boleto->cinst2;
			$this->instrucoes3 = $boleto->cinst3;
			$this->instrucoes4 = $boleto->cinst4;	
			$this->usuario_criacao = $this->usuario_exclusao;

			$boleto_id = $this->save();

			$this->gerarRemessa($boleto_id);

			return array("message"=>"Novo boleto gerado com sucesso", "numero_boleto"=>$this->numero_documento);

		}

		/**
		* Função que pega um boleto e gera seu arquivo de remessa
		* @param integer id do boleto
		* @access public
		*/	

		public function gerarRemessa($boleto_id){

			$this->load->model('cadgrl/Enderecocadastrogeral_model');

			$this->db->where('nidcadbol', $boleto_id);
			$boleto = $this->db->get('cadbol')->row();
			$fin = $this->db->where('nidcadfin', $boleto->nidcadfin)->get('cadfin')->row();
			$locacao = $this->db->where('nidcadloc', $fin->nidcadloc)->get('cadloc')->row();
			$cliente = $this->db->where('nidcadgrl', $locacao->nidcadgrl)->get('cadgrl')->row();

			$numero_antigo = $boleto->cnumerodocumento;

			$enderecos = $this->Enderecocadastrogeral_model->getByCadastroGeral($cliente->nidcadgrl);

			/* Arquivo importado do sistema atual */

			$data_geracao = date("dmY");
			$hora_geracao = date("His");
			$banco = "104";
			$agencia = "00001";
			$dv_agencia = "2";
			$cod_convenio = "625786";
			$n_inscricao_empresa = "00000000000000";
			$empresa = "YOOPAY SOLUÇOES TECNOLOGICAS S/A";
			$dias_de_prazo_para_pagamento = 0;

			$mensagem_3 = "Sr Caixa, Não Receber Após Vencimento!!";
			$mensagem_4 = "";
			$mensagem_5 = "";
			$mensagem_6 = "";
			$mensagem_7 = "";
			$mensagem_8 = "";

			$data_emissao = date("dmY");
			$valor_em_zero = "0.00";

			$juros = explode('.',$valor_em_zero);
			$juros_mora = str_pad('0',13,"0",STR_PAD_LEFT);
			$juros_decimal = str_pad('0',2,"0");

			$desconto = explode('.',$valor_em_zero);
			$desconto_mora = str_pad('0',13,"0",STR_PAD_LEFT);
			$desconto_decimal = str_pad('0',2,"0");

			$iof = explode('.',$valor_em_zero);
			$iof_mora = str_pad('0',13,"0",STR_PAD_LEFT);
			$iof_decimal = str_pad('0',2,"0");

			$abatimento = explode('.',$valor_em_zero);
			$abatimento_mora = str_pad('0',13,"0",STR_PAD_LEFT);
			$abatimento_decimal = str_pad('0',2,"0");

			$cod_protesto = "3";
			$n_dias_protesto = "00";
			$cod_baixa_devolucao = "1";
			$n_dias_baixa_devolucao = "005";
			$cod_moeda = "09";
			$dias_tolerancia_multa = 1;
			$valor_multa = "0";
			$valor_multa = explode('.',str_replace(',','.',$valor_multa));

			// para montar nome do arquivo
			//$monta_nome_arquivo = 'cef_boleto_'.$_GET[nrdoc];
			$monta_nome_arquivo = 'cef_boleto_'.$boleto->cnumerodocumento;

			$arquivo = 'tmp/'.$monta_nome_arquivo.'.rem';
			@unlink($arquivo);

			$monta_nome_arquivo_antigo = 'cef_boleto_'.$boleto->cnumerodocumento_antigo;

			$arquivo_antigo = 'tmp/'.$monta_nome_arquivo_antigo.'.rem';
			@unlink($arquivo_antigo);

			// Cria e Abre para gravar $arquivo
			$abrir = fopen($arquivo, "w+");

			//$header_arquivo = str_pad($banco,3,'0',STR_PAD_LEFT).str_pad('',4,'0',STR_PAD_LEFT)."0".str_pad(' ',9)."2".str_pad($n_inscricao_empresa,14,"0",STR_PAD_LEFT).str_pad('0',20,'0',STR_PAD_LEFT).str_pad($agencia,5,"0",STR_PAD_LEFT).$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',8,'0',STR_PAD_LEFT).str_pad($empresa, 30)."CAIXA ECONOMICA FEDERAL       ".str_pad(' ',10)."1".$data_geracao.$hora_geracao."000095"."050".str_pad('0',5,'0',STR_PAD_LEFT).str_pad(' ',20)."REMESSA-PRODUCAO    "."V215".str_pad('',25);
			$header_arquivo = str_pad($banco,3,'0',STR_PAD_LEFT).str_pad('',4,'0',STR_PAD_LEFT)."0".str_pad(' ',9)."2".str_pad($n_inscricao_empresa,14,"0",STR_PAD_LEFT).str_pad('0',20,'0',STR_PAD_LEFT).str_pad($agencia,5,"0",STR_PAD_LEFT).$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',8,'0',STR_PAD_LEFT).str_pad($empresa, 30)."CAIXA ECONOMICA FEDERAL       ".str_pad(' ',10)."1".$data_geracao.$hora_geracao."000095"."050".str_pad('0',5,'0',STR_PAD_LEFT).str_pad(' ',20)."REMESSA-PRODUCAO        ".str_pad('',25);

			//$header_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."1"."R"."01"."00"."030"." "."2".str_pad($n_inscricao_empresa,15,"0",STR_PAD_LEFT).str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',14,'0',STR_PAD_LEFT).$agencia.$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',7,'0',STR_PAD_LEFT)."0".str_pad($empresa, 30).str_pad('',40).str_pad('',40)."00000095".$data_geracao.$data_geracao.str_pad(' ',33);
			$header_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."1"."R"."01"."00"."030"." "."2".str_pad($n_inscricao_empresa,15,"0",STR_PAD_LEFT).str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',14,'0',STR_PAD_LEFT).$agencia.$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT).str_pad('0',7,'0',STR_PAD_LEFT)."0".str_pad($empresa, 30).str_pad('',40).str_pad('',40)."00000095".$data_geracao.str_pad('0',8,'0',STR_PAD_LEFT).str_pad(' ',25);


			$escreve_arq = fwrite($abrir, $header_arquivo."\r\n" );//Arquivo de Header
			$escreve_lote = fwrite($abrir, $header_lote."\r\n" );//Arquivo de Lote


			$rs_data = date("dmY",strtotime($boleto->ddatavencimento));
			$dia=substr($boleto->ddatavencimento,8,2);
			$mes=substr($boleto->ddatavencimento,5,2);
			$ano=substr($boleto->ddatavencimento,0,4);
			$vencimento = $rs_data;
			$nosso_numero = $boleto->cnumerodocumento;

			$documento = preg_replace('@[./-]@','',$cliente->ccpfcnpj);
			$cliente = str_pad($boleto->csacado,40);

			// Verifica Pessoa Fisica / Juridica
			if(strlen($documento)<=11){
			    $tipo_de_inscricao = 1;
			}elseif(strlen($documento)>11){
			    $tipo_de_inscricao = 2;
			}
			//
			$endereco = str_pad((strtoupper($enderecos[0]['cdescrilog']." ".$enderecos[0]['cnumero']." ".$enderecos[0]['ccomplemento'])),40);
			$bairro = str_pad(strtoupper($enderecos[0]['cdescribai']),15);
			$cep = preg_replace('@[-]@','',$enderecos[0]['ccep_log'] ? $enderecos[0]['ccep_log'] : $enderecos[0]['ccep_loc']);
			$cidade = str_pad(strtoupper($enderecos[0]['cdescriloc']),15);
			$estado = str_pad(strtoupper($enderecos[0]['cdescriuf']),2);
			$email = str_pad(strtoupper(''),50);
			//
			$valor = explode('.',number_format($boleto->nvalor,2,".",""));
			$valor_nominal = str_pad($valor[0],13,"0",STR_PAD_LEFT);
			$valor_decimal = str_pad($valor[1],2,"0");
			$valor_titulo = number_format($boleto->nvalor,2,".","");

			$linha_p = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."3"."00001"."P"." "."01".$agencia.$dv_agencia.str_pad($cod_convenio,6,"0",STR_PAD_LEFT)."00000000000"."14".str_pad($nosso_numero,15,"0",STR_PAD_LEFT)."1"."1"."2"."2"."0"."B".str_pad($nosso_numero,10,"0",STR_PAD_LEFT)."    ".$vencimento.$valor_nominal.$valor_decimal."00000"."0"."02"."N".$data_emissao."3"."00000000".$juros_mora.$juros_decimal."0"."00000000".$desconto_mora.$desconto_decimal.$iof_mora.$iof_decimal.$abatimento_mora.$abatimento_decimal."BOLETO NUMERO".str_pad($nosso_numero,9)."XXX".$cod_protesto.$n_dias_protesto.$cod_baixa_devolucao.$n_dias_baixa_devolucao.$cod_moeda.str_pad('',10,'0',STR_PAD_LEFT)." ";

			$linha_q = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."3"."00002"."Q"." "."01".$tipo_de_inscricao.str_pad($documento,15,"0",STR_PAD_LEFT).strtoupper($cliente).$endereco.$bairro.$cep.$cidade.$estado."0"."000000000000000".str_pad(' ',40)."000".str_pad(' ',20).str_pad(' ',8);

			//$linha_r = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."3"."00003"."R"." "."01".str_pad('0',1).str_pad('0',8).str_pad('0',13).str_pad('0',1).str_pad('0',8).str_pad('0',13).str_pad('0',1).str_pad('0',8).str_pad('0',13).str_pad(' ',10).str_pad(' ',40).str_pad(' ',40).str_pad(' ',50).str_pad(' ',11);

			//$linha_s = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."3"."00004"."S"." "."01"."3".str_pad($mensagem_3,40).str_pad($mensagem_6,40).str_pad($mensagem_7,40).str_pad($mensagem_8,40).str_pad(' ',40).str_pad(' ',22);

			$escreve_p = fwrite($abrir, $linha_p."\r\n" );//Arquivo de Lote
			$escreve_q = fwrite($abrir, $linha_q."\r\n" );//Arquivo de Lote

			$soma_valores = explode('.', $valor_titulo);

			////$trailer_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."5".str_pad('',9).str_pad((($num_remessa_financeiro * 4) + 2),6,"0",STR_PAD_LEFT).str_pad($num_remessa_financeiro,6,"0",STR_PAD_LEFT).str_pad($soma_valores[0],15,'0',STR_PAD_LEFT).str_pad($soma_valores[1],2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad(' ',31).str_pad(' ',117);
			//$trailer_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."5".str_pad(' ',9).str_pad((($nosso_numero * 4) + 2),6,"0",STR_PAD_LEFT).str_pad($nosso_numero,6,"0",STR_PAD_LEFT).str_pad($soma_valores[0],15,'0',STR_PAD_LEFT).str_pad($soma_valores[1],2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad(' ',31).str_pad(' ',117);

			$trailer_lote = str_pad($banco,3,'0',STR_PAD_LEFT)."0001"."5".str_pad(' ',9)."000004"."000001".str_pad($soma_valores[0],15,'0',STR_PAD_LEFT).str_pad($soma_valores[1],2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad('0',6,'0',STR_PAD_LEFT).str_pad('0',15,'0',STR_PAD_LEFT).str_pad('0',2,'0',STR_PAD_LEFT).str_pad(' ',31).str_pad(' ',117);

			$trailer_arquivo = str_pad($banco,3,'0',STR_PAD_LEFT)."9999"."9".str_pad(' ',9)."000001"."000001".str_pad(' ',6).str_pad(' ',205);

			$escreve_tlote = fwrite($abrir, $trailer_lote."\r\n" );//Arquivo de Trailer
			$escreve_tarq = fwrite($abrir, $trailer_arquivo);//Arquivo de Trailer

			// Salva Arquivo
			$fecha_arquivo = fclose($abrir);

			/* Enviar arquivo para o server final */

		}

		/**
		* Função que pega um boleto através do hash dele
		* @param string hash do boleto
		* @return object boleto
		* @access public
		*/

		public function getByHash($hash){
			$this->db->where('chash', $hash);
			$boleto = $this->db->get(self::$_table)->row();
			return $boleto;
		}

		/**
		* Função que concilia um boleto
		* @param string número do documento
		* @param date data de pagamento
		* @access public
		*/		

		public function conciliar($numero_documento, $data_pagamento){
			$this->db->where('cnumerodocumento', $numero_documento);
			$boleto = $this->db->get('cadbol')->row();
			if (!$boleto){
				return false;
			}
			$this->db->where('nidcadbol', $boleto->nidcadbol);
			$data = array('ddataconciliacao'=>$data_pagamento, 'ddatabaixa'=>date('Y-m-d'), 'nconciliado'=>1);
			$this->db->update('cadbol', $data);
			return true;
		}

		/**
		* Função que paga um boleto
		* @param string número do documento
		* @param date data de pagamento
		* @access public
		*/		

		public function pagar($numero_documento, $data_pagamento){
			$this->db->where('cnumerodocumento', $numero_documento);
			$boleto = $this->db->get('cadbol')->row();
			if (!$boleto){
				return false;
			}
			$this->db->where('nidcadbol', $boleto->nidcadbol);
			$data = array('ddatapagamento'=>$data_pagamento);
			$this->db->update('cadbol', $data);
			$data = array('ddatapagamento'=>$data_pagamento,'ddatastatus'=>date('Y-m-d'), 'nidtbxstp'=>Parametro_model::get('id_status_pagamento_pago'));
			$this->db->where('nidcadfin', $boleto->nidcadfin);
			$this->db->update('cadfin', $data);
			return true;
		}

		/**
		* Função que retorna os boletos conciliados
		* @param date data no formato user inicial
		* @param date data no formato user final
		* @access public
		*/

		public function getProvisao($data_inicial = false, $data_final = false){
			
			if ($data_inicial){
				$this->db->where('ddatabaixa >=', toDbDate($data_inicial));
			}
			if ($data_final){
				$this->db->where('ddatabaixa <=', toDbDate($data_final));
			}

			$result_dirty = $this->db->get('cadbol')->result();

			$result = array();

			foreach ($result_dirty as $boleto){

				$this->db->where('nidcadfin', $boleto->nidcadfin);

				$boleto->fin = $this->db->get('cadfin')->row();

				$this->db->where('nidcadloc', $boleto->fin->nidcadloc);

				$boleto->loc = $this->db->get('cadloc')->row();

				$this->db->where('nidcadimo', $boleto->loc->nidcadimo);

				$boleto->imo = $this->db->get('cadimo')->row();

				$result[] = $boleto;

			}

			return $result;


		}

		/**
		* Função que retorna os boletos provisionados
		* @param date data no formato user inicial
		* @param date data no formato user final
		* @access public
		*/

		public function getConciliados($data_inicial = false, $data_final = false){
			
			if ($data_inicial){
				$this->db->where('ddataconciliado >=', toDbDate($data_inicial));
			}
			if ($data_final){
				$this->db->where('ddataconciliado <=', toDbDate($data_final));
			}

			$this->db->where('nconciliado', 1);

			$result_dirty = $this->db->get('cadbol')->result();

			$result = array();

			foreach ($result_dirty as $boleto){

				$this->db->where('nidcadfin', $boleto->nidcadfin);

				$boleto->fin = $this->db->get('cadfin')->row();

				$this->db->where('nidcadloc', $boleto->fin->nidcadloc);

				$boleto->loc = $this->db->get('cadloc')->row();

				$this->db->where('nidcadimo', $boleto->loc->nidcadimo);

				$boleto->imo = $this->db->get('cadimo')->row();

				$result[] = $boleto;

			}

			return $result;


		}

	}