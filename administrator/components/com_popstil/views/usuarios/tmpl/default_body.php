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
					<?php echo JHTML::_('grid.sort', 'COM_POPSTIL_NOMECOMPLETO', 'u.nomecompleto', $this->sortDirection, $this->sortColumn); ?>
				</th>
				<th class="nowrap center" >
					<?php echo JHtml::_('grid.sort', 'COM_POPSTIL_USERNAME', 'u.username', $this->sortDirection, $this->sortColumn); ?>
				</th>
				<th class="nowrap center" >
					E-mail
				</th>	
				<th class="nowrap center" >
					Telefone
				</th>		
				<th class="nowrap center" >
					Endereco
				</th>	
				<th class="nowrap center" >
					Numero
				</th>
				<th class="nowrap center" >
					Complemento
				</th>
				<th class="nowrap center" >
					CEP
				</th>
				<th class="nowrap center" >
					Bairro
				</th>
				<th class="nowrap center" >
					Estado
				</th>
				<th class="nowrap center" >
					Pais
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
					<?php echo JHtml::_('grid.id', $i, $item->idusuario); ?>
				</td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_popstil&view=usuario&layout=detalheusuario&id='.(int) $item->idusuario); ?>" title="">
						<?php echo $this->escape($item->nomecompleto); ?> </a>					
				</td>
				<td class="center">
					<?php echo $this->escape($item->username); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->email); ?>
				</td>
				<td class="center">
					<?php echo $this->formatar($this->escape($item->ddd1).''.$this->escape($item->telefone1),'fone'); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->endereco); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->numero); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->complemento); ?>
				</td>
				<td class="center">
					<?php echo $this->formatar($this->escape($item->cep)); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->bairro); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->estado); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->pais); ?>
				</td>
			</tr>			
		<?php } ?>
			
		</tbody>
		
	
	</table>
	<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
	<input type="hidden" name="task" value="">

</form>

