<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_popstil'.DS.'tables');


class PopstilModelRegistration extends JModelForm {
	
	protected $data;
	
	public function getData() {
		//$data = JFactory::getApplication()->getUserState('com_popstilcustomizacao.registration.data', array());
		//print_r('<br/>oiii</br>');
		
		$user = JFactory::getUser();
		//print_r($user);
		/*if($user->guest) {
			print_r('Voce deve ser logar para continuar');
		}*/
		
		if($this->data === null) {
			
			$this->data = new stdClass();
			$app 		= JFactory::getApplication();
			$params		= JComponentHelper::getParams('com_popstil');
			
			$temp = (array)$app->getUserState('com_popstil.registration.data', array());
			
			//print_r($temp);
			
			foreach ($temp as $k => $v) {
				$this->data->$k = $v;
			}
			
			$this->data->groups = array();
			
			$system	= $params->get('new_usertype', 2);
			
			$this->data->groups[] = $system;
			
			// Unset the passwords.
			unset($this->data->password);
			unset($this->data->password2);
			
			// Get the dispatcher and load the users plugins.
			$dispatcher	= JDispatcher::getInstance();
			JPluginHelper::importPlugin('user');

			// Trigger the data preparation event.
			$results = $dispatcher->trigger('onContentPrepareData', array('com_users.registration', $this->data));

			// Check for errors encountered while preparing the data.
			if (count($results) && in_array(false, $results, true)) {
				$this->setError($dispatcher->getError());
				$this->data = false;
			}
			
		}
		//echo('Dados digitados<br/>');
		//print_r($this->data);
		
		return $this->data;
	}
	protected function loadFormData()
	{
		return $this->getData();
	}
	
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
		$form = $this->loadForm('com_popstil.registration', 'registration', array('control' => 'cadastro', 'load_data' => $loadData));
		if (empty($form)) {
			
			return false;
		}
		
		return $form;
	}
	
	protected function verificarUserName($username) {
		
		$db		= $this->getDbo();
		$query = $db->getQuery(true);
		$query->select(' u.id ');
		$query->from('#__popstil_usuarios u');
		$query->where(' u.username = \''.$username.'\'');
		
		
		$db->setQuery((String) $query,0,1);
		$result = $db->loadObjectList();
		
		return (isset($result[0] -> id) ? true : false);
		
	}
	
	public function getActivate() {
		//print_r('entrou aki no models -> activ do popstilcadastrousuario');
	}
	
	public function register($temp) {
	
		$config = JFactory::getConfig();
		$db		= $this->getDbo();
		$params = JComponentHelper::getParams('com_users');
		//print_r($temp);
		$user = new JUser;
		$data = (array)$this->getData();
//		
		foreach ($temp as $k => $v) {
			$data[$k] = $v;
		}
		
		$data['email']		= $data['email'];
		$data['password']	= $data['password'];
		$data['username']	= $data['username'];
		//$useractivation = $params->get('useractivation');
		//$sendpassword = $params->get('sendpassword', 1);
		
		if($data['password'] != $data['password2']) {
			$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_PASSWORD_DIFERENTES'));
			//JFactory::getApplication()->setUserState('com_popstil.registration.erro', 'COM_POPSTIL_REGISTRATION_PASSWORD_DIFERENTES');
			return false;
		}
		
		
		$data['cpf']	= preg_replace('/[^0-9]+/','',$data['cpf']);
		
		$datanascimento = explode('/', $data['datanascimento']);
		
		list($d, $m, $y) = explode('/', $data['datanascimento']);
		$mk = mktime(0,0,0,$m,$d,$y);
		
		$data['datanascimento'] = strftime('%Y-%m-%d',$mk);				
		$data['dataregistro'] = strftime('%Y-%m-%d %H:%M:%S',time());
		
		echo '<br/><br/>';
		print_r($data);
		echo '<br/><br/>';
		
		//$row = JTable::getInstance('usuario', 'Table');
		$tableUsuario = JTable::getInstance('usuario', 'PopstilTable');
		$tableEndereco = JTable::getInstance('endereco', 'PopstilTable');		
		
		
		$data['name'] = $data['nomecompleto'];		
		//Bind the data.
		if (!$user->bind($data)) {
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
			//JFactory::getApplication()->setUserState('com_popstil.registration.erro', 'COM_USERS_REGISTRATION_BIND_FAILED');
			return false;
		}
		
		//Load the users plugin group.
		JPluginHelper::importPlugin('user');

		// Store the data.
		if (!$user->save()) {
			print_r($user->getError());
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
			//JFactory::getApplication()->setUserState('com_popstil.registration.erro', 'COM_USERS_REGISTRATION_SAVE_FAILED');
			return false;
		}
		
		
		$data['idusuario_joomla'] = $user->id;
		
		if (!$tableUsuario->bind($data)) {
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $tableUsuario->getError()));
			return false;
		}
		//Salva os dados do usuario.
		if($this->verificarUserName($data['username'])) {
			//JFactory::getApplication()->setUserState('com_popstil.registration.erro', 'COM_POPSTIL_REGISTRATION_USERNAME_REGISTRADO');
			$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_USERNAME_REGISTRADO',$tableUsuario->getError()));
			return false;			
		}else {
			//Grava o usuario
			$tableUsuario->store();
		}	
		
		if (!$tableUsuario->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_USER_SAVE_FAILED',$tableUsuario->getError()));
			return false;
		}
		
		$data['popstil_usuario_idusuario'] = $tableUsuario->id;
		if (!$tableEndereco->bind($data)) {
			$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_ENDERECO_BIND_FAILED', $tableEndereco->getError()));
			return false;
		}
		//Salva os dados do endereco.
		if (!$tableEndereco->store()) {
			print_r($tableEndereco->getError());
			$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_ENDERECO_SAVE_FAILED', $tableEndereco->getError()));
			return false;
		}
	
		$this->enviaremailcadastro($data);
		
		
		//Aqui em baixo ele salva o usuario no users nativo do joomla
		
//		$data['name'] = $data['nomecompleto'];		
		//Bind the data.
//		if (!$user->bind($data)) {
//			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
			//JFactory::getApplication()->setUserState('com_popstil.registration.erro', 'COM_USERS_REGISTRATION_BIND_FAILED');
//			return false;
//		}
//		
		//Load the users plugin group.
//		JPluginHelper::importPlugin('user');
//
		// Store the data.
//		if (!$user->save()) {
//			print_r($user->getError());
//			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
			//JFactory::getApplication()->setUserState('com_popstil.registration.erro', 'COM_USERS_REGISTRATION_SAVE_FAILED');
//			return false;
//		}
//		
//		print_r('registrado');
	}
	
	
	public function enviaremailcadastro($dados) {
		
		$mailer = JFactory::getMailer();
		
		$config = JFactory::getConfig();
		/*$sender = array( 
		    $config->getValue( 'luiz@proiz.com' ),
		    $config->getValue( 'config.fromname' ));
		 */
		$mailer->setSender('sac@popstil.com');
		
		$user = JFactory::getUser();
		$recipient = $user->email;
		 
		$mailer->addRecipient($dados['email']);
		
		$body   = "<body style='background: #f6f6f6; text-align:center; font-family: Tahoma'>
			<div class='corpo_wrapper' style='background: #fff; width:750px; display: inline-block; border: 1px solid #c6c8ca; -webkit-box-shadow: 2px 2px 3px 0px #bcbec0;
			-moz-box-shadow: 2px 2px 3px 0px #bcbec0;box-shadow: 2px 2px 3px 0px #bcbec0;'>
				<div class='corpo' style='margin: 0px 70px 50px 70px;text-align: left;'>
					<div class='header'>
						<img src='http://www.popstil.com/images/logo_email.png' alt='Bem vindo' style='margin: 0px 0px 0px -70px;width: 750px;' />
					</div>
					
					<div class='titulo'>
						<h1 style='font-family: Tahoma;font-size: 30px;	color: #58595b;	font-weight: normal;text-align: center;	line-height: 60px;'>
							Seja Bem-vindo(a) ao Popstil, ".$dados['nomecompleto']."!</h1>
						<p style='font-family: Tahoma;font-size: 16px;text-align: left;	line-height: 25px;'>
							Agora você já pode efetuar e acompanhar pedidos e receber as últimas novidades do Popstil com seu e-mail!</p> 
					</div>
					
					<div class='conteudo' style='margin-top: 30px;' >
						<h4 style='font-family: Tahoma;	font-size: 15px;font-weight: normal;'>
							Seus dados são:
						</h4>
						<div class='conteudo_info' style='display: inline-block;margin-right: 15px;	margin: 0px 0px 10px 0px;'>
							<h3 style='font-size: 18px;display: inline-block;'>Endereco:</h3>
							<h5 style='font-weight: normal;display: inline-block;'>".$dados['endereco'].", ".$dados['numero']." </h5>
						</div>
						<div class='conteudo_info'>
							<h3 style='font-size: 18px;display: inline-block;'>CEP:</h3>
							<h5 style='font-weight: normal;display: inline-block;'>".$dados['cep']."</h5>
						</div>
						<div class='conteudo_info'>
							<h3 style='font-size: 18px;display: inline-block;'>Cidade:</h3>
							<h5 style='font-weight: normal;display: inline-block;'>".$dados['cidade']." </h5>
						</div>
						<div class='conteudo_info'>
							<h3 style='font-size: 18px;display: inline-block;'>Estado:</h3>
							<h5 style='font-weight: normal;display: inline-block;'>".$dados['estado']." </h5>
						</div>
						<div class='conteudo_info'>
							<h3 style='font-size: 18px;display: inline-block;'>Telefone 1:</h3>
							<h5 style='font-weight: normal;display: inline-block;'> (".$dados['ddd1'].") ".$dados['telefone1']." </h5>
						</div>
						<h4>Você pode:</h4>
						
						<div class='links'>
							<p style='margin: 0 auto;font-size: 15px;'>
								<a href='http://www.popstil.com' style='text-decoration: none;color: #0093d0;'>Fazer um pedido</a>
							</p>
						</div>
						<br/>
						<h4>Se você não realizou este cadastro, avise-nos <b style='color: #0093d0;	font-weight: normal;'>sac@popstil.com</b></h4>
						<h4>Em caso de dúvidas, visite nossa página de <u><a href='http://www.popstil.com'>perguntas frequentes</a></u></h4>
						<br/>
						<h4>Atenciosamente,</h4>
						<h4>Popstil.</h4>
					</div>
				</div>
			</div>";
		
		$mailer->isHTML(true);
		//$mailer->Encoding = 'base64';
		/*$mailer->CharSet = "UTF8";*/
		$mailer->setSubject('Bem vindo ao Popstil');
		$mailer->setBody($body);
		$mailer->AddCustomHeader('Content-type: text/html; charset=utf-8');
		
		$send = $mailer->Send();		
	}
	

}