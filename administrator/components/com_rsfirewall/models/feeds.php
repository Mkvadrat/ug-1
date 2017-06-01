<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelFeeds extends JModel
{
	var $_total = 0;
	var $_query = '';
	var $_pagination = null;
	var $_db = null;
	
	function __construct()
	{
		parent::__construct();
		$this->_query = $this->_buildQuery();
		$this->_db =& JFactory::getDBO();
	}
	
	function _buildQuery()
	{
		global $mainframe;
		
		$query = "SELECT * FROM #__rsfirewall_feeds";
		
		$filter_state = $mainframe->getUserStateFromRequest('rsfirewall_filter_state', 'filter_state');
		if ($filter_state != '')
			$query .= " WHERE `published`='".($filter_state == 'U' ? '0' : '1')."'";
			
		$query .= " ORDER BY `ordering` ASC";
		
		return $query;
	}
	
	function getData()
	{
		return $this->_getList($this->_query);
	}
	
	function getTotal()
	{
		if (empty($this->_total))
			$this->_total = $this->_getListCount($this->_query); 
		
		return $this->_total;
	}
	
	function getPagination()
	{
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
		}
		
		return $this->_pagination;
	}
	
	function getFeed()
	{
		$cid = JRequest::getVar('cid', 0);
		
		// Get only one feed at a time
		if (is_array($cid))
			$cid = $cid[0];
			
		$feed =& JTable::getInstance('RSFirewall_Feeds','Table');
		$feed->load((int) $cid);
		
		return $feed;
	}
	
	function publish($cid=array(), $publish=1)
	{
		if (!is_array($cid) || count($cid) > 0)
		{
			$publish = (int) $publish;
			$cids = implode(',', $cid);

			$query = "UPDATE #__rsfirewall_feeds SET `published`='".$publish."' WHERE `id` IN (".$cids.")"	;
			$this->_db->setQuery($query);
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return $cid;
	}
	
	function remove($cids)
	{
		$cids = implode(',', $cids);

		$query = "DELETE FROM #__rsfirewall_feeds WHERE `id` IN (".$cids.")";
		$this->_db->setQuery($query);
		$this->_db->query();
		
		return true;
	}
	
	function save()
	{	
		$cid = JRequest::getVar('cid', '0');
		$feed =& JTable::getInstance('RSFirewall_Feeds','Table');
		$post = JRequest::get('post');
				
		$msg = '';
		$link = '';
		
		if (!$feed->bind($post))
			return JError::raiseWarning(500, $feed->getError());
		
		$feed->ordering = $feed->getNextOrder();
		
		if ($feed->store())
			$msg = JText::_('RSF_FEED_SAVED_OK');
		else
		{
			JError::raiseWarning(500, $feed->getError());
			$msg = JText::_('RSF_FEED_SAVED_ERROR');
		}
		
		$task = JRequest::getCmd('task');
		switch($task)
		{
			case 'apply':
				$link = 'index.php?option=com_rsfirewall&controller=feeds&task=editfeed&cid[]='.$feed->id;
			break;
		
			case 'save':
				$link = 'index.php?option=com_rsfirewall&view=feeds';
			break;
		}
		
		return array('link' => $link, 'msg' => $msg);
	}
}
?>