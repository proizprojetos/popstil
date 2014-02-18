<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');

class PopstilController extends JControllerLegacy {

	public function display($cachable = false, $urlparams = false) {
		
		//print_r('display do controller pai<br/>');
		
		$document		= JFactory::getDocument();
		
		$vName	 = JRequest::getCmd('view', 'login');
		$vFormat = $document->getType();
		$lName	 = JRequest::getCmd('layout', 'default');

		if ($view = $this->getView($vName, $vFormat)) {
			switch($vName) {
				case 'registration':
					//Se o usuario esta logado redireciona para a pagina do painel de controle
					$user = JFactory::getUser();
					if( $user->get('guest') != 1) {
						//Caso o usuario esteja logado redireciona para o painel de controle dele
						$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));
						return;
					}
					
					$model = $this->getModel('Registration');
					break;
				
				case 'popstilcustomizacao' :
					$model = $this->getModel('customizacao');
					break;
				
				case 'popstilcarrinho' :
					$model = $this->getModel('carrinho');
					break;
					
				case 'paginainexistente' :
					$model = $this->getModel('paginainexistente');
					break;
				case 'faqpergunta' :
					$model = $this->getModel('faqpergunta');
					break;
				case 'sobre' :
					$model = $this->getModel('sobre');
					break;
				case 'painel' :
					//Se o usuario não esta logado redireciona ele para a pagina de login
					$user = JFactory::getUser();
					if ($user->get('guest') == 1)
					{
						// Redirect to login page.
						$this->setRedirect(JRoute::_('index.php?option=com_users&view=login', false));
						return;
					}					
					$model = $this->getModel('painel');
					break;
				
				
			}
		}
		
		// Push the model into the view (as default).
		$view->setModel($model, true);
		$view->setLayout($lName);

		// Push document object into the view.
		$view->assignRef('document', $document);

		$view->display();
	}
	
	public function enviar_email() {
		//Pega os parametros passados da solicitação
		$paramentro = JRequest::getVar("param");
		$params = array();
		//Como eles estao serializados, joga eles dentro de uma array
		parse_str($paramentro, $params);
//		$nomeremetente	= $_POST['sugestao_nome'];
//		$email			= $_POST['sugestao_email'];
//		$mensagem		= $_POST['sugestao_mensagem'];
//		
		$mailer = JFactory::getMailer();
		        
        $config = JFactory::getConfig();
        $sender = array( 
            $config->get( 'config.mailfrom' ),
            $config->get( 'config.fromname' ) );
         
        $mailer->setSender('sac@popstil.com');
               
        $mailer->addRecipient('sac@popstil.com');
      
        $titulo = 'Email de Sugestão!';
        
        $horaenviado = date("d/m/y H:i");
        
        $mensagemHTML = '<p>Email de sugestção<p>
        <p>Nome: '.$params['sugestao_nome'].'</b>
        <p>Email: '.$params['sugestao_email'].'</b>
        <p>Mensagem: '.$params['sugestao_mensagem'].'</b>
        <hr>';

      	
        $mailer->setSubject($titulo);
//        Quando o email tem tags html é necessario dizer ao mail que é um HTML
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($mensagemHTML);
        
        $send = $mailer->Send();
        if ( $send === true ) {
            echo json_encode("certo");
        } else {
            echo json_encode("errado");
        }
	}
	
	public function uploadImageCliente() {
		//$filename = $_FILES["file_upload"]["name"];
		$tmp_name = $_FILES['file_upload']['tmp_name'];
		$size = filesize($_FILES['file_upload']['tmp_name']);
		$extensao = pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION);
		$data = (date("d_m_Y_H_i_s"));
		$fileName = 'popstil_'.$data.'.'.$extensao;
		$uploadPath = JPATH_SITE.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'com_popstil'.DIRECTORY_SEPARATOR.'popstilcustomizacao'.DIRECTORY_SEPARATOR.'quadrosClientes'.DIRECTORY_SEPARATOR.$fileName;
		$imagem = JURI::base().'media/com_popstil/popstilcustomizacao/quadrosClientes/'.$fileName;
		
		if(!JFile::upload($tmp_name, $uploadPath)) 
		{
			echo json_encode('Erro ao mover a foto');
			return;
		}else {
			echo (urldecode($imagem));
			return;
		}
		
		//echo json_encode($imagem);
	}

}

?>
