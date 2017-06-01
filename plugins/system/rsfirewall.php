<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.plugin.plugin');

require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_rsfirewall'.DS.'helpers'.DS.'rsfirewall.php');

class plgSystemRSFirewall extends JPlugin {
	
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @since 1.5
	 */
	function plgSystemRSFirewall(&$subject, $config) {
		parent::__construct($subject, $config);
		RSFirewallHelper::readConfig();
	}
	
	function onAfterInitialise()
	{
		return 1;
	}
	
	function onAfterDispatch()
	{
		return 1;
	}
}