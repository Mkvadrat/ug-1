<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RSFirewallController extends JController
{
	var $_db;
	
	function __construct()
	{
		parent::__construct();
		$document =& JFactory::getDocument();
		// Add the css stylesheet
		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_rsfirewall/assets/css/rsfirewall.css');
		// Add the rsfirewall js
		$document->addScript(JURI::root(true).'/administrator/components/com_rsfirewall/assets/js/rsfirewall.js');
		
		// Set the database object
		$this->_db =& JFactory::getDBO();
		
		RSFirewallHelper::readConfig();
	}
	
	/**
	 * Display the view
	 */
	function display()
	{
		parent::display();
	}
	
	/**
	 * Display "System Check"
	 */
	function check()
	{
		JRequest::setVar('view', 'check');
		parent::display();
	}
	
	/**
	 * Display "Firewall Configuration"
	 */
	function configuration()
	{
		JRequest::setVar('view', 'configuration');
		parent::display();
	}
	
	/**
	 * Display "System Logs"
	 */
	function logs()
	{
		JRequest::setVar('view', 'logs');
		parent::display();
	}
	
	/**
	 * Display "System Lockdown"
	 */
	function lockdown()
	{
		JRequest::setVar('view', 'lockdown');
		parent::display();
	}
	
	/**
	 * Display "Feed Configuration"
	 */
	function feeds()
	{
		JRequest::setVar('view', 'feeds');
		parent::display();
	}
	
	function auth()
	{
		JRequest::setVar('view', 'auth');
		parent::display();
	}
	
	function acceptHash()
	{
		$cid = JRequest::getInt('cid');
		if ($cid == 0) return;
		
		jimport('joomla.filesystem.file');
		
		$this->_db->setQuery("SELECT * FROM #__rsfirewall_hashes WHERE `id`='".$cid."' AND `flag` != ''");
		$this->_db->query();
		$hash = $this->_db->loadObject();
		
		if (JFile::exists($hash->file))
		{
			$curr_hash = md5_file($hash->file);
			$this->_db->setQuery("UPDATE #__rsfirewall_hashes SET `flag`='', `hash`='".$curr_hash."' WHERE `id`='".$cid."' LIMIT 1");
			$this->_db->query();
		}
		$this->setRedirect('index.php?option=com_rsfirewall', JText::_('RSF_HASH_CHANGED_SUCCESS'));
	}
	
	function fix()
	{
		JRequest::setVar('view', 'fix');
		JRequest::setVar('tmpl', 'component');
		parent::display();
	}
	
	function saveRegistration()
	{
		$code = JRequest::getVar('global_register_code');
		$code = $this->_db->getEscaped($code);
		if (!empty($code))
		{
			$this->_db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".$code."' WHERE `name`='global_register_code'");
			$this->_db->query();

			$this->setRedirect('index.php?option=com_rsfirewall&view=updates', JText::_('RSF_LICENSE_SAVED'));
		}
		else
		{
			$this->setRedirect('index.php?option=com_rsfirewall&view=configuration');
		}
	}
}
?>