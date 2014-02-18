<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableFundoCategoria extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_customizacao_fundo_categoria','id',$db);
	}
	
} 