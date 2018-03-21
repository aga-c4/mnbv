<? require_once MNBVf::getRealFileName(MNBV_MAINMODULE, MOD_VIEWPATH . 'head.php'); ?>
</head>
<body>
<?
echo (isset($item['page_content'])) ? ($item['page_content']."<br>\n") : '';
if (SysLogs::getLog()!=''){echo "<pre>LOG:\n" . SysLogs::getLog() . "-------\n</pre>";}
if (SysLogs::getErrors()!=''){echo "<pre>ERRORS:\n" . SysLogs::getErrors() . "-------\n</pre>";}
?>
</body>
</html>
