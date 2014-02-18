<?php
//defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PopstilViewPaginainexistente extends JViewLegacy {
	
	function display($tpl = null) {
		
		$this->prepareDocument();
			
		parent::display($tpl);
	}	
	
	public function prepareDocument() {
		$document = JFactory::getDocument();
		//Importa o arquivo css criado para as modificações do layout
		$document->addStyleSheet(JURI::root() . "/components/com_popstil/assets/css/paginainexistente.css");
	}
	
}

?>