<?php 

defined('_JEXEC') or die('Acesso restrito');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');

?>
<form action="<?php echo JRoute::_('index.php?option=com_popstil&view=precos'); ?>" method="post" name="adminForm" id="adminForm">

	<table class="table">
		
		<thead>
			<tr>
				<th class="center">
					Tamanho do quadro
				</th>
				<th class="nowrap center" width="20%">
					Numero de pessoas
				</th>
				<th class="nowrap center" width="20%">
					Preço
				</th>
			</tr>		
		</thead>
		<tbody>
		<?php foreach ($this->items as $i => $item) { ?>
			<tr class="row<?php echo $i %2; ?>">
				
				<td class="center" width="10%">
					<?php echo $this->escape($item->largura.'x'.$item->altura); ?>
				</td>
				<td class="center">
					<?php echo ($this->escape($item->numero_pessoas)); ?>
				</td>
				<td class="center">
					<input type="number" step="any" name="precos[<?php echo $item->id_tamanho; ?>][<?php echo $item->id_numpessoas; ?>]" value="<?php echo $this->escape($item->preco); ?>" />
				</td>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>