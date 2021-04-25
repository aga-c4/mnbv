<?php
/**
 * Начальная инициализация модуля. Как правило этот файл одинаковый и совпадает с типовым из модуля mnbvdefault, однако в некоторых модулях он может отличаться
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00 
 */
SysLogs::addLog('Submodules_init start mnbv_module = ['.Glob::$vars['mnbv_module'].'].' );

Glob::$vars['session'] = new MNBVSession(true); //Инициализация сессии

//Установки языка и инициализация словаря
SysLogs::addLog('lang=['.Glob::$vars['lang'].'] def_lang=['.Glob::$vars['def_lang'].'] Lang::lang=['.Lang::getLang().'] Lang::def_lang=['.Lang::getDefLang().'] Lang::alt_lang=['.((Lang::isAltLang())?'TRUE':'FALSE').']');
if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['lang'].'.php'); //Переподключим основной словарь с языком пользователя
MNBVf::requireFile(MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'lang/LangDict_'.Glob::$vars['lang'].'.php')); //Словарь модуля 
if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'lang/LangDict_'.Glob::$vars['def_lang'].'.php'));  //Словарь модуля дефолтовый
