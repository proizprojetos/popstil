<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');


class PopstilBlogModelOsingular extends JModelItem {

	protected $data;
		
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_popstilblog.osingular', 'osingular', array('control' => 'osingular', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}
	
	
	public function getLastMateria() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$date = JFactory::getDate();
		
		$nowDate = $db->quote($date->toSql());
		
//		$query->select('*')
//		->from('#__blog_materia as materia')
//		->where('(materia.inicio_publicacao <= '.$nowDate.')') 
//		->where('(materia.fim_publicacao >= '.$nowDate.')')
//		->order('materia.data_criacao asc');
		$db->setQuery('select * from #__blog_materia as materia 
						where (materia.inicio_publicacao <= '.$nowDate.') 
							and (materia.fim_publicacao >= '.$nowDate.')
						order by materia.data_criacao desc
						');
		$materias = $db->loadObject();
		
		return $materias;
	}
	
	public function getMaterias() {
	
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$date = JFactory::getDate();
		
		$nowDate = $db->quote($date->toSql());
		
//		$query->select('*')
//		->from('#__blog_materia as materia')
//		->where('(materia.inicio_publicacao <= '.$nowDate.')') 
//		->where('(materia.fim_publicacao >= '.$nowDate.')'); 
//		$db->setQuery('select materia.*, ca.cor_tema from #__blog_materia as materia 
//						inner join #__blog_categoria ca on materia.id_categoria = ca.id
//						where (materia.inicio_publicacao <= '.$nowDate.') 
//							and (materia.fim_publicacao >= '.$nowDate.')
//						order by materia.data_criacao desc
//						limit 20 offset 1');
		$db->setQuery('select materia.*, ca.cor_tema from #__blog_materia as materia 
						inner join #__blog_categoria ca on materia.id_categoria = ca.id
						where (materia.inicio_publicacao <= '.$nowDate.') 
							and (materia.fim_publicacao >= '.$nowDate.')
						order by materia.data_criacao desc limit 10');

		$materias = $db->loadObjectList();
		
		foreach ($materias as $key => $value) {
			$value->inicio_publicacao = UtilitariosHelper::diferencaentredatas($value->inicio_publicacao); 
		}

		return $materias;
	}
	
	public function getCategorias() {
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$date = JFactory::getDate();
		
		$nowDate = $db->quote($date->toSql());
		
		$query->select('*')
			->from('#__blog_categoria as categoria')
			->where('(categoria.inicio_publicacao <= '.$nowDate.')') 
			->where('(categoria.fim_publicacao >= '.$nowDate.')')
			->where('categoria.status = 1');
		
		$db->setQuery($query);
		
		$categorias = $db->loadObjectList();
		
		return $categorias;

	}
	

}