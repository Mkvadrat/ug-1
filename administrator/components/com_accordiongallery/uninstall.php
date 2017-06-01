<?php
/**
 * @version		$Id: uninstall.php 12/21/2011 xml/swf $
 * @package		ACCORDION GALLERY
 * @author		xml/swf http://vm.xmlswf.com
 * @copyright	Copyright (c) 2011 xml/swf. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.installer.installer');

$status = new JObject();
$status->modules = array ();
$status->plugins = array ();

if(version_compare( JVERSION, '1.6.0', 'ge' )) {
	//$modules = & $this->manifest->xpath('modules/module');
	$plugins = array();//& $this->manifest->xpath('plugins/plugin');
	//foreach($modules as $module){
		$mname = 'mod_accordion_gallery';//$mname = $module->getAttribute('module');
		$client = 'site';//$module->getAttribute('client');
		$db = & JFactory::getDBO();
		$query = "SELECT `extension_id` FROM `#__extensions` WHERE `type`='module' AND element = ".$db->Quote($mname)."";
		$db->setQuery($query);
		$IDs = $db->loadResultArray();
		if (count($IDs)) {
			foreach ($IDs as $id) {
				$installer = new JInstaller;
				$result = $installer->uninstall('module', $id);
			}
		}
		$status->modules[] = array ('name'=>$mname, 'client'=>$client, 'result'=>$result);
	//}

	foreach ($plugins as $plugin) {

		$pname = $plugin->getAttribute('plugin');
		$pgroup = $plugin->getAttribute('group');
		$db = & JFactory::getDBO();
		$query = "SELECT `extension_id` FROM #__extensions WHERE `type`='plugin' AND element = ".$db->Quote($pname)." AND folder = ".$db->Quote($pgroup);
		$db->setQuery($query);
		$IDs = $db->loadResultArray();
		if (count($IDs)) {
			foreach ($IDs as $id) {
				$installer = new JInstaller;
				$result = $installer->uninstall('plugin', $id);
			}
		}
		$status->plugins[] = array ('name'=>$pname, 'group'=>$pgroup, 'result'=>$result);
	}
	
}
else {


	$modules = & $this->manifest->getElementByPath('modules');
	$plugins = & $this->manifest->getElementByPath('plugins');

	if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) {

		foreach ($modules->children() as $module) {

			$mname = $module->attributes('module');
			$client = $module->attributes('client');
			$db = & JFactory::getDBO();
			$query = "SELECT `id` FROM `#__modules` WHERE module = ".$db->Quote($mname)."";
			$db->setQuery($query);
			$modules = $db->loadResultArray();
			if (count($modules)) {
				foreach ($modules as $module) {
					$installer = new JInstaller;
					$result = $installer->uninstall('module', $module, 0);
				}
			}
			$status->modules[] = array ('name'=>$mname, 'client'=>$client, 'result'=>$result);
		}
	}

	if (is_a($plugins, 'JSimpleXMLElement') && count($plugins->children())) {

		foreach ($plugins->children() as $plugin) {

			$pname = $plugin->attributes('plugin');
			$pgroup = $plugin->attributes('group');
			$db = & JFactory::getDBO();
			$query = 'SELECT `id` FROM #__plugins WHERE element = '.$db->Quote($pname).' AND folder = '.$db->Quote($pgroup);
			$db->setQuery($query);
			$plugins = $db->loadResultArray();
			if (count($plugins)) {
				foreach ($plugins as $plugin) {
					$installer = new JInstaller;
					$result = $installer->uninstall('plugin', $plugin, 0);
				}
			}
			$status->plugins[] = array ('name'=>$pname, 'group'=>$pgroup, 'result'=>$result);
		}
	}


}


?>

<?php $rows = 0; ?>
<h2><?php echo JText::_('Accordion Gallery Removel Status'); ?></h2>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2">&nbsp;</th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo JText::_('com_accordiongallery'); ?></td>
			<td><strong><?php echo JText::_('Component Removed'); ?></strong></td>
		</tr>
		<?php if (count($status->modules)): ?>
		<tr>
			<th><?php echo JText::_('MODULE'); ?></th>
			<th><?php echo JText::_('CLIENT'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->modules as $module): ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong><?php echo ($module['result'])?JText::_('Module  Removed'):JText::_('Module Not Removed'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>

		</tbody>
</table>
