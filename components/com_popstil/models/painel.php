<?php

defined('_JEXEC') or die('Restricted access');

//jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_popstil'.DS.'tables');

class PopstilModelPainel extends JModelForm {
	
	//protected $msg;
	protected $data;
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_popstil.painel', 'painel', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}
	
	public function getpedidos() {
	
		$user =JFactory::getUser();
		
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select('p.*');
		$query->from('#__popstil_pedidos p');
		$query->join('INNER', '#__popstil_usuarios user on user.id = p.popstil_usuario_idusuario ');
		$query->join('INNER', '#__users u on u.id = user.idusuario_joomla ');
		$query->where(' u.id = '.$user->id);
		$db->setQuery((String) $query);
		$pedidos = $db->loadObjectList();
		
		return $pedidos;
	}
	
	public function getpedidosandamento() {
		
		$user =JFactory::getUser();
	
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query->select('p.*');
		$query->from('#__popstil_pedidos p ');
		$query->join('INNER', '#__popstil_usuarios user on user.id = p.popstil_usuario_idusuario ');
		$query->join('INNER', '#__users u on u.id = user.idusuario_joomla ');
		$query->where(' u.id = '.$user->id . ' and p.status_pedido != \'CON\'');
		$db->setQuery((String) $query);
		$pedidosandamento = $db->loadObjectList();
		
		foreach ($pedidosandamento as $chave => &$pedido) {
			
			$query = $db->getQuery(true);
			$query->select('item.*, arte.url_arte');
			$query->from('#__popstil_item_pedido item');
			$query->join('LEFT', '#__popstil_arte arte on arte.id = item.popstil_arte_id');
			$query->where(' item.popstil_pedido_idpedido = '.$pedido->idpedido);
			$db->setQuery((String) $query);
			$itensdopedido = $db->loadObjectList();
			
			$pedido->itens = $itensdopedido;
			
		}
		
		
		return $pedidosandamento;
	}
	
	public function getitensdepedidosemandamento() {
		
		$user = JFactory::getUser();
		
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		/*
		SELECT i . * 
		FROM joomla03_popstil_item_pedido i
		INNER JOIN joomla03_popstil_pedidos p ON i.popstil_pedido_idpedido = p.idpedido
		INNER JOIN joomla03_popstil_usuarios user ON user.id = p.popstil_usuario_idusuario
		INNER JOIN joomla03_users u ON u.id = user.idusuario_joomla
		WHERE u.id =555
		AND p.status_pedido !=  'CON'
		*/
		
		$query->select('i.*');
		$query->from('#__popstil_item_pedido i ');
		$query->join('INNER','#__popstil_pedidos p ON i.popstil_pedido_idpedido = p.idpedido');
		$query->join('INNER','#__popstil_usuarios user ON user.id = p.popstil_usuario_idusuario');
		$query->join('INNER','#__users u ON u.id = user.idusuario_joomla ');
		$query->where(' u.id = '.$user->id . ' and p.status_pedido != \'CON\'');
		$db->setQuery((String) $query);
		$pedidosandamento = $db->loadObjectList();		
		
		return $pedidosandamento;
		
		
	}
	
	/*Método que busca o pedido que o usuario seleciona para realizar o pagamento e retorna 
	 o pedido com todos os dados para realizar o pagamento*/
	public function getpedidopagamento() {
		
		$idpedido = JRequest::getVar('idpedido');
		
		$user = JFactory::getUser();
		
		$db = JFactory::getDBO();
		
		//Busca o pedido em si
		$query = $db->getQuery(true);
		$query->select('p.*, user.*, end.*');
		$query->from('#__popstil_pedidos p ');
		$query->join('INNER', '#__popstil_usuarios user on user.id = p.popstil_usuario_idusuario ');
		$query->join('INNER', '#__users u on u.id = user.idusuario_joomla ');
		$query->join('INNER', '#__popstil_enderecos end on end.popstil_usuario_idusuario = user.id');
		$query->where('p.idpedido = '.$idpedido.' and u.id = '.$user->id);
		$db->setQuery((String) $query);
		$pedido = $db->loadObjectList();
		
		$pedido = $pedido[0];
		
		//Busca os itens do pedido e adiciona ao objeto do pedido
		$query = $db->getQuery(true);
		$query->select('item.*, arte.url_arte');
		$query->from('#__popstil_item_pedido item');
		$query->join('LEFT', '#__popstil_arte arte on arte.id = item.popstil_arte_id');
		$query->where(' item.popstil_pedido_idpedido = '.$idpedido);
		$db->setQuery((String) $query);
		$itensdopedido = $db->loadObjectList();
		
		$pedido->itens = $itensdopedido;
		
		//Para cada item do pedido busca os quadros do item
		foreach ($pedido->itens as $key => &$item) {
			$query = $db->getQuery(true);
			$query->select('quadro.* ');
			$query->from('#__popstil_quadros quadro');
			//$query->join('LEFT', '#__popstil_arte arte on arte.id = item.popstil_arte_id');
			$query->where(' quadro.popstil_item_pedido_id = '.$item->popstil_item_pedido_id);
			$db->setQuery((String) $query);
			$quadros = $db->loadObjectList();
			
			$item->quadros = $quadros;
		}
		
		
		return $pedido;
	}
	
	public function getartesconcluidas() {
		$user = JFactory::getUser();
		
		$db = JFactory::getDBO();
		
		/*SELECT arte.*, pedido.idpedido FROM joomla03_popstil_arte arte
		inner join joomla03_popstil_item_pedido item on item.popstil_arte_id = arte.id
		inner join joomla03_popstil_pedidos pedido on pedido.idpedido = item.popstil_pedido_idpedido
		where pedido.popstil_usuario_idusuario = 138 and item.status_pedido = 'CON'*/
		
		$query = $db->getQuery(true);
		$query->select('arte.*');
		$query->from('#__popstil_arte arte ');
		$query->join('INNER', '#__popstil_item_pedido item on item.popstil_arte_id = arte.id ');
		$query->join('INNER', '#__popstil_pedidos pedido on pedido.idpedido = item.popstil_pedido_idpedido');
		$query->join('INNER', '#__popstil_usuarios user on user.id = pedido.popstil_usuario_idusuario');
		$query->join('INNER', '#__users u on u.id = user.idusuario_joomla');
		$query->where('u.id = '.$user->id);
		$query->where('item.status_pedido = \'CON\' or item.status_pedido = \'ENV\'');
		$db->setQuery((String) $query);
		$artes = $db->loadObjectList();
		
		return $artes;
		
	}
	
	
	public function aprovararte($idpedido, $iditem) {
		
		$tableItem 	 	= JTable::getInstance('itempedido', 'PopstilTable');
		
		$dadositempedido = array();
		$dadositempedido['popstil_item_pedido_id'] = $iditem;
		$dadositempedido['status_pedido'] = 'ARP';
		
		
		if(!$tableItem->bind($dadositempedido)) {
			$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_ITEMPEDIDO_BIND_FAILED', $tableItem->getError()));
			return false;
		}
		
		if(!$tableItem->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_ITEMPEDIDO_STORE_FAILED', $tableItem->getError()));
			return false;
		}
		
		$this->enviaremailalteracaopedido($idpedido, true, '');
		
	}
	
	public function alterararte($arteid, $iditem, $texto, $idpedido) {
		
		$tableAlterar	= JTable::getInstance('alteracaopopstil', 'PopstilTable');
		
		$dados = array();
		$dados['arte_id'] = $arteid;
		$dados['item_pedido_id'] = $iditem;
		$dados['desc_alteracao'] = $texto;
		
		if(!$tableAlterar->bind($dados)) {
			$this->setError(JText::sprintf('COM_POPSTIL_ALTERARARTE_BIND_FAILED', $tableItem->getError()));
			return false;
		}
		
		if(!$tableAlterar->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_ALTERARARTE_STORE_FAILED', $tableItem->getError()));
			return false;
		}
		
		$tableItem 	 	= JTable::getInstance('itempedido', 'PopstilTable');
		
		$dadositempedido = array();
		$dadositempedido['popstil_item_pedido_id'] = $iditem;
		$dadositempedido['status_pedido'] = 'PRO';
		
		
		if(!$tableItem->bind($dadositempedido)) {
			$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_ITEMPEDIDO_BIND_FAILED', $tableItem->getError()));
			return false;
		}
		
		if(!$tableItem->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_ITEMPEDIDO_STORE_FAILED', $tableItem->getError()));
			return false;
		}
		
		$this->enviaremailalteracaopedido($idpedido, false, $texto);
		
		/*Altera o status do pedido para em produção novamente*/
		/*$tablePedido		=	JTable::getInstance('pedido','PopstilTable');
		
		$db = JFactory::getDBO();
		//Busca o pedido em si
		$query = $db->getQuery(true);
		$query->select('p.*');
		$query->from('#__popstil_pedidos p ');
		$query->where('p.idpedido = '.$dadositempedido->popstil_pedido_idpedido);
		$db->setQuery((String) $query);
		$dadosPedido = $db->loadObject();
		
		//$dadosPedido['idpedido'] = $dadositempedido->popstil_pedido_idpedido;
		$dadosPedido['status_pedido'] = 'PRO' ;
		
		if(!$tablePedido->bind($dadosPedido)) {
			$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_PEDIDO_BIND_FAILED', $tableItem->getError()));
			return false;
		}
		
		if(!$tablePedido->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_PEDIDO_STORE_FAILED', $tableItem->getError()));
			return false;
		}*/
		
	}
	
	public function alterarfoto($iditem, $idpedido, $imagem) {
		
		$tableAlterar	= JTable::getInstance('itempedido', 'PopstilTable');
		
		$dados = array();
		$dados['popstil_item_pedido_id'] = $iditem;
		$dados['popstil_pedido_idpedido'] = $idpedido;
		$dados['foto_cliente'] = $imagem;
		$dados['status_pedido'] = 'ANA';
		
		if(!$tableAlterar->bind($dados)) {
			$this->setError(JText::sprintf('COM_POPSTIL_ALTERARARTE_BIND_FAILED', $tableItem->getError()));
			return false;
		}
		
		if(!$tableAlterar->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_ALTERARARTE_STORE_FAILED', $tableItem->getError()));
			return false;
		}
		
		$tablePedido	= JTable::getInstance('pedido', 'PopstilTable');
		
		$dados = array();
		$dados['idpedido'] = $idpedido;
		$dados['status_pedido'] = 'ANA';
		
		if(!$tablePedido->bind($dados)) {
			$this->setError(JText::sprintf('COM_POPSTIL_ALTERARARTE_BIND_FAILED', $tableItem->getError()));
			return false;
		}
		
		if(!$tablePedido->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_ALTERARARTE_STORE_FAILED', $tableItem->getError()));
			return false;
		}
		
		
		//$this->enviaremailalteracaopedido($idpedido, false, $texto);

	}
	
	public function getusuario() {
	
		$user = JFactory::getUser();
		
		$db = JFactory::getDBO();
	
		$query = $db->getQuery(true);
		$query->select('usuario.*, end.*');
		$query->from('#__popstil_usuarios usuario ');
		$query->join('INNER', '#__popstil_enderecos end on end.popstil_usuario_idusuario = usuario.id');
		$query->where('usuario.idusuario_joomla = '.$user->id);
		$db->setQuery((String) $query);
		$usuario = $db->loadObject();
		
		return $usuario;
		
	}
	
	public function alterarSenha($dados) {
	
		$db = JFactory::getDBO();
		
		
		$query = $db->getQuery(true);
		$query->select('usuario.*');
		$query->from('#__popstil_usuarios usuario ');
		$query->where('usuario.idusuario_joomla = '.$dados['idusuario_joomla']);
		$db->setQuery((String) $query);
		$usuario = $db->loadObject();
		
		if(!isset($usuario) || empty($usuario)) {
			$this->setError(JText::sprintf('COM_POPSTIL_FIND_USER_ERROR'));
			return false;
		}else {
			if($usuario->password != $dados['atual']) {
				$this->setError(JText::sprintf('COM_POPSTIL_ALTARSENHA_SENHA_INVALIDA'));
				return false;
			}
		}
		
		//print_r($usuario);
		
		$dados['id'] = $usuario->id;
		$dados['password'] = $dados['senha1'];
		
		$tableUsuario 	 	= JTable::getInstance('usuario', 'PopstilTable');
		
		if(!$tableUsuario->bind($dados)) {
			$this->setError(JText::sprintf('COM_POPSTIL_ALTERARSENHA_BIND_FAILED', $tableUsuario->getError()));
			return false;
		}
		
		if(!$tableUsuario->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_ITEMPEDIDO_STORE_FAILED', $tableUsuario->getError()));
			return false;
		}
		
		//Atualiza no joomla tambem
		$params = JComponentHelper::getParams('com_users');
		//print_r($temp);
		$user = new JUser;
		
		$data['id'] = $dados['idusuario_joomla'];
		$data['password']	= $dados['senha1'];
		$data['email']		= $usuario->email;
		$data['username']	= $usuario->username;
		$data['name']		= $usuario->nomecompleto;
		print_r($data);
		
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

		
		
		return true;
		
	}
	
	public function alterardados($temp) {
		
		$db = JFactory::getDBO();
		
		$user = JFactory::getUser();
		
		$query = $db->getQuery(true);
		$query->select('usuario.*');
		$query->from('#__popstil_usuarios usuario ');
		$query->where('usuario.idusuario_joomla = '.$user->id);
		$db->setQuery((String) $query);
		$usuario = $db->loadObject();
		
		if(!isset($usuario) || empty($usuario)) {
			$this->setError(JText::sprintf('COM_POPSTIL_FIND_USER_ERROR'));
			return false;
		}
		//print_r($temp);
		$dados['id'] = $usuario->id;
		foreach ($temp as $k => $v) {
			$dados[$k] = $v;
		}
		
		$dados['cpf']	= preg_replace('/[^0-9]+/','',$dados['cpf']);
		
		$datanascimento = explode('/', $dados['datanascimento']);		
		
		list($d, $m, $y) = explode('/', $dados['datanascimento']);
		$mk = mktime(0,0,0,$m,$d,$y);
		
		$dados['datanascimento'] = strftime('%Y-%m-%d',$mk);
		
		//print_r($dados);
		
		$tableUsuario 	 	= JTable::getInstance('usuario', 'PopstilTable');
		
		if(!$tableUsuario->bind($dados)) {
			$this->setError(JText::sprintf('COM_POPSTIL_ALTERARSENHA_BIND_FAILED', $tableUsuario->getError()));
			return false;
		}
		
		if(!$tableUsuario->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_ITEMPEDIDO_STORE_FAILED', $tableUsuario->getError()));
			return false;
		}
		
		
		$dados['popstil_usuario_idusuario'] = $usuario->id;
		$dados['id'] = $dados['id_endereco'];
		
		$tableEndereco = JTable::getInstance('endereco', 'PopstilTable');
		if (!$tableEndereco->bind($dados)) {
			$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_ENDERECO_BIND_FAILED', $tableEndereco->getError()));
			return false;
		}
		//Salva os dados do endereco.
		if (!$tableEndereco->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_REGISTRATION_ENDERECO_SAVE_FAILED', $tableEndereco->getError()));
			return false;
		}
				
		//Atualiza no joomla tambem
		$params = JComponentHelper::getParams('com_users');

		$user = new JUser;
		
		$data = array();
		
		$data['id'] 			= $usuario->idusuario_joomla;
		$data['email']			= $dados['email'];
		$data['username']		= $dados['username'];
		$data['name']			= $dados['nomecompleto'];
		$data['sendemail']		= $dados['enviaremail'] == 'S' ? 1 : 0;
		echo '<br/><br/>';
		print_r($data);
		
		
		if (!$user->bind($data)) {
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
			JFactory::getApplication()->setUserState('com_popstil.registration.erro', 'COM_USERS_REGISTRATION_BIND_FAILED');
			return false;
		}
		
		//Load the users plugin group.
		JPluginHelper::importPlugin('user');

		//Store the data.
		if (!$user->save()) {
			print_r($user->getError());
			$this->setError(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
			JFactory::getApplication()->setUserState('com_popstil.registration.erro', 'COM_USERS_REGISTRATION_SAVE_FAILED');
			return false;
		}
		
		return true;	
	}
	
	
	public function enviaremailalteracaopedido($numeropedido, $aprovado, $motivo) {

		$mailer = JFactory::getMailer();
		
		$config = JFactory::getConfig();
		
		$mailer->setSender('vendas@popstil.com');

		$mailer->addRecipient('vendas@popstil.com');
		
		$texto = '';
		$textoaprovado = 'aprovado';
		
		if(!$aprovado) {
			$texto = 'Motivo: '.$motivo;
			$textoaprovado = 'recusado';
		}
		
		
		
		$body   = "<body style='background: #f6f6f6; text-align:center; font-family: Tahoma'>
			<div class='corpo_wrapper' style='background: #fff; width:750px; display: inline-block; border: 1px solid #c6c8ca; -webkit-box-shadow: 2px 2px 3px 0px #bcbec0;
			-moz-box-shadow: 2px 2px 3px 0px #bcbec0;box-shadow: 2px 2px 3px 0px #bcbec0;'>
				<div class='corpo' style='margin: 0px 70px 50px 70px;text-align: left;'>
					<div class='header'>
						<img src='http://www.popstil.com/images/logo_email.png' alt='Bem vindo' style='margin: 0px 0px 0px -70px;width: 750px;' />
					</div>
					
					<div class='titulo'>
						<h1 style='font-family: Tahoma;font-size: 30px;	color: #58595b;	font-weight: normal;text-align: center;	line-height: 60px;'>
							A arte do pedido numero: ".$numeropedido.", foi ".$textoaprovado."!</h1>
						<p style='margin: 0 auto;font-size: 15px;'>
							<a href='http://www.popstil.com/administrator/index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido=".$numeropedido."' style='text-decoration: none;color: #0093d0;'>Acessar pedido</a>
						</p>
					</div>
					
					<div class='conteudo' style='margin-top: 30px;' >
						<br/>
						
						<h4>".$texto."</h4>
						
					</div>
				</div>
			</div>";
		
		$mailer->isHTML(true);
		//$mailer->Encoding = 'base64';
		/*$mailer->CharSet = "UTF8";*/
		$mailer->setSubject('Alteração do pedido');
		$mailer->setBody($body);
		$mailer->AddCustomHeader('Content-type: text/html; charset=utf-8');
		
		$send = $mailer->Send();
		if ( $send !== true ) {
		    $this->setError(JText::sprintf('Erro ao enviar email', $temp->getError()));
		    return false;
		} else {
		    echo 'Mail sent';
		}	
	}
	

}

?>