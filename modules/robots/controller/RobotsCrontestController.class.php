<?php
/**
 * RobotsController class - класс тестового cron робота
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class RobotsCrontestController extends AbstractMnbvsiteController{

    /**
     * @var string - Имя робота
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
    public function action_index($item=array(),$tpl_mode='html', $console=false){

        #################################################################
        # Стартовый конфиг
        #################################################################
        ini_set('max_execution_time', 0); //Максимальное время выполнения скрипта, установим в 0, чтоб небыло ограничений. Устанавливаем в контроллере, т.к. могут быть роботы с установленным ограничением по времени
        $usleepTime = 1; //1 секунда - понадобится позже при вычислении реального времени выполнения.
        //SysLogs::$logsEnable = false; //Накапливать лог
        //SysLogs::$errorsEnable = false; //Накапливать лог ошибок
        //SysLogs::$logRTView = true; //Выводить сообщения непосредственно при их формировании. Если не установлено SysLogs::$logView, то выводятся только ошибки
        //SysLogs::$logView = false; //Показывать лог событий скрипта (суммарный для ошибок и событий). Если не задано, то сообщения обычные в лог не будут выводиться даже при установленном SysLogs::$logRTView
        #################################################################

        //Если надо спать в начале, то спим, чтоб база успела обновиться и pid там бы был.
        usleep(1000000 * $usleepTime); //Спим $usleepTime секунд. чтоб все по базам записалось
        $procId = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'proc',''),'int');
        $rsid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'rsid',''),'strictstr');

        $proc = new MNBVRobot($procId);
        $procProp = $proc->getObj();

        if ($procProp!==null && (empty($procProp['sid']) || $procProp['sid']==$rsid)) {//Продолжаем работу только если данное задание не имеет sid, т.е. не запущено.
        
            $proc->setPsid($rsid);
            $procProp['sid'] = $rsid;

            //Откроем сессию, подключим пользователя, того, кто был редактором задания на выполнение.
            Glob::$vars['session'] = new MNBVSession(true,'','Nosave'); //Инициализация сессии
            Glob::$vars['session']->set('userid',$procProp['edituser']); //Скрипт запускается от идентификатора пользователя последнего редактора
            Glob::$vars['user'] = new MNBVUser(Glob::$vars['session']->get('userid'));

            echo "Start MNBV robot " . $this->thisModuleName . "! \n";
            echo "RSid=[$rsid]\n";
            echo "Pid=[".$proc->getPid()."]\n";
            echo "UserId=[".Glob::$vars['session']->get('userid')."]\n";
            echo "Script=[".$procProp['vars']['script']."]\n";
            echo "Output=[".$procProp['vars']['output']."]\n";

            //То, что делает робот
            echo date("Y-m-d G:i:s") . " Run cron script!\n";
            echo date("Y-m-d G:i:s") . " Stop cron script!\n";

            //Финальные операции
            $proc->clear('status'); //Если если это не бесконечный циклический процесс, то перед выходом очистим данные по процессу. 

            //Запишем конфиг и логи----------------------
            MNBVf::putFinStatToLog();
        
        }

    }

}
