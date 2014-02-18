<?php

defined('_JEXEC') or die;

?>

<div class="container pedido_pagamento_wrapper">
	
	<form name="bcash" action="https://www.bcash.com.br/checkout/pay/" method="post">
	<!--<form name="bcash" action="<?php echo JRoute::_('index.php?option=com_popstil&task=painel.realizarpagamentopedido&idpedido='.$this->pedido->idpedido); ?>" method="post">-->
	<!--<form name="bcash" action="<?php echo JRoute::_('index.php?option=com_popstil&task=painel.confirmapagamento'); ?>" method="post">-->
		<input name="email_loja" type="hidden" value="vendas@popstil.com"> 
		<input name="id_pedido" type="hidden" value="<?php echo $this->pedido->idpedido ?>">
		<input name="tipo_integracao" type="hidden" value="PAD">
		<input name="frete" type="hidden" value="<?php echo $this->pedido->valor_frete ?>">
		<input name="desconto" type="hidden" value="<?php echo $this->pedido->valor_desconto ?>">
		<input name="url_retorno" type="hidden" value="<?php echo JRoute::_('index.php/meupopstil?view=painel&layout=pagamentorealizado'); ?>">
		<input name="redirect" type="hidden" value="true">
		
		<!-- dados do cliente -->
		<input name="email" type="hidden" value="<?php echo $this->pedido->email ?>">
		<input name="nome" type="hidden" value="<?php echo $this->pedido->nomecompleto ?>">
		<input name="cpf" type="hidden" value="<?php echo $this->pedido->cpf ?>">
		<input name="telefone" type="hidden" value="<?php echo $this->pedido->ddd1.''.$this->pedido->telefone1 ?>"> 
		
		
		<!-- Dados de Entrega -->
		<input name="cep" type="hidden" value="<?php echo $this->pedido->cep ?>">
		<input name="endereco" type="hidden" value="<?php echo $this->pedido->endereco.','.$this->pedido->numero ?>">
		<input name="complemento" type="hidden" value="<?php echo $this->pedido->complemento ?>">
		<input name="bairro" type="hidden" value="<?php echo $this->pedido->bairro ?>">
		<input name="cidade" type="hidden" value="<?php echo $this->pedido->cidade ?>">
		<input name="estado" type="hidden" value="<?php echo $this->pedido->estado ?>">
		
		
		<div class="row-fluid pedido_pagamento_titulo">
			<div class="span8">
				<hr class="linha_divisao" />
				<h2>Detalhe do pedido nº <?php echo $this->pedido->idpedido ?></h2>
				<h4>Valor dos itens: <b>R$<?php echo ($this->pedido->valortotal )?></b></h4>
				<h4>Valor do frente: <b>R$<?php echo ($this->pedido->valor_frete )?></b></h4>
				<h4>Valor do desconto: <b>R$<?php echo ($this->pedido->valor_desconto )?></b></h4>
				<hr class="linha_divisao" />
			</div>
		</div>
		
		<?php foreach ($this->pedido->itens as $key => $item) { ?>
			<div class="row-fluid pedido_pagamento col-wrap">
				<input name="produto_codigo_<?php echo ($key+1) ?>" type="hidden" value="<?php echo $item->produto_codigo ?>">
				<input name="produto_descricao_<?php echo ($key+1) ?>" type="hidden" 
					value="<?php 
						$desc = '';
						foreach ($item->quadros as $key => $value) {
							$desc .= 'Popstil '.$value->tamanho;
							if(end($item->quadros) !== $value) {
								$desc .= ', ';
							}
					}
						echo $desc;
					?>">
				<input name="produto_qtde_<?php echo ($key+1) ?>" type="hidden" value="1">
				
				<input name="produto_valor_<?php echo ($key+1) ?>" type="hidden" value="<?php echo $item->produto_preco ?>" >
				<div class="span3 pedido_pagamento_detalhes_wrapper col">
					<div class="pedido_pagamento_detalhes">
						<h2>Popstil <?php echo ($key+1) ?></h2>
						<h4>Nº de quadros: <?php echo sizeof($item->quadros) ?><b></b></h4>
						<h4>Valor total do item: <b>R$<?php echo ($item->produto_preco )?></b></h4>
						<h4>Número de pessoas: <b><?php echo $item->nrpessoas ?></b></h4>
						<hr class="linha_divisao" />
					</div>
				</div>
				<div class="span5 pedido_pagamento_quadros">
					<div class="row">
						<?php foreach ($item->quadros as $cjave => $quadro) { ?>
							<div class="span6">
								<div class="pedido_pagamento_quadro_detalhe">
									<div class="pedido_andamento_imagem">
										<?php  if($item->status_pedido === 'ANA') { ?>
											<img src="<?php echo JURI::base().''?>components/com_popstil/assets/img/status/analise.png" alt="" height="130px" width="175px" />
										<?php }else if($item->status_pedido == 'AGU') { ?>
											<img src="<?php echo JURI::base().''?>components/com_popstil/assets/img/status/aprovada.png" alt="" height="130px" width="175px" />
										<?php }else if($item->status_pedido == 'PRO') { ?>
											<img src="<?php echo JURI::base().''?>components/com_popstil/assets/img/status/producao.jpg" alt="" height="130px" width="175px" />
										<?php }else if($item->status_pedido == 'APR') { ?>
											<img src="<?php echo $quadro->url_popstil ?>" alt="" height="130px" width="175px" />
										<?php }else if($item->status_pedido == 'CON') { ?>
											<img src="<?php echo JURI::base().''?>components/com_popstil/assets/img/status/montagem.png" alt="" height="130px" width="175px" />
										<?php } ?>
										
									</div>	
									<h2><b>Cor da moldura: </b> <?php echo $quadro->moldura ?></h2>
									<h2><b>Tamanho: </b><?php echo $quadro->tamanho?> </h2>
								</div>
							</div>
						<?php } ?>
					</div>			
				</div>
			</div>
			
		<?php } ?>
		
		<div class="row">
			<div class="span10">
				&nbsp;
			</div>
			
			<div class="span2">
				<div class="total" id="total_wrapper">
					<div class="total_preco">
						<h3>Valor total R$</h3>
						<h2 id="valorTotal">R$<?php echo (($this->pedido->valortotal+$this->pedido->valor_frete)-$this->pedido->valor_desconto )?></h2>
						<h4> Parcele em até 12x no cartão sem juros</h4>
						<div class="wrapper_finalizar">
							<input type="submit" class="bt_finalizar_pedido" name="popstilregister" value="Finalizar Pedido" />
						</div>
					</div>
											
				</div>
				
			</div>
		</div>
	</form>
</div>