<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewFolders extends JView
{
	function display( $tpl = null )
	{
		$elements = $this->get('elements');
		$folders = $this->get('folders');
		$files = $this->get('files');
		
		$this->assignRef('files', $files);
		$this->assignRef('folders', $folders);
		$this->assignRef('elements', $elements);
		$this->assignRef('current_element',$current_element);
		
		parent::display($tpl);
	}
}