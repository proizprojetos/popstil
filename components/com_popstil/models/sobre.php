<?php

defined('_JEXEC') or die('Restricted access');

//jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

class PopstilModelSobre extends JModelForm {
	
	//protected $msg;
	protected $data;
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_popstil.sobre', 'sobre', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}
	
	public function getListasobre () {
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select('p.*');
		$query->from('#__popstil_sobre p');
		$query->where('p.ativo = 1');
		$db->setQuery((String) $query);
		$perguntas = $db->loadObjectList();
		
		return $perguntas;
	}

}

?>