<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

define('_RSFIREWALL_VERSION', 'TRYOUT');
define('_RSFIREWALL_VERSION_LONG', '1.0.0');
define('_RSFIREWALL_KEY', 'FW6AL534B2');
define('_RSFIREWALL_PRODUCT', 'RSFirewall!');
define('_RSFIREWALL_COPYRIGHT', '&copy;2007-2009 www.rsjoomla.com');
define('_RSFIREWALL_LICENSE', 'GPL');
define('_RSFIREWALL_MESSAGE', '<p><strong>Please note:</strong><br />
This is a free version of RSFirewall!, you are free (under the GPL license) to use it on any number of websites, but you won\'t get any support or updates from RSJoomla!. <strong>Additionally, this version lacks security features.</strong><br /><strong style="font-size: 13px;"><a href="http://www.rsjoomla.com/joomla-components/joomla-security.html" target="_blank">You can have access to the unlimited features of RSFirewall! by purchasing a subscription here</a></strong></p>');
define('_RSFIREWALL_AUTHOR', '<a href="http://www.rsjoomla.com" target="_blank">www.rsjoomla.com</a>');

class RSFirewallHelper
{
	function readConfig()
	{
		global $mainframe;
		
		$rsfirewall_config = new stdClass();
		
		$db =& JFactory::getDBO();
		$db->setQuery("SELECT * FROM `#__rsfirewall_configuration`");
		$config = $db->loadObjectList();
		foreach ($config as $config_item)
		{
			if ($config_item->name == 'verify_sql_skip' || $config_item->name == 'verify_php_skip' || $config_item->name == 'verify_js_skip' || $config_item->name == 'verify_upload_skip' || $config_item->name == 'monitor_users' || $config_item->name == 'backend_access_users' || $config_item->name == 'backend_access_components')
				$config_item->value = strlen($config_item->value) > 0 ? RSFirewallHelper::explode($config_item->value) : array();
			
			$rsfirewall_config->{$config_item->name} = $config_item->value;
		}

		$mainframe->setUserState('rsfirewall_config', $rsfirewall_config);
	}
	
	function getConfig($name = null)
	{
		global $mainframe;
		$config = $mainframe->getUserState('rsfirewall_config');
		if ($name != null)
		{
			if (isset($config->$name))
				return $config->$name;
			else
				return false;
		}
		else
			return $config;
	}
	
	function genKeyCode()
	{
		global $mainframe;
		$code = RSFirewallHelper::getConfig('global_register_code');
		if ($code === false)
			$code = '';
		return md5($code._RSFIREWALL_KEY);
	}
	
	function isMasterLogged()
	{
		return true;
	}
	
	function getLatestJoomlaVersion()
	{
		$url = 'http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=version&version=joomla';
		return RSFirewallHelper::fopen($url);
	}
	
	function getCurrentJoomlaVersion()
	{
		$jversion = new JVersion();
		return $jversion->getShortVersion();
	}
	
	function getLatestFirewallVersion()
	{
		$url = 'http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=version&version=firewall';
		return RSFirewallHelper::fopen($url);
	}
	
	function getCurrentFirewallVersion()
	{
		return _RSFIREWALL_VERSION;
	}
	
	function version_compare($current, $latest)
	{
		return version_compare($current, $latest, '>=');
	}
	
	function grade($amount)
	{
		global $mainframe;
		$grade = $mainframe->getUserState('grade', '0');
		$grade += $amount;
		$mainframe->setUserState('grade', $grade);
	}
	
	function saveGrade()
	{
		global $mainframe;
		$grade = $mainframe->getUserState('grade', '0');
		$grade = RSFirewallHelper::convertGrade($grade);
		
		$db = JFactory::getDBO();
		$db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".$grade."' WHERE `name`='grade' LIMIT 1");
		$db->query();
	}
	
	function getGrade()
	{
		global $mainframe;
		return $mainframe->getUserState('grade', '0');
	}
	
	function convertGrade($grade)
	{
		$maxgrade = 212;
		$grade = floor(99*$grade/$maxgrade);
		return $grade;
	}
	
	function explode($what)
	{
		$what = str_replace("\r\n", "\n", $what);
		return explode("\n", $what);
	}
	
	function getUsersSnapshot($type='protect')
	{
		$db =& JFactory::getDBO();
		$type = $db->getEscaped($type);
		$db->setQuery("SELECT * FROM #__rsfirewall_snapshots WHERE `type`='".$type."'");
		$result = $db->loadObjectList();
		$return = array();
		
		foreach ($result as $user)
			$return[$user->user_id] = unserialize(base64_decode($user->snapshot));
		
		return $return;
	}
	
	function createSnapshot($user)
	{
		$snapshot = new stdClass();
		$snapshot->user_id = $user->id;
		$snapshot->name = $user->name;
		$snapshot->username = $user->username;
		$snapshot->email = $user->email;
		$snapshot->password = $user->password;
		$snapshot->usertype = $user->usertype;
		$snapshot->block = $user->block;
		$snapshot->sendEmail = $user->sendEmail;
		$snapshot->gid = $user->gid;
		$snapshot->params = $user->params;
		
		$snapshot = base64_encode(serialize($snapshot));
		
		return $snapshot;
	}
	
	function checkLogHistory()
	{
		return true;
	}	
	
	function getProtectedFiles()
	{
		$db =& JFactory::getDBO();
		$db->setQuery("SELECT * FROM #__rsfirewall_hashes WHERE `type`='protect'");
		$db->query();
		return $db->loadObjectList();
	}
	
	function recursive($array)
	{
		$return = array();
		if (is_array($array))
			foreach ($array as $item)
				$return[] = RSFirewallHelper::recursive($item);
		else
			$return = $array;
		
		return $return;
	}
	
	function header($code=200, $msg='')
	{
		switch ($code)
		{
			case 200:
			header('HTTP/1.1 200 OK');
			echo $code;
			break;
			
			case 301:
			header('HTTP/1.1 301 Moved Permanently');
			echo $code;
			break;
			
			case 500:
			header('HTTP/1.1 500 Internal Server Error');
			echo $code;
			break;
			
			case 403:
			header('HTTP/1.1 403 Forbidden');
			include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'assets'.DS.'headers'.DS.$code.'.php');
			break;
			
			case 404:
			header('HTTP/1.1 404 Not Found');
			echo $code;
			break;
		}
		die();
	}
	
	function getAlertLevelsArray()
	{
		return array('low', 'medium', 'high', 'critical');
	}
	
	function getAlertLevels()
	{
		$levels = array();
		
		$level = new stdClass();
		$level->value = 'low';
		$level->text = JText::_('RSF_LOW');
		$levels[] = $level;
		
		$level = new stdClass();
		$level->value = 'medium';
		$level->text = JText::_('RSF_MEDIUM');
		$levels[] = $level;
		
		$level = new stdClass();
		$level->value = 'high';
		$level->text = JText::_('RSF_HIGH');
		$levels[] = $level;
		
		$level = new stdClass();
		$level->value = 'critical';
		$level->text = JText::_('RSF_CRITICAL');
		$levels[] = $level;
		
		return $levels;
	}
	
	function is_ip($ip)
	{
		if (strpos($ip, '*') !== false)
		{
			$ip = explode('.', $ip);
			if (count($ip) != 4) return false;
			foreach ($ip as $i => $part)
			{
				if ($part == '*' || strpos($part, '*') !== false)
				{
					$ip[$i] = '*';
					continue;
				}
				if ($part < 0 || $part > 255)
					return false;
			}
			return true;
		}
		else
		{
			$pattern = '/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/';
			return (preg_match($pattern, $ip) == 1);
		}
	}
	
	function ip_in($needle, $haystack)
	{
		if ($needle == $haystack) return true;
		if (strpos($haystack, '*') === false) return false;
		
		$haystack = explode('.', $haystack);
		$needle = explode('.', $needle);
		
		foreach ($haystack as $i => $fragment)
			if ($fragment != '*' && $fragment != $needle[$i])
				return false;
		
		return true;
	}
	
	function is_email($email)
	{
		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
			return false;
			
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++)
			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
				return false;
		
		if (RSFirewallHelper::is_ip($email_array[1]))
			return true;
		
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
		{
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2)
				return false;
				
			for ($i = 0; $i < sizeof($domain_array); $i++)
				if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
					return false;
		}
		return true;
	}
	
	/**
	 * Open a connection through several methods
	 */
	 function fopen($url)
	 {
		$url_info = parse_url($url);
		
		$data = false;

		// cURL
		if (extension_loaded('curl'))
		{
			// Init cURL
			$ch = @curl_init();
			
			// Set options
			@curl_setopt($ch, CURLOPT_URL, $url);
			@curl_setopt($ch, CURLOPT_HEADER, 0);
			@curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			// Set timeout
			@curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			
			// Grab data
			$data = @curl_exec($ch);
			
			// Clean up
			@curl_close($ch);
			
			// Return data
			if ($data !== false)
				return $data;
		}

		// fsockopen
		if (function_exists('fsockopen'))
		{
			$errno = 0;
			$errstr = '';

			// Set timeout
			$fsock = @fsockopen($url_info['host'], 80, $errno, $errstr, 5);
		
			if ($fsock)
			{
				@fputs($fsock, 'GET '.$url_info['path'].(!empty($url_info['query']) ? '?'.$url_info['query'] : '').' HTTP/1.1'."\r\n");
				@fputs($fsock, 'HOST: '.$url_info['host']."\r\n");
				@fputs($fsock, 'Connection: close'."\r\n\r\n");
        
				// Set timeout
				@stream_set_blocking($fsock, 1);
				@stream_set_timeout($fsock, 5);
				
				$data = '';
				$passed_header = false;
				while (!@feof($fsock))
				{
					if ($passed_header)
						$data .= @fread($fsock, 1024);
					else
					{
						if (@fgets($fsock, 1024) == "\r\n")
							$passed_header = true;
					}
				}
				
				// Clean up
				@fclose($fsock);
				
				// Return data
				if ($data !== false)
					return $data;
			}
		}

	 	// fopen
		if (function_exists('fopen') && ini_get('allow_url_fopen'))
		{
			// Set timeout
			if (ini_get('default_socket_timeout') < 5)
				ini_set('default_socket_timeout', 5);
			@stream_set_blocking($handle, 1);
			@stream_set_timeout($handle, 5);
			
			$handle = @fopen ($url, 'r');
			
			if ($handle)
			{
				$data = '';
				while (!feof($handle))
					$data .= @fread($handle, 8192);
			
				// Clean up
				@fclose($handle);
			
				// Return data
				if ($data !== false)
					return $data;
			}
		}
						
		// file_get_contents
		if(function_exists('file_get_contents') && ini_get('allow_url_fopen'))
		{
			$data = @file_get_contents($url);
			
			// Return data
			if ($data !== false)
				return $data;
		}
		
		return $data;
	 }
}

class RSFirewallLog
{
	var $_db = null;
	var $_emails = null;
	var $level = 'low';
	var $date = null;
	var $ip = null;
	var $userid = 0;
	var $username = null;
	var $page = null;
	var $code = 1;
	var $debug_variables = null;
	
	var $mailfrom = null;
	var $fromname = null;
	
	var $config = null;
	
	var $root = null;
	
	function RSFirewallLog()
	{
		global $mainframe;
		// Create the JDatabase Object
		$this->_db =& JFactory::getDBO();
		
		// Get emails to be notified
		$this->config = RSFirewallHelper::getConfig();
		$this->_emails = explode("\n",$this->config->log_emails);
		
		// Set current time in unix format
		$this->date = time();
		
		// Set the client's IP address
		$this->ip = $_SERVER['REMOTE_ADDR'];
		
		// Set the current user's id
		$user =& JFactory::getUser();
		$this->userid = $user->id;
		
		$this->username = $user->username;
		
		// Set the current page
		$this->page = JRequest::getURI();
		
		$jconfig = new JConfig();
		
		$this->mailfrom = $jconfig->mailfrom;
		$this->fromname = $jconfig->fromname;
		
		$this->root = JURI::root();
	}
	
	function addEvent($level='low', $code=1, $debug_variables=null)
	{
		return 1;
	}
	
	function saveEvent()
	{
		return 1;
	}
}

class RSFirewallMerger
{
	var $_array = array();
	
	function __construct($array)
	{
		$this->recursive($array);
	}
	
	function recursive($array)
	{
		if (is_array($array))
			foreach ($array as $item)
				$this->recursive($item);
		else
			$this->_array[] = $array;
	}
	
	function getArray()
	{
		return $this->_array;
	}
}
?>