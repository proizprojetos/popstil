<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableFundoCorSolida extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_customizacao_fundo_corsolida','id',$db);
	}
	
} 