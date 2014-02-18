<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');

require_once JPATH_COMPONENT.'/controller.php';

class PopstilControllerCustomizacao extends PopstilController {
	
	public function activate() {
		
		print_r('entrou no activate');
		
		$user = JFactory::getUser();
		
		if($user->get('id')) {
			print_r('usuario já logado<br/>');
			return true;
		}else {
			print_r('usuario não logado<br/>');
			return false;
		}
		
		return true;
		
	}
	
	/*
		Quando o usuario monta seu popstil, e clica em finalizar pedido
		ele fara as validações em javascript, caso passe ele chamará esse
		método que ira enviar o array de popstil para o carrinho.
	*/	
	public function finalizaPedido() {
		
		// Check for request forgeries.
		JSession::checkToken() or $this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcustomizacao', false));
		
		//Inicia as variaveis
		$app = JFactory::getApplication();
		
		//Pega os dados do quadro montado pelo usuario
		$requestData = JRequest::getVar('quadro', array(), 'post', 'array');
		
		//Carrega a imagem enviada pelo usuario e adiciona na variavel $imagem
		//$imagem = $this->carregaImagem();
		
		$quadros = array();
		//Verifica o numero de quadros e cria um array limpo
		//com apenas os quadros preenchidos.
		$arraynovo = array();
		
		
		$arraynovo['imagem'] = $requestData['imagem'];
		$arraynovo['idnumpessoas'] = $requestData['idnumpessoas'];
		$arraynovo['orientacao'] = (isset($requestData['orientacao'])) ? $requestData['orientacao'] : 'P';
		
		//print_r($requestData);
		foreach($requestData as $chave => $valor) {
			
			if(!empty($valor['tamanho']) && $valor['tamanho'] > 0  && is_array($valor)){
				
				array_push($arraynovo,$valor);
				
			}
		}
		//$quadros['idnumpessoas'] = $requestData['idnumpessoas'];
		array_push($quadros,$arraynovo);
		print_r($quadros);
		
		JFactory::getApplication()->setUserState('com_popstil.carrinho.valorFrete', '');
		
		/*coloca o carrinho de compras no COOKIE DO NAVEGADOR*/
		if (isset($_COOKIE['carrinho'])) {
   			$carrinho = unserialize($_COOKIE['carrinho']);
			$novoarray = array_merge($carrinho, $quadros);
			$novoarray = serialize($novoarray);
			setcookie('carrinho', $novoarray, time() + 60*60*24*7);
		} else {
			$novoarray = serialize($quadros);
			setcookie('carrinho', $novoarray, time() + 60*60*24*7);
		} 
		
		/*coloca o carrinho de compras na sessão DO NAVEGADOR*/
		//Inicia a sessão
		/*session_start();
		//Adiciona o quadro a array do carrinho que esta na sessão
		if(isset($_SESSION['carrinho'])) {
			$carrinho = $_SESSION['carrinho'];
			$novoarray = array_merge($carrinho, $quadros);
			$_SESSION['carrinho'] = $novoarray;
		}else {
			$_SESSION['carrinho'] = $quadros;
		}*/
		
		//Redireciona para o carrinho
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
	}
	
	//Método para carregar a imagem enviada pelo usuario
	public function carregaImagem() {
		try {
			$fieldName = 'file_upload';
			$data = (date("d_m_Y_H_i_s"));
			$extensao = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
			$fileName = 'popstil_'.$data.'.'.$extensao;
			$fileTemp = $_FILES[$fieldName]['tmp_name'];
			$uploadPath = JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'com_popstil'.DIRECTORY_SEPARATOR.'popstilcustomizacao'.DIRECTORY_SEPARATOR.'quadrosClientes'.DIRECTORY_SEPARATOR.$fileName;
			$imagem = JURI::base().'media/com_popstil/popstilcustomizacao/quadrosClientes/'.$fileName;
		}catch(Exception $ex) {
			$this->enviaremailerro($ex);
			echo ('O seguinte erro aconteceu: '.$ex);	
		}
		//$this->imagem = preg_replace("\\", "//", $this->imagem);
		if(!JFile::upload($fileTemp, $uploadPath)) 
		{
				echo JText::_( 'Erro ao mover foto.' );
				return;
		}
		else
		{			
		   // success, exit with code 0 for Mac users, otherwise they receive an IO Error
		  //print_r('<br/>quadro upload com sucesso');
		}
		//Qualquer erro que o servidor registrar no upload.
		$fileError = $_FILES[$fieldName]['error'];
		if($fileError > 0) {
			$this->enviaremailerro($fileError);
			switch($fileError) {
				case 1:
				echo JText::_('Arquivo grande demais.');
				return;
				
				case 2:
				echo JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
				return;
		 
				case 3:
				echo JText::_( 'ERROR PARTIAL UPLOAD' );
				return;
		 
				case 4:
				echo JText::_( 'ERROR NO FILE' );
				return;
			}
		}
		return $imagem != '' ? $imagem : 'Erro ao enviar a imagem';
	}
	
	public function enviaremailerro($mensagem) {
	
			$mailer = JFactory::getMailer();
			
			$config = JFactory::getConfig();
			
			$mailer->setSender('suporte@popstil.com');
	
			$mailer->addRecipient('luyzgarcia@gmail.com');
						
			
			$body   = "<h2>Ocorreu o seguinte erro no finaliza pedido do customização:</h2><br/>:".$mensagem;
			
			$mailer->isHTML(true);
			//$mailer->Encoding = 'base64';
			/*$mailer->CharSet = "UTF8";*/
			$mailer->setSubject('Erro no sistema popstil');
			$mailer->setBody($body);
			$mailer->AddCustomHeader('Content-type: text/html; charset=utf-8');
			
			$send = $mailer->Send();
			if ( $send !== true ) {
			    $this->setError(JText::sprintf('Erro ao enviar email', $temp->getError()));
			    return false;
			} else {
			    echo 'Mail sent';
			}	
		}
	
	
}
