<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<h3>&rarr; <?php echo JText::_('RSF_SOFTWARE_VERSION_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="20%"><?php echo JText::_('RSF_ACTION'); ?></th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->validJoomlaVersion ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_JOOMLA_VERSION_CHECK'); ?></td>
			<td><?php echo JText::_('RSF_INSTALLED_VERSION'); ?> <?php echo $this->currentJoomlaVersion; ?><br />
			<?php echo JText::_('RSF_LATEST_VERSION'); ?> <?php echo $this->latestJoomlaVersion; ?></td>
			<td><?php echo $this->messageJoomlaVersion; ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=JOOMLA_VERSION" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->validFirewallVersion ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_FIREWALL_VERSION_CHECK'); ?></td>
			<td><?php echo JText::_('RSF_INSTALLED_VERSION'); ?> <?php echo $this->currentFirewallVersion; ?><br />
			<?php echo JText::_('RSF_LATEST_VERSION'); ?> <?php echo $this->latestFirewallVersion; ?></td>
			<td><?php echo $this->messageFirewallVersion; ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=FIREWALL_VERSION" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
	</table>