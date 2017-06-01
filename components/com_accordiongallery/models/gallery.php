<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
 * Gallery Model for Gallery XML Component
 */
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
/**
 * Gallery Model
 */

if (!class_exists('JModelSST')) {
 if (!class_exists('JModel')) {
  if(function_exists('class_alias')) {
   class_alias('JModelLegacy', 'JModelSST');
  } else {
   class JModelSST extends JModelLegacy
   {
    function __construct()
    {
     parent::__construct();
    }
   }
  }
  } else {
  if(function_exists('class_alias')) {
   class_alias('JModel', 'JModelSST');
  } else {
   class JModelSST extends JModel
   {
    function __construct()
    {
     parent::__construct();
    }
   }
  }
 }
}
class GalleryModelGallery extends JModelSST
{
    /**
    * Gets the data
    * @return gallery data
    */
    function getData($cat_ids)
    {
		$where_q = '';
		if ($cat_ids != 0) {
			$ids_arr = explode (',', $cat_ids);
			if (isset($ids_arr) && is_array($ids_arr) && count($ids_arr)>0) {
				$where_q = ' AND (id=' . implode (' OR id=', $ids_arr) . ')';
			}
		}
		$database = & JFactory::getDBO();
		$query = 'Select * FROM #__accordiongalleryc  WHERE publish = 1 '.$where_q .' ORDER BY ordnum ';
		$database->setQuery($query);
		$data = $database->loadObjectList();
		return $data;
    }
	function getCatData($cat_id)
    {
		$database = & JFactory::getDBO();
		$query = 'Select * FROM #__accordiongallery WHERE catid = ' . $cat_id . ' AND publish = 1 ORDER BY ordnum';
		$database->setQuery($query);
		$data = $database->loadObjectList();
		return $data;
    }
}
