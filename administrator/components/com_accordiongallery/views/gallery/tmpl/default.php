<?php
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="editcell">
    <table class="adminlist">
    <thead>
        <tr>
            <th width="20">
              <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
            </th>
			<th width="20">
                <?php echo JText::_( 'ID' ); ?>
            </th>
            <th width="450">
                <?php echo JText::_( 'Thumb' ); ?>
            </th>
            <th>
                <?php echo JText::_( 'Name' ); ?>
            </th>
            <th>
                <?php echo JText::_( 'Regular Price' ); ?>
            </th>

            <th>
                <?php echo JText::_( 'Discount Price' ); ?>
            </th>

            <th>
                <?php echo JText::_( 'Image Link' ); ?>
            </th>

			<th width="20" align="center">
                <?php echo JText::_( 'Published' ); ?>
            </th>
			<th width="25">
                <?php echo JText::_( 'Order' ); ?>
            </th>
			<th width="200">
                <?php echo JText::_( 'Category' );
					echo ' <select id="showcat" class="inputbox" size="1" name="showcat" onchange="window.document.getElementById(\'adminForm\').submit();">';
					echo '<option value="0" ' . (($this->showcat == 0) ? 'selected="selected"' : '').' >-ALL-</option>';
					foreach($this->categories as $curr_cat) {
						echo '<option ';
						if($curr_cat->id == $this->showcat){echo 'selected="selected"';}
						echo ' value="'.$curr_cat->id.'">'.$curr_cat->name.'</option>';
					}
					echo '</select>';
				?>
            </th>
        </tr>            
    </thead>
    <?php
    $k = 0;
    for ($i=0, $n=count( $this->items ); $i < $n; $i++)
    {
        $row =& $this->items[$i];
        $checked    = JHTML::_( 'grid.id', $i, $row->id );
        $link = JRoute::_( 'index.php?option=com_accordiongallery&controller=item&task=edit&cid[]='. $row->id );
		if ($row->publish == 1) {
			$unpublish_link = JRoute::_( 'index.php?option=com_accordiongallery&controller=item&task=unpublish&picid='. $row->id );
			$publish_item = '<a title="Unpublish Picture" href="'.$unpublish_link.'"><img border="0" alt="Published" src="'.JURI::root().'components/com_accordiongallery/tick.png"/></a>';
		} else {
			$publish_link = JRoute::_( 'index.php?option=com_accordiongallery&controller=item&task=publish&picid='. $row->id );
			$publish_item = '<a title="Publish Picture" href="'.$publish_link.'"><img border="0" alt="Unpublished" src="'.JURI::root().'components/com_accordiongallery/publish_x.png"/></a>';
		}
		//$config_obj =& JFactory::getConfig();
		//$_SERVER['HTTP_HOST']
		$uri_var = & JFactory::getURI();
		$uri_str = $uri_var->toString();
		$joom_url = substr($uri_str, 0, strrpos(strtolower($uri_str), '/administrator/'));
		
		$params = &JComponentHelper::getParams('com_accordiongallery');
		$gallery_path = $params->get('pic_path', 'images/accordiongallery/gallery');
		//$thumb_link = $joom_url . '/images/accordiongallery/gallery/' . 'g' . $row->catid . '/' . $row->thumb;
		$thumb_path = $gallery_path . '/' . $row->thumb;
		$image_path = $gallery_path . '/' . $row->image;
		//$thumb_link = $joom_url . '/' . $gallery_path . '/' . $row->thumb;
		$thumb_link = $joom_url . '/' . $gallery_path . '/' . $row->image;
        ?>
        <tr class="<?php echo "row$k"; ?>">
            <td>
              <?php echo $checked; ?>
            </td>
			<td align="center">
              <?php echo $row->id; ?>
            </td>
            <td width="450" align="center">
                <img src="<?php echo $thumb_link; ?>" width="70" height="50" />
				<br/>
				<b>Image Path:</b> <?php echo $image_path; ?>
            </td>
			 <td>
                <a href="<?php echo $link; ?>"><?php echo $row->name; ?></a>
            </td>
			 <td>
                <a href="<?php echo $link; ?>"><?php echo $row->reg_price; ?></a>
            </td>

            <td>
                <a href="<?php echo $link; ?>"><?php echo $row->dis_price; ?></a>
            </td>
			<td>
              <a href="<?php echo $link; ?>"><?php echo $row->linkit; ?></a>
            </td>

            <td align="center" >
                <?php echo $publish_item; ?>
            </td>
            <td>
                <?php echo '<input class="text_area" type="text" style="text-align: center;" value="'.$row->ordnum.'" size="5" name="order[]"/>'; ?>
            </td>
            <td width="200" align="center">
                <?php echo $row->catname; ?>
            </td>
        </tr>
        <?php
        $k = 1 - $k;

    }
    ?>
	<tfoot>
    <tr>
      <td colspan="10"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
	</tfoot>

    </table>
</div>
 
<input type="hidden" name="option" value="com_accordiongallery" />
<input type="hidden" name="task" id="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" id="controller" value="item" />
 
</form>