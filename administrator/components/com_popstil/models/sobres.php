<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.modellist');

class PopstilModelSobres extends JModelList {


	/**
	* Método para construir um query SQL para carregar a lista de dados
	*/
	protected function getListQuery() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos desejados
		$query->select('*');
		
		//Da tabela
		$query->from('#__popstil_sobre');
		return $query;
	}

}