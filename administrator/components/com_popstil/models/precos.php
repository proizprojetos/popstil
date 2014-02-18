<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.application.component.modellist');

class PopstilModelPrecos extends JModelList {


	/**
	* Método para construir um query SQL para carregar a lista de dados
	*/
	protected function getListQuery() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos desejados
		//$query->select('*');
		
		//Da tabela
		//$query->from('#__popstil_customizacao_precoquadro');
		$query->select('pc.*, t.largura, t.altura , p.numero_pessoas');
		$query->from('#__popstil_customizacao_precoquadro pc');
		$query->join('INNER', '#__popstil_customizacao_tamanhos t on t.id_tamanho = pc.id_tamanho');
		$query->join('INNER', '#__popstil_customizacao_numeropessoas as p on p.id_numpessoas = pc.id_numpessoas');
		
		return $query;
	}
	
	public function getLista() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos desejados
		//$query->select('*');
		
		//Da tabela
		//$query->from('#__popstil_customizacao_precoquadro');
		$query->select('pc.*, t.largura, t.altura , p.numero_pessoas');
		$query->from('#__popstil_customizacao_precoquadro pc');
		$query->join('INNER', '#__popstil_customizacao_tamanhos t on t.id_tamanho = pc.id_tamanho');
		$query->join('INNER', '#__popstil_customizacao_numeropessoas as p on p.id_numpessoas = pc.id_numpessoas');
		$query->order('t.largura, p.numero_pessoas');
		
		$db->setQuery($query);
		
		$data = $db->loadObjectList();
		
		return $data;
		
	}
	
	public function salvar($data) {
	
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		try {
			foreach ($data as $key => $value) {
				foreach ($value as $k => $v) {
					$this->_db->setQuery(
						'update #__popstil_customizacao_precoquadro set preco = '.$v.' where id_tamanho = '.$key.' and id_numpessoas =' .$k
					);
					$db->execute();
				}
			}
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());
			return false;
		}
		return true;
		
	}

}