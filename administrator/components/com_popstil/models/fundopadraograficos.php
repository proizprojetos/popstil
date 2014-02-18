<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.modellist');

class PopstilModelFundoPadraoGraficos extends JModelList {


	/**
	* Método para construir um query SQL para carregar a lista de dados
	*/
	protected function getListQuery() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos desejados
		$query->select('p.*, s.descricao as desc_subcategoria');
		
		//Da tabela
		$query->from('#__popstil_customizacao_fundo_padraografico p');
		$query->join('INNER','#__popstil_customizacao_fundo_subcategoria s on s.id = p.id_subcategoria');
		return $query;
	}

}