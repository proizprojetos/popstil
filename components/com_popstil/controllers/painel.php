<?php

defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT.'/controller.php';

class PopstilControllerPainel extends PopstilController {
	
	public function aprovararte() {
		
		$idpedido 		= JRequest::getVar('idpedido');
		$item 		= JRequest::getVar('item');
		
		$model = $this->getModel('painel');
		
		//Envia os dados para o model do carrinho para gravar no bando de dados
		$return = $model->aprovararte($idpedido,$item);
				
		if(!$return) {
			$this->setMessage($model->getError(), 'warning');
			//$app->setUserState('com_popstil.registration.erro', null);
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));
			return false;
		}else {
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));
		}
		
	}
	
	public function alteracaoarte() {
		
		$idarte 		= JRequest::getVar('idarte');
		$item 		= JRequest::getVar('item');
		$idpedido 		= JRequest::getVar('idpedido');
		
		$textoalteracao = JRequest::getVar('textoalteracao');
		
		$model = $this->getModel('painel');
		
		//Envia os dados para o model do carrinho para gravar no bando de dados
		$return = $model->alterararte($idarte,$item,$textoalteracao,$idpedido);
		
		if(!$return) {
			$this->setMessage($model->getError(), 'warning');
			//$app->setUserState('com_popstil.registration.erro', null);
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));
			return false;
		}else {
			$this->setMessage('Seu pedido de alteração será avaliado pelos nossos designers!', 'message');
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));
		}
		
	}
	
	public function alteracaofoto() {
		$item 			= JRequest::getVar('item');
		$idpedido 		= JRequest::getVar('idpedido');
		
		$imagem 		= JRequest::getVar('imagem');
		
		$model = $this->getModel('painel');
		
		//Envia os dados para o model do carrinho para gravar no bando de dados
		$return = $model->alterarfoto($item,$idpedido,$imagem);
		
		if(!$return) {
			$this->setMessage($model->getError(), 'warning');
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));
			return false;
		}else {
			$this->setMessage('Seu pedido de alteração será avaliado pelos nossos designers!', 'message');
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));
		}
		
		//echo $imagem;
	}
	
	public function realizarpagamentopedido() {
		
		$idpedido 		= JRequest::getVar('idpedido');
		
		$user = JFactory::getUser();
		
		if(!$user->get('id')) {
			$this->setRedirect(JRoute::_('index.php?meupopstil', false));
		}
		
		$model = $this->getModel('painel');
		
		$this->pedido = $model->getpedidopagamento();
		print_r($this->pedido);
		
		$campos = array(
			'email_loja'=>urldecode('vendas@popstil.com'),
			'id_pedido'=>urldecode($this->pedido->idpedido),
			'tipo_integracao'=>urldecode('PAD'),
			'redirect'=>urldecode(true),
			'frete'=>urldecode($this->pedido->valor_frete),
			'desconto'=>urldecode($this->pedido->valor_desconto),
			'email'=>urldecode($this->pedido->email),
			'nome'=>urldecode($this->pedido->nomecompleto),
			'cpf'=>urldecode($this->pedido->cpf),
			'telefone'=>urldecode($this->pedido->ddd1.''.$this->pedido->telefone1),
			'cep'=>urldecode($this->pedido->cep),
			'endereco'=>urldecode($this->pedido->endereco),
			'complemento'=>urldecode($this->pedido->complemento),
			'bairro'=>urldecode($this->pedido->bairro),
			'cidade'=>urldecode($this->pedido->cidade),
			'estado'=>urldecode($this->pedido->estado),
			'url_aviso'=>urldecode(JURI::base().'index.php/meupopstil?view=painel&layout=pagamentorealizado')
		);
		
		foreach ($this->pedido->itens as $key => $item) {
			$campos['produto_codigo_'.($key+1)] = $item->produto_codigo;
			$desc = '';
				foreach ($item->quadros as $key => $value) {
					$desc .= 'Popstil '.$value->tamanho;
					if(end($item->quadros) !== $value) {
						$desc .= ', ';
					}
				}
				echo $desc;
			$campos['produto_descricao_'.($key+1)] = $desc;
			$campos['produto_qtde_'.($key+1)] = 1;
			$campos['produto_valor_'.($key+1)] = $item->produto_preco;
		}
		
		$string_campos ='';
		//temos que colocar os parâmetros do post no estilo de uma query string
/*		foreach($campos as $name => $valor) {
		    $string_campos .= $name . '=' . $valor . '&';
		}
*/
		$url = 'https://www.bcash.com.br/checkout/pay/';
		
//		$string_campos = rtrim($string_campos,'&');
		$string_campos = http_build_query($campos);
		
		ob_start();
		$ch = curl_init();
		
		//configurando as opções da conexão curl
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//este parâmetro diz que queremos resgatar o retorno da requisição
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$string_campos);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
		//manda a requisição post
		curl_exec($ch);
		curl_close($ch);
		
		header("location: https://www.bcash.com.br/checkout/pay/",TRUE, 307);
		
	}
	
//	public function confirmapagamento() {
//		$campos = array(
//			'id_transacao'=>urldecode('20683731'),
//			'email_loja'=>urldecode('vendas@popstil.com'),
//			'valor_original'=>urldecode('2.00'),
//			'valor_loja'=>urldecode('1.94'),
//			'status'=>urldecode('Transação Concluída'),
//			'cod_status'=>urldecode('0'),
//			'id_pedido'=>urldecode('12'),
//			/*'id_pedido'=>urldecode($this->pedido->idpedido),
//			'tipo_integracao'=>urldecode('PAD'),
//			'redirect'=>urldecode(true),
//			'frete'=>urldecode($this->pedido->valor_frete),
//			'email'=>urldecode($this->pedido->email),
//			'nome'=>urldecode($this->pedido->nomecompleto),
//			'cpf'=>urldecode($this->pedido->cpf),
//			'telefone'=>urldecode($this->pedido->ddd1.''.$this->pedido->telefone1),
//			'cep'=>urldecode($this->pedido->cep),
//			'endereco'=>urldecode($this->pedido->endereco),
//			'complemento'=>urldecode($this->pedido->complemento),
//			'bairro'=>urldecode($this->pedido->bairro),
//			'cidade'=>urldecode($this->pedido->cidade),
//			'estado'=>urldecode($this->pedido->estado),*/
//		);
//		
//		$url = 'http://localhost:8888/administrator/components/com_popstil/confirma_pagamento.php';
//				
		//		$string_campos = rtrim($string_campos,'&');
//		$string_campos = http_build_query($campos);
//		
//		ob_start();
//		$ch = curl_init();
//		
		//configurando as opções da conexão curl
//		curl_setopt($ch,CURLOPT_URL,$url);
//		curl_setopt($ch, CURLOPT_HEADER, 0);
		//este parâmetro diz que queremos resgatar o retorno da requisição
//		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
//		curl_setopt($ch,CURLOPT_POST,true);
//		curl_setopt($ch,CURLOPT_POSTFIELDS,$string_campos);
//		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
		//manda a requisição post
//		$resposta = curl_exec($ch);
//		curl_close($ch);
//		
//		echo $resposta;
//		
//	}
	
	public function verdetalhespido() {
	
	}
	
	public function alterarSenha() {
		
		$idusuario 		= JRequest::getVar('idusuario');
		
		$dados = JRequest::getVar('senha', array(), 'post', 'array');
		
		if($dados['senha1'] != $dados['senha2']) {
			$this->setMessage('As nova senha não conferem.', 'warning');
			//$app->setUserState('com_popstil.registration.erro', null);
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel&layout=alterarsenha&idusuario='.$idusuario, false));
			return false;
		}
		
		$dados['idusuario_joomla'] = $idusuario;
		
		$model = $this->getModel('painel');
		
		$retorno = $model->alterarsenha($dados);
		
		if(!$retorno) {
			$this->setMessage($model->getError(), 'warning');
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel&layout=alterarsenha&idusuario=', false));
			return false;
			
		}
		
		$this->setMessage('Senha alterada com sucesso.', 'warning');
		
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));		
	}
	
	public function alterardados() {
	
		$dados = JRequest::getVar('cadastro', array(), 'post', 'array');
		
		$model = $this->getModel('painel');
		
		$retorno = $model->alterardados($dados);
		
		if(!$retorno) {
			$this->setMessage($model->getError(), 'warning');
			
			$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel&layout=alterarsenha&idusuario=', false));
			return false;
			
		}
		
		$this->setMessage('Dados alterados com sucesso.', 'warning');
		
		$this->setRedirect(JRoute::_('index.php?option=com_popstil&view=painel', false));
		
	}

}
