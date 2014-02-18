<?php 

defined('_JEXEC') or die ('Acesso restrito');

jimport('joomla.application.component.modelist');

class PopstilModelPedidos extends JModelList {

	protected function getListQuery() {
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		/*
		$query->select('p.*');
		$query->from('#__popstil_pedidos p, #__popstil_usuarios user ');
		$query->join('INNER', '#__users u on u.id = user.idusuario_joomla ');
		*/
		
		//Seleciona os campos
		$query->select('p.*, user.id as idusuario, user.nomecompleto');
		$query->from('#__popstil_pedidos p, #__popstil_usuarios user');
		$query->join('INNER', '#__users u on u.id = user.idusuario_joomla');
		$query->where('p.popstil_usuario_idusuario = user.id ');
		$query->order($db->escape($this->getState('list.ordering', 'p.datagravacao')).' '.
		                $db->escape($this->getState('list.direction', 'ASC')));
		                             
		return $query;
	}
	
	protected function populateState($ordering = null, $direction = null) {
	        parent::populateState('p.datagravacao', 'ASC');
	}
	
	public function __construct($config = array())
    {   
            $config['filter_fields'] = array(
                    'p.idpedido',
                    'p.datagravacao',
                    'p.status_pedido',
                    'p.valortotal',
                    'p.popstil_usuario_idusuario'
            );
            parent::__construct($config);
    }

}