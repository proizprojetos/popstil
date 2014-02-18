<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableFaqPergunta extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_perguntas_faq','id',$db);
	}
	
} 