<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

class TableRSFirewall_Feeds extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	var $url = null;

	var $limit = 5;
	
	var $ordering = null;
	
	var $published = 1;
		
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableRSFirewall_Feeds(& $db)
	{
		parent::__construct('#__rsfirewall_feeds', 'id', $db);
	}
}