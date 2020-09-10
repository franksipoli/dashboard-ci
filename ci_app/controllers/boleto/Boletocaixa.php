<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boletocaixa extends CI_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->helper('url');

		$this->load->helper('custom_helper');

		$this->load->model('fin/Boleto_model');

	}

	public function index(){

		$codigo = $this->input->get('h');

		$boleto = $this->Boleto_model->getByHash($codigo);

		if (!$boleto){
			die('Boleto não encontrado');
		}

		$data_to_view = array();

		// DADOS DO BOLETO PARA O SEU CLIENTE
		$data_to_view['dias_de_prazo_para_pagamento'] = $dias_de_prazo_para_pagamento = Parametro_model::get('boleto_dias_de_prazo_para_pagamento');
		$data_to_view['taxa_boleto'] = $taxa_boleto = Parametro_model::get('boleto_taxa_boleto');
		$data_to_view['data_venc'] = $data_venc = toUserDate($boleto->ddatavencimento);  // Prazo de X dias OU informe data: "13/04/2006";
		$data_to_view['valor_cobrado'] = $valor_cobrado = $boleto->nvalor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$data_to_view['valor_cobrado'] = $valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$data_to_view['valor_boleto'] = $valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

		// Composição Nosso Numero - CEF SIGCB
		$data_to_view['nosso_numero1'] = $dadosboleto["nosso_numero1"] = "000"; // tamanho 3
		$data_to_view['nosso_numero_const1'] = $dadosboleto["nosso_numero_const1"] = "2"; //constanto 1 , 1=registrada , 2=sem registro
		$data_to_view['nosso_numero2'] = $dadosboleto["nosso_numero2"] = "000"; // tamanho 3
		$data_to_view['nosso_numero_const2'] = $dadosboleto["nosso_numero_const2"] = "4"; //constanto 2 , 4=emitido pelo proprio cliente
		$data_to_view['nosso_numero3'] = $dadosboleto["nosso_numero3"] = $boleto->cnumerodocumento; // tamanho 9


		$data_to_view['numero_documento'] = $dadosboleto["numero_documento"] = $boleto->cnumerodocumento;	// Num do pedido ou do documento
		$data_to_view['data_vencimento'] = $dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/data_to_view
		$AAAA['data_documento'] = $dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
		$data_to_view['data_processamento'] = $dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
		$data_to_view['valor_boleto'] = $dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

		// DADOS DO SEU CLIENTE
		$data_to_view['sacado'] = $dadosboleto["sacado"] = $boleto->csacado;
		$data_to_view['endereco1'] = $dadosboleto["endereco1"] = $boleto->cendereco1;
		$data_to_view['endereco2'] = $dadosboleto["endereco2"] = $boleto->cendereco2;

		// INFORMACOES PARA O CLIENTE
		$data_to_view['demonstrativo1'] = $dadosboleto["demonstrativo1"] = $boleto->cdemo1;
		$data_to_view['demonstrativo2'] = $dadosboleto["demonstrativo2"] = $boleto->cdemo2;
		$data_to_view['demonstrativo3'] = $dadosboleto["demonstrativo3"] = $boleto->cdemo3;

		// INSTRUÇÕES PARA O CAIXA
		$data_to_view['instrucoes1'] = $dadosboleto["instrucoes1"] = $boleto->cinst1;
		$data_to_view['instrucoes2'] = $dadosboleto["instrucoes2"] = $boleto->cinst2;
		$data_to_view['instrucoes3'] = $dadosboleto["instrucoes3"] = $boleto->cinst3;
		$data_to_view['instrucoes4'] = $dadosboleto["instrucoes4"] = $boleto->cinst4;

		// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
		$data_to_view['quantidade'] = $dadosboleto["quantidade"] = "";
		$data_to_view['valor_unitario'] = $dadosboleto["valor_unitario"] = "";
		$data_to_view['aceite'] = $dadosboleto["aceite"] = "";		
		$data_to_view['especie'] = $dadosboleto["especie"] = "R$";
		$data_to_view['especie_doc'] = $dadosboleto["especie_doc"] = "";


		// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


		// DADOS DA SUA CONTA - CEF
		$data_to_view['agencia'] = $dadosboleto["agencia"] = Parametro_model::get('boleto_agencia'); // Num da agencia, sem digito
		$data_to_view['conta'] = $dadosboleto["conta"] = Parametro_model::get('boleto_conta'); 	// Num da conta, sem digito
		$data_to_view['conta_dv'] = $dadosboleto["conta_dv"] = Parametro_model::get('boleto_conta_dv'); 	// Digito do Num da conta

		// DADOS PERSONALIZADOS - CEF
		$data_to_view['conta_cedente'] = $dadosboleto["conta_cedente"] = Parametro_model::get('boleto_conta_cedente'); // Código Cedente do Cliente, com 6 digitos (Somente Números)
		$data_to_view['carteira'] = $dadosboleto["carteira"] = Parametro_model::get('carteira');  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

		// SEUS DADOS
		$data_to_view['identificacao'] = $dadosboleto["identificacao"] = Parametro_model::get('boleto_identificacao');
		$data_to_view['cpf_cnpj'] = $dadosboleto["cpf_cnpj"] = Parametro_model::get('boleto_cpf_cnpj');
		$data_to_view['endereco'] = $dadosboleto["endereco"] = Parametro_model::get('boleto_endereco');
		$data_to_view['cidade_uf'] = $dadosboleto["cidade_uf"] = Parametro_model::get('boleto_cidade_uf');
		$data_to_view['cedente'] = $dadosboleto["cedente"] = Parametro_model::get('boleto_cedente');
			
		$data_to_view['codigobanco'] = $codigobanco = Parametro_model::get('boleto_codigobanco');
		$data_to_view['codigo_banco_com_dv'] = $codigo_banco_com_dv = $this->geraCodigoBanco($codigobanco);
		$data_to_view['nummoeda'] = $nummoeda = Parametro_model::get('boleto_nummoeda');
		$data_to_view['fator_vencimento'] = $fator_vencimento = $this->fator_vencimento($dadosboleto["data_vencimento"]);

		//valor tem 10 digitos, sem virgula
		$data_to_view['valor'] = $valor = $this->formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
		//agencia é 4 digitos
		$data_to_view['agencia'] = $agencia = $this->formata_numero($dadosboleto["agencia"],4,0);
		//conta é 5 digitos
		$data_to_view['conta'] = $conta = $this->formata_numero($dadosboleto["conta"],5,0);
		//dv da conta
		$data_to_view['conta_dv'] = $conta_dv = $this->formata_numero($dadosboleto["conta_dv"],1,0);
		//carteira é 2 caracteres
		$data_to_view['carteira'] = $carteira = $dadosboleto["carteira"];

		//conta cedente (sem dv) com 6 digitos
		$data_to_view['conta_cedente'] = $conta_cedente = $this->formata_numero($dadosboleto["conta_cedente"],6,0);
		//dv da conta cedente
		$data_to_view['conta_cedente_dv'] = $conta_cedente_dv = $this->digitoVerificador_cedente($conta_cedente);

		//campo livre (sem dv) é 24 digitos
		$data_to_view['campo_livre'] = $campo_livre = $conta_cedente . $conta_cedente_dv . $this->formata_numero($dadosboleto["nosso_numero1"],3,0) . $this->formata_numero($dadosboleto["nosso_numero_const1"],1,0) . $this->formata_numero($dadosboleto["nosso_numero2"],3,0) . $this->formata_numero($dadosboleto["nosso_numero_const2"],1,0) . $this->formata_numero($dadosboleto["nosso_numero3"],9,0);
		//dv do campo livre
		$data_to_view['dv_campo_livre'] = $dv_campo_livre = $this->digitoVerificador_nossonumero($campo_livre);
		$data_to_view['campo_livre_com_dv'] = $campo_livre_com_dv ="$campo_livre$dv_campo_livre";

		//nosso número (sem dv) é 17 digitos
		$data_to_view['nnum'] = $nnum = $this->formata_numero($dadosboleto["nosso_numero_const1"],1,0).$this->formata_numero($dadosboleto["nosso_numero_const2"],1,0).$this->formata_numero($dadosboleto["nosso_numero1"],3,0).$this->formata_numero($dadosboleto["nosso_numero2"],3,0).$this->formata_numero($dadosboleto["nosso_numero3"],9,0);
		//nosso número completo (com dv) com 18 digitos
		$data_to_view['nossonumero'] = $nossonumero = $nnum . $this->digitoVerificador_nossonumero($nnum);

		// 43 numeros para o calculo do digito verificador do codigo de barras
		$data_to_view['dv'] = $dv = $this->digitoVerificador_barra("$codigobanco$nummoeda$fator_vencimento$valor$campo_livre_com_dv", 9, 0);
		// Numero para o codigo de barras com 44 digitos
		$data_to_view['linha'] = $linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$campo_livre_com_dv";

		$data_to_view['agencia_codigo'] = $agencia_codigo = $agencia." / ". $conta_cedente ."-". $conta_cedente_dv;

		$dadosboleto["codigo_barras"] = $linha;
		$dadosboleto["linha_digitavel"] = $this->monta_linha_digitavel($linha);
		$dadosboleto["agencia_codigo"] = $agencia_codigo;
		$dadosboleto["nosso_numero"] = $nossonumero;
		$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

		$data_to_view['dadosboleto'] = $dadosboleto;

		$data_to_view['fbarcode'] = $this->fbarcode($dadosboleto["codigo_barras"]);

		$this->load->view('boleto/cef', $data_to_view);

	}

	private function digitoVerificador_nossonumero($numero) {
		$resto2 = $this->modulo_11($numero, 9, 1);
	     $digito = 11 - $resto2;
	     if ($digito == 10 || $digito == 11) {
	        $dv = 0;
	     } else {
	        $dv = $digito;
	     }
		 return $dv;
	}


	private function digitoVerificador_cedente($numero) {
	  $resto2 = $this->modulo_11($numero, 9, 1);
	  $digito = 11 - $resto2;
	  if ($digito == 10 || $digito == 11) $digito = 0;
	  $dv = $digito;
	  return $dv;
	}

	private function digitoVerificador_barra($numero) {
		$resto2 = $this->modulo_11($numero, 9, 1);
	     if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
	        $dv = 1;
	     } else {
	        $dv = 11 - $resto2;
	     }
		 return $dv;
	}


	// FUNÇÕES
	// Algumas foram retiradas do Projeto PhpBoleto e modificadas para atender as particularidades de cada banco

	private function formata_numero($numero,$loop,$insert,$tipo = "geral") {
		if ($tipo == "geral") {
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "valor") {
			/*
			retira as virgulas
			formata o numero
			preenche com zeros
			*/
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "convenio") {
			while(strlen($numero)<$loop){
				$numero = $numero . $insert;
			}
		}
		return $numero;
	}


	private function fbarcode($valor){

		$result = "";

		ob_start();

		$fino = 1 ;
		$largo = 3 ;
		$altura = 50 ;

	  $barcodes[0] = "00110" ;
	  $barcodes[1] = "10001" ;
	  $barcodes[2] = "01001" ;
	  $barcodes[3] = "11000" ;
	  $barcodes[4] = "00101" ;
	  $barcodes[5] = "10100" ;
	  $barcodes[6] = "01100" ;
	  $barcodes[7] = "00011" ;
	  $barcodes[8] = "10010" ;
	  $barcodes[9] = "01010" ;
	  for($f1=9;$f1>=0;$f1--){ 
	    for($f2=9;$f2>=0;$f2--){  
	      $f = ($f1 * 10) + $f2 ;
	      $texto = "" ;
	      for($i=1;$i<6;$i++){ 
	        $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
	      }
	      $barcodes[$f] = $texto;
	    }
	  }


	//Desenho da barra


	//Guarda inicial
	?><img src=<?php echo base_url('assets/boleto/imagens/p.png')?> width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
	src=<?php echo base_url('assets/boleto/imagens/b.png')?> width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
	src=<?php echo base_url('assets/boleto/imagens/p.png')?> width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
	src=<?php echo base_url('assets/boleto/imagens/b.png')?> width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
	<?php
	$texto = $valor ;
	if((strlen($texto) % 2) <> 0){
		$texto = "0" . $texto;
	}

	// Draw dos dados
	while (strlen($texto) > 0) {
	  $i = round($this->esquerda($texto,2));
	  $texto = $this->direita($texto,strlen($texto)-2);
	  $f = $barcodes[$i];
	  for($i=1;$i<11;$i+=2){
	    if (substr($f,($i-1),1) == "0") {
	      $f1 = $fino ;
	    }else{
	      $f1 = $largo ;
	    }
	?>
	    src=<?php echo base_url('assets/boleto/imagens/p.png')?> width=<?php echo $f1?> height=<?php echo $altura?> border=0><img 
	<?php
	    if (substr($f,$i,1) == "0") {
	      $f2 = $fino ;
	    }else{
	      $f2 = $largo ;
	    }
	?>
	    src=<?php echo base_url('assets/boleto/imagens/b.png')?> width=<?php echo $f2?> height=<?php echo $altura?> border=0><img 
	<?php
	  }
	}

	// Draw guarda final
	?>
	src=<?php echo base_url('assets/boleto/imagens/p.png')?> width=<?php echo $largo?> height=<?php echo $altura?> border=0><img 
	src=<?php echo base_url('assets/boleto/imagens/b.png')?> width=<?php echo $fino?> height=<?php echo $altura?> border=0><img 
	src=<?php echo base_url('assets/boleto/imagens/p.png')?> width=<?php echo 1?> height=<?php echo $altura?> border=0> 
	  <?php

	  $result = ob_get_contents();
	  ob_end_clean();

	  return $result;

	} //Fim da função

	private function esquerda($entra,$comp){
		return substr($entra,0,$comp);
	}

	private function direita($entra,$comp){
		return substr($entra,strlen($entra)-$comp,$comp);
	}

	private function fator_vencimento($data) {
	  if ($data != "") {
		$data = explode("/",$data);
		$ano = $data[2];
		$mes = $data[1];
		$dia = $data[0];
	    return(abs(($this->_dateToDays("1997","10","07")) - ($this->_dateToDays($ano, $mes, $dia))));
	  } else {
	    return "0000";
	  }
	}

	private function _dateToDays($year,$month,$day) {
	    $century = substr($year, 0, 2);
	    $year = substr($year, 2, 2);
	    if ($month > 2) {
	        $month -= 3;
	    } else {
	        $month += 9;
	        if ($year) {
	            $year--;
	        } else {
	            $year = 99;
	            $century --;
	        }
	    }
	    return ( floor((  146097 * $century)    /  4 ) +
	            floor(( 1461 * $year)        /  4 ) +
	            floor(( 153 * $month +  2) /  5 ) +
	                $day +  1721119);
	}

	private function modulo_10($num) { 
			$numtotal10 = 0;
	        $fator = 2;

	        // Separacao dos numeros
	        for ($i = strlen($num); $i > 0; $i--) {
	            // pega cada numero isoladamente
	            $numeros[$i] = substr($num,$i-1,1);
	            // Efetua multiplicacao do numero pelo (falor 10)
	            $temp = $numeros[$i] * $fator; 
	            $temp0=0;
	            foreach (preg_split('//',$temp,-1,PREG_SPLIT_NO_EMPTY) as $k=>$v){ $temp0+=$v; }
	            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
	            // monta sequencia para soma dos digitos no (modulo 10)
	            $numtotal10 += $parcial10[$i];
	            if ($fator == 2) {
	                $fator = 1;
	            } else {
	                $fator = 2; // intercala fator de multiplicacao (modulo 10)
	            }
	        }
			
	        // várias linhas removidas, vide função original
	        // Calculo do modulo 10
	        $resto = $numtotal10 % 10;
	        $digito = 10 - $resto;
	        if ($resto == 0) {
	            $digito = 0;
	        }
			
	        return $digito;
			
	}

	private function modulo_11($num, $base=9, $r=0)  {
	    /**
	     *   Autor:
	     *           Pablo Costa <pablo@users.sourceforge.net>
	     *
	     *   Função:
	     *    Calculo do Modulo 11 para geracao do digito verificador 
	     *    de boletos bancarios conforme documentos obtidos 
	     *    da Febraban - www.febraban.org.br 
	     *
	     *   Entrada:
	     *     $num: string numérica para a qual se deseja calcularo digito verificador;
	     *     $base: valor maximo de multiplicacao [2-$base]
	     *     $r: quando especificado um devolve somente o resto
	     *
	     *   Saída:
	     *     Retorna o Digito verificador.
	     *
	     *   Observações:
	     *     - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
	     *     - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste script.
	     */                                        

	    $soma = 0;
	    $fator = 2;

	    /* Separacao dos numeros */
	    for ($i = strlen($num); $i > 0; $i--) {
	        // pega cada numero isoladamente
	        $numeros[$i] = substr($num,$i-1,1);
	        // Efetua multiplicacao do numero pelo falor
	        $parcial[$i] = $numeros[$i] * $fator;
	        // Soma dos digitos
	        $soma += $parcial[$i];
	        if ($fator == $base) {
	            // restaura fator de multiplicacao para 2 
	            $fator = 1;
	        }
	        $fator++;
	    }

	    /* Calculo do modulo 11 */
	    if ($r == 0) {
	        $soma *= 10;
	        $digito = $soma % 11;
	        if ($digito == 10) {
	            $digito = 0;
	        }
	        return $digito;
	    } elseif ($r == 1){
	        $resto = $soma % 11;
	        return $resto;
	    }
	}

	private function monta_linha_digitavel($codigo) {
			
			// Posição 	Conteúdo
	        // 1 a 3    Número do banco
	        // 4        Código da Moeda - 9 para Real
	        // 5        Digito verificador do Código de Barras
	        // 6 a 9   Fator de Vencimento
			// 10 a 19 Valor (8 inteiros e 2 decimais)
	        // 20 a 44 Campo Livre definido por cada banco (25 caracteres)

	        // 1. Campo - composto pelo código do banco, código da moéda, as cinco primeiras posições
	        // do campo livre e DV (modulo10) deste campo
	        $p1 = substr($codigo, 0, 4);
	        $p2 = substr($codigo, 19, 5);
	        $p3 = $this->modulo_10("$p1$p2");
	        $p4 = "$p1$p2$p3";
	        $p5 = substr($p4, 0, 5);
	        $p6 = substr($p4, 5);
	        $campo1 = "$p5.$p6";

	        // 2. Campo - composto pelas posiçoes 6 a 15 do campo livre
	        // e livre e DV (modulo10) deste campo
	        $p1 = substr($codigo, 24, 10);
	        $p2 = $this->modulo_10($p1);
	        $p3 = "$p1$p2";
	        $p4 = substr($p3, 0, 5);
	        $p5 = substr($p3, 5);
	        $campo2 = "$p4.$p5";

	        // 3. Campo composto pelas posicoes 16 a 25 do campo livre
	        // e livre e DV (modulo10) deste campo
	        $p1 = substr($codigo, 34, 10);
	        $p2 = $this->modulo_10($p1);
	        $p3 = "$p1$p2";
	        $p4 = substr($p3, 0, 5);
	        $p5 = substr($p3, 5);
	        $campo3 = "$p4.$p5";

	        // 4. Campo - digito verificador do codigo de barras
	        $campo4 = substr($codigo, 4, 1);

	        // 5. Campo composto pelo fator vencimento e valor nominal do documento, sem
	        // indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
	        // tratar de valor zerado, a representacao deve ser 000 (tres zeros).
			$p1 = substr($codigo, 5, 4);
			$p2 = substr($codigo, 9, 10);
			$campo5 = "$p1$p2";

	        return "$campo1 $campo2 $campo3 $campo4 $campo5"; 
	}

	private function geraCodigoBanco($numero) {
	    $parte1 = substr($numero, 0, 3);
	    $parte2 = $this->modulo_11($parte1);
	    return $parte1 . "-" . $parte2;
	}

}
?>