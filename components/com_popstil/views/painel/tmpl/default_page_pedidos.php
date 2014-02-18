<?php

defined('_JEXEC') or die;

?>
<hr class="linha_divisao"/>
<div class="container painel_pedidos">
	
	<div class="row">
		<div class="span12 titulo_pedidos_pendentes">
			<h1>Pedidos em andamento</h1>
		</div>
	</div>
</div>
<hr class="linha_divisao"/>
<?php foreach ($this->pedidosandamento as $chave => $pedido) { ?>
	<div class="container pedido_andamento_wrapper">
		<div class="row-fluid pedido_andamento col-wrap">
			<div class="span4 pedido_andamento_detalhes_wrapper col">
				<div class="pedido_andamento_detalhes">
					<div class="pedido_andamento_desc">
						<h2>Pedido Numero: <?php echo $pedido->idpedido ?></h2>
						<h4>Status do pedido: 
							<b><?php if($pedido->status_pedido === 'ANA') { 
								echo 'Foto em análise';											 
							 }else  if($pedido->status_pedido === 'FRE') { 
							 	echo 'Foto recusada';
							 } else if($pedido->status_pedido == 'AGU') { 
							 	echo 'Foto aprovada / Aguardando pagamento';
							 } else if($pedido->status_pedido == 'PCP') { 
							 	echo 'Pagamento confirmado / Em criação';
							 } else if($pedido->status_pedido == 'PRO') { 
							 	echo 'Em criação';
							 } else if($pedido->status_pedido == 'APR') { 
							 	echo 'Arte pronta / Aguardando aprovação';
							 } else if($pedido->status_pedido == 'CON') { 
							 	echo 'Concluida / Em produção';
							 } else if($pedido->status_pedido == 'REC') { 
							 	echo 'Arte recusada';
							 } else if($pedido->status_pedido == 'ARP') { 
							 	echo 'Arte aprovada';
							 } 
							  ?>
							 </b>
						</h4>
						<h4>Valor do frete: <b>R$<?php echo ($pedido->valor_frete )?></b></h4>
						<h4>Valor total do pedido: <b>R$<?php echo ($pedido->valortotal+$pedido->valor_frete )?></b></h4>
					</div>
					<?php if($pedido->status_pedido == 'AGU') { ?>
					<div class="wrapper_finalizar">
						<form method="post" action="<?php echo JRoute::_('index.php?option=com_popstil&view=painel&layout=realizarpagamento&idpedido='.$pedido->idpedido); ?>">
							<input type="hidden" name="idpedido" value="<?php  echo $pedido->idpedido ?>" />
							<input type="submit" class="bt_finalizar_pedido" name="popstilregister" value="Realizar pagamento">
						</form>
					</div>
					<?php } ?>
					<div class="bt_detalhes">
						<div class="">
							<div class="">				
								<form method="post" action="<?php echo JRoute::_('index.php?option=com_popstil&view=painel&layout=detalhepedido&idpedido='.$pedido->idpedido); ?>">
									<input type="submit" class="bt_detalhepedido" name="popstilregister" value="Detalhe do pedido">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="span8 pedido_andamento_quadros col">
			<div class="row">
				<?php foreach ($pedido->itens as $key => $item) { ?>
					<div class="span6">
						<div class="pedido_andamento_quadro_detalhe">
							<h1>Popstil <?php echo ($key+1) ?></h1>
							<h3>
								<?php if($item->status_pedido === 'ANA') { 
									echo 'Foto em análise';	
								 } else if($item->status_pedido == 'AGU') { 
								 	echo 'Foto aprovada/Aguardando pagamento';
								 } else if($item->status_pedido == 'FRE') { 
								 	echo 'Foto recusada/Aguardando nova foto';
								 } else if($item->status_pedido == 'PCP') { 
								 	echo 'Pagamento confirmado/ Em criação';
								 } else if($item->status_pedido == 'PRO') { 
								 	echo 'Em criação';
								 } else if($item->status_pedido == 'APR') { 
								 	echo 'Arte pronta/Aguardando aprovação';
								 } else if($item->status_pedido == 'CON') { 
								 	echo 'Concluida/Em produção';
								 } else if($item->status_pedido == 'REC') { 
								 	echo 'Arte recusada';
								 } else if($item->status_pedido == 'ARP') { 
								 	echo 'Arte aprovada/Em produçao';
								 } 
								  ?>						
							</h3>
							<div class="pedido_andamento_imagem">
								<?php  if($item->status_pedido === 'ANA' || $item->status_pedido==='FRE') { ?>
									<img src="<?php echo JURI::base().''?>components/com_popstil/assets/img/status/analise.png" alt="" height="130px" width="175px" />
								<?php }else if($item->status_pedido == 'AGU') { ?>
									<img src="<?php echo JURI::base().''?>components/com_popstil/assets/img/status/aprovada.png" alt="" height="130px" width="175px" />
								<?php }else if($item->status_pedido == 'PRO' || $item->status_pedido== 'PCP') { ?>
									<img src="<?php echo JURI::base().''?>components/com_popstil/assets/img/status/producao.jpg" alt="" height="130px" width="175px" />
								<?php }else if($item->status_pedido == 'APR') { ?>
									<a href="<?php echo $item->url_arte; ?>" download="<?php echo $item->url_arte; ?>" target="_blank">
										<img src="<?php echo $item->url_arte ?>" alt="" height="130px" width="175px" />
									</a>
								<?php }else if($item->status_pedido == 'CON'|| $item->status_pedido == 'ARP') { ?>
									<img src="<?php echo JURI::base().''?>components/com_popstil/assets/img/status/montagem.png" alt="" height="130px" width="175px" />
								<?php } ?>
								
							</div>				
							<?php if($item->status_pedido === 'APR') { ?>
								<p>Clique sobre a imagem para ampliar</p>
							<?php } ?>
							<h2><b>Número de pessoas:</b> <?php echo $item->nrpessoas ?></h2>
							<h2><b>Valor individual:</b> R$<?php echo ($item->produto_preco )?></h2>
						</div>
						<div class="pedido_andamento_botoes">
							<?php if($item->status_pedido === 'APR') { ?>
								<form method="post" action="<?php echo JRoute::_('index.php?option=com_popstil&task=painel.aprovararte&idpedido='.$pedido->idpedido.'&item='.$item->popstil_item_pedido_id); ?>" name="aprovar_arte" enctype="multipart/form-data">
									<input type="submit" value="Aprovar desenho" value="" class="bt_aprovar" />
								</form>
								<script src="<?php echo JURI::root() . "/components/com_popstil/assets/js/popupoverlay.js" ?>"></script>						
								
								<div class="div_alteracao">	
									<input type="button" value="Sugerir alteração" value="" class="bt_sugeriralteracao dialog-modal_open" id="bt_alteracao"/>
								</div>
								
								<div id="dialog-modal" title="Sugerir alteração">
									<form method="post" action="<?php echo JRoute::_('index.php?option=com_popstil&task=painel.alteracaoarte&idpedido='.$pedido->idpedido.'&idarte='.$item->popstil_arte_id.'&item='.$item->popstil_item_pedido_id); ?>" name="alterar_arte" >
										<div class="titulo_popup">
											<h3>Meu popstil</h3><h3 class="dialog-modal_close"><a href="#">Fechar</a></h3>
										</div>
										<div class="image_popup_wrapper">
											<div class="image_popup">
												<img src="<?php echo $item->url_arte ?>" alt="" height="500px" width="400px" />
											</div>
										</div>
										<textarea name="textoalteracao" value=""  placeholder="O que você gostaria que fosse alterado?" ></textarea>
																				
										<div class="botoes_alteracao">
											<input type="submit" value="Sugerir alteração" value="" class="bt_sugeriralteracao" />
										</div>
									</form>
								</div>
								
							<?php } ?>
							<?php if($item->status_pedido === 'FRE') { ?>
								<script src="<?php echo JURI::root() . "/components/com_popstil/assets/js/popupoverlay.js" ?>"></script>
								
								<div id="dialog-modal-novafoto" title="Sugerir alteração">
									<div id="preview" class="dropareatext preview">
										<img id="blah" src="#" alt="your image" style='display: none;'/>
										<div id="textopreview" class="textopreview">
											Arraste aqui sua foto.
										</div>
									</div>
									<form id="formimage" runat="server">
										<input type="file" id="inputdroparea" name="file_upload" action="" onchange="uploadImage(this);" />
										<div id="img_carregando">
											<img src="<?php echo JURI::root() ?>/components/com_popstil/assets/img/loading.gif" />
										</div>
									</form>
									
									<form method="post" id="form_alterarfoto" action="<?php echo JRoute::_('index.php?option=com_popstil&task=painel.alteracaofoto&idpedido='.$pedido->idpedido.'&item='.$item->popstil_item_pedido_id); ?>" name="novafoto" >
										
										
										<input type="hidden" id="idImagem" name="imagem" />
																				
										<div class="botoes_alteracao">
											<input type="submit" value="Sugerir alteração" value="" class="bt_sugeriralteracao" onclick="if(!validacoes()) {
														alert('Você ainda não envio a foto.');
														return false;
													}" />
										</div>
									</form>
								</div>
								
								<div class="div_alteracao">	
									<input type="button" value="Enviar nova foto" value="" class="bt_sugeriralteracao dialog-modal-novafoto_open" id="bt_alteracao"/>
								</div>
							<?php } ?>
							<?php if($item->status_pedido === 'CON' ) { ?>
								<input type="button" value="Desenho aprovado" value="" class="bt_aprovado" />
							<?php } ?>
						</div>
					
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="container painel_pedidos">
		
	<div class="row">
		<div class="span12 titulo_pedidos_pendentes">
			<h1>Artes concluidas</h1>
		</div>
		<div class="span12 pedidos_pendentes">
			<?php if(!isset($this->artes) || empty($this->artes)) { ?>
				<h4>Você ainda não possui nenhuma arte concluída.</h4>
			<?php } ?>
			
			<?php foreach ($this->artes as $chave => $arte) { ?>
				<div class="pedido span2 arte">
					<img src="<?php echo $arte->url_arte ?>" alt="Arte"/>
						<div class="botoes_pedido">
							<!--<span><a href="#">Ver pedido</a></span>
							<span><a href="<?php echo JRoute::_('index.php?option=com_popstil&view=painel&layout=pagamento&idpedido='.$pedido->idpedido); ?>">Realizar pagamento</a></span>
							<span><a href="#">Aprovar arte</a></span>-->
						</div>
					</div>
			<?php } ?>			
		</div>
	</div>
	
	<div class="row">
		<div class="span12 titulo_pedidos_pendentes">
			<h1>Últimos pedidos realizados:</h1>
		</div>
		<div class="span12 pedidos_realizados">
			<?php if(!isset($this->pedidos) || empty($this->pedidos)) { ?>
				<h4>Você ainda nao realizou nenhum pedido </h4>
			<?php }  ?>
			<?php foreach ($this->pedidos as $chave => $item) { ?>
				
				<div class="pedido_realizado">
					<div class="titulo_pedido span7">
						<h3>Pedido numero: <?php echo $item->idpedido?></h3>
					</div>
					<div class="titulo_pedido span2">
						<h4>Realizado em <?php echo date("d/m/Y", strtotime($item->datagravacao)); ?></h4>
					</div>
					<div class="titulo_pedido span2">
						<span><a href="<?php echo JRoute::_('index.php?option=com_popstil&view=painel&layout=detalhepedido&idpedido='.$item->idpedido); ?>">Ver detalhes</a></span>
					</div>
				</div>
			
			<?php } ?>
			
			<!--<div class="pedido_realizado">
				<div class="titulo_pedido span7">
					<h3>Resumo do pedido - Popstil clássico 40x30cm</h3>
				</div>
				<div class="titulo_pedido span2">
					<h4>Envidado em 00/00/0000</h4>
				</div>
				<div class="titulo_pedido span2">
					<span><a href="#">Ver detalhes</a></span>
				</div>
			</div>-->
		</div>
	</div>
</div>