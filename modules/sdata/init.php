<?php
/**
 * Начальная инициализация модуля
 */

Glob::$vars['session'] = new MNBVSession(true); //Инициализация сессии
if (Glob::$vars['session']->get('logs_view')!==NULL) SysLogs::$logView = (Glob::$vars['session']->get('logs_view'))?true:false; //Видимость Лога работы скрипта
if (!Glob::$vars['session']->get('userid')) Glob::$vars['session']->set('userid',0);
Glob::$vars['user'] = new MNBVUser(Glob::$vars['session']->get('userid'));