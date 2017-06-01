<?php
/**
* @package		Email Protector
* @link			http://enless-soft.com/pj_abm
* @author		Enless Soft Ltd.
* @copyright	Copyright (C) 2007 - 2010 Enless Soft Ltd.
* @license		GNU/GPL v.2 http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
* 
* This file is part of Email Protector.
* 
* Email Protector is distributed under the terms of the GNU General
* Public License version 2 as published by the Free Software Foundation.
* 
* Email Protector is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Email Protector. If not, see <http://www.gnu.org/licenses/>.
* 
**/
?><?php 
defined('_JEXEC') or die('Restricted access');

class plgSystemEs_Email_Protector extends JPlugin {
	static $is_active = false;
	static $js_func_name = '';
	
 	function plgSystemEs_Email_Protector(& $subject, $config) {
        parent::__construct($subject, $config);
		self::$is_active = true;
		
		$func_name = self::getUniqueCode(10);
		if (is_numeric(substr($func_name, 0, 1))) $func_name = 'f'.$func_name;
		self::$js_func_name = $func_name;
    }
    function getUniqueCode($length = 0) {
    	$code = md5(uniqid(rand(), true));
    	if ($length > 0) {
    		return substr($code, 0, $length);
    	} else {
    		return $code;
    	}
    }
    function onAfterRoute() {
		global $mainframe;
		if (!self::$is_active) return;
		if ($mainframe->isAdmin() == true) return;
		
		$doc =& JFactory::getDocument();
		if (is_a($doc, 'JDocumentHTML')) {
			$js = "
			function ".self::$js_func_name."(address) {
				document.location.href = 'mail'+'to:'+address;
			}
			";
			$doc->addScriptDeclaration($js);
		}
    }

	function onAfterRender() {
		global $mainframe;
		if (!self::$is_active) return;
		if ($mainframe->isAdmin() == true) return;
		
		$body = JResponse::getBody(false);
		
		//Cloak mailto links
		$pattern = '/(<a.+href=)(?:"|\')mailto:(.*)(?:"|\')(.*>)(.*)(<\/a>)/iU';
		$m = array();
		preg_match_all($pattern, $body, $m, PREG_SET_ORDER);
		
		$result = $body;
		foreach ($m as $match) {
			$email = $match[2];
			$js_email = self::getCloakedJavaScriptEmail($email);
			$new_mailto = "javascript:".self::$js_func_name."(".$js_email.");";
			
			$nv = $match[1];
			$nv .= '"'.$new_mailto.'"';
			$nv .= $match[3];
			$nv .= $match[4];
			$nv .= $match[5];
			
			$result = preg_replace($pattern, $nv, $result, 1);
		}
		
		//Cloak email addresses everywhere else
		$pattern = '/>([^<]*?)(([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4}))/i';
		preg_match_all($pattern, $result, $m, PREG_SET_ORDER);
		foreach ($m as $match) {
			$email = $match[2];
			$js_email = self::getCloakedJavaScriptEmail($email);
			$new_email = "<script type='text/javascript'>document.write($js_email)</script>";
			
			$nv = '>'.$match[1].$new_email;
			
			$result = preg_replace($pattern, $nv, $result, 1);
		}
		
		
		JResponse::setBody($result);
	}
	
	private function getCloakedJavaScriptEmail($email) {
		$email_parts = explode('@', $email);
		$js_email = "['".$email_parts[0]."','".$email_parts[1]."'].join('&#64;')";
		return $js_email;
	}
	
}

?>
