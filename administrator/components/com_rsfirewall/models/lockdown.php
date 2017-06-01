<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelLockdown extends JModel
{
	var $_log = null;
	
	function __construct()
	{
		parent::__construct();
		$this->_log = new RSFirewallLog();
	}
	
	function lockdown()
	{
		$lockdown = JRequest::getInt('lockdown', 0, 'post');
		if ($lockdown == 0)
		{
			$this->_db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='lockdown'");
			$this->_db->query();
			$level = 'high';
			$code = 'LOCKDOWN_DISABLED';
			$lockdown = false;
		}
		else
		{
			$this->_db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='lockdown'");
			$this->_db->query();
			$level = 'low';
			$code = 'LOCKDOWN_ENABLED';
			
			$this->_db->setQuery("DELETE FROM #__rsfirewall_snapshots WHERE `type`='lockdown'");
			$this->_db->query();
			
			$this->_db->setQuery("SELECT * FROM #__users WHERE `gid` > 22");
			$users = $this->_db->loadObjectList();
			foreach ($users as $user)
			{
				$snapshot = RSFirewallHelper::createSnapshot($user);
				$this->_db->setQuery("INSERT INTO #__rsfirewall_snapshots SET `user_id`='".$user->id."', `snapshot`='".$snapshot."', `type`='lockdown'");
				$this->_db->query();
			}
			$lockdown = true;
		}
		RSFirewallHelper::readConfig();
		$this->_log->addEvent($level, $code);
		
		return $lockdown;
	}
}
?>