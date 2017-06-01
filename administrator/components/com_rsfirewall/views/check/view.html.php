<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewCheck extends JView
{
	function display( $tpl = null )
	{
		JToolBarHelper::title('RSFirewall!','rsfirewall');
		
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_OVERVIEW'), 'index.php?option=com_rsfirewall');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_CHECK'), 'index.php?option=com_rsfirewall&view=check', true);
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOGS'), 'index.php?option=com_rsfirewall&view=logs');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOCKDOWN'), 'index.php?option=com_rsfirewall&view=lockdown');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=configuration');
		JSubMenuHelper::addEntry(JText::_('RSF_FEEDS_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=feeds');
		JSubMenuHelper::addEntry(JText::_('RSF_UPDATES'), 'index.php?option=com_rsfirewall&view=updates');
		
		parent::display($tpl);
		
		$run = JRequest::getVar('run', false);
		if ($run)
		{
			$log = new RSFirewallLog();
			$log->addEvent('low', 'START_SYSTEM_CHECK');
			
			$this->assignRef('currentJoomlaVersion', $this->get('CurrentJoomlaVersion'));
			$this->assignRef('latestJoomlaVersion', $this->get('LatestJoomlaVersion'));
			$this->assignRef('messageJoomlaVersion', $this->get('MessageJoomlaVersion'));
			$this->assignRef('validJoomlaVersion', $this->get('ValidJoomlaVersion'));
			
			$this->assignRef('currentFirewallVersion', $this->get('CurrentFirewallVersion'));
			$this->assignRef('latestFirewallVersion', $this->get('LatestFirewallVersion'));
			$this->assignRef('messageFirewallVersion', $this->get('MessageFirewallVersion'));
			$this->assignRef('validFirewallVersion', $this->get('ValidFirewallVersion'));
			
			parent::display('version');
			
			$this->assignRef('integrityScrollable', $this->get('integrityScrollable'));
			
			parent::display('integrity');
			
			$this->assignRef('filePermissionsScrollable', $this->get('filePermissionsScrollable'));
			$this->assignRef('folderPermissionsScrollable', $this->get('folderPermissionsScrollable'));
			$this->assignRef('filePermissionsResult', $this->get('FilePermissionsResult'));
			$this->assignRef('folderPermissionsResult', $this->get('FolderPermissionsResult'));
			
			parent::display('permissions');
			
			parent::display('patterns');
			
			$this->assignRef('tempIsOutside', $this->get('tempOutsideResult'));
			$this->assignRef('logIsOutside', $this->get('LogOutsideResult'));
			$this->assignRef('tempFiles', $this->get('tempFilesResult'));
			$this->assignRef('configurationIsOk', $this->get('configurationResult'));
			$this->assignRef('configurationIsOutside', $this->get('configurationOutsideResult'));
			
			parent::display('access');
			
			parent::display('php');
			
			$this->assignRef('adminActive', $this->get('adminActive'));
			
			parent::display('users');
			
			if (RSFirewallHelper::getConfig('lockdown'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('master_password_enabled') && RSFirewallHelper::getConfig('master_password'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('backend_password_enabled') && RSFirewallHelper::getConfig('backend_password'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('active_scanner_status'))
				RSFirewallHelper::grade('+10');
			if (RSFirewallHelper::getConfig('verify_dos'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('verify_generator'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('verify_sql'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('verify_php'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('verify_js'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('verify_multiple_exts'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('monitor_core'))
				RSFirewallHelper::grade('+5');
			if (RSFirewallHelper::getConfig('verify_upload'))
				RSFirewallHelper::grade('+5');
			
			$this->assignRef('grade', $this->get('grade'));
			
			parent::display('grade');
			
			RSFirewallHelper::saveGrade();
		}
	}
}