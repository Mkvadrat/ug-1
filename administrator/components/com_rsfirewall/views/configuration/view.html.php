<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pane');

class RSFirewallViewConfiguration extends JView
{
	function display( $tpl = null )
	{
		global $mainframe;
	
		JToolBarHelper::title('RSFirewall!','rsfirewall');
		
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_OVERVIEW'), 'index.php?option=com_rsfirewall');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_CHECK'), 'index.php?option=com_rsfirewall&view=check');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOGS'), 'index.php?option=com_rsfirewall&view=logs');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOCKDOWN'), 'index.php?option=com_rsfirewall&view=lockdown');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=configuration', true);
		JSubMenuHelper::addEntry(JText::_('RSF_FEEDS_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=feeds');
		JSubMenuHelper::addEntry(JText::_('RSF_UPDATES'), 'index.php?option=com_rsfirewall&view=updates');
		
		JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		
		$config = RSFirewallHelper::getConfig();
		$this->assignRef('config', $config);
		
		$levels = $this->get('alertlevels');
		$this->assignRef('levels', $levels);
		
		$users = $this->get('users');
		$this->assignRef('users', $users);
		
		$components = $this->get('components');
		$this->assignRef('components', $components);
		
		$pane =& JPane::getInstance('Tabs', array(), true);
		$this->assignRef('pane', $pane);
		
		parent::display($tpl);
	}
}