<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelRSFirewall extends JModel
{	
	function __construct()
	{
		parent::__construct();
	}
	
	function getFeeds()
	{
		$feeds = array();
		$rows = $this->_getList("SELECT * FROM #__rsfirewall_feeds WHERE `published`='1' ORDER BY `ordering` ASC");
		
		foreach ($rows as $row)
			$feeds[] = $this->getFeed($row->url, $row->limit);
			
		return $feeds;
	}
	
	function getFeed($feed_url, $feed_limit)
	{
		$feed_limit = is_numeric($feed_limit) ? $feed_limit : 1;
		$options = array('rssUrl' => $feed_url);

		$rssDoc =& JFactory::getXMLparser('RSS', $options);

		$feed = new stdclass();

		if ($rssDoc != false)
		{
			// channel header and link
			$feed->title = $rssDoc->get_title();
			$feed->link = $rssDoc->get_link();
			$feed->description = $rssDoc->get_description();

			// channel image if exists
			$feed->image->url = $rssDoc->get_image_url();
			
			$feed->image->title = $rssDoc->get_image_title();
			
			// items
			$items = $rssDoc->get_items();

			// feed elements
			$feed->items = array_slice($items, 0, @$feed_limit);
		}
		else
			$feed = false;
		
		return $feed;
	}
	
	function getComponents()
	{
		$rows = $this->_getList("SELECT DISTINCT(`option`) FROM `#__components` WHERE `option` != ''");
		
		$find = array();
		$replace = array();
		foreach ($rows as $row)
		{
			$find[] = $row->option;
			$replace[] = '<strong style="color: red">'.$row->option.'</strong>';
		}
		
		$return = new stdClass();
		$return->find = $find;
		$return->replace = $replace;
		
		return $return;
	}
	
	function getLogs()
	{
		$limit = RSFirewallHelper::getConfig('log_overview');
		return $this->_getList("SELECT * FROM #__rsfirewall_logs ORDER BY `date` DESC LIMIT ".(int) $limit);
	}
	
	function getFiles()
	{
		return $this->_getList("SELECT * FROM #__rsfirewall_hashes WHERE `type`='protect' AND `flag`!=''");
	}
	
	function getPluginEnabled()
	{
		$db =& JFactory::getDBO();
		$db->setQuery("SELECT `published` FROM #__plugins WHERE `element`='rsfirewall' AND `folder`='system'");
		$status = $db->loadResult();
		if ($status != '1')
			return false;
		
		return true;
	}
	
	function getCode()
	{
		$code = RSFirewallHelper::getConfig('global_register_code');
		return $code;
	}
	
	function getGrade()
	{
		$grade = RSFirewallHelper::getConfig('grade');
		return $grade;
	}
}
?>