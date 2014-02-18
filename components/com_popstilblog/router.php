<?php 

defined('_JEXEC') or die;

function PopstilblogBuildRoute(&$query) {
	//echo '<br/><br/><br/><br/><br/><br/><br/>';
	//print_r($query);
	
	$segments = array();

	if(isset($query['view'])) {
		$segments[] = $query['view'];
		unset($query['view']);	
	}
	
	if(isset($query['id'])) {
		$segments[] = $query['id'];
		unset($query['id']);
	}
	
	if(isset($query['layout']))
	{
       $segments[] = $query['layout'];
       unset( $query['layout'] );
	}; 
	
	if(isset($query['task']))
	{
	   $segments[] = $query['task'];
	   unset( $query['task'] );
	};
	if(isset($query['titulo']))
	{
	   $titulo = str_replace(' ', '-', $query['titulo']);
	   $titulo = str_replace(",","", $titulo);
	   $segments[] = $titulo;
	   unset( $query['titulo'] );
	};
	//echo '<br/>';
	//print_r($segments);
	
	return $segments;
}

function PopstilblogParseRoute($segments) {
	//echo '<br/><br/><br/><br/><br/><br/><br/>ae garoto';
	//print_r($segments);
	$vars = array();
	
	switch($segments[0]) {
		case 'indice':
               $vars['view'] = 'indice';
               if(isset($segments[1])) {
//               	if($segments[1] == 'mes') {
//               		
//               		echo 'entrou';
//               	}
               	$vars['layout'] = $segments[1];
               }
               break;
       case 'materia':
               $vars['view'] = 'materia';
               //$id = explode( ':', $segments[1] );
               $vars['id'] = $segments[1];
               break;
       case 'mes':
               $vars['view'] = 'indice';
               //$id = explode( ':', $segments[1] );
               //$vars['mes'] = $segments[1];
               $vars['layout'] = $segments[1];
               break;
	}
	//$vars['view'] = 'teste';
	
	return $vars;

}