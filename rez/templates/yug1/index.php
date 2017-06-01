<?php

/**
 * Template for Joomla! CMS, created with Artisteer.
 * See readme.txt for more details on how to use the template.
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';

// Create alias for $this object reference.
$document = & $this;

$templateUrl = $document->baseurl . '/templates/' . $document->template;
artxComponentWrapper($document);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $document->language; ?>" lang="<?php echo $document->language; ?>" >
<head>
<div style="padding:0px; position:absolute; margin-right:-300px; right:50%; top:50px; z-index:1"><p><a mce_href="http://ug-1.com.ua/cheluskintsev_57" href="http://ug-1.com.ua/cheluskintsev_57"><img onmouseout="return true;this.src='http://ug-1.com.ua/images/link.png';" onmouseover="return true;this.src='http://ug-1.com.ua/images/link_2.png';" src="http://ug-1.com.ua/images/link_2.png" mce_src="images/link_2.png" border="0" width="600px" alt=""></a><br mce_bogus="1"></p></div>
<!--
Skype 'Мой статус' button
http://www.skype.com/go/skypebuttons
-->
<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<div style="z-index:2;position:absolute;top:10px;right:50%;margin-right:-485px;"><a href="skype:ug-odin?call"><img src="http://mystatus.skype.com/smallicon/ug-odin" style="border:none;" width="16" height="16" alt="My status" title="Связаться с нами через Skype!"/></a></div>
<div style="position:absolute; top:-30px; margin-right:-500px;padding:0px; z-index:1; right:50%;"><script type="text/javascript" src="http://www.skypeassets.com/i/scom/js/skype-uri.js"></script>
<div id="SkypeButton_Call_ug-odin_1">
  <script type="text/javascript">
    Skype.ui({
      "name": "chat",
      "element": "SkypeButton_Call_ug-odin_1",
      "participants": ["ug-odin"],
      "imageColor": "white",
      "imageSize": 32
    });
  </script>
</div></div>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
 <jdoc:include type="head" />
 <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/system.css" type="text/css" />
 <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/general.css" type="text/css" />
 <link rel="stylesheet" type="text/css" href="<?php echo $templateUrl; ?>/css/template.css" media="screen" />
 <!--[if IE 6]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie6.css" type="text/css" media="screen" /><![endif]-->
 <!--[if IE 7]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie7.css" type="text/css" media="screen" /><![endif]-->
 <script type="text/javascript" src="<?php echo $templateUrl; ?>/jquery.js"></script>
 <script type="text/javascript">jQuery.noConflict();</script>
 <script type="text/javascript" src="<?php echo $templateUrl; ?>/script.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
</head>
<body>
<!-- Rating@Mail.ru counter -->
<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({id: "2521391", type: "pageView", start: (new Date()).getTime()});
(function (d, w) {
   var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true;
   ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
   var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
   if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window);
</script><noscript><div style="position:absolute;left:-10000px;">
<img src="//top-fwz1.mail.ru/counter?id=2521391;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->
<div id="art-main">
<div class="art-sheet">

    <div class="art-sheet-body">
<div class="art-header">
    <div class="art-header-center">
        <div class="art-header-jpeg"></div>
    </div>

</div>
<jdoc:include type="modules" name="user3" />
<jdoc:include type="modules" name="banner1" style="artstyle" artstyle="art-nostyle" />
<?php echo artxPositions($document, array('top1', 'top2', 'top3'), 'art-block'); ?>
<div class="art-content-layout">
    <div class="art-content-layout-row">
<?php $contentCellStyle = artxCountModules($document, 'right') ? 'content' : 'content-wide'; ?>
<div class="art-layout-cell art-<?php echo $contentCellStyle; ?>">

<?php
  echo artxModules($document, 'banner2', 'art-nostyle');
  if (artxCountModules($document, 'breadcrumb'))
    echo artxPost(artxModules($document, 'breadcrumb'));
  echo artxPositions($document, array('user1', 'user2'), 'art-article');
  echo artxModules($document, 'banner3', 'art-nostyle');
?>
<?php if (artxHasMessages()) : ?><div class="art-post">

    <div class="art-post-body">
<div class="art-post-inner">
<div class="art-postcontent">

<jdoc:include type="message" />

</div>
<div class="cleared"></div>

</div>

		<div class="cleared"></div>
    </div>
</div>
<?php endif; ?>
<jdoc:include type="component" />
<?php echo artxModules($document, 'banner4', 'art-nostyle'); ?>
<?php echo artxPositions($document, array('user4', 'user5'), 'art-article'); ?>
<?php echo artxModules($document, 'banner5', 'art-nostyle'); ?>

  <div class="cleared"></div>
</div>
<?php if (artxCountModules($document, 'right')) : ?>
<div class="art-layout-cell art-sidebar1">
<?php echo artxModules($document, 'right', 'art-block'); ?>

  <div class="cleared"></div>
</div>
<?php endif; ?>

    </div>
</div>
<div class="cleared"></div>


<?php echo artxPositions($document, array('bottom1', 'bottom2', 'bottom3'), 'art-block'); ?>
<jdoc:include type="modules" name="banner6" style="artstyle" artstyle="art-nostyle" />
<div class="art-footer">
    <div class="art-footer-t"></div>
    <div class="art-footer-l"></div>
    <div class="art-footer-b"></div>
    <div class="art-footer-r"></div>
    <div class="art-footer-body">
         <?php echo artxModules($document, 'syndicate'); ?>
        <div class="art-footer-text">
  <?php if (artxCountModules($document, 'copyright') == 0): ?>
    <?php ob_start(); ?>
<p></p><p>ЖСК "ЮГ-1" %YEAR%. Все права защищены.</p>
    <?php echo str_replace('%YEAR%', date('Y'), ob_get_clean()); ?>
  <?php else: ?>
  <?php echo artxModules($document, 'copyright', 'art-nostyle'); ?>
  <?php endif; ?>
        </div>
        <div class="cleared"></div>
    </div>
</div>
		<div class="cleared"></div>
    </div>
</div>
<div class="cleared"></div>
<p class="art-page-footer"></a></p>

</div>




<a href="#" id="toTop"><img src=http://ug-1.com.ua/images/stories/up_button.png border="0" align="absmiddle" /></a>
<script src="http://ug-1.com.ua/toTop.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
$("#toTop").scrollToTop();
});
</script>
</body> 
</html>