<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
 
defined( '_JEXEC' ) or die( 'Restricted access' );
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
jimport( 'joomla.application.component.view');

if (!class_exists('JViewSST')) {
 if (!class_exists('JView')) {
  if(function_exists('class_alias')) {
   class_alias('JViewLegacy', 'JViewSST');
  } else {
   class JViewSST extends JViewLegacy
   {
    function __construct()
    {
     parent::__construct();
    }
   }
  }
  } else {
  if(function_exists('class_alias')) {
   class_alias('JView', 'JViewSST');
  } else {
   class JViewSST extends JView
   {
    function __construct()
    {
     parent::__construct();
    }
   }
  }
 }
}
class GalleryViewAccordiongallery extends JViewSST
{
    function display($tpl = null)
    {
        parent::display($tpl);
    }
}