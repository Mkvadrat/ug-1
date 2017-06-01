<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

$status = new JObject();
$status->modules = array();
$status->plugins = array();

//PLUGIN INSTALLATION SECTION

$plugins = &$this->manifest->getElementByPath('plugins');
if (is_a($plugins, 'JSimpleXMLElement') && count($plugins->children())) {

	foreach ($plugins->children() as $plugin)
	{
		$pname		= $plugin->attributes('plugin');
		$pgroup		= $plugin->attributes('group');
		$porder		= $plugin->attributes('order');

		// Set the installation path
		if (!empty($pname) && !empty($pgroup)) {
			$this->parent->setPath('extension_root', JPATH_ROOT.DS.'plugins'.DS.$pgroup);
		} else {
			$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('No plugin file specified'));
			return false;
		}


		 //Filesystem Processing Section


		// If the plugin directory does not exist, lets create it
		$created = false;
		if (!file_exists($this->parent->getPath('extension_root'))) {
			if (!$created = JFolder::create($this->parent->getPath('extension_root'))) {
				$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Failed to create directory').': "'.$this->parent->getPath('extension_root').'"');
				return false;
			}
		}

		/*
		* If we created the plugin directory and will want to remove it if we
		* have to roll back the installation, lets add it to the installation
		* step stack
		*/
		if ($created) {
			$this->parent->pushStep(array ('type' => 'folder', 'path' => $this->parent->getPath('extension_root')));
		}

		// Copy all necessary files
		$element = &$plugin->getElementByPath('files');
		if ($this->parent->parseFiles($element, -1) === false) {
			// Install failed, roll back changes
			$this->parent->abort();
			return false;
		}

		// Copy all necessary files
		$element = &$plugin->getElementByPath('languages');
		if ($this->parent->parseLanguages($element, 1) === false) {
			// Install failed, roll back changes
			$this->parent->abort();
			return false;
		}

		// Copy media files
		$element = &$plugin->getElementByPath('media');
		if ($this->parent->parseMedia($element, 1) === false) {
			// Install failed, roll back changes
			$this->parent->abort();
			return false;
		}


		//Database Processing Section

		$db = &JFactory::getDBO();

		// Check to see if a plugin by the same name is already installed
		$query = 'SELECT `id`' .
		' FROM `#__plugins`' .
		' WHERE folder = '.$db->Quote($pgroup) .
		' AND element = '.$db->Quote($pname);
		$db->setQuery($query);
		if (!$db->Query()) {
			// Install failed, roll back changes
			$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
			return false;
		}
		$id = $db->loadResult();

		// Was there a plugin already installed with the same name?
		if ($id) {

			if (!$this->parent->getOverwrite())
			{
				// Install failed, roll back changes
				$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.JText::_('Plugin').' "'.$pname.'" '.JText::_('already exists!'));
				return false;
			}

		} else {
			$row =& JTable::getInstance('plugin');
			$row->name = JText::_(ucfirst($pgroup)).' - '.JText::_(ucfirst($pname));
			$row->ordering = $porder;
			$row->folder = $pgroup;
			$row->iscore = 0;
			$row->access = 0;
			$row->client_id = 0;
			$row->element = $pname;
			$row->published = 1;
			$row->params = '';

			if (!$row->store()) {
				// Install failed, roll back changes
				$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
				return false;
			}
		}

		$status->plugins[] = array('name'=>$pname,'group'=>$pgroup);
	}
}

// MODULE INSTALLATION SECTION

$modules = &$this->manifest->getElementByPath('modules');
if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) {

	foreach ($modules->children() as $module)
	{
		$mname		= $module->attributes('module');
		$mclient	= JApplicationHelper::getClientInfo($module->attributes('client'), true);

		// Set the installation path
		if (!empty ($mname)) {
			$this->parent->setPath('extension_root', $mclient->path.DS.'modules'.DS.$mname);
		} else {
			$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('No module file specified'));
			return false;
		}

		/*
		* If the module directory already exists, then we will assume that the
		* module is already installed or another module is using that directory.
		*/
		if (file_exists($this->parent->getPath('extension_root'))&&!$this->parent->getOverwrite()) {
			$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('Another module is already using directory').': "'.$this->parent->getPath('extension_root').'"');
			return false;
		}

		// If the module directory does not exist, lets create it
		$created = false;
		if (!file_exists($this->parent->getPath('extension_root'))) {
			if (!$created = JFolder::create($this->parent->getPath('extension_root'))) {
				$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.JText::_('Failed to create directory').': "'.$this->parent->getPath('extension_root').'"');
				return false;
			}
		}

		/*
		* Since we created the module directory and will want to remove it if
		* we have to roll back the installation, lets add it to the
		* installation step stack
		*/
		if ($created) {
			$this->parent->pushStep(array ('type' => 'folder', 'path' => $this->parent->getPath('extension_root')));
		}

		// Copy all necessary files
		$element = &$module->getElementByPath('files');
		if ($this->parent->parseFiles($element, -1) === false) {
			// Install failed, roll back changes
			$this->parent->abort();
			return false;
		}

		// Copy language files
		$element = &$module->getElementByPath('languages');
		if ($this->parent->parseLanguages($element, $mclient->id) === false) {
			// Install failed, roll back changes
			$this->parent->abort();
			return false;
		}

		// Copy media files
		$element = &$module->getElementByPath('media');
		if ($this->parent->parseMedia($element, $mclient->id) === false) {
			// Install failed, roll back changes
			$this->parent->abort();
			return false;
		}

		$mtitle		= $module->attributes('title');
		$mposition	= $module->attributes('position');
		$morder		= $module->attributes('order');

		if ($mtitle && $mposition) {
			// if module already installed do not create a new instance
			$db =& JFactory::getDBO();
			$query = 'SELECT `id` FROM `#__modules` WHERE module = '.$db->Quote( $mname);
			$db->setQuery($query);
			if (!$db->Query()) {
				// Install failed, roll back changes
				$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.$db->stderr(true));
				return false;
			}
			$id = $db->loadResult();

			if (!$id){
				$row = & JTable::getInstance('module');
				$row->title		= $mtitle;
				$row->ordering	= $morder;
				$row->position	= $mposition;
				$row->showtitle	= 0;
				$row->iscore	= 0;
				$row->access	= ($mclient->id) == 1 ? 2 : 0;
				$row->client_id	= $mclient->id;
				$row->module	= $mname;
				$row->published	= 1;
				$row->params	= '';

				if (!$row->store()) {
					// Install failed, roll back changes
					$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.$db->stderr(true));
					return false;
				}
				
				// Make visible evertywhere if site module
				if ($mclient->id==0){
					$query = 'REPLACE INTO `#__modules_menu` (moduleid,menuid) values ('.$db->Quote( $row->id).',0)';
					$db->setQuery($query);
					if (!$db->query()) {
						// Install failed, roll back changes
						$this->parent->abort(JText::_('Module').' '.JText::_('Install').': '.$db->stderr(true));
						return false;
					}
				}


			}


		}

		$status->modules[] = array('name'=>$mname,'client'=>$mclient->name);
	}
}

$db =& JFactory::getDBO();
$db->setQuery("SELECT `value` FROM #__rsfirewall_configuration WHERE `name`='log_emails'");
$log_emails = $db->loadResult();
if ($log_emails == 'admin@localhost')
{
	$db->setQuery("SELECT `email` FROM #__users WHERE `gid`='25' AND `block`='0' ORDER BY `id` LIMIT 1");
	$email = $db->getEscaped($db->loadResult());
	if (!empty($email))
	{
		$db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".$email."' WHERE `name`='log_emails'");
		$db->query();
	}
}
?>

	<div align="left" width="100%">
 		<img src="../administrator/components/com_rsfirewall/assets/images/rsfirewall.jpg" alt="RSFirewall! Logo"/>
 	</div>
 	<br/>
	<table class="adminform">
		<tr>
			<td align="left">
			<strong>RSFirewall! 1.0.0 Component for Joomla!</strong><br/>
			&copy; 2009 by <a href="http://www.rsjoomla.com" target="_blank">http://www.rsjoomla.com</a><br/>
			All rights reserved.
			<br/><br/>
			This Joomla! Component has been released under <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPL</a>.<br/>
			<br/><br/>
			<p><strong>Please note:</strong><br />
This is a free version of RSFirewall!, you are free (under the GPL license) to use it on any number of websites, but you won't get any support or updates from RSJoomla!. <strong>Additionally, this version lacks security features.</strong><br /><strong style="font-size: 13px;"><a href="http://www.rsjoomla.com/joomla-components/joomla-security.html" target="_blank">You can have access to the unlimited features of RSFirewall! by purchasing a subscription here</a></strong></p>

			<b>Visit <a href="http://www.rsjoomla.com/" target="_blank">http://www.rsjoomla.com/</a> - for common issues, tech support, user manual, additional downloads and up to date knowledge base articles related to RSFirewall!.</b><br/><br/>

			Thank you for using RSFirewall!.
			<br/><br/>
			The RSJoomla.com team.
			<br/><br/>
			</td>
		</tr>
	</table><br/>
<br/><br/>
	<div align="left" width="100%"><b>RSFirewall! 1.0.0 Installed</b></div>