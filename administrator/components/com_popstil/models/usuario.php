<?php 

defined('_JEXEC') or die('Acesos restrito');

jimport('joomla.application.component.modeladmin');

class PopstilModelUsuario extends JModelAdmin {
	
	public function getTable($type="Usuario", $prefix="PopstilTable", $config=array() ) {
		
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) {
		$form = $this->loadForm('com_popstil.usuario', 'usuario', array('control' => 'jform', 'load_data' =>$loadData));
		
		if(empty($form)) {
			return false;
		}
		
		return $form;		
	}
	
	/**
	*	Método responsavel por pegas os dados que serão injetados no formulario
	*/
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_popstil.edit.usuario.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	
	
	public function getcliente() {
		
		//Pega o id do pedido passado por parametro
		$id 	= JRequest::getVar('id');
				
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos
		$query->select(' pessoa.*, end.*');
		$query->from('#__popstil_usuarios pessoa');
		$query->join('INNER', '#__popstil_enderecos end ON end.popstil_usuario_idusuario = pessoa.id');
		$query->where('pessoa.id = '.$id);
		$db->setQuery((String) $query);
		$cliente = $db->loadObject();

		return $cliente;
	}
	
	public function cancelar() {
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=usuarios', false));
	}
	
}