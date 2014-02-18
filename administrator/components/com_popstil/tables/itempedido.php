<?php 

defined('_JEXEC') or die;

jimport('joomla.database.table');

class PopstilTableItemPedido extends JTable {
	
	function __construct($db) {
		parent::__construct('#__popstil_item_pedido','popstil_item_pedido_id',$db);
	}
	
} 