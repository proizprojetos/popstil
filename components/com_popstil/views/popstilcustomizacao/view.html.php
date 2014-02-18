<?php
//defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PopstilViewPopstilCustomizacao extends JViewLegacy {
	
	
	
	function display($tpl = null) {
		
		$this->listaCategorias 	= $this->get('CategoriasTamanhos');
		$this->listaNumPessoas 	= $this->get('NumPessoas');
		$this->listaMolduras	= $this->get('Molduras');
		$this->listaCores 		= $this->get('CorSolidas');
		$this->padroes			= $this->get('PadroesGraficos');
		
		$this->prepareDocument();
		
		parent::display($tpl);
	}
	
	function getListaTamanhos($idCategoria) {
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		//echo $query;
		
		$query->select(array('t.id_tamanho','t.id_categoria','t.largura','t.altura','t.estilo','t.peso','p.preco', 'p.id_numpessoas'));
		$query->from('#__popstil_customizacao_tamanhos AS t');
		$query->join('INNER', '#__popstil_customizacao_precoquadro as p on t.id_tamanho = p.id_tamanho ');
		$query->where(' id_categoria = '.$idCategoria);
		$query->order(' id_tamanho desc');
		
		$db->setQuery($query);
		$tamanhos = $db->loadObjectList();
		//foreach($tamanhos as $value){
		// 	echo $value."<br />";
		//}
		
		
		
		
		return $tamanhos;
	}
	
	public function prepareDocument() {
		$document = JFactory::getDocument();
		//Importa o arquivo css criado para as modificações do layout
		$document->addStyleSheet(JURI::root() . "/components/com_popstil/assets/css/customizacao.css");
		
		//E importa os js utilizados nessa pagina
		$document->addScript('components/com_popstil/assets/js/jquery.min.1.7.1.js');
		$document->addScript('components/com_popstil/assets/js/jquery-ui1.10.2.js');
		$document->addScript('components/com_popstil/assets/js/jquery.form.js');
		$document->addScript('components/com_popstil/assets/js/ajaxupload/file_uploads.js');
		$document->addScript('components/com_popstil/assets/js/droparea.js');
		$document->addScript('components/com_popstil/assets/js/customizacao.js');
	}
}

?>