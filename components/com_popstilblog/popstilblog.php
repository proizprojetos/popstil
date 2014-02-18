<?php
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')) {
	define('DS',DIRECTORY_SEPARATOR);
}

jimport('joomla.application.component.controller');

JLoader::register('UtilitariosHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'utilitarios.php');

$controller = JControllerLegacy::getInstance('popstilblog');

$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));




//adicionar javascript e css
$document = JFactory::getDocument();
//$document->addScript(JURI::root() . '/components/com_popstilblog/assets/js/jquery.min.1.7.1.js');
/*$document->addStyleSheet('components/com_popstilcustomizacao/assets/css/estilos-customizacao.css');

$document->addScript('components/com_popstilcustomizacao/assets/js/jquery-ui1.10.2.js');
$document->addScript('components/com_popstilcustomizacao/assets/js/droparea.js');
$document->addScript('components/com_popstilcustomizacao/assets/js/bootstrap.min.js');
$document->addScript('components/com_popstilcustomizacao/assets/js/customizacao.js');*/
$controller->redirect();

?>