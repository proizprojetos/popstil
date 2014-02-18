<?php 

defined('_JEXEC') or die('Acesso restrito');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
?>

<form action="<?php echo JRoute::_('index.php?option=com_popstilblog&view=categorias'); ?>" method="post" name="adminForm" id="adminForm">

	<table class="table table-striped">
		
		<thead>
			<tr>
				<th width="1%">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th class="nowrap center" width="20%">
					Titulo da categoria
				</th>
				<th class="nowrap center" width="20%">
					Descrição
				</th>
				<th class="nowrap center" width="5%">
					Esta ativo?
				</th>
				<th class="nowrap center" width="5%">
					Cor do tema
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
					<a href="<?php echo JRoute::_('index.php?option=com_popstilblog&task=categoria.edit&id='.(int) $item->id); ?>" title="">
						<?php echo $this->escape($item->titulo); ?></a>
				</td>
				<td class="center">
					<a href="<?php echo JRoute::_('index.php?option=com_popstilblog&task=categoria.edit&id='.(int) $item->id); ?>" title="">
						<?php echo $this->escape($item->descricao); ?></a>
				</td>
				<td class="center">
					<?php echo ($this->escape($item->status) == 1 ? 'Sim' : 'Não') ; ?>
				</td>
				<td class="center">
					<div style="margin-left: 25%;width: 45px;height:35px ;background-color: <?php echo '#'. $this->escape($item->cor_tema) ?>;" />
				</td>
				<td class="center">
					<?php echo date("d/m/Y H:i:s", strtotime($this->escape($item->inicio_publicacao))); ?>					
				</td>
				<td class="center">
					<?php echo date("d/m/Y H:i:s", strtotime($this->escape($item->fim_publicacao))); ?>					
				</td>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
	
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>