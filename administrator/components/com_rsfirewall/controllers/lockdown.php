<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RSFirewallControllerLockdown extends RSFirewallController
{
	function __construct()
	{
		parent::__construct();
	}
	
	function lockdown()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');

		// Get the model
		$model = $this->getModel('lockdown');
		
		// Lockdown
		$locked = $model->lockdown();
		
		// Redirect
		if ($locked == false)
			$this->setRedirect('index.php?option=com_rsfirewall&view=lockdown', JText::_('RSF_LOCKDOWN_DISABLED'));
		else
			$this->setRedirect('index.php?option=com_rsfirewall&view=lockdown', JText::_('RSF_LOCKDOWN_ENABLED'));
	}
}
?>