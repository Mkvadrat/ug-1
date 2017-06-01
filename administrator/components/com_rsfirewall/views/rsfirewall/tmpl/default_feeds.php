<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.modal');

if (count($this->feeds) > 0)
	foreach ($this->feeds as $feed)
	{
		if (!$feed) continue;
	?>
		<h3><?php echo JText::_('RSF_FEED'); ?> - <u><?php echo $feed->title; ?></u></h3>
		<table class="adminlist" cellspacing="1">
		<thead>
		<tr>
			<th width="10%"><?php echo JText::_('RSF_FEED_DATE'); ?></th>
			<th class="title"><?php echo JText::_('RSF_FEED_TITLE'); ?></th>
		</tr>
		</thead>
	<?php foreach ($feed->items as $i => $item) { ?>
		<tr>
			<td><?php echo $item->get_date(); ?></td>
			<td><a href="<?php echo $item->get_link(); ?>" class="modal" rel="{handler: 'iframe', size: {x: 570, y: 500}}"><?php echo str_replace($this->components->find, $this->components->replace, $item->get_title()); ?></a></td>
		</tr>
	<?php } ?>
		</table>
<?php } ?>