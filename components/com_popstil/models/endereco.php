<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

class PopstilModelUsuario extends JModelForm {
	
	protected $data;
	
//	public function getData() {
		//$data = JFactory::getApplication()->getUserState('com_popstilcustomizacao.registration.data', array());
		//print_r('<br/>oiii</br>');
//		
//		$user = JFactory::getUser();
		//print_r($user);
//		/*if($user->guest) {
//			print_r('Voce deve ser logar para continuar');
//		}*/
//		
//		if($this->data === null) {
//			
//			$this->data = new stdClass();
//			$app 		= JFactory::getApplication();
//			$params		= JComponentHelper::getParams('com_popstil');
//			
//			$temp = (array)$app->getUserState('com_popstil.registration.data', array());
//			
			//print_r($temp);
//			
//			foreach ($temp as $k => $v) {
//				$this->data->$k = $v;
//			}
//			
//			$this->data->groups = array();
//			
//			$system	= $params->get('new_usertype', 2);
//			
//			$this->data->groups[] = $system;
//			
			// Unset the passwords.
//			unset($this->data->password);
//			unset($this->data->password2);
//			
			// Get the dispatcher and load the users plugins.
//			$dispatcher	= JDispatcher::getInstance();
//			JPluginHelper::importPlugin('user');
//
			// Trigger the data preparation event.
//			$results = $dispatcher->trigger('onContentPrepareData', array('com_users.registration', $this->data));
//
			// Check for errors encountered while preparing the data.
//			if (count($results) && in_array(false, $results, true)) {
//				$this->setError($dispatcher->getError());
//				$this->data = false;
//			}
//			
//		}
		//echo('Dados digitados<br/>');
		//print_r($this->data);
//		
//		return $this->data;
//	}
//	protected function loadFormData()
//	{
//		return $this->getData();
//	}
	
	protected function populateState()
	{
		//print_r('entrouaaaaaa');
		// Get the application object.
		$app	= JFactory::getApplication();
		$params	= $app->getParams('com_popstil');

		// Load the parameters.
		$this->setState('params', $params);
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		
		// Get the form.
		$form = $this->loadForm('com_popstil.usuario', 'usuario', array('control' => 'cadastro', 'load_data' => $loadData));
		if (empty($form)) {
			
			return false;
		}
		
		return $form;
	}
	
	public function register($temp) {
		$config = JFactory::getConfig();
		$db		= $this->getDbo();
		//$params = JComponentHelper::getParams('com_users');
		//print_r($temp);
		$user = new JUser;
		$data = (array)$this->getData();
		
		foreach ($temp as $k => $v) {
			$data[$k] = $v;
		}
		
		$data['email']		= $data['email'];
		$data['password']	= $data['password'];
		$data['username']	= $data['user'];
		//$useractivation = $params->get('useractivation');
		//$sendpassword = $params->get('sendpassword', 1);
		
		// Bind the data.
		if (!$user->bind($data)) {
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
			return false;
		}
		
		// Load the users plugin group.
		JPluginHelper::importPlugin('user');

		// Store the data.
		if (!$user->save()) {
			print_r($user->getError());
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
			return false;
		}
		
		print_r('registrado');
	}

}