<?php

class Conciliacao extends MY_Controller {

	public function __construct(){
	
		parent::__construct();
	
		$this->load->model('fin/Financeiro_model');
		$this->load->model('fin/Boleto_model');

	}

	/**
	* Abre a tela para formulário de conciliação
	*/

	public function index(){
		$this->visualizar();
	}

	public function visualizar(){
		$this->title = "Conciliar boletos bancários CEF - Yoopay - Soluções Tecnológicas";
		$this->loadview('fin/conciliar_boleto');
	}

	public function conciliar(){
		
		$config['upload_path'] = 'tmp/conciliacao/';
		$config['allowed_types'] = '*';
		$config['max_size']	= '3072';

		$this->load->library('upload', $config);

		if ( $this->upload->do_upload()){
			$fileinfo = $this->upload->data();
			if ($fileinfo['file_ext'] == ".txt"){
				$this->session->set_flashdata('sucesso', 'Arquivo enviado com sucesso');
				$this->concilia_cobranca($fileinfo);
			} elseif ($fileinfo['file_ext'] == ".ret"){
				$this->session->set_flashdata('sucesso', 'Arquivo enviado com sucesso');
				$this->retorno_cnab240($fileinfo);
			} else {
				$this->session->set_flashdata('erro', 'Erro no envio do arquivo (obrigatório ser .txt ou .ret e possuir menos de 3mb)');
			}
		} else {
			$this->session->set_flashdata('erro', 'Erro no envio do arquivo (obrigatório ser .txt ou .ret e possuir menos de 3mb)');
		}
		redirect(makeUrl("fin", "conciliacao", "visualizar"));
	}

	/* Função que processa o arquivo de retorno em formato txt */

	private function concilia_cobranca($fileinfo){
		
		$full_path = $fileinfo['full_path'];
		$arrArquivo = file($full_path);
		
		//linha atual
		$i = 0;
		$numerolinhas = count($arrArquivo);
		unset($arrArquivo[$numerolinhas]);
		unset($arrArquivo[$numerolinhas-1]);
		unset($arrArquivo[0]);
		unset($arrArquivo[1]);
		unset($arrArquivo[2]);
		unset($arrArquivo[3]);
		unset($arrArquivo[4]);
		sort($arrArquivo);
		$numerolinhas2 = count($arrArquivo);
		//echo "<br>Numero de Linhas ==> ".$numerolinhas2."<br>";

		//retira de um vez as quebras de linhas, retorno de carros e linhas vazias
		foreach($arrArquivo as $linhas){

		//retira \r
		$linhas = str_replace(chr(13), "", $linhas);

		//retira \n
		$linhas = str_replace(chr(10), "", $linhas);

		//apaga as linhas vazias
		if(empty($linhas)){unset($arrArquivo[$i]);}

		//echo($linhas."<br>");
		//echo($linhas);

		//proxima linha
		$i++;
		}
		// Vao ao inicio do Arquivo
		reset($arrArquivo);
		//Conta a linhas
		$numerolinhas3=count($arrArquivo);
		//echo "Numero de Linhas2 ==> ".$numerolinhas3."<br>";
		// Retira as linhas sem informações
		for($x=0; $x<$numerolinhas3; $x++){
			if(trim(substr($arrArquivo[$x],1,4))===""){unset($arrArquivo[$x]);}
		}

		// Vao ao inicio do Arquivo
		sort($arrArquivo);
		//conta quantos registros o arquivo tem
		$nRegistros = count($arrArquivo);
		//navega entre os registros e os formata em arrays (Detalhes do Boleto)
		for($j=0; $j<$nRegistros; $j++){

		//obtém o registro atual
		//$registroAtual[$j] = $arrArquivo[$j];

		//$arrArquivoRetorno['REGISTRO'.$j]['Boleto'] = retornaTrecho($arrArquivo[$j], 8, 11);
		//$arrArquivoRetorno['REGISTRO'.$j]['VlrBoleto'] = retornaTrecho($arrArquivo[$j], 90, 12);
		//$arrArquivoRetorno['REGISTRO'.$j]['VctoBoleto'] = retornaTrecho($arrArquivo[$j], 105, 11);
		//$arrArquivoRetorno['REGISTRO'.$j]['Situacao'] = retornaTrecho($arrArquivo[$j], 120, 10);
		//$arrArquivoRetorno['REGISTRO'.$j]['DtaRegistro'] = retornaTrecho($arrArquivo[$j], 160, 11);
		//$arrArquivoRetorno['REGISTRO'.$j]['DtaEntrada'] = retornaTrecho($arrArquivo[$j], 178, 11);
		//
		$boleto = $this->retornaTrecho($arrArquivo[$j], 8, 11);
		$vlrboleto = $this->retornaTrecho($arrArquivo[$j], 90, 12);
		$dta_pgto = substr($this->retornaTrecho($arrArquivo[$j], 105, 11),7,4)."-";
		$dta_pgto .= substr($this->retornaTrecho($arrArquivo[$j], 105, 11),4,2)."-";
		$dta_pgto .= substr($this->retornaTrecho($arrArquivo[$j], 105, 11),1,2);
		$situacao = $this->retornaTrecho($arrArquivo[$j], 120, 10);
		$dtaregistro = substr($this->retornaTrecho($arrArquivo[$j], 160, 11),7,4)."-";
		$dtaregistro .= substr($this->retornaTrecho($arrArquivo[$j], 160, 11),4,2)."-";
		$dtaregistro .= substr($this->retornaTrecho($arrArquivo[$j], 160, 11),1,2);
		
		$this->Boleto_model->conciliar($boleto, $dta_pgto);

		@unlink($full_path);

		}

	}

	/* Função que processa o arquivo de retorno em formato ret */

	private function retorno_cnab240($fileinfo){
		$full_path = $fileinfo['full_path'];
		$arrArquivo = file($full_path);

		//linha atual
		$i = 0;

		//retira de um vez as quebras de linhas, retorno de carros e linhas vazias
		foreach($arrArquivo as $linhas){

		//retira \r
		$linhas = str_replace(chr(13), "", $linhas);

		//retira \n
		$linhas = str_replace(chr(10), "", $linhas);

		//apaga as linhas vazias
		if(empty($linhas)){unset($arrArquivo[$i]);}

		//echo($linhas);

		//proxima linha
		$i++;
		}

		//HEADER DE ARQUIVO:
		$HA = $arrArquivo[0];

		//separa o header do arquivo em seus pedaços
		$arrArquivoRetorno['HA']['ContrBanco'] = $this->retornaTrecho($HA, 1, 3);
		$arrArquivoRetorno['HA']['ContrLote'] = $this->retornaTrecho($HA, 4, 4);
		$arrArquivoRetorno['HA']['ContrRegistro'] = $this->retornaTrecho($HA, 8, 1);
		$arrArquivoRetorno['HA']['CNAB1'] = $this->retornaTrecho($HA, 9, 9);
		$arrArquivoRetorno['HA']['EmpInscTipo'] = $this->retornaTrecho($HA, 18, 1);
		$arrArquivoRetorno['HA']['EmpInscNum'] = $this->retornaTrecho($HA, 19, 14);
		$arrArquivoRetorno['HA']['EmpConvenio'] = $this->retornaTrecho($HA, 33, 20);
		$arrArquivoRetorno['HA']['EmpContCorAgenCod'] = $this->retornaTrecho($HA, 53, 5);
		$arrArquivoRetorno['HA']['EmpContCorAgenDV'] = $this->retornaTrecho($HA, 58, 1);
		$arrArquivoRetorno['HA']['EmpContCorContNum'] = $this->retornaTrecho($HA, 59, 12);
		$arrArquivoRetorno['HA']['EmpContCorContDV'] = $this->retornaTrecho($HA, 71, 1);
		$arrArquivoRetorno['HA']['EmpContCorDV'] = $this->retornaTrecho($HA, 72, 1);
		$arrArquivoRetorno['HA']['EmpNome'] = $this->retornaTrecho($HA, 73, 30);
		$arrArquivoRetorno['HA']['NomeBanco'] = $this->retornaTrecho($HA, 103, 30);
		$arrArquivoRetorno['HA']['CNAB2'] = $this->retornaTrecho($HA, 133, 10);
		$arrArquivoRetorno['HA']['ArqCodigo'] = $this->retornaTrecho($HA, 143, 1);
		$arrArquivoRetorno['HA']['ArqDataGeracao'] = $this->retornaTrecho($HA, 144, 8);
		$arrArquivoRetorno['HA']['ArqHoraGeracao'] = $this->retornaTrecho($HA, 152, 6);
		$arrArquivoRetorno['HA']['ArqSequencia'] = $this->retornaTrecho($HA, 158, 6);
		$arrArquivoRetorno['HA']['ArqLayout'] = $this->retornaTrecho($HA, 164, 3);
		$arrArquivoRetorno['HA']['ArqDensidade'] = $this->retornaTrecho($HA, 167, 5);
		$arrArquivoRetorno['HA']['ReservadoBanco'] = $this->retornaTrecho($HA, 172, 20);
		$arrArquivoRetorno['HA']['ReservadoEmpresa'] = $this->retornaTrecho($HA, 192, 20);
		$arrArquivoRetorno['HA']['CNAB3'] = $this->retornaTrecho($HA, 212, 29);

		//número total de linhas do arquivo
		$nTotalLinhas = count($arrArquivo);

		//TRAILER DE ARQUIVO:
		$TA = $arrArquivo[$nTotalLinhas-1];

		//separa o trailer do arquivo em seus pedaços
		$arrArquivoRetorno['TA']['ContrBanco'] = $this->retornaTrecho($TA, 1, 3);
		$arrArquivoRetorno['TA']['ContrLote'] = $this->retornaTrecho($TA, 4, 4);
		$arrArquivoRetorno['TA']['ContrRegistro'] = $this->retornaTrecho($TA, 8, 1);
		$arrArquivoRetorno['TA']['CNAB1'] = $this->retornaTrecho($TA, 9, 9);
		$arrArquivoRetorno['TA']['TotaisQtdeLotes'] = $this->retornaTrecho($TA, 18, 6);
		$arrArquivoRetorno['TA']['TotaisQtdeRegistros'] = $this->retornaTrecho($TA, 24, 6);
		$arrArquivoRetorno['TA']['TotaisQtdeConcil'] = $this->retornaTrecho($TA, 30, 6);
		$arrArquivoRetorno['TA']['CNAB2'] = $this->retornaTrecho($TA, 36, 205);

		//retira o header e trailer de arquivo para ficar apenas os lotes
		unset($arrArquivo[0]);
		unset($arrArquivo[$nTotalLinhas-1]);

		//ordena o array $arrArquivo
		sort($arrArquivo);

		//HEADER DO LOTE:
		$HL = $arrArquivo[0];

		//separa o header do lote em seus pedaços
		$arrArquivoRetorno['HL']['ContrBanco'] = $this->retornaTrecho($HL, 1, 3);
		$arrArquivoRetorno['HL']['ContrLote'] = $this->retornaTrecho($HL, 4, 4);
		$arrArquivoRetorno['HL']['ContrRegistro'] = $this->retornaTrecho($HL, 8, 1);
		$arrArquivoRetorno['HL']['ServOperacao'] = $this->retornaTrecho($HL, 9, 1);
		$arrArquivoRetorno['HL']['ServServico'] = $this->retornaTrecho($HL, 10, 2);
		$arrArquivoRetorno['HL']['ServFormLanca'] = $this->retornaTrecho($HL, 12, 2);
		$arrArquivoRetorno['HL']['ServLayout'] = $this->retornaTrecho($HL, 14, 3);
		$arrArquivoRetorno['HL']['CNAB1'] = $this->retornaTrecho($HL, 17, 1);
		$arrArquivoRetorno['HL']['EmpInscTipo'] = $this->retornaTrecho($HL, 18, 1);
		//$arrArquivoRetorno['HL']['EmpInscNum'] = retornaTrecho($HL, 19, 14);
		$arrArquivoRetorno['HL']['EmpInscNum'] = $this->retornaTrecho($HL, 20, 14);
		//$arrArquivoRetorno['HL']['EmpConvenio'] = retornaTrecho($HL, 33, 20);
		$arrArquivoRetorno['HL']['EmpConvenio'] = $this->retornaTrecho($HL, 34, 20);
		//$arrArquivoRetorno['HL']['EmpContCorAgenCod'] = retornaTrecho($HL, 53, 5);
		$arrArquivoRetorno['HL']['EmpContCorAgenCod'] = $this->retornaTrecho($HL, 54, 5);
		//$arrArquivoRetorno['HL']['EmpContCorDV'] = retornaTrecho($HL, 58, 1);
		$arrArquivoRetorno['HL']['EmpContCorDV'] = $this->retornaTrecho($HL, 59, 1);
		//$arrArquivoRetorno['HL']['EmpContCorContNum'] = retornaTrecho($HL, 59, 12);
		$arrArquivoRetorno['HL']['EmpContCorContNum'] = $this->retornaTrecho($HL, 60, 12);
		//$arrArquivoRetorno['HL']['EmpContCorContDV'] = retornaTrecho($HL, 71, 1);
		$arrArquivoRetorno['HL']['EmpContCorContDV'] = $this->retornaTrecho($HL, 72, 1);
		//$arrArquivoRetorno['HL']['EmpContCorDV'] = retornaTrecho($HL, 72, 1);
		$arrArquivoRetorno['HL']['EmpContCorDV'] = $this->retornaTrecho($HL, 73, 1);
		//$arrArquivoRetorno['HL']['EmpNome'] = retornaTrecho($HL, 73, 30);
		$arrArquivoRetorno['HL']['EmpNome'] = $this->retornaTrecho($HL, 74, 30);
		//$arrArquivoRetorno['HL']['Informacao1'] = retornaTrecho($HL, 103, 40);
		//$arrArquivoRetorno['HL']['EmpEndLogra'] = retornaTrecho($HL, 143, 30);
		//$arrArquivoRetorno['HL']['EmpEndNum'] = retornaTrecho($HL, 173, 5);
		//$arrArquivoRetorno['HL']['EmpEndComple'] = retornaTrecho($HL, 178, 15);
		//$arrArquivoRetorno['HL']['EmpEndCidade'] = retornaTrecho($HL, 193, 20);
		//$arrArquivoRetorno['HL']['EmpEndCEP'] = retornaTrecho($HL, 213, 5);
		//$arrArquivoRetorno['HL']['EmpEndCompleCEP'] = retornaTrecho($HL, 218, 3);
		//$arrArquivoRetorno['HL']['EmpEndEstado'] = retornaTrecho($HL, 221, 2);
		$arrArquivoRetorno['HL']['Informacao1'] = $this->retornaTrecho($HL, 104, 30);
		$arrArquivoRetorno['HL']['Informacao2'] = $this->retornaTrecho($HL, 144, 40);
		$arrArquivoRetorno['HL']['NumeroRetorno'] = $this->retornaTrecho($HL, 184, 8);
		$arrArquivoRetorno['HL']['DtaGravRetorno'] = $this->retornaTrecho($HL, 192, 8);
		$arrArquivoRetorno['HL']['DtaCredito'] = $this->retornaTrecho($HL, 200, 8);
		$arrArquivoRetorno['HL']['CNAB2'] = $this->retornaTrecho($HL, 208, 8);


		//número total de linhas do arquivo
		$nTotalLinhas = count($arrArquivo);

		//TRAILER DO LOTE:
		$TL = $arrArquivo[$nTotalLinhas-1];

		//separa o trailer do lote em seus pedaços
		$arrArquivoRetorno['TL']['ContrBanco'] = $this->retornaTrecho($TL, 1, 3);
		$arrArquivoRetorno['TL']['ContrLote'] = $this->retornaTrecho($TL, 4, 4);
		$arrArquivoRetorno['TL']['ContrRegistro'] = $this->retornaTrecho($TL, 8, 1);
		$arrArquivoRetorno['TL']['CNAB1'] = $this->retornaTrecho($TL, 9, 9);
		$arrArquivoRetorno['TL']['TotaisQtdeRegistros'] = $this->retornaTrecho($TL, 18, 6);
		$arrArquivoRetorno['TL']['TotaisValor'] = $this->addDecimal($this->retornaTrecho($TL, 24, 18), 2);
		$arrArquivoRetorno['TL']['TotaisQtdeMoeda'] = $this->retornaTrecho($TL, 42, 18);
		$arrArquivoRetorno['TL']['NumAvisoDebito'] = $this->retornaTrecho($TL, 60, 6);
		$arrArquivoRetorno['TL']['CNAB2'] = $this->retornaTrecho($TL, 66, 165);
		$arrArquivoRetorno['TL']['Ocorrencias'] = $this->retornaTrecho($TL, 231, 10);

		//retira o header e trailer do lote para ficar apenas os registros
		unset($arrArquivo[0]);
		unset($arrArquivo[$nTotalLinhas-1]);

		//ordena o array $arrArquivo
		sort($arrArquivo);

		//conta quantos registros o arquivo tem
		$nRegistros = count($arrArquivo);

		//navega entre os registros e os formata em arrays (SEGMENTO J)
		for($i=0; $i<$nRegistros; $i++){

		//obtém o registro atual
		$registroAtual = $arrArquivo[$i];

		//cadastra cada registro separadamente com seus detalhes
		// Registro Tipo T e U
		$arrArquivoRetorno['REGISTRO'.$i]['NrBanco'] = $this->retornaTrecho($registroAtual, 1, 3);
		$arrArquivoRetorno['REGISTRO'.$i]['NrLote'] = $this->retornaTrecho($registroAtual, 4, 4);
		$arrArquivoRetorno['REGISTRO'.$i]['TpRegistro'] = $this->retornaTrecho($registroAtual, 8, 1);
		$arrArquivoRetorno['REGISTRO'.$i]['NrRegNoLote'] = $this->retornaTrecho($registroAtual, 9, 5);
		$arrArquivoRetorno['REGISTRO'.$i]['CodSegNoReg'] = $this->retornaTrecho($registroAtual, 14, 1);
		$arrArquivoRetorno['REGISTRO'.$i]['CNAB1'] = $this->retornaTrecho($registroAtual, 15, 1);
		$arrArquivoRetorno['REGISTRO'.$i]['TpMovRetorno'] = $this->retornaTrecho($registroAtual, 16, 2);

		if($this->retornaTrecho($registroAtual, 16, 2)=='06'){

		//echo "Mostra  TpMovRetorno ==> ".retornaTrecho($registroAtual, 16, 2)."<br>";

			if($this->retornaTrecho($registroAtual, 14, 1)=='T'){

				//echo "Mostra  TpRegistro ==> ".retornaTrecho($registroAtual, 14, 1)."<br>";

				$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa1'] = $this->retornaTrecho($registroAtual, 18, 5);
				$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa2'] = $this->retornaTrecho($registroAtual, 23, 1);
				$arrArquivoRetorno['REGISTRO'.$i]['CodConvNoBco'] = $this->retornaTrecho($registroAtual, 24, 6);
				$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa3'] = $this->retornaTrecho($registroAtual, 30, 3);
				$arrArquivoRetorno['REGISTRO'.$i]['NrBcoSacado'] = $this->retornaTrecho($registroAtual, 33, 3);
				$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa4'] = $this->retornaTrecho($registroAtual, 36, 4);
				$arrArquivoRetorno['REGISTRO'.$i]['ModNNumero'] = $this->retornaTrecho($registroAtual, 40, 2);
				$arrArquivoRetorno['REGISTRO'.$i]['IdTitNoBco'] = $this->retornaTrecho($registroAtual, 42, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa5'] = $this->retornaTrecho($registroAtual, 57, 1);
				$arrArquivoRetorno['REGISTRO'.$i]['CodCarteira'] = $this->retornaTrecho($registroAtual, 58, 1);
				$arrArquivoRetorno['REGISTRO'.$i]['NrDocDeCobranca'] = $this->retornaTrecho($registroAtual, 59, 11);
				$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa6'] = $this->retornaTrecho($registroAtual, 70, 4);
				$arrArquivoRetorno['REGISTRO'.$i]['PagDtVctoTit'] = $this->retornaTrecho($registroAtual, 74, 8);
				$arrArquivoRetorno['REGISTRO'.$i]['PagVlrTit'] = $this->retornaTrecho($registroAtual, 82, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['PagCodBco'] = $this->retornaTrecho($registroAtual, 97, 3);
				$arrArquivoRetorno['REGISTRO'.$i]['PagCodAgencia'] = $this->retornaTrecho($registroAtual, 100, 5);
				$arrArquivoRetorno['REGISTRO'.$i]['PagDigitoAg'] = $this->retornaTrecho($registroAtual, 105, 1);
				$arrArquivoRetorno['REGISTRO'.$i]['PagIdTitEmpresa'] = $this->retornaTrecho($registroAtual, 106, 25);
				$arrArquivoRetorno['REGISTRO'.$i]['PagCodMoeda'] = $this->retornaTrecho($registroAtual, 131, 2);
				$arrArquivoRetorno['REGISTRO'.$i]['TpInscSacado'] = $this->retornaTrecho($registroAtual, 133, 1);
				$arrArquivoRetorno['REGISTRO'.$i]['NrInscSacado'] = $this->retornaTrecho($registroAtual, 134, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['NomeSacado'] = $this->retornaTrecho($registroAtual, 149, 40);
				$arrArquivoRetorno['REGISTRO'.$i]['CNAB2'] = $this->retornaTrecho($registroAtual, 189, 10);
				$arrArquivoRetorno['REGISTRO'.$i]['VlTarifa'] = $this->retornaTrecho($registroAtual, 199, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['MotOcorrencia'] = $this->retornaTrecho($registroAtual, 214, 10);
				$arrArquivoRetorno['REGISTRO'.$i]['CNAB3'] = $this->retornaTrecho($registroAtual, 224, 17);
			}elseif($this->retornaTrecho($registroAtual, 14, 1)=='U'){

				//echo "Mostra  TpRegistro ==> ".retornaTrecho($registroAtual, 14, 1)."<br>";

				$arrArquivoRetorno['REGISTRO'.$i]['VlrAcrescimos'] = $this->retornaTrecho($registroAtual, 18, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['VlrDoDesc'] = $this->retornaTrecho($registroAtual, 33, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['VlrAbatimento'] = $this->retornaTrecho($registroAtual, 48, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['VlrIOF'] = $this->retornaTrecho($registroAtual, 63, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['PagVlrTitulo'] = $this->retornaTrecho($registroAtual, 78, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['PagVlrCredito'] = $this->retornaTrecho($registroAtual, 93, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['PagAcrescimo'] = $this->retornaTrecho($registroAtual, 108, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['PagCreditos'] = $this->retornaTrecho($registroAtual, 123, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['DtOcorrencia'] = $this->retornaTrecho($registroAtual, 138, 8);
				$arrArquivoRetorno['REGISTRO'.$i]['DtaCredito'] = $this->retornaTrecho($registroAtual, 146, 8);
				$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa1'] = $this->retornaTrecho($registroAtual, 154, 4);
				$arrArquivoRetorno['REGISTRO'.$i]['DtaDebitoTar'] = $this->retornaTrecho($registroAtual, 158, 8);
				$arrArquivoRetorno['REGISTRO'.$i]['CodSacadoBco'] = $this->retornaTrecho($registroAtual, 166, 15);
				$arrArquivoRetorno['REGISTRO'.$i]['UsoCaixa2'] = $this->retornaTrecho($registroAtual, 181, 30);
				$arrArquivoRetorno['REGISTRO'.$i]['CodBcoCompensado'] = $this->retornaTrecho($registroAtual, 211, 3);
				$arrArquivoRetorno['REGISTRO'.$i]['NrNossoNumeroBcoComp'] = $this->retornaTrecho($registroAtual, 214, 20);
				$arrArquivoRetorno['REGISTRO'.$i]['CNAB2'] = $this->retornaTrecho($registroAtual, 234, 7);
			}

			if(($this->retornaTrecho($registroAtual, 14, 1)=='U') || ($this->retornaTrecho($registroAtual, 14, 1)=='T')){
				if($this->retornaTrecho($registroAtual, 14, 1)=='T'){
					$boleto = $this->retornaTrecho($registroAtual, 46, 11);
					$VlrTitulo = $this->retornaTrecho($registroAtual, 82, 15);
					//echo "Mostra  NrBoleto ==> ".$boleto."<br>";
					//echo "Mostra  VlrTitulo ==> ".$VlrTitulo."<br>";
				}elseif($this->retornaTrecho($registroAtual, 14, 1)=='U'){
					//echo "Mostra  VlrTitulo ==> ".$VlrTitulo."<br>";
					//echo "Mostra  VlrTitulo ==> ".retornaTrecho($registroAtual, 93, 15)."<br>";

					if($VlrTitulo == $this->retornaTrecho($registroAtual, 93, 15)){
						//echo "Mostra  Dta_Pgto ==> ".retornaTrecho($registroAtual, 146, 8)."<br>";
						$dta_pgto = substr($this->retornaTrecho($registroAtual, 146, 8),4,4)."-";
						$dta_pgto .= substr($this->retornaTrecho($registroAtual, 146, 8),2,2)."-";
						$dta_pgto .= substr($this->retornaTrecho($registroAtual, 146, 8),0,2);
						$situacao = "LIQUIDA";
						//echo "Mostra  DtaRegistro ==> ".retornaTrecho($registroAtual, 138, 8)."<br>";
						$dtaregistro = substr($this->retornaTrecho($registroAtual, 138, 8),4,4)."-";
						$dtaregistro .= substr($this->retornaTrecho($registroAtual, 138, 8),2,2)."-";
						$dtaregistro .= substr($this->retornaTrecho($registroAtual, 138, 8),0,2);

						$this->Boleto_model->pagar($boleto, $dta_pgto);
						
						$boleto = '';
						$VlrTitulo = '';
					}
				}
			}
		}

	}

	}

	private function retornaTrecho($var, $inicio, $nDigitos){
		//retorna a parte solicitada da string $var (a contagem inicia-se em zero)
		return substr($var, $inicio-2, $nDigitos);
	}

	private function addDecimal($var, $casasDecimais){
		//retorna a string formatada
		return substr_replace($var, ".", -$casasDecimais, 0);
	}

	/* Relatório de boletos conciliados - Pesquisa */

	public function conciliados(){
		if ($this->input->get()){
			/* Gerar relatório */
			$this->gerarRelatorioConciliados();
			return;
		}

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('app/js/financeiro/relatorioconciliados.js?v='.rand(1,9999));

		$this->title = 'Relatório de boletos conciliados - CEF - Yoopay - Soluções Tecnológicas';

		$this->loadview('fin/relatorio_conciliados_pesquisa');
	}

	/* Relatório de boletos pagos */

	public function provisao(){
		if ($this->input->get()){
			/* Gerar relatório */
			$this->gerarRelatorioProvisao();
			return;
		}

		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');

		$this->enqueue_script('app/js/financeiro/relatorioprovisao.js?v='.rand(1,9999));

		$this->title = 'Relatório de boletos provisionados - CEF - Yoopay - Soluções Tecnológicas';

		$this->loadview('fin/relatorio_provisao_pesquisa');
	}

	/* Relatório de boletos em provisão */

	private function gerarRelatorioConciliados(){
		$data_inicial = $this->input->get('datan');
		$data_final = $this->input->get('dataf');
		$this->data['boletos'] = $this->Boleto_model->getConciliados($data_inicial, $data_final);
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$this->enqueue_script('app/js/locacaotemporada/relatorioconciliados_lista.js?v='.rand(1,9999));
		$this->title = 'Relatório de boletos provisionados - CEF - Yoopay - Soluções Tecnológicas';
		$this->loadview('fin/relatorio_provisao');		
	}

	/* Relatório de boletos conciliados */

	private function gerarRelatorioProvisao(){
		$data_inicial = $this->input->get('datan');
		$data_final = $this->input->get('dataf');
		$this->data['boletos'] = $this->Boleto_model->getProvisao($data_inicial, $data_final);
		$this->enqueue_style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		$this->enqueue_script('//code.jquery.com/ui/1.11.4/jquery-ui.js');
		$this->enqueue_script('vendor/jquery-ui/ui/datepicker.js');
		$this->enqueue_script('app/js/locacaotemporada/relatorioconciliados_lista.js?v='.rand(1,9999));
		$this->title = 'Relatório de boletos provisionados - CEF - Yoopay - Soluções Tecnológicas';
		$this->loadview('fin/relatorio_provisao');		
	}

}