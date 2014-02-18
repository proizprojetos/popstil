<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableArte extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_arte','id',$db);
	}
	
} 