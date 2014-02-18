<?php

defined('_JEXEC') or die ('Acesso restrito');

jimport('joomla.application.component.view');

class PopstilViewPedidos extends JViewLegacy {

	public function display($tpl = null) {
	
		$items 			= $this->get('Items');
		$pagination 	= $this->get('Pagination');
		$state	= $this->get('State');
		
		$this->sortDirection = $state->get('list.direction');
        $this->sortColumn = $state->get('list.ordering');
	
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->items = $items;
		$this->pagination = $pagination;
		
		parent::display($tpl);
		
		$this->setDocument();
		
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Gerenciar Pedidos'));
		
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title('Pedidos');
		JToolBarHelper::deleteList('', 'helloworlds.delete');
		JToolBarHelper::editList('helloworld.edit');
		JToolBarHelper::addNew('helloworld.add');
	}
	
	protected function getSortFields()
	{
		return array(
				'p.idpedido' => JText::_('idpedido'),
				'p.datagravacao' => JText::_('datagravacao'),
				'p.status_pedido' => JText::_('status_pedido'),
				'p.valortotal' => JText::_('valortotal'),
				'p.popstil_usuario_idusuario' => JText::_('postil_usuario_idusuario')
		);
	}

}