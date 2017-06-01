<?php
/**
* @Copyright Copyright (C) 2011- XML/SWF
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' ); 
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);//J3 compatibility
}
?>
 <style>
  <?php
  	$database = & JFactory::getDBO();//new ps_DB();
  	$query = "Select * FROM #__accordiongalleryc  WHERE publish = 1 ORDER BY ordnum DESC " ;
	$database->setQuery($query);
	$cat_q_res = $database->loadObjectList();
	$i=1;
	$style='';
     foreach ($cat_q_res as $curr_product) {
		$style.="
		.x_gallery li:nth-child(".$i.") .x_caption {

		background-color: #".$curr_product->linkname." !important;

	}
	.x_gallery li:nth-child(".$i.") .x_caption.active, .x_gallery li:nth-child(".$i.") .x_caption:hover {

		background-color: #".$curr_product->linkit." !important;

		border-right: none;

		width: 41px;

	}
		"; 
		$i++;
	 }
	 echo $style;
  ?>
 /*.x_gallery li:nth-child(1) .x_caption {

		background-color: #FF0000 !important;

	}
	.x_gallery li:nth-child(1) .x_caption.active, .x_gallery li:nth-child(1) .x_caption:hover {

		background-color: #00FF00 !important;

		border-right: none;

		width: 41px;

	}*/

  </style>
 <?php
//slide parameters
$slideshow_width                   = intval($params->get( 'gallery_width', 670 ));
$slideshow_height                  = intval($params->get( 'gallery_height', 410 ));

if (!function_exists('GetHColor')) {
function GetHColor($params, $tag_name, $curr_h_val = 'FFFFFF', $curr_h_sym = '#')
{
	$curr_pinput = $params->get($tag_name, $curr_h_sym . $curr_h_val);
	if (strtolower(substr($curr_pinput, 0, 2)) == '0x') {
		$curr_hex = substr($curr_pinput, 2);
	} elseif (substr($curr_pinput, 0, 1) == '#') {
		$curr_hex = substr($curr_pinput, 1);
	} else {
		$curr_hex = $curr_pinput;
	}
	if (strspn($curr_hex, "0123456789abcdefABCDEF") == 6 && strlen($curr_hex) == 6) {
		$curr_pinput = $curr_h_sym . $curr_hex;
	} else {
		$curr_pinput = $curr_h_sym . $curr_h_val;
	}
	return $curr_pinput;
}
}

$backgroundColor = trim($params->get( 'gallery_bgcolor', 'CCCCCC' ));
$wmode                 = trim($params->get( 'wmode', 'opaque' ));

$xml_fname    = trim($params->get( 'xml_fname', 'data' ));
$catppv_id = 'xml/' . $xml_fname;
$module_path = dirname(__FILE__).DS;
if (!is_dir($module_path . 'xml/')) {
	mkdir($module_path . 'xml/', 0777);
}

if (!function_exists('create_gallaccordion_xml_file')) {
function create_gallaccordion_xml_file($params, &$catppv_id, &$onlyvm_flag)
{
$database = & JFactory::getDBO();//new ps_DB();
$cat_ids                = trim($params->get( 'category_id', '0' ));
$add_query = '';
if ($cat_ids && $cat_ids != 0) {
	$ids  = explode(",", $cat_ids);
	if (is_array($ids)) {
		foreach ($ids as $curr_id) {
			$add_query_arr[] = " id = " . $curr_id . " ";
		}
		$add_query = " AND " . '(' . implode("OR", $add_query_arr) . ')';
	}
}

if (1 == trim($params->get( 'catppv_flag', '2' ))) {
	$catppv_id .= str_replace(',', '_', $cat_ids);
}
$module_path = dirname(__FILE__).DS;
if (!file_exists($module_path . $catppv_id . '.swf') ) {
	copy($module_path . 'mod_accordion_gallery.swf', $module_path . $catppv_id . '.swf');

	///////// set chmod 0644 for creating .swf file  if server is not windows
	$os_string = php_uname('s');
	$cnt = substr_count($os_string, 'Windows');
	if($cnt =='0'){
		chmod($module_path . $catppv_id . '.swf', 0644);
	}


}

$query = "Select * FROM #__accordiongalleryc  WHERE publish = 1 " . $add_query . " ORDER BY ordnum " ;
$database->setQuery($query);
$cat_q_res = $database->loadObjectList();

$xml_categories_filename = $module_path.$catppv_id.'.xml';
$defaultSelectedCategory = $params->get( 'defaultSelectedCategory', '0' );
if ($defaultSelectedCategory == 0) {
		if(count($cat_q_res)>0){
			$defaultSelectedCategory = $cat_q_res[0]->id;
		}
		else{
				echo "<b style='color:#FF0000;'>Please Add categories and category data in accordiongallery component.</b><br/><br/>";
			}
}


///////// Autoplay 
$autoplay = trim($params->get( 'auto_play', 'yes' ));

if($autoplay=='yes'){
  $generate_autoplay = 'true';
}else{
	 $generate_autoplay = 'false';
}

////// Shadow
$shadow = trim($params->get( 'shadow', 'yes' ));

if($shadow=='yes'){
  $generate_shadow = 'true';
}else{
	 $generate_shadow = 'false';
}

/////// Show control
$showcontrol = trim($params->get( 'show_control', 'yes' ));

if($showcontrol=='yes'){
  $generate_showcontrol = 'true';
}else{
	 $generate_showcontrol = 'false';
}
$xml_data_data = '<?xml version="1.0" encoding="utf-8" ?><data>
	
	<settings>
		<gallery_width>'.trim($params->get( 'gallery_width', '720' )).'</gallery_width>
		<gallery_height>'.trim($params->get( 'gallery_height', '410' )).'</gallery_height>
		<title_size>'.trim($params->get( 'title_size', '14' )).'</title_size>
		<title_color>'.trim($params->get( 'title_color', 'FFFFFF' )).'</title_color>
		<description_size>'.trim($params->get( 'desc_size', '12' )).'</description_size>
		<description_color>'.trim($params->get( 'desc_color', 'FFFFFF' )).'</description_color>
		<auto_play>'.trim($generate_autoplay).'</auto_play>
		<change_time>'.trim($params->get( 'slide_transitiontime', '3' )).'</change_time>
		<accord_location>'.trim($params->get( 'accordion_position', 'left' )).'</accord_location>
		<tab>
';
if (!stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone') && !stristr($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
		$xml_data_data .= '			<position>vertical</position>
';
}
			$xml_data_data .= '			<width>'.trim($params->get( 'tab_width', '50' )).'</width>
			<shadow>'.trim($generate_shadow).'</shadow>
			<open_time>'.trim($params->get( 'tab_opentime', '0.5' )).'</open_time>
			<open_mode>'.trim($params->get( 'tab_openmode', 'click' )).'</open_mode>
			<font_size>'.trim($params->get( 'tab_textsize', '25' )).'</font_size>
			<text_color>'.trim($params->get( 'tab_textcolor', 'FFFFFF' )).'</text_color>
		</tab>

		<display_template>
			<type>'.trim($params->get( 'template_type', '3' )).'</type>
			<change_time>'.trim($params->get( 'image_transition_time', '.5' )).'</change_time>			

		<template_fourth>
				<link_text>'.trim($params->get( 'tem2_readlink', 'Read More' )).'</link_text>
				<description_width>'.trim($params->get( 'tem2_descwidth', '250' )).'</description_width>
				<description_background_color>'.trim($params->get( 'tem3_descbgcolor', '000000' )).'</description_background_color>
				<description_background_alpha>'.trim($params->get( 'temd3_descbgcoloralpha', '0.5' )).'</description_background_alpha>
			</template_fourth>
				
		
		<template_third>
				<controls_position_y>300</controls_position_y>
				<description_background_color>'.trim($params->get( 'tem3_descbgcolor', '000000' )).'</description_background_color>
				<description_background_alpha>'.trim($params->get( 'temd3_descbgcoloralpha', '0.5' )).'</description_background_alpha>
			</template_third>

			<template_second>
				<link_text>'.trim($params->get( 'tem2_readlink', 'Read More' )).'</link_text>
				<description_width>'.trim($params->get( 'tem2_descwidth', '250' )).'</description_width>
				<description_background_color>'.trim($params->get( 'tem2_descbgcolor', '000000' )).'</description_background_color>				
			</template_second>
			
			<template_first>
				<link_text>'.trim($params->get( 'tem1_readlink', 'Read More' )).'</link_text>
				<picture_height>'.trim($params->get( 'tem1_pic_height', '234' )).'</picture_height>
			</template_first>
			
			<controls>
				<show>'.trim($generate_showcontrol).'</show>
				<button_width>'.trim($params->get( 'control_btnwidth', '11' )).'</button_width>
				<button_height>'.trim($params->get( 'control_btnheight', '11' )).'</button_height>
				<button_color>'.trim($params->get( 'control_btncolor', 'ffffff' )).'</button_color>
				<button_color_over>'.trim($params->get( 'control_btnovercolor', 'ff5a01' )).'</button_color_over>
			</controls>
		</display_template>

		<price>
			<x>'.trim($params->get( 'pricebtn_xpos', '100' )).'</x>
			<y>'.trim($params->get( 'pricebtn_ypos', '100' )).'</y>
			<width>'.trim($params->get( 'pricebtn_width', '120' )).'</width>
			<height>'.trim($params->get( 'pricebtn_height', '120' )).'</height>
			<img>'.JURI::root().'components/com_accordiongallery/price_images/'.$params->get( 'pricebtn_img', 'flower_red.png' ).'</img>
			<symbol>'.trim($params->get( 'currency', '$' )).'</symbol>
			<label_size>'.trim($params->get( 'price_size', '20' )).'</label_size>
			<label_color>'.trim($params->get( 'price_color', 'FFFFFF' )).'</label_color>
		</price>

	</settings>
	<snow_effect 	
		type="'.$params->get( 'snoweffect_type', '1' ).'"
		
		minimumSize="'.$params->get( 'min_particle_size', '0.3' ).'"
		maximumSize="'.$params->get( 'max_particle_size', '0.7' ).'"
		
		minimumSpeedY="'.$params->get( 'min_particle_yspeed', '2' ).'"
		maximumSpeedY="'.$params->get( 'max_particle_yspeed', '4' ).'"
		
		minimumSpeedX="'.$params->get( 'min_particle_xspeed', '0' ).'"
		maximumSpeedX="'.$params->get( 'max_particle_xspeed', '0' ).'"
		
		numOfParticles="'.$params->get( 'noof_particles', '120' ).'"
		
		minimumRotation="'.$params->get( 'min_particle_rotation', '0' ).'"
		maximumRotation="'.$params->get( 'max_particle_rotation', '0' ).'"
		
		minimumAlpha="'.$params->get( 'min_particle_alpha', '1' ).'"
		maximumAlpha="'.$params->get( 'max_particle_alpha', '1' ).'"
		
		minimumBlur="'.$params->get( 'min_particle_blur', '0' ).'"
		maximumBlur="'.$params->get( 'max_particle_blur', '6' ).'"
	/>';
$xml_data_data .= ' <tabs> ';
$def_cat_flag = true;
if(count($cat_q_res) > 0){
	foreach ($cat_q_res as $curr_category) 
	{
		if (!stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone') && !stristr($_SERVER['HTTP_USER_AGENT'], 'iPad') && $curr_category->linkname && strlen($curr_category->linkname) == 6) {
			$tab_color_xml = 'color="'.$curr_category->linkname.'" hoverColor="'.$curr_category->linkit.'"';
			
		} else {
			$tab_color_xml = '';
		}
		$ret_arr = write_galaccordion_xml_data($curr_category->id, $curr_category->id, $params);
		if ($ret_arr['flag']) {
			if ($params->get( 'default_category_id', '0' ) == $curr_category->id || ($def_cat_flag && trim($params->get( 'default_category_id', '0' )) == 0)) {
				$xml_data_data .= ' <tab play_deafult="true" '.$tab_color_xml.' >';
				$def_cat_flag = false;
			}else{
				$xml_data_data .= ' <tab '.$tab_color_xml.' >';
			}

			$xml_data_data .= ' <name><![CDATA['.strip_tags($curr_category->name).']]></name>';
			
			$xml_data_data .= $ret_arr['xml'];

			$xml_data_data .= '	</tab>';
		}
		
	}
}
$xml_data_data .= '</tabs></data>';

$xml_categories_file = fopen($xml_categories_filename,'w');
@chmod($xml_categories_filename, 0777);
fwrite($xml_categories_file, $xml_data_data);
fclose($xml_categories_file);
}
}
if (!function_exists('write_galaccordion_xml_data')) {
function write_galaccordion_xml_data($cat_name, $cat_id, $params)
{
	$ret_arr = array ('flag'=>false, 'xml'=>'');
	$params_comg = &JComponentHelper::getParams('com_accordiongallery');
	$images_path = $params_comg->get('pic_path', 'images/accordiongallery/gallery');
	$images_path .= '/';
	global $mosConfig_absolute_path, $sess;
	$query = "Select * FROM #__accordiongallery WHERE catid = " . $cat_id . " AND publish = 1 ORDER BY ordnum";

	$xml_data = '';
	$db = & JFactory::getDBO();//new ps_DB();
	//$db->query($query);
	//$rows = $db->record;
	$db->setQuery($query);
	$prod_q_res = $db->loadObjectList();

	///// Image Scalling
	$imagescale = trim($params->get( 'image_scale', 'no' ));

	if($imagescale=='yes'){
	  $generate_imagescale = 'true';
	}else{
	  $generate_imagescale = 'false';
	}

	foreach ($prod_q_res as $curr_product) {

		$ret_arr['flag'] = true;

				$xml_data .= ' <element>';
				$xml_data .= ' <link target="'.trim($params->get( 'target', '_self' )).'"><![CDATA['.trim($curr_product->linkit).']]></link>';
				$xml_data .= ' <picture  scale="'.trim($generate_imagescale).'">'.JURI::root().$images_path.$curr_product->image.'</picture>';
				if (!(stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || stristr($_SERVER['HTTP_USER_AGENT'], 'iPad') || stristr($_SERVER['HTTP_USER_AGENT'], 'Android'))) {
				if (trim($curr_product->linkname) != '') {
					$xml_data .= '
					<video>'.trim($curr_product->linkname).'</video>
					';
				}
				}
				$xml_data .= ' <title><![CDATA['.strip_tags($curr_product->name).']]></title>';
				if (trim($params->get( 'showdesc', 'yes' )) == 'yes') {
				$xml_data .= ' <description><![CDATA['.strip_tags($curr_product->descr).']]></description>';
				}else{
					$xml_data .= ' <description></description>';
				}

				$xml_data .= '<price>';
				
				 if ($params->get( 'show_price', 'yes' ) == 'yes') {
					
					if($curr_product->reg_price>0){ 
					$xml_data .= '<regular><![CDATA['.$curr_product->reg_price.']]></regular>';
					}else{
						$xml_data .= '<regular><![CDATA[]]></regular>';
					}

					if ($params->get( 'show_disprice', 'yes' ) == 'yes') {
						if($curr_product->dis_price>0){   
						$xml_data .= '<updated><![CDATA['.$curr_product->dis_price.']]></updated>';
						}else{
							$xml_data .= '<updated><![CDATA[]]></updated>';
						}
					}else{
							$xml_data .= '<updated><![CDATA[]]></updated>';
					}

						
					}else{
						$xml_data .= '<regular><![CDATA[]]></regular>';
						$xml_data .= '<updated><![CDATA[]]></updated>';
						
					}
			$xml_data .= '	</price>';

			$xml_data .= ' </element>';	

	}
		$ret_arr['xml'] = $xml_data;
		return $ret_arr;
}
}
create_gallaccordion_xml_file($params, $catppv_id, $onlyvm_flag);

if (stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || stristr($_SERVER['HTTP_USER_AGENT'], 'iPad') || stristr($_SERVER['HTTP_USER_AGENT'], 'Android')) {
	?>
  <link rel="stylesheet" type="text/css" href="<?php echo JURI::root(); ?>components/com_accordiongallery/css/x_gallery.css" />
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_accordiongallery/js/easing.js"></script>
  <script type="text/javascript">
	window.x_ppa = "<?php echo JURI::root(); ?>components/com_accordiongallery/js/";
  </script>
  <script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_accordiongallery/js/x_gallery.js"></script>
  <!--[if lte IE 8]>
	<style>
		.x_caption > h3 {
			position: relative;
			filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
			top: 60px;
			left: 0;
			text-align: left;
			width: 315px;
			height: 30px;
			display: inline-block;
			font-size: 18px;
			font-weight: normal;
		}
	</style>
	<![endif]-->
	<!--[if lte IE 7]>
	<script>
	function screwIE() {
		$('.x_clock').last().click();
		$('.x_clock').hide();
	} 
	$(document).ready(function() {
		window.setTimeout('screwIE()', 5000);
	});
	
	</script>
	
	<![endif]-->
	<div class="x_gallery" id="x_gallery" data-xml="<?php echo JURI::root()?>modules/mod_accordion_gallery/<?php echo $catppv_id; ?>.xml" style="width:<?php echo trim($params->get( 'gallery_width', '720' ));?>px;height:<?php echo trim($params->get( 'gallery_height', '410' ));?>px; z-index:0;">
	<div class="x_cover"></div>
		<ul>
		</ul>
	</div>

	<?php
} else {
?>
	<script src="<?php echo JURI::root()?>modules/mod_accordion_gallery/js/swfobject.js" language="javascript"></script>
		<script type="text/javascript">
		var flashvars = {
			xmlPath: "<?php echo JURI::root()?>modules/mod_accordion_gallery/<?php echo $catppv_id; ?>.xml",
			swfWidth: "<?php echo $slideshow_width;?>"
		};
		var params = {
			menu: "false",
			scale: "noScale",
			allowFullscreen: "true",
			allowScriptAccess: "always",
			bgcolor: "<?php echo $backgroundColor; ?>",
			wmode: "<?php echo $wmode;?>" // can cause issues with FP settings & webcam
		};
		var attributes = {
			id:"accord<?php echo $xml_fname; ?>"
		};
		swfobject.embedSWF(
			"<?php echo JURI::root().'modules/mod_accordion_gallery/'.$catppv_id.'.swf';?>", 
			"accordionGallery<?php echo $xml_fname; ?>", "<?php echo $slideshow_width;?>", "<?php echo $slideshow_height; ?>", "10.0.0",false,flashvars, params, attributes);
	</script>

	<div id="accordionGallery<?php echo $xml_fname; ?>"></div>
<?php 
}
?>