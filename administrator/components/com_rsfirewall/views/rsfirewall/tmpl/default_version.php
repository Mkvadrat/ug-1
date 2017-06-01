<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

?>

</td>
<td width="50%" valign="top" align="center">

<form action="index.php?option=com_rsfirewall" method="post" name="adminForm">
<table border="1" width="100%" class="thisform">
	<tr class="thisform">
		<th class="cpanel" colspan="2"><?php echo _RSFIREWALL_PRODUCT . ' ' . _RSFIREWALL_VERSION_LONG. ' rev ' . _RSFIREWALL_VERSION; ?></th></td>
	 </tr>
	 <tr class="thisform"><td bgcolor="#FFFFFF" colspan="2"><br />
  <div style="width=100%" align="center">
  <img src="../administrator/components/com_rsfirewall/assets/images/rsfirewall.jpg" align="middle" alt="RSFirewall! logo"/>
  <br /><br /></div>
  </td></tr>
	 <tr class="thisform">
		<td width="120" bgcolor="#FFFFFF"><?php echo JText::_('RSF_INSTALLED_VERSION'); ?></td>
		<td bgcolor="#FFFFFF"><?php echo _RSFIREWALL_VERSION_LONG; ?></td>
	 </tr>
	 <tr class="thisform">
		<td bgcolor="#FFFFFF"><?php echo JText::_('RSF_COPYRIGHT'); ?></td>
		<td bgcolor="#FFFFFF"><?php echo _RSFIREWALL_COPYRIGHT;?></td>
	 </tr>
	 <tr class="thisform">
		<td bgcolor="#FFFFFF"><?php echo JText::_('RSF_LICENSE'); ?></td>
		<td bgcolor="#FFFFFF"><?php echo _RSFIREWALL_LICENSE;?></td>
	 </tr>
	 <tr class="thisform">
		<td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
		<td bgcolor="#FFFFCC"><?php echo _RSFIREWALL_MESSAGE;?></td>
	 </tr>
	 <tr class="thisform">
		<td valign="top" bgcolor="#FFFFFF"><?php echo JText::_('RSF_AUTHOR'); ?></td>
		<td bgcolor="#FFFFFF"><?php echo _RSFIREWALL_AUTHOR;?></td>
	 </tr>
	 <tr class="<?php echo (!$this->code) ? 'thisformError' : 'thisformOk'; ?>">
		<td valign="top"><?php echo JText::_('RSF_YOUR_CODE'); ?></td>
		<td>
			<?php echo (!$this->code) ? '<input type="text" name="global_register_code" value="" />': $this->code; ?>
		</td>
	 </tr>
	 <tr class="<?php echo (!$this->code) ? 'thisformError' : 'thisformOk'; ?>">
		<td valign="top">&nbsp;</td>
		<td>
			<?php if (!$this->code) { ?>
			<input type="submit" name="register" value="<?php echo JText::_('RSF_UPDATE_REGISTRATION');?>" /><br/>
			<?php } else { ?>
			<input type="button" name="register" value="<?php echo JText::_('RSF_MODIFY_REGISTRATION');?>" onclick="javascript:submitbutton('saveRegistration');"/>
			<?php }	?>
		</td>
	 </tr>
  </table>
<input type="hidden" name="filetype" value="rsfirewallupdate"/>
<input type="hidden" name="task" value="saveRegistration"/>
<input type="hidden" name="option" value="com_rsfirewall"/>
</form>

</td>
</tr>
</table>