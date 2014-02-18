<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.controller');

class PopstilController extends JControllerLegacy {

	
	function display($cachable = false, $urlparams = false) {
		
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'Dashboard'));
		
		parent::display($cachable, $urlparams);
		
		PopstilHelper::addSubmenu('Dashboard');
		
	}
}