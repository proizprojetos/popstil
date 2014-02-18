<?php

defined('_JEXEC') or die ('Acesso Restrito');

abstract class PopstilBlogHelper {
	
	//Configura a barra de menus lateral
	public static function addSubmenu($submenu) {
		
		$view = JRequest::getVar('view');
		
		JSubMenuHelper::addEntry(JText::_('COM_POPSTILBLOG_SUBMENU_DASHBOARD'), 'index.php?option=com_popstilblog', $view == 'Dashboard');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTILBLOG_SUBMENU_TAG'), 'index.php?option=com_popstilblog&view=tags', $view == 'tags' || $view == 'tag');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTILBLOG_SUBMENU_CATEGORIA'), 'index.php?option=com_popstilblog&view=categorias', $view == 'categorias' || $view == 'categoria');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTILBLOG_SUBMENU_MATERIA'), 'index.php?option=com_popstilblog&view=materias', $view == 'materias' || $view == 'materia');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTILBLOG_SUBMENU_SUGESTAO'), 'index.php?option=com_popstilblog&view=sugestaos', $view == 'sugestoes' || $view == 'sugestao');
	}
	
	public static function filterText($text)
	{
		JLog::add('ContentHelper::filterText() is deprecated. Use JComponentHelper::filterText() instead.', JLog::WARNING, 'deprecated');

		return JComponentHelper::filterText($text);
	}
	
}