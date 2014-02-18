<?php

/**
 * @version		$Id: helloworld.php 51 2010-11-22 01:33:21Z chdemko $
 * @package		Joomla16.Tutorials
 * @subpackage	Components
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @author		Christophe Demko
 * @link		http://joomlacode.org/gf/project/helloworld_1_6/
 * @license		License GNU General Public License version 2 or later
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * HelloWorld Model
 */
class PopstilModelPedido extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Pedido', $prefix = 'PopstilTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_popsil.pedido', 'popstil', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	
	/**
	* Método para pegar o script que tem que ser incluido no formulario
	* @return string 	Arquivos de script
	**/
//	public function getScript() {
//		return 'administrator/components/com_helloworld/models/forms/helloworld.js';
//	}	
		
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_popstil.edit.pedido.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	public function getpedido() {
		
		//Pega o id do pedido passado por parametro
		$idpedido 	= JRequest::getVar('idpedido');
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos
		$query->select('p.*, pessoa.*, end.*');
		$query->from('#__popstil_pedidos p');
		$query->join('INNER', '#__popstil_usuarios pessoa ON pessoa.id = p.popstil_usuario_idusuario');
		$query->join('INNER', '#__popstil_enderecos end ON end.popstil_usuario_idusuario = pessoa.id');
		$query->where('p.idpedido = '.$idpedido);
		$db->setQuery((String) $query);
		$pedido = $db->loadObjectList();
		
		return $pedido[0];
	}
	
	public function getitenspedido() {
		
		$idpedido 	= JRequest::getVar('idpedido');
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos
		$query->select('item.*, arte.url_arte');
		$query->from('#__popstil_item_pedido item');
		$query->join('LEFT', '#__popstil_arte arte on arte.id = item.popstil_arte_id');
		$query->where('item.popstil_pedido_idpedido = '.$idpedido);
		$db->setQuery((String) $query);
		$itenspedido = $db->loadObjectList();
		
		foreach ($itenspedido as $chave => &$item) {
			
			$query = $db->getQuery(true);
			
			$query->select('alteracao.*');
			$query->from('#__popstil_alteracao_arte alteracao');
			$query->where('alteracao.item_pedido_id = '.$item->popstil_item_pedido_id);
			$db->setQuery((String) $query);
			$alteracaoarte = $db->loadObjectList();
			
			$item->alteracoes = $alteracaoarte;
			
		}
		
		return $itenspedido;
	}
	
	public function getquadrospedido() {
		
		$idpedido 	= JRequest::getVar('idpedido');
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos
 		$query->select('quadro.*, fundo.tipo_fundo,  cor.codigo_cor, padrao.url_imagem');
		$query->from('#__popstil_quadros quadro ');
		$query->join('INNER', '#__popstil_item_pedido item on item.popstil_item_pedido_id = quadro.popstil_item_pedido_id');
		$query->join('INNER', '#__popstil_pedidos pedido on pedido.idpedido = '.$idpedido.' and item.popstil_pedido_idpedido = pedido.idpedido');
		$query->join('LEFT', '#__popstil_customizacao_fundo fundo on fundo.id = popstil_fundo_id');
		$query->join('LEFT', '#__popstil_customizacao_fundo_corsolida cor on cor.id_fundo = fundo.id');
		$query->join('LEFT', '#__popstil_customizacao_fundo_padraografico padrao on padrao.id_fundo = fundo.id');
		$query->order('quadro.id');
		$db->setQuery((String) $query);
		$quadrospedido = $db->loadObjectList();
		
		return $quadrospedido;
	}
	
	
	public function salvarQuadros($temp) {		
	
		print_r($temp);
		
		foreach ($temp as $chave => $quadro) {
			$tableQuadro 	= JTable::getInstance('quadro', 'PopstilTable');
			echo '<br/><br/>';
			print_r($quadro);
			//Armazena os dados no tableQuadro para gravar
			if (!$tableQuadro->bind($quadro)) {
				$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_PEDIDO_BIND_FAILED', $tableQuadro->getError()));
				return false;
			}
			
			if (!$tableQuadro->store()) {
				$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_PEDIDO_STORE_FAILED', $tableQuadro->getError()));
				return false;
			}	
		}
		
		//return true;
		
	}
	
	public function salvarItemsPedido($temp) {
	
		$tableItemPedido 	= JTable::getInstance('itempedido', 'PopstilTable');
		
		//Armazena os dados no tablePedido para gravar
		
		foreach ($temp as $chave => $itempedido) {
			if($itempedido['status_anterior'] != $itempedido['status_pedido']) {
				if (!$tableItemPedido->bind($itempedido)) {
					$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_ITEMPEDIDO_BIND_FAILED', $tableItemPedido->getError()));
					return false;
				}
				
				if (!$tableItemPedido->store()) {
					$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_ITEMPEDIDO_STORE_FAILED', $tableItemPedido->getError()));
					return false;
				}
			}
		}	
		return true;
	}
	
	public function salvarPedido($temp) {
		$tablePedido 	= JTable::getInstance('pedido', 'PopstilTable');
		
		//Armazena os dados no tablePedido para gravar
		if (!$tablePedido->bind($temp)) {
			$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_PEDIDO_BIND_FAILED', $tablePedido->getError()));
			return false;
		}
		
		if (!$tablePedido->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_PEDIDO_STORE_FAILED', $tablePedido->getError()));
			return false;
		}
		return true;
	}
	
	public function salvarArte($temp) {
		
		$tableArte 	= JTable::getInstance('arte', 'PopstilTable');
		
		//Armazena os dados no tablePedido para gravar
		
		if (!$tableArte->bind($temp)) {
			$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_ARTE_BIND_FAILED', $temp->getError()));
			return false;
		}
		
		if (!$tableArte->store()) {
			$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_ARTE_STORE_FAILED', $temp->getError()));
			return false;
		}
		
		$idarte = $tableArte->id;
		
		return $idarte;
	}
	
	public function enviaremailalteracaopedido($numeropedido) {
	
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		//Seleciona os campos
		$query->select('usuario.*');
		$query->from('#__popstil_usuarios usuario');
		$query->join('INNER', '#__popstil_pedidos pedido ON pedido.popstil_usuario_idusuario = usuario.id');
		$query->where('pedido.idpedido = '.$numeropedido);
		$db->setQuery((String) $query);
		$usuario = $db->loadObject();
		
		$mailer = JFactory::getMailer();
		
		$config = JFactory::getConfig();
		/*$sender = array( 
		    $config->getValue( 'luiz@proiz.com' ),
		    $config->getValue( 'config.fromname' ));
		 */
		$mailer->setSender('vendas@popstil.com');
		
		//$user = JFactory::getUser();
		//$recipient = $user->email;
		 
		$mailer->addRecipient($usuario->email);
		
		$body   = "<body style='background: #f6f6f6; text-align:center; font-family: Tahoma'>
			<div class='corpo_wrapper' style='background: #fff; width:750px; display: inline-block; border: 1px solid #c6c8ca; -webkit-box-shadow: 2px 2px 3px 0px #bcbec0;
			-moz-box-shadow: 2px 2px 3px 0px #bcbec0;box-shadow: 2px 2px 3px 0px #bcbec0;'>
				<div class='corpo' style='margin: 0px 70px 50px 70px;text-align: left;'>
					<div class='header'>
						<img src='http://www.popstil.com/images/logo_email.png' alt='Bem vindo' style='margin: 0px 0px 0px -70px;width: 750px;' />
					</div>
					
					<div class='titulo'>
						<h1 style='font-family: Tahoma;font-size: 30px;	color: #58595b;	font-weight: normal;text-align: center;	line-height: 60px;'>
							Olá, ".$usuario->nomecompleto."!</h1>
						<p style='font-family: Tahoma;font-size: 16px;text-align: left;	line-height: 25px;'>
							O status do seu pedido ".$numeropedido.", foi alterado!</p> 
					</div>
					
					<div class='conteudo' style='margin-top: 30px;' >
						<br/>
						<h4>Clique <a href='http://www.popstil.com/index.php/meupopstil'>aqui</a> para acompanhar o status seu pedido: <b style='color: #0093d0;	font-weight: normal;'></h4>
						
						<h4>Em caso de dúvidas, visite nossa página de <u><a href='http://www.popstil.com'>perguntas frequentes</a></u> ou pelo email <b>sac@popstil.com</b></h4>
						<br/>
						<h4>Atenciosamente,</h4>
						<h4>Popstil.</h4>
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
