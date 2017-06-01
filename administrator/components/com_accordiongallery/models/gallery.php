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
     * Gallery data array
     *
     * @var array
     */
    var $_data;

	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildQuery($cat_id = 0)
	{
		$where_q = ($cat_id == 0) ? '' : ' WHERE #__accordiongallery.catid = ' . $cat_id;
		$query = ' SELECT #__accordiongallery.*, #__accordiongalleryc.name as catname '
			   . ' FROM #__accordiongallery '
			   . ' LEFT JOIN #__accordiongalleryc'
				. '	ON #__accordiongallery.catid = #__accordiongalleryc.id '
				. $where_q
			   . ' ORDER BY #__accordiongalleryc.ordnum, #__accordiongallery.ordnum'
		;
		return $query;
	}
	/**
	 * Retrieves the Gallery data
	 * @return array Array of objects containing the data from the database
	 */
	function getData($cat_id = 0)
	{
		$mainframe = JFactory::getApplication();
		global $option;
	
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data ))
		{
			$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
			$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);


			$where_q = ($cat_id == 0) ? '' : ' WHERE #__accordiongallery.catid = ' . $cat_id;
			$query = ' SELECT #__accordiongallery.*, #__accordiongalleryc.name as catname '
				   . ' FROM #__accordiongallery '
				   . ' LEFT JOIN #__accordiongalleryc'
					. '	ON #__accordiongallery.catid = #__accordiongalleryc.id '
					. $where_q
				   . ' ORDER BY #__accordiongalleryc.ordnum, #__accordiongallery.ordnum'
			;
			$items = $this->_getList($query, $limitstart, $limit);
			 
			$total = $this->_getListCount($query);
			jimport('joomla.html.pagination');
			$pagination = new JPagination($total, $limitstart, $limit);
			
			$this->_data = array('items'=>$items, 'pagination'=>$pagination);
		}
		return $this->_data;
	}
	function &getCategories()
	{
		$query = 'SELECT id, ordnum, publish, name FROM #__accordiongalleryc ORDER BY ordnum';
		$categories = $this->_getList( $query );
		return 	$categories;
	}
}
