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

print_r($params);

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'user.cancel' || document.formvalidator.isValid(document.id('user-form')))
		{
			Joomla.submitform(task, document.getElementById('user-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_helloworld&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="user-form" class="form-validate form-horizontal" enctype="multipart/form-data">
	
	<fieldset>
		
		<?php echo JHtml::_('bootstrap.startTabSet','myTab', array('active' => 'details')); ?>
		
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('Detalhe da conta',true)); ?>
			
			<?php foreach ($this->form->getFieldset('detalhes_usuario') as $field) { ?>
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
	<!--
	
	
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Editando'); ?></legend>
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('detaisl') as $field) { ?>
					<li><?php echo $field->label; $field->input; ?></li>
				<?php } ?>
			</ul>
		</fieldset>
	</div>
	
	<div class="width-120 fltrt">
		<?php echo JHtml::_('sliders.start', 'helloworld-slider');
		foreach ($params as $name => $fieldset) {
			echo JHtml::_('sliders.panel', JText::_($fieldset->label), $name. '-params');
			if(isset($fieldset->description) && trim($fieldset->description)) { ?>
				<p class="tip"><?php $this->escape(JText::_($fieldset->description)); ?></p>
		<?php } ?>
		
		
		
		<fieldset class="panelform">
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset($name) as $field) { ?>
					<li><?php echo $field ->label; ?><?php echo $field->input; ?></li>
				<?php } ?>
			</ul>
		</fieldset>
		<?php } ?>
	</div>-->
	
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	
</form>