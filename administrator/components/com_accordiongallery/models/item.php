<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

/**
 * Item Model for Gallery XML Component
 */
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
/**
 * Item Model
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
class GalleryModelItem extends JModelSST
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
	 
		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
		$this->_no_image_thumb = 'noimage_thumb.jpg';
		$this->_no_image_image = 'noimage.jpg';
		$params = &JComponentHelper::getParams('com_accordiongallery');
		$this->_categories_folder = $params->get('cat_path', 'images/accordiongallery/galleries');
		$this->_images_folder = $params->get('pic_path', 'images/accordiongallery/gallery');
	}
	
	/**
	 * Method to set the item id
	 *
	 * @access    public
	 * @param    int item identifier
	 * @return    void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id        	= $id;
		$this->_data  		= null;
	}

	/**
	 * Method to get a item data
	 * @return object with data
	 */
	 
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__accordiongallery '
					 . ' WHERE id = ' . $this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->catid = 1;			
			$this->_data->ordnum = 1;
			$this->_data->publish = 1;
			$this->_data->name = null;
			$this->_data->descr = null;
			$this->_data->altthumb = 'no image';
			$this->_data->altlarge = 'no image';
			$this->_data->thumb = $this->_no_image_thumb;
			$this->_data->image = $this->_no_image_image;
			$this->_data->linkname = null;
			$this->_data->linkit = null;
			$this->_data->reg_price = null;
			$this->_data->dis_price = null;
			$this->_data->medfld = 1;
		}
		return $this->_data;
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
	//Return Max ordnum (order number) of the category
	function getMaxOrder($categoryId)
	{
		$query = ' SELECT MAX(ordnum) as maxordnum FROM #__accordiongallery WHERE catid = ' . $categoryId;
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
		$row =& $this->getTable();
	 
		$data = JRequest::get( 'post' );
		$data['name'] = $_POST['name'];
		$data['descr'] = $_POST['descr'];
		if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1) {
			$data['descr'] = stripslashes($data['descr']);
			$data['name'] = stripslashes($data['name']);
		}
		$pattern_yt = '#[/&\?]v[=/]([^/&\?]+)#';
		if (trim($_POST['linkname']) != "" && preg_match($pattern_yt, trim($_POST['linkname']), $result_yt) > 0) {
			$data['linkname'] = $result_yt[1];
		}
		if ($_POST['medfld'] == 1) {
			if (($_FILES["file1"]["error"] > 0 || !(strtolower(substr($_FILES["file1"]["name"], -4)) == ".swf" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".flv" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".mp4" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".mov"))) {
				$data['medfld'] = 1;
			} else {
				$data['medfld'] = 2;
			}
		}
		$this->setId((int)$data['id']);
		$old_picinfo = $this->getData();
		
		//set the order
		$max_ord_num = $this->getMaxOrder($data['catid']);
		
		$update_order_after_insert = array();
		$update_order_after_insert['insert_flag'] = false;
		$update_order_after_insert['new_ordnum'] = $data['ordnum'];
		$update_order_after_insert['new_catid'] = $data['catid'];
		if ($old_picinfo->id > 0) {
			$update_order_after_insert['old_ordnum'] = $old_picinfo->ordnum;
			if ($old_picinfo->catid == $data['catid']) {
				$update_order_after_insert['flag'] = 2;
			} else {
				$update_order_after_insert['flag']  = 3;
				$update_order_after_insert['old_catid'] = $old_picinfo->catid;
			}
		} else {
			$update_order_after_insert['flag']  = 1;
		}
		
		//$update_order_after_insert_flag = false;
		if($max_ord_num == 0) {
			$data['ordnum'] = 1;
		} else {
			if ($data['ordnum'] > 0 && $data['ordnum'] <= $max_ord_num) {
				//if picture new or old picture get different ordnumber - than make reorder
				if ($old_picinfo->id == 0 || $data['ordnum'] != $old_picinfo->ordnum || $update_order_after_insert['flag'] == 3) {
					$update_order_after_insert['insert_flag'] = true;
					$update_order_after_insert['new_ordnum'] = $data['ordnum'];
					//$data['ordnum'] = $max_ord_num + 2;
				}
			} else {
				if ($update_order_after_insert['flag']  == 2) {
					$data['ordnum'] = $max_ord_num;
					$update_order_after_insert['insert_flag'] = true;
					$update_order_after_insert['new_ordnum'] = $data['ordnum'];
				} else {
					$data['ordnum'] = $max_ord_num + 1;
				}
			}
		}
		
		
		//FILES TO UPLOAD
		$move_uploaded_file_flag = false;
		$move_uploaded_image_file_flag = false;
		$gallery_path = JPATH_SITE . DS .$this->_images_folder;//JPATH_COMPONENT_SITE . DS . 'gallery' . DS;
		$new_gallery_path = $gallery_path;//$gallery_path . 'g' . $data['catid'];
		if (!is_dir($new_gallery_path)) {
			mkdir($new_gallery_path, 0777);
		}
		$gallery_path .= DS;
		$new_gallery_path = $gallery_path;
		if (!file_exists($new_gallery_path .  $this->_no_image_image)) {
			copy(JPATH_COMPONENT_SITE . DS . $this->_no_image_image, $new_gallery_path . $this->_no_image_image);
		}
		if (!file_exists($new_gallery_path . $this->_no_image_thumb)) {
			copy(JPATH_COMPONENT_SITE . DS . $this->_no_image_thumb, $new_gallery_path . $this->_no_image_thumb);
		}
		
		
		//$g_name = 'g' . $data['catid'];
		$save_file_path = $gallery_path;
		
		if ($_FILES["file"]["error"] > 0 || !(strtolower(substr($_FILES["file"]["name"], -5)) == ".jpeg" || strtolower(substr($_FILES["file"]["name"], -4)) == ".jpg" || strtolower(substr($_FILES["file"]["name"], -4)) == ".gif"  || strtolower(substr($_FILES["file"]["name"], -4)) == ".bmp" || strtolower(substr($_FILES["file"]["name"], -4)) == ".png" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".swf" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".flv" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".mp4" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".mov")) {

		} else {
			if ($old_picinfo->thumb != $this->_no_image_thumb) {
				$old_thumb_file = $new_gallery_path . $old_picinfo->thumb;
				if (file_exists($old_thumb_file)) {
					unlink($old_thumb_file);
				}
			}
			
			$old_picinfo->thumb = $_FILES["file"]["name"];
			$thumb_name_end = $old_picinfo->thumb;
			$noex_f_index = 0;
			while(file_exists($save_file_path . $thumb_name_end)) {
				$noex_f_index++;
				$thumb_ext = strrchr($old_picinfo->thumb, '.');
				$thumb_name_end = substr($old_picinfo->thumb, 0, -strlen($thumb_ext)) . '_' . $noex_f_index . $thumb_ext;				
			}
			
			if ($thumb_name_end != $old_picinfo->thumb) {
				$old_picinfo->thumb = $thumb_name_end;
			}
			
			$move_uploaded_file_flag = true;	
		}
		
		if ($_FILES["file1"]["error"] > 0 || $_POST['medfld'] > 10 || !(strtolower(substr($_FILES["file1"]["name"], -5)) == ".jpeg" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".jpg" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".gif"  || strtolower(substr($_FILES["file1"]["name"], -4)) == ".bmp" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".png" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".swf" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".flv" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".mp4" || strtolower(substr($_FILES["file1"]["name"], -4)) == ".mov")) {

		} else {
			if ($old_picinfo->image != $this->_no_image_image) {
				$old_image_file = $new_gallery_path . $old_picinfo->image;
				if (file_exists($old_image_file)) {
					unlink($old_image_file);
				}
			}
			
			$old_picinfo->image = $_FILES["file1"]["name"];
			$image_name_end = $old_picinfo->image;
			$noex_f_index = 0;
			while(file_exists($save_file_path . $image_name_end)) {
				$noex_f_index++;
				$image_ext = strrchr($old_picinfo->image, '.');
				$image_name_end = substr($old_picinfo->image, 0, -strlen($image_ext)) . '_' . $noex_f_index . $image_ext;				
			}
			
			if ($image_name_end != $old_picinfo->image) {
				$old_picinfo->image = $image_name_end;
			}
			
			$move_uploaded_image_file_flag = true;	
		}

		//If thumb and Large image files are equal - rename thumb
		if($old_picinfo->thumb == $old_picinfo->image) {
			$image_ext = strrchr($old_picinfo->thumb, '.');
			$old_picinfo->thumb = substr($old_picinfo->thumb, 0, -strlen($image_ext)) . '_thumb' . $image_ext;			
		}
		if ($move_uploaded_file_flag) {
			$save_file_name = $save_file_path . $old_picinfo->thumb;
		}
		if ($move_uploaded_image_file_flag) {
			$save_image_file_name = $save_file_path . $old_picinfo->image;
		}
		
		$data['thumb'] = $old_picinfo->thumb;
		$data['image'] = $old_picinfo->image;
		
		// Bind the form fields to the hello table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return $old_picinfo->id;
		}
	 
		// Make sure the item record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return $old_picinfo->id;
		}
	 
		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return $old_picinfo->id;
		}
		
		//Reorder Pics
		if ($old_picinfo->id > 0) {
			$update_order_after_insert['id'] = $old_picinfo->id;			
		} else {
			$update_order_after_insert['id'] = $this->_db->insertid();
		}
		
		if ($update_order_after_insert['insert_flag']) {
			if ($update_order_after_insert['flag'] == 1 || $update_order_after_insert['flag'] == 3) {
				$this->ReorderPics($update_order_after_insert['new_catid'], $update_order_after_insert['new_ordnum'], $update_order_after_insert['id']);
			} else {
				if ($update_order_after_insert['flag'] == 2) {
					$this->ReorderPics($update_order_after_insert['new_catid'], $update_order_after_insert['new_ordnum'], $update_order_after_insert['id'], $update_order_after_insert['old_ordnum']);
				}
			}
		}
		if ($update_order_after_insert['flag'] == 3) {
			$this->ReorderDesc($update_order_after_insert['old_catid'], $update_order_after_insert['old_ordnum']);
		}
		//UPLOAD UPLOADED FILES
		if ($move_uploaded_image_file_flag && $_POST['medfld'] < 11 ) {
			move_uploaded_file($_FILES["file1"]["tmp_name"], $save_image_file_name);
		}
		if ($move_uploaded_file_flag) {
			move_uploaded_file($_FILES["file"]["tmp_name"], $save_file_name);
		}	
		return $update_order_after_insert['id'];
	}
	
	function ReorderPics($cat_id, $new_ordnum, $pic_id, $old_ordnum = false)
	{
		if ($old_ordnum) {
			if ($new_ordnum > $old_ordnum) {
				$add_q = '- 1 WHERE catid = ' . $cat_id . ' AND ordnum <= ' . $new_ordnum . ' AND ordnum > ' . $old_ordnum;
			} else {
				$add_q = '+ 1 WHERE catid = ' . $cat_id . ' AND ordnum < ' . $old_ordnum . ' AND ordnum >= ' . $new_ordnum;
			}
		} else {
			$add_q = '+ 1 WHERE catid = ' . $cat_id . ' AND ordnum >= ' . $new_ordnum;
		}
		$up_query = 'UPDATE #__accordiongallery  SET ordnum = ordnum ' . $add_q;
		$this->_db->setQuery($up_query);
		$this->_db->query();

		$up_query = 'UPDATE #__accordiongallery  SET ordnum = ' . $new_ordnum . ' WHERE id = ' . $pic_id;
		$this->_db->setQuery($up_query);
		$this->_db->query();
	}
	function ReorderDesc($cat_id, $deleted_ordnum)
	{
		$up_query = 'UPDATE #__accordiongallery  SET ordnum = ordnum - 1 WHERE catid = ' . $cat_id . ' AND ordnum > '.$deleted_ordnum;
		$this->_db->setQuery($up_query);
		$this->_db->query();
	}
	
	/**
	 * unpublish one record from link
	 * @return void
	 */	
	function unpublish()
	{
		$p_id = JRequest::getVar( 'picid', 0, 'get', 'int' );
		if ($p_id && $p_id != 0) {
			$up_query = 'UPDATE #__accordiongallery  SET publish = 0 WHERE id = ' . $p_id;
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
		$p_id = JRequest::getVar( 'picid', 0, 'get', 'int' );
		if ($p_id && $p_id > 0) {
			$up_query = 'UPDATE #__accordiongallery  SET publish = 1 WHERE id = ' . $p_id;
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
		$gallery_path = JPATH_SITE . DS . $this->_images_folder . DS;//JPATH_COMPONENT_SITE . DS . 'gallery' . DS;
		
		foreach($cids as $cid) {
			$this->setId($cid);
			$pic_info = $this->getData();
			
			if (!$row->delete( $cid )) {
				$this->setError( $row->getErrorMsg() );
				$result = false;//return false;
			} else {
				if ($pic_info->image != $this->_no_image_image) {
					$image_file_name = $gallery_path . $pic_info->image;
					if (file_exists($image_file_name)) {
						unlink($image_file_name);
					}
				}
				if ($pic_info->thumb != $this->_no_image_thumb) {
					$thumb_file_name = $gallery_path . $pic_info->thumb;
					if (file_exists($thumb_file_name)) {
						unlink($thumb_file_name);
					}
				}
				$this->ReorderDesc($pic_info->catid, $pic_info->ordnum);
			}
		}
		return $result;
	}
	
}
