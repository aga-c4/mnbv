<? require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'head.php'); ?>
<LINK href="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/default.css" type="text/css" rel="Stylesheet" media="screen">
<LINK href="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/mnbv.css" type="text/css" rel="Stylesheet" media="screen">
</head>
<body>
<?
echo (!empty($item['page_h1'])) ? ("<h1>".$item['page_h1']."</h1>\n") : '';
echo (!empty($item['page_content'])) ? ($item['page_content']."<br>\n") : '';
if (!empty($item['page_sctpl'])) {require(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.$item['page_sctpl']));echo "<br>\n";}
echo (!empty($item['page_content2'])) ? ($item['page_content2']."<br>\n") : '';
MNBVf::putFinStatToLog();
if (SysLogs::getLog()!=''){echo "<pre>LOG:\n"  . SysLogs::getLog() . "-------\n</pre>";}
if (SysLogs::getErrors()!=''){echo "<pre>ERRORS:\n" . SysLogs::getErrors() . "-------\n</pre>";} 
?>
</body>
</html>
