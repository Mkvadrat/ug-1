<?php
/**
* @package		RSFirewall!
* @copyright	Copyright (C) 2009 rsjoomla.com
* @license		GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root().'administrator/modules/mod_rsfirewall/mod_rsfirewall.css');
$document->addStyleSheet(JURI::root().'administrator/components/com_rsfirewall/assets/css/rsfirewall.css');

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'helpers'.DS.'rsfirewall.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'models'.DS.'rsfirewall.php');

$model = new RSFirewallModelRSFirewall();
$logs = $model->getLogs();

$lang =& JFactory::getLanguage();
$lang->load('com_rsfirewall');

$status = RSFirewallHelper::getConfig('active_scanner_status');
$lockdown = RSFirewallHelper::getConfig('lockdown');

$latestJoomla = RSFirewallHelper::getLatestJoomlaVersion();
$currentJoomla = RSFirewallHelper::getCurrentJoomlaVersion();

$latestFirewall = RSFirewallHelper::getLatestFirewallVersion();
$currentFirewall = RSFirewallHelper::getCurrentFirewallVersion();

$grade = RSFirewallHelper::getConfig('grade');
if ($grade > 0)
{
	if ($grade >= 75)
		$img = 'administrator/components/com_rsfirewall/assets/images/grade-green.jpg';
	else
		$img = 'administrator/components/com_rsfirewall/assets/images/grade-blue.jpg';
}
else
	$img = 'administrator/components/com_rsfirewall/assets/images/grade-grey.jpg';
?>
<div class="rsfirewall_cpanel_container">

<div style="width: 100%; position: relative; height: 90px;">

<a href="index.php?option=com_rsfirewall"><img src="<?php echo JURI::root(); ?>administrator/components/com_rsfirewall/assets/images/rsfirewall.jpg" alt="Protected by RSFirewall!" id="rsfirewall_cpanel_logo" width="233" height="70" /></a>

<div id="cpanel" style="position: absolute; top: 0px;">
<div style="float: left;">
	<div class="icon">
		<a href="index.php?option=com_rsfirewall&view=check" class="rsfirewall_grade_container">
			<span class="rsfirewall_grade"><?php echo $grade ? $grade : '0.0'; ?></span>
			<?php echo JHTML::_('image', $img, JText::_('RSF_GRADE')); ?>
			<span><?php echo JText::_('RSF_GRADE'); ?></span>
		</a>
	</div>
</div>
</div>

</div>

<span class="rsfirewall_clear"></span>
<?php if (RSFirewallHelper::isMasterLogged()) { ?>
	<table class="adminlist" align="center">
	<tbody>
	<tr>
		<td width="50%"><strong><?php echo JText::_('RSF_FIREWALL_STATUS'); ?></strong></td>
		<td><strong class="rsfirewall_cpanel_<?php echo $status ? 'green' : 'red'; ?>"><?php echo $status ? JText::_('RSF_ACTIVE') : JText::_('RSF_PAUSED'); ?></strong></td>
	</tr>
	<tr>
		<td width="50%"><strong><?php echo JText::_('RSF_SYSTEM_LOCKDOWN'); ?></strong></td>
		<td><strong class="rsfirewall_cpanel_<?php echo $lockdown ? 'green' : 'red'; ?>"><?php echo $lockdown ? JText::_('RSF_ACTIVE') : JText::_('RSF_PAUSED'); ?></strong></td>
	</tr>
	<tr>
		<td><strong>RSFirewall!</strong></td>
		<td><span class="rsfirewall_cpanel_<?php echo RSFirewallHelper::version_compare($currentFirewall, $latestFirewall) ? 'green' : 'red'; ?>"><?php echo JText::_('RSF_INSTALLED_VERSION'); ?> <?php echo $currentFirewall; ?></span><br />
		<span class="rsfirewall_cpanel_green"><?php echo JText::_('RSF_LATEST_VERSION'); ?> <?php echo $latestFirewall; ?></span></td>
	</tr>
	<tr>
		<td width="50%"><strong>Joomla!</strong></td>
		<td><span class="rsfirewall_cpanel_<?php echo RSFirewallHelper::version_compare($currentJoomla, $latestJoomla) ? 'green' : 'red'; ?>"><?php echo JText::_('RSF_INSTALLED_VERSION'); ?> <?php echo $currentJoomla; ?></span><br />
		<span class="rsfirewall_cpanel_green"><?php echo JText::_('RSF_LATEST_VERSION'); ?> <?php echo $latestJoomla; ?></span></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><a href="http://www.rsjoomla.com" target="_blank">www.rsjoomla.com</a></td>
	</tr>
	</tbody>
	</table>

	<?php if (count($logs) > 0) { ?>
	<h3><?php echo JText::_('RSF_LATEST_MESSAGES_SYSTEM_LOG'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th class="title"><?php echo JText::_('RSF_ALERT_LEVEL'); ?></th>
			<th><?php echo JText::_('RSF_DATE_EVENT'); ?></th>
			<th><?php echo JText::_('RSF_USERIP'); ?></th>
			<th><?php echo JText::_('RSF_USERID'); ?></th>
			<th><?php echo JText::_('RSF_USERNAME'); ?></th>
			<th><?php echo JText::_('RSF_PAGE'); ?></th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
		</tr>
	</thead>
	<?php foreach ($logs as $i => $log) { ?>
	<tr>
		<td class="rsfirewall_<?php echo $log->level; ?>"><?php echo JText::_('RSF_'.strtoupper($log->level)); ?></td>
		<td><?php echo date('d.m.Y H:i:s', $log->date); ?></td>
		<td><a href="http://www.rsjoomla.com/index.php?option=com_rslicense&task=whois&ip=<?php echo $log->ip; ?>" target="_blank"><?php echo $log->ip; ?></a></td>
		<td><?php echo $log->userid; ?></td>
		<td><?php echo $log->username; ?></td>
		<td><?php echo $log->page; ?></td>
		<td><?php echo JText::_('RSF_EVENT_'.strtoupper($log->code)); ?></td>
	</tr>
	<?php } ?>
	</table>
	<?php } ?>
	
<?php } ?>
</div>