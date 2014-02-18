<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableUsuario extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_usuarios','id',$db);
	}
	
} 