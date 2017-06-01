<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

/**
 * Categories View for Gallery XML Component
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
class GalleryViewCategories extends JViewSST
{
    /**
     * Categories view display method
     * @return void
     **/
    function display($tpl = null)
    {
        JToolBarHelper::title( JText::_( 'Category Manager' ), 'generic.png' );
        JToolBarHelper::deleteList('Are you sure?');
if(version_compare(JVERSION, '3.0.0', 'ge')) {
		JToolBarHelper::editList();
} else {
		JToolBarHelper::editListX();
}
if(version_compare(JVERSION, '3.0.0', 'ge')) {
        JToolBarHelper::addNew();
} else {
        JToolBarHelper::addNewX();
}
		JToolBarHelper::preferences('com_accordiongallery', '380');
		
		JSubMenuHelper::addEntry(JText::_('Pictures'), 'index.php?option=com_accordiongallery');
		JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_accordiongallery&controller=categories', true );
		JSubMenuHelper::addEntry(JText::_('Multiple Upload'), 'index.php?option=com_accordiongallery&controller=multiup');
 
        // Get data from the model
        $cats =& $this->get( 'Categories');
 
        $this->assignRef( 'cats', $cats );
 
        parent::display($tpl);
    }
}
