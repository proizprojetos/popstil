<?php 

defined('_JEXEC') or die('Acesos restrito');

jimport('joomla.application.component.modeladmin');

class PopstilModelSobre extends JModelAdmin {
	
	public function getTable($type="Sobre", $prefix="PopstilTable", $config=array() ) {
		return JTable::getInstance($type, $prefix, $config);	
	}
	
	public function getForm($data = array(), $loadData = true) {
	
		$form = $this->loadForm('com_popstil.sobre', 'sobre', array('control' => 'jform', 'load_data' =>$loadData));
		
		if(empty($form)) {
			return false;
		}
		return $form;		
	}
	
	/**
	*	Método responsavel por pegas os dados que serão injetados no formulario
	*/
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_popstil.edit.sobre.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
}