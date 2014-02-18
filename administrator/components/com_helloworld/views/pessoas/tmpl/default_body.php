<?php 

defined('_JEXEC') or die('Acesso restrito');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
?>

<form action="<?php echo JRoute::_('index.php?option=com_helloword&view=pessoas'); ?>" method="post" name="adminform" id="adminform">

	<table class="table table-striped">
		
		<thead>
			<tr>
				<th width="1%">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th class="left">
					Nome completo
				</th>
				<th class="nowrap center" width="60%">
					Endereço
				</th>
			</tr>		
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
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
				
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_helloworld&task=pessoa.edit&id='.(int) $item->id); ?>" title="">
						<?php echo $this->escape($item->nome); ?></a>
				</td>
				<td class="center">
					<?php echo $this->escape($item->endereco); ?>
				</td>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
	
</form>