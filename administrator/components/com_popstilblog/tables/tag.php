<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilBlogTableTag extends JTable {
	
	function __construct($db) {
		parent::__construct('#__blog_tag','id',$db);
	}
	
} 