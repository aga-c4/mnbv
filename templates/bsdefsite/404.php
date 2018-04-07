<?php
/**
 * Шаблон 404 ошибки
 */

header("HTTP/1.0 404 Not Found");
if (!Glob::$vars['console']) header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
    <title>404 Not Found!</title>
</head>
<body>
<h1>404 Not Found!</h1>
<?=(SysLogs::getErrors()!='')?("<pre>Errors:\n".SysLogs::getErrors().'</pre>'):'';?>
<?=(SysLogs::getLog()!='')?("<pre>Errors:\n".SysLogs::getLog().'</pre>'):'';?>
</body>
</html>

