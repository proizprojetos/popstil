<?php

defined('_JEXEC') or die;


class PopstilBlogModelMateria extends JModelItem
{
	
	protected $_context = 'com_popstilblog.article';
	
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 */
	protected function populateState()
	{			
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = $app->input->getInt('id');
		$this->setState('materia.id', $pk);

		//$offset = $app->input->getUInt('limitstart');
		//$this->setState('list.offset', $offset);

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		// TODO: Tune these values based on other permissions.
//		$user = JFactory::getUser();
//		if ((!$user->authorise('core.edit.state', 'com_content')) && (!$user->authorise('core.edit', 'com_content')))
//		{
//			$this->setState('filter.published', 1);
//			$this->setState('filter.archived', 2);
//		}
//
//		$this->setState('filter.language', JLanguageMultilang::isEnabled());
	}
	
	/**
	*	Método para retornar o artigo solicitado
	*
	*/
	public function getItem($pk = null) {
		
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('materia.id');
		
		if($this->_item === null) {
			$this->_item = array();
		}
		
		if(!isset($this->item[$pk])) {
			
			try{
				$db = $this->getDbo();
				$query = $db->getQuery(true)
					->select(
						'ma.*'
					);
				$query->from('#__blog_materia AS ma');
				
				// Join na tabela USER, para pegar o autor.
				$query->select('u.name AS author')
					->join('LEFT', '#__users AS u on u.id = ma.id_autor');
					
				$date = JFactory::getDate();
				$nullDate = $db->quote($db->getNullDate());
				$nowDate = $db->quote($date->toSql());

				$query->where('(ma.inicio_publicacao = ' . $nullDate . ' OR ma.inicio_publicacao <= ' . $nowDate . ')')
					->where('(ma.fim_publicacao = ' . $nullDate . ' OR ma.fim_publicacao >= ' . $nowDate . ')')
					->where('ma.id = ' . (int) $pk);
					
				$db->setQuery($query);
				
				$data = $db->loadObject();

				$query = $db->getQuery(true)
					->select(
						'tag.*'
					);
				$query->from('#__blog_tag AS tag')
					->join('inner', '#__blog_materia_tag as t on t.id_tag = tag.id and t.id_materia = '.$data->id);
					
				$db->setQuery($query);
				
				$data->tags = $db->loadObjectList();
				
				if (empty($data))
				{
					return JError::raiseError(404, JText::_('COM_CONTENT_ERROR_MATERIA_NOT_FOUND'));
				}
				
				$this->_item[$pk] = $data;
				
				
			
			}catch (Exception $e)
			{
				if ($e->getCode() == 404)
				{
					// Need to go thru the error handler to allow Redirect to work.
					JError::raiseError(404, $e->getMessage());
				}
				else
				{
					$this->setError($e);
					$this->_item[$pk] = false;
				}
			}	
		}	
		return $this->_item[$pk];
	}
	

	
	public function getInstagramImages() {
		/*
			Your token is: 525590693.ab103e5.995a8849950343c0b02b00a5ad39c33f 
			Your user ID is: 525590693
		*/	
		$userid = "525590693";
		$accessToken = "525590693.ab103e5.995a8849950343c0b02b00a5ad39c33f";
		$url = "https://api.instagram.com/v1/users/{$userid}/media/recent/?access_token={$accessToken}";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		//curl_close($ch); 
		$result = json_decode($result);
		
		if(curl_errno($ch)) {
			echo 'error:' . curl_error($ch);	
		}
		
		//print_r($result);
		/*
		$data['nCdEmpresa'] = '';
		$data['sDsSenha'] = '';
		$data['sCepOrigem'] = '43820080';
		$data['sCepDestino'] = '43810040';
		$data['nVlPeso'] = '1';
		$data['nCdFormato'] = '1';
		$data['nVlComprimento'] = '16';
		$data['nVlAltura'] = '5';
		$data['nVlLargura'] = '15';
		$data['nVlDiametro'] = '0';
		$data['sCdMaoPropria'] = 's';
		$data['nVlValorDeclarado'] = '200';
		$data['sCdAvisoRecebimento'] = 'n';
		$data['StrRetorno'] = 'xml';
		$data['nCdServico'] = '40010';
		//$data['nCdServico'] = '40010,40045,40215,40290,41106';
		$data = http_build_query($data);
		 
		$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
		$curl = curl_init($url . '?' . $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($curl);
		$result = simplexml_load_string($result);*/
		
	//	 $result = json_decode($result);
    //  	foreach ($result->data as $post) {
    //    echo 'testea';
    //  }	
 
        return $result;
		
	}
	
//	public function getCategorias() {
//			
//		$db = JFactory::getDBO();
//		$query = $db->getQuery(true);
//		
//		$date = JFactory::getDate();
//		
//		$nowDate = $db->quote($date->toSql());
//		
//		$query->select('*')
//			->from('#__blog_categoria as categoria')
//			->where('(categoria.inicio_publicacao <= '.$nowDate.')') 
//			->where('(categoria.fim_publicacao >= '.$nowDate.')')
//			->where('categoria.status = 1');
//		
//		$db->setQuery($query);
//		
//		$categorias = $db->loadObjectList();
//		
//		return $categorias;
//
//	}
	
}
