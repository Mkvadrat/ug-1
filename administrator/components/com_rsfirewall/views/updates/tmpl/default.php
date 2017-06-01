<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>
<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm">
<table class="adminform">
	<tr>
		<th>
			<?php echo JText::_('RSF_UPDATE_CHECKING'); ?>
		</th>
	</tr>
	<tr>
		<td>
			<iframe src="http://www.rsjoomla.com/index.php?option=com_rshelp&amp;task=rev.check&amp;sess=<?php  echo RSFirewallHelper::genKeyCode();?>&amp;rev=<?php echo _RSFIREWALL_VERSION;?>&amp;joomla=j15x&amp;Itemid=43" style="border:0px solid;width:100%;height:18px;" scrolling="no" frameborder="no"></iframe>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><iframe src="http://www.rsjoomla.com/latest.html?tmpl=component" style="border:0px solid;width:100%;height:380px;" scrolling="no" frameborder="no"></iframe></td>
	</tr>
</table>

<input type="hidden" name="filetype" value="rsfirewallupdate"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="option" value="com_rsfirewall"/>
</form>