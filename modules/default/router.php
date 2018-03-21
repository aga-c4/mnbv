<?php
/**
 * router.php Маршрутизатор модуля default
 *
 * Created by Konstantin Khachaturyan
 * User: AGA-C4
 * Date: 09.04.15
 * Time: 16:53
 */

//if (!empty(Glob::$vars['request']['module'])) { Glob::$vars['module'] = Glob::$vars['request']['module'];}
if (!empty(Glob::$vars['controller'])) {$controller = Glob::$vars['controller'];}else $controller = SysBF::trueName(Glob::$vars['module'],'title');
if (!empty(Glob::$vars['action'])) {$action = Glob::$vars['action'];}else{$action = 'index';}
