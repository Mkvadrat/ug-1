<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
 * Categories Model for Gallery XML Component
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
class GalleryModelCategories extends JModelSST
{
    /**
     * Categories array
     *
     * @var array
     */
    var $_categories;

	function &getCategories()
	{
		if (empty( $this->_categories )) {
			$query = 'SELECT * FROM #__accordiongalleryc ORDER BY ordnum';
			$this->_categories = $this->_getList( $query );
			//$this->_db->setQuery( $query );
			//$this->_categories = $this->_db->loadObject();
		}
		return 	$this->_categories;
	}
}
