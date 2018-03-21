<?
/**
 * Заголовок html шаблона с метатегами и др.
 */
if (empty(Glob::$vars['console'])) header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
    <TITLE><?=isset(Glob::$vars['page_title'])?Glob::$vars['page_title']:'';?></TITLE>
    <META NAME="title" CONTENT="<?=isset(Glob::$vars['page_title'])?Glob::$vars['page_title']:'';?>">
    <META name="keywords" lang="ru" content="<?=isset(Glob::$vars['page_keywords'])?Glob::$vars['page_keywords']:'';?>">
    <META name="description" content="<?=isset(Glob::$vars['page_description'])?Glob::$vars['page_description']:'';?>">
    <META NAME="author" content="Khachaturyan Konstantin (MNBV.ru)">
    <META http-equiv=Content-Type content="text/html; charset=utf-8">
