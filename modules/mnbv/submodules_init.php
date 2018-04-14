<?php
/**
 * Начальная инициализация модуля. Как правило этот файл одинаковый и совпадает с типовым из модуля mnbvdefault, однако в некоторых модулях он может отличаться
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00 
 */
SysLogs::addLog('Modules_init start mnbv_module = ['.Glob::$vars['mnbv_module'].'].' );

//Установки языка и инициализация словаря
if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['lang'].'.php'); //Переподключим основной словарь с языком пользователя
MNBVf::requireFile(MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'lang/LangDict_'.Glob::$vars['lang'].'.php')); //Словарь модуля 
if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'lang/LangDict_'.Glob::$vars['def_lang'].'.php'));  //Словарь модуля дефолтовый
