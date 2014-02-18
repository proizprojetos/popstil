<?php

defined('_JEXEC') or die ('Acesso restrito');

jimport('joomla.application.component.view');

class PopstilViewFaqPerguntas extends JViewLegacy {

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
		$document->setTitle(JText::_('Gerenciar Perguntas do FAQ'));
		
	}
	
	protected function addToolBar() 
	{
		JToolBarHelper::title('Gerenciar Perguntas do FAQ');
		JToolBarHelper::deleteList('', 'faqperguntas.delete');
		JToolBarHelper::editList('faqpergunta.edit');
		JToolBarHelper::addNew('faqpergunta.add');
	}

}