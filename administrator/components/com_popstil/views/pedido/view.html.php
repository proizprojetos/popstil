<?php

/**
 * @version		$Id: view.html.php 51 2010-11-22 01:33:21Z chdemko $
 * @package		Joomla16.Tutorials
 * @subpackage	Components
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @author		Christophe Demko
 * @link		http://joomlacode.org/gf/project/helloworld_1_6/
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorld View
 */
class PopstilViewPedido extends JViewLegacy
{
	/**
	 * View form
	 *
	 * @var		form
	 */
	protected $form = null;
	//protected $pedido;
	//protected $itensdopedido;

	/**
	 * display method of Hello view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// get the Data
		
		//Verifica qual layout foi escolhido, assim pega os dados referente ao layout
		if($this->getLayout() === 'visualizarpedido') {
			$pedido 		= $this->get('pedido');
			$itenspedido 	= $this->get('itenspedido');
			$quadrospedido 	= $this->get('quadrospedido');
			
			// Assign the Data
			$this->pedido = $pedido;
			$this->itenspedido = $itenspedido;
			$this->quadrospedido = $quadrospedido;
		}
		
		
		//$form = $this->get('Form');
		//$item = $this->get('Item');
		//$script = $this->get('Script');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		

		// Set the toolbar
		$this->addToolBar();
              
		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
		JToolBarHelper::title(JText::_('COM_POPSTIL_PEDIDO_DETALHE'));
//		JToolBarHelper::save('pedido.salvar');
		JToolBarHelper::custom('pedido.salvar','save','save','Salvar', false);
		JToolBarHelper::custom('pedido.cancelar', 'cancel','cancel','Cancelar',false);
		
		//JToolBarHelper::cancel($task = 'pedido.cancel', 'JTOOLBAR_CANCEL');
		
		
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		//$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_POPSTIL_PEDIDO_DETALHE'));
		
		//Adiciona o CSS
		$document->addStyleSheet(JURI::root() . "/administrator/components/com_popstil/assets/css/pedidos.css");
		
	}
}
