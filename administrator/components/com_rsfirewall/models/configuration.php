<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelConfiguration extends JModel
{
	var $_log = null;
	
	function __construct()
	{
		parent::__construct();
		$this->_log = new RSFirewallLog();
	}
	
	function getAlertLevels()
	{
		return RSFirewallHelper::getAlertLevels();
	}
	
	function getAlertLevelsArray()
	{
		return RSFirewallHelper::getAlertLevelsArray();
	}
	
	function getConfiguration()
	{
		return RSFirewallHelper::getConfig();
	}
	
	function getUsers()
	{
		$query = "SELECT id, username FROM #__users WHERE gid > 22 ORDER BY username ASC";
		
		return $this->_getList($query);
	}
	
	function getComponents()
	{
		$query = "SELECT DISTINCT(`option`) FROM #__components WHERE `option`!='' ORDER BY `option` ASC";
		
		return $this->_getList($query);
	}
	
	function getModules()
	{
		$query = "SELECT DISTINCT(module) FROM #__modules ORDER BY module ASC";
		
		return $this->_getList($query);
	}
	
	function getPlugins()
	{
		$query = "SELECT element, folder FROM #__plugins ORDER BY folder ASC";
		
		return $this->_getList($query);
	}
	
	function save()
	{
		global $mainframe;
		$msg = '';
		$link = '';
		$config = RSFirewallHelper::getConfig();
		
		$post = JRequest::get('post');
		if (isset($post['master_password_enabled']))
		{
			if ($post['master_password_enabled'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='master_password_enabled'";
				$level = 'high';
				$code = 'MASTER_PASSWORD_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='master_password_enabled'";
				$level = 'low';
				$code = 'MASTER_PASSWORD_ENABLED';
			}
			
			if ($post['master_password_enabled'] != $config->master_password_enabled)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['master_password']))
		{
			if (strlen($post['master_password']) > 0 && strlen($post['master_password']) < 6)
				JError::raiseWarning(500, JText::_('RSF_MASTER_PASSWORD_ERROR'));
				
			if (strlen($post['master_password']) >= 6 && md5($post['master_password']) != $config->master_password)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".md5($post['master_password'])."' WHERE `name`='master_password'";
				$level = 'high';
				$code = 'MASTER_PASSWORD_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['global_register_code']))
		{
			$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['global_register_code']."' WHERE `name`='global_register_code'";
			$this->_db->setQuery($query);
			$this->_db->query();
		}
		
		if (isset($post['blacklist_ips']))
		{
			$blacklist_ips = explode("\n", $post['blacklist_ips']);
			foreach ($blacklist_ips as $i => $ip)
			{
				$ip = trim($ip);
				if (!RSFirewallHelper::is_ip($ip))
					unset($blacklist_ips[$i]);
			}
			
			$post['blacklist_ips'] = implode("\n", $blacklist_ips);
			$post['blacklist_ips'] = $this->_db->getEscaped($post['blacklist_ips']);
			$config->blacklist_ips = $this->_db->getEscaped($config->blacklist_ips);
			if ($post['blacklist_ips'] != $config->blacklist_ips)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['blacklist_ips']."' WHERE `name`='blacklist_ips'";
				$level = 'low';
				$code = 'BLACKLIST_UPDATED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['active_scanner_status']))
		{
			if ($post['active_scanner_status'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='active_scanner_status'";
				$level = 'high';
				$code = 'ACTIVE_SCANNER_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='active_scanner_status'";
				$level = 'low';
				$code = 'ACTIVE_SCANNER_ENABLED';
			}
			
			if ($post['active_scanner_status'] != $config->active_scanner_status)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_generator']))
		{
			if ($post['verify_generator'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_generator'";
				$level = 'low';
				$code = 'VERIFY_GENERATOR_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_generator'";
				$level = 'low';
				$code = 'VERIFY_GENERATOR_ENABLED';
			}
			
			if ($post['verify_generator'] != $config->verify_generator)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_dos']))
		{
			if ($post['verify_dos'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_dos'";
				$level = 'medium';
				$code = 'VERIFY_DOS_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_dos'";
				$level = 'low';
				$code = 'VERIFY_DOS_ENABLED';
			}
			
			if ($post['verify_dos'] != $config->verify_dos)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_sql']))
		{
			if ($post['verify_sql'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_sql'";
				$level = 'medium';
				$code = 'VERIFY_SQL_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_sql'";
				$level = 'low';
				$code = 'VERIFY_SQL_ENABLED';
			}
			
			if ($post['verify_sql'] != $config->verify_sql)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_sql_skip']))
		{
			$verify_sql_skip = implode("\n",$post['verify_sql_skip']);
			$verify_sql_skip = $this->_db->getEscaped($verify_sql_skip);
			
			$config->verify_sql_skip = implode("\n", $config->verify_sql_skip);
			$config->verify_sql_skip = $this->_db->getEscaped($config->verify_sql_skip);
			
			if ($verify_sql_skip != $config->verify_sql_skip)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$verify_sql_skip."' WHERE `name`='verify_sql_skip'";
				$level = 'high';
				$code = 'VERIFY_SQL_SKIP_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_php']))
		{
			if ($post['verify_php'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_php'";
				$level = 'medium';
				$code = 'VERIFY_PHP_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_php'";
				$level = 'low';
				$code = 'VERIFY_PHP_ENABLED';
			}
			
			if ($post['verify_php'] != $config->verify_php)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_php_skip']))
		{
			$verify_php_skip = implode("\n",$post['verify_php_skip']);
			$verify_php_skip = $this->_db->getEscaped($verify_php_skip);
			
			$config->verify_php_skip = implode("\n", $config->verify_php_skip);
			$config->verify_php_skip = $this->_db->getEscaped($config->verify_php_skip);
			
			if ($verify_php_skip != $config->verify_php_skip)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$verify_php_skip."' WHERE `name`='verify_php_skip'";
				$level = 'high';
				$code = 'VERIFY_PHP_SKIP_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_js']))
		{
			if ($post['verify_js'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_js'";
				$level = 'medium';
				$code = 'VERIFY_JS_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_js'";
				$level = 'low';
				$code = 'VERIFY_JS_ENABLED';
			}
			
			if ($post['verify_js'] != $config->verify_js)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_js_skip']))
		{
			$verify_js_skip = implode("\n",$post['verify_js_skip']);
			$verify_js_skip = $this->_db->getEscaped($verify_js_skip);
			
			$config->verify_js_skip = implode("\n", $config->verify_js_skip);
			$config->verify_js_skip = $this->_db->getEscaped($config->verify_js_skip);
			
			if ($verify_js_skip != $config->verify_js_skip)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$verify_js_skip."' WHERE `name`='verify_js_skip'";
				$level = 'high';
				$code = 'VERIFY_JS_SKIP_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_multiple_exts']))
		{
			if ($post['verify_multiple_exts'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_multiple_exts'";
				$level = 'medium';
				$code = 'VERIFY_MULTIPLE_EXTS_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_multiple_exts'";
				$level = 'low';
				$code = 'VERIFY_MULTIPLE_EXTS_ENABLED';
			}
			
			if ($post['verify_multiple_exts'] != $config->verify_multiple_exts)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_upload']))
		{
			if ($post['verify_upload'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='verify_upload'";
				$level = 'medium';
				$code = 'VERIFY_UPLOAD_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='verify_upload'";
				$level = 'low';
				$code = 'VERIFY_UPLOAD_ENABLED';
			}
			
			if ($post['verify_upload'] != $config->verify_upload)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['verify_upload_blacklist_exts']))
		{
			$post['verify_upload_blacklist_exts'] = $this->_db->getEscaped($post['verify_upload_blacklist_exts']);
			$config->verify_upload_blacklist_exts = $this->_db->getEscaped($config->verify_upload_blacklist_exts);
			
			if ($post['verify_upload_blacklist_exts'] != $config->verify_upload_blacklist_exts)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['verify_upload_blacklist_exts']."' WHERE `name`='verify_upload_blacklist_exts'";
				$level = 'medium';
				$code = 'VERIFY_EXTENSIONS_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['monitor_core']))
		{
			if ($post['monitor_core'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='monitor_core'";
				$level = 'medium';
				$code = 'MONITOR_CORE_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='monitor_core'";
				$level = 'low';
				$code = 'MONITOR_CORE_ENABLED';
			}
			
			if ($post['monitor_core'] != $config->monitor_core)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['monitor_files']))
		{
			$monitor_files = explode("\n", $post['monitor_files']);
			foreach ($monitor_files as $i => $file)
			{
				$file = trim($file);
				if (!file_exists($file))
					unset($monitor_files[$i]);
				else
				{
					$query = "SELECT `id` FROM #__rsfirewall_hashes WHERE `file`='".$this->_db->getEscaped($file)."'";
					$this->_db->setQuery($query);
					$this->_db->query();
					if ($this->_db->getNumRows() == 0)
					{
						$query = "INSERT INTO #__rsfirewall_hashes SET `file`='".$this->_db->getEscaped($file)."', `hash`='".md5_file($file)."', `type`='protect'";
						$this->_db->setQuery($query);
						$this->_db->query();
					}
				}
			}
			
			$post['monitor_files'] = implode("\n", $monitor_files);
			$post['monitor_files'] = $this->_db->getEscaped($post['monitor_files']);
			$config->monitor_files = $this->_db->getEscaped($config->monitor_files);
			if ($post['monitor_files'] != $config->monitor_files)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['monitor_files']."' WHERE `name`='monitor_files'";
				$level = 'medium';
				$code = 'MONITOR_FILES_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['monitor_users']))
		{
			JArrayHelper::toInteger($post['monitor_users']);
			
			$monitor_users = implode("\n",$post['monitor_users']);
			$monitor_users = $this->_db->getEscaped($monitor_users);
			
			$config->monitor_users = implode("\n", $config->monitor_users);
			$config->monitor_users = $this->_db->getEscaped($config->monitor_users);
			
			if ($monitor_users != $config->monitor_users)
			{
				$this->_db->setQuery("DELETE FROM #__rsfirewall_snapshots WHERE `type`='protect'");
				$this->_db->query();
				
				foreach ($post['monitor_users'] as $user_id)
				{
					$user = JUser::getInstance($user_id);
					$snapshot = RSFirewallHelper::createSnapshot($user);
					$this->_db->setQuery("INSERT INTO #__rsfirewall_snapshots SET `user_id`='".$user_id."', `snapshot`='".$snapshot."', `type`='protect'");
					$this->_db->query();
				}
					
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$monitor_users."' WHERE `name`='monitor_users'";
				$level = 'medium';
				$code = 'MONITOR_USERS_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['backend_access_control_enabled']))
		{
			if ($post['backend_access_control_enabled'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='backend_access_control_enabled'";
				$level = 'medium';
				$code = 'BACKEND_ACCESS_CONTROL_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='backend_access_control_enabled'";
				$level = 'low';
				$code = 'BACKEND_ACCESS_CONTROL_ENABLED';
			}
			
			if ($post['backend_access_control_enabled'] != $config->backend_access_control_enabled)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['backend_access_users']))
		{
			JArrayHelper::toInteger($post['backend_access_users']);

			$backend_access_users = implode("\n",$post['backend_access_users']);
			$backend_access_users = $this->_db->getEscaped($backend_access_users);
			
			$config->backend_access_users = implode("\n",$config->backend_access_users);
			$config->backend_access_users = $this->_db->getEscaped($config->backend_access_users);
			
			if ($backend_access_users != $config->backend_access_users)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$backend_access_users."' WHERE `name`='backend_access_users'";
				$level = 'high';
				$code = 'BACKEND_ACCESS_USERS_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['backend_access_components']))
		{
			$backend_access_components = implode("\n",$post['backend_access_components']);
			$backend_access_components = $this->_db->getEscaped($backend_access_components);
			
			$config->backend_access_components = implode("\n",$config->backend_access_components);
			$config->backend_access_components = $this->_db->getEscaped($config->backend_access_components);
			
			if ($backend_access_components != $config->backend_access_components)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$backend_access_components."' WHERE `name`='backend_access_components'";
				$level = 'high';
				$code = 'BACKEND_ACCESS_COMPONENTS_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['backend_password_enabled']))
		{
			if ($post['backend_password_enabled'] == 0)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='0' WHERE `name`='backend_password_enabled'";
				$level = 'high';
				$code = 'BACKEND_PASSWORD_DISABLED';
			}
			else
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='1' WHERE `name`='backend_password_enabled'";
				$level = 'low';
				$code = 'BACKEND_PASSWORD_ENABLED';
			}
			
			if ($post['backend_password_enabled'] != $config->backend_password_enabled)
			{
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['backend_password']))
		{
			if (strlen($post['backend_password']) > 0 && strlen($post['backend_password']) < 6)
				JError::raiseWarning(500, JText::_('RSF_BACKEND_PASSWORD_ERROR'));
				
			if (strlen($post['backend_password']) >= 6 && md5($post['backend_password']) != $config->backend_password)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".md5($post['backend_password'])."' WHERE `name`='backend_password'";
				$level = 'high';
				$code = 'BACKEND_PASSWORD_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['backend_whitelist_ips']))
		{
			$backend_whitelist_ips = explode("\n", $post['backend_whitelist_ips']);
			foreach ($backend_whitelist_ips as $i => $ip)
			{
				$ip = trim($ip);
				if (!RSFirewallHelper::is_ip($ip))
					unset($backend_whitelist_ips[$i]);
			}
			
			$post['backend_whitelist_ips'] = implode("\n", $backend_whitelist_ips);
			$post['backend_whitelist_ips'] = $this->_db->getEscaped($post['backend_whitelist_ips']);
			
			$config->backend_whitelist_ips = $this->_db->getEscaped($config->backend_whitelist_ips);
			
			if ($post['backend_whitelist_ips'] != $config->backend_whitelist_ips)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['backend_whitelist_ips']."' WHERE `name`='backend_whitelist_ips'";
				$level = 'high';
				$code = 'BACKEND_WHITELIST_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['log_emails']))
		{
			$log_emails = explode("\n", $post['log_emails']);
			foreach ($log_emails as $i => $email)
			{
				$email = trim($email);
				if (!RSFirewallHelper::is_email($email))
					unset($log_emails[$i]);
			}
			
			$post['log_emails'] = implode("\n", $log_emails);
			$post['log_emails'] = $this->_db->getEscaped($post['log_emails']);
			$config->log_emails = $this->_db->getEscaped($config->log_emails);
			if ($post['log_emails'] != $config->log_emails)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['log_emails']."' WHERE `name`='log_emails'";
				$level = 'high';
				$code = 'LOG_EMAILS_CHANGED';
			
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['log_alert_level']))
		{
			if (array_search($post['log_alert_level'], $this->getAlertLevelsArray()) !== false && $post['log_alert_level'] != $config->log_alert_level)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['log_alert_level']."' WHERE `name`='log_alert_level'";
				$level = 'medium';
				$code = 'LOG_ALERT_LEVEL_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['log_history']))
		{
			$post['log_history'] = intval($post['log_history']);
			if ($post['log_history'] == 0)
				$post['log_history'] = 30;
			if ($post['log_history'] != $config->log_history)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['log_history']."' WHERE `name`='log_history'";
				$level = 'low';
				$code = 'LOG_HISTORY_CHANGED';
			
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		if (isset($post['log_overview']))
		{
			$post['log_overview'] = intval($post['log_overview']);
			if ($post['log_overview'] == 0)
				$post['log_overview'] = 5;
			if ($post['log_overview'] != $config->log_overview)
			{
				$query = "UPDATE #__rsfirewall_configuration SET `value`='".$post['log_overview']."' WHERE `name`='log_overview'";
				$level = 'low';
				$code = 'LOG_OVERVIEW_CHANGED';
				
				$this->_db->setQuery($query);
				$this->_db->query();
				$this->_log->addEvent($level, $code);
			}
		}
		
		RSFirewallHelper::readConfig();
	}
}
?>