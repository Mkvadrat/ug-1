<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

if ($this->grade >= 75)
	$img = 'administrator/components/com_rsfirewall/assets/images/grade-green.jpg';
else
	$img = 'administrator/components/com_rsfirewall/assets/images/grade-blue.jpg';

defined('_JEXEC') or die('Restricted access');
?>

<h3>&rarr; <?php echo JText::_('RSF_GRADE'); ?></h3>

<div id="rsfirewall_grade">

<div id="cpanel">
<div style="float: left">
	<div class="icon">
		<a href="javascript: void(0)" class="rsfirewall_grade_container">
			<span class="rsfirewall_grade"><?php echo $this->grade ? $this->grade : '0.0'; ?></span>
			<?php echo JHTML::_('image', $img, JText::_('RSF_GRADE')); ?>
			<span><?php echo JText::_('RSF_GRADE'); ?></span>
		</a>
	</div>
</div>
</div>

</div>