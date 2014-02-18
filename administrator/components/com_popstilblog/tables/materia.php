<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilBlogTableMateria extends JTable {
	
	function __construct($db) {
		parent::__construct('#__blog_materia','id',$db);
	}
	
} 