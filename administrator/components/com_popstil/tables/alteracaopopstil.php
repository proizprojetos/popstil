<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableAlteracaopopstil extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_alteracao_arte','id',$db);
	}
	
} 