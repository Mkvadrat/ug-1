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
function rsfirewall_reset()
{
	var form = document.adminForm;

	for (var i=0;i<form.search_level.options.length;i++)
		form.search_level.options[i].selected = true;
	form.search_date_start.value = '';
	form.search_date_stop.value = '';
	form.search_ip.value = '';
	form.search_userid.value = '';
	form.search_username.value = '';
	form.search_page.value = '';
	
	form.submit();
}
</script>

<p><strong class="rsfirewall_red" style="font-size: 15px;">The System Logs are not functional in this version.</strong> <?php echo _RSFIREWALL_MESSAGE; ?></p>

<form action="<?php echo JRoute::_('index.php?option=com_rsfirewall&view=logs'); ?>" method="post" name="adminForm">
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_('#'); ?></th>
			<th class="title"><?php echo JHTML::_('grid.sort', 'RSF_ALERT_LEVEL', 'level', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th><?php echo JHTML::_('grid.sort', 'RSF_DATE_EVENT', 'date', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th><?php echo JHTML::_('grid.sort', 'RSF_USERIP', 'ip', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th><?php echo JHTML::_('grid.sort', 'RSF_USERID', 'userid', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th><?php echo JHTML::_('grid.sort', 'RSF_USERNAME', 'username', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th><?php echo JHTML::_('grid.sort', 'RSF_PAGE', 'page', $this->lists['order_Dir'], $this->lists['order']); ?></th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('RSF_READ_MORE'); ?></th>
		</tr>
	</thead>

	<tbody>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo JHTML::_('select.genericlist',$this->levels,'search_level[]','multiple="multiple" size="4"','value','text',$this->search['search_level']); ?></td>
		<td><?php echo JHTML::_('calendar',$this->search['search_date_start'],'search_date_start','search_date_start','%Y-%m-%d'); ?> - <?php echo JHTML::_('calendar',$this->search['search_date_stop'],'search_date_stop','search_date_stop','%Y-%m-%d'); ?></td>
		<td><input type="text" class="textarea" name="search_ip" value="<?php echo $this->search['search_ip']; ?>" size="30"></td>
		<td><input type="text" class="textarea" name="search_userid" value="<?php echo $this->search['search_userid']; ?>" size="5"></td>
		<td><input type="text" class="textarea" name="search_username" value="<?php echo $this->search['search_username']; ?>" size="20"></td>
		<td><input type="text" class="textarea" name="search_page" value="<?php echo $this->search['search_page']; ?>" size="20"></td>
		<td><input type="submit" name="" value="<?php echo JText::_('RSF_FILTER'); ?>" /> <input type="button" onclick="rsfirewall_reset()" name="" value="<?php echo JText::_('RSF_RESET'); ?>" /></td>
		<td>&nbsp;</td>
	</tr>
		<?php
		$k = 0;
		$i = 0;
		$n = count($this->data);
		foreach ($this->data as $row)
		{
   		?>
		<tr class="<?php echo "row$k"; ?>">
			<td><?php echo $this->pagination->getRowOffset($i); ?></td>
			<td align="left" class="rsfirewall_<?php echo $row->level; ?>"><?php echo JText::_('RSF_'.strtoupper($row->level)); ?></td>
			<td align="left"><?php echo date('d.m.Y H:i:s', $row->date); ?></td>
			<td align="left"><a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=whois&ip=<?php echo $row->ip; ?>" target="_blank"><?php echo $row->ip; ?></a></td>
			<td align="left"><?php echo $row->userid; ?></td>
			<td align="left"><?php echo $row->username; ?></td>
			<td align="left"><?php echo $row->page; ?></td>
			<td align="left"><?php echo JText::_('RSF_EVENT_'.$row->code); ?><?php echo !empty($row->debug_variables) ? '<br /><b>'.JText::_('RSF_DEBUG_VARIABLES').'</b><br />'.$row->debug_variables : ''; ?></td>
			<td align="center"><a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=<?php echo $row->code; ?>" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<?php
		$k = 1 - $k;
        $i++;
		} 
		?>
	</tbody>

	<tfoot>
		<tr>
			<td colspan="10">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	
	</table>
	
	<?php echo JHTML::_( 'form.token' ); ?>
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_rsfirewall" />
	<input type="hidden" name="task" value="logs" />
	<input type="hidden" name="view" value="logs" />
	<input type="hidden" name="controller" value="logs" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>