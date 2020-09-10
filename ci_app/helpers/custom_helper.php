<?php
	/**
	 * Função para gerar URL absoluta
	 * @param (String) subpasta de controller onde o controlador se encontra
	 * @param (String) nome do controlador alvo
	 * @param (String) nome do método alvo
	 * @param (String) parâmetros
	 * @return URL absoluta para os parâmetros enviados
	 * @access public
	 */
	function makeUrl($folder = '', $controller = '', $method = '', $parameters = ''){
		if ($folder)
			$controller = $folder."/".$controller;	
		$segments = array($controller,$method,$parameters);	
		return site_url($segments);
	}

	/**
	 * Função para transformar número em double para o mysql
	 * @param (String) número com caracteres como vírgulas e pontos
	 * @return (String) número com ponto como separador e sem vírgulas
	 * @access public
	 */

	function toDbCurrency($user_currency){
		if (strpos($user_currency, ",") !== false){
			$currency = str_replace('.', '', $user_currency);
			$currency = str_replace(',', '.', $currency);
		} elseif (strpos($user_currency, ".")) {
			$currency_parts = explode(".", $user_currency);
			if (count($currency_parts) == 2){
				$currency = $currency_parts[0].".".$currency_parts[1];
			} else {
				$total = count($currency_parts);
				$currency_parts[$total] = $currency_parts[$total-1];
				$currency_parts[$total-1] = ".";
				$currency = implode('', $currency_parts);
			}
		} else {
			$currency = $user_currency;
		}
		return $currency;
	}

	/**
	 * Função para transformar número de formato mysql para financeiro
	 * @param (String) número com ponto como separador e sem vírgulas
	 * @return (String) número com caracteres como vírgulas e pontos
	 * @access public
	 */

	function toUserCurrency($db_currency, $label = false){
		$result = number_format($db_currency, 2, ",", ".");
		if ($label){
			$result = $label.$result;
		}
		return $result;
	}

	/**
	 * Função para transformar data no formato user para o formato mysql
	 * @param (String) data no formato user
	 * @return (String) data no formato mysql
	 * @access public
	 */

	function toDbDate($user_data){
		if (!$user_data || $user_data == "00/00/0000"){
			return null;
		}
		return substr($user_data, 6, 4)."-".substr($user_data, 3, 2)."-".substr($user_data, 0, 2);
	}

	/**
	 * Função para transformar data no formato mysql para o formato user
	 * @param (String) data no formato mysql
	 * @return (String) data no formato user
	 * @access public
	 */

	function toUserDate($mysql_data){
		if (!$mysql_data || $mysql_data == "0000-00-00"){
			return null;
		}
		return substr($mysql_data, 8, 2)."/".substr($mysql_data, 5, 2)."/".substr($mysql_data, 0, 4);
	}

	/**
	 * Função para transformar string em cpf ou cnpj
	 * @param (String) número sem pontos
	 * @return (String|Boolean) cpf/cnpj ou false
	 * @access public
	 */

	function toUserCpfCnpj($dirty_cpf_cnpj){
		if (strlen($dirty_cpf_cnpj) == 11){
			return toUserCpf($dirty_cpf_cnpj);
		} elseif (strlen($dirty_cpf_cnpj) == 14) {
			return toUserCnpj($dirty_cpf_cnpj);
		}
		return false;
	}

	/**
	 * Função para transformar string em cpf
	 * @param (String) número sem pontos
	 * @return (String|Boolean) cpf ou false
	 * @access public
	 */

	function toUserCpf($dirty_cpf){

		if (strlen($dirty_cpf) != 11){
			return false;
		}

		$cpf = substr($dirty_cpf, 0, 3).".".substr($dirty_cpf, 3, 3).".".substr($dirty_cpf,6,3)."-".substr($dirty_cpf, 9, 2);

		return $cpf;
	}

	/**
	 * Função para transformar string em cnpj
	 * @param (String) número sem pontos
	 * @return (String|Boolean) cnpj ou false
	 * @access public
	 */

	function toUserCnpj($dirty_cnpj){

		if (strlen($dirty_cnpj) != 14){
			return false;
		}

		$cnpj = substr($dirty_cnpj, 0, 2).".".substr($dirty_cnpj, 2, 3).".".substr($dirty_cnpj, 5, 3)."/".substr($dirty_cnpj, 8, 4)."-".substr($dirty_cnpj, 12, 2);

		return $cnpj;
	}

	/**
	 * Função para transformar data e horário no formato mysql para o formato user
	 * @param (String) data e horário no formato mysql
	 * @return (String) data e horário no formato user
	 * @access public
	 */

	function toUserDateTime($mysql_datatempo, $glue=FALSE){
		if(!$glue) $glue = ' às ';
		return substr($mysql_datatempo, 8, 2)."/".substr($mysql_datatempo, 5, 2)."/".substr($mysql_datatempo, 0, 4).$glue.substr($mysql_datatempo, 11, 5);
	}

	/**
	 * Função para pegar todas as datas em um intervalo de datas
	 * @param Date data inicial
	 * @param Date data final
	 * @return Array datas no intervalo
	 * @access public
	 */

	function createDateRangeArray($strDateFrom,$strDateTo)
	{
	    // takes two dates formatted as YYYY-MM-DD and creates an
	    // inclusive array of the dates between the from and to dates.

	    // could test validity of dates here but I'm already doing
	    // that in the main script

	    $aryRange=array();

	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    return $aryRange;
	}

	/**
	 * Função para retornar apenas valores numéricos de uma string
	 * @param String valor que deve ser limpo
	 * @return String número
	 * @access public
	 */

	function cleanToNumber($string) {
	   return preg_replace('/[^0-9]/', '', $string); // Removes special chars.
	}

	/**
	 * Função para retornar apenas valores alfanuméricos de uma string
	 * @param String valor que deve ser limpo
	 * @return String número
	 * @access public
	 *
/
	function cleanToAlphaNumber($string) {
	   return preg_replace('/[^A-Za-z0-9]/', '', $string); // Removes special chars.
	}

	/**
	 * Função para retornar apenas texto de uma string
	 * @param String valor que deve ser limpo
	 * @return String texto
	 * @access public
	 */

	function cleanToString($string) {
	   return preg_replace('/[^A-Za-z]/', '', $string); // Removes special chars.
	}

	/**
	 * Função para retornar array com os estados do Brasil
	 * @return array estados do brasil
	 * @access public
	 */

	function estadosDoBrasil() {
	   $estados = array("AC"=>"Acre", "AL"=>"Alagoas", "AM"=>"Amazonas", "AP"=>"Amapá","BA"=>"Bahia","CE"=>"Ceará","DF"=>"Distrito Federal","ES"=>"Espírito Santo","GO"=>"Goiás","MA"=>"Maranhão","MT"=>"Mato Grosso","MS"=>"Mato Grosso do Sul","MG"=>"Minas Gerais","PA"=>"Pará","PB"=>"Paraíba","PR"=>"Paraná","PE"=>"Pernambuco","PI"=>"Piauí","RJ"=>"Rio de Janeiro","RN"=>"Rio Grande do Norte","RO"=>"Rondônia","RS"=>"Rio Grande do Sul","RR"=>"Roraima","SC"=>"Santa Catarina","SE"=>"Sergipe","SP"=>"São Paulo","TO"=>"Tocantins");
	   return $estados;
	}

?>