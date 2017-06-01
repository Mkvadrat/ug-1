<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
 * Gallery View for Gallery XML Component
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.view' );

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
class GalleryViewItem extends JViewSST
{
	/**
	 * display method of Gallery view
	 * @return void
	 **/
	function display($tpl = null)
	{
		//get Gategories
		$categories    =& $this->get('Categories');
		//get the item
		$item        =& $this->get('Data');
		$isNew        = ($item->id < 1);
	 
		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( $text. ' Picture' ));
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
	 
		$this->assignRef('item', $item);
		$this->assignRef('categories', $categories);
		parent::display($tpl);
	}

}
