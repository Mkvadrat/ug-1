<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<form action="index.php?option=com_rsfirewall&task=feeds" method="post" name="adminForm">
	<table class="adminform">
		<tr>
			<td width="100%">&nbsp;</td>
			<td nowrap="nowrap">
				<?php echo $this->lists['state']; ?>
			</td>
		</tr>
	</table>
	<div id="editcell1">
		<table class="adminlist">
			<thead>
			<tr>
				<th width="5">
					<?php echo JText::_( '#' ); ?>
				</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->data); ?>);"/></th>
				<th><?php echo JText::_('RSF_FEED_URL'); ?></th>
				<th><?php echo JText::_('RSF_FEED_SHOW_NEWEST'); ?></th>
				<th width="80"><?php echo JText::_('Published'); ?></th>
				<th width="100"><?php echo JText::_('Ordering'); ?>
				<?php echo JHTML::_('grid.order',$this->data); ?>
				</th>
			</tr>
			</thead>
	<?php
	$i = 0;
	$n = count($this->data);
	foreach ($this->data as $row)
	{
	?>
		<tr class="row<?php echo $i; ?>">
			<td><?php echo $i+1; ?></td>
			<td><?php echo JHTMLGrid::id($i, $row->id); ?></td>
			<td align="center"><a href="<?php echo JRoute::_('index.php?option=com_rsfirewall&controller=feeds&task=editfeed&cid[]='.$row->id); ?>"><?php echo $row->url; ?></a></td>
			<td align="center"><?php echo $row->limit.JText::_('RSF_FEED_ENTRIES'); ?></td>
			<td align="center"><?php echo JHTMLGrid::published($row, $i); ?></td>
			<td class="order" align="center">
			<span><?php echo $this->pagination->orderUpIcon( $i, true, 'orderup', 'Move Up', 'ordering'); ?></span>
			<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', 'ordering' ); ?></span>
			<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align:center" />
			</td>
		</tr>
	<?php
		$i += 1;
	}
	?>
		</table>
	</div>
	<?php echo JHTML::_( 'form.token' ); ?>
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_rsfirewall" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="view" value="feeds" />
	<input type="hidden" name="controller" value="feeds" />
</form>