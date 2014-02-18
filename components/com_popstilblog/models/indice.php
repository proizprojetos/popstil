<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');


class PopstilBlogModelIndice extends JModelItem {

	protected $data;
		
//	public function getForm($data = array(), $loadData = true)
//	{
		// Get the form.
//		$form = $this->loadForm('com_popstilblog.osingular', 'osingular', array('control' => 'osingular', 'load_data' => $loadData));
//		if (empty($form)) {
//			return false;
//		}
//
//		return $form;
//	}
	
	
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
	
	public function getMateriasPorAno() {
	
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$date = JFactory::getDate();
		
		$nowDate = $db->quote($date->toSql());
		
		$query->select('year(inicio_publicacao) as \'ano\' ,month(inicio_publicacao) \'mes\' ,count(*) \'quantidade\'')
		->from('#__blog_materia as materia')
		->order('month(inicio_publicacao) asc, year(inicio_publicacao) desc')
		->group('month(inicio_publicacao), year(inicio_publicacao)');
		
		$db->setQuery($query);
		
		$data = $db->loadObjectList();
		
		$listaretorna = array();
		
		$meses = array('janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'); 
		
		foreach ($data as $chave => &$valor) {
			foreach ($valor as $key => &$value) {
				
				
				if($key === 'ano') {
					$vazio = true;
					$possuiano = false;
					foreach ($listaretorna as $k => &$v) {
						$vazio = false;
						if(intval($v['ano']) == intval($value)) {
							$possuiano = true;
							$novo = array();
							$novo['mes'] = $valor->mes;
							$novo['mesextenso'] = $meses[$valor->mes-1];
							$novo['quantidade'] = $valor->quantidade; 
							array_push($v , $novo);						
							break;
						}
					}
					if(!$vazio && !$possuiano){
						$novo = array();
						$novo['ano'] = $valor->ano;
						$filho = array();
						$filho['mes'] = $valor->mes;
						$filho['mesextenso'] = $meses[$valor->mes-1];
						$filho['quantidade'] = $valor->quantidade; 
						array_push($novo,$filho);
						array_push($listaretorna,$novo);			
					}
					if($vazio) {
						$novo = array();
						$novo['ano'] = $valor->ano;
						$filho = array();
						$filho['mes'] = $valor->mes;
						$filho['mesextenso'] = $meses[$valor->mes-1];
						$filho['quantidade'] = $valor->quantidade; 
						array_push($novo,$filho);
						array_push($listaretorna,$novo);						
					}
				}
			}
		}
		return $listaretorna;
	}
	
	public function getTags() {
	
		/*
		SELECT tag.titulo, COUNT( * ) as quantidade
		FROM joomla03_blog_tag tag
		inner join joomla03_blog_materia_tag mt on mt.id_tag = tag.id
		group by tag.id, tag.titulo
		*/
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query->select('tag.titulo, count(*) as quantidade')
			->from('#__blog_tag tag')
			->join('INNER', '#__blog_materia_tag mt on mt.id_tag = tag.id')
			->group('tag.id, tag.titulo');
			
		$db->setQuery($query);
		
		$data = $db->loadObjectList();
		
		return $data;
		
	}
	
	public function getMateriasPorAnoMes() {
	
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$ano = JRequest::getVar('ano');
		$mes = JRequest::getVar('mes');
		
		if(!isset($ano) || !isset($mes) || empty($mes) || empty($ano)  ) {
			$app =& JFactory::getApplication(); 
			$app->redirect(JRoute::_('index.php?option=com_popstilblog&view=indice', false)); 
			//$this->setRedirect(JRoute::_('index.php?option=com_popstilblog&view=indice', false));	
		}
		
		$date = JFactory::getDate();
		
		$nowDate = $db->quote($date->toSql());
		
		$query->select('materia.*, cat.cor_tema, cat.titulo as titulo_categoria')
		->from('#__blog_materia as materia')
		->join('INNER','#__blog_categoria as cat on cat.id = materia.id_categoria')
		->where('year(materia.inicio_publicacao) = '.$ano.' and month(materia.inicio_publicacao) = '.$mes.' and materia.status = 1')
		->order('month(materia.inicio_publicacao) asc, year(materia.inicio_publicacao) desc');
		
		$query->select('u.name AS author')
			->join('LEFT', '#__users AS u on u.id = materia.id_autor');
		
		$db->setQuery($query);
		
		$data = $db->loadObjectList();
		
		foreach ($data as $key => &$value) {
			$query = $db->getQuery(true)
				->select(
					'tag.*'
				);
			$query->from('#__blog_tag AS tag')
				->join('inner', '#__blog_materia_tag as t on t.id_tag = tag.id and t.id_materia = '.$value->id);
				
			$db->setQuery($query);
			
			$value->tags = $db->loadObjectList();
		}
		
		return $data;
		
	}
	
	public function getMateriasPorTag() {
	
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$tag = JRequest::getVar('tag');
		
		if(!isset($tag) || empty($tag)) {
			$app =& JFactory::getApplication(); 
			$app->redirect(JRoute::_('index.php?option=com_popstilblog&view=indice', false)); 
			//$this->setRedirect(JRoute::_('index.php?option=com_popstilblog&view=indice', false));	
		}
		
		$date = JFactory::getDate();
		
		$nowDate = $db->quote($date->toSql());
		
		$query->select('distinct materia.*, cat.cor_tema, cat.titulo as titulo_categoria')
		->from('#__blog_materia as materia')
		->join('INNER','#__blog_categoria as cat on cat.id = materia.id_categoria')
		->join('INNER','#__blog_tag as tag')
		->join('INNER', '#__blog_materia_tag as t on t.id_materia = materia.id and t.id_tag = tag.id ')
		->where('tag.titulo like \''.$tag.'\' and materia.status = 1')
		->order('materia.inicio_publicacao desc');
		
		$query->select('u.name AS author')
			->join('LEFT', '#__users AS u on u.id = materia.id_autor');
		
		$db->setQuery($query);
		
		$data = $db->loadObjectList();
		
		foreach ($data as $key => &$value) {
			$query = $db->getQuery(true)
				->select(
					'tag.*'
				);
			$query->from('#__blog_tag AS tag')
				->join('inner', '#__blog_materia_tag as t on t.id_tag = tag.id and t.id_materia = '.$value->id);
				
			$db->setQuery($query);
			
			$value->tags = $db->loadObjectList();
		}
		
		return $data;
		
	}
	

}