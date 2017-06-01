<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<h3>&rarr; <?php echo JText::_('RSF_FILE_ACCESS_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="20%"><?php echo JText::_('RSF_ACTION'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->tempIsOutside ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_TEMP_OUTSIDE'); ?></td>
			<td><?php echo $this->tempIsOutside ? JText::_('RSF_OK_TEMP_OUTSIDE') : JText::_('RSF_NO_TEMP_OUTSIDE'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=TEMP_OUTSIDE" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->logIsOutside ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_LOG_OUTSIDE'); ?></td>
			<td><?php echo $this->logIsOutside ? JText::_('RSF_OK_LOG_OUTSIDE') : JText::_('RSF_NO_LOG_OUTSIDE'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=LOG_OUTSIDE" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->tempFiles == 0 ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_TEMP_FILES'); ?></td>
			<td>
			<?php if ($this->tempFiles > 0) {
			echo $this->tempFiles.JText::_('RSF_NOT_OK_TEMP_FILES') ?>
			<span id="rsfirewall_temp_files">
			<img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/loading.gif" alt="" id="rsfirewall_temp_files_loading" style="display: none" />
			<button type="button" onclick="rsfirewall_fix_temp_files(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button>
			</span>
			<?php } else
				echo JText::_('RSF_OK_TEMP_FILES'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=TEMP_FILES" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/nocheck24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_CONFIGURATION_FILE'); ?></td>
			<td>The File and Folder Access Check is limited in this version. This checks for known malware patterns (trojans, javascripts) in your configuration.php file.</td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->configurationIsOutside ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_CONFIGURATION_OUTSIDE'); ?></td>
			<td><?php echo $this->logIsOutside ? JText::_('RSF_OK_CONFIGURATION_OUTSIDE') : JText::_('RSF_NO_CONFIGURATION_OUTSIDE'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=CONFIGURATION_OUTSIDE" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
	</table>