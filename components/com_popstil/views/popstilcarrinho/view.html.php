<?php
//defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PopstilViewPopstilCarrinho extends JViewLegacy {
	
	protected $quadros;
	protected $carrinho;
	protected $carrinho_tela;
	protected $valorFrete = 0.00;
	protected $cepdigitado;
	protected $cepinvalido = 1;
	public $valorSubtotal;
	public $valorTotal;
	protected $mostrarLogin = 0;
	public $dadospedidorealizado = array();
	
	function display($tpl = null) {
		
		$app 		= JFactory::getApplication();
		
		$this->valorFrete		= $this->get('valorFrete');
		$this->fretepac			= $app->getUserState('com_popstil.carrinho.fretepac');
				
		$this->cepdigitado  	= $this->get('cepdigitado');
		$this->cepinvalido		= $this->get('cepinvalido');
		
		$this->carrinho_tela	= $this->get('carrinho');
		
		$this->valorSubtotal	= $this->get('subTotal');
		$this->valorTotal	 	= $this->get('precoTotal');
		$this->valorDesconto	= $this->get('valorDesconto');
		$this->descDesconto	= $this->get('descDesconto');
		
		$this->set('limpaVariaveis');
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		//Utilizado quando o usuario finalizida o pedido, aqui contem os dados do pedido realizado
		$this->dadospedidorealizado = (array)JFactory::getApplication()->getUserState('com_popstil.carrinho.dadospedidofinalizado', array());
		JFactory::getApplication()->setUserState('com_popstil.carrinho.dadospedidofinalizado', '');
		
		//$this->mostrarLogin = JFactory::getApplication()->getUserState('com_popstil.carrinho.mostrarLogin');
		
		//echo '<br/>login: '.$this->mostrarLogin;
		/*session_start();
		if(isset($_SESSION['carrinho'])) {
			$carrinho = $_SESSION['carrinho'];
			print_r(($carrinho));			
		}else {
			echo "Carrinho vazio<br/>";
		}
//		unset($_SESSION['carrinho']);
		//print_r(sizeof($carrinho));
		
		
		
		//
		//	Monta o array que sera mostrado na tela para o usuario
		//
		$pesoquadros = 0;
		
		$this->carrinho_tela = array();
		
		foreach($carrinho as $chave => $item ){
			
			$popstil = array();			
			$popstil['imagem'] = $item['imagem'];
			$popstil['numpessoas'] = $this->getnumerodepessoas($item[0]['idnumpessoas']);
			$popstil['numquadros'] = sizeof($item) - 1;
			
			foreach($item as $chavefilho => $subitem) {
				if((string)($chavefilho) != 'imagem') {
					//$numeroquadros += 1;
					$pesoquadros += $this->getPesoQuadro($subitem['tamanho']);
					$quadro = array();
					$quadro['tamanho'] = $this->gettamanhoquadro($subitem['tamanho']);
					$quadro['moldura'] = $this->getmoldura($subitem['idcormoldura']);
					$popstil['quadros'][$chavefilho] = $quadro;
				}
			}
			array_push($this->carrinho_tela,$popstil);
		}
		echo '<br /><br />';
		print_r($this->carrinho_tela);
				
		$this->carrinho = $carrinho;
		
		$app = JFactory::getApplication();
		
		//Coloca na sessao do usuario o preço para calcular o frete.
		$precoquadros = (string)$this->getSubTotal();
		$app->setUserState('com_popstilcustomizacao.carrinho.precoquadros',$precoquadros);
		
		//Coloca na sessao tambem o peso dos quadros
		$app ->setUserstate('com_popstilcustomizacao.carrinho.pesoquadros', $pesoquadros);		
		*/
		parent::display($tpl);
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
		
		return ($moldura[0] -> titulo);
	}
	
	/*function getSubTotal() {
		$subtotal = 0;
		foreach($this->carrinho as $chave => $item ){
			foreach($item as $subchave =>$subitem) {
				$subtotal += intval($this->getPrecoQuadro($subitem['tamanho'], $subitem['idnumpessoas']));	
			}
		}
		return $subtotal;
	}
	
	function getPrecoTotal() {
		$precototal = 0;
		
		$precototal += $this->getSubTotal();
		$precototal += $this->getValorFrete();
		$precototal = $precototal -  99;
		
		return $precototal;
		
	}*/
	
	function getPrecoQuadro($idTamanho, $idNumPessoas) {
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select('* ');
		$query->from('#__popstil_customizacao_numeropessoas');
		$query->where(' id_numpessoas = '.$idNumPessoas.' and id_tamanho = '.$idTamanho);
		
		
		//Seta no query para trazer apenas um resultado.
		//o set query recebe tres parametros sendo eles 1ª query, o 2ª inicio, 3ª o limite para trazer
		$db->setQuery((String) $query,0,1);
		$retorno = $db->loadObjectList();
		
		return ($retorno[0] -> preco);		
	}
	
	function getPesoQuadro($idTamanho) {
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
	
	function getValorFrete() {
		return $this->valorFrete;	
	}
	
//	function getValorDesconto() {
//	
//		if($this->getSubtotal() == 0) {
//			$this->setMessage(JText::sprintf('COM_POPSTIL_CARRINHO_VAZIO'), 'warning');
//			
//			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=popstilcarrinho', false));
//			return false;
//		}
//		
//		$valorDesconto = 0;
//		$desconto = JFactory::getApplication()->getUserState('com_popstil.carrinho.desconto');
		//print_r($desconto);
//		if(isset($desconto) && !empty($desconto)) {
//			print_r($desconto);
			//Caso o tipo de desconto seja RS, ou seja reais, ele apenas adiciona o valor de desconto a variavel.
			//Caso ele seja em porcentagem, ele calcula o valor de desconto em cima do valor do pedido.
//			if($desconto->tipo_desconto === 'RS') {
//				$valorDesconto = $desconto->desconto;
//			}else if($desconto->tipo_desconto === 'PO') {
//				$valortotal = $this->getSubTotal();
//				$valorDesconto = $valortotal * $desconto->desconto;
//			}
//			
//			$app 		= JFactory::getApplication();
//			
//			$app->setUserState('com_popstil.carrinho.desconto',null);
//		}
//		return $valorDesconto;		
//	}
	
}

?>