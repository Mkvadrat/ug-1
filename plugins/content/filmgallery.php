	<?php
/**
* Film Gallery Joomla! 1.5 Native Component
* @version 1.0.6
* @author DesignCompassCorp <admin@designcompasscorp.com>
* Copyright (C) 2010-2011 Design Compass corp
* @link http://www.designcompasscorp.com
* @license GNU/GPL **/

/*   
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    But you have to have a link to designcompasscorp.com website, on every
    page where you have Film Gallery visible.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License (see license.txt file)
    long with this program.  If not, see <http://www.gnu.org/licenses/>
*/

defined('_JEXEC') or die('Restricted access');


$mainframe->registerEvent('onPrepareContent', 'plgContentFilmGallery');

require_once('filmgalleryfiles'.DS.'render.php');

function plgContentFilmGallery(&$row, &$params, $page=0)
{
	$mainframel='3c6';
	
	$plugin =& JPluginHelper::getPlugin('content', 'filmgallery');
	$pluginParams = new JParameter( $plugin->params );
	
	$options=array();
	$fgc=new FilmGalleryClass;
	$fgc->copyprotection=$pluginParams->get( 'copyprotection' );
	$fgc->bgimagefolder='plugins/content/filmgalleryfiles/';
	
	if (is_object($row)) {
		$count=0;
		
		$text=$fgc->strip_html_tags_textarea($row->text);
		
		$fList=$fgc->getListToReplace('filmgallery',$options,$text,'{}');
		
		for($i=0; $i<count($fList);$i++)
		{
			$replaceWith=$fgc->getFilmGallery($options[$i],$i,$mainframel);
			$row->text=str_replace($fList[$i],$replaceWith,$row->text);	
		}
	
		$count+=count($fList);
	
		return (bool)$count;
	}
	
	
	$count=0;
		
	$text=$fgc->strip_html_tags_textarea($row);
	
	$fList=$fgc->getListToReplace('filmgallery',$options,$text,'{}');
		
	for($i=0; $i<count($fList);$i++)
	{
		$replaceWith=$fgc->getFilmGallery($options[$i],$i,$mainframel);
		$row=str_replace($fList[$i],$replaceWith,$row);	
	}
	
	$count+=count($fList);
	
	return (bool)$count;
	
	
	
}

?>

