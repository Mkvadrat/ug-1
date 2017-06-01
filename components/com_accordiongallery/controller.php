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
class GalleryController extends JControllerSST
{
    /**
     * Method to display the view
     *
     * @access    public
     */
    function display()
    {
        parent::display();
    }
 
}
