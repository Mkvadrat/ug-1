<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewLogs extends JView
{
	function display( $tpl = null )
	{
		global $mainframe, $option;
	
		JToolBarHelper::title('RSFirewall!','rsfirewall');
		
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_OVERVIEW'), 'index.php?option=com_rsfirewall');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_CHECK'), 'index.php?option=com_rsfirewall&view=check');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOGS'), 'index.php?option=com_rsfirewall&view=logs', true);
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOCKDOWN'), 'index.php?option=com_rsfirewall&view=lockdown');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=configuration');
		JSubMenuHelper::addEntry(JText::_('RSF_FEEDS_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=feeds');
		JSubMenuHelper::addEntry(JText::_('RSF_UPDATES'), 'index.php?option=com_rsfirewall&view=updates');
		
		JToolBarHelper::custom('emptylog', 'delete', 'delete', JText::_('RSF_EMPTY_LOG'), false, false);
		
		$logs = $this->get('data');
		$this->assignRef('data', $logs);
		
		$pagination = $this->get('pagination');
		$this->assignRef('pagination', $pagination);
		
		$lists['order'] = $mainframe->getUserStateFromRequest($option.'.logs.filter_order', 'filter_order', 'date', 'cmd' );
		$lists['order_Dir'] = $mainframe->getUserStateFromRequest($option.'.logs.filter_order_Dir', 'filter_order_Dir', 'DESC', 'word');
		$this->assignRef('lists', $lists);
		
		$levels = $this->get('alertlevels');
		$this->assignRef('levels', $levels);
		
		$search = $this->get('search');
		$this->assignRef('search', $search);
		
		parent::display($tpl);
	}
}