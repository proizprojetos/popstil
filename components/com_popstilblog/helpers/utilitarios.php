<?php

defined('_JEXEC') or die ('Acesso Restrito');

abstract class UtilitariosHelper {
	
	public static function diferencaentredatas($dataoriginal) {
		
		//$inicio = DateTime::createFromFormat('d/m/Y H:i:s', getdate());
		//$fim 	= DateTime::createFromFormat('d/m/Y H:i:s', $dataoriginal);
		
		//$intervalo = getdate()->diff($dataoriginal);
		//Pega o timestamp da hora atual
		$date = new DateTime();
		$dataatual = $date->getTimestamp();
		
		//Pega o timestamp da data passada 
		$dataoriginal = strtotime($dataoriginal);
		
		//Pega a diferença entre as datas
		$diferenca = $dataatual - $dataoriginal;
		
		$tempo = (int)floor( $diferenca / (60 * 60 * 24));
		//$d = date('Y-m-d H:i:s', $diferenca);
		if($tempo == 0) {
			$tempo = (int)floor( $diferenca / (60 * 60));
			$tempo .= ' horas';
		}else {
			$tempo .= ' dias';
		}
		
		return $tempo;
		
	} 
	
	public static function retornaMes($mes) {
		
		$meses = array('janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'); 
		
		return $meses[($mes-1)];
		
	}
	
	
	public static function getSugestaoPopstil() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$db->setQuery('select * from #__blog_sugestao as sugestao 
						where sugestao.status = 1
						order by RAND()');
						
		$sugestao = $db->loadObject();
		
		return $sugestao;
	}
	
	public static function getInstagramImages() {
		/*
			Your token is: 525590693.ab103e5.995a8849950343c0b02b00a5ad39c33f 
			Your user ID is: 525590693
		*/	
		$userid = "525590693";
		$accessToken = "525590693.ab103e5.995a8849950343c0b02b00a5ad39c33f";
		$url = "https://api.instagram.com/v1/users/{$userid}/media/recent/?access_token={$accessToken}";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		
		$result = json_decode($result);
		
		if(curl_errno($ch)) {
			echo 'error:' . curl_error($ch);	
		}
		
		curl_close($ch); 
        return $result;
		
	}
	
}