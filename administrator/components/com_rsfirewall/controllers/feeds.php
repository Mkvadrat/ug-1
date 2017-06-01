<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RSFirewallControllerFeeds extends RSFirewallController
{
	function __construct()
	{
		parent::__construct();
		$this->registerTask('orderup', 'move');
		$this->registerTask('orderdown', 'move');
		$this->registerTask('apply', 'save');
	}
	
	/**
	 * Display "New" / "Edit"
	 */
	function editfeed()
	{
		JRequest::setVar('view', 'feeds');
		JRequest::setVar('layout', 'edit');
		parent::display();
	}
	
	/**
	 * Save the ordering
	 */
	function saveOrder()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');

		// Get the model
		$model = $this->getModel('feeds');
		
		// Get the table instance
		$feed =& JTable::getInstance('RSFirewall_Feeds','Table');
		
		// Get the selected feeds
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		
		// Get the ordering
		$order = JRequest::getVar( 'order', array (0), 'post', 'array' );
		
		// Force array elements to be integers
		JArrayHelper::toInteger($cid, array(0));
		JArrayHelper::toInteger($order, array(0));
		
		// Load each element of the array
		for ($i=0;$i<count($cid);$i++)
		{
			// Load the feed
			$feed->load($cid[$i]);
			
			// Set the new ordering only if different
			if ($feed->ordering != $order[$i])
			{	
				$feed->ordering = $order[$i];
				if (!$feed->store()) 
				{
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}
		// Redirect
		$this->setRedirect('index.php?option=com_rsfirewall&view=feeds', JText::_('RSF_FEEDS_ORDERED'));
	}
	
	/**
	 * Logic to move feeds
	 */
	function move() 
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Get the model
		$model = $this->getModel('feeds');
		
		// Get the table instance
		$feed =& JTable::getInstance('RSFirewall_Feeds','Table');
		
		// Get the selected feeds
		$cid = JRequest::getVar('cid', array(0), 'post', 'array');
		
		// Get the task
		$task = JRequest::getCmd('task');
		
		// Force array elements to be integers
		JArrayHelper::toInteger($cid, array(0));
		
		// Set the direction to move
		$direction = $task == 'orderup' ? -1 : 1;
		
		// Can move only one element
		if (is_array($cid))	$cid = $cid[0];
		
		// Load feed
		if (!$feed->load($cid)) 
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// Move
		$feed->move($direction);
	
		// Redirect
		$this->setRedirect('index.php?option=com_rsfirewall&view=feeds');
	}
	
	/**
	 * Logic to publish feeds
	 */
	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Get the model
		$model = $this->getModel('feeds');
		
		// Get the selected feeds
		$cid = JRequest::getVar('cid', array(0), 'post', 'array');

		// Force array elements to be integers
		JArrayHelper::toInteger($cid, array(0));
		
		// No feeds are selected
		if (!is_array($cid) || count($cid) < 1)
		{
			$msg = '';
			JError::raiseWarning(500, JText::_('SELECT ITEM PUBLISH'));
		}
		// Try to publish the feed
		else
		{
			if (!$model->publish($cid, 1))
				JError::raiseError(500, $model->getError());

			$total = count($cid);
			$msg = $total.' '.JText::_('RSF_FEEDS_PUBLISHED');
			
			// Clean the cache, if any
			$cache =& JFactory::getCache('com_rsfirewall');
			$cache->clean();
		}
		
		// Redirect
		$this->setRedirect('index.php?option=com_rsfirewall&view=feeds', $msg);
	}

	/**
	 * Logic to unpublish feeds
	 */
	function unpublish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
		
		// Get the model
		$model = $this->getModel('feeds');
		
		// Get the selected feeds
		$cid = JRequest::getVar('cid', array(0), 'post', 'array');

		// Force array elements to be integers
		JArrayHelper::toInteger($cid, array(0));
		
		// No feeds are selected
		if (!is_array($cid) || count($cid) < 1)
		{
			$msg = '';
			JError::raiseWarning(500, JText::_('SELECT ITEM PUBLISH'));
		}
		// Try to publish the feed
		else
		{
			if (!$model->publish($cid, 0))
				JError::raiseError(500, $model->getError());

			$total = count($cid);
			$msg = $total.' '.JText::_('RSF_FEEDS_UNPUBLISHED');
			
			// Clean the cache, if any
			$cache =& JFactory::getCache('com_rsfirewall');
			$cache->clean();
		}
		
		// Redirect
		$this->setRedirect('index.php?option=com_rsfirewall&view=feeds', $msg);
	}
	
	/**
	 * Logic to remove feeds
	 */
	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');

		// Get the model
		$model = $this->getModel('feeds');
		
		// Get the selected feeds
		$cid = JRequest::getVar('cid', array(0), 'post', 'array');

		// Force array elements to be integers
		JArrayHelper::toInteger($cid, array(0));
		
		// No feeds are selected
		if (!is_array($cid) || count($cid) < 1)
		{
			$msg = '';
			JError::raiseWarning(500, JText::_('SELECT ITEM DELETE'));
		}
		// Try to remove the feed
		else
		{
			$model->remove($cid);
			
			$total = count($cid);
			$msg = $total.' '.JText::_('RSF_FEEDS_DELETED');
			
			// Clean the cache, if any
			$cache =& JFactory::getCache('com_rsfirewall');
			$cache->clean();
		}
		
		// Redirect
		$this->setRedirect('index.php?option=com_rsfirewall&view=feeds', $msg);
	}
	
	/**
	 * Logic to save feeds
	 */
	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get the model
		$model = $this->getModel('feeds');
		
		// Save
		$return = $model->save();
		
		// Redirect
		$this->setRedirect($return['link'], $return['msg']);
	}
}
?>