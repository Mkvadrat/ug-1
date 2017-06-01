<?php 
/**
* @Copyright Copyright (C) 2011- xml/swf
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die('Restricted access'); 
?>
<form action="index.php" method="post" name="adminForm" id="adminForm" >
<div id="editcell">
    <table class="adminlist" >
    <thead>
        <tr>
            <th width="20">
              <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->cats ); ?>);" />
            </th>
			<th width="20">
                <?php echo JText::_( 'ID' ); ?>
            </th>
            <th>
                <?php echo JText::_( 'Name' ); ?>
            </th>
			<th width="20" align="center">
                <?php echo JText::_( 'Published' ); ?>
            </th>
			<th width="25">
                <?php echo JText::_( 'Order' ); ?>
            </th>
        </tr>            
    </thead>
    <?php
    $k = 0;
    for ($i=0, $n=count( $this->cats ); $i < $n; $i++)
    {
        $row =& $this->cats[$i];
        $checked    = JHTML::_( 'grid.id', $i, $row->id );
        $link = JRoute::_( 'index.php?option=com_accordiongallery&controller=category&task=edit&cid[]='. $row->id );
		if ($row->publish == 1) {
			$unpublish_link = JRoute::_( 'index.php?option=com_accordiongallery&controller=category&task=unpublish&catid='. $row->id );
			$publish_item = '<a title="Unpublish Category" href="'.$unpublish_link.'"><img border="0" alt="Published" src="'.JURI::root().'components/com_accordiongallery/tick.png"/></a>';
		} else {
			$publish_link = JRoute::_( 'index.php?option=com_accordiongallery&controller=category&task=publish&catid='. $row->id );
			$publish_item = '<a title="Publish Category" href="'.$publish_link.'"><img border="0" alt="Unpublished" src="'.JURI::root().'components/com_accordiongallery/publish_x.png"/></a>';
		}
		$uri_var = & JFactory::getURI();
		$uri_str = $uri_var->toString();
		$joom_url = substr($uri_str, 0, strrpos(strtolower($uri_str), '/administrator/'));
		
		$params = &JComponentHelper::getParams('com_accordiongallery');
		$catsimg_path =  $params->get('cat_path', 'images/accordiongallery/galleries');
		//$thumb_link = $joom_url . '/images/accordiongallery/galleries/' . $row->thumb;
		$thumb_path = $catsimg_path . '/' . $row->thumb;
		$image_path = $catsimg_path . '/' . $row->image;
		$thumb_link = $joom_url . '/' . $catsimg_path . '/' . $row->thumb;
        ?>
        <tr class="<?php echo "row$k"; ?>">
            <td>
              <?php echo $checked; ?>
            </td>
			<td align="center">
              <?php echo $row->id; ?>
            </td>
            <td>
                <a href="<?php echo $link; ?>"><?php echo $row->name; ?></a>
            </td>
            <td align="center" >
                <?php echo $publish_item; ?>
            </td>
            <td>
                <?php echo '<input class="text_area" type="text" style="text-align: center;" value="'.$row->ordnum.'" size="5" name="order[]"/>'; ?>
            </td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
    </table>
</div>
 
<input type="hidden" name="option" value="com_accordiongallery" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="category" />
 
</form>