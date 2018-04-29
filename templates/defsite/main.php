<?php
require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'head.php');
?>
<link rel="shortcut icon" href="<?=WWW_IMGPATH;?>logo/smallico.ico">
<LINK href="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/default.css" type="text/css" rel="Stylesheet" media="screen">
<LINK href="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/mnbv.css" type="text/css" rel="Stylesheet" media="screen">
<link type="/text/css" href="/src/mnbv/css/jquery.lightbox.css" rel="stylesheet">

<script src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/jquery-1.7.1.js" type="text/javascript"></script>
<script src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/jquery.lightbox.js?show_linkback=false&amp;show_helper_text=false&amp;show_info=true&amp;show_extended_info=true&amp;keys.close=z&amp;keys.prev=q&amp;keys.next=e&amp;text.image=Фото&amp;text.of=из&amp;text.close=Закрыть&amp;text.download=Загрузить" type="text/javascript"></script>
<script src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/jquery.lightbox_start.js" type="text/javascript"></script>
</head>
<body>
<div class="container" style="width:100%;">

<div class="gormenu" style="width:100%;overflow: hidden;">
<span style="float:right;padding-right:5px;">
<?
    if (Lang::isDefLang()){ //Это основной язык
        echo ' | <b>' . Lang::getDefLang() . '</b> | <a href="' . ((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'') . '">' . Lang::getAltLangName() . '</a>';
    }else{ //Это альтернативный язык
        echo ' | <a href="' . ((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'') . '">' . Lang::getDefLang() . '</a> | <b>' . Lang::getAltLangName() . '</b>';
    }

?>
</span>
<a href="<?=((!empty(Glob::$vars['mnbv_site']['maindomain']))?(Glob::$vars['mnbv_site']['protocol'].Glob::$vars['mnbv_site']['maindomain']):'/').((Lang::isAltLang())?('/'.Lang::getAltLangName()):'');?>"><img src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/img/logo/logomini1.png" width="27" height="30" border="0" style="vertical-align: middle;"></a>
<?MNBVf::startVidget('gormenu',$item,3);?>
</div>

<div class="content">
<?=(!empty($item['obj']['nav_arr']))?MNBVf::getNavStr($item['obj']['nav_arr'],array('fin_link_ctive'=>false,'link_class'=>'nav','delim'=>' -> ')):'';?><br>
<?php
echo (!empty($item['page_h1'])) ? ("<h1>".$item['page_h1']."</h1>\n") : '';
echo (!empty($item['page_content'])) ? ($item['page_content']."\n") : '';
if (!empty($item['page_sctpl'])) {require(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.$item['page_sctpl']));}
echo (!empty($item['page_content2'])) ? ($item['page_content']."\n") : '';
MNBVf::putFinStatToLog();
if (SysLogs::getLog()!=''){echo "<pre>LOG:\n"  . SysLogs::getLog() . "-------\n</pre>";}
if (SysLogs::getErrors()!=''){echo "<pre>ERRORS:\n" . SysLogs::getErrors() . "-------\n</pre>";}
?>
</div>

<div class="futor" style="width:100%;">
<span style="color:blue;">&nbsp;&nbsp;<?
if (Glob::$vars['user']->get('userid')>0) $langUserName = 'No name'; else $langUserName = '';
if (Glob::$vars['user']->get('name')!='') $langUserName = Glob::$vars['user']->get('name');
if (!Lang::isDefLang()&&Glob::$vars['user']->get('namelang')!='') $langUserName = Glob::$vars['user']->get('namelang');
echo '<a href="/intranet/auth">'.$langUserName.'</a>';
?></span>
<span style="float:right;">Сopyright © 2006-2018, AGA-C4 <?=SysBF::getFrArr($item,'site_name');?>&nbsp;&nbsp;</span>
</div>
</div>

</body>
</html>
