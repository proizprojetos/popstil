<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableEndereco extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_enderecos','id',$db);
	}
	
} 