<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

?>
<?php if (count($this->logs) > 0) { ?>
	<h3><?php echo JText::_('RSF_LATEST_MESSAGES_SYSTEM_LOG'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_('#'); ?></th>
			<th class="title"><?php echo JText::_('RSF_ALERT_LEVEL'); ?></th>
			<th><?php echo JText::_('RSF_DATE_EVENT'); ?></th>
			<th><?php echo JText::_('RSF_USERIP'); ?></th>
			<th><?php echo JText::_('RSF_USERID'); ?></th>
			<th><?php echo JText::_('RSF_USERNAME'); ?></th>
			<th><?php echo JText::_('RSF_PAGE'); ?></th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('RSF_READ_MORE'); ?></th>
		</tr>
	</thead>
	<?php foreach ($this->logs as $i => $log) { ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="rsfirewall_<?php echo $log->level; ?>"><?php echo JText::_('RSF_'.strtoupper($log->level)); ?></td>
		<td><?php echo date('d.m.Y H:i:s', $log->date); ?></td>
		<td><a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=whois&ip=<?php echo $log->ip; ?>" target="_blank"><?php echo $log->ip; ?></a></td>
		<td><?php echo $log->userid; ?></td>
		<td><?php echo $log->username; ?></td>
		<td><?php echo $log->page; ?></td>
		<td><?php echo JText::_('RSF_EVENT_'.strtoupper($log->code)); ?></td>
		<td align="center"><a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=<?php echo $log->code; ?>" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
	</tr>
	<?php } ?>
	</table>
<?php } ?>