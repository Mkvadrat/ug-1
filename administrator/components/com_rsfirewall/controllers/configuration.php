<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RSFirewallControllerConfiguration extends RSFirewallController
{
	function __construct()
	{
		parent::__construct();
		$this->registerTask('apply', 'save');
	}
	
	/**
	 * Logic to save feeds
	 */
	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the model
		$model = $this->getModel('configuration');
		
		// Save
		$model->save();
		
		$task = JRequest::getCmd('task');
		if ($task == 'apply')
			$link = 'index.php?option=com_rsfirewall&view=configuration';
		else
			$link = 'index.php?option=com_rsfirewall';
		
		// Redirect
		$this->setRedirect($link, JText::_('RSF_CONFIGURATION_OK'));
	}
	
	function folders()
	{
		JRequest::setVar('view', 'folders');
		parent::display();
	}
}
?>