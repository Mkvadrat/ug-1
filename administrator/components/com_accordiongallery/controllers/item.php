<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
/**
 * Gallery XML Component Controller
 */

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
class GalleryControllerItem extends JControllerSST
{

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
	 
		// Register Extra tasks
		$this->registerTask('add', 'edit');
	}
	
	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		$model = $this->getModel('item');
		if (!$model->getCategories()) {
			$msg = JText::_( 'Add category first' );
			$this->setRedirect( 'index.php?option=com_accordiongallery', $msg );
		} else {
			$params = &JComponentHelper::getParams('com_accordiongallery');
			$img_rfld = JPATH_SITE . DS . $params->get('pic_path', 'images/accordiongallery/gallery');
			if (is_dir($img_rfld)) {
				JRequest::setVar( 'view', 'item' );
				JRequest::setVar( 'layout', 'default'  );
				JRequest::setVar('hidemainmenu', 1);
				parent::display();
			} else {
				$msg = JText::_( 'Please create read/write folder ' . $img_rfld );
				$this->setRedirect( 'index.php?option=com_accordiongallery', $msg );
			}
		}
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('item');
	 
		if ($model->store()) {
			$msg = JText::_( 'Item Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Item' );
		}
	 
		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_accordiongallery';
		$this->setRedirect($link, $msg);
	}
	/**
	 * apply the changes (and redirect to form)
	 * @return void
	 */	
	function apply()
	{
		$model = $this->getModel('item');
		$pic_id_a = $model->store();
		if ($pic_id_a != 0) {
			$msg = JText::_( 'Item Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Item' );
		}
	 
		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_accordiongallery&controller=item&task=edit&cid[]=' . $pic_id_a;
		$this->setRedirect($link, $msg);
	}
	
	/**
	 * unpublish one record from link
	 * @return void
	 */
	function unpublish()
	{
		$model = $this->getModel('item');
		$model->unpublish();
		$this->setRedirect('index.php?option=com_accordiongallery');
	}
	/**
	 * publish one record from link
	 * @return void
	 */
	function publish()
	{
		$model = $this->getModel('item');
		$model->publish();
		$this->setRedirect('index.php?option=com_accordiongallery');
	}	
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('item');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Items Could not be Deleted' );
		} else {
			$msg = JText::_( 'Deleted' );
		}
	 
		$this->setRedirect( 'index.php?option=com_accordiongallery', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_accordiongallery', $msg );
	}
 
}
