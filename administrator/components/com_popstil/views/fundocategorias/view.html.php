<?php

defined('_JEXEC') or die ('Acesso restrito');

jimport('joomla.application.component.view');

class PopstilViewFundoCategorias extends JViewLegacy {

	public function display($tpl = null) {
	
		$items 			= $this->get('Items');
		$pagination 	= $this->get('Pagination');
		$state	= $this->get('State');
		
		//$this->sortDirection = $state->get('list.direction');
        //$this->sortColumn = $state->get('list.ordering');
	
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->items = $items;
		$this->pagination = $pagination;
		
		parent::display($tpl);
		
		$this->addToolBar();
		
		$this->setDocument();
		
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Gerenciar Categorias de fundos de quadro'));
		
	}
	
	protected function addToolBar() 
	{
		JToolBarHelper::title('Gerenciar Categorias de fundos de quadro');
		//JToolBarHelper::deleteList('', 'descontos.delete');
		JToolBarHelper::deleteList('', 'fundocategorias.delete');
		JToolBarHelper::editList('fundocategoria.edit');
		JToolBarHelper::addNew('fundocategoria.add');
	}

}