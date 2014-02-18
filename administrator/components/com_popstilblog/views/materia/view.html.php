<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.view');


class PopstilBlogViewMateria extends JViewLegacy {
	
	public function display($tpl = null) {
		
		$form = $this->get('Form');
		$item = $this->get('Item');
		
		$tags = $this->get('tags');
		
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
				
		$this->form = $form;
		$this->item = $item;
		$this->tags = $tags;
		
		$this->addToolBar();
		
		parent::display($tpl);
		
	}
	
	protected function addToolBar() {
		JRequest::setVar('hidemainmenu', true);
		
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_POPSTILBLOG_MANAGER_NEW') : JText::_('COM_POPSTILBLOG_MANAGER_EDIT'), 'tag');
		JToolBarHelper::save('materia.save');
		JToolBarHelper::cancel('materia.cancel');
		
	}
	
}

?>