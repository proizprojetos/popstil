<? 



if ($_REQUEST) {
// Pagina que ira atualizar o pedido do popstil, para pago ou nao

	$my_path = dirname(__FILE__);
	
	echo 'comecou';
	
	define( '_JEXEC', 1 );
	define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../..' ));
	define( 'DS', DIRECTORY_SEPARATOR );
	
	//Importa as classes necessarias acessas as funções do joomla.
	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	JTable::addIncludePath(JPATH_BASE.DS.'components'.DS.'com_popstil'.DS.'tables');
	
	
	// Obtenha seu TOKEN entrando no menu Ferramentas do Bcash
	$token = '271191D3C28E30178428DA4B9014A870';### Coloque aqui o seu TOKEN ###;
	
	
	/* Montando as variáveis de retorno */
	
	$id_transacao = $_POST['id_transacao'];
	//$data_transacao = $_POST['data_transacao'];
	$data_credito = $_POST['data_credito'];
	$valor_original = $_POST['valor_original'];
	$valor_loja = $_POST['valor_loja'];
	//$valor_total = $_POST['valor_total'];
	//$desconto = $_POST['desconto'];
	//$acrescimo = $_POST['acrescimo'];
	//$tipo_pagamento = $_POST['tipo_pagamento'];
	//$parcelas = $_POST['parcelas'];
	//$cliente_nome = $_POST['cliente_nome'];
	//$cliente_email = $_POST['cliente_email'];
	//$cliente_rg = $_POST['cliente_rg'];
	//$cliente_data_emissao_rg = $_POST['cliente_data_emissao_rg'];
	//$cliente_orgao_emissor_rg = $_POST['cliente_orgao_emissor_rg'];
	//$cliente_estado_emissor_rg = $_POST['cliente_estado_emissor_rg'];
	//$cliente_cpf = $_POST['cliente_cpf'];
	//$cliente_sexo = $_POST['cliente_sexo'];
	//$cliente_data_nascimento = $_POST['cliente_data_nascimento'];
//	$cliente_endereco = $_POST['cliente_endereco'];
//	$cliente_complemento = $_POST['cliente_complemento'];
	$status = $_POST['status'];
	$cod_status = $_POST['cod_status'];
//	$cliente_bairro = $_POST['cliente_bairro'];
//	$cliente_cidade = $_POST['cliente_cidade'];
//	$cliente_estado = $_POST['cliente_estado'];
//	$cliente_cep = $_POST['cliente_cep'];
//	$frete = $_POST['frete'];
	//$tipo_frete = $_POST['tipo_frete'];
	//$informacoes_loja = $_POST['informacoes_loja'];
	$id_pedido = $_POST['id_pedido'];
	//$free = $_POST['free'];
	
	/* Essa variável indica a quantidade de produtos retornados */
//	$qtde_produtos = $_POST['qtde_produtos'];
	
	/* Verificando ID da transação */
	/* Verificando status da transação */
	/* Verificando valor original */
	/* Verificando valor da loja */
	
	$post = "transacao=$id_transacao" .
	"&status=$status" .
	"&cod_status=$cod_status" .
	"&valor_original=$valor_original" .
	"&valor_loja=$valor_loja" .
	"&token=$token";
	$enderecoPost = "https://www.bcash.com.br/checkout/verify/";
	
	//print_r($post);
	$mailer = JFactory::getMailer();
				
	$config = JFactory::getConfig();
	
	$mailer->setSender('vendas@popstil.com');

	$mailer->addRecipient('luyzgarcia@gmail.com');
	
	
	$body   = "vai chamar o bcash passando: <br/>".$_POST['id_transacao'];
	
	$mailer->isHTML(true);
	//$mailer->Encoding = 'base64';
	/*$mailer->CharSet = "UTF8";*/
	$mailer->setSubject('Confirmação de pagamento');
	$mailer->setBody($body);
	$mailer->AddCustomHeader('Content-type: text/html; charset=utf-8');
	
	$send = $mailer->Send();
	if ( $send !== true ) {
	    $this->setError(JText::sprintf('Erro ao enviar email', $temp->getError()));
	    return false;
	} else {
	    echo 'Mail sent';
	}
	
	ob_start();
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $enderecoPost);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
	curl_exec ($ch);
	$resposta = ob_get_contents();
	ob_end_clean();
	
	echo '<br/><br />';
	print_r($resposta);
	$mailer = JFactory::getMailer();
				
	$config = JFactory::getConfig();
	
	$mailer->setSender('vendas@popstil.com');

	$mailer->addRecipient('luyzgarcia@gmail.com');
	
	
	$body   = "entrou no confirma pagamento";
	
	$mailer->isHTML(true);
	//$mailer->Encoding = 'base64';
	/*$mailer->CharSet = "UTF8";*/
	$mailer->setSubject('Confirmação de pagamento');
	$mailer->setBody($resposta);
	$mailer->AddCustomHeader('Content-type: text/html; charset=utf-8');
	
	$send = $mailer->Send();
	if ( $send !== true ) {
	    $this->setError(JText::sprintf('Erro ao enviar email', $temp->getError()));
	    return false;
	} else {
	    echo 'Mail sent';
	}
	
	if(trim($resposta)=="VERIFICADO"){
		//echo '<br/>Entrou no verificado:'.$cod_status;
		//Se o status estiver 1 a transação foi conlcuida com sucesso
		if($cod_status == '1') {
			
			$tablePedido 	= JTable::getInstance('pedido', 'PopstilTable');
			
			$dados = array();
			$dados['idpedido'] = $id_pedido;
			$dados['status_pedido'] = 'PCP';
			
			if (!$tablePedido->bind($dados)) {
				$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_PEDIDO_BIND_FAILED', $tablePedido->getError()));
				return false;
			}
			
			if (!$tablePedido->store()) {
				$this->setError(JText::sprintf('COM_POPSTIL_ADMINISTRATOR_PEDIDO_STORE_FAILED', $tablePedido->getError()));
				return false;
			}
			
			$mensagem = 'Confirmação do pagamento pelo BCash.';
			
			$this->enviremail($id_pedido, $mensagem);
			
			//Busca todos os itens do pedido e muda o status deles para PCP - Pagamento Confirmado/ Em Produção
			$db = JFactory::getDBO();
			
			$query = $db->getQuery(true);
			
			//Seleciona os campos
			$query->select('item.*');
			$query->from('#__popstil_item_pedido item');
			$query->where('item.popstil_pedido_idpedido = '.$id_pedido);
			$db->setQuery((String) $query);
			$itenspedido = $db->loadObjectList();
			
			foreach ($itenspedido as $key => $item) {
				$tableItemPedido = JTable::getInstance('itempedido', 'PopstilTable');
				
				$dadositempedido = array();
				$dadositempedido['popstil_item_pedido_id'] = $item->popstil_item_pedido_id;
				$dadositempedido['status_pedido'] = 'PCP';
				
				
				if(!$tableItemPedido->bind($dadositempedido)) {
					$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_ITEMPEDIDO_BIND_FAILED', $tableItem->getError()));
					return false;
				}
				
				if(!$tableItemPedido->store()) {
					$this->setError(JText::sprintf('COM_POPSTIL_APROVARARTE_ITEMPEDIDO_STORE_FAILED', $tableItem->getError()));
					return false;
				}			
			}
		}
	// Loop para retornar dados dos produtos
//		for ($x=1; $x <= $qtde_produtos; $x++) {
//		
//			$produto_codigo = $_POST['produto_codigo_'.$x];
//			$produto_descricao = $_POST['produto_descricao_'.$x];
//			$produto_qtde = $_POST['produto_qtde_'.$x];
//			$produto_valor = $_POST['produto_valor_'.$x];
//			
//			/*
//			Após obter as variáveis dos produtos, grava no banco de dados.
//			Se produto já existe, atualiza os dados, senão cria novo pedido.
//			*/ 
//		}
	}else {
		
		
		$mensagem = 'Não foi possivel confirmar o pagamento BCash.';
		
		$this->enviremail($id_pedido, $mensagem);
		
	}
}

	function enviaremail($numeropedido, $mensagem) {
	
			$mailer = JFactory::getMailer();
			
			$config = JFactory::getConfig();
			
			$mailer->setSender('vendas@popstil.com');
	
			$mailer->addRecipient('luyzgarcia@gmail.com');
			
			
			$body   = "<body style='background: #f6f6f6; text-align:center; font-family: Tahoma'>
				<div class='corpo_wrapper' style='background: #fff; width:750px; display: inline-block; border: 1px solid #c6c8ca; -webkit-box-shadow: 2px 2px 3px 0px #bcbec0;
				-moz-box-shadow: 2px 2px 3px 0px #bcbec0;box-shadow: 2px 2px 3px 0px #bcbec0;'>
					<div class='corpo' style='margin: 0px 70px 50px 70px;text-align: left;'>
						<div class='header'>
							<img src='http://www.popstil.com/images/logo_email.png' alt='Bem vindo' style='margin: 0px 0px 0px -70px;width: 750px;' />
						</div>
						
						<div class='titulo'>
							<h1 style='font-family: Tahoma;font-size: 30px;	color: #58595b;	font-weight: normal;text-align: center;	line-height: 60px;'>
								Pagamento do pedido numero: ".$numeropedido.", !</h1>
							<h4>".$mensagem."</h4>
							<p style='margin: 0 auto;font-size: 15px;'>
								<a href='http://www.popstil.com/administrator/index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido=".$numeropedido."' style='text-decoration: none;color: #0093d0;'>Acessar pedido</a>
							</p>
						</div>
						
						<div class='conteudo' style='margin-top: 30px;' >
							<br/>
							
							<h4>".$texto."</h4>
							
						</div>
					</div>
				</div>";
			
			$mailer->isHTML(true);
			//$mailer->Encoding = 'base64';
			/*$mailer->CharSet = "UTF8";*/
			$mailer->setSubject('Alteração do pedido');
			$mailer->setBody($body);
			$mailer->AddCustomHeader('Content-type: text/html; charset=utf-8');
			
			$send = $mailer->Send();
			if ( $send !== true ) {
			    $this->setError(JText::sprintf('Erro ao enviar email', $temp->getError()));
			    return false;
			} else {
			    echo 'Mail sent';
			}	
		}

?>