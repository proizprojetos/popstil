<?php

defined('_JEXEC') or die('Restricted access');

//require_once ( 'components/com_popstilcustomizacao/views/popstilcustomizacao/teste.php' );

jimport('joomla.application.component.controller');
$controller = JControllerLegacy::getInstance('popstilcustomizacao');
$controller->execute(JRequest::getCmd('task', 'display'));
$controller->redirect();
/*$controller = JController::getInstance('popstilcustomizacao');

$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
*/



//adicionar javascript e css
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_popstilcustomizacao/assets/css/estilos-carrinho.css');
$document->addStyleSheet('components/com_popstilcustomizacao/assets/css/estilos-customizacao.css');
$document->addScript('components/com_popstilcustomizacao/assets/js/jquery.min.1.7.1.js');
$document->addScript('components/com_popstilcustomizacao/assets/js/jquery-ui1.10.2.js');
$document->addScript('components/com_popstilcustomizacao/assets/js/droparea.js');
$document->addScript('components/com_popstilcustomizacao/assets/js/bootstrap.min.js');
$document->addScript('components/com_popstilcustomizacao/assets/js/customizacao.js');
$document->addScript('components/com_popstilcustomizacao/assets/js/jquery.maskedinput.min.js');
$document->addScript('components/com_popstilcustomizacao/assets/js/cadastrousuario.js');
$controller->redirect();

?>