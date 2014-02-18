<?php 

defined('_JEXEC') or die ('Acesso restrito');

jimport('joomla.application.component.modeladmin');

class HelloWorldModelPessoa extends JModelAdmin {
	
	public function getTable($type="Pessoa", $prefix="HelloWorldTable", $config=array() ) {
		
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) {
		
		//Pega o formulario
		$form = $this->loadForm('com_helloworld.pessoa', 'pessoa', array('control' => 'jform', 'load_data' => $loadData));
		
		if(empty($form)) {
			echo 'Formulario pessoa vazio';
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
		$data = JFactory::getApplication()->getUserState('com_helloworld.edit.pessoa.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
}