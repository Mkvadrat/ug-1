<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelFolders extends JModel
{
	var $_folder = null;

	function __construct()
	{
		parent::__construct();
		$this->_folder = is_dir(JRequest::getVar('folder')) ? JRequest::getVar('folder') : JPATH_SITE;
	}
	
	function getFolders()
	{
		$folders = array();
		$current_element = $this->_folder;
		if ($dirHandle = @opendir($current_element)) 
		{
			while ($file = @readdir($dirHandle)) 
				if(is_dir($current_element.DS.$file) && $file != '.' && $file != '..')
				{
					$newfolder = new stdClass();
					$newfolder->name = $file;
					$newfolder->fullpath = $current_element.DS.$file;
					
					$folders[] = $newfolder;
				}
		}
		
		return $folders;
	}
	
	function getFiles()
	{
		$files = array();
		$current_directory = $this->_folder;
		if ($dirHandle = @opendir($current_directory)) 
		{
			while ($file = @readdir($dirHandle)) 
				if(is_file($current_directory.DS.$file) && $file != '.' && $file != '..')
				{
					$newfile = new stdClass();
					$newfile->name = $file;
					$newfile->fullpath = $current_directory.DS.$file;
					
					$files[] = $newfile;
				}
		}
		return $files;
	}
	
	function getElements()
	{
		$current_element = $this->_folder;
		
		$elements = explode(DS,$current_element);
		$navigation_path = '';
		if(!empty($elements))
		{
			foreach($elements as $i=>$element)
			{
				$navigation_path .= $element;
				$newelement = new stdClass();
				$newelement->name = $element;
				$newelement->fullpath = $navigation_path;
				$elements[$i] = $newelement;
				$navigation_path .= DS;
			}
		}
		
		return $elements;
	}
}
?>