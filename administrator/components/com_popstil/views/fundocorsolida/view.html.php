<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.view');


class PopstilViewFundoCorSolida extends JViewLegacy {
	
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
		
		$this->setDocument();
		
		$this->addToolBar();
		
		parent::display($tpl);
		
	}
	
	protected function setDocument() {
		
		$document = JFactory::getDocument();
		$document->addScript('components/com_popstil/views/fundocorsolida/js/jscolor/jscolor.js');
	}
	
	protected function addToolBar() {
		JRequest::setVar('hidemainmenu', true);
		
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_POPSTIL_MANAGER_FUNDOCORSOLIDA_NEW') : JText::_('COM_POPSTIL_MANAGER_FUNDOCORSOLIDA_EDIT'), 'fundocorsolida');
		JToolBarHelper::save('fundocorsolida.save');
		JToolBarHelper::cancel('fundocorsolida.cancel');
		
	}
	
}

?>