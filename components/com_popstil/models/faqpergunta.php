<?php

defined('_JEXEC') or die('Restricted access');

//jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

class PopstilModelFaqPergunta extends JModelForm {
	
	//protected $msg;
	protected $data;
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_popstil.faqpergunta', 'faqpergunta', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}
	
	public function getPerguntas () {
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select('p.*');
		$query->from('#__popstil_perguntas_faq p');
		$query->where('p.ativo = 1');
		$db->setQuery((String) $query);
		$perguntas = $db->loadObjectList();
		
		return $perguntas;
	}

}

?>