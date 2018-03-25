<?php
if (!Glob::$vars['console']) header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
    <title>NBV Redirect</title>
</head>
<body>
<h1>MNBV Redirect</h1>
<? MNBVf::putFinStatToLog(); ?>
<?=(SysLogs::getErrors()!='')?("<pre>Errors:\n".SysLogs::getErrors().'</pre>'):'';?>
<?=(SysLogs::getLog()!='')?("<pre>Log messages:\n".SysLogs::getLog().'</pre>'):'';?>
</body>
</html>
