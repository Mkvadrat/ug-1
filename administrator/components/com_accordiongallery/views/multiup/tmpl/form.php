<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="swfuploader">

<form action="index.php" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm">
<div class="col100">
    <fieldset class="adminform">
        <legend><?php echo JText::_( 'Upload Options' ); ?></legend>
        <table class="admintable">
		<tr>
            <td width="100" align="right" class="key">
                <label for="catid">
                    <?php echo JText::_( 'Category id' ); ?>:
                </label>
            </td>
            <td>
                <select id="catid" class="inputbox" size="1" name="catid" onchange="UpdateUset();">
				<?php foreach($this->categories as $key_cat => $curr_cat) {
					echo '<option ';
					if($key_cat == 0){echo 'selected="selected"';}
					echo ' value="'.$curr_cat->id.'">'.$curr_cat->name.'</option>';
				}?>
				</select>
			</td>
        </tr>
		<tr>
			<td colspan="2">
				<div class="fieldset flash" id="fsUploadProgress">
                     <span class="legend">Upload Queue</span>
                </div>
				<div id="divStatus">0 Files Uploaded</div>
				<div>
					<span id="spanButtonPlaceHolder"></span>
					<input id="btnCancel" type="button" value="Cancel Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 22px;" />
				</div>

			</td>
		</tr>
    </table>
    </fieldset>
</div>
 
<div class="clr"></div>
<input type="hidden" name="option" value="com_accordiongallery" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="multiup" />
</form>

</div>