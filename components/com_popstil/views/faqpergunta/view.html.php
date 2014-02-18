<?php
//defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PopstilViewFaqPergunta extends JViewLegacy {
	
	function display($tpl = null) {
		
		$this->prepareDocument();
		
		$this->listaPerguntas		= $this->get('perguntas');
			
		parent::display($tpl);
	}	
	
	public function prepareDocument() {
		$document = JFactory::getDocument();
		//Importa o arquivo css criado para as modificações do layout
		$document->addStyleSheet(JURI::root() . "/components/com_popstil/assets/css/faq.css");
		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/jquery.min.1.7.1.js');
		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/faq.js');
	}
	
}

?>