<?php
if (!Glob::$vars['console']) header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
    <title>Redirect</title>
</head>
<body>
<h1>Redirect</h1>
<?=(SysLogs::getErrors()!='')?("<pre>Errors:\n".SysLogs::getErrors().'</pre>'):'';?>
<?=(SysLogs::getLog()!='')?("<pre>Errors:\n".SysLogs::getLog().'</pre>'):'';?>
</body>
</html>

