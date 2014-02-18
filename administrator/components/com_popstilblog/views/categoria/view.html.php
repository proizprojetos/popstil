<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.view');


class PopstilBlogViewCategoria extends JViewLegacy {
	
	public function display($tpl = null) {
		
		$form = $this->get('Form');
		$item = $this->get('Item');
		
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
				
		$this->form = $form;
		$this->item = $item;
		
		$this->addToolBar();
		
		$this->setDocument();
		
		parent::display($tpl);
		
	}
	
	protected function setDocument() {
		
		$document = JFactory::getDocument();
		$document->addScript('components/com_popstilblog/views/categoria/js/jscolor/jscolor.js');
	}
	
	protected function addToolBar() {
		JRequest::setVar('hidemainmenu', true);
		
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_POPSTILBLOG_MANAGER_NEW') : JText::_('COM_POPSTILBLOG_MANAGER_EDIT'), 'tag');
		JToolBarHelper::save('categoria.save');
		JToolBarHelper::cancel('categoria.cancel');
		
	}
	
}

?>