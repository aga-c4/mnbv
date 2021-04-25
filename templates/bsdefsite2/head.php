<?php
/**
 * Заголовок html шаблона с метатегами и др.
 * 
 * <html lang="en">
 * <html lang="ru">
 */
if (!Glob::$vars['console']) header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="<?=(Lang::isDefLang())?'ru':'en';?>">
<head>
    <TITLE><?=isset(Glob::$vars['page_title'])?Glob::$vars['page_title']:'';?></TITLE>
    <META name="title" content="<?=isset(Glob::$vars['page_title'])?Glob::$vars['page_title']:'';?>">
    <META name="keywords" lang="ru" content="<?=isset(Glob::$vars['page_keywords'])?Glob::$vars['page_keywords']:'';?>">
    <META name="description" content="<?=isset(Glob::$vars['page_description'])?Glob::$vars['page_description']:'';?>">
    <META name="author" content="Khachaturyan Konstantin (MNBV.ru)">
    <META http-equiv=Content-Type content="text/html; charset=utf-8">   
    <meta charset="utf-8">
