<?php 

defined('_JEXEC') or die('Acesso restrito');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
?>

<form action="<?php echo JRoute::_('index.php?option=com_popstil&view=fundopadraograficos'); ?>" method="post" name="adminForm" id="adminForm">

	<table class="table table-striped">
		
		<thead>
			<tr>
				<th width="1%">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th class="nowrap center" width="20%">
					Descrição
				</th>
				<th class="nowrap center" width="20%">
					Subategoria
				</th>
				<th class="nowrap center" width="5%">
					Esta ativo?
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
					<a href="<?php echo JRoute::_('index.php?option=com_popstil&task=fundopadraografico.edit&id='.(int) $item->id); ?>" title="">
						<?php echo $this->escape($item->descricao); ?></a>
				</td>
				<td class="center">
					<?php echo $this->escape($item->desc_subcategoria); ?>
				</td>
				<td class="center">
					<?php echo ($this->escape($item->ativo) == 1 ? 'Sim' : 'Não') ; ?>
				</td>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
	
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>