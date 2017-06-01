<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewFeeds extends JView
{
	function display($tpl=null)
	{
		JToolBarHelper::title('RSFirewall!','rsfirewall');
		
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_OVERVIEW'), 'index.php?option=com_rsfirewall');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_CHECK'), 'index.php?option=com_rsfirewall&view=check');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOGS'), 'index.php?option=com_rsfirewall&view=logs');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOCKDOWN'), 'index.php?option=com_rsfirewall&view=lockdown');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=configuration');
		JSubMenuHelper::addEntry(JText::_('RSF_FEEDS_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=feeds', true);
		JSubMenuHelper::addEntry(JText::_('RSF_UPDATES'), 'index.php?option=com_rsfirewall&view=updates');
		
		global $mainframe, $option;

		$task = JRequest::getVar('task','');
		
		switch ($task)
		{
			default:
				JToolBarHelper::publishList();
				JToolBarHelper::unpublishList();
				JToolBarHelper::deleteList();
				JToolBarHelper::editListX('editfeed');
				JToolBarHelper::addNewX('editfeed');
		
				$feeds = $this->get('data');
				
				$filter_state = $mainframe->getUserStateFromRequest($option.'.filter_state', 'filter_state');
				$mainframe->setUserState($option.'.filter_state', $filter_state);
				$lists['state']	= JHTML::_('grid.state', $filter_state);
				
				$pagination = $this->get('pagination');
				
				$this->assignRef('data', $feeds);
				$this->assignRef('lists', $lists);
				$this->assignRef('pagination', $pagination);
			break;
			
			case 'editfeed':
				JToolBarHelper::apply();
				JToolBarHelper::save();
				JToolBarHelper::cancel();
				
				$cid = JRequest::getVar('cid', 0);
				if (is_array($cid))
					$cid = $cid[0];
			
				if ($cid > 0)
				{
					$feed = $this->get('feed');
					$filter_state = $feed->published ? 'P' : 'U';
					$lists['state']	= JHTML::_('grid.state', $filter_state);
				}
				else
				{
					$feed = $this->get('feed');
					$filter_state = $feed->published ? 'P' : 'U';
					$lists['state']	= JHTML::_('grid.state', $filter_state);
				}
				
				$this->assignRef('feed', $feed);
				$this->assignRef('lists', $lists);
			break;
		}
		
		parent::display($tpl);
	}
}