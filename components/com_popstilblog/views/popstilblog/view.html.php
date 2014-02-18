<?php
//defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');


class PopstilBlogViewPopstilBlog extends JViewLegacy {
	
	function display($tpl = null) {
		
		$this->prepareDocument();
		
		//echo '<br/><br/><br/><br/><br/><br/>';
		//$this->state	= $this->get('State');
		
		//$this->params = $this->state->get('params');
		
		//$url = $this->params->def('url', '');
		
		$categoria = JRequest::getVar('categoria');
		//echo 'categoria = ';
		//print_r($categoria);
		
		$this->categoria = $categoria;

		$this->listamaterias 	= $this->get('materias');
		$this->ultimamateria 	= $this->get('lastmateria');
		$this->listacategorias 	= $this->get('categorias');		
		
		parent::display($tpl);
	}	
	
	public function prepareDocument() {
		$document = JFactory::getDocument();
		//Importa o arquivo css criado para as modificações do layout
		$document->addStyleSheet(JURI::root() . "/components/com_popstilblog/views/popstilblog/css/estilos.css");
		$document->addStyleSheet(JURI::root() . "/components/com_popstilblog/assets/css/estilos_comuns.css");
		
		$document->addScript('components/com_popstil/assets/js/jquery.min.1.7.1.js');
		$document->addScript(JURI::root() . '/components/com_popstilblog/views/popstilblog/js/popstilblog.js');
		//$document->addScript(JURI::root() . '/components/com_popstil/assets/js/faq.js');
	}
	
}

?>