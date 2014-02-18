<?php
//defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.application.component.modelform');

jimport('joomla.application.component.view');
class PopstilBlogViewMateria extends JViewLegacy {
	
	protected $item;
	
	protected $params;
	
	function display($tpl = null) {
		
		$this->item				= $this->get('Item');
		$this->state			= $this->get('State');
		
		//echo '<br/><br/><br/><br/>Echo: </br>';
		
		$this->imagesinstagram			= UtilitariosHelper::getInstagramImages();
		//print_r($this->imagesinstagram);
		
		$this->sugestaopopstil 			= UtilitariosHelper::getSugestaoPopstil();
		
		$dispatcher	= JEventDispatcher::getInstance();
		
		$items_model = JModelLegacy::getInstance( 'popstilblog', 'PopstilBlogModel' );
		$this->listacategorias 	= $items_model->getCategorias();
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}
		
		$item = $this->item;
		
		$offset = $this->state->get('list.offset');
		
		JPluginHelper::importPlugin('content');
		$dispatcher->trigger('onContentPrepare', array ('com_content.article', &$item, &$this->params, $offset));
		
		//////////////////////////////////////////////////
		//$model = $this->getModel('osingular');
		
		//$this->listacategorias 	= $model->getCategorias();		
		
		////////////////////////////////////////////////
		$this->params = $this->state->get('params');
		
		$this->prepareDocument();
			
		parent::display($tpl);
	}	
	
	public function prepareDocument() {
		$document = JFactory::getDocument();
		
		$document->addScript(JURI::root() . '/components/com_popstilblog/assets/js/jquery.min.1.7.1.js');

		//slider
		//$document->addScript(JURI::root() . '/components/com_popstilblog/views/materia/js/slider/jquery.secret-source.min.js');
		$document->addScript(JURI::root() . '/components/com_popstilblog/views/materia/js/slider/bjqs-1.3.js');
		$document->addStyleSheet(JURI::root() . "/components/com_popstilblog/views/materia/js/slider/bjqs.css");
		
		
		$document->addStyleSheet(JURI::root() . "/components/com_popstilblog/views/materia/css/estilos.css");
		$document->addStyleSheet(JURI::root() . "/components/com_popstilblog/assets/css/estilos_comuns.css");
		
		$document->addScript(JURI::root() . '/components/com_popstilblog/views/materia/js/script.js');
		
				//$document->addScript(JURI::root() . '/components/com_popstil/assets/js/faq.js');
		
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway	= $app->getPathway();
		$title		= null;
		
		$title = $this->params->get('page_title', '');
		
		$title = $this->item->titulo;
		
		$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		//Coloca o titulo da matéria no titulo da página
		if (empty($title))
		{
			$title = $app->getCfg('sitename');
		}
		
		if (empty($title))
		{
			$title = $this->item->titulo;
		}
		$this->document->setTitle($title);
		
		
		if ($this->item->metakey)
		{
			$this->document->setMetadata('keywords', $this->item->metakey);
		}
		elseif (!$this->item->metakey && $this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}
		
		$opengraph  = '<meta property="og:title" content="'.$this->item->titulo.'"/>' ."\n";
		$opengraph .= '<meta property="og:locale" content="'."pt_BR".'"/>' ."\n";
		$opengraph .= '<meta property="og:type" content="'."article".'"/>' ."\n";
		$opengraph .= '<meta property="og:url"  content="'.'http://popstil.com'.JRoute::_('index.php?option=com_popstilblog&view=materia&id='. 
			$this->item->id.'&titulo='.$this->item->titulo).'"/>/' ."\n";
		$opengraph .= '<meta property="og:image" content="'.'http://popstil.com/'.$this->item->imagem_intro.'"/>'."\n";
		$opengraph .= '<meta property="og:site_name" content="'."Popstil - Singular".'"/>' ."\n";
		$opengraph .= '<meta property="og:description" content="'.strip_tags($this->item->texto_intro).'"/>' ."\n";
		//add the tags to the head of the page;[/
		$this->document->addCustomTag($opengraph);
		
		/*
		<meta property="og:type" content="article">
		<meta property="og:locale" content="pt_BR">
		<meta property="og:site_name" content="Omelete">
		<meta property="og:title" content="LEGO The Hobbit é confirmado e ganha imagens - veja">
		<meta property="og:description" content="LEGO The Hobbit foi confirmado pela desenvolvedora Traveller's Tales. O jogo abrangerá os dois primeiros filmes da trilogia de Peter Jackson: O Hobbit: Uma Jornada Inesperada e O Hobbit: A Desolação de Smaug. Também ...">
		<meta property="og:url" content="http://omelete.uol.com.br/hobbit/games/lego-hobbit-e-confirmado-e-ganha-imagens-veja/">
		<meta property="og:image" content="http://omelete.uol.com.br/static/img/omelete_logo_fb.jpg">
		*/
		
		$source_url ='https://www.popstil.com'.JRoute::_('index.php?option=com_popstilblog&view=materia&id='.$this->item->id.'&titulo='.$this->item->titulo);
		//$source_url = str_replace("//","/", $source_url);
		$url = "http://api.facebook.com/restserver.php?method=links.getStats&urls=".urlencode($source_url);
		$xml = file_get_contents($url);
		$xml = simplexml_load_string($xml);
		$this->comentarios = $xml->link_stat->commentsbox_count;
				
	}
	
}

?>