<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewFix extends JView
{
	function display( $tpl = null )
	{		
		$what = JRequest::getVar('what');
		$fix = $this->getModel('fix');
		
		switch ($what)
		{
		
			case 'folderPermissions':
			//$folders = $this->get('folders');
			$fix->fixFolderPermissions();
			//$this->assignRef('folders', $folders);
			parent::display('folderpermissions');
			break;
			
			case 'filePermissions':
			//$files = $this->get('files');
			$fix->fixFilePermissions();
			//$this->assignRef('files', $files);
			parent::display('filepermissions');
			break;
			
			case 'admin':
			$fix->fixAdmin();
			break;
			
			case 'tempFiles':
			$files = $fix->fixTempFiles();
			$this->assignRef('files', $files);
			parent::display('tempfiles');
			break;
		}
	}
}