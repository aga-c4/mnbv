<?php
/**
 * RobotsController class - класс робота запуска кроновых скриптов
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class RobotsStartcronController extends AbstractMnbvsiteController{

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
        SysLogs::$logsEnable = false; //Накапливать лог
        SysLogs::$errorsEnable = false; //Накапливать лог ошибок
        SysLogs::$logRTView = true; //Выводить сообщения непосредственно при их формировании. Если не установлено SysLogs::$logView, то выводятся только ошибки
        SysLogs::$logView = false; //Показывать лог событий скрипта (суммарный для ошибок и событий). Если не задано, то сообщения обычные в лог не будут выводиться даже при установленном SysLogs::$logRTView
        #################################################################

        //Если надо спать в начале, то спим, чтоб база успела обновиться и pid там бы был.
        usleep(1000000 * $usleepTime); //Спим $usleepTime секунд. чтоб все по базам записалось
        $procId = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'proc',''),'int');
        $rsid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'rsid',''),'strictstr');
        
        echo "Start MNBV robot " . $this->thisModuleName . "! \n";
        echo "RSid=[$rsid]\n";

        require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVProcess.class.php';  //Класс работы со словарями
        require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVRobot.class.php';  //Класс работы со словарями
        $proc = new MNBVRobot('zbrobotsrun',$procId);
        $procProp = $proc->getObj();

        if ($procProp!==null && (empty($procProp['sid']) || $procProp['sid']==$rsid)) {//Продолжаем работу только если данное задание не имеет sid, т.е. не запущено.

            $proc->setPsid($rsid);
            $procProp['sid'] = $rsid;

            //Откроем сессию, подключим пользователя, того, кто был редактором задания на выполнение.
            Glob::$vars['session'] = new MNBVSession(true,'','Nosave'); //Инициализация сессии
            Glob::$vars['session']->set('userid',$procProp['edituser']); //Скрипт запускается от идентификатора пользователя последнего редактора
            Glob::$vars['user'] = new MNBVUser(Glob::$vars['session']->get('userid'));

            echo "Pid=[".$proc->getPid()."]\n";
            echo "UserId=[".Glob::$vars['session']->get('userid')."]\n";
            echo "Script=[".$procProp['vars']['script']."]\n";
            echo "Output=[".$procProp['vars']['output']."]\n\n";
            echo date("Y-m-d G:i:s") . " Run cron scripts:\n";

            $crmin = date("i");
            $crhour = date("G");
            $crday = date("d");
            $crmonth = date("m");
            $crweek = date("w");

            //То, что делает робот
            //1. Запросим задания, исполняемые по крону
            $storageRes = MNBVStorage::getObj('zbrobotsrun',
                array("id","name","sid","vars"),
                array("cronrun","=","1","and","type","=","0","and","visible","=","1"));

            //2. Переберем задания и выберем те из них, которым пора запуститься и у которых допустимые для запуска статусы, запустим эти скрипты в отдельных процессах.
            unset($storageRes[0]); //Вынесем размер списка из массива
            foreach ($storageRes as $task) if (!empty($task["id"])) {
                $task['vars'] = (!empty($task['vars']))?SysBF::json_decode($task['vars']):array();
                //Проверка расписания запуска текущего задания
                if ($task['sid']!="" && empty($task['vars']['always'])) continue; //Запускаем, если sid пустой, либо есть маркер безусловного запуска
                if (!isset($task['vars']['crmin']) || !MNBVf::validateValByStr($crmin,$task['vars']['crmin'])) continue;
                if (!isset($task['vars']['crhour']) || !MNBVf::validateValByStr($crhour,$task['vars']['crhour'])) continue;
                if (!isset($task['vars']['crday']) || !MNBVf::validateValByStr($crday,$task['vars']['crday'])) continue;
                if (!isset($task['vars']['crmonth']) || !MNBVf::validateValByStr($crmonth,$task['vars']['crmonth'])) continue;
                if (!isset($task['vars']['crweek']) || !MNBVf::validateValByStr($crweek,$task['vars']['crweek'])) continue;

                $stProc = new MNBVRobot('zbrobotsrun',$task["id"]);
                if ($stProc->start((!empty($task['vars']['always']))?'restart':'')) echo date("Y-m-d G:i:s") . ' ' . $stProc->getRobotAlias() . " sid=[" . $stProc->getPsid() . "]\n";
            }

            //Финальные операции
            $proc->clear('status'); //Если если это не бесконечный циклический процесс, то перед выходом очистим данные по процессу.

        }
        
        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start'] - $usleepTime));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        echo "\n";
        echo 'Starttime: ' . Glob::$vars['datetime_start'] . "\n";
        echo "Endtime: $script_datetime_stop" . "\n";
        echo "Runtime: $time_script" . "\n";
        //echo "------Log-------\n";
        //echo SysLogs::getLog() . "\n";
        //echo MNBVf::putDBStatToLog() . "\n";

    }

}
