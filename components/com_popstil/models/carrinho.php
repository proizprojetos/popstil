<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_popstil'.DS.'tables');

class PopstilModelCarrinho extends JModelForm {
	
	protected $quadros;
	
	protected $cepdigitado;
	protected $cepinvalido;
	protected $carrinho_tela;
	protected $carrinho;
	protected $valorFrete = 0.00;
	protected $valorDesconto = 0.00;
	
	
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_popstil.carrinho', 'carrinho', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}
	
	public function removeQuadro($posicao) {
		
		$carrinho = $this->retornaCarrinhoCookie();
		//$numpessoas = $carrinho['idnumpessoas'];
		JFactory::getApplication()->setUserState('com_popstil.carrinho.valorFrete', '');
		
		//print_r($carrinho);
		//echo '<br/><Br/>';
		///$carrinho = $this->getCarrinho();
		
		unset($carrinho[$posicao[0]][$posicao[1]]);
		
		foreach($carrinho as $chave => $item) {
			print_r($item);
			if(sizeof($item) <= 3) {
				unset($carrinho[$chave]);
			}
		}
		
		$carrinho = array_values($carrinho);
		$this->gravaCarrinhoCookie($carrinho);
		
	}
	
	private function retornaCarrinhoCookie() {
		$carrinho = array();
		if (isset($_COOKIE['carrinho'])) {
   			$carrinho = unserialize($_COOKIE['carrinho']);
		} else {
			//echo 'Carrinho vazio<br />';
		} 
		return $carrinho;
	}
	
	private function gravaCarrinhoCookie($gravar) {
		$carrinho = unserialize($_COOKIE['carrinho']);
		$carrinho = array();
		$carrinho = serialize($gravar);
		setcookie('carrinho', $carrinho, time() + 60*60*24*7);
	}
	
	public function getCarrinho() {
		
		//Apagar o cookie
		//setcookie('carrinho', "", time() - 3600);
		
		$carrinho = $this->retornaCarrinhoCookie();
		
		if( !isset($carrinho)) {
			return false;
		}
		//echo '<br/><br/>Carrinho da cookie:</br>';
		//print_r($carrinho);
		
		/*
			Monta o array que sera mostrado na tela para o usuario
		*/
		$pesoquadros = 0;
		
		$this->carrinho_tela = array();
		/*echo '<br/>';
		print_r($carrinho);
		echo '<br /><br />';
		*/		
		foreach($carrinho as $chave => $item ){
			//if($chave !== 'idnumpessoas' ) {
				$popstil = array();			
				$popstil['imagem'] = $item['imagem'];
				
				$popstil['numpessoas'] = $this->getnumerodepessoas($item['idnumpessoas']);
				/*foreach ($item as $key => $value) {
					if($key !== 'imagem'){
						$popstil['numpessoas'] = $value['idnumpessoas'];
					}
				}*/			
				//$popstil['numpessoas'] = $this->getnumerodepessoas($item[0]['idnumpessoas']);
				$numeroquadros = 0;
				
				foreach($item as $chavefilho => $subitem) {
					if(($chavefilho) !== 'imagem' && $chavefilho !== 'idnumpessoas' && $chavefilho !== 'orientacao') {
						//if($chavefilho == 'tamanho' || $chavefilho == 'idcormoldura' || $chavefilho == 'idfundo') {
							$numeroquadros += 1;
							$pesoquadros += $this->getPesoQuadro($subitem['tamanho']);
							$quadro = array();
							$quadro['tamanho'] = $this->gettamanhoquadro($subitem['tamanho']);
							$quadro['moldura'] = $this->getmoldura($subitem['idcormoldura']);
							$popstil['quadros'][$chavefilho] = $quadro;
						//}
						//echo print_r($subitem);
					}
					//echo $chavefilho;
				}
				
				$popstil['numquadros'] = $numeroquadros;
				array_push($this->carrinho_tela,$popstil);
			//}
		}
		/*echo '<br /><br />';
		print_r($this->carrinho_tela);
		*/		
		$this->carrinho = $carrinho;
		
		$app = JFactory::getApplication();
		
		//Coloca na sessao do usuario o preço para calcular o frete.
		$precoquadros = (string)$this->getSubTotal();
		$app->setUserState('com_popstil.carrinho.precoquadros',$precoquadros);
		
		//Coloca na sessao tambem o peso dos quadros
		$app ->setUserstate('com_popstil.carrinho.pesoquadros', $pesoquadros);		
		
		return $this->carrinho_tela;
	}
	
	function getnumerodepessoas($idNumPessoas) {
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select('* ');
		$query->from('#__popstil_customizacao_numeropessoas');
		$query->where(' id_numpessoas = '.$idNumPessoas);
		
		
		//Seta no query para trazer apenas um resultado.
		//o set query recebe tres parametros sendo eles 1ª query, o 2ª inicio, 3ª o limite para trazer
		$db->setQuery((String) $query,0,1);
		$numpessoas = $db->loadObjectList();
		return ($numpessoas[0] -> numero_pessoas);
	}
	
	function gettamanhoquadro($idTamanhoQuadro) {
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select('* ');
		$query->from('#__popstil_customizacao_tamanhos');
		$query->where(' id_tamanho = '.$idTamanhoQuadro);
		
		
		//Seta no query para trazer apenas um resultado.
		//o set query recebe tres parametros sendo eles 1ª query, o 2ª inicio, 3ª o limite para trazer
		$db->setQuery((String) $query,0,1);
		$tamanhoquadro = $db->loadObjectList();
		$retorna = $tamanhoquadro[0] -> largura .'x'.$tamanhoquadro[0]->altura.'cm';
		
		return $retorna;
	}
	
	function getmoldura($idMoldura) {
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select('* ');
		$query->from('#__popstil_customizacao_molduras');
		$query->where(' id_moldura = '.$idMoldura);
		
		
		//Seta no query para trazer apenas um resultado.
		//o set query recebe tres parametros sendo eles 1ª query, o 2ª inicio, 3ª o limite para trazer
		$db->setQuery((String) $query,0,1);
		$moldura = $db->loadObjectList();
		//return 'preto';
		return ($moldura[0] -> titulo);
	}
	
	function getSubTotal() {
		$subtotal = 0;
		if(isset($this->carrinho) && !empty($this->carrinho) ) {
			foreach($this->carrinho as $chave => $item ){
				//if($chave !== 'idnumpessoas'  ) {
					foreach($item as $subchave =>$subitem) {
						if($subchave !== 'imagem' && $subchave !== 'idnumpessoas' && $subchave !== 'orientacao') {
							$subtotal += intval($this->getPrecoQuadro($subitem['tamanho'], $item['idnumpessoas']));	
						}
					}
				//}
			}
		}
		return $subtotal;
	}
	
	function getPrecoTotal() {
		$precototal = 0;
		
		$precototal += $this->getSubTotal();
		$precototal += $this->valorFrete;
		$precototal -= $this->getValorDesconto();
		
		return $precototal;
		
	}
	
	function getPrecoQuadro($idTamanho, $idNumPessoas) {
		$db = JFactory::getDBO();
		
		//echo $idTamanho.' - '. $idNumPessoas;
		
		$query = $db->getQuery(true);
		$query->select('* ');
		$query->from('#__popstil_customizacao_precoquadro');
		$query->where(' id_tamanho = '.$idTamanho.' and id_numpessoas ='.$idNumPessoas);
		
		
		//Seta no query para trazer apenas um resultado.
		//o set query recebe tres parametros sendo eles 1ª query, o 2ª inicio, 3ª o limite para trazer
		$db->setQuery((String) $query,0,1);
		$retorno = $db->loadObjectList();
		
		return ($retorno[0] -> preco);
	}
	
	function getPesoQuadro($idTamanho) {
		//echo $idTamanho;
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select('* ');
		$query->from('#__popstil_customizacao_tamanhos');
		$query->where(' id_tamanho = '.$idTamanho);
		
		
		//Seta no query para trazer apenas um resultado.
		//o set query recebe tres parametros sendo eles 1ª query, o 2ª inicio, 3ª o limite para trazer
		$db->setQuery((String) $query,0,1);
		$tamanhoquadro = $db->loadObjectList();
		$retorna = $tamanhoquadro[0] -> peso;
		
		$retorna = floatval($retorna);
		
		return $retorna;		
	}
	
	public function getValorDesconto() {

		$valorDesconto = 0;
		$desconto = JFactory::getApplication()->getUserState('com_popstil.carrinho.desconto');
		//print_r($desconto);
		
		if(isset($desconto) && !empty($desconto) && $this->getSubTotal() > 0) {
			$desconto = $this->getDesconto($desconto->code_desconto);
			
			if(isset($desconto) && !empty($desconto)) {
				//print_r($desconto);
				//Caso o tipo de desconto seja RS, ou seja reais, ele apenas adiciona o valor de desconto a variavel.
				//Caso ele seja em porcentagem, ele calcula o valor de desconto em cima do valor do pedido.
				if($desconto->tipo_desconto === 'RS') {
					$valorDesconto = $desconto->desconto;
				}else if($desconto->tipo_desconto === 'PO') {
					$valortotal = $this->getSubTotal();
					$valorDesconto = $valortotal * $desconto->desconto;
				}
				
			}
			//$app 		= JFactory::getApplication();
			
			//$app->setUserState('com_popstil.carrinho.desconto',null);
		}
		return $valorDesconto;
	}
	
	public function getDescDesconto() {
		$desconto = JFactory::getApplication()->getUserState('com_popstil.carrinho.desconto');
		//print_r($desconto);
		
		$retorno = '';
		//echo 'entrou no desc';
		if(isset($desconto) && !empty($desconto)) {
			//$desconto = $this->getDesconto($desconto->code_desconto);
			
			//if(isset($desconto) && !empty($desconto)) {
				$retorno = $desconto->code_desconto ;
				
			//}
			//$app 		= JFactory::getApplication();
			
			//$app->setUserState('com_popstil.carrinho.desconto',null);
		}
		return $retorno;
	}
	
	public function getValorFrete() {
		$this->data = new stdClass();
		$app 		= JFactory::getApplication();
		
		//Pega o array de quadros enviados da tela de customização
		$this->valorFrete = (float)$app->getUserState('com_popstil.carrinho.valorFrete');
		$this->cepdigitado = $app->getUserState('com_popstil.carrinho.cepDigitado');
		
		//$app->setUserState('com_popstil.carrinho.valorFrete', '');
		
		return $this->valorFrete;
			
	}
	
	public function getCepdigitado() {
		$this->data = new stdClass();
		$app 		= JFactory::getApplication();
		
		//Pega o array de quadros enviados da tela de customização
		$this->cepdigitado = (string)$app->getUserState('com_popstil.carrinho.cepDigitado');
		//Assim, ele limpa a variavel da sessao, contendo o cep do usuario.
		//$app->setUserState('com_popstil.carrinho.cepdigitado', '');
		
		return $this->cepdigitado;
	}
	
	public function getCepinvalido() {
		$this->data = new stdClass();
		$app 		= JFactory::getApplication();
		
		$this->cepinvalido = $app->getUserState('com_popstil.carrinho.cepinvalido',1) === 'false' ? 0 : 1;
		
		//faz isso para caso o usuario atualizar a pagina ele nao mostre a msg de erro caso o cep for invalido
		$app->setUserState('com_popstil.carrinho.cepinvalido','true');
	
		return $this->cepinvalido;	
	}
	
	//Esse método pega o array que vem da customização, e joga ele dentro da variavel quadros.
	public function getQuadros() {
		
		
		//Inicia as variaveis
		$this->data = new stdClass();
		$app 		= JFactory::getApplication();
		$params		= JComponentHelper::getParams('com_popstil');
		
		//Pega o array de quadros enviados da tela de customização
		$this->quadros = (array)$app->getUserState('com_popstil.carrinho.data', array());
		
		return $this->quadros;
		
		//print_r($temp);
		
		//Apagando a variavel		
		//unset($temp);
		
		//Limpa os dados
		//$app->setUserState('com_popstilcustomizacao.carrinho.data', false);
		
	}
	
	/*public function getForm($data = array(), $loadData = true)
	{
		
		// Get the form.
		$form = $this->loadForm('com_popstilcustomizacao.registration', 'registration', array('control' => 'cadastro', 'load_data' => $loadData));
		if (empty($form)) {
			
			return false;
		}
		
		return $form;
	}
	
	protected function populateState()
	{
		print_r('entrou no populateState do carrinho');
		// Get the application object.
		$app	= JFactory::getApplication();
		$params	= $app->getParams('com_popstilcustomizacao');

		// Load the parameters.
		$this->setState('params', $params);
	}
	
	/*public function finalizarPedido() {
		
	}*/
	
	
	public function finalizarPedido() {
	
		$user =JFactory::getUser();
		
		//echo $user->guest;
		//echo '<br/>';
		
		if(!JFactory::getUser()->id) {
			$this->setError('Você não esta logando, clique <a href="/index.php/component/users/?view=login">aqui</a> para se logar ou se registrar.');
			//JFactory::getApplication()->setUserState('com_popstil.carrinho.mostrarLogin','1');
			//faz isso para caso o usuario atualizar a pagina ele nao mostre a msg de erro caso o cep for invalido
			return false;
		}
		
		//pega o carrinho que esta no cookie do usuario
		$carrinho_tela = $this->getCarrinho();
		
		//Verifica se o carrinho não esta vazio
		if(empty($carrinho_tela)) {
			$this->setError(JText::sprintf('COM_POPSTIL_CARRINHO_VAZIO', 'error'));
			return false;
		}
		
		//Verifica o valor do frete e se o frete foi digitado
		if($this->getCepdigitado() === '' || ($this->getValorFrete())== 0 ) {
			$this->setError(JText::sprintf('COM_POPSTIL_CARRINHO_CEP_FAILED', 'error'));
			return false;
		}
		
		
//		print_r($carrinho);
//		
//		$msg = '';
//		echo '<br/><br/>';		
//		foreach ($carrinho_tela as $key => $value) {
//
//			echo 'Item do pedido =>'.($key+1).'<br/>';
//			echo 'imagem => '.$value['imagem'].'<br/>';
//			echo 'Numero de pessoas => '.$value['numpessoas'].'<br/>';
//			foreach($value as $subchave => $quadro) {  
//				if((string) $subchave == 'quadros') {
//			  		$nrquadro = 0;
//			  		foreach($quadro as $subquadro => $quadroitem ) {
//			  			echo 'Quadro => '. ($nrquadro += 1).'<br/>';
//			  			echo 'Tamanho=> '. $quadroitem['tamanho'].'<br/>';
//			  			echo 'Moldura=> '. $quadroitem['moldura'].'<br/>';
//			  		}
//				}
//			}
//			echo '<br/>';
//		}
		
		$carrinho = $this->retornaCarrinhoCookie();
		//*Carrinho que sera gravado
		
		//Array com o resumo do pedido
		$resumopedido = array();	
		
		//print_r($carrinho);
				
		$carrinho_gravar = array();
		
		//echo '<br/>Frete:'.$this->getValorFrete().'<br/>';
		
		$tablePedido 	= JTable::getInstance('pedido', 'PopstilTable');
		$tableItem 	 	= JTable::getInstance('itempedido', 'PopstilTable');
		$tableQuadro	= JTable::getInstance('quadro', 'PopstilTable');
		
		$dadosPedido = array();
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(' u.id, u.nomecompleto ');
		$query->from('#__popstil_usuarios u');
		$query->where(' u.idusuario_joomla ='.$user->id);
		
		
		$db->setQuery((String) $query,0,1);
		$retorno = $db->loadObjectList();		
		$idusuario = $retorno[0] ->id;
		
//		echo 'Id do usuario:'.$retorno[0] ->id;
		$app 		= JFactory::getApplication();
		$tipofrete = $app->getUserState('com_popstil.carrinho.fretepac');
		
		$dadosPedido['popstil_usuario_idusuario'] = $idusuario;
		$dadosPedido['datagravacao'] = strftime('%Y-%m-%d %H:%M:%S',time());
		$dadosPedido['valor_frete'] = $this->getValorFrete();
		$dadosPedido['tipo_frete'] = $tipofrete == 1 ? 'PAC' : 'SEDEX';
		$dadosPedido['valor_desconto'] = $this->getValorDesconto();
		$dadosPedido['valortotal'] = $this->getSubTotal();
		$dadosPedido['status_pedido'] = 'ANA';
		
		//Armazena os dados no tablePedido para gravar
		if (!$tablePedido->bind($dadosPedido)) {
			//echo 'erro ao bind do pedido';
			$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_PEDIDO_BIND_FAILED', $tableEndereco->getError()));
			return false;
		}
		
		if (!$tablePedido->store()) {
		//	echo 'erro ao store do pedido';
			$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_PEDIDO_BIND_FAILED', $tableEndereco->getError()));
			return false;
		}
		
		$idpedido = $tablePedido->idpedido;
		
		$resumopedido['numeropedido'] 	= $idpedido;
		$resumopedido['subtotal']		= $this->getSubTotal();
		$resumopedido['valorfrete']		= $this->getValorFrete();
		$resumopedido['total']			= $this->getPrecoTotal();
		$resumopedido['valordesconto'] 	= $this->getValorDesconto();
		$resumopedido['cliente']		= $retorno[0]->nomecompleto;
		
		foreach ($carrinho as $key => $value) {
		
			$tableItem 	 	= JTable::getInstance('itempedido', 'PopstilTable');
			
			$dadositempedido = array();
			
			$dadositempedido['popstil_pedido_idpedido'] = $idpedido;
			$dadositempedido['produto_quantidade'] = 1;
			$dadositempedido['produto_nome'] = 'Quadro Popstil';
			$dadositempedido['produto_codigo'] = 1;
			$dadositempedido['status_pedido'] = 'ANA';
			
			$subtotalpedido = 0;
			foreach($value as $key =>$item) {
				if($key !== 'imagem' && $key !== 'idnumpessoas' && $key !== 'orientacao') {
					$subtotalpedido += intval($this->getPrecoQuadro($item['tamanho'], $value['idnumpessoas']));	
				}
			}
			
			//echo 'Total do item:'.$subtotalpedido;
			
			$dadositempedido['produto_preco'] = $subtotalpedido;
			$dadositempedido['nrpessoas'] = $value['idnumpessoas'];
			$dadositempedido['orientacao'] =$value['orientacao'];
			$dadositempedido['foto_cliente'] = $value['imagem'];
			
			if(!$tableItem->bind($dadositempedido)) {
				$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_ITEMPEDIDO_BIND_FAILED', $tableItem->getError()));
				return false;
			}
			
			if(!$tableItem->store()) {
				$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_ITEMPEDIDO_STORE_FAILED', $tableItem->getError()));
				return false;
			}
			
			$iditempedido = $tableItem->popstil_item_pedido_id;
			
			foreach($value as $chavefilho => $subitem) {
				if((string)($chavefilho) != 'imagem' && $chavefilho !== 'idnumpessoas' && $chavefilho !== 'orientacao') {
					$tableQuadro	= JTable::getInstance('quadro', 'PopstilTable');
					$dadosquadro = array();
					
					$dadosquadro['popstil_item_pedido_id'] = $iditempedido;
					$dadosquadro['popstil_tamanho_id'] = $subitem['tamanho'];
					$dadosquadro['popstil_moldura_id'] = $subitem['idcormoldura'];
					$dadosquadro['tamanho'] = $this->gettamanhoquadro($subitem['tamanho']);
					$dadosquadro['moldura'] = $this->getmoldura($subitem['idcormoldura']);
					$dadosquadro['popstil_fundo_id'] =$subitem['idfundo'];
					
					if(!$tableQuadro->bind($dadosquadro)) {
						$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_ITEMQUADRO_BIND_FAILED', $tableQuadro->getError()));
						return false;
					}
					
					if(!$tableQuadro->store()) {
						$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_ITEMQUADRO_STORE_FAILED', $tableQuadro->getError()));
						return false;
					}
					
				}
			}
		}
		
		$this->enviaremailconfirmapedido($resumopedido);

		//faz isso para caso o usuario atualizar a pagina ele nao mostre a msg de erro caso o cep for invalido
		JFactory::getApplication()->setUserState('com_popstil.carrinho.dadospedidofinalizado',$resumopedido);
		
		return true;		
		
	}
	
	public function getDesconto($coddesconto) {
		
		$db = JFactory::getDBO();
		
		$date = JFactory::getDate();
		$nowDate = $db->quote($date->toSql());
		
		$query = $db->getQuery(true);
		$query->select('* ')
			->from('#__popstil_descontos')
			->where(' code_desconto = \''.$coddesconto.'\'')
			->where(' ativo = 1')
			->where('(datainicio <= '.$nowDate.')')
			->where('(datafim >= '.$nowDate.')');

		$db->setQuery($query);
		$retorna = $db->loadObject();
		
		return $retorna;
				
	}
	
	public function enviaremailconfirmapedido($dados) {
		
		$mailer = JFactory::getMailer();
		
		$config = JFactory::getConfig();
		/*$sender = array( 
		    $config->getValue( 'luiz@proiz.com' ),
		    $config->getValue( 'config.fromname' ));
		 */
		$mailer->setSender('vendas@popstil.com');
		
		$user = JFactory::getUser();
		$recipient = $user->email;
		 
		$mailer->addRecipient('vendas@popstil.com');
		
		$body   = "<body style='background: #f6f6f6; text-align:center; font-family: Tahoma'>
			<div class='corpo_wrapper' style='background: #fff; width:750px; display: inline-block; border: 1px solid #c6c8ca; -webkit-box-shadow: 2px 2px 3px 0px #bcbec0;
			-moz-box-shadow: 2px 2px 3px 0px #bcbec0;box-shadow: 2px 2px 3px 0px #bcbec0;'>
				<div class='corpo' style='margin: 0px 70px 50px 70px;text-align: left;'>
					<div class='header'>
						<img src='http://www.popstil.com/images/logo_email.png' alt='Bem vindo' style='margin: 0px 0px 0px -70px;width: 750px;' />
					</div>
					
					<div class='titulo'>
						<h1 style='font-family: Tahoma;font-size: 30px;	color: #58595b;	font-weight: normal;text-align: center;	line-height: 60px;'>
							Um pedido acaba de ser finalizado!</h1>
						<p style='font-family: Tahoma;font-size: 16px;text-align: left;	line-height: 25px;'>
							Abaixo seguem as informações do pedido!</p> 
					</div>
					
					<div class='conteudo' style='margin-top: 30px;' >
						<h4 style='font-family: Tahoma;	font-size: 15px;font-weight: normal;'>
							Seus dados são:
						</h4>
						<div class='conteudo_info'>
							<h3 style='font-size: 18px;display: inline-block;'>Número de pedido:</h3>
							<h5 style='font-weight: normal;font-size:14px;display: inline-block;'>".$dados['numeropedido']."</h5>
						</div>
						<div class='conteudo_info' >
							<h3 style='font-size: 18px;display: inline-block;'>Sub total:</h3>
							<h5 style='font-weight: normal;display:font-size:14px; inline-block;'>R$".$dados['subtotal']."</h5>
						</div>
						<div class='conteudo_info'>
							<h3 style='font-size: 18px;display: inline-block;'>Valor do frete:</h3>
							<h5 style='font-weight: normal;display:font-size:14px; inline-block;'>R$".$dados['valorfrete']."</h5>
						</div>
						<div class='conteudo_info'>
							<h3 style='font-size: 18px;display: inline-block;'>Valor de desconto:</h3>
							<h5 style='font-weight: normal;display:font-size:14px; inline-block;'>R$".$dados['valordesconto']." </h5>
						</div>
						<div class='conteudo_info'>
							<h3 style='font-size: 18px;display: inline-block;'>Valor total:</h3>
							<h5 style='font-weight: normal;display:font-size:14px; inline-block;'>R$".$dados['total']." </h5>
						</div>
						<div class='conteudo_info'>
							<h3 style='font-size: 18px;display: inline-block;'>Cliente:</h3>
							<h5 style='font-weight: normal;display:font-size:14px; inline-block;'> ".$dados['cliente']." </h5>
						</div>
						<h4>Você pode:</h4>
						
						<div class='links'>
							<p style='margin: 0 auto;font-size: 15px;'>
								<a href='http://www.popstil.com/administrator/index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido=".$dados['numeropedido']."' style='text-decoration: none;color: #0093d0;'>Acessar pedido</a>
							</p>
						</div>
						<br/>
						<h4>Se você não realizou este cadastro, avise-nos <b style='color: #0093d0;	font-weight: normal;'>sac@popstil.com</b></h4>
						<h4>Em caso de dúvidas, visite nossa página de <u><a href='http://www.popstil.com'>perguntas frequentes</a></u></h4>
						<br/>
						<h4>Atenciosamente,</h4>
						<h4>Popstil.</h4>
					</div>
				</div>
			</div>";
		
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		/*$mailer->CharSet = "UTF8";*/
		$mailer->setSubject('Pedido realizado: Pedido '.$dados['numeropedido']);
		$mailer->setBody($body);
		$mailer->AddCustomHeader('Content-type: text/html; charset=utf-8');
		
		$send = $mailer->Send();		
	}

}