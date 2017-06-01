function rsfirewall_switch(item_id)
{
	if (document.getElementById(item_id).style.display == 'none')
		rsfirewall_open(item_id);
	else
		rsfirewall_close(item_id);
	
	return false;
}

function rsfirewall_open(item_id)
{
	document.getElementById(item_id).style.display = 'block';
}

function rsfirewall_close(item_id)
{
	document.getElementById(item_id).style.display = 'none';
}