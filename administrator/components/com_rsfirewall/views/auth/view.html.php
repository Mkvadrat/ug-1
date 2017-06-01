<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewAuth extends JView
{
	function display( $tpl = null )
	{
		JToolBarHelper::title('RSFirewall!','rsfirewall');
		
		parent::display($tpl);
	}
}