<? require_once APP_MODULESPATH . 'default/view/head.php'; ?>
</head>
<body>
<?
echo (isset($item['page_h1'])) ? ("<h1>".Glob::$vars['page_h1']."</h1>\n") : '';
echo (isset($item['page_content'])) ? ($item['page_content']."<br>\n") : '';
if (SysLogs::getLog()!=''){echo "<pre>LOG:\n" . SysLogs::getLog() . "-------\n</pre>";}
if (SysLogs::getErrors()!=''){echo "<pre>ERRORS:\n" . SysLogs::getErrors() . "-------\n</pre>";}
?>
</body>
</html>
