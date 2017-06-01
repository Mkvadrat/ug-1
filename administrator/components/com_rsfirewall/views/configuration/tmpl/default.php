<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
?>

<script type="text/javascript">
function rsfirewall_enable_master_password(thevalue)
{
	if (thevalue == 1)
	{
		document.getElementById('master_password').disabled = false;
		document.getElementById('master_password_span').style.display = '';
	}
	else
	{
		document.getElementById('master_password').disabled = true;
		document.getElementById('master_password_span').style.display = 'none';
	}
}

function rsfirewall_enable_backend_password(thevalue)
{
	if (thevalue == 1)
	{
		document.getElementById('backend_password').disabled = false;
		document.getElementById('backend_password_span').style.display = '';
		document.getElementById('whitelist_ip1').disabled = false;
		document.getElementById('whitelist_ip2').disabled = false;
		document.getElementById('whitelist_ip3').disabled = false;
		document.getElementById('whitelist_ip4').disabled = false;
		document.getElementById('backend_whitelist_ips').disabled = false;
		document.getElementById('rsfirewall_add_ip_whitelist').disabled = false;
	}
	else
	{
		document.getElementById('backend_password').disabled = true;
		document.getElementById('backend_password_span').style.display = 'none';
		document.getElementById('whitelist_ip1').disabled = true;
		document.getElementById('whitelist_ip2').disabled = true;
		document.getElementById('whitelist_ip3').disabled = true;
		document.getElementById('whitelist_ip4').disabled = true;
		document.getElementById('backend_whitelist_ips').disabled = true;
		document.getElementById('rsfirewall_add_ip_whitelist').disabled = true;
	}
}

function rsfirewall_enable_backend_access_control(thevalue)
{
	if (thevalue == 1)
	{
		document.getElementById('backend_access_users').disabled = false;
		document.getElementById('backend_access_components').disabled = false;
	}
	else
	{
		document.getElementById('backend_access_users').disabled = true;
		document.getElementById('backend_access_components').disabled = true;
	}
}

function rsfirewall_enable_active_scanner_status(thevalue)
{
	if (thevalue == 1)
	{
		document.getElementById('verify_dos0').disabled = false;
		document.getElementById('verify_dos1').disabled = false;
		document.getElementById('verify_sql0').disabled = false;
		document.getElementById('verify_sql1').disabled = false;
		document.getElementById('verify_sql_skip').disabled = false;
		document.getElementById('verify_php0').disabled = false;
		document.getElementById('verify_php1').disabled = false;
		document.getElementById('verify_php_skip').disabled = false;
		document.getElementById('verify_js0').disabled = false;
		document.getElementById('verify_js1').disabled = false;
		document.getElementById('verify_js_skip').disabled = false;
		document.getElementById('verify_multiple_exts0').disabled = false;
		document.getElementById('verify_multiple_exts1').disabled = false;
		document.getElementById('verify_upload0').disabled = false;
		document.getElementById('verify_upload1').disabled = false;
		document.getElementById('verify_upload_blacklist_exts').disabled = false;
		document.getElementById('monitor_core0').disabled = false;
		document.getElementById('monitor_core1').disabled = false;
		document.getElementById('filesPathChange').style.display = '';
		document.getElementById('monitor_files').disabled = false;
		document.getElementById('monitor_users').disabled = false;
	}
	else
	{
		document.getElementById('verify_dos0').disabled = true;
		document.getElementById('verify_dos1').disabled = true;
		document.getElementById('verify_sql0').disabled = true;
		document.getElementById('verify_sql1').disabled = true;
		document.getElementById('verify_sql_skip').disabled = true;
		document.getElementById('verify_php0').disabled = true;
		document.getElementById('verify_php1').disabled = true;
		document.getElementById('verify_php_skip').disabled = true;
		document.getElementById('verify_js0').disabled = true;
		document.getElementById('verify_js1').disabled = true;
		document.getElementById('verify_js_skip').disabled = true;
		document.getElementById('verify_multiple_exts0').disabled = true;
		document.getElementById('verify_multiple_exts1').disabled = true;
		document.getElementById('verify_upload0').disabled = true;
		document.getElementById('verify_upload1').disabled = true;
		document.getElementById('verify_upload_blacklist_exts').disabled = true;
		document.getElementById('monitor_core0').disabled = true;
		document.getElementById('monitor_core1').disabled = true;
		document.getElementById('filesPathChange').style.display = 'none';
		document.getElementById('monitor_files').disabled = true;
		document.getElementById('monitor_users').disabled = true;
	}
}

function rsfirewall_add_ip(placeholder, iplist)
{
	var message = '<?php echo addslashes(JText::_('RSF_IP_ERROR')); ?>';
	var message2 = '<?php echo addslashes(JText::_('RSF_IP_MASK_ERROR')); ?>';
	
	var part1 = document.getElementById(placeholder + '1').value != '*' ? parseInt(document.getElementById(placeholder + '1').value) : '*';
	var part2 = document.getElementById(placeholder + '2').value != '*' ? parseInt(document.getElementById(placeholder + '2').value) : '*';
	var part3 = document.getElementById(placeholder + '3').value != '*' ? parseInt(document.getElementById(placeholder + '3').value) : '*';
	var part4 = document.getElementById(placeholder + '4').value != '*' ? parseInt(document.getElementById(placeholder + '4').value) : '*';
	
	if ((part1 != '*' && (isNaN(part1) || part1 < 0 || part1 > 255)) || (part2 != '*' && (isNaN(part2) || part2 < 0 || part2 > 255)) || (isNaN(part3) || part3 != '*' && (part3 < 0 || part3 > 255)) || (isNaN(part4) || part4 != '*' && (part4 < 0 || part4 > 255)))
	{
		alert(message);
		return false;
	}
	
	var ip = part1 + '.' + part2 + '.' + part3 + '.' + part4;
	
	if (ip == '*.*.*.*')
	{
		alert(message2);
		return false;
	}
	
	
	//var filter = /(([0-1]?[0-9]{1,2}\.)|(2[0-4][0-9]\.)|(25[0-5]\.)){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))/;
	//if (filter.test(ip))
	//{
		if (document.getElementById(iplist).value.length > 0)
			document.getElementById(iplist).value += "\n" + ip;
		else
			document.getElementById(iplist).value = ip;
		document.getElementById(placeholder + '1').value = '';
		document.getElementById(placeholder + '2').value = '';
		document.getElementById(placeholder + '3').value = '';
		document.getElementById(placeholder + '4').value = '';
		return true;
	//}
	//else
	//{
	//	alert(message);
	//	return false;
	//}
}

function rsfirewall_numeric(what)
{
	what.value=what.value.replace(/[^0-9*]/g, '');
	if (what.value.indexOf('*') != '-1')
		what.value = '*';
}

function rsfirewall_change_master_password(what)
{
	if (what.value.length < 6)
		document.getElementById('master_password_span').innerHTML = '<img src="<?php echo JURI :: root(); ?>administrator/images/publish_y.png" alt="" /> <?php echo JText::_('RSF_MASTER_PASSWORD_CHANGING'); ?>';
	else
		document.getElementById('master_password_span').innerHTML = '<img src="<?php echo JURI :: root(); ?>administrator/images/publish_y.png" alt="" /> <?php echo JText::_('RSF_MASTER_PASSWORD_CHANGING_OK'); ?>';
}

function rsfirewall_change_backend_password(what)
{
	if (what.value.length < 6)
		document.getElementById('backend_password_span').innerHTML = '<img src="<?php echo JURI :: root(); ?>administrator/images/publish_y.png" alt="" /> <?php echo JText::_('RSF_BACKEND_PASSWORD_CHANGING'); ?>';
	else
		document.getElementById('backend_password_span').innerHTML = '<img src="<?php echo JURI :: root(); ?>administrator/images/publish_y.png" alt="" /> <?php echo JText::_('RSF_BACKEND_PASSWORD_CHANGING_OK'); ?>';
}

</script>

<p><strong class="rsfirewall_red" style="font-size: 15px;">The Firewall Configuration is not functional in this version. You can change these settings to get a feel of the options available, but you will not be actively protected.</strong> <?php echo _RSFIREWALL_MESSAGE; ?></p>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<?php
echo $this->pane->startPane('stat-pane');

echo $this->pane->startPanel(JText::_('RSF_RSFIREWALL_ACCESS'), 'rsfirewall');
?>
<div class="rsfirewall_tooltip">
	<strong><?php echo JText::_('RSF_RSFIREWALL_ACCESS'); ?></strong>
	<p><?php echo JText::_('RSF_RSFIREWALL_ACCESS_DESC'); ?></p>
</div>
<div class="col100">
	<fieldset class="adminform">
		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_ENABLE_MASTER_PASSWORD_DESC'); ?>">
				<?php echo JText::_('RSF_ENABLE_MASTER_PASSWORD'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','master_password_enabled', 'onclick="rsfirewall_enable_master_password(this.value)"', $this->config->master_password_enabled); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_MASTER_PASSWORD_DESC'); ?>">
				<?php echo JText::_('RSF_MASTER_PASSWORD'); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="password" name="master_password" id="master_password" size="35" value="" <?php echo $this->config->master_password_enabled == 0 ? 'disabled="disabled"' : ''; ?> onkeyup="rsfirewall_change_master_password(this)" />
				<span <?php echo $this->config->master_password_enabled == 1 ? '' : 'style="display: none"'; ?> id="master_password_span">
					<?php if (strlen($this->config->master_password) > 0) { ?>
					<img src="<?php echo JURI :: root(); ?>administrator/images/tick.png" alt="" />
					<?php echo JText::_('RSF_MASTER_PASSWORD_SET'); ?>
					<?php } else { ?>
					<img src="<?php echo JURI :: root(); ?>administrator/images/publish_x.png" alt="" />
					<?php echo JText::_('RSF_MASTER_PASSWORD_NOT_SET'); ?>
					<?php } ?>
				</span>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_LICENSE_CODE_DESC'); ?>">
				<?php echo JText::_('RSF_LICENSE_CODE'); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="global_register_code" id="global_register_code" size="35" value="<?php echo $this->config->global_register_code; ?>" />
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<?php
echo $this->pane->endPanel();

echo $this->pane->startPanel(JText::_('RSF_BLACKLIST'), 'rsfirewall_blacklist');
?>
<div class="rsfirewall_tooltip">
	<strong><?php echo JText::_('RSF_BLACKLIST'); ?></strong>
	<p><?php echo JText::_('RSF_BLACKLIST_DESC'); ?></p>
</div>
<div class="col100">
	<fieldset class="adminform">
		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_ADD_BLACKLIST_IP_DESC'); ?>">
				<?php echo JText::_('RSF_ADD_BLACKLIST_IP'); ?>
				</span>
			</td>
			<td>
				<input type="text" name="blacklist_ip1" id="blacklist_ip1" value="" size="3" maxlength="3" onkeyup="rsfirewall_numeric(this)" />.
				<input type="text" name="blacklist_ip2" id="blacklist_ip2" value="" size="3" maxlength="3" onkeyup="rsfirewall_numeric(this)" />.
				<input type="text" name="blacklist_ip3" id="blacklist_ip3" value="" size="3" maxlength="3" onkeyup="rsfirewall_numeric(this)" />.
				<input type="text" name="blacklist_ip4" id="blacklist_ip4" value="" size="3" maxlength="3" onkeyup="rsfirewall_numeric(this)" />
				
				<input type="button" id="rsfirewall_add_ip_blacklist" name="" value="<?php echo JText::_('RSF_ADD'); ?>" onclick="rsfirewall_add_ip('blacklist_ip', 'blacklist_ips')" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_DENY_ACCESS_IP_DESC'); ?>">
				<?php echo JText::_('RSF_DENY_ACCESS_IP'); ?>
				</span>
			</td>
			<td>
				<textarea cols="80" rows="10" class="text_area" type="text" name="blacklist_ips" id="blacklist_ips"><?php echo $this->config->blacklist_ips; ?></textarea>
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<?php
echo $this->pane->endPanel();

echo $this->pane->startPanel(JText::_('RSF_BACKEND_PASSWORD'), 'rsfirewall_backend_password');
?>
<div class="rsfirewall_tooltip">
	<strong><?php echo JText::_('RSF_BACKEND_PASSWORD'); ?></strong>
	<p><?php echo JText::_('RSF_BACKEND_PASSWORD_DESC'); ?></p>
</div>
<div class="col100">
	<fieldset class="adminform">
		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key hasTip" title="<?php echo JText::_('RSF_ENABLE_BACKEND_PASSWORD_DESC'); ?>">
				<?php echo JText::_('RSF_ENABLE_BACKEND_PASSWORD'); ?>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','backend_password_enabled', 'onclick="rsfirewall_enable_backend_password(this.value)"', $this->config->backend_password_enabled); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key hasTip" title="<?php echo JText::_('RSF_BACKEND_PASS_DESC'); ?>">
				<?php echo JText::_('RSF_BACKEND_PASS'); ?>
			</td>
			<td>
				<input class="text_area" type="password" name="backend_password" id="backend_password" size="35" value="" <?php echo $this->config->backend_password_enabled == 0 ? 'disabled="disabled"' : ''; ?> onkeyup="rsfirewall_change_backend_password(this)" />
				<span <?php echo $this->config->backend_password_enabled == 1 ? '' : 'style="display: none"'; ?> id="backend_password_span">
					<?php if (strlen($this->config->backend_password) > 0) { ?>
					<img src="<?php echo JURI :: root(); ?>administrator/images/tick.png" alt="" />
					<?php echo JText::_('RSF_BACKEND_PASSWORD_SET'); ?>
					<?php } else { ?>
					<img src="<?php echo JURI :: root(); ?>administrator/images/publish_x.png" alt="" />
					<?php echo JText::_('RSF_BACKEND_PASSWORD_NOT_SET'); ?>
					<?php } ?>
				</span>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_ADD_WHITELIST_IP_DESC'); ?>">
				<?php echo JText::_('RSF_ADD_WHITELIST_IP'); ?>
				</span>
			</td>
			<td>
				<input type="text" name="whitelist_ip1" id="whitelist_ip1" value="" size="3" maxlength="3" <?php echo $this->config->backend_password_enabled == 0 ? 'disabled="disabled"' : ''; ?> onkeyup="rsfirewall_numeric(this)" />.
				<input type="text" name="whitelist_ip2" id="whitelist_ip2" value="" size="3" maxlength="3" <?php echo $this->config->backend_password_enabled == 0 ? 'disabled="disabled"' : ''; ?> onkeyup="rsfirewall_numeric(this)" />.
				<input type="text" name="whitelist_ip3" id="whitelist_ip3" value="" size="3" maxlength="3" <?php echo $this->config->backend_password_enabled == 0 ? 'disabled="disabled"' : ''; ?> onkeyup="rsfirewall_numeric(this)" />.
				<input type="text" name="whitelist_ip4" id="whitelist_ip4" value="" size="3" maxlength="3" <?php echo $this->config->backend_password_enabled == 0 ? 'disabled="disabled"' : ''; ?> onkeyup="rsfirewall_numeric(this)" />
				
				<input type="button" id="rsfirewall_add_ip_whitelist" name="" value="<?php echo JText::_('RSF_ADD'); ?>" <?php echo $this->config->backend_password_enabled == 0 ? 'disabled="disabled"' : ''; ?> onclick="rsfirewall_add_ip('whitelist_ip', 'backend_whitelist_ips')" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_WHITELIST_IP_DESC'); ?>">
				<?php echo JText::_('RSF_WHITELIST_IP'); ?>
				</span>
			</td>
			<td>
				<textarea cols="80" rows="10" class="text_area" type="text" name="backend_whitelist_ips" id="backend_whitelist_ips" <?php echo $this->config->backend_password_enabled == 0 ? 'disabled="disabled"' : ''; ?>><?php echo $this->config->backend_whitelist_ips; ?></textarea>
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<?php
echo $this->pane->endPanel();

echo $this->pane->startPanel(JText::_('RSF_BACKEND_ACCESS_CONTROL'), 'rsfirewall_backend_access_control');
?>
<div class="rsfirewall_tooltip">
	<strong><?php echo JText::_('RSF_BACKEND_ACCESS_CONTROL'); ?></strong>
	<p><?php echo JText::_('RSF_BACKEND_ACCESS_CONTROL_DESC'); ?></p>
</div>
<div class="col100">
	<fieldset class="adminform">
		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_ENABLE_BACKEND_ACCESS_CONTROL_DESC'); ?>">
				<?php echo JText::_('RSF_ENABLE_BACKEND_ACCESS_CONTROL'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','backend_access_control_enabled', 'onclick="rsfirewall_enable_backend_access_control(this.value)"', $this->config->backend_access_control_enabled); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_ALLOW_USERS_DESC'); ?>">
				<?php echo JText::_('RSF_ALLOW_USERS'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.genericlist', $this->users, 'backend_access_users[]', 'class="inputbox" size="5" multiple="multiple"'.($this->config->backend_access_control_enabled == 0 ? ' disabled="disabled"' : ''), 'id', 'username', $this->config->backend_access_users); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_ALLOW_COMPONENTS_DESC'); ?>">
				<?php echo JText::_('RSF_ALLOW_COMPONENTS_DESC'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.genericlist', $this->components, 'backend_access_components[]', 'class="inputbox" size="5" multiple="multiple"'.($this->config->backend_access_control_enabled == 0 ? ' disabled="disabled"' : ''), 'option', 'option', $this->config->backend_access_components); ?>
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<?php
echo $this->pane->endPanel();

echo $this->pane->startPanel(JText::_('RSF_RSFIREWALL_ACTIVE_SCANNER'), 'rsfirewall_active_scanner');
?>
<div class="rsfirewall_tooltip">
	<strong><?php echo JText::_('RSF_RSFIREWALL_ACTIVE_SCANNER'); ?></strong>
	<p><?php echo JText::_('RSF_RSFIREWALL_ACTIVE_SCANNER_DESC'); ?></p>
</div>
<div class="col100">
	<fieldset class="adminform">
		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_ENABLE_ACTIVE_SCANNER_DESC'); ?>">
				<?php echo JText::_('RSF_ENABLE_ACTIVE_SCANNER'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','active_scanner_status', 'onclick="rsfirewall_enable_active_scanner_status(this.value)"', $this->config->active_scanner_status); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_VERIFY_DOS_DESC'); ?>">
				<?php echo JText::_('RSF_VERIFY_DOS'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','verify_dos', $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : '', $this->config->verify_dos); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_VERIFY_GENERATOR_DESC'); ?>">
				<?php echo JText::_('RSF_VERIFY_GENERATOR'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','verify_generator', $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : '', $this->config->verify_generator); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_VERIFY_SQL_DESC'); ?>">
				<?php echo JText::_('RSF_VERIFY_SQL'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','verify_sql', $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : '', $this->config->verify_sql); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_SKIP_SQL_DESC'); ?>">
				<?php echo JText::_('RSF_SKIP_SQL'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.genericlist', $this->components, 'verify_sql_skip[]', 'class="inputbox" size="5" multiple="multiple"'.($this->config->active_scanner_status == 0 ? ' disabled="disabled"' : ''), 'option', 'option', $this->config->verify_sql_skip); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_VERIFY_PHP_DESC'); ?>">
				<?php echo JText::_('RSF_VERIFY_PHP'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','verify_php', $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : '', $this->config->verify_php); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_SKIP_PHP_DESC'); ?>">
				<?php echo JText::_('RSF_SKIP_PHP'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.genericlist', $this->components, 'verify_php_skip[]', 'class="inputbox" size="5" multiple="multiple"'.($this->config->active_scanner_status == 0 ? ' disabled="disabled"' : ''), 'option', 'option', $this->config->verify_php_skip); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_VERIFY_JS_DESC'); ?>">
				<?php echo JText::_('RSF_VERIFY_JS'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','verify_js', $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : '', $this->config->verify_js); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_SKIP_JS_DESC'); ?>">
				<?php echo JText::_('RSF_SKIP_JS'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.genericlist', $this->components, 'verify_js_skip[]', 'class="inputbox" size="5" multiple="multiple"'.($this->config->active_scanner_status == 0 ? ' disabled="disabled"' : ''), 'option', 'option', $this->config->verify_js_skip); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_VERIFY_MULTIPLE_EXTS_DESC'); ?>">
				<?php echo JText::_('RSF_VERIFY_MULTIPLE_EXTS'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','verify_multiple_exts', $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : '', $this->config->verify_multiple_exts); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_VERIFY_FILES_DESC'); ?>">
				<?php echo JText::_('RSF_VERIFY_FILES'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','verify_upload', $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : '', $this->config->verify_upload); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_DENY_EXTENSIONS_DESC'); ?>">
				<?php echo JText::_('RSF_DENY_EXTENSIONS'); ?>
				</span>
			</td>
			<td>
				<textarea cols="80" rows="10" class="text_area" name="verify_upload_blacklist_exts" id="verify_upload_blacklist_exts" <?php echo $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : ''; ?>><?php echo $this->config->verify_upload_blacklist_exts; ?></textarea>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_MONITOR_CORE_DESC'); ?>">
				<?php echo JText::_('RSF_MONITOR_CORE'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist','monitor_core', $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : '', $this->config->monitor_core); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_MONITOR_FILES_DESC'); ?>">
				<?php echo JText::_('RSF_MONITOR_FILES'); ?>
				</span>
			</td>
			<td>
				<div class="button2-left"><div class="blank"><a class="modal" title="Select the path" href="" rel="{handler: 'iframe', size: {x: 650, y: 375}}" id="filesPathChange" onclick="this.href = 'index.php?option=com_rsfirewall&task=folders&tmpl=component&controller=configuration';" <?php echo $this->config->active_scanner_status == 0 ? ' style="display: none"' : ''?>><?php echo JText::_('RSF_ADD_FILE'); ?></a></div></div>
				<span class="rsfirewall_clear"></span>
				<textarea cols="80" rows="10" class="text_area" name="monitor_files" id="monitor_files" <?php echo $this->config->active_scanner_status == 0 ? ' disabled="disabled"' : '' ?>><?php echo $this->config->monitor_files; ?></textarea>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_MONITOR_USERS_DESC'); ?>">
				<?php echo JText::_('RSF_MONITOR_USERS'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.genericlist', $this->users, 'monitor_users[]', 'class="inputbox" size="5" multiple="multiple"'.($this->config->active_scanner_status == 0 ? ' disabled="disabled"' : ''), 'id', 'username', $this->config->monitor_users); ?>
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<?php
echo $this->pane->endPanel();

echo $this->pane->startPanel(JText::_('RSF_RSFIREWALL_LOGGING_UTILITY'), 'rsfirewall_log');
?>
<div class="rsfirewall_tooltip">
	<strong><?php echo JText::_('RSF_RSFIREWALL_LOGGING_UTILITY'); ?></strong>
	<p><?php echo JText::_('RSF_RSFIREWALL_LOGGING_UTILITY_DESC'); ?></p>
</div>
<div class="col100">
	<fieldset class="adminform">
		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_SEND_EMAILS_DESC'); ?>">
				<?php echo JText::_('RSF_SEND_EMAILS'); ?>
				</span>
			</td>
			<td>
				<textarea cols="80" rows="10" class="text_area" type="text" name="log_emails" id="log_emails"><?php echo $this->config->log_emails; ?></textarea>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_SEND_ONLY_IF_HIGHER_DESC'); ?>">
				<?php echo JText::_('RSF_SEND_ONLY_IF_HIGHER'); ?>
				</span>
			</td>
			<td>
				<?php echo JHTML::_('select.genericlist', $this->levels, 'log_alert_level', null, 'value', 'text', $this->config->log_alert_level); ?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_DAYS_LOG_HISTORY_DESC'); ?>">
				<?php echo JText::_('RSF_DAYS_LOG_HISTORY'); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="log_history" size="35" value="<?php echo $this->config->log_history; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<span class="hasTip" title="<?php echo JText::_('RSF_NUMBER_EVENTS_SYSTEM_OVERVIEW_DESC'); ?>">
				<?php echo JText::_('RSF_NUMBER_EVENTS_SYSTEM_OVERVIEW'); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="log_overview" size="35" value="<?php echo $this->config->log_overview; ?>" />
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<?php
echo $this->pane->endPanel();

echo $this->pane->endPane();
?>

<?php echo JHTML::_('form.token'); ?>
<input type="hidden" name="option" value="com_rsfirewall" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="configuration" />
</form>

<?php
//keep session alive while editing
JHTML::_('behavior.keepalive');
?>