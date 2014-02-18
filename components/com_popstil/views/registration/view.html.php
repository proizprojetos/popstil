<?php
//defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PopstilViewRegistration extends JViewLegacy {
	
	protected $ativo;
	protected $data;
	protected $state;
	
	//Primeiro método a ser chamado ao iniciar o carregamento da pagina.
	function display($tpl = null) {
		
		//print_r('display do tmpl<br/>');
	
		$this->data		= $this->get('Data');
		//$this->state	= $this->get('State');
		
		if (count($errors = $this->get('Errors')))
		{
			echo 'entrou no errors';
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		
		//print_r($this->state);
	
		//$this->ativo	 = $this->get('Activate');
		print_r('<br/>');

		
		
		//$active = JFactory::getApplication()->getMenu()->getActive();
		$this->prepareDocument();	
		
		parent::display($tpl);
	}
	
	protected function prepareDocument() {
	
		//print_r('entrou no prepare Document<br/>');
		
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$document = JFactory::getDocument();
		
		$document->addStyleSheet(JURI::root() . "/components/com_popstil/assets/css/registration.css");
		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/jquery.min.1.7.1.js');
		$document->addScript('components/com_popstil/assets/js/jquery-ui1.10.2.js');
		$document->addScript('components/com_popstil/assets/js/jquery.maskedinput.min.js');
	//	$document->addScript(JURI::root() . "/components/com_popstil/views/registration/registervalidation.js");
		$document->addScript('components/com_popstil/assets/js/cadastrousuario.js');
		
		$menu = $menus->getActive();
	}
}

?>