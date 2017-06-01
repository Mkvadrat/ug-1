<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelAuth extends JModel
{
	var $_log = null;
	
	function __construct()
	{
		parent::__construct();
		$this->_log = new RSFirewallLog();
	}
	
	function login()
	{
		global $mainframe;
		
		$pass = JRequest::getVar('master_password', '', 'post');
		$logged = md5($pass) == RSFirewallHelper::getConfig('master_password');
		
		if ($logged == true)
		{
			$mainframe->setUserState('rsfirewall_master_logged', true);
			$level = 'low';
			$code = 'MASTER_LOGIN_OK';
		}
		else
		{
			$mainframe->setUserState('rsfirewall_master_logged', false);
			$level = 'medium';
			$code = 'MASTER_LOGIN_ERROR';
		}
		$this->_log->addEvent($level, $code);
		
		return $logged;
	}
}
?>