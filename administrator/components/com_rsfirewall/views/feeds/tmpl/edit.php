<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<script type="text/javascript">
function submitbutton(pressbutton)
{
	var form = document.adminForm;
	
	if (pressbutton == 'cancel')
	{
		submitform(pressbutton);
		return;
	}

	// do field validation
	if (form.url.value.length == 0 || form.url.value.indexOf('http') == -1)
		alert('<?php echo JText::_('RSF_FEED_URL_ERROR'); ?>');
	else if (form.limit.value.length == 0)
		alert('<?php echo JText::_('RSF_FEED_POSTS_ERROR'); ?>');
	else
		submitform(pressbutton);
}
</script>

<form action="index.php?option=com_rsfirewall&task=feeds" method="post" name="adminForm" id="adminForm">

	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="adminform">
		<tr>
			<td><label for="url"><?php echo JText::_('RSF_FEED_URL'); ?></label></td>
			<td><input name="url" value="<?php echo $this->feed->url; ?>" size="120" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="limit"><?php echo JText::_('RSF_FEED_SHOW_NEWEST'); ?></label></td>
			<td><input name="limit" value="<?php echo $this->feed->limit; ?>" size="3" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="published"><?php echo JText::_('STATE'); ?></label></td>
			<td><?php echo $this->lists['state']; ?></td>
		</tr>
	</table>

<?php echo JHTML::_('form.token'); ?>
<input type="hidden" name="option" value="com_rsfirewall" />
<input type="hidden" name="id" value="<?php echo $this->feed->id; ?>" />
<input type="hidden" name="controller" value="feeds" />
<input type="hidden" name="task" value="editfeed" />
<input type="hidden" name="view" value="feeds" />
</form>

<?php
//keep session alive while editing
JHTML::_('behavior.keepalive');
?>