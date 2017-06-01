<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<form action="<?php echo JRoute::_('index.php?option=com_rsfirewall&view=auth'); ?>" method="post" name="adminForm">
	<table class="adminlist" cellspacing="1">
		<tr>
			<td width="105"><?php echo JText::_('RSF_MASTER_PASSWORD'); ?></td>
			<td><input type="password" name="master_password" class="textarea" value="" size="50" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="" value="<?php echo JText::_('RSF_LOGIN'); ?>" /></td>
		</tr>
	</table>
	
	<?php echo JHTML::_( 'form.token' ); ?>
	<input type="hidden" name="option" value="com_rsfirewall" />
	<input type="hidden" name="task" value="login" />
	<input type="hidden" name="view" value="auth" />
	<input type="hidden" name="controller" value="auth" />
</form>