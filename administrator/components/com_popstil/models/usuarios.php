<?php 

defined('_JEXEC') or die ('Acesso restrito');

jimport('joomla.application.component.modelist');

class PopstilModelUsuarios extends JModelList {

	protected function getListQuery() {
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos
		$query->select('u.id as idusuario, u.*, e.* ');
		$query->from('#__popstil_usuarios u');
		$query->join('INNER', '#__popstil_enderecos e ON e.popstil_usuario_idusuario = u.id ');
		$query->order($db->escape($this->getState('list.ordering', 'u.nomecompleto')).' '.
		                $db->escape($this->getState('list.direction', 'ASC')));
		                             
		return $query;
	}
	
	protected function populateState($ordering = null, $direction = null) {
	        parent::populateState('u.nomecompleto', 'ASC');
	}
	
	public function __construct($config = array())
    {   
            $config['filter_fields'] = array(
                    'u.nomecompleto',
                    'u.username'
            );
            parent::__construct($config);
    }

}