<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class PopstilCustomizacaoController extends JControllerLegacy {

	public function display($cachable = false, $urlparams = false) {
		
		//print_r('display do controller pai<br/>');
		
		$document		= JFactory::getDocument();
		
		$vName	 = JRequest::getCmd('view', 'login');
		$vFormat = $document->getType();
		$lName	 = JRequest::getCmd('layout', 'default');

		if ($view = $this->getView($vName, $vFormat)) {
			switch($vName) {
				case 'popstilcadastrousuario':
				//Se o usuario esta logado redireciona para a pagina do painel de controle
				$user = JFactory::getUser();
				if( $user->get('guest') != 1) {
					print_r('usuario logado');
					return;
				}
				
				$model = $this->getModel('registration');
				break;
				
				case 'popstilcustomizacao' :
					print_r($vName);
					$model = $this->getModel('customizacao');
					break;
				
				case 'popstilcarrinho' :
					$model = $this->getModel('carrinho');
					break;
			}
		}
		
		// Push the model into the view (as default).
		$view->setModel($model, true);
		$view->setLayout($lName);

		// Push document object into the view.
		$view->assignRef('document', $document);

		$view->display();
	}

}

?>