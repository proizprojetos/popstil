<?php

defined('_JEXEC') or die('Restricted access');

//jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

class PopstilModelEnviarEmail extends JModelForm {
	
	function enviaremail() {
		return 'Enviar email do model';
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		
		return false;
	}

}

?>