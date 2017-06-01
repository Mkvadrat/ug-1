<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<h3>&rarr; <?php echo JText::_('RSF_PHP_CHECK'); ?></h3>
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
			<td colspan="4">The PHP Check is not available in this version. The PHP Check scans if your PHP configuration allows some commands to be run on your website that could potentially lead to an intrusion.</td>
		</tr>
		
	</table>