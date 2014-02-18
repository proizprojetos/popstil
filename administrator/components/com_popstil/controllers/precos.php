<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * HelloWorlds Controller
 */
class PopstilControllerPrecos extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Preco', $prefix = 'PopstilModel',$config=array()) 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	
	public function salvar() {
		
		$precos = JRequest::getVar('precos');
		
		$model = $this->getModel('precos', 'PopstilModel');
		
		$return = $model->salvar($precos);
		
		if($return === true) {
			//echo 'deu certo';
		}else {
			//echo 'deu merda';
			$this->setMessage($model->getError(), 'warning');
		}
		$this->setMessage('Preços atualizados com sucesso', 'message');
		
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=precos&layout=default', false));
		return true;
	}
	
}
