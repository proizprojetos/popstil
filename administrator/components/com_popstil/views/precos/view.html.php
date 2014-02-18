<?php

defined('_JEXEC') or die ('Acesso restrito');

jimport('joomla.application.component.view');

class PopstilViewPrecos extends JViewLegacy {

	public function display($tpl = null) {
	
		$items 			= $this->get('Lista');
		//$pagination 	= $this->get('Pagination');
		//$state	= $this->get('State');
	
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->items = $items;
		//$this->pagination = $pagination;
		
		parent::display($tpl);
		
		$this->addToolBar();
		
		$this->setDocument();
		
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Gerenciar Preços dos quadros'));
		
	}
	
	protected function addToolBar() 
	{
		JToolBarHelper::title('Gerenciar Precos');
		JToolBarHelper::custom('precos.salvar','save','save','Salvar', false);
		JToolBarHelper::custom('preco.cancelar', 'cancel','cancel','Cancelar',false);
	}
	

}