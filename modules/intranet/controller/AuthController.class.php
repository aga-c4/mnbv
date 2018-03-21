<?php
/**
 * Auth Controller - контроллер авторизации
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class AuthController {
    
    /**
     * @var string - Имя модуля контроллера (Внимание, оно должно соответствовать свойству $thisModuleName фронт контроллера модуля (используется во View)
     */
    public $thisModuleName = '';
    
    public function __construct($thisModuleName) {
        $this->thisModuleName = $thisModuleName;
    }

    /**
     * Метод по-умолчанию
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($tpl_mode='html', $console=false){
        $this->action_auth($tpl_mode, $console);//Покажем авторизацию
    }
    
    /**
     * Вывод страницы авторизации
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_auth($tpl_mode='html', $console=false){

        //MNBVf::redirect('/'); //Редирект в корень сайта

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
                MNBVf::redirect('/intranet/storage/'); //Редирект в корень сайта
                
            break;

            case 'update':

                if (MNBVf::getViewLogsStatus()){//Настройки логов и редректа и всего остального доступны только тем, у кого в админке стоит маркер viewlogs
                    //Сменим статус отображения лога на противоположный
                    $logs_view = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'logs_view'),'on');
                    SysLogs::$logView = (!empty($logs_view))?true:false;
                    Glob::$vars['session']->set('logs_view',SysLogs::$logView);

                    $allow_redirect = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'allow_redirect'),'on');
                    Glob::$vars['allow_redirect'] = (!empty($allow_redirect))?true:false;
                    Glob::$vars['session']->set('allow_redirect',Glob::$vars['allow_redirect']);

                    Glob::$vars['session']->save(); //Сохраним данные сессии
                }

                break;
            case 'logout': //Авторизация
                Glob::$vars['session']->set('userid',0);
                Glob::$vars['user'] = new MNBVUser();
                MNBVf::logoutOperations(); //Первоначальные установки
                Glob::$vars['session']->save(); //Сохраним данные сессии
                MNBVf::redirect('/intranet/auth/'); //Редирект в корень сайта
            break;
        }

        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("MNBV authorization","module_names"); //Метатеги
        $item = array(); //Массив данных, передаваемых во View

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

        $PgHtml = '';
        $item['page_content'] = $PgHtml;
        $item['page_h1'] = Glob::$vars['page_h1'];

        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);

    }

}
