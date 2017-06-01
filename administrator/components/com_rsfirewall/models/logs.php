<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelLogs extends JModel
{
	var $_query = '';
	var $_where = '';
	var $_order = '';
	var $_pagination = null;
	var $filter_order = null;
	var $filter_order_Dir = null;
	var $limit = null;
	var $limitstart = null;
	
	function __construct()
	{
		parent::__construct();
		
		RSFirewallHelper::checkLogHistory();
		
		global $mainframe, $option;
		
		$this->filter_order = $mainframe->getUserStateFromRequest($option.'.logs.filter_order', 'filter_order', 'date', 'cmd' );
		$this->filter_order_Dir = $mainframe->getUserStateFromRequest($option.'.logs.filter_order_Dir', 'filter_order_Dir', 'DESC', 'word');
		
		$this->limit = $mainframe->getUserStateFromRequest($option.'.logs.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$this->limitstart = $mainframe->getUserStateFromRequest($option.'.logs.limitstart', 'limitstart', 0, 'int' );
		
		$this->_query = $this->_buildQuery();
	}
	
	function _buildWhere()
	{
		$search = $this->getSearch();
		$where = '';
		if (count($search['search_level']) > 0 && count($search['search_level']) != 4)
		{
			$levels = $this->getAlertLevelsArray();
			foreach ($search['search_level'] as $i => $search_level)
				if (array_search($search_level, $levels) === false)
					unset($search['search_level'][$i]);
			if (count($search['search_level']) > 0)
				$where .= " AND `level` IN ('".implode("','", $search['search_level'])."')";
		}
		
		if (!empty($search['search_date_start']))
			$where .= " AND `date` >= '".strtotime($search['search_date_start'])."'";
		
		if (!empty($search['search_date_stop']))
			$where .= " AND `date` <= '".strtotime($search['search_date_stop'])."'";
		
		if (!empty($search['search_ip']) && RSFirewallHelper::is_ip($search['search_ip']))
			$where .= " AND `ip` = '".$this->_db->getEscaped($search['search_ip'])."'";
		
		if (!empty($search['search_userid']))
			$where .= " AND `userid`='".(int) $search['search_userid']."'";
		
		if (!empty($search['search_username']))
			$where .= " AND `username` LIKE '%".$this->_db->getEscaped($search['search_username'])."%'";

		if (!empty($search['search_page']))
			$where .= " AND `page` LIKE '%".$this->_db->getEscaped($search['search_page'])."%'";
		
		return $where;
	}
	
	function _buildOrder()
	{
		$order = " ORDER BY `".$this->filter_order."` ".$this->filter_order_Dir;
		return $order;
	}
	
	function _buildLimit()
	{
		$limit = '';
		if ($this->limit > 0)
			$limit = " LIMIT ".$this->limitstart.",".$this->limit;
		return $limit;
	}
	
	function _buildQuery()
	{
		$this->_where = $this->_buildWhere();
		$this->_order = $this->_buildOrder();
		$this->_limit = $this->_buildLimit();
		$query = "SELECT * FROM #__rsfirewall_logs WHERE 1 ".$this->_where.$this->_order.$this->_limit;
		return $query;
	}
	
	function _buildTotalQuery()
	{
		$query = "SELECT `id` FROM #__rsfirewall_logs WHERE 1 ".$this->_where;
		return $query;
	}
	
	function getData()
	{
		return $this->_getList($this->_query);
	}
	
	function getPagination()
	{
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->limitstart, $this->limit);
		}
		
		return $this->_pagination;
	}
	
	function getTotal()
	{
		$this->_query = $this->_buildTotalQuery();
		return $this->_getListCount($this->_query);
	}
	
	function getSearch()
	{
		global $mainframe, $option;
		$return = array();
		$return['search_level'] = $mainframe->getUserStateFromRequest($option.'.logs.search_level', 'search_level', RSFirewallHelper::getAlertLevelsArray(), 'array');
		$return['search_date_start'] = $mainframe->getUserStateFromRequest($option.'.logs.search_date_start', 'search_date_start', '', 'date');
		$return['search_date_stop'] = $mainframe->getUserStateFromRequest($option.'.logs.search_date_stop', 'search_date_stop', '', 'date');
		$return['search_ip'] = $mainframe->getUserStateFromRequest($option.'.logs.search_ip', 'search_ip', '', 'cmd');
		$return['search_userid'] = $mainframe->getUserStateFromRequest($option.'.logs.search_userid', 'search_userid', '', 'int');
		$return['search_username'] = $mainframe->getUserStateFromRequest($option.'.logs.search_username', 'search_username', '');
		$return['search_page'] = $mainframe->getUserStateFromRequest($option.'.logs.search_page', 'search_page', '');
		
		return $return;
	}
	
	function getAlertLevels()
	{
		return RSFirewallHelper::getAlertLevels();
	}
	
	function getAlertLevelsArray()
	{
		return RSFirewallHelper::getAlertLevelsArray();
	}
	
	function emptyLog()
	{
		$this->_db->setQuery("TRUNCATE TABLE #__rsfirewall_logs");
		$this->_db->query();
		
		$log = new RSFirewallLog();
		$log->addEvent('critical', 'LOG_EMPTIED');
	}
}
?>