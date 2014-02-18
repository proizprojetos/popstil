<?php


// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controllerform');

jimport('joomla.filesystem.file');
/**
 * HelloWorlds Controller
 */
class PopstilControllerPedido extends JControllerForm
{

	/*public function getModel($name = 'Pedido', $prefix = 'PopstilModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}*/
	
	public function viewpedido() {
		
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido='.JRequest::getVar('id'), false));
	}
	
	public function cancelar() {
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=pedidos', false));
	}
	
	public function salvar() {
		
		$itempedidos 	= JRequest::getVar('item_pedido', array(), 'post', 'array');
		$quadrositem 	= JRequest::getVar('quadro_item', array(), 'post', 'array');
		$idpedido 		= JRequest::getVar('idpedido');
		
		$model = $this->getModel('pedido', 'PopstilModel');
		
		print_r($itempedidos);
				
		foreach ($itempedidos as $key => &$itempedido) {
			if((($itempedido['status_pedido']) === 'APR') && ($itempedido['status_anterior'] != $itempedido['status_pedido'])) {
				
				if(empty($_FILES['item_pedido']['name'][$key]['arte'])) {
					$this->setMessage('A arte item de pedido '.($key+1).' não foi inserida.', 'warning');
					$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido='.$idpedido, false));
					return false;
				}else {
					try {
						$data = (date("d_m_Y_H_i_s"));
						$extensao = pathinfo($_FILES['item_pedido']['name'][$key]['arte'], PATHINFO_EXTENSION);
						$fileName = 'popstil_arte_pedido_'.$idpedido.'_item_'.$itempedido['popstil_pedido_idpedido'].'_em_'.$data.'.'.$extensao;
						$fileTemp = $_FILES['item_pedido']['tmp_name'][$key]['arte'];
						$uploadPath = JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'com_popstil'.DIRECTORY_SEPARATOR.'artes'.DIRECTORY_SEPARATOR.$fileName;
						$imagempopstil = JURI::root().'media/com_popstil/artes/'.$fileName;
					}catch(Exception $ex) {
						echo ('O seguinte erro aconteceu: '.$ex);
					}
					//$this->imagem = preg_replace("\\", "//", $this->imagem);
					if(!JFile::upload($fileTemp, $uploadPath)) 
					{
							echo JText::_( 'Erro ao mover foto.' );
							return;
					}
					
					//Qualquer erro que o servidor registrar no upload.
					$fileError = $_FILES['quadro_item']['error'];
					if($fileError > 0) {
						switch($fileError) {
							case 1:
							echo JText::_('Arquivo grande demais.');
							return;
							
							case 2:
							echo JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
							return;
					 
							case 3:
							echo JText::_( 'ERROR PARTIAL UPLOAD' );
							return;
					 
							case 4:
							echo JText::_( 'ERROR NO FILE' );
							return;
						}
					}
					$arte = array();
					$arte['url_arte'] = $imagempopstil;
					$arte['id_usuario'] = $itempedido['id_usuario'];
					$arte['datagravacao'] = strftime('%Y-%m-%d %H:%M:%S',time());
					
					if(!empty($itempedido['id_arte'])){
						$arte['id'] = $itempedido['id_arte'];
					}
					
					$idarte = $model->salvarArte($arte);
					$itempedido['popstil_arte_id'] = $idarte;
				}			
				foreach ($quadrositem as $chave => &$quadro) {
					if($quadro['id_itempedido'] === $itempedido['popstil_item_pedido_id']) {
						if(empty($_FILES['quadro_item']['name'][$chave]['arte'])) {
							$this->setMessage('Os itens de pedido com status de arte pronta nao possuem arte inserida', 'warning');
							$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido='.$idpedido, false));
							return false;
						}else{
							//Realiza o upload da imagem.
							try {
								$data = (date("d_m_Y_H_i_s"));
								$extensao = pathinfo($_FILES['quadro_item']['name'][$chave]['arte'], PATHINFO_EXTENSION);
								$fileName = 'popstil_arte_pedido_'.$idpedido.'_item_'.$quadro['id_itempedido'].'_quadroid_'.$quadro['id'].'_em_'.$data.'.'.$extensao;
								$fileTemp = $_FILES['quadro_item']['tmp_name'][$chave]['arte'];
								$uploadPath = JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'com_popstil'.DIRECTORY_SEPARATOR.'artes'.DIRECTORY_SEPARATOR.'popstil'.DIRECTORY_SEPARATOR.$fileName;
								$imagem = JURI::root().'media/com_popstil/artes/popstil/'.$fileName;
							}catch(Exception $ex) {
								echo ('O seguinte erro aconteceu: '.$ex);
							}
							//$this->imagem = preg_replace("\\", "//", $this->imagem);
							if(!JFile::upload($fileTemp, $uploadPath)) 
							{
									echo JText::_( 'Erro ao mover foto.' );
									return;
							}
							
							//Qualquer erro que o servidor registrar no upload.
							$fileError = $_FILES['quadro_item']['error'];
							if($fileError > 0) {
								switch($fileError) {
									case 1:
									echo JText::_('Arquivo grande demais.');
									return;
									
									case 2:
									echo JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
									return;
							 
									case 3:
									echo JText::_( 'ERROR PARTIAL UPLOAD' );
									return;
							 
									case 4:
									echo JText::_( 'ERROR NO FILE' );
									return;
								}
							}
							
							/*$arte = array();
							$arte['url_arte'] = $imagem;
							$arte['id_usuario'] = $itempedido['id_usuario'];
							$arte['datagravacao'] = strftime('%Y-%m-%d %H:%M:%S',time());
							
							$idarte = $model->salvarArte($arte);
							$quadro['popstil_arte_id'] = $idarte;*/
							$quadro['url_popstil'] = $imagem;
						}
					}
					
				}
			}
		}
		
//		
//		
		

		$return = $model->salvarQuadros($quadrositem);
		$return = $model->salvarItemsPedido($itempedidos);
		
		
		//Verifica se todas o itens estao com o status igual para alterar o status do Pedido
		for ($i = 0; $i < sizeof($itempedidos); $i++) {
			$statusigual = true;
			$status = $itempedidos[$i]['status_pedido'];
			echo '<br />';	
			for ($f = $i+1; $f < sizeof($itempedidos); $f++) {
				if($itempedidos[$f]['status_pedido'] === $status) {
					$statusigual = true;
				}else {
					$statusigual = false;
				}
			}
			break;
		}
		
		if($statusigual) {
			$dadospedido = array();
			$dadospedido['idpedido'] = $idpedido;
			$dadospedido['status_pedido'] = $status;		
			$return = $model->salvarPedido($dadospedido);
		}
		
		
		if($return === false){
			
			$this->setMessage($model->getError(), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido='.$idpedido, false));
			return false;
			
		}
		
		//$dadosemail = array();
		//$dadosemail['numeropedido'] = $idpedido;
		
		$retorno = $model->enviaremailalteracaopedido($idpedido);
		
		if($return === false){
			
			$this->setMessage($model->getError(), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido='.$idpedido, false));
			return false;
			
		}
		
		$this->setMessage('Pedido salvo com sucesso', 'message');
		
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido='.$idpedido, false));
		return true;
		
		

		//print_r($quadrositem);
		//print_r($itempedidos);
		//echo '<br/><br/>';
		//print_r($quadrositem);
		//$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=pedidos', false));
	}
	
	//Método para carregar a imagem da arte enviada design
	public function carregaImagem($filename) {
		try {
			$fieldName = $filename;
			$data = (date("d_m_Y_H_i_s"));
			$extensao = pathinfo($filename, PATHINFO_EXTENSION);
			$fileName = 'popstil_arte_'.$data.'.'.$extensao;
			$fileTemp = $_FILES[$fieldName]['tmp_name'];
			$uploadPath = JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'com_popstil'.DIRECTORY_SEPARATOR.'artes'.DIRECTORY_SEPARATOR.$fileName;
			$imagem = JURI::base().'media/com_popstil/artes/'.$fileName;
		}catch(Exception $ex) {
			echo ('O seguinte erro aconteceu: '.$ex);	
		}
		//$this->imagem = preg_replace("\\", "//", $this->imagem);
		if(!JFile::upload($fileTemp, $uploadPath)) 
		{
				echo JText::_( 'Erro ao mover foto.' );
				return;
		}
		else
		{			
		   // success, exit with code 0 for Mac users, otherwise they receive an IO Error
		  //print_r('<br/>quadro upload com sucesso');
		}
		//Qualquer erro que o servidor registrar no upload.
		$fileError = $_FILES[$fieldName]['error'];
		if($fileError > 0) {
			switch($fileError) {
				case 1:
				echo JText::_('Arquivo grande demais.');
				return;
				
				case 2:
				echo JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
				return;
		 
				case 3:
				echo JText::_( 'ERROR PARTIAL UPLOAD' );
				return;
		 
				case 4:
				echo JText::_( 'ERROR NO FILE' );
				return;
			}
		}
		return $imagem != '' ? $imagem : 'Erro ao enviar a imagem';
	}
	
}