<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
/**
 * Gallery View for Gallery XML Component
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.view' );

if (!class_exists('JViewSST')) {
 if (!class_exists('JView')) {
  if(function_exists('class_alias')) {
   class_alias('JViewLegacy', 'JViewSST');
  } else {
   class JViewSST extends JViewLegacy
   {
    function __construct()
    {
     parent::__construct();
    }
   }
  }
  } else {
  if(function_exists('class_alias')) {
   class_alias('JView', 'JViewSST');
  } else {
   class JViewSST extends JView
   {
    function __construct()
    {
     parent::__construct();
    }
   }
  }
 }
}
class GalleryViewMultiup extends JViewSST
{
	/**
	 * display method of Gallery view
	 * @return void
	 **/
	function display($tpl = null)
	{
	
	//get the hosts name
jimport('joomla.environment.uri' );
$host = JURI::root();
 
//add the links to the external files into the head of the webpage (note the 'administrator' in the path, which is not nescessary if you are in the frontend)
$document =& JFactory::getDocument();
$document->addScript($host.'administrator/components/com_accordiongallery/swfupload/swfupload.js');
$document->addScript($host.'administrator/components/com_accordiongallery/swfupload/swfupload.queue.js');
$document->addScript($host.'administrator/components/com_accordiongallery/swfupload/fileprogress.js');
$document->addScript($host.'administrator/components/com_accordiongallery/swfupload/handlers.js');
$document->addStyleSheet($host.'administrator/components/com_accordiongallery/swfupload/default.css');

///////////////////////////////////////////////////////////////////
//when we send the files for upload, we have to tell Joomla our session, or we will get logged out 
$session = & JFactory::getSession();
$params_comg = &JComponentHelper::getParams('com_accordiongallery');
$decret = $params_comg->get('secur_w', 'telx3eis7d');
 
 
 $categories    =& $this->get('Categories');
 
 
$swfUploadHeadJs ='
var swfu;
 
window.onload = function()
{
 
var settings = 
{
        flash_url : "'.$host.'administrator/components/com_accordiongallery/swfupload/swfupload.swf",
		flash9_url : "'.$host.'administrator/components/com_accordiongallery/swfupload/swfupload_fp9.swf",

        upload_url: "'.$host.'index.php",
        post_params: 
        {
            "catid" : "'.$categories[0]->id.'",
			"decret" : "'.$decret.'",
            "format" : "raw",
			"option" : "com_accordiongallery",
			"controller" : "multiupdo",
			"task" : "upfuf"
        }, 
        //you need to put the session and the "format raw" in there, the other ones are what you would normally put in the url
        file_size_limit : "25 MB",
        //client side file chacking is for usability only, you need to check server side for security
        file_types : "*.jpg;*.jpeg;*.gif;*.png",
        file_types_description : "All Files",
        file_upload_limit : 100,
        file_queue_limit : 100,
        custom_settings : 
        {
                progressTarget : "fsUploadProgress",
                cancelButtonId : "btnCancel"
        },
        debug: false,
 
        // Button settings
        button_image_url: "'.$host.'administrator/components/com_accordiongallery/swfupload/images/blank_btn.png",
        button_width: "86",
        button_height: "22",
        button_placeholder_id: "spanButtonPlaceHolder",
		button_text : \'<span class="btnText">Browse</span>\',
		button_text_style : ".btnText { text-align: center; font-size: 14; font-weight: bold; font-family: MS Shell Dlg; }",
 
        // The event handler functions are defined in handlers.js
		swfupload_preload_handler : preLoad,
		swfupload_load_failed_handler : loadFailed,
        file_queued_handler : fileQueued,
        file_queue_error_handler : fileQueueError,
        file_dialog_complete_handler : fileDialogComplete,
        upload_start_handler : uploadStart,
        upload_progress_handler : uploadProgress,
        upload_error_handler : uploadError,
        upload_success_handler : uploadSuccess,
        upload_complete_handler : uploadComplete,
        queue_complete_handler : queueComplete     // Queue plugin event
};
swfu = new SWFUpload(settings);


};
function UpdateUset()
{
	var ncat_id = new String(window.document.getElementById("catid").value);
	var npar_obj = {
            "catid" : ncat_id.valueOf(),
			"decret" : "'.$decret.'",
            "format" : "raw",
			"option" : "com_accordiongallery",
			"controller" : "multiupdo",
			"task" : "upfuf"
        }
	swfu.setPostParams(npar_obj);
}
';
 
//add the javascript to the head of the html document
$document->addScriptDeclaration($swfUploadHeadJs);

///////////////////////////////////////////////////////////////////


		//get Gategories
		//$i_model = $this->getModel('item');
		$categories    =& $this->get('Categories');
		//get the item
		//$item        =& $this->get('Data');
		//$isNew        = ($item->id < 1);
	 
		$text = JText::_( 'Multiple Upload' );
		JToolBarHelper::title(   JText::_( $text. ' Pictures' ));
		//JToolBarHelper::save();
		JToolBarHelper::cancel('cancel', 'Close');
	 
		//$this->assignRef('item', $item);
		$this->assignRef('categories', $categories);
		parent::display($tpl);
	}

}
