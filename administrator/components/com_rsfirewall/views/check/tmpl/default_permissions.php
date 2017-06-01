<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<h3>&rarr; <?php echo JText::_('RSF_FOLDER_PERMISSIONS_CHECK'); ?></h3>

	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="70%"><?php echo JText::_('RSF_PATH'); ?></th>
			<th width="20%"><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
	</table>
	
	<?php if ($this->folderPermissionsScrollable) { ?><div class="scrolling"><?php } ?>
	<table class="adminlist" cellspacing="1">
	<tbody>
	<?php foreach ($this->folderPermissionsResult as $folder => $perm) if ($perm > 755) { $wrong_folders = true; ?>
		<tr>
			<td width="1%"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/nocheck24.png" alt="" /></td>
			<td><?php echo $folder; ?></td>
			<td width="20%"><?php echo $perm; ?></td>
		</tr>
	<?php } ?>
	<?php if (empty($wrong_folders)) { ?>
		<tr>
			<td width="1%"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/check24.png" alt="" /></td>
			<td colspan="2"><?php echo JText::_('RSF_OK_FOLDER_PERMS'); ?></td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
	<?php if ($this->folderPermissionsScrollable) { ?></div><?php } ?>
	
	<?php if (!empty($wrong_folders)) { ?>
	<div class="rsfirewall_click" id="rsfirewall_folder_permissions">
	<img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/loading.gif" alt="" id="rsfirewall_folder_permissions_loading" style="display: none" />
	<p><?php echo JText::_('RSF_FOLDER_PERMISSIONS_ERROR'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=FOLDER_PERMISSIONS" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></p>
	<p><button type="button" onclick="rsfirewall_fix_folder_permissions(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button></p>
	</div>
	<?php } ?>

<h3>&rarr; <?php echo JText::_('RSF_FILE_PERMISSIONS_CHECK'); ?></h3>

	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="70%"><?php echo JText::_('RSF_PATH'); ?></th>
			<th width="20%"><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
	</table>
	
	<?php if ($this->filePermissionsScrollable) { ?><div class="scrolling"><?php } ?>
	<table class="adminlist" cellspacing="1">
	<tbody>
	<?php foreach ($this->filePermissionsResult as $file => $result) if ($result['perm'] > 644) { $wrong_files = true; ?>
		<tr>
			<td width="1%"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/nocheck24.png" alt="" /></td>
			<td><?php echo $file; ?></td>
			<td width="20%"><?php echo $result['perm']; ?></td>
		</tr>
	<?php } ?>
	<?php if (empty($wrong_files)) { ?>
		<tr>
			<td width="1%"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/check24.png" alt="" /></td>
			<td colspan="2"><?php echo JText::_('RSF_OK_FILE_PERMS'); ?></td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
	<?php if ($this->filePermissionsScrollable) { ?></div><?php } ?>
	
	<?php if (!empty($wrong_files)) { ?>
	<div class="rsfirewall_click" id="rsfirewall_file_permissions">
	<img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/loading.gif" alt="" id="rsfirewall_file_permissions_loading" style="display: none" />
	<p><?php echo JText::_('RSF_FILE_PERMISSIONS_ERROR'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=FILE_PERMISSIONS" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></p>
	<p><button type="button" onclick="rsfirewall_fix_file_permissions(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button></p>
	</div>
	<?php } ?>