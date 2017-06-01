<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<script type="text/javascript">
function addfile(filepath)
{
	var files = window.parent.document.getElementById('monitor_files');
	if (typeof(files)=='undefined' || files===null) 
		return false; 

	if (files.value.length == 0)
		files.value = filepath;
	else
		files.value += '\n'+filepath;
	
	window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 700);
	
	return false;
}
</script>

<div id="rsfirewall_explorer">

<div class="rsfirewall_explorer_header">
	<strong><?php echo JText::_('RSF_CURRENT_LOCATION'); ?></strong>
	<?php foreach ($this->elements as $element) { ?>
	<a href="index.php?option=com_rsfirewall&task=folders&tmpl=component&controller=configuration&folder=<?php echo urlencode($element->fullpath); ?>"><?php echo $element->name; ?></a> <?php echo DS; ?>
	<?php } ?>
</div>

<ul class="rsfirewall_explorer_list">
<?php foreach ($this->folders as $folder) { ?>
	<li class="folder"><a href="index.php?option=com_rsfirewall&task=folders&tmpl=component&controller=configuration&folder=<?php echo urlencode($folder->fullpath); ?>"><?php echo $folder->name; ?></a></li>
<?php } ?>
<?php foreach ($this->files as $file) { ?>
	<li class="file"><a href="javascript:void(0)" onclick="return addfile('<?php echo addslashes($file->fullpath); ?>');"><?php echo $file->name; ?></a></li>
<?php } ?>
</ul>

</div>