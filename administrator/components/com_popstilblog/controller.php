<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.controller');

class PopstilBlogController extends JControllerLegacy {

	
	function display($cachable = false, $urlparams = false) {
		
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'Dashboard'));
		
		parent::display($cachable, $urlparams);
		
		PopstilBlogHelper::addSubmenu('Dashboard');
		
	}
}