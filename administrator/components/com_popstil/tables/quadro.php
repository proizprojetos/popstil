<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableQuadro extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_quadros','id',$db);
	}
	
} 