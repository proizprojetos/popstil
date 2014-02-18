<?php

defined('_JEXEC') or die ('Acesso Restrito');

abstract class HelloWorldHelper {
	
	/**
	* Configura a barra de links
	*/
	public static function addSubmenu($submenu) {
		
		$view = JRequest::getVar('view');
	
		JSubMenuHelper::addEntry(JText::_('COM_HELLOWORLD_SUBMENU_MESSAGES'), 'index.php?option=com_helloworld', $view == 'HelloWorlds');
		JSubMenuHelper::addEntry(JText::_('COM_HELLOWORLD_SUBMENU_CATEGORIES'), 'index.php?option=com_categories&view=categories&extension=com_helloworld', $submenu == 'categories');
		
		JSubMenuHelper::addEntry(JText::_('Pessoas'), 'index.php?option=com_helloworld&view=pessoas', $view == 'pessoas');
		
		//JSubMenuHelper::addFilter('Filtro pessoas', 'name', '"1"', false);		
		
		//seta algumas propriedades globais
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-helloworld' . '{background-image: url(../media/com_helloworld/images/tux-48x48.png);}');
		if($submenu == 'categories') {
			$document->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION_CATEGORIES'));
		}
	}
	
}