<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
	$version = new JVersion;
	$jver = $version->getShortVersion();
	
	$weditor =& JFactory::getEditor();
    $descr_string = $weditor->display('descr', $this->item->descr, '550', '400', '60', '20', false);
?>
<form action="index.php" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm">
<div class="col100">
    <fieldset class="adminform">
        <legend><?php echo JText::_( 'Details' ); ?></legend>
        <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="name">
                    <?php echo JText::_( 'Name' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="name" id="name" size="32" maxlength="250" value="<?php echo $this->item->name;?>" />
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="catid">
                    <?php echo JText::_( 'Category id' ); ?>:
                </label>
            </td>
            <td>
                <select id="catid" class="inputbox" size="1" name="catid">
				<?php foreach($this->categories as $curr_cat) {
					echo '<option ';
					if($curr_cat->id == $this->item->catid){echo 'selected="selected"';}
					echo ' value="'.$curr_cat->id.'">'.$curr_cat->name.'</option>';
				}?>
				</select>
			</td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="ordnum">
                    <?php echo JText::_( 'Order number' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="ordnum" id="ordnum" size="4" maxlength="11" value="<?php echo $this->item->ordnum;?>" />
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                    <?php echo JText::_( 'Published' ); ?>:
            </td>
            <td>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '<table><tr><td>';} ?>
				<input id="publish0" class="inputbox" type="radio" <?php if($this->item->publish == 0){echo 'checked="checked"';} ?> value="0" name="publish"/>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '</td><td>';} ?>
				<label for="publish0">No</label>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '</td><td>';} ?>
				<input id="publish1" class="inputbox" type="radio" <?php if($this->item->publish == 1){echo 'checked="checked"';} ?> value="1" name="publish"/>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '</td><td>';} ?>
				<label for="publish1">Yes</label>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '</td></tr></table>';} ?>
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="altlarge">
                    <?php echo JText::_( 'Alternative text for Image' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="altlarge" id="altlarge" size="32" maxlength="250" value="<?php echo $this->item->altlarge;?>" />
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="file1">
                    <?php echo JText::_( 'Image' ); ?>:
                </label>
            </td>
            <td>
                <input type="file" name="file1" id="file1" />
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="linkit">
                    <?php echo JText::_( 'Image Link' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="linkit" id="linkit" size="60" maxlength="250" value="<?php echo $this->item->linkit;?>" />
            </td>
        </tr>
		
		<tr>
            <td width="100" align="right" class="key">
                <label for="descr">
                    <?php echo JText::_( 'Description' ); ?>:
                </label>
            </td>
            <td>
                <?php echo $descr_string; ?>
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="reg_price">
                    <?php echo JText::_( 'Regular Price' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="reg_price" id="reg_price" size="60" maxlength="250" value="<?php echo $this->item->reg_price;?>" />
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="dis_price">
                    <?php echo JText::_( 'Discount Price' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="dis_price" id="dis_price" size="60" maxlength="250" value="<?php echo $this->item->dis_price;?>" />
            </td>
        </tr>
    </table>
    </fieldset>
</div>
 
<div class="clr"></div>
<input type="hidden" name="option" value="com_accordiongallery" />
<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="item" />
<input type="hidden" name="medfld" value="1"/>
</form>