<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementjsforadmipassphrase extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'jsforadmipassphrase';
	
	function fetchElement($name, $value, &$node, $control_name)
	{
			JHTML::script('joomla.javascript.js', 'includes/js/', false);
            JHTML::script('mootools.js', 'media/system/js/', false);
			JHTML::script('modal.js');
            JHTML::stylesheet('modal.css');
		
		$elementData = "
					
					<script>
						var origPassPhrase = '';
						var newPassPhrase =  '';
						function getPassPhrase()
						{
							origPassPhrase = document.getElementById('paramsadminPassPhrase').value;
							document.getElementById('paramsadminPassPhrase').onblur=alertPassPhraseChange
							
							 //alert(origPassPhrase);
						}
						function alertPassPhraseChange()
						{
							var adminPassPhraseField = document.getElementById('paramsadminPassPhrase');
							newPassPhrase = adminPassPhraseField.value;
							if(origPassPhrase != newPassPhrase)
							{
								//alert('Pass Phrase Changed');
								if(!confirm(\"You have altered \'ADMIN PASS PHRASE\'.\\nThis change  will alter URL of admin side of this site.\\nIE AFTER YOU SAVE THE NEW \'ADMIN PASS PHRASE\', ADMIN URL WILL BE\\n\\n ".JURI::base()."?osolPP=\" + newPassPhrase +\"\\n\\nClick 'cancel' if you haven't understood this\"))
								{
								  adminPassPhraseField.value = origPassPhrase;
								  //showModal(document.getElementById('adminPassPhraseConfirmLink'))
								}
							}
						}
						function showModal(aObj)
					   {
							//alert(aObj.href);
					  		SqueezeBox.fromElement(aObj);
							setTimeout(showAdminPassPhraseConfirmMessage,1000);
							return false;
					   }
					   function showAdminPassPhraseConfirmMessage()
					   {
						var new_content = '<spane style=\"font-weight:bold;font-size:18px\">You have set a new ADMIN PASS PHRASE.<br />This change  will make it mandatory to use query variable osolPP=' + newPassPhrase +' to access admin side of this site <br />Click \'cancel\' if you haven\'t understood this </span>'
						//alert(document.getElementById('sbox-window').innerHTML );
						//document.getElementById('sbox-window').innerHTML =\"DDD\"
						var iframes = document.getElementById('sbox-window').getElementsByTagName(\"iframe\");
						//alert();
						var iframe = iframes[0];
						iframe.contentWindow.document.open()
						//alert(new_content);
						iframe.contentWindow.document.write(new_content);
					   }
						window.addEvent( 'domready', getPassPhrase );
						</script>
						
						<a id=\"adminPassPhraseConfirmLink\" href=\"\" rel=\"{handler: 'iframe', size: {x: 900, y: 500}}\" onclick=\"return showModal(this);\"  style=\"display:none\" ><a>
						";
		return $elementData;
	}
}