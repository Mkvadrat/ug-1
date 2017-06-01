<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );


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
class GalleryModelGalpic extends JModelSST
{
    function getData($cat_id)
    {
		$query = 'Select * FROM #__accordiongallery WHERE catid = ' . $cat_id . ' AND publish = 1 ORDER BY ordnum';
		$this->_db->setQuery($query);
		$data = $this->_db->loadObjectList();
		return $data;
    }
	function getItems($q_ids)
    {
		$query = 'Select * FROM #__accordiongallery WHERE id = ' . $q_ids;
		$this->_db->setQuery($query);
		$data = $this->_db->loadObjectList();
		return $data;
    }
}
