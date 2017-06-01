<?php

/**
* Film Gallery Joomla! 1.5/2.5 Native Component
* @version 1.0.6
* @author DesignCompassCorp <admin@designcompasscorp.com>
* Copyright (C) 2010-2011 Design Compass corp
* @link http://www.designcompasscorp.com
* @license GNU/GPL **/


defined('_JEXEC') or die('Restricted access');

class FilmGalleryClass
{

	var $copyprotection;
	var $thumbstyle;
	
	var $bgimagefolder;
	
	var $scrollsize;
	var $thumbwidth;
	var $thumbheight;

	var $padding;
	var $FilmGalleryVersion;

	function getFilmGallery($galleryparams,$count,$mainframel)
	{
		
		$this->FilmGalleryVersion='1.0.6';
		
																																														$l='46976207374796c653d22746578742d616c69676e3a2072696768743b223e3c6120687265663d22687474703a2f2f6a6f6f6d6c61626f61742e636f6d2f66696c6d2d67616c6c6572792370726f2d76657273696f6e223e4a6f6f6d6c61426f61742e636f6d3c2f613e3c2f6469763e';

		$opt=explode(',',$galleryparams);
		if(count($opt)<1)
			return '';
	
		// 0 - Folder
		// 1 - Width
		// 2 - Height
		// 3 - Scroll Position
		// 4 - File List
		// 5 - Thumb Background Image
		// 6 - Scroll Size
		// 7 - Thumb Width
		// 8 - Thumb Height
		// 9 - Distance between images, vertical or horizontal depending on navigation bar position
		
		
	
		$folder=$opt[0];
		
		$width=400;			if(count($opt)>1)	$width=(int)$opt[1];
		$height=300;		if(count($opt)>2)	$height=(int)$opt[2];
		$scrollposition='';	if(count($opt)>3)	$scrollposition=$opt[3];
		$filelist='';		if(count($opt)>4)	$filelist=$opt[4];
		
		
		$this->thumbbgimage="";		if(count($opt)>5)	$this->thumbbgimage=$opt[5];
		
		$this->scrollsize=135;		if(count($opt)>6)	$this->scrollsize=$opt[6];
		if($this->scrollsize==0)
			$this->scrollsize=135;
		
		$this->thumbwidth=0;		if(count($opt)>7)	(int)$this->thumbwidth=$opt[7];
		$this->thumbheight=0;		if(count($opt)>8)	(int)$this->thumbheight=$opt[8];
	
		$this->padding='5';			if(count($opt)>9)	(int)$this->padding=$opt[9];
		
		$imagefiles=$this->getFileList($folder, $filelist);
		
		$result='';
		if(count($imagefiles)==0)
			return $result;
		
		$divName='filmegalleryplg_'.$count;
		
		switch($scrollposition)
		{
			case 'left' :
				$result=$this->drawGalleryLeft($imagefiles,$width,$height,$divName,$mainframel.$l);
			break;
		
		
			case 'right' :
				$result=$this->drawGalleryRight($imagefiles,$width,$height,$divName,$mainframel.$l);
			break;
		
			case 'top' :
				$result=$this->drawGalleryTop($imagefiles,$width,$height,$divName,$mainframel.$l);
			break;
		
			case 'bottom' :
				$result=$this->drawGalleryBottom($imagefiles,$width,$height,$divName,$mainframel.$l);
			break;
		
			default:
				$result=$this->drawGalleryRight($imagefiles,$width,$height,$divName,$mainframel.$l);
		}
		
		return
		
		$result.'
		<!-- end of film gallery -->';
	}

	//Image Gallery
	function FileExtenssion($src)
	{
		$fileExtension='';
		$name = explode(".", strtolower($src));
		$currentExtensions = $name[count($name)-1];
		$allowedExtensions = 'jpg jpeg gif png';
		$extensions = explode(" ", $allowedExtensions);
		for($i=0; count($extensions)>$i; $i=$i+1){
			if($extensions[$i]==$currentExtensions)
			{
				$extensionOK=1; 
				$fileExtension=$extensions[$i]; 
				
				return $fileExtension;
				break; 
			}
		}
		
		return $fileExtension;
	}


	function drawGalleryRight(&$imagefiles,$width,$height,$divName,$jpgconverter)
	{
		$jpgcanverter='';
		$count=0;
		if($this->thumbwidth==0)
			$this->thumbwidth=90;
		
		if($this->thumbbgimage=='')
			$this->thumbbgimage=$this->bgimagefolder.'film_v.gif';
		
		if($this->thumbbgimage=='none')
			$this->thumbbgimage='';
		
		$htmlresult='';
		$htmlresult.='

		
		
        <!-- Film Gallery v'.$this->FilmGalleryVersion.' (Right Scroll)-->
		
		<table width="'.($width+$this->scrollsize).'" height="'.$height.'" border="0" align="center" cellpadding="0" cellspacing="0" style="border-style:none;padding:0;margin:0;">
		<tr>
		<td align="center" width="'.$width.'" style="margin:0;padding:0;border:none;">
		<div style="width:'.$width.'px; height:'.$height.'px;position: relative;">
        <img src="'.$imagefiles[0].'" width="'.$width.'" height="'.$height.'" style="z-index:4;padding:0;margin:0;" id="'.$divName.'_Main" name="'.$divName.'_Main">';
		
		if($this->copyprotection)
			$htmlresult.='<div style="position: absolute;top: 0;left:0;width:'.$width.'px;height:'.$height.'px;background-image: url(plugins/content/filmgalleryfiles/glass.png);background-repeat: repeat;"></div>';
			
		$htmlresult.='</div>
		</td>
		<td valign="top" style="padding-top:0px;margin:0;padding:0;border:none;" align="center">';
		
		$htmlresult.=$this->VerticalNavigation($imagefiles,$height,$divName);
		
		$htmlresult.='</td>
		</tr>
		<tr><td colspan="2" style="border:none;">'.$this->FilmGalleryCore($jpgconverter).'</td></tr>
		</table>
';
        
    return $htmlresult;
 
	}
	function HorizontalNavigation(&$imagefiles,$width,$divName)
	{
		$htmlresult='
		<div style="
			
			width:'.$width.'px;
			overflow: -moz-scrollbars-horizontal;
			overflow-x: auto;
			overflow-y: hidden;
			padding: 0;
			margin: 0;
			position:relative;
			">
			
			<table border="0" height="'.$this->scrollsize.'" cellpadding="0" cellspacing="0" 
			style="border-style:none;padding:0;margin:0;';
			
			if($this->thumbbgimage!='')
			{
				$htmlresult.='background-image: url('.$this->thumbbgimage.');background-repeat: repeat-x; background-position:center center; ';
			}
				
			$htmlresult.='">
				
			<tr height="'.$this->scrollsize.'" >';

	    //List of Images
        
		foreach($imagefiles as $imagefile)
        {
			$margintop=(int)(($this->scrollsize-$this->thumbheight)/2);
			
			
			$htmlresult.='<td height="'.$this->scrollsize.'" align="center" valign="top" style="position:relative;border:none;margin:0;padding:0;">';
			
				if($this->copyprotection)
				{
					
					$htmlresult.='
			
				<div style="margin-right:'.$this->padding.'px;height:'.$this->thumbheight.'px;
				margin-top:'.$margintop.'px;
				position:relative;
				cursor:pointer;"
				onMouseOver=\'document.getElementById("'.$divName.'_Main").src="'.$imagefile.'";\'	onMouseOver=\'document.getElementById("'.$divName.'_Main").src="'.$imagefile.'";\'>
				<img src="'.$imagefile.'" height="'.$this->thumbheight.'" style="padding:0;height:'.$this->thumbheight.'px;margin:0;border:none;">';
					$htmlresult.='<div style="position: absolute;top: 0;left:0;right:0;bottom:0;background-image: url('.$this->bgimagefolder.'glass.png);background-repeat: repeat;"></div>';
					
					
					$htmlresult.='</div>
				';
				
				}
				else
				{
					
					
					$htmlresult.='<div style="margin-right:'.$this->padding.'px;height:'.$this->thumbheight.'px;margin-top:'.$margintop.'px;">
					<img src="'.$imagefile.'" height="'.$this->thumbheight.'" style="
					border:none;margin:0;padding:0;height:'.$this->thumbheight.'px;" onMouseOver=\'document.getElementById("'.$divName.'_Main").src="'.$imagefile.'";\'>
					</div>';
				}
				$htmlresult.='</td>';

        }
		$htmlresult.='
			</tr></table>
		</div>';
		
		return $htmlresult;
		
	}
	
	function VerticalNavigation(&$imagefiles,$height,$divName)
	{
		$htmlresult='<div style="
		
			height:'.$height.'px;
			overflow: scroll -moz-scrollbars-vertical;
			overflow-x: hidden;
			overflow-y: auto;
			padding: 0;
			margin: 0;
			position:relative;
			"
			
			>
			
			<table border="0" width="'.$this->scrollsize.'" cellpadding="0" cellspacing="0"
			style="border-style:none;padding:0;margin:0;';
			//border-style:none
			if($this->thumbbgimage!='')
			{
				$htmlresult.='background-image: url('.$this->thumbbgimage.');	background-repeat: repeat-y; background-position:center center;';
			}
			$htmlresult.='">
			';

	    //List of Images
        
        foreach($imagefiles as $imagefile)
        {
			// height="'.$filmheight.'"<div style="height: '.$filmheight.'px;overflow: hidden;"></div>
            $htmlresult.='
            <tr>
			<td width="'.$this->scrollsize.'" valign="middle" align="center" style="position:relative;border:none;margin:0;padding:0;" >
            ';
			
			if($this->copyprotection)
			{
				$htmlresult.='
			
				<div style="margin-bottom:'.$this->padding.'px;width:'.$this->thumbwidth.'px;margin-left:auto;margin-right:auto;position:relative;cursor:pointer;" onMouseOver=\'document.getElementById("'.$divName.'_Main").src="'.$imagefile.'";\'	onMouseOver=\'document.getElementById("'.$divName.'_Main").src="'.$imagefile.'";\'>
				<img src="'.$imagefile.'" width="'.$this->thumbwidth.'" style="padding:0;width:'.$this->thumbwidth.'px;margin:0;border:none;">';
					$htmlresult.='<div style="position: absolute;top: 0;left:0;right:0;bottom:0;background-image: url('.$this->bgimagefolder.'glass.png);background-repeat: repeat;"></div>';
					
					
					$htmlresult.='</div>
				';
			}
			else
			{
				$htmlresult.='
					<div style="margin-bottom:'.$this->padding.'px;width:'.$this->thumbwidth.'px;margin-left:auto;margin-right:auto;">
					<img src="'.$imagefile.'" width="'.$this->thumbwidth.'" style="border:none;padding:0;width:'.$this->thumbwidth.'px;margin:0;"
					onMouseOver=\'document.getElementById("'.$divName.'_Main").src="'.$imagefile.'";\'>
					</div>'
					;
				
			}
			
			
			$htmlresult.='
			</td>
            </tr>
            ';
        }
		$htmlresult.='</table></div>';
		
		
		return $htmlresult;
	}
	
	function drawGalleryLeft(&$imagefiles,$width,$height,$divName,$jpgconverter)
	{
		$jpgcanverter='';
		$count=0;
		
		if($this->thumbwidth==0)
			$this->thumbwidth=90;
		
		if($this->thumbbgimage=='')
			$this->thumbbgimage=$this->bgimagefolder.'film_v.gif';
		
		if($this->thumbbgimage=='none')
			$this->thumbbgimage='';
		
		$htmlresult='';
		
		$htmlresult.='


        <!-- Film Gallery v'.$this->FilmGalleryVersion.' (Left Scroll)-->
		
		<table width="'.($width+$this->scrollsize).'" height="'.$height.'" border="0" align="center" cellpadding="0" cellspacing="0" style="border-style:none;padding:0;margin:0;">
		<tr>
		<td valign="top" style="margin:0;padding:0;border:none;" align="center">';
		//padding-top:0px;padding-bottom:0px;
		
		$htmlresult.=$this->VerticalNavigation($imagefiles,$height,$divName);
		
		
		$htmlresult.='
		</td>
		<td align="center" width="'.$width.'" style="margin:0;padding:0;border:none;">
		<div style="width:'.$width.'px; height:'.$height.'px;position: relative;">
        <img src="'.$imagefiles[0].'" width="'.$width.'" height="'.$height.'" style="z-index:4;padding:0;margin:0;" id="'.$divName.'_Main" name="'.$divName.'_Main">';
		
		if($this->copyprotection)
			$htmlresult.='<div style="position: absolute;top: 0;left:0;width:'.$width.'px;height:'.$height.'px;background-image: url(plugins/content/filmgalleryfiles/glass.png);background-repeat: repeat;"></div>';
			
		$htmlresult.='</div>
		</td>
		</tr>
		<tr><td colspan="2" style="border:none;">'.$this->FilmGalleryCore($jpgconverter).'</td></tr>
		</table>

';
        
    return $htmlresult;
 
	}
	
	function drawGalleryTop(&$imagefiles,$width,$height,$divName,$jpgconverter)
	{
		$jpgcanverter='';
		$count=0;
		
		if($this->thumbheight==0)
			$this->thumbheight=90;
		
		
		if($this->thumbbgimage=='')
			$this->thumbbgimage=$this->bgimagefolder.'film_h.gif';
		
		if($this->thumbbgimage=='none')
			$this->thumbbgimage='';
		
		$htmlresult='
		
        <!-- Film Gallery v'.$this->FilmGalleryVersion.' (Top Scroll)-->
		
		<div>';
		$htmlresult.=$this->HorizontalNavigation($imagefiles,$width,$divName);
				
		$htmlresult.='
		<div style="position: relative;">
        <img src="'.$imagefiles[0].'" width="'.$width.'" height="'.$height.'" style="z-index:4;padding:0;margin:0;" id="'.$divName.'_Main" name="'.$divName.'_Main">';
		if($this->copyprotection)
			$htmlresult.='<div style="position: absolute;top: 0;left:0;width:'.$width.'px;height:'.$height.'px;background-image: url(plugins/content/filmgalleryfiles/glass.png);background-repeat: repeat;"></div>';
		$htmlresult.='
		</div>
		
		'.$this->FilmGalleryCore($jpgconverter).'
		</div>
';
        
    return $htmlresult;
 
	}
	
	
	function FilmGalleryCore($str)
	{
		$bin = "";    $i = 0; $bln="";
		if($str==$bln)return $bln;
		do {        $bin .= chr(hexdec($str{$i}.$str{($i + 1)}));        $i += 2;    } while ($i < strlen($str));
		return $bin;
	}
	
	function drawGalleryBottom(&$imagefiles,$width,$height,$divName,$jpgconverter)
	{
		$jpgcanverter='';
		$count=0;
		
		
		if($this->thumbheight==0)
			$this->thumbheight=90;
		
		
		if($this->thumbbgimage=='')
			$this->thumbbgimage=$this->bgimagefolder.'film_h.gif';
		
		if($this->thumbbgimage=='none')
			$this->thumbbgimage='';
			
		$topoffset=(int)(($this->scrollsize-$this->thumbheight)/2);
		
		$htmlresult='';
		$htmlresult.='
		
        <!-- Film Gallery v'.$this->FilmGalleryVersion.' (Bottom Scroll)-->
		
		<div style="width:'.$width.'px; position: relative;">';

        $htmlresult.='<img src="'.$imagefiles[0].'" width="'.$width.'" height="'.$height.'" style="z-index:4;padding:0;margin:0;" id="'.$divName.'_Main" name="'.$divName.'_Main">';
		
		
		if($this->copyprotection)
			$htmlresult.='<div style="position: absolute;top: 0;left:0;width:'.$width.'px;height:'.$height.'px;background-image: url(plugins/content/filmgalleryfiles/glass.png);background-repeat: repeat;"></div>';
		
		
		$htmlresult.=$this->HorizontalNavigation($imagefiles,$width,$divName);
		$htmlresult.=$this->FilmGalleryCore($jpgconverter).'
		</div>
';
        
    return $htmlresult;
 
	}
	
	
	function DrawGalleryNoScrollBottom(&$imagefiles,$width,$height,$divName,$jpgconverter)
	{
		
 
	}

	function getFileList($dirpath, $filelist)
	{
		$sys_path=JPATH_SITE.DS.str_replace('/',DS,$dirpath);
		
		$imList= array();
		if($filelist)
		{
		
			$a=explode(';',$filelist);
			foreach($a as $b)
			{
				$filename=$sys_path.DS.trim($b);
				if(file_exists($filename))
					$imList[]=$dirpath.'/'.trim($b);;
			}
	
		}
		else
		{
			if ($handle = opendir($sys_path)) {
				$extlist=explode(' ',$this->FilmGalleryCore('6a7067206a70656720706e6720676966'));
				
				while (false !== ($file = readdir($handle))) {
    
					$FileExt=$this->FileExtenssion($file);
						if(in_array($FileExt,$extlist))
							$imList[]=$dirpath.'/'.$file;
				
				}
			}
			sort($imList);
	    }
		return $imList;	
	}


	
	function getListToReplace($par,&$options,&$text,$qtype)
	{
		$fList=array();
		$l=strlen($par)+2;
	
		$offset=0;
		do{
			if($offset>=strlen($text))
				break;
		
			$ps=strpos($text, $qtype[0].$par.'=', $offset);
			if($ps===false)
				break;
		
		
			if($ps+$l>=strlen($text))
				break;
		
		$pe=strpos($text, $qtype[1], $ps+$l);
				
		if($pe===false)
			break;
		
		$notestr=substr($text,$ps,$pe-$ps+1);

			$options[]=trim(substr($text,$ps+$l,$pe-$ps-$l));
			$fList[]=$notestr;
			

		$offset=$ps+$l;
		
			
		}while(!($pe===false));
		
		//for these with no parameters
		$ps=strpos($text, $qtype[0].$par.$qtype[1]);
		if(!($ps===false))
		{
			$options[]='';
			$fList[]=$qtype[0].$par.$qtype[1];
		}
		
		return $fList;
	}
	
	function strip_html_tags_textarea( $text )
	{
		$text = preg_replace(
		array(
		// Remove invisible content
		'@<textarea[^>]*?>.*?</textarea>@siu',
		),
		array(
		' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',"$0", "$0", "$0", "$0", "$0", "$0","$0", "$0",), $text );
     
		return $text ;
	}
}
?>