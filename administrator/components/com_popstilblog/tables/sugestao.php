<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilBlogTableSugestao extends JTable {
	
	function __construct($db) {
		parent::__construct('#__blog_sugestao','id',$db);
	}
	
} 