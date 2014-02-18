<?php

defined('_JEXEC') or die ('Acesso restrito');

jimport('joomla.application.component.view');

class PopstilViewUsuarios extends JViewLegacy {

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
		//JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
		
		parent::display($tpl);
		
		$this->setDocument();
		
	}
	
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
	
	function formatar ($string, $tipo = "")
	{
		$string = preg_replace("[^0-9]", "", $string);
		if (!$tipo)
		{
			switch (strlen($string))
			{
				case 10: 	$tipo = 'fone'; 	break;
				case 8: 	$tipo = 'cep'; 		break;
				case 11: 	$tipo = 'cpf'; 		break;
				case 14: 	$tipo = 'cnpj'; 	break;
			}
		}
		switch ($tipo)
		{
			case 'fone':
				$string = '(' . substr($string, 0, 3) . ') ' . substr($string, 3, 4) . '-' . substr($string, 8);
			break;
			case 'cep':
				$string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
			break;
			case 'cpf':
				$string = substr($string, 0, 3) . '.' . substr($string, 3, 3) . '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
			break;
			case 'cnpj':
				$string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3) . '/' . substr($string, 8, 4) . '-' . substr($string, 12, 2);
			break;
			case 'rg':
				$string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3);
			break;
		}
		return $string;
	}
	
	protected function getSortFields()
	{
		return array(
				'a.nomecompleto' => JText::_('nomecompleto'),
				'a.username' => JText::_('JGLOBAL_USERNAME')
		);
	}
	

}