<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$run = JRequest::getVar('run', false);
if (!$run) { ?>

<p><strong class="rsfirewall_red" style="font-size: 15px;">The System Check is limited in this version. Some security checks are being ignored.</strong> <?php echo _RSFIREWALL_MESSAGE; ?></p>

<h3><?php echo JText::_('RSF_SYSTEM_CHECK'); ?></h3>
<p id="rsfirewall_desc"><?php echo JText::_('RSF_CHECK_SYSTEM_DESC'); ?></p>
<button type="button" onclick="rsfirewall_check();" id="rsfirewall_button_check"><?php echo JText::_('RSF_CHECK_SYSTEM'); ?></button>

<img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/loading.gif" alt="" id="rsfirewall_loading" />

<div id="rsfirewall_response"></div>
<?php } ?>

<h3 id="rsfirewall_grade_up_heading"></h3>
<div id="rsfirewall_grade_up"></div>
<span class="rsfirewall_clear"></span>

<script type="text/javascript">
var xmlHttp

// System Check
function rsfirewall_check()
{
	document.getElementById('rsfirewall_loading').style.display = 'block';
	document.getElementById('rsfirewall_button_check').style.display = 'none';
	document.getElementById('rsfirewall_button_check').innerHTML = '<?php echo htmlspecialchars(addslashes(JText::_('RSF_RECHECK_SYSTEM'))); ?>';
	document.getElementById('rsfirewall_response').innerHTML='';
	document.getElementById('rsfirewall_desc').innerHTML = '<?php echo htmlspecialchars(addslashes(JText::_('RSF_CHECK_SYSTEM_DESC'))); ?>';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&view=check&run=true&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_check_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_check_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_response').innerHTML=xmlHttp.responseText;
		document.getElementById('rsfirewall_loading').style.display = 'none';
		document.getElementById('rsfirewall_desc').innerHTML = '<?php echo htmlspecialchars(addslashes(JText::_('RSF_CHECK_SYSTEM_COMPLETE_DESC'))); ?>';
		document.getElementById('rsfirewall_button_check').style.display = '';
		document.getElementById('rsfirewall_grade_up_heading').innerHTML = '&rarr; <?php echo htmlspecialchars(addslashes(JText::_('RSF_GRADE'))); ?>';
		document.getElementById('rsfirewall_grade_up').innerHTML = document.getElementById('rsfirewall_grade').innerHTML;
	}
}

// Fix file permissions
function rsfirewall_fix_file_permissions(thebutton)
{
	document.getElementById('rsfirewall_file_permissions_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=filePermissions&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_file_permissions_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_file_permissions_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_file_permissions').innerHTML=xmlHttp.responseText;
	}
}

// Fix folder permissions
function rsfirewall_fix_folder_permissions(thebutton)
{
	document.getElementById('rsfirewall_folder_permissions_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=folderPermissions&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_folder_permissions_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_folder_permissions_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_folder_permissions').innerHTML=xmlHttp.responseText;
	}
}

// Fix patterns
function rsfirewall_fix_patterns(thebutton)
{
	if (!confirm('<?php echo htmlspecialchars(addslashes(JText::_('RSF_FIX_PATTERNS_SURE'))); ?>')) return;
	document.getElementById('rsfirewall_patterns_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=patterns&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_patterns_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_patterns_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_patterns').innerHTML=xmlHttp.responseText;
	}
}

// Fix integrity
function rsfirewall_fix_integrity(thebutton)
{
	document.getElementById('rsfirewall_integrity_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=integrity&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_integrity_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_integrity_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_integrity').innerHTML=xmlHttp.responseText;
	}
}

// Fix PHP
function rsfirewall_fix_php(thebutton)
{
	document.getElementById('rsfirewall_php_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=php&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_php_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_php_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_php').innerHTML=xmlHttp.responseText;
	}
}

// Fix Temporary Files
function rsfirewall_fix_temp_files(thebutton)
{
	if (!confirm('<?php echo htmlspecialchars(addslashes(JText::_('RSF_FIX_TEMP_FILES_SURE'))); ?>')) return;
	document.getElementById('rsfirewall_temp_files_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=tempFiles&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_temp_files_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_temp_files_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_temp_files').innerHTML=xmlHttp.responseText;
	}
}

// XML HTTP Object
function rsfirewall_get_xml_http_object()
{
	var xmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}
</script>