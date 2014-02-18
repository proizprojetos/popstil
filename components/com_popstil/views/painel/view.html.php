<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PopstilViewPainel extends JViewLegacy {
	
	protected 	$ativo;
	protected 	$data;
	protected 	$state;
	public		$pedidos;
	public		$pedidosandamento;
	public		$itensdepedidos;
	
	//Primeiro método a ser chamado ao iniciar o carregamento da pagina.
	function display($tpl = null) {
	
		$user =JFactory::getUser();
		
		$this->user = $user;
		
		$this->data		= $this->get('Data');
		//$this->state	= $this->get('State');
		$this->pedidos			= $this->get('pedidos');
		$this->pedidosandamento = $this->get('pedidosandamento');
		$this->itensdepedidos	= $this->get('itensdepedidosemandamento');
		$this->artes			= $this->get('artesconcluidas');
		
		if($this->getLayout() === 'pagamentorealizado') {
			//$this->setMessage('Estamos aguardando a confirmação do pagamento', 'warning');	
			JFactory::getApplication()->enqueueMessage('Estaremos aguardando a confirmação do pagamento para iniciarmos a produção do seu Popstil.');
		}
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		//$active = JFactory::getApplication()->getMenu()->getActive();
		$this->prepareDocument();	
		
		if($this->getLayout() === 'detalhepedido') {
			$this->pedido = $this->get('pedidopagamento');
		}
		
		if($this->getLayout() === 'alterardados') {
			$this->data = 	$this->get('usuario');
		}
		
		/*Caso ele entre na tela para realizar o pagamento do pedido*/
		if($this->getLayout() === 'realizarpagamento') {
//			$idpedido = JRequest::getVar('idpedido');
			$this->pedido = $this->get('pedidopagamento');
			//print_r($this->pedido);
		}
		
		
		
		parent::display($tpl);
	}
	
	protected function prepareDocument() {
	
		//print_r('entrou no prepare Document<br/>');
		
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$document = JFactory::getDocument();
		
		//$document->addScript(JURI::root() . "/components/com_popstil/views/popstilcadastrousuario/registervalidation.js");
		$document->addStyleSheet(JURI::root() . "/components/com_popstil/assets/css/estilos-painel.css");
		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/jquery.min.1.7.1.js');
		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/jquery-ui.js');
		$document->addScript(JURI::root() . 'components/com_popstil/assets/js/jquery.form.js');
		$document->addScript(JURI::root() . 'components/com_popstil/assets/js/ajaxupload/file_uploads.js');
		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/popupoverlay.js');
		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/painel.js');
		
		$menu = $menus->getActive();
	}
	
	function displaydetalhepedido($tpl = null) {
		echo 'entrou no abc<br/>';
		
		echo 'Id: '.JRequest::getVar('idpedido').'<br/>';
		
		//parent::display($tpl);
	}
	
//	protected function preparedDocument() {
//		$document = JFactory::getDocument();
//		
//		$document->addStyleSheet(JURI::root() . "/components/com_popstil/assets/css/estilos-painel.css");
//		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/jquery.min.1.7.1.js');
		//$document->addScript(JURI::root() . '/components/com_popstil/assets/js/jquery-ui.js');
//		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/painel.js');
//		
//	}
	
}

?>