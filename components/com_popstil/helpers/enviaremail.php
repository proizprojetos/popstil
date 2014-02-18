<?php

defined('_JEXEC') or die ('Acesso Restrito');

abstract class EnviaremailHelper {
	
	//Configura a barra de menus lateral
	public static function enviarEmail() {
		
//		$para = 'luyzgarcia@gmail.com';
//		$titulo = 'Email de Teste Popstil!';
//		
//		$headers = "From: sac@popstil.com \r\n";
//		$headers .= "MIME-Version: 1.0\r\n";
//		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//		
//		$message = '<html><body>';
//		$message .= '<h1>Hello, World!</h1>';
//		$message .= '</body></html>';
//		
//		mail($para, $titulo, $message, $headers);
		
//		if (mail($para, $titulo, $message, $headers)) {
//          return true;
//        } else {
//          return false;
//        }
        
        
        $mailer = JFactory::getMailer();
        
        $config = JFactory::getConfig();
//        $sender = array( 
//            $config->get( 'config.mailfrom' ),
//            $config->get( 'config.fromname' ) );
         
        $mailer->setSender('luyzgarcia@gmail.com');
        
        $destinararios = array('luyzgarcia@gmail.com','luiz.garcia@outlook.com','luiz@proiz.com.br');
        
        $mailer->addRecipient($destinararios);
      
        $titulo = 'Email de Teste Popstil!';
      
      	$message = '<html><body>';
      	$message .= '<h1>Hello, World!</h1>';
      	$message .= '</body></html>';
      	
        $mailer->setSubject($titulo);
        //Quando o email tem tags html é necessario dizer ao mail que é um HTML
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($message);
        
        $send = $mailer->Send();
        if ( $send === true ) {
            return true;
        } else {
            return false;
        }
		
	}
	
}