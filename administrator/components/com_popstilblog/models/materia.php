<?php 

defined('_JEXEC') or die('Acesos restrito');

jimport('joomla.application.component.modeladmin');

class PopstilBlogModelMateria extends JModelAdmin {
	
	public function getTable($type="Materia", $prefix="PopstilBlogTable", $config=array() ) {
		return JTable::getInstance($type, $prefix, $config);	
	}
	
	public function getForm($data = array(), $loadData = true) {
	
		$form = $this->loadForm('com_popstilblog.materia', 'materia', array('control' => 'jform', 'load_data' =>$loadData));
		
		if(empty($form)) {
			return false;
		}
		return $form;		
	}
	
	/**
	*	Método responsavel por pegas os dados que serão injetados no formulario
	*/
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_popstilblog.edit.materia.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	
	/*
	public function getListaAutores() {
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			
			$item = $this->getItem();
	
			$sql = '';
			$isNew = ($item->id == 0);
			
			if(!$isNew) {
				$sql = 'SELECT distinct autor.*, la.id_livro as "checked"
					FROM #__loja_autores autor left join omuz_loja_livros_autores la on la.id_autor = autor.id and la.id_livro = '.$item->id;
			}else {
				$sql = 'SELECT distinct autor.*, 0 as "checked"
					FROM #__loja_autores autor';
			}
			
			$db->setQuery($sql);
			
			$autores = $db->loadObjectList();
	
			return $autores;
		}
	*/
	
	public function getTags() {
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$item = $this->getItem();
		
		$sql = '';
		$isNew = ($item->id == 0);
		
		if(!$isNew) {
			$sql = 'SELECT distinct tag.*, la.id_materia as "checked"
				FROM #__blog_tag tag left join #__blog_materia_tag la on la.id_tag = tag.id and la.id_materia = '.$item->id;
		}else {
			$sql = 'SELECT distinct tag.*, 0 as "checked"
				FROM #__blog_tag tag';
		}
		
		$db->setQuery($sql);
		
		$autores = $db->loadObjectList();

		return $autores;
		
	}
	
	
	public function save($data)
		{		
	
			$dispatcher = JEventDispatcher::getInstance();
			$input      = JFactory::getApplication()->input;
			$table		= $this->getTable();
			
			// Bind the data.
			if (!$table->bind($data))
			{
				$this->setError($table->getError());
				return false;
			}
	
			// Prepare the row for saving
			$this->prepareTable($table);
	
			// Check the data.
			if (!$table->check())
			{
				$this->setError($table->getError());
				return false;
			}
		
	
			// Store the data.
			if (!$table->store())
			{
				$this->setError($table->getError());
				return false;
			}
			
			//Processo para salvar as tags 
			//Pega os ids das tags selecionados
			$tags = isset($data['tag']) ? $data['tag'] : 0;
			
			//Agora apaga o relacionamento da tabela materia_tag relacionado a essa materia
			$db    = $this->getDbo();
			$query = $db->getQuery(true)
				->delete('#__blog_materia_tag')
				->where('id_materia = ' . (int) $table->id);
			$db->setQuery($query);
			
			try
			{
				$db->execute();
			}
			catch (RuntimeException $e)
			{
				$this->setError($e->getMessage());
				return false;
			}
			
			if(!empty($tags)) {
				//E agora salva o novo relaciomento entre os tag e materia
				foreach ($tags as &$pk) {
					$tuples[] = '(' . (int) $table->id . ',' . (int) $pk . ')';
				}
				$this->_db->setQuery(
					'INSERT INTO #__blog_materia_tag (id_materia, id_tag) VALUES ' .
					implode(',', $tuples)
				);
				
				try
				{
					$db->execute();
				}
				catch (RuntimeException $e)
				{
					$this->setError($e->getMessage());
					return false;
				}
				
			}
			return true;
		}
		
		public function delete(&$pks)
		{
			$dispatcher = JEventDispatcher::getInstance();
			$pks = (array) $pks;
			$table = $this->getTable();
	
			// Include the content plugins for the on delete events.
			JPluginHelper::importPlugin('content');
	
			// Iterate the items to delete each one.
			foreach ($pks as $i => $pk)
			{
				if ($table->load($pk))
				{
	
					if ($this->canDelete($table))
					{
	
						$context = $this->option . '.' . $this->name;
						
						//Apaga primeiro da tabela #__loja_livros_autores
						
						$db = JFactory::getDBO();
						$query = $db->getQuery(true)	
						->delete('#__blog_materia_tag')
						->where('id_materia = ' . (int) $pk);
						$db->setQuery($query);
						try
						{
							$db->execute();
						}
						catch (RuntimeException $e)
						{
							$this->setError($e->getMessage());
							return false;
						}
						// Trigger the onContentBeforeDelete event.
						$result = $dispatcher->trigger($this->event_before_delete, array($context, $table));
						if (in_array(false, $result, true))
						{
							$this->setError($table->getError());
							return false;
						}
	
						if (!$table->delete($pk))
						{
							$this->setError($table->getError());
							return false;
						}
	
						// Trigger the onContentAfterDelete event.
						$dispatcher->trigger($this->event_after_delete, array($context, $table));
	
					}
					else
					{
	
						// Prune items that you can't change.
						unset($pks[$i]);
						$error = $this->getError();
						if ($error)
						{
							JLog::add($error, JLog::WARNING, 'jerror');
							return false;
						}
						else
						{
							JLog::add(JText::_('JLIB_APPLICATION_ERROR_DELETE_NOT_PERMITTED'), JLog::WARNING, 'jerror');
							return false;
						}
					}
	
				}
				else
				{
					$this->setError($table->getError());
					return false;
				}
			}
	
			// Clear the component's cache
			$this->cleanCache();
	
			return true;
		}
		
	
}
