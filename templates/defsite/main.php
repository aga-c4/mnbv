<?php
require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'head.php');

//Блок изменения ширины шаблона
if (Glob::$vars['session']->get('intranet_width')) $intranet_width = Glob::$vars['session']->get('intranet_width');
else $intranet_width = 1;

if (isset($_GET["fintranet_width"])){
    $fintranet_width=intval($_GET["fintranet_width"]);
    if (($fintranet_width>1)and($fintranet_width<980)){$fintranet_width=980;}//Установка минимальной ширины шаблона
    $intranet_width = $fintranet_width;
    Glob::$vars['session']->set('intranet_width',$intranet_width); //Варианты 0 или не задано - 100%, остальные числа - необходимая ширина шаблона
}
if (($intranet_width>1)and($intranet_width<980)){$intranet_width=980;}//Установка минимальной ширины шаблона
if ($intranet_width==1){$intranet_width_str='99%';}else{$intranet_width_str=$intranet_width.'px';}
//Конец блока изменения ширины шаблона

?>
<link rel="shortcut icon" href="<?=WWW_IMGPATH;?>logo/smallico.ico">
<LINK href="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/mnbv.css" type="text/css" rel="Stylesheet" media="screen">
<link type="/text/css" href="/src/mnbv/css/jquery.lightbox.css" rel="stylesheet">

<script src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/jquery-1.7.1.js" type="text/javascript"></script>
<script src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/jquery.lightbox.js?show_linkback=false&amp;show_helper_text=false&amp;show_info=true&amp;show_extended_info=true&amp;keys.close=z&amp;keys.prev=q&amp;keys.next=e&amp;text.image=Фото&amp;text.of=из&amp;text.close=Закрыть&amp;text.download=Загрузить" type="text/javascript"></script>
<script src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/jquery.lightbox_start.js" type="text/javascript"></script>
</head>
<body>
<div class="container" style="width:<?=$intranet_width_str;?>;">

<div class="gormenu" style="width:<?=$intranet_width_str;?>;overflow: hidden;">
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
<?=MNBVf::getNavStr($item['obj']['nav_arr'],array('fin_link_ctive'=>false,'link_class'=>'nav','delim'=>' -> '));?><br>
<?php
echo (!empty($item['page_h1'])) ? ("<h1>".$item['page_h1']."</h1>\n") : '';
echo (!empty($item['page_content'])) ? ($item['page_content']."\n") : '';
if (!empty($item['page_sctpl'])) {require(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.$item['page_sctpl']));}
echo (!empty($item['page_content2'])) ? ($item['page_content']."\n") : '';
MNBVf::putDBStatToLog();
if (SysLogs::getLog()!=''){echo "<pre>LOG:\n"  . SysLogs::getLog() . "-------\n</pre>";}
if (SysLogs::getErrors()!=''){echo "<pre>ERRORS:\n" . SysLogs::getErrors() . "-------\n</pre>";}
?>
</div>

<div class="futor" style="width:<?=$intranet_width_str;?>;">
<?php
echo '<span style="float:right;">'.Lang::get("Click to resize").' --->';
if ($intranet_width==1){echo '<a href="?fintranet_width=980" style="font-weight:bold;text-decoration:none;color:#000;">[980]</a>';}
elseif ($intranet_width<=980){echo '<a href="?fintranet_width=1250" style="font-weight:bold;text-decoration:none;color:#000;">[1250]</a>';}
elseif ($intranet_width<=1250){echo '<a href="?fintranet_width=1" style="font-weight:bold;text-decoration:none;color:#000;">[100%]</a>';}
else {echo '<a href="?fintranet_width=980" style="font-weight:bold;text-decoration:none;color:#000;">[980]</a>';}
echo "&nbsp;&nbsp;</span>\n";
?>
<span style="color:blue;">&nbsp;&nbsp;<?
if (Glob::$vars['user']->get('userid')>0) $langUserName = 'No name'; else $langUserName = '';
if (Glob::$vars['user']->get('name')!='') $langUserName = Glob::$vars['user']->get('name');
if (!Lang::isDefLang()&&Glob::$vars['user']->get('namelang')!='') $langUserName = Glob::$vars['user']->get('namelang');
echo '<a href="/intranet/auth/">'.$langUserName.'</a>';
?></span><br>
<span style="float:right;">Сopyright © 2012 <?=SysBF::getFrArr($item,'site_name');?>&nbsp;&nbsp;</span>
</div>
</div>

</body>
</html>
