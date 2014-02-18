<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableSlider extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_slider','id',$db);
	}
	
} 