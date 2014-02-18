<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class PopstilBlogController extends JControllerLegacy {

	function display($cachable = false, $urlparams = false) {
		$vName	 = JRequest::getCmd('view');
		
		parent::display();
	}
	
	
	public function getMaterias() {
		$parametro = JRequest::getVar("param");
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$date = JFactory::getDate();
		
		$nowDate = $db->quote($date->toSql());
		
		$query->select('materia.*, categoria.cor_tema')
			->from('#__blog_materia as materia')
			->join('INNER','#__blog_categoria as categoria on categoria.id = materia.id_categoria')
			->where('(materia.inicio_publicacao <= '.$nowDate.')') 
			->where('(materia.fim_publicacao >= '.$nowDate.')')
			->order('materia.data_criacao desc');
			
		if($parametro != '#') {
			$query->where('categoria.titulo like \''.$parametro.'\'');
		}
			
		$db->setQuery($query,0,10);
		$materias = $db->loadObjectList();
		
		foreach ($materias as $key => $value) {
			$value->inicio_publicacao = UtilitariosHelper::diferencaentredatas($value->inicio_publicacao);
			$value->url = str_replace(" ", "-", $value->titulo);
		}
		
		echo json_encode($materias);
	}
	
	public function getNovasMaterias() {
		
		$categoria = JRequest::getVar("data");
		$c = explode('&',$categoria);
		
		$inicio = JRequest::getVar("inicio");
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$date = JFactory::getDate();
		
		$nowDate = $db->quote($date->toSql());
		
		$query->select('materia.*, categoria.cor_tema')
			->from('#__blog_materia as materia')
			->join('INNER','#__blog_categoria as categoria on categoria.id = materia.id_categoria')
			->where('(materia.inicio_publicacao <= '.$nowDate.')') 
			->where('(materia.fim_publicacao >= '.$nowDate.')')
			->order('materia.data_criacao desc')
			->limit('10,10');
			
		if($c[0] != '#') {
			$query->where('categoria.titulo like \''.$c[0].'\'');
		}
			
		$db->setQuery($query,$c[1],10);
		$materias = $db->loadObjectList();
		
		foreach ($materias as $key => $value) {
			$value->inicio_publicacao = UtilitariosHelper::diferencaentredatas($value->inicio_publicacao); 
		}
		
		echo json_encode($materias);
	}

}

?>