<?php 

defined('_JEXEC') or die('Acesso restrito');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
?>

<form action="<?php echo JRoute::_('index.php?option=com_popstil&view=sliders'); ?>" method="post" name="adminForm" id="adminForm">

	<table class="table table-striped">
		
		<thead>
			<tr>
				<th width="1%">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th class="left">
					Mensagem do slider
				</th>
				<th class="nowrap center" width="20%">
					Imagem
				</th>
				<th class="nowrap center" width="20%">
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
				<td colspan="6">
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
					<a href="<?php echo JRoute::_('index.php?option=com_popstil&task=slider.edit&id='.(int) $item->id); ?>" title="">
						<?php echo $this->escape($item->mensagem); ?></a>
				</td>
				<td class="center">
					<?php echo $this->escape($item->url_imagem); ?>
				</td>
				<td class="center">
					<?php echo ($this->escape($item->ativo) == 1 ? 'Sim' : 'Não') ; ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->inicio_publicacao); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->fim_publicacao); ?>
				</td>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>