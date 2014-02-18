<?php

defined('_JEXEC') or die ('Acesso Restrito');

abstract class PopstilHelper {
	
	//Configura a barra de menus lateral
	public static function addSubmenu($submenu) {
		
		$view = JRequest::getVar('view');
		
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_DASHBOARD'), 'index.php?option=com_popstil', $view == 'Dashboard');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_SLIDER'), 'index.php?option=com_popstil&view=sliders', $view == 'sliders' || $view == 'slider');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_DESCONTOS'), 'index.php?option=com_popstil&view=descontos', $view == 'descontos' || $view == 'desconto');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_FUNDOCATEGORIA'), 'index.php?option=com_popstil&view=fundocategorias', $view == 'fundocategorias' || $view == 'fundocategoria');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_FUNDOSUBCATEGORIA'), 'index.php?option=com_popstil&view=fundosubcategorias', $view == 'fundosubcategorias' || $view == 'fundosubcategoria');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_FUNDOPADRAOGRAFICO'), 'index.php?option=com_popstil&view=fundopadraograficos', $view == 'fundopadraograficos' || $view == 'fundopadraografico');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_FUNDOCORSOLIDA'), 'index.php?option=com_popstil&view=fundocorsolidas', $view == 'fundocorsolidas' || $view == 'fundocorsolida');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_CLIENTES'), 'index.php?option=com_popstil&view=usuarios', $view == 'usuarios' || $view == 'usuario');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_PEDIDOS'), 'index.php?option=com_popstil&view=pedidos', $view == 'pedidos'|| $view=='pedido');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_FAQ'), 'index.php?option=com_popstil&view=faqperguntas', $view == 'faqperguntas' || $view == 'faqpergunta');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_SOBRE'), 'index.php?option=com_popstil&view=sobres', $view == 'sobres' || $view == 'sobre');
		JSubMenuHelper::addEntry(JText::_('COM_POPSTIL_SUBMENU_PRECO'), 'index.php?option=com_popstil&view=precos', $view == 'precos' || $view == 'preco');
		
	}
	
}