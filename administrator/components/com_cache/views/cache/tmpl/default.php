<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_cache
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('formbehavior.chosen', 'select');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>

<form action="<?php echo JRoute::_('index.php?option=com_cache'); ?>" method="post" name="adminForm" id="adminForm">
  <?php if (!empty( $this->sidebar)) : ?>
    <div id="j-sidebar-container" class="span2">
      <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
  <?php else : ?>
    <div id="j-main-container">
  <?php endif;?>
  	<table class="table table-striped">
  		<thead>
  			<tr>
  				<th width="20">
  					<?php echo JHtml::_('grid.checkall'); ?>
  				</th>
  				<th class="title nowrap">
  					<?php echo JHtml::_('grid.sort',  'COM_CACHE_GROUP', 'group', $listDirn, $listOrder); ?>
  				</th>
  				<th width="5%" class="center nowrap">
  					<?php echo JHtml::_('grid.sort',  'COM_CACHE_NUMBER_OF_FILES', 'count', $listDirn, $listOrder); ?>
  				</th>
  				<th width="10%" class="center">
  					<?php echo JHtml::_('grid.sort',  'COM_CACHE_SIZE', 'size', $listDirn, $listOrder); ?>
  				</th>
  			</tr>
  		</thead>
  		<tfoot>
  			<tr>
  				<td colspan="4">
  				<?php echo $this->pagination->getListFooter(); ?>
  				</td>
  			</tr>
  		</tfoot>
  		<tbody>
  			<?php
  			$i = 0;
  			foreach ($this->data as $folder => $item) : ?>
  				<tr class="row<?php echo $i % 2; ?>">
  					<td>
  						<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $item->group; ?>" onclick="Joomla.isChecked(this.checked);" />
  					</td>
  					<td>
  						<strong><?php echo $item->group; ?></strong>
  					</td>
  					<td class="center">
  						<?php echo $item->count; ?>
  					</td>
  					<td class="center">
  						<?php echo JHtml::_('number.bytes', $item->size*1024); ?>
  					</td>
  				</tr>
  			<?php $i++; endforeach; ?>
  		</tbody>
  	</table>

  	<input type="hidden" name="task" value="" />
  	<input type="hidden" name="boxchecked" value="0" />
  	<input type="hidden" name="client" value="<?php echo $this->client->id;?>" />
  	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
  	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
  	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
