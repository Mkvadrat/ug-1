<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<h3>&rarr; <?php echo JText::_('RSF_USERS_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->adminActive ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_ADMIN_ACTIVE_DESC'); ?></td>
			<td>
			<?php if ($this->adminActive) {
			echo JText::_('RSF_ADMIN_ACTIVE_ON'); ?>
			<a href="<?php echo JRoute::_('index.php?option=com_rsfirewall&task=fix&what=admin'); ?>" target="_blank"><?php echo JText::_('RSF_CLICK_FIX'); ?></a>
			<?php } else
			echo JText::_('RSF_ADMIN_ACTIVE_OFF'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=ADMIN_ACTIVE" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/nocheck24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_WEAK_PASSWORDS_DESC'); ?></td>
			<td>The Users Check is limited in this version. This checks for weak passwords in your user accounts.</a>
			</td>
		</tr>
	</table>