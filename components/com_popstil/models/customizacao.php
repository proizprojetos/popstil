<?php

defined('_JEXEC') or die('Restricted access');

//jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

class PopstilModelCustomizacao extends JModelForm {
	
	//protected $msg;
	protected $data;
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_users.registration', 'registration', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}
	
	public function getCategoriasTamanhos() {
		
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select('*');
		$query->from('#__popstil_customizacao_categoria_tamanhos');
		//$query->where(' id_cat_tamanho = 1');
		$db->setQuery((String) $query);
		$messages = $db->loadObjectList();
		
		return $messages;
	}
	
	public function getNumPessoas() {
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select('* ');
		$query->from('#__popstil_customizacao_numeropessoas');
		$query->order(' id_tamanho, numero_pessoas asc');		
		$db->setQuery((String) $query);
		$numpessoas = $db->loadObjectList();
		
		return $numpessoas;
	}
	
	public function getMolduras() {
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select('* ');
		$query->from('#__popstil_customizacao_molduras');
		$db->setQuery((String) $query);
		$molduras = $db->loadObjectList();
		
		return $molduras;
	}
	
	public function getCorSolidas() {
		
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select('* ');
		$query->from('#__popstil_customizacao_fundo_corsolida');
		$db->setQuery((String) $query);
		$cores = $db->loadObjectList();
		
		return $cores;
		
	}
	
	public function getPadroesGraficos() {
		
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select('* ');
		$query->from('#__popstil_customizacao_fundo_categoria');
		$query->where('ativo = 1');
		$db->setQuery((String) $query);
		$padroes = $db->loadObjectList();
		
		foreach ($padroes as $key => &$value) {
			$query->clear();
			$query->select('*')
				->from('#__popstil_customizacao_fundo_subcategoria as sub ')
				->where('sub.id_categoria = '.$value->id)
				->where('ativo = 1');
			$db->setQuery((String) $query);
			$subcategorias = $db->loadObjectList();
			
				foreach ($subcategorias as $chave => &$sub) {
					$query->clear();
					$query->select('*')
						->from('#__popstil_customizacao_fundo_padraografico as p ')
						->where('p.id_subcategoria = '.$sub->id)
						->where('ativo = 1');
					$db->setQuery((String) $query);
					$itens = $db->loadObjectList();
					
					$sub->itens = $itens;
				}
			
			$value->categorias = $subcategorias;
		}
		
		return $padroes;
	
	}

}

?>