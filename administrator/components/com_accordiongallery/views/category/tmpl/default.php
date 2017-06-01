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
                <input class="text_area" type="text" name="name" id="name" size="32" maxlength="250" value="<?php echo $this->category->name;?>" />
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="ordnum">
                    <?php echo JText::_( 'Order number' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="ordnum" id="ordnum" size="4" maxlength="11" value="<?php echo $this->category->ordnum;?>" />
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                    <?php echo JText::_( 'Published' ); ?>:
            </td>
            <td>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '<table><tr><td>';} ?>
				<input id="publish0" class="inputbox" type="radio" <?php if($this->category->publish == 0){echo 'checked="checked"';} ?> value="0" name="publish"/>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '</td><td>';} ?>
				<label for="publish0">No</label>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '</td><td>';} ?>
				<input id="publish1" class="inputbox" type="radio" <?php if($this->category->publish == 1){echo 'checked="checked"';} ?> value="1" name="publish"/>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '</td><td>';} ?>
				<label for="publish1">Yes</label>
				<?php if(substr($jver, 0, 3) != '1.5'){echo '</td></tr></table>';} ?>
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="linkname">
                    <?php echo JText::_( 'Color' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="linkname" id="linkname" size="12" maxlength="6" value="<?php echo $this->category->linkname;?>" />
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="linkit">
                    <?php echo JText::_( 'Hover Color' ); ?>:
                </label>
            </td>
            <td>
                <input class="text_area" type="text" name="linkit" id="linkit" size="12" maxlength="6" value="<?php echo $this->category->linkit;?>" />
            </td>
        </tr>
		<tr>
            <td width="100" align="right" class="key">
                <label for="descr">
                    <?php echo JText::_( 'Description' ); ?>:
                </label>
            </td>
            <td>
                <textarea class="text_area" name="descr" id="descr" rows="10" cols="32"><?php echo $this->category->descr;?></textarea>
            </td>
        </tr>
    </table>
    </fieldset>
</div>
 
<div class="clr"></div>
 
<input type="hidden" name="option" value="com_accordiongallery" />
<input type="hidden" name="id" value="<?php echo $this->category->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="category" />
</form>