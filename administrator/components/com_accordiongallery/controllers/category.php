<?php
// No direct access
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');

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
class GalleryControllerCategory extends JControllerSST
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
		$params = &JComponentHelper::getParams('com_accordiongallery');
		$img_rfld = JPATH_SITE . DS . $params->get('cat_path', 'images/accordiongallery/galleries');
		if (is_dir($img_rfld)) {
			JRequest::setVar( 'view', 'category' );
			JRequest::setVar( 'layout', 'default' );
			JRequest::setVar('hidemainmenu', 1);
			parent::display();
		} else {
			$msg = JText::_( 'Please create read/write folder ' . $img_rfld );
			$this->setRedirect( 'index.php?option=com_accordiongallery&controller=categories', $msg );
		}
	}
	
	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('category');
	 
		if ($model->store()) {
			$msg = JText::_( 'Category Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Category' );
		}
	 
		$link = 'index.php?option=com_accordiongallery&controller=categories';
		$this->setRedirect($link, $msg);
	}
	/**
	 * apply a record changes (and redirect to form)
	 * @return void
	 */
	function apply()
	{
		$model = $this->getModel('category');
		
		$cat_id_a = $model->store();
		if ($cat_id_a != 0) {
			$msg = JText::_( 'Category Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Category' );
		}
	 
		$link = 'index.php?option=com_accordiongallery&controller=category&task=edit&cid[]=' . $cat_id_a;
		$this->setRedirect($link, $msg);
	}
	/**
	 * unpublish one record from link
	 * @return void
	 */
	function unpublish()
	{
		$model = $this->getModel('category');
		$model->unpublish();
		$this->setRedirect('index.php?option=com_accordiongallery&controller=categories');
	}
	/**
	 * publish one record from link
	 * @return void
	 */
	function publish()
	{
		$model = $this->getModel('category');
		$model->publish();
		$this->setRedirect('index.php?option=com_accordiongallery&controller=categories');
	}
	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('category');
		if(!$model->delete()) {
			$msg = JText::_( 'One or More Categories Could not be Deleted' );
		} else {
			$msg = JText::_( 'Deleted' );
		}
		$link = 'index.php?option=com_accordiongallery&controller=categories';
		$this->setRedirect( $link, $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$this->setRedirect( 'index.php?option=com_accordiongallery&controller=categories');
	}
 
}
