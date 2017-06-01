<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');

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
class GalleryControllerMultiupdo extends JControllerSST
{
	function __construct()
	{
		parent::__construct();
	}

function upfuf()
{
$version = new JVersion;
$jver = $version->getShortVersion();
if(substr($jver, 0, 3) != '1.5'){
	jimport('joomla.html.parameter');
}

$root_dirn = JPATH_ROOT . DS;

if(version_compare(JVERSION, '3.0.0', 'ge')) {
	$params_comg = JComponentHelper::getParams('com_accordiongallery', true);
} else {
	$componentstr = &JComponentHelper::getComponent('com_accordiongallery');
	$params_comg = new JParameter($componentstr->params);
}

$thumb_x = $params_comg->get('thumb_x', '100');
$thumb_y = $params_comg->get('thumb_y', '75');
$secur_w = $params_comg->get('secur_w', 'telx3eis7d');
if ($secur_w == 'telx3eis7d') {
	exit();
}
if (!isset($_POST['decret']) || $_POST['decret'] != $secur_w) {
	exit();
}
$pic_path = $params_comg->get('pic_path', 'images/accordiongallery/gallery');

if (DS != '/') {
	$pic_path = str_replace('/', DS, $pic_path);
}

$gallery_path = $root_dirn . $pic_path . DS;


if ($_FILES["Filedata"]["error"] > 0 || !(strtolower(substr($_FILES["Filedata"]["name"], -5)) == ".jpeg" || strtolower(substr($_FILES["Filedata"]["name"], -4)) == ".jpg" || strtolower(substr($_FILES["Filedata"]["name"], -4)) == ".gif"  || strtolower(substr($_FILES["Filedata"]["name"], -4)) == ".bmp" || strtolower(substr($_FILES["Filedata"]["name"], -4)) == ".png")) {
	exit();
} else {
	$img_ext = strtolower(strrchr($_FILES["Filedata"]["name"], '.'));
	$pic_name = substr($_FILES["Filedata"]["name"], 0, -strlen($img_ext));
	$image_name_end = preg_replace('/[^a-zA-Z0-9_]/', '_', $pic_name) . $img_ext;
	$image_name = $image_name_end;
	$noex_f_index = 0;
	while(file_exists($gallery_path . $image_name_end)) {
		$noex_f_index++;
		$image_ext = strrchr($image_name, '.');
		$image_name_end = substr($image_name, 0, -strlen($image_ext)) . '_' . $noex_f_index . $image_ext;				
	}
	if ($image_name_end != $image_name) {
		$image_name = $image_name_end;
	}
	move_uploaded_file($_FILES["Filedata"]["tmp_name"], $gallery_path . $image_name);
}

$thumb_name = 'noimage_thumb.jpg';
if (file_exists($gallery_path . $image_name)) {
	$thumb_name_end = 'thumb_' . $image_name;
	$thumb_name = $thumb_name_end;
	$noex_f_index = 0;
	while(file_exists($gallery_path . $thumb_name_end)) {
		$noex_f_index++;
		$thumb_ext = strrchr($thumb_name, '.');
		$thumb_name_end = substr($thumb_name, 0, -strlen($thumb_ext)) . '_' . $noex_f_index . $thumb_ext;				
	}
	if ($thumb_name_end != $thumb_name) {
		$thumb_name = $thumb_name_end;
	}
	$thumb_ext = substr(strrchr($thumb_name, '.'), 1);
	$cnt_ext_chr = -(strlen($thumb_ext) + 1);
	$thumb_noext = $gallery_path . substr($thumb_name, 0, $cnt_ext_chr);
	$image_noext = $gallery_path . substr($image_name, 0, $cnt_ext_chr);
	$this->CreateThumbF($image_noext, $thumb_noext, $thumb_ext, $thumb_x, $thumb_y);
}



$ord_numb = 1;
if (is_numeric($_POST['catid'])) {
	$cat_id = $_POST['catid'];
} else {
	$cat_id = 1;
}
$q_maxord = ' SELECT MAX(ordnum) as maxordnum FROM #__accordiongallery WHERE catid = ' . $cat_id;
$database = & JFactory::getDBO();
$database->setQuery($q_maxord);
$img_info = $database->loadObject();
if (!$img_info) {
	$ord_numb = 1;
} else {
	$ord_numb = $img_info->maxordnum + 1;
}

$insert_q = "INSERT INTO #__accordiongallery VALUES (NULL,".$cat_id.",".$ord_numb.",1,'".$pic_name."','".$pic_name."','".'thumb_'.$pic_name."','".$pic_name."','" .$thumb_name. "','".$image_name."','','','0','0',1)";
$database->setQuery($insert_q);
$database->query();
echo "Picture successfully saved";
$mainframe = JFactory::getApplication();
$mainframe->close();
}

function CreateThumbF($bigi_name, $thumb_name, $ext, $t_x, $t_y)
{
	$jpg_imgr = false;
	switch ($ext) {
		case 'jpg':
		case 'jpeg':
			if (function_exists('imagecreatefromjpeg')) {
				$jpg_imgr = imagecreatefromjpeg($bigi_name . '.' . $ext);
			}
		break;
		case 'png':
			if (function_exists('imagecreatefrompng')) {
				$jpg_imgr = imagecreatefrompng($bigi_name . '.' . $ext);
			}
		break;
		case 'gif':
			if (function_exists('imagecreatefromgif')) {
				$jpg_imgr = imagecreatefromgif($bigi_name . '.' . $ext);
			}
		break;
		default:
			return false;
	}
	
	if ($jpg_imgr) {
		$big_x = imagesx($jpg_imgr);
		$big_y = imagesy($jpg_imgr);
		
		$ratio_orig = $big_x/$big_y;
		if ($t_x/$t_y > $ratio_orig) {
		   $t_x = $t_y * $ratio_orig;
		} else {
		   $t_y = $t_x/$ratio_orig;
		}

		$dst_img=ImageCreateTrueColor($t_x, $t_y);
		imagecopyresampled($dst_img, $jpg_imgr,0,0,0,0,$t_x,$t_y,$big_x,$big_y);
		switch ($ext) {
			case 'jpg':
			case 'jpeg':
				imagejpeg($dst_img, $thumb_name . '.' . $ext, 100);
			break;
			case 'png':
				imagepng($dst_img, $thumb_name . '.' . $ext, 0);
			break;
			case 'gif':
				if (function_exists('imagegif')) { 
					imagegif ($dst_img, $thumb_name . '.' . $ext);
				} else {
					imagejpeg($dst_img, $thumb_name . '.' . $ext, 100);
				}
			break;
			default:
				return false;
		}
		imagedestroy($jpg_imgr);
		imagedestroy($dst_img);
	} else {
		return false;
	}
}

}
