<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

/**
 * Category Model for Gallery XML Component
 */
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
/**
 * Category Model
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
class GalleryModelCategory extends JModelSST
{
    /**
     * Gallery data array
     *
     * @var array
     */
    var $_data;
	var $_id;
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
	 
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
		$this->_no_image_thumb = 'noimage_thumb.jpg';
		$this->_no_image_image = 'noimage.jpg';
		$params = &JComponentHelper::getParams('com_accordiongallery');
		$this->_categories_folder = $params->get('cat_path', 'images/accordiongallery/galleries');
		$this->_images_folder = $params->get('pic_path', 'images/accordiongallery/gallery');
	}
	
	/**
	 * Method to set the category id
	 *
	 * @access    public
	 * @param    int category identifier
	 * @return    void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id        	= $id;
		$this->_data  		= null;
	}

	/**
	 * Method to get a category data
	 * @return object with data
	 */
	 
	function &getCategory()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__accordiongalleryc '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->ordnum = 1;
			$this->_data->publish = 1;
			$this->_data->name = null;
			$this->_data->descr = null;
			$this->_data->altthumb = 'no image';
			$this->_data->altlarge = 'no image';
			$this->_data->thumb = $this->_no_image_thumb;
			$this->_data->image = $this->_no_image_image;
			$this->_data->linkname = 'FFF000';
			$this->_data->linkit = 'FF00FF';
		}
		return $this->_data;
	}
	function getMaxOrder()
	{
		$query = ' SELECT MAX(ordnum) as maxordnum FROM #__accordiongalleryc ';
		$this->_db->setQuery( $query );
		$maxordn = $this->_db->loadObject();
//print_r($maxordn);exit();
		if (!$maxordn) {
			$ret_Maxnumber = 0;
		} else {
			$ret_Maxnumber = $maxordn->maxordnum;
		}
		return $ret_Maxnumber;
	}
	/**
	 * Method to store a record
	 *
	 * @access    public
	 * @return    boolean    True on success
	 */
	function store()
	{
	
		//FOLDER FOR PICTURES
		//$gallery_path = JPATH_SITE . DS . $this->_images_folder;//JPATH_COMPONENT_SITE . DS . 'gallery';
		//if (!is_dir($gallery_path)) {
		//	mkdir($gallery_path, 0777);
		//}
	
		$row =& $this->getTable();
	 
		$data = JRequest::get( 'post' );
		$data['name'] = $_POST['name'];
		$data['descr'] = $_POST['descr'];
		if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1) {
			$data['descr'] = stripslashes($data['descr']);
			$data['name'] = stripslashes($data['name']);
		}
		
		$this->setId((int)$data['id']);
		$old_catinfo = $this->getCategory();
		
		//SET THE ORDER
		$max_ord_num = $this->getMaxOrder();
		//$update_order_after_insert_flag = false;
		$update_order_after_insert = array();
		$update_order_after_insert['insert_flag'] = false;
		$update_order_after_insert['new_ordnum'] = $data['ordnum']; //this order number will be written in the database for the pic (after insert will update)
		
		if ($old_catinfo->id > 0) {
			$update_order_after_insert['old_ordnum'] = $old_catinfo->ordnum;
			$update_order_after_insert['flag'] = 2;
		} else {
			$update_order_after_insert['flag']  = 1;
		}
		
		if($max_ord_num == 0) {
			$data['ordnum'] = 1;
		} else {
			if ($data['ordnum'] > 0 && $data['ordnum'] <= $max_ord_num) {
				if ($old_catinfo->id == 0 || $data['ordnum'] != $old_catinfo->ordnum) {
					$update_order_after_insert['insert_flag'] = true;
				}
			} else {
				$data['ordnum'] = $max_ord_num + 1;
			}
		}
		
		//FILES TO UPLOAD
		$galleries_path = JPATH_SITE . DS . $this->_categories_folder;//JPATH_COMPONENT_SITE . DS . 'galleries';
		if (!is_dir($galleries_path)) {
			mkdir($galleries_path, 0777);
		}
		$galleries_path = $galleries_path . DS;
		if (!file_exists($galleries_path . $this->_no_image_image)) {
			copy(JPATH_COMPONENT_SITE . DS . $this->_no_image_image, $galleries_path . $this->_no_image_image);
		}
		if (!file_exists($galleries_path . $this->_no_image_thumb)) {
			copy(JPATH_COMPONENT_SITE . DS . $this->_no_image_thumb, $galleries_path . $this->_no_image_thumb);
		}
		$move_uploaded_file_flag = false;
		$move_uploaded_image_file_flag = false;
		
		if ($_FILES["file"]["error"] > 0 || !($_FILES["file"]["type"] == "image/x-png" || $_FILES["file"]["type"] == "image/pjpeg" || $_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/gif"  || $_FILES["file"]["type"] == "image/bmp" || $_FILES["file"]["type"] == "image/png")) {

		} else {
			if ($old_catinfo->thumb != $this->_no_image_thumb) {
				$old_thumb_file = $galleries_path . $old_catinfo->thumb;
				if (file_exists($old_thumb_file)) {
					unlink($old_thumb_file);
				}
			}
			
			$old_catinfo->thumb = $_FILES["file"]["name"];
			$thumb_name_end = $old_catinfo->thumb;
			$noex_f_index = 0;
			while(file_exists($galleries_path . $thumb_name_end)) {
				$noex_f_index++;
				$thumb_ext = strrchr($old_catinfo->thumb, '.');
				$thumb_name_end = substr($old_catinfo->thumb, 0, -strlen($thumb_ext)) . '_' . $noex_f_index . $thumb_ext;				
			}
			
			if ($thumb_name_end != $old_catinfo->thumb) {
				$old_catinfo->thumb = $thumb_name_end;
			}
			
			$move_uploaded_file_flag = true;	
		}
		
		if ($_FILES["file1"]["error"] > 0 || !($_FILES["file1"]["type"] == "image/x-png" || $_FILES["file1"]["type"] == "image/pjpeg" || $_FILES["file1"]["type"] == "image/jpeg" || $_FILES["file1"]["type"] == "image/gif"  || $_FILES["file1"]["type"] == "image/bmp" || $_FILES["file1"]["type"] == "image/png")) {

		} else {
			if ($old_catinfo->image != $this->_no_image_image) {
				$old_image_file = $galleries_path . $old_catinfo->image;
				if (file_exists($old_image_file)) {
					unlink($old_image_file);
				}
			}
			
			$old_catinfo->image = $_FILES["file1"]["name"];
			$image_name_end = $old_catinfo->image;
			$noex_f_index = 0;
			while(file_exists($galleries_path . $image_name_end)) {
				$noex_f_index++;
				$image_ext = strrchr($old_catinfo->image, '.');
				$image_name_end = substr($old_catinfo->image, 0, -strlen($image_ext)) . '_' . $noex_f_index . $image_ext;				
			}
			
			if ($image_name_end != $old_catinfo->image) {
				$old_catinfo->image = $image_name_end;
			}
			
			$move_uploaded_image_file_flag = true;	
		}

		//If thumb and Large image files are equal - rename thumb
		if($old_catinfo->thumb == $old_catinfo->image) {
			$image_ext = strrchr($old_catinfo->thumb, '.');
			$old_catinfo->thumb = substr($old_catinfo->thumb, 0, -strlen($image_ext)) . '_thumb' . $image_ext;			
		}
		if ($move_uploaded_file_flag) {
			$save_file_name = $galleries_path . $old_catinfo->thumb;
		}
		if ($move_uploaded_image_file_flag) {
			$save_image_file_name = $galleries_path . $old_catinfo->image;
		}
		
		$data['thumb'] = $old_catinfo->thumb;
		$data['image'] = $old_catinfo->image;

		// Bind the form fields to the hello table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return $old_catinfo->id;
		}
	 
		// Make sure the category record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return $old_catinfo->id;
		}
	 
		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return $old_catinfo->id;
		}
		
		//Reorder Categories
		if ($old_catinfo->id > 0) {
			$update_order_after_insert['id'] = $old_catinfo->id;			
		} else {
			$update_order_after_insert['id'] = $this->_db->insertid();
		}
		
		
		if ($update_order_after_insert['insert_flag']) {
			if ($update_order_after_insert['flag'] == 1) {
				$this->ReorderCategories($update_order_after_insert['new_ordnum'], $update_order_after_insert['id']);
			} else {
				if ($update_order_after_insert['flag'] == 2) {
					$this->ReorderCategories($update_order_after_insert['new_ordnum'], $update_order_after_insert['id'], $update_order_after_insert['old_ordnum']);
				}
			}
		}
		
		//UPLOAD UPLOADED FILES
		if ($move_uploaded_image_file_flag) {
			move_uploaded_file($_FILES["file1"]["tmp_name"], $save_image_file_name);
		}
		if ($move_uploaded_file_flag) {
			move_uploaded_file($_FILES["file"]["tmp_name"], $save_file_name);
		}
		
		return $update_order_after_insert['id'];
	}

	function ReorderCategories($new_ordnum, $inserted_id, $old_ordnum = false)
	{
		if ($old_ordnum) {
			if ($new_ordnum > $old_ordnum) {
				$add_q = '- 1 WHERE ordnum <= ' . $new_ordnum . ' AND ordnum > ' . $old_ordnum;
			} else {
				$add_q = '+ 1 WHERE ordnum < ' . $old_ordnum . ' AND ordnum >= ' . $new_ordnum;
			}
		} else {
			$add_q = '+ 1 WHERE ordnum >= ' . $new_ordnum;
		}
	
		$up_query = 'UPDATE #__accordiongalleryc  SET ordnum = ordnum ' . $add_q;
		$this->_db->setQuery($up_query);
		$this->_db->query();
		
		$up_query = 'UPDATE #__accordiongalleryc  SET ordnum = ' . $new_ordnum . ' WHERE id = ' . $inserted_id;
		$this->_db->setQuery($up_query);
		$this->_db->query();
	}
	function ReorderDesc($deleted_ord_numb)
	{
		$up_query = 'UPDATE #__accordiongalleryc  SET ordnum = ordnum - 1 WHERE ordnum > '.$deleted_ord_numb;
		$this->_db->setQuery($up_query);
		$this->_db->query();		
	}
	/**
	 * unpublish one record from link
	 * @return void
	 */	
	function unpublish()
	{
		$c_id = JRequest::getVar( 'catid', 0, 'get', 'int' );
		if ($c_id && $c_id != 0) {
			$up_query = 'UPDATE #__accordiongalleryc  SET publish = 0 WHERE id = ' . $c_id;
			$this->_db->setQuery($up_query);
			$this->_db->query();
		}
	}
	/**
	 * publish one record from link
	 * @return void
	 */	
	function publish()
	{
		$c_id = JRequest::getVar( 'catid', 0, 'get', 'int' );
		if ($c_id && $c_id > 0) {
			$up_query = 'UPDATE #__accordiongalleryc  SET publish = 1 WHERE id = ' . $c_id;
			$this->_db->setQuery($up_query);
			$this->_db->query();
		}
	}	

	/**
	 * Method to delete record(s)
	 *
	 * @access    public
	 * @return    boolean    True on success
	 */
	function delete()
	{
		$result = true;
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$row =& $this->getTable();
	 
		foreach($cids as $cid) {
			$gallery_path = JPATH_SITE . DS . $this->_categories_folder . DS;//JPATH_COMPONENT_SITE . DS . 'galleries' . DS;
			$query = ' SELECT * FROM #__accordiongallery '
					 . ' WHERE catid = ' . $cid . ' LIMIT 1';
			$this->_db->setQuery( $query );
			$find_pics = $this->_db->loadObject();
			if (!$find_pics) {
				$query = ' SELECT * FROM #__accordiongalleryc '.
							'  WHERE id = ' . $cid;
				$this->_db->setQuery( $query );
				$curr_cat_info = $this->_db->loadObject();
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					$result = false;
					//return false;
				} else {
					$this->ReorderDesc($curr_cat_info->ordnum);
					if ($curr_cat_info->image != $this->_no_image_image) {
						$image_file_name = $gallery_path . $curr_cat_info->image;
						if (file_exists($image_file_name)) {
							unlink($image_file_name);
						}
					}
					if ($curr_cat_info->thumb != $this->_no_image_thumb) {
						$thumb_file_name = $gallery_path . $curr_cat_info->thumb;
						if (file_exists($thumb_file_name)) {
							unlink($thumb_file_name);
						}
					}
				}
			} else {
				$result = false;
			}
		}
		return $result;//true;
	}
	
}