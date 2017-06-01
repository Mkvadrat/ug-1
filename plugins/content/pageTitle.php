<?php
/**
* @copyright	Copyright (C) 2005 - 2008 Arlifax Pty Ltd. All rights reserved.
* @license		GNU/GPL
*/

// Check for access
defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent( 'onAfterDisplayTitle', 'plgContentPageTitle' );

/**
* Plugin that changes an articles tile from the Article title to the Key Reference.
*/
function plgContentPageTitle( &$row, &$params, $page=0 )
{
	if( strlen($params->get('keyref')) > 0 )
    	{
        	$document= & JFactory::getDocument();
        	$document->setTitle( $params->get('keyref'));
	 }
}
?>