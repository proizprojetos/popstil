<?php
//defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PopstilViewSobre extends JViewLegacy {
	
	function display($tpl = null) {
		
		$this->prepareDocument();
		
		$this->itens		= $this->get('listasobre');
			
		parent::display($tpl);
	}	
	
	public function prepareDocument() {
		$document = JFactory::getDocument();
		//Importa o arquivo css criado para as modificações do layout
		$document->addStyleSheet(JURI::root() . "/components/com_popstil/assets/css/sobre.css");
		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/jquery.min.1.7.1.js');
		$document->addScript('components/com_popstil/assets/js/jquery-ui1.10.2.js');
		$document->addScript(JURI::root() . '/components/com_popstil/assets/js/sobre.js');
	}
	
}

?>