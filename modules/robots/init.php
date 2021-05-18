<?php
/**
 * Начальная инициализация модуля MNBV
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Установки языка и инициализация словаря (важно файлы всех используемых языков должны быть хотя бы в модуле MNBV)
//Lang::addNewLangs(array('ru','en')); //При необходимости так можно добавить новый язык в списк алиасов языков
Lang::setDefLang(Glob::$vars['def_lang']); //Установим язык по-умолчанию из системной переменной
Lang::setLang(Glob::$vars['lang']); //Установим язык из системной переменной
Lang::setAltLangName(Glob::$vars['mnbv_altlang_name']); //Установим алиас альтернативного языка из системной переменной
MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['lang'].'.php'); //Подключим основной словарь с языком пользователя
if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['def_lang'].'.php');
