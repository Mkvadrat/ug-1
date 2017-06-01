<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RSFirewallControllerAuth extends RSFirewallController
{
	function __construct()
	{
		parent::__construct();
	}
	
	function login()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the model
		$model = $this->getModel('auth');
		
		// Login
		$logged = $model->login();
		
		// Redirect
		if ($logged == false)
		{
			JError::raiseWarning(500, JText::_('RSF_LOGIN_ERROR'));
			$this->setRedirect('index.php?option=com_rsfirewall&view=auth&controller=auth');
		}
		else
			$this->setRedirect('index.php?option=com_rsfirewall', JText::_('RSF_LOGIN_OK'));
	}
}
?>