<?php 

defined('_JEXEC') or die('Acesso restrito');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
?>

<form action="<?php echo JRoute::_('index.php?option=com_popstil&view=descontos'); ?>" method="post" name="adminForm" id="adminForm">

	<table class="table table-striped">
		
		<thead>
			<tr>
				<th width="1%">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th class="nowrap center" width="20%">
					Codigo do desconto
				</th>
				<th class="nowrap center" width="20%">
					Valor do Desconto (% ou R$)
				</th>
				<th class="nowrap center" width="5%">
					Esta ativo?
				</th>
				<th class="nowrap center" width="20%">
					Inicio da publicação
				</th>
				<th class="nowrap center" width="20%">
					Fim da publicacao
				</th>
			</tr>		
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) { ?>
			<tr class="row<?php echo $i %2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				
				<td class="center">
					<a href="<?php echo JRoute::_('index.php?option=com_popstil&task=desconto.edit&id='.(int) $item->id); ?>" title="">
						<?php echo $this->escape($item->code_desconto); ?></a>
				</td>
				<td class="center">
					<?php echo ($this->escape($item->tipo_desconto) == 'RS' ? 'R$' : '%'); echo $this->escape($item->desconto); ?>
				</td>
				<td class="center">
					<?php echo ($this->escape($item->ativo) == 1 ? 'Sim' : 'Não') ; ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->datainicio); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->datafim); ?>
				</td>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
	
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>