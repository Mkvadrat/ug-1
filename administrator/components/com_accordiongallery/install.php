<?php
/**
 * @version		$Id: install.php 
 * @package		ACCORDION GALLERY
 * @author		XML/SWF http://vm.xmlswf.com
 * @copyright	Copyright (c) 2011 xml/swf. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);//J3 compatibility
} else {
jimport('joomla.installer.installer');

$db = & JFactory::getDBO();
$status = new JObject();
$status->modules = array();
$status->plugins = array();
$src = $this->parent->getPath('source');

if(version_compare( JVERSION, '1.6.0', 'ge' )) {

	$modules = &$this->manifest->xpath('modules/module');
	//foreach($modules as $module){
		$mname = 'mod_accordion_gallery';//$module->getAttribute('module');
		$client = 'site';//$module->getAttribute('client');
		if(is_null($client)) { $client = 'site';}
		($client=='administrator')? $path=$src.DS.'administrator'.DS.'modules'.DS.$mname: $path = $src.DS.'modules'.DS.$mname;
		$installer = new JInstaller;
		$result = $installer->install($path);
		$status->modules[] = array('name'=>$mname,'client'=>$client, 'result'=>$result);
//	}
	
	$query = "UPDATE #__modules SET position='left', ordering=99, published=0 WHERE module='mod_accordion_gallery'";
	$db->setQuery($query);
	$db->query();
	
}
else {

	$modules = &$this->manifest->getElementByPath('modules');
	if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) {
		foreach ($modules->children() as $module) {
			$mname = $module->attributes('module');
			$client = $module->attributes('client');
			if(is_null($client)) $client = 'site';
			($client=='administrator')? $path=$src.DS.'administrator'.DS.'modules'.DS.$mname: $path = $src.DS.'modules'.DS.$mname;
			$installer = new JInstaller;
			$result = $installer->install($path);
			$status->modules[] = array('name'=>$mname,'client'=>$client, 'result'=>$result);
		}
		
		$query = "UPDATE #__modules SET position='left', ordering=99, published=0 WHERE module='mod_accordion_gallery'";
		$db->setQuery($query);
		$db->query();
		
	}
}

if(version_compare( JVERSION, '1.6.0', 'ge' )) {
	
	$query = "SELECT id FROM #__modules WHERE `module`='mod_accordion_gallery' ";
	$db->setQuery($query);
	$moduleIDs = $db->loadResultArray();
	foreach($moduleIDs as $id) {
		$query = "INSERT IGNORE INTO #__modules_menu VALUES({$id}, 0)";
		$db->setQuery($query);
		$db->query();
	}

	$plugins = &$this->manifest->xpath('plugins/plugin');
	foreach($plugins as $plugin){
		$pname = $plugin->getAttribute('plugin');
		$pgroup = $plugin->getAttribute('group');
		$path = $src.DS.'plugins'.DS.$pgroup;
		$installer = new JInstaller;
		$result = $installer->install($path);
		$status->plugins[] = array('name'=>$pname,'group'=>$pgroup, 'result'=>$result);
		$query = "UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND element=".$db->Quote($pname)." AND folder=".$db->Quote($pgroup);
		$db->setQuery($query);
		$db->query();
	}
}
else {
	$plugins = &$this->manifest->getElementByPath('plugins');
	if (is_a($plugins, 'JSimpleXMLElement') && count($plugins->children())) {

		foreach ($plugins->children() as $plugin) {
			$pname = $plugin->attributes('plugin');
			$pgroup = $plugin->attributes('group');
			$path = $src.DS.'plugins'.DS.$pgroup;
			$installer = new JInstaller;
			$result = $installer->install($path);
			$status->plugins[] = array('name'=>$pname,'group'=>$pgroup, 'result'=>$result);

			$query = "UPDATE #__plugins SET published=1 WHERE element=".$db->Quote($pname)." AND folder=".$db->Quote($pgroup);
			$db->setQuery($query);
			$db->query();
		}
	}
}

?>

<?php $rows = 0; ?>
<h2><?php echo JText::_('Accordion Gallery Installation Status'); ?></h2>
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
			<td><strong><?php echo JText::_('Component Installed'); ?></strong></td>
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
			<td><strong><?php echo ($module['result'])?JText::_('Module Installed'):JText::_('Module Not Installed'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<?php } ?>