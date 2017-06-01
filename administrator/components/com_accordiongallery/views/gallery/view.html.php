<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
 * Gallery View for Gallery XML Component
 */
 
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.view' );
 
/**
 * Gallery View
 */

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
class GalleryViewGallery extends JViewSST
{
    /**
     * Gallery view display method
     * @return void
     **/
    function display($tpl = null)
    {
        JToolBarHelper::title( JText::_( 'Gallery Manager' ), 'generic.png' );
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

		JSubMenuHelper::addEntry(JText::_('Pictures'), 'index.php?option=com_accordiongallery', true );
		JSubMenuHelper::addEntry(JText::_('Categories'), 'index.php?option=com_accordiongallery&controller=categories');
		JSubMenuHelper::addEntry(JText::_('Multiple Upload'), 'index.php?option=com_accordiongallery&controller=multiup');

		$jsession =& JFactory::getSession();
		
		$gmodel = $this->getModel('gallery');
		
		if (isset($_POST['showcat'])) {
			$showcat = $_POST['showcat'];
			$jsession->set( 's_showcat', $showcat );
		} else {
			if ($jsession->has('s_showcat')) {
				$showcat = $jsession->get('s_showcat');
			} else {
				$showcat = 0;
			}
		}
		
        // Get data from the model
        $items_data =& $gmodel->getData($showcat);
		//get Gategories
		$categories    =& $this->get('Categories');
		
		$this->assignRef('pagination', $items_data['pagination']);
 
		$this->assignRef( 'items', $items_data['items'] );
		$this->assignRef( 'categories', $categories );
		$this->assignRef( 'showcat', $showcat );
 
        parent::display($tpl);
    }
}
