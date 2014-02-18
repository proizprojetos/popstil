

<form id="adminForm" action="<?php JRoute::_('index.php?option=com_popstil&task=pedido.cancelar') ?>" method="post" enctype="multipart/form-data">
	<!--<?php print_r($this->pedido); ?>
	<br/>
	<br/>
	<?php print_r($this->itenspedido); ?>
	
	<br /><br />
	<? print_r($this->quadrospedido); ?>
	-->
	<?php echo JHtml::_('bootstrap.startTabSet','myTab', array('active' => 'details')); ?>
	
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('Detalhe do pedido',true)); ?>
		<div id="pedido_header">
			<h2>Detalhe do pedido <?php echo $this->pedido->idpedido ?></h2>
		</div>
		
		<div id="pedido_corpo_left">
			<div class="pedido_detalhe">
				<h3>Dados do pedido</h3>
				<div class="item">
					<p>Status do pedido: 
					<?php if($this->escape($this->pedido->status_pedido) === 'ANA' ) {
						echo 'Análise da foto';
					}else if($this->escape($this->pedido->status_pedido) === 'FRE' ) {
						echo 'Foto recusada';
					}else if($this->escape($this->pedido->status_pedido) === 'AGU' ) {
						echo 'Foto aprovada/Aguardando pagamento';
					}else if($this->escape($this->pedido->status_pedido) === 'PCP' ) {
						echo 'Pagamento realizado/Em criação';
					}
					else if($this->escape($this->pedido->status_pedido) === 'PRO' ) {
						echo 'Em Criação';
					}
					else if($this->escape($this->pedido->status_pedido) === 'APR' ) {
						echo 'Arte pronta/Aguardando Aprovação';
					}else if($this->escape($this->pedido->status_pedido) === 'REC' ) {
						echo 'Arte recusada';
					}
					else if($this->escape($this->pedido->status_pedido) === 'CON' ) {
						echo 'Concluida/Em produção';
					}else if($this->escape($this->pedido->status_pedido) === 'ARP' ) {
						echo 'Arte aprovada/Em produção';
					}?> 				
					</p>
				</div>
				
				<div class="item">
					<p>Pedido realizado em <?php echo date("d/m/Y", strtotime($this->escape($this->pedido->datagravacao))); ?>	 </p>
				</div>
				
				<div class="item">
					<p>Valor parcial: <?php echo 'R$'.( $this->escape($this->pedido->valortotal))?> 	 </p>
				</div>
				
				<div class="item">
					<p>Valor do frete: <?php echo 'R$'.($this->escape($this->pedido->valor_frete))?> 	 </p>
				</div>
				
				<div class="item">
					<p>Valor total: <?php echo 'R$'.( $this->escape($this->pedido->valor_frete)+$this->escape($this->pedido->valortotal))?> 	 </p>
				</div>
			</div>
		</div>
		
		<div id="pedido_detalhe_cliente">
			<div class="pedido_detalhe_cliente">
				<h3>Detalhe do cliente</h3>
				<div class="item">
					<p>Nome completo: <?php echo $this->escape($this->pedido->nomecompleto); ?>	 </p>
				</div>
				<div class="item">
					<p>Email: <?php echo $this->escape($this->pedido->email); ?>	 </p>
				</div>
				<div class="item">
					<p>Nome de usuário <?php echo $this->escape($this->pedido->username);  ?>	 </p>
				</div>
				<h3>Endereço para entrega</h3>
				<div class="item">
					<p>Endereco: <?php echo $this->escape($this->pedido->endereco); ?> </p>
				</div>
				<div class="item">
					<p>Número: <?php echo $this->escape($this->pedido->numero); ?> </p>
				</div>
				<div class="item">
					<p>Complemento: <?php echo isset($this->pedido->complemento) ? $this->escape($this->pedido->complemento) : 'Nenhum'; ?> </p>
				</div>
				<div class="item">
					<p>CEP: <?php echo $this->escape($this->pedido->cep); ?> </p>
				</div>
				<div class="item">
					<p>Bairro: <?php echo $this->escape($this->pedido->bairro); ?> </p>
				</div>
				<div class="item">
					<p>Cidade: <?php echo $this->escape($this->pedido->cidade); ?> </p>
				</div>
				<div class="item">
					<p>Estado: <?php echo $this->escape($this->pedido->estado); ?> </p>
				</div>
			</div>
		</div>
		
		
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	
	<?php foreach ($this->itenspedido as $chave => $item) { ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'tabitem'.$chave, JText::_('Item do pedido '.($chave+1),true)); ?>
			<input type="hidden" name="item_pedido[<?php echo $chave?>][popstil_item_pedido_id]" value="<?php echo $item->popstil_item_pedido_id ?>" />
			<input type="hidden" name="item_pedido[<?php echo $chave?>][popstil_pedido_idpedido]" value="<?php echo $this->pedido->idpedido ?>" />
			<input type="hidden" name="item_pedido[<?php echo $chave?>][id_usuario]" value="<?php echo $this->pedido->popstil_usuario_idusuario ?>" />
			<input type="hidden" name="item_pedido[<?php echo $chave?>][status_anterior]" value="<?php echo $item->status_pedido ?>" />
			<input type="hidden" name="item_pedido[<?php echo $chave?>][id_arte]" value="<?php echo $item->popstil_arte_id ?>" />
			
			<div class="item_pedido_wrapper">
				<div class="item_pedido_left">
					<div class="foto_pedido">
						<img src="<?php echo $item->foto_cliente ?>" alt="" />
					</div>
					<a href="<?php echo $item->foto_cliente ?>" download="<?php echo $item->foto_cliente ?>" target="_blank">Baixar imagem</a>
					<br/>
					<div class="status_item_pedido">
						<select name="item_pedido[<?php echo $chave ?>][status_pedido]" id="" >
							<option value="ANA" <?php if($item->status_pedido == 'ANA') { echo 'selected';} ?>>Analise da foto</option>
							<option value="FRE" <?php if($item->status_pedido == 'FRE') { echo 'selected';} ?>>Foto recusada/Aguardando nova foto</option>
							<option value="AGU" <?php if($item->status_pedido == 'AGU') { echo 'selected';} ?>>Foto aprovada/Aguardando pagamento</option>
							<option value="PCP" <?php if($item->status_pedido == 'PCP') { echo 'selected';} ?>>Pagamento confirmado/Em Criação</option>
							<option value="PRO" <?php if($item->status_pedido == 'PRO') { echo 'selected';} ?>>Em Criação</option>
							<option value="APR" <?php if($item->status_pedido == 'APR') { echo 'selected';} ?>>Arte pronta/Aguardando aprovação</option>
							<option value="CON" <?php if($item->status_pedido == 'CON') { echo 'selected';} ?>>Concluida/Em Produção</option>
							<option value="REC" <?php if($item->status_pedido == 'REC') { echo 'selected';} ?>>Arte recusada</option>
							<option value="ARP" <?php if($item->status_pedido == 'ARP') { echo 'selected';} ?>>Arte aprovada/Em produção</option>
						</select>
					</div>		
					Arte:<br/>
					<?php if($item->status_pedido === 'PCP' || $item->status_pedido === 'PRO') { ?>
						<input type="file" name="item_pedido[<?php echo $chave ?>][arte]" arte="<?php if(isset($quadro->url_arte) && !empty($quadro->url_arte)) { echo $quadro->url_arte;} ?>" ?>
					<?php } ?>
					<?php if($item->status_pedido === 'APR' || $item->status_pedido == 'CON' || $item->status_pedido == 'REC' || $item->status_pedido == 'ARP' || !empty($item->url_arte)) {  ?>
						<div class="item_pedido_img">
							<a href="<?php echo $item->url_arte ?>" download="<?php echo $item->url_arte ?>" target="_blank">
								<img src="<?php echo $item->url_arte ?>" alt="" />
							</a>
						</div>
					<?php } ?>
					<br/>
					<?php if(!empty($item->alteracoes)) {?>
						<div class="alteracoes">
							<h3>Alterações solicitadas</h3>
							<?php foreach ($item->alteracoes as $key => $alteracao) { ?>
								<h4>Alteração <?php echo ($key+1); ?></h4>
								<p>Descrição: <?php echo $alteracao->desc_alteracao ?></p>
							<?php } ?>
						</div>
					<?php } ?>
				</div>			
			</div>
			
			<div class="quadro_item_wrapper">
				<div class="quadro_item">
					<h2>Detalhe dos quadros</h2>
					<p>Numero de Pessoas: <?php echo $item->nrpessoas; ?></p>
					<p>Orientação: <?php echo ($item->orientacao  === 'R' ? 'Retrato' : 'Paisagem'); ?></p>
				</div>
			</div>
			
			<!-- for each de cada quadro do item do pedido -->
			<?php foreach ($this->quadrospedido as $key => $quadro) { 
					if($quadro->popstil_item_pedido_id == $item->popstil_item_pedido_id) {
				?>
				
				<input type="hidden" name="quadro_item[<?php echo $key ?>][id]" value="<?php echo $quadro->id ?>" />
				<input type="hidden" name="quadro_item[<?php echo $key ?>][id_itempedido]" value="<?php echo $item->popstil_item_pedido_id ?>" />
				
				<div class="quadro_item_wrapper">
					<div class="quadro_item">
						<h2>Quadro <?php echo ($key+1) ?></h2>
						<p>Tamanho: <?php echo $quadro->tamanho ?> </p>
						<p>Moldura: <?php echo $quadro->moldura ?> </p>
						<p>Fundo: </p>
						<?php if($quadro->tipo_fundo == 'COR' ) { ?>
							<div class="fundo_cor" style="width:80px;height: 80px;padding:10px;">
								<span style="background: #<?php echo $quadro->codigo_cor; ?>; height: 100%;	width: 100%;display: inline-block;" 
								title=" #<?php echo $quadro->codigo_cor; ?>"></span>
							</div>
						<?php }else { ?>
							<div class="fundo_padraografico">
								<a href="<?php echo $quadro->url_imagem; ?>" download="<?php echo $quadro->url_imagem; ?>" target="_blank">
									<img src="<?php echo JURI::root().''.$quadro->url_imagem; ?>" alt=""  style="width:200px;height: 180px;"/>
								</a>
							</div>
							
						<?php } ?>

						<br/>
						<p>Arte:  </p>
						<br/>
						<?php if($item->status_pedido == 'APR' || $item->status_pedido == 'ARP' || $item->status_pedido == 'CON') { ?>
							<?php if(!empty($quadro->url_popstil)) { ?>
								<div class="foto_pedido">
									<a href="<?php echo $quadro->url_popstil ?>" download="<?php echo $quadro->url_popstil ?>" target="_blank">
										<img src="<?php echo $quadro->url_popstil ?>" alt="" />
									</a>
								</div>
							<?php } ?>
						<?php } ?>
						<?php if($item->status_pedido == 'PCP' || $item->status_pedido === 'PRO') { ?>
							<input type="file" name="quadro_item[<?php echo $key ?>][arte]" arte="<?php if(isset($quadro->url_arte) && !empty($quadro->url_arte)) { echo $quadro->url_arte;} ?>" ?>
						<?php } ?>
					</div>
				</div>
				
		
			<?php 
				}
			} ?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php } ?>
	
	
	<?php echo JHtml::_('bootstrap.endTabSet');?>
	
	
<input type="hidden" name="task" value="">
</form>