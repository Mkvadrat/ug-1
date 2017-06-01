<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewRSFirewall extends JView
{
	function display($tpl = null)
	{		
		JToolBarHelper::title('RSFirewall!','rsfirewall');
		
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_OVERVIEW'), 'index.php?option=com_rsfirewall', true);
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_CHECK'), 'index.php?option=com_rsfirewall&view=check');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOGS'), 'index.php?option=com_rsfirewall&view=logs');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOCKDOWN'), 'index.php?option=com_rsfirewall&view=lockdown');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=configuration');
		JSubMenuHelper::addEntry(JText::_('RSF_FEEDS_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=feeds');
		JSubMenuHelper::addEntry(JText::_('RSF_UPDATES'), 'index.php?option=com_rsfirewall&view=updates');
		
		$this->assignRef('pluginEnabled', $this->get('pluginEnabled'));
		
		$this->assignRef('grade', $this->get('grade'));
		
		parent::display($tpl);
		
		$this->assignRef('logs', $this->get('logs'));
		parent::display('logs');
		
		$this->assignRef('files', $this->get('files'));
		parent::display('files');
		
		$this->assignRef('components',$this->get('components'));
		$this->assignRef('feeds',$this->get('feeds'));
		
		parent::display('feeds');
		
		$this->assignRef('code', $this->get('code'));
		
		parent::display('version');
	}
}