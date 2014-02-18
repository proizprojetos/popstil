<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableSobre extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_sobre','id',$db);
	}
	
} 