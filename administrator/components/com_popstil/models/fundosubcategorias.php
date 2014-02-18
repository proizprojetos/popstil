<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.modellist');

class PopstilModelFundoSubCategorias extends JModelList {


	/**
	* Método para construir um query SQL para carregar a lista de dados
	*/
	protected function getListQuery() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos desejados
		$query->select('s.id, s.descricao,s.ativo, c.descricao as desc_categoria');
		
		//Da tabela
		$query->from('#__popstil_customizacao_fundo_subcategoria s');
		$query->join('INNER','#__popstil_customizacao_fundo_categoria c on c.id = s.id_categoria');
		return $query;
	}

}