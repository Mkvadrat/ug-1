<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

/**
 * Gallery table class
 */
 
// No direct access
defined('_JEXEC') or die('Restricted access');
 
/**
 * Gallery Table class
 */
class TableCategory extends JTable
{
    /**
     * Primary Key
     *
     * @vars int
     */
    var $id = null;
	var $catid = null;
	var $ordnum = null;
	var $publish = null; 
    /**
     * @vars string
     */
    var $name = null;
    var $descr = null;
	var $altthumb = null;
	var $altlarge = null;
	var $thumb = null;
	var $image = null;
	var $linkname = null;
	var $linkit = null;
	
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct( &$db ) {
        parent::__construct('#__accordiongalleryc', 'id', $db);
    }
}