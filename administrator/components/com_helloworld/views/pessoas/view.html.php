<?php 

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.view');

class HelloWorldViewPessoas extends JViewLegacy {
	
	function display($tpl = null) {
	
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
		
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->items = $items;
		$this->pagination = $pagination;
		
		parent::display($tpl);
		
		$this->addToolBar();
				
		// Set the document
		$this->setDocument();
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Gerenciar Pessoas'));
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title('Gerenciar Pessoas');
		JToolBarHelper::deleteList('', 'helloworlds.delete');
		JToolBarHelper::editList('helloworld.edit');
		JToolBarHelper::addNew('helloworld.add');
	}
	
	
	
}