<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableDesconto extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_descontos','id',$db);
	}
	
} 