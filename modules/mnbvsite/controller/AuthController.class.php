<?php
/**
 * Auth Controller - контроллер авторизации
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class AuthController extends AbstractMnbvsiteController {

    /**
     * Метод по-умолчанию
     * @param $item массив $item, сформированный в родительском контроллере
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($item=array(),$tpl_mode='html', $console=false){

        $sid = Glob::$vars['session']->sid;
        $sidName = Glob::$vars['session']->sidName;

        //Действия в рамках данного контроллера
        $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');
        switch ($act){
            case 'auth': //Авторизация  
                Glob::$vars['user'] = new MNBVUser();
                $ul = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ul'),'login');
                $fu = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'fu'),'passwd');;
                $res = Glob::$vars['user']->load(0,$ul,$fu,$sid); 
                Glob::$vars['session']->set('userid',$res);
                
                //Сделаем первоначальную установку переменных персонализации
                if (Glob::$vars['user']->get('userid')==0){//Если это пользоваетель 0
                    MNBVf::logoutOperations(); //Первоначальные установки
                }else{//Если установлен пользователь
                    MNBVf::loginOperations(); //Установки с сессией и глобальными переменными
                }
                Glob::$vars['session']->save(); //Сохраним данные сессии
                //MNBVf::redirect('/intranet/storage/'); //Редирект в корень сайта               
                break;
            
            case 'logout': //Авторизация
                Glob::$vars['session']->set('userid',0);
                Glob::$vars['user'] = new MNBVUser();
                MNBVf::logoutOperations(); //Первоначальные установки
                Glob::$vars['session']->save(); //Сохраним данные сессии
                //MNBVf::redirect('/intranet/auth/'); //Редирект в корень сайта
                break;
        }

        $item['sid'] = $sid; 
        $item['sidName'] = $sidName;
                
        //Блок контента, который будет выводиться в шаблоне
        if (Glob::$vars['user']->get('userid')){ //Авторизованный пользователь
            $item['page_sctpl'] = 'tpl_auth_userinfo.php'; //Шаблон
            $item['user'] =  Glob::$vars['user']->getall();
        }else{//Неавторизованный
            $item['page_sctpl'] = 'tpl_auth.php'; //Шаблон
            $item['user'] = array();
            //$item['user']['login'] = 'Login';
        }

        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);

    }

}
