<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

/**
/**
 * Multiup Model for Gallery XML Component
 */
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
/**
 * Multiup Model
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
class GalleryModelMultiup extends JModelSST
{
    /**
     * Gallery data array
     *
     * @var array
     */
    var $_data;
	var $_id;
	var $_categories;
	var $_no_image_thumb;
	var $_no_image_image;
	var $_categories_folder;
	var $_images_folder;
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access    public
	 * @return    void
	*/
	function __construct()
	{
		parent::__construct();
	 
		//$array = JRequest::getVar('cid',  0, '', 'array');
		//$this->setId((int)$array[0]);
		$this->_no_image_thumb = 'noimage_thumb.jpg';
		$this->_no_image_image = 'noimage.jpg';
		$params = &JComponentHelper::getParams('com_accordiongallery');
		$this->_categories_folder = $params->get('cat_path', 'images/accordiongallery/galleries');
		$this->_images_folder = $params->get('pic_path', 'images/accordiongallery/gallery');
	}
	
	/**
	 * Method to set the multiup id
	 *
	 * @access    public
	 * @param    int multiup identifier
	 * @return    void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id        	= $id;
		$this->_data  		= null;
	}
	 
	function &getCategories()
	{
		if (empty( $this->_categories )) {
			$query = 'SELECT id,ordnum,publish,name FROM #__accordiongalleryc ORDER BY ordnum';
			$this->_categories = $this->_getList( $query );
			//$this->_db->setQuery( $query );
			//$this->_categories = $this->_db->loadObject();
		}
		return 	$this->_categories;
	}
	
}
