<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

// Require the base controller
require_once(JPATH_COMPONENT.DS.'controller.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'rsfirewall.php');

// See if this is a request for a specific controller
$controller = JRequest::getCmd('controller');
$controller_exists = false;
switch ($controller)
{
	case 'configuration':
	case 'feeds':
	case 'logs':
	case 'auth':
	case 'lockdown':
		$controller_exists = true;
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
	break;
}

// Create the controller
if ($controller_exists)
{
	$newcontroller = 'RSFirewallController'.$controller;
	$RSFirewallController = new $newcontroller();
}
else
	$RSFirewallController = new RSFirewallController();
	
// Execute the given task
if (!RSFirewallHelper::isMasterLogged())
{
	if (JRequest::getCmd('task') == 'login')
		$RSFirewallController->execute('login');
	else
		$RSFirewallController->execute('auth');
}
else
	$RSFirewallController->execute(JRequest::getCmd('task'));

// Redirect if set
$RSFirewallController->redirect();
?>