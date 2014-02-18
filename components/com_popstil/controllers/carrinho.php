<?php

defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT.'/controller.php';
require_once JPATH_COMPONENT.'/helpers/enviaremail.php';

class PopstilControllerCarrinho extends PopstilController {
		
	public function activate() {
		
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
	
	public function removerQuadro() {
		$posicaoRemover = JRequest::getVar('posicaoquadro');
		$posicao = explode(",",$posicaoRemover);
		//print_r( $posicao);
		
		$model = $this->getModel('carrinho');
		
		$model->removeQuadro($posicao);
		
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
			
	}
	
	public function calcularDesconto() {
		$app = JFactory::getApplication();
		
		$app->setUserState('com_popstil.carrinho.desconto',null);
		
		$codigodesconto	= JRequest::getVar('codDesconto');
		
		if(!isset($codigodesconto) || empty($codigodesconto)) {
			
			$this->setMessage(JText::sprintf('COM_POPSTIL_DESCONTO_INVALID'), 'warning');
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
			return false;
		}
		
		$modelCarrinho = $this->getModel('carrinho' , 'PopstilModel');
		
		//Passa o codigo do desconto para o método que ira verificar se o desconto esta ativo e se existe
		//Caso ele exista e esta ativo e no prazo de validade, ele vai retornar um objeto do tipo desconto com os dados 
		//para calculo
		$retorno = $modelCarrinho ->getDesconto($codigodesconto);
		
		if(!isset($retorno) || empty($retorno) ){
			
			$this->setMessage(JText::sprintf('COM_POPSTIL_DESCONTO_INVALID'), 'warning');
			//$app->setUserState('com_popstil.registration.erro', null);
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
			return false;
		}
		else{
			//Se entrou é porque o desconto esta ativo, entao ele calcula o valor de desconto
			//Primeiro verifica qual o tipo de desconto, se é % ou em R$
			//if($retorno->tipo_desconto === 'RS') {
				
			//}else if($retorno->tipo_desconto === 'PO'){
				
			//}
			$app->setUserState('com_popstil.carrinho.desconto',$retorno);
		}
		
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
	}
	
	/*
		Serve para calcular o frete para a tela do carrinho
	*/
	public function calcularFrete() {
	
		/*$email = EnviaremailHelper::enviarEmail();
		
		if($email) {
			$this->setMessage('email enviado!', 'warning');
			//$app->setUserState('com_popstil.registration.erro', null);
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
			return false;
		}else {
			$this->setMessage('Erro ao enviar email!', 'warning');
			//$app->setUserState('com_popstil.registration.erro', null);
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
			return false;
		}*/
		
		$app = JFactory::getApplication();
		
		$requestData = JRequest::getVar('cepDestino');
		
		//Remove o traço do cep.
		$cepdestino = str_ireplace('-','',$requestData);
		
		//Pega o peso dos quadros, e o preço total para fazer o seguro
		$pesoquadros = $app->getUserState('com_popstil.carrinho.pesoquadros','0');
		$precoquadros = $app->getUserState('com_popstil.carrinho.precoquadros');
	
		//CEP Proiz - 85900-215
		
		$tipo_frete = JRequest::getVar('tipo_frete');
		
		//Por padrão o envio sera por sedex, caso exceda o limite, sera enviado por pac
		$tipoenvio = '40010';
		if($tipo_frete == 'pac') {
			$tipoenvio = '41106';
			$app->setUserState('com_popstil.carrinho.fretepac',1);
		}else if($tipo_frete == 'sedex') {
			$tipoenvio = '40010';	
			$app->setUserState('com_popstil.carrinho.fretepac',0);
		}
		//Se o peso for maior que 30 kg entao deve ser por sedex
		if(floatval($pesoquadros) > 30) {
			$tipoenvio = '41106';
		}
		//Chama o método que calcula o cep no webservice dos correios
		$valorFrete = $this->calculaFreteCorreios($tipoenvio,'85900215',$cepdestino, $pesoquadros,$precoquadros);
		//$valorSEDEX = $this->calculaFreteCorreios('40010','85900215',$cepdestino, $pesoquadros,$precoquadros);
		
		//Caso o usuario digitar o CEP errado, ele seta false para a variavel cepinvalido e retorna para a tela de carrinho com a msg de cep inválido.
		if(!$valorFrete) {
			$app->setUserState('com_popstil.carrinho.cepinvalido','false');
			$app->setUserState('com_popstil.carrinho.cepDigitado', $cepdestino);
			$app->setUserState('com_popstil.carrinho.valorFrete', '0.00');
		
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));		
		}else{
		
			$app->setUserState('com_popstil.carrinho.cepinvalido','true');
			
			//Substitui a virgula por ponto para poder converter o valor retornado para float.
			$valorFrete = str_ireplace(',','.',$valorFrete);
			//$valorSEDEX = str_ireplace(',','.',$valorSEDEX);
			
			//converte o valor retornado para float.
			$valorFrete = floatval($valorFrete);
			//$valorSEDEX = floatval($valorSEDEX);
			
			$app->setUserState('com_popstil.carrinho.valorFrete', $valorFrete);
			//$app->setUserState('com_popstil.carrinho.valorFretePac', $valorFrete);
			//$app->setUserState('com_popstil.carrinho.valorFreteSedex', $valorSEDEX);
			$app->setUserState('com_popstil.carrinho.cepDigitado', $cepdestino);
			
			
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
		}
	}
	
	private function calculaFreteCorreios($cod_servico, $cep_origem, $cep_destino, $peso, $valor_declarado='1.50', $altura = '2', 
		$largura = '11', $comprimento='16') {
	
	    ############################################
		# Código dos Serviços dos Correios
		# 41106 PAC sem contrato
		# 40010 SEDEX sem contrato
		# 40045 SEDEX a Cobrar, sem contrato
		# 40215 SEDEX 10, sem contrato
		############################################
		 
		/*$correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor_declarado."&sCdAvisoRecebimento=n&nCdServico=".$cod_servico."&nVlDiametro=0&StrRetorno=xml";
		
        $xml = simplexml_load_file($correios);
		*/
		
		
		
		$data = array();  
		
		$data['sCepOrigem'] 	= $cep_origem;
		$data['sCepDestino'] 	= $cep_destino;
		$data['nVlPeso']		= $peso;
		$data['nCdFormato']		= '1';
		$data['nVlComprimento'] =  $comprimento;
		$data['nVlAltura'] = $altura;
		$data['nVlLargura'] = $largura;
		$data['nVlDiametro'] = 0;
		$data['sCdMaoPropria'] = 'n';
		$data['nVlValorDeclarado'] = '1000';
		$data['sCdAvisoRecebimento'] = 'n';
		$data['StrRetorno'] = 'xml';
		$data['nCdServico'] = $cod_servico;
		
		$data = http_build_query($data);
		
		$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
		
		$curl = curl_init($url . '?' .  $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($curl);
		
		$result = simplexml_load_string($result);
		
		print_r($result);
		
		if($result->cServico->Erro == '0') 
			return $result->cServico->Valor;
		else
			return false;			
	}
	
	
	public function finalizarPedido() {
	
		// Check for request forgeries.
	//	JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
	
	
		//Inicia as variveis
		$add = JFactory::getApplication();
		$modelCarrinho = $this->getModel('carrinho', 'PopstilModel');
		
		$requestData = $this->input->post->get('pedido', array(), 'array');
		
		//Verificia se o usuario selecionou um tipo de frete
		if(!array_key_exists('tipo_frete',$requestData)) {
			$this->setMessage('Você deve informar o tipo de frete', 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
		}
		
		//Envia os dados para o model do carrinho para gravar no bando de dados
		$return = $modelCarrinho->finalizarPedido($requestData);
		
		if($return === false){
			
			$this->setMessage($modelCarrinho->getError(), 'warning');
			//$app->setUserState('com_popstil.registration.erro', null);
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
			return false;
			
		}
		
		
		
		setcookie('carrinho', "", time() - 3600);
		
		//Redireciona para a pagina 
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho&layout=pedidorealizado', false));
		
		//$this->setMessage($model->getError(), 'warning');
		//$app->setUserState('com_popstil.registration.erro', null);
		
		//$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
		//return false;
	}
	
	
	
	
	
	
	
	
	
	

}
