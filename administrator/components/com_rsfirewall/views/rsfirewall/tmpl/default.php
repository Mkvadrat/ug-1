<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

if ($this->grade > 0)
{
	if ($this->grade >= 75)
		$img = 'administrator/components/com_rsfirewall/assets/images/grade-green.jpg';
	else
		$img = 'administrator/components/com_rsfirewall/assets/images/grade-blue.jpg';
}
else
	$img = 'administrator/components/com_rsfirewall/assets/images/grade-grey.jpg';

JHTML::_('behavior.tooltip');
?>

<?php if (!$this->pluginEnabled) { ?>
<div class="rsfirewall_tooltip rsfirewall_warning">
	<strong><?php echo JText::_('RSF_RSFIREWALL_ACTIVE_SCANNER'); ?></strong>
	<p><?php echo JText::_('RSF_WARNING_PLUGIN_DISABLED'); ?></p>
</div>
<?php } ?>

<table>
<tr>
	<td width="50%" valign="top">

<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td valign="top">
		<table class="adminlist">
			<tr>
				<td>
					<div id="cpanel">
					<div style="float: left">
						<div class="icon hasTip" title="<?php echo JText::_('RSF_SYSTEM_CHECK_DESC'); ?>">
							<a href="index.php?option=com_rsfirewall&amp;view=check">
								<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/check.png', JText::_('RSF_SYSTEM_CHECK')); ?>
								<span><?php echo JText::_('RSF_SYSTEM_CHECK'); ?></span>
							</a>
						</div>
					</div>
					<div style="float: left">
						<div class="icon hasTip" title="<?php echo JText::_('RSF_SYSTEM_LOGS_DESC'); ?>">
							<a href="index.php?option=com_rsfirewall&amp;view=logs">
								<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/logs.png', JText::_('RSF_SYSTEM_LOGS')); ?>
								<span><?php echo JText::_('RSF_SYSTEM_LOGS'); ?></span>
							</a>
						</div>
					</div>
					<div style="float: left">
						<div class="icon hasTip" title="<?php echo JText::_('RSF_SYSTEM_LOCKDOWN_DESC'); ?>">
							<a href="index.php?option=com_rsfirewall&amp;view=lockdown">
								<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/lockdown.png', JText::_('RSF_SYSTEM_LOCKDOWN')); ?>
								<span><?php echo JText::_('RSF_SYSTEM_LOCKDOWN'); ?></span>
							</a>
						</div>
					</div>
					<div style="float: left">
						<div class="icon hasTip" title="<?php echo JText::_('RSF_FIREWALL_CONFIGURATION_DESC'); ?>">
							<a href="index.php?option=com_rsfirewall&amp;view=configuration">
								<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/configuration.png', JText::_('RSF_FIREWALL_CONFIGURATION')); ?>
								<span><?php echo JText::_('RSF_FIREWALL_CONFIGURATION'); ?></span>
							</a>
						</div>
					</div>
					<div style="float: left">
						<div class="icon hasTip" title="<?php echo JText::_('RSF_FEEDS_CONFIGURATION_DESC'); ?>">
							<a href="index.php?option=com_rsfirewall&amp;view=feeds">
								<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/feeds.png', JText::_('RSF_FEEDS_CONFIGURATION')); ?>
								<span><?php echo JText::_('RSF_FEEDS_CONFIGURATION'); ?></span>
							</a>
						</div>
					</div>
					<div style="float: left">
						<div class="icon hasTip" title="<?php echo JText::_('RSF_UPDATES_DESC'); ?>">
							<a href="index.php?option=com_rsfirewall&view=updates">
								<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/updates.png', JText::_('RSF_UPDATES')); ?>
								<span><?php echo JText::_('RSF_UPDATES'); ?></span>
							</a>
						</div>
					</div>
					<div style="float: left">
						<div class="icon hasTip" title="<?php echo $this->grade ? JText::_('RSF_GRADE_RUN') : JText::_('RSF_GRADE_NOT_RUN'); ?>">
							<a href="javascript: void(0)" class="rsfirewall_grade_container">
								<span class="rsfirewall_grade"><?php echo $this->grade ? $this->grade : '0.0'; ?></span>
								<?php echo JHTML::_('image', $img, JText::_('RSF_GRADE')); ?>
								<span><?php echo JText::_('RSF_GRADE'); ?></span>
							</a>
						</div>
					</div>
					</div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<span class="rsfirewall_clear"></span>