<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

$params = $this->form->getFieldsets('params');

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'categoria.cancel' || document.formvalidator.isValid(document.id('categoria-form')))
		{
			Joomla.submitform(task, document.getElementById('categoria-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_popstilblog&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="categoria-form" class="form-validate form-horizontal" enctype="multipart/form-data">
	
	<fieldset>
		
		<?php echo JHtml::_('bootstrap.startTabSet','myTab', array('active' => 'details')); ?>
		
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('Detalhe da Categoria',true)); ?>
			
			<?php foreach ($this->form->getFieldset('detalhes_categoria') as $field) { ?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $field->label; ?>
					</div>
					<div class="controls">
						<?php echo $field->input; ?>
					</div>
				</div>
			<?php } ?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>		
	</fieldset>	
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>