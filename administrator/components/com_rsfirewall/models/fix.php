<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelFix extends JModel
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getFiles()
	{
		global $mainframe;
		return $mainframe->getUserState('rsfirewall_files', array());
	}
	
	function getFolders()
	{
		global $mainframe;
		return $mainframe->getUserState('rsfirewall_folders', array());
	}
	
	function fixFilePermissions()
	{
		jimport('joomla.filesystem.path');
		JPath::setPermissions(JPATH_SITE, '0644', null);
	}
	
	function fixFolderPermissions()
	{
		jimport('joomla.filesystem.path');
		JPath::setPermissions(JPATH_SITE, null, '0755');
	}
	
	function fixTempFiles()
	{
		jimport('joomla.filesystem.file');
		$config =& JFactory::getConfig();
		$tmp_path = $config->getValue('config.tmp_path');
		$files = JFolder::files($tmp_path, '', true, true, array('index.html'));
		JFile::delete($files);
		
		return $files;
	}
	
	function fixAdmin()
	{
		global $mainframe;
		$this->_db->setQuery("SELECT `id` FROM #__users WHERE `username`='admin' AND `gid` > 22 LIMIT 1");
		$id = $this->_db->loadResult();
		$mainframe->redirect('index.php?option=com_users&view=user&task=edit&cid[]='.$id, JText::_('RSF_FIX_ADMIN'));
	}
}
?>