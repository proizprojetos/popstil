<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.view');


class PopstilViewUsuario extends JViewLegacy {
	
	public function display($tpl = null) {
		
		$form = $this->get('Form');
		$item = $this->get('Item');
		
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		if($this->getLayout() === 'detalheusuario') {
			$cliente 		= $this->get('cliente');
			
			$this->cliente = $cliente;
		}
				
		$this->form = $form;
		$this->item = $item;
		
		//$this->addToolBar();
		
		parent::display($tpl);
		
	}
	
	protected function addToolBar() {
		JRequest::setVar('hidemainmenu', true);
		
		$isNew = ($this->item->id == 0);
		//JToolBarHelper::title($isNew ? JText::_('COM_POPSTIL_MANAGER_SLIDER_NEW') : JText::_('COM_POPSTIL_MANAGER_SLIDER_EDIT'), 'slider');
		//JToolBarHelper::save('slider.save');
		JToolBarHelper::cancel('usuario.cancel');
		JToolBarHelper::custom('usuario.cancelar', 'cancel','cancel','Cancelar',false);
		
	}
	
}

?>