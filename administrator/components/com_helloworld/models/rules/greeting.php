<?php 

defined('_JEXEC') or die('Acesso restrito');

jimport('joomla.form.formrule');

class JFormRuleGreeting extends JFormRule {
	
	protected $regex = '^[^0-9]+$';
	
}