<?php

defined('_JEXEC') or die('Acesso restrito');

//Como a constante DS foi removida na versao 3, 
//é necessario definir ela para nao dar problema no resto do componente.
if(!defined('DS')) {
	define('DS',DIRECTORY_SEPARATOR);
}

JLoader::register('PopstilBlogHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'popstilblog.php');

jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('PopstilBlog');

$controller->execute(JRequest::getCmd('task'));

$controller->redirect();