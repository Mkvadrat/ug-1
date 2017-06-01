<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RSFirewallControllerLogs extends RSFirewallController
{
	function __construct()
	{
		parent::__construct();
	}
	
	function emptyLog()
	{
		$model = $this->getModel('logs');
		$model->emptyLog();
		
		$this->setRedirect('index.php?option=com_rsfirewall&view=logs', JText::_('RSF_LOG_EMPTIED'));
	}
}
?>