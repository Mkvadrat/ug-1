<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');

class RSFirewallModelCheck extends JModel
{
	var $latestJoomlaVersion = null;
	var $currentJoomlaVersion = null;
	var $latestFirewallVersion = null;
	var $currentFirewallVersion = null;
	
	var $_files = array();
	var $_folders = array();
	
	var $_config = null;
	var $_document_root = null;
	
	var $_file_errors = array();
	
	var $_patterns = array();
	
	var $_wrong_php = false;
	
	var $_integrity_scrollable = 0;
	var $_file_permissions_scrollable = 0;
	var $_folder_permissions_scrollable = 0;
	var $_patterns_scrollable = 0;
	
	function __construct()
	{
		parent::__construct();
		global $mainframe;
		
		$run = JRequest::getVar('run', false);
		if ($run)
		{
			$mainframe->setUserState('grade', '0');
			set_time_limit(0);
			// Joomla!
			$this->_getLatestJoomlaVersion();
			$this->_getCurrentJoomlaVersion();
		
			// RSFirewall!
			$this->_getLatestFirewallVersion();
			$this->_getCurrentFirewallVersion();
		
			jimport('joomla.filesystem.folder');
			// Check folders
			$this->_scanFolders();
			
			// Check files
			$this->_scanFiles();
		
			// JConfig
			$this->_config =& JFactory::getConfig();
		
			// Document root
			$this->_document_root = realpath($_SERVER['DOCUMENT_ROOT']);
		}
	}
	
	// Joomla!
	// Get the latest version of Joomla!
	function _getLatestJoomlaVersion()
	{
		$this->latestJoomlaVersion = RSFirewallHelper::getLatestJoomlaVersion();
	}
	
	function getLatestJoomlaVersion()
	{
		return $this->latestJoomlaVersion;
	}
	
	// Get the current version of Joomla!
	function _getCurrentJoomlaVersion()
	{
		$this->currentJoomlaVersion = RSFirewallHelper::getCurrentJoomlaVersion();
	}
	
	function getCurrentJoomlaVersion()
	{
		return $this->currentJoomlaVersion;
	}
	
	// Check if running the latest version of Joomla!
	function getValidJoomlaVersion()
	{
		$valid = RSFirewallHelper::version_compare($this->currentJoomlaVersion, $this->latestJoomlaVersion);
		if ($valid)
			RSFirewallHelper::grade('+10');
			
		return $valid;
	}
	
	function getMessageJoomlaVersion()
	{
		if ($this->getValidJoomlaVersion())
			return JText::_('RSF_JOOMLA_VERSION_OK');
		else
			return JText::_('RSF_JOOMLA_VERSION_OLD');
	}
	
	// RSFirewall!
	// Get the latest version of RSFirewall!
	function _getLatestFirewallVersion()
	{
		$this->latestFirewallVersion = RSFirewallHelper::getLatestFirewallVersion();
	}
	
	function getLatestFirewallVersion()
	{
		return $this->latestFirewallVersion;
	}
	
	// Get the current version of RSFirewall!
	function _getCurrentFirewallVersion()
	{
		$this->currentFirewallVersion = RSFirewallHelper::getCurrentFirewallVersion();
	}
	
	function getCurrentFirewallVersion()
	{
		return $this->currentFirewallVersion;
	}
	
	// Check if running the latest version of RSFirewall!
	function getValidFirewallVersion()
	{
		$valid = RSFirewallHelper::version_compare($this->currentFirewallVersion, $this->latestFirewallVersion);
		if ($valid)
			RSFirewallHelper::grade('+10');
			
		return $valid;
	}
	
	function getMessageFirewallVersion()
	{
		if ($this->getValidFirewallVersion())
			return JText::_('RSF_FIREWALL_VERSION_OK');
		else
			return JText::_('RSF_FIREWALL_VERSION_OLD');
	}
	
	// Folders check - grab all folders and check their permissions
	function _scanFolders()
	{
		$folders = array();
		$tmp_folders = JFolder::folders(JPATH_SITE, '.', true, true);
		foreach ($tmp_folders as $i => $folder)
		{
			$perm = substr(decoct(fileperms($folder)),-3);
			if ($perm > 755)
				$this->_folder_permissions_scrollable++;
			$this->_folders[str_replace(JPATH_SITE.DS, '', $folder)] = $perm;
		}
		
		$maxfolders = count($tmp_folders);
		unset($tmp_folders);
		if ($this->_folder_permissions_scrollable)
		{
			$grade = ceil(1/(100*$this->_folder_permissions_scrollable/$maxfolders));
			RSFirewallHelper::grade($grade);
		}
		else
			RSFirewallHelper::grade('+10');
		
		//global $mainframe;
		//$mainframe->setUserState('rsfirewall_folders', $this->_folders);
	}
	
	function _scanFiles()
	{
		$files = array();
		$tmp_files = JFolder::files(JPATH_SITE, '.', true, true);
		foreach ($tmp_files as $i => $file)
		{
			$perm = substr(decoct(fileperms($file)),-3);
			if ($perm > 644)
				$this->_file_permissions_scrollable++;
			
			$this->_files[str_replace(JPATH_SITE.DS, '', $file)] = array('perm' => $perm, 'pattern' => '');
		}
		$maxfiles = count($tmp_files);
		unset($tmp_files);
		if ($this->_file_permissions_scrollable)
		{
			$grade = ceil(1/(100*$this->_file_permissions_scrollable/$maxfiles));
			RSFirewallHelper::grade($grade);
		}
		else
			RSFirewallHelper::grade('+10');
		
		global $mainframe;
		//$mainframe->setUserState('rsfirewall_files', $this->_files);
		$mainframe->setUserState('rsfirewall_patterns', $this->_patterns);
	}
	
	function getFilePermissionsResult()
	{
		return $this->_files;
	}
	
	function getFolderPermissionsResult()
	{
		return $this->_folders;
	}
	
	function getTempOutsideResult()
	{
	 	$tmp_path = $this->_config->getValue('config.tmp_path');
		$valid = strpos($tmp_path, $this->_document_root) === false ? true : false;
		
		if ($valid)
			RSFirewallHelper::grade('+3');
		
		return $valid;
	}
	
	function getLogOutsideResult()
	{
		$log_path = $this->_config->getValue('config.log_path');
		$valid = strpos($log_path, $this->_document_root) === false ? true : false;
		
		if ($valid)
			RSFirewallHelper::grade('+3');
		
		return $valid;
	}
	
	function getTempFilesResult()
	{
	 	$tmp_path = $this->_config->getValue('config.tmp_path');
		$files = JFolder::files($tmp_path, '', true, true, array('index.html'));
		$count = count($files);
		
		if (!$count)
			RSFirewallHelper::grade('+3');
		
		return $count;
	}
	
	function getConfigurationOutsideResult()
	{
		if (JPATH_SITE == JPATH_CONFIGURATION)
			$valid = false;
		else
		{
			$valid = true;
			RSFirewallHelper::grade('+5');
		}
		
		return $valid;
	}
	
	function getPatternsScrollable()
	{
		return ($this->_patterns_scrollable >= 12);
	}
	
	function getFilePermissionsScrollable()
	{
		return ($this->_file_permissions_scrollable >= 12);
	}
	
	function getFolderPermissionsScrollable()
	{
		return ($this->_folder_permissions_scrollable >= 12);
	}
	
	function getIntegrityScrollable()
	{
		return ($this->_integrity_scrollable >= 12);
	}
	
	function getAdminActive()
	{
		$valid = $this->_getListCount("SELECT `id` FROM #__users WHERE `username`='admin' AND `gid` > 22") > 0 ? true : false;
		
		if (!$valid)
			RSFirewallHelper::grade('+5');
		
		return $valid;
	}
	
	function getGrade()
	{
		return RSFirewallHelper::convertGrade(RSFirewallHelper::getGrade());
	}
}
?>