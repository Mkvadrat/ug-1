<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
/**
 * Gallery XML Component Controller
 */
if (!class_exists('JControllerSST')) {
 if (!class_exists('JController')) {
  if(function_exists('class_alias')) {
   class_alias('JControllerLegacy', 'JControllerSST');
  } else {
   class JControllerSST extends JControllerLegacy
   {
    function __construct()
    {
     parent::__construct();
    }
   }
  }
  } else {
  if(function_exists('class_alias')) {
   class_alias('JController', 'JControllerSST');
  } else {
   class JControllerSST extends JController
   {
    function __construct()
    {
     parent::__construct();
    }
   }
  }
 }
}
class GalleryControllerCategories extends JControllerSST
{
    
	function __construct()
	{
		parent::__construct();
		
		$version = new JVersion;
		$jver = $version->getShortVersion();
		if(substr($jver, 0, 3) != '1.5'){
			jimport('joomla.html.parameter');
		}
		if(version_compare(JVERSION, '3.0.0', 'ge')) {
			$params_comg = JComponentHelper::getParams('com_accordiongallery', true);
		} else {
			$componentstr = &JComponentHelper::getComponent('com_accordiongallery');
			$params_comg = new JParameter($componentstr->params);
		}
		
		$secur_w = $params_comg->get('secur_w', 'telx3eis7d');
		if ($secur_w == 'telx3eis7d') {
			$secur_w = md5(time().rand().rand().rand());		
			if(substr($jver, 0, 3) != '1.5') {
				$replace_q = "UPDATE #__extensions SET `params` = REPLACE(`params`, '\"secur_w\":\"telx3eis7d\"', '\"secur_w\":\"".$secur_w."\"') WHERE `element` = 'com_accordiongallery'";
			} else {
				$replace_q = "UPDATE #__components SET `params` = REPLACE(`params`, 'secur_w=telx3eis7d', 'secur_w=".$secur_w."') WHERE `link` = 'option=com_accordiongallery'";
			}
			$database = & JFactory::getDBO();
			$database->setQuery($replace_q);
			$database->query();
			if ($database->getAffectedRows() != 1) {
				if(substr($jver, 0, 3) != '1.5') {
					$replace_q = "UPDATE #__extensions SET `params` = REPLACE(`params`, '}', '\"secur_w\":\"".$secur_w."\"}') WHERE `element` = 'com_accordiongallery'";
				} else {
					$replace_q = "UPDATE #__components SET `params` = CONCAT(`params`, 'secur_w=".$secur_w."\\n') WHERE `link` = 'option=com_accordiongallery'";
				}
				$database = & JFactory::getDBO();
				$database->setQuery($replace_q);
				$database->query();
			}
		}
		
		jimport('joomla.client.helper');
		jimport('joomla.client.ftp');
		$ftp_info = JClientHelper::getCredentials('ftp');
		$rel_cat_path = $params_comg->get('cat_path', 'images/accordiongallery/galleries');
		$rel_cat_path_arr = explode('/', $rel_cat_path);
		if (DS != '/') {
			$rel_cat_path = implode(DS, $rel_cat_path_arr);
		}
		$img_rfld = JPATH_SITE . DS . $rel_cat_path;
		if (!is_dir($img_rfld)) {
			@$created_flag = mkdir($img_rfld, 0777, true);
			if (is_dir($img_rfld)) {
				@chmod($img_rfld, 0777);
			}
			if (!$created_flag) {
				if ($ftp_info['enabled']) {
					$ftp_con = JFTP::getInstance($ftp_info['host'], $ftp_info['port'], null, $ftp_info['user'], $ftp_info['pass']);
					$curr_dir = $ftp_info['root'];
					$curr_isdir = JPATH_SITE;
					foreach ($rel_cat_path_arr as $c_dir) {
						$curr_dir .= DS . $c_dir;
						$curr_isdir .= DS . $c_dir;
						if (!is_dir($curr_isdir)) {
							$ftp_con->mkdir($curr_dir);
						}
					}
					if (is_dir($img_rfld)) {
						$created_flag = true;
						$ftp_con->chmod($curr_dir, 511);
					} else {
						$created_flag = false;
					}
				}
			}
			if (!$created_flag) {
				$err_msg = JText::_(' Please create read/write folder ') . $img_rfld;
				JError::raiseNotice(1, $err_msg, 'mandatory');
			}
		}
		
		$rel_pic_path = $params_comg->get('pic_path', 'images/accordiongallery/gallery');
		$rel_pic_path_arr = explode('/', $rel_pic_path);
		if (DS != '/') {
			$rel_pic_path = implode(DS, $rel_pic_path_arr);
		}
		$img_rfld1 = JPATH_SITE . DS . $rel_pic_path;
		if (!is_dir($img_rfld1)) {
			@$created_flag1 = mkdir($img_rfld1, 0777, true);
			if (is_dir($img_rfld1)) {
				@chmod($img_rfld1, 0777);
			}
			if (!$created_flag1) {
				if ($ftp_info['enabled']) {
					$ftp_connect = JFTP::getInstance($ftp_info['host'], $ftp_info['port'], null, $ftp_info['user'], $ftp_info['pass']);
					$curr_dir = $ftp_info['root'];
					$curr_isdir = JPATH_SITE;
					foreach ($rel_pic_path_arr as $c_dir) {
						$curr_dir .= DS . $c_dir;
						$curr_isdir .= DS . $c_dir;
						if (!is_dir($curr_isdir)) {
							$ftp_connect->mkdir($curr_dir);
						}
					}
					if (is_dir($img_rfld1)) {
						$created_flag1 = true;
						$ftp_connect->chmod($curr_dir, 511);
					} else {
						$created_flag1 = false;
					}
				}
			}
			if (!$created_flag1) {
				$err_msg = JText::_(' Please create read/write folder ') . $img_rfld1;
				JError::raiseNotice(2, $err_msg, 'mandatory');
			}
		}

	}
	
    function display()
    {
		JRequest::setVar( 'view', 'categories' );
		JRequest::setVar( 'layout', 'default' );
        parent::display();
    }
 
}