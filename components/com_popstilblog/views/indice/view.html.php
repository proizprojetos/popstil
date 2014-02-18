<?php
//defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.application.component.modelitem');

class PopstilBlogViewIndice extends JViewLegacy {
	
	function display($tpl = null) {
		
		$this->prepareDocument();
		//echo '<br/><br/><br/><br/><br/>';
		
		$this->listaMaterias	= $this->get('materiasPorAno');
		$this->listaTags		= $this->get('tags');
		
//		
//		$categoria = JRequest::getVar('categoria');
		//echo 'categoria = ';
		
		
		//$model = $this->getModel(JModelLegacy::getInstance('popstilblogmodelpopstilblog'));
		//$view = $this->getView( 'PopstilBlog', 'html' );
		$items_model = JModelLegacy::getInstance( 'popstilblog', 'PopstilBlogModel' );

		if($this->getLayout() === 'mes') {
			$this->ano = JRequest::getVar('ano');
			$this->mes = UtilitariosHelper::retornaMes(JRequest::getVar('mes'));
			
			$this->listaresultado = $this->get('materiasPorAnoMes');
		}
		
		if($this->getLayout() === 'tag') {
			$this->tag = JRequest::getVar('tag');
			
			$this->listaresultado = $this->get('materiasPorTag');

			//echo $this->tag;
		}
		$this->listacategorias 	= $items_model->getCategorias();
		
		/*Paginação*/
		//$pageNav = new JPagination( 100, 1,10 );
		//echo $pageNav->getListFooter();

		parent::display($tpl);
	}	
	
	public function prepareDocument() {
		$document = JFactory::getDocument();
		//Importa o arquivo css criado para as modificações do layout
		$document->addStyleSheet(JURI::root() . "/components/com_popstilblog/views/indice/css/indice.css");
		$document->addStyleSheet(JURI::root() . "/components/com_popstilblog/assets/css/estilos_comuns.css");
		//$document->addScript(JURI::root() . '/components/com_popstil/assets/js/jquery.min.1.7.1.js');
		//$document->addScript(JURI::root() . '/components/com_popstil/assets/js/faq.js');
	}
	
}

?>