<?php 

defined('_JEXEC') or die('Acesso restrito');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');

JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$sortFields = $this->getSortFields();

?>

<form action="<?php echo JRoute::_('index.php?option=com_popstil&view=usuarios'); ?>" method="post" name="adminForm" id="adminForm">

	<table class="table table-striped">
	
		<thead>
			<tr>
				<th width="1%">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th class="left">
					<?php echo JHTML::_('grid.sort', 'COM_POPSTIL_PEDIDOID', 'p.idpedido', $this->sortDirection, $this->sortColumn); ?>
				</th>
				<th class="nowrap center" >
					<?php echo JHtml::_('grid.sort', 'COM_POPSTIL_PEDIDOSTATUS', 'p.status_pedido', $this->sortDirection, $this->sortColumn); ?>
				</th>
				<th class="nowrap center" >
					Cliente
				</th>	
				<th class="nowrap center" >
					Subtotal
				</th>
				<th class="nowrap center" >
					Valor do frete
				</th>
				<th class="nowrap center" >
					Total
				</th>
				<th class="nowrap center" >
					Pedido realizado em
				</th>

			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="12">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach($this->items as $i => $item) { ?>
			<tr class="row<?php echo $i %2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->idpedido); ?>
				</td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido='.(int) $item->idpedido); ?>" title="">
						<?php echo $this->escape($item->idpedido); ?> </a>					
				</td>
				<td class="center">
					<a href="<?php echo JRoute::_('index.php?option=com_popstil&view=pedido&layout=visualizarpedido&idpedido='.(int) $item->idpedido); ?>" title="">
						<?php if($this->escape($item->status_pedido) === 'ANA' ) {
							echo 'Análise da foto';
						}else if($this->escape($this->pedido->status_pedido) === 'FRE' ) {
							echo 'Foto recusada';
						}else if($this->escape($item->status_pedido) === 'AGU' ) {
							echo 'Foto aprovada/Aguardando pagamento';
						}else if($this->escape($item->status_pedido) === 'PAG' ) {
							echo 'Pagamento realizado';
						}
						else if($this->escape($item->status_pedido) === 'PRO' ) {
							echo 'Em Produção';
						}
						else if($this->escape($item->status_pedido) === 'APR' ) {
							echo 'Arte pronta/Aguardando Aprovação';
						}else if($this->escape($item->status_pedido) === 'REC' ) {
							echo 'Arte recusada';
						}
						else if($this->escape($item->status_pedido) === 'CON' ) {
							echo 'Concluida/Enviada';
						}?> 
					</a>					
				</td>
				<td class="center">
					<?php echo $this->escape($item->idusuario).' - '.$this->escape($item->nomecompleto); ?> 					
				</td>
				<td class="center"> 
					<?php echo 'R$'.( $this->escape($item->valortotal))?> 					
				</td>
				<td class="center">
					<?php echo 'R$'.($this->escape($item->valor_frete))?> 					
				</td>
				<td class="center">
					<?php echo 'R$'.( $this->escape($item->valortotal)+$this->escape($item->valor_frete))?>					
				</td>
				<td class="center">
					<?php echo date("d/m/Y", strtotime($this->escape($item->datagravacao))); ?>					
				</td>
			</tr>			
		<?php } ?>
			
		</tbody>
		
	
	</table>
	<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
	<input type="hidden" name="task" value="">

</form>

