<?php

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.database.table');

class HelloWorldTablePessoa extends JTable {

	//var $id = null;
	//var $nome = null;
	//var $endereco = null;
	
	function __construct(&$db) {
		parent::__construct('#__pessoas','id',$db);
		
	}
	
//	
//	* Sebreescreve a funcão bind
//	* @param  array			array
//	* @return null|string	null se a operação foi um sucesso, senão retorna um erro
//	* @see JTable:bind
//	
//	public function bind($array, $ignore = '') {
//		
//		if(isset($array['params']) && is_array($array['params'])) {
//			Converte o campo params para uma string
//			$parameter = new JRegistry;
//			$paremeter->loadArray($array['params']);
//			$array['params'] = (string) $parameter;
//		}		
//		return parent::bind($array, $ignore);
//	}
//	
//	
//	* Sobreescreve a função load
//	* 
//	* @param		int $pk chave primaria
//	* @param		boolean $rest restar dados
//	* @return		boolean
//	* @see JTable:load
//	
//	public function load($pk = null, $reset = true) {
//	
//		if(parent::load($pk, $reset)) {
//			converte os campos de paremetro para um registro
//			$params = new JRegistry;
//			$params->loadString($this->params, 'JSON');
//			
//			$this->params = $params;
//			return true;
//		}else {
//			return false;
//		}
//		
//	}


}