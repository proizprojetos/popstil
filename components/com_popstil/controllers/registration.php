<?php

defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT.'/controller.php';

class PopstilControllerRegistration extends PopstilController {
	
	public function getActivate() {
		
		print_r('entrou no activate');
		
		$user = JFactory::getUser();
		
		if($user->get('id')) {
			print_r('usuario já logado<br/>');
			return true;
		}else {
			print_r('usuario não logado<br/>');
			return false;
		}
		
		return false;
		
	}
	
	public function register() {
		// Check for request forgeries.
		JSession::checkToken() or $this->setRedirect(JRoute::_('index.php?option=com_popstil&view=registration', false));;
		
		//Inicia as variavies
		$app = JFactory::getApplication();
		$modelUsuario	= $this->getModel('Usuario', 'PopstilModel');
		$model = $this->getModel('registration', 'PopstilModel');
		
		//Pega os dados digitados na tela
		$requestData = JRequest::getVar('cadastro', array(), 'post', 'array');
		
		$form	= $modelUsuario->getForm();
		
		
		//print_r($form);
		echo '<br/><br/>';
		
		$data	= $modelUsuario->validate($form, $requestData);

		//Validação, caso de falso, retorna para a tela de cadatro		
		if($data === false) {
//		
			//Pega as mensagens de validação
			$errors = $model->getErrors();
			print_r($errors);	
//			
			$app->enqueueMessage('Preencha todos os campos obrigatorios', 'warning');
			//Coloca as mensagens de validação para o usuario
			for($i = 0, $n = count($errors); $i< $n && $i < 3; $i++ ) {
				if($errors[$i] instanceof exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}else {
					$app->enqueueMessage($error[$i], 'warning');
				}
			}		
			//Coloca os dados digitados nos campos
			$app->setUserState('com_popstil.registration.data', $requestData);
			//Redireciona para a tela de cadastro
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=registration', false));
			return false;
		}	
		
		
		//Grava dos dados do usuario
		$return = $model->register($requestData);
		
		if($return === false){
			
			//$erro = $app->getUserState('com_popstil.registration.erro', string);
			
			//$this->setMessage($erro, 'warning');
			$this->setMessage($model->getError(), 'warning');
			//$app->setUserState('com_popstil.registration.erro', null);
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=registration', false));
			return false;
			
		}
		
		$app->setUserState('com_popstil.registration.data', null);
		
		//Redireciona para a pagina 
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));
		
	}

}
