<?php

defined('_JEXEC') or die;

?>
<?php echo $this->loadTemplate('page_heading'); ?>

<div class="container pedido_pagamento_wrapper">
	<div class="row-fluid pedido_pagamento_titulo">
		<div class="span8">
			<hr class="linha_divisao" />
			<h2>Detalhe do pedido nº <?php echo $this->pedido->idpedido ?></h2>
			<hr class="linha_divisao" />
		</div>
	</div>
	
	<?php foreach ($this->pedido->itens as $key => $item) { ?>
		<div class="row-fluid pedido_pagamento col-wrap">
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
									<?php }else if($item->status_pedido == 'PRO' || $item->status_pedido == 'PCP') { ?>
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
	<div class="voltar">
		<a class="bt_detalhepedido" href="<?php echo JRoute::_('index.php?option=com_popstil&view=painel'); ?>">Voltar</a>
	</div>	
</div>