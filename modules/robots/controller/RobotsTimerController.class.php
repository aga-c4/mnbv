<?php
/**
 * RobotsController class - класс робота для сбора основной статистики биржи Yobit
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class RobotsTimerController extends AbstractMnbvsiteController{

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

        usleep(1000000 * $usleepTime); //Спим $usleepTime секунд. чтоб все по базам записалось
        $procId = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'proc',''),'int');
        $rsid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'rsid',''),'strictstr');

        require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVProcess.class.php';  //Класс работы со словарями
        require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVRobot.class.php';  //Класс работы со словарями
        $proc = new MNBVRobot($procId);
        $procProp = $proc->getObj();
        $proc->setPsid($rsid);
        $procProp['sid'] = $rsid;

        if ($procProp!==null && (empty($procProp['sid']) || $procProp['sid']==$rsid)) {//Продолжаем работу только если данное задание не имеет sid, т.е. не запущено.

            //Откроем сессию, подключим пользователя, того, кто был редактором задания на выполнение.
            Glob::$vars['session'] = new MNBVSession(true,'','Nosave'); //Инициализация сессии
            Glob::$vars['session']->set('userid',$procProp['edituser']); //Скрипт запускается от идентификатора пользователя последнего редактора
            Glob::$vars['user'] = new MNBVUser(Glob::$vars['session']->get('userid'));

            //Установки языка и инициализация словаря
            if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['lang'].'.php'); //Переподключим основной словарь с языком пользователя
            MNBVf::requireFile(MNBVf::getRealFileName($this->thisModuleName, 'lang/LangDict_'.Glob::$vars['lang'].'.php')); //Словарь модуля

            echo "Start MNBV robot " . $this->thisModuleName . "! \n";
            echo "RSid=[$rsid]\n";
            echo "Pid=[".$proc->getPid()."]\n";
            echo "UserId=[".Glob::$vars['session']->get('userid')."]\n";
            echo "Script=[".$procProp['vars']['script']."]\n";
            echo "Output=[".$procProp['vars']['output']."]\n";

            while (true){ //Бесконечный цикл жизни робота
                $timeStart = microtime(true);

                $procProp = $proc->getObjById($procId);

                //Если отвалилась база данных и мы не можем получить
                if ($procProp===null){
                    $timeDelta = microtime(true) - $timeStart;
                    if ($timeDelta<1) usleep(intval(1000000 - 1000000 * $timeDelta));
                    continue;
                }

                //Проверка на маркер завершения, если есть, то оставливаем (включая маркер принудительной остановки)
                if ($procProp['status']=='stopped' || $procProp['status']=='killed') {
                    echo "Script stopped\n";
                    break;
                }

                //Валидация текущей сессии задания робота
                if (!$proc->validate($procProp)){
                    $proc->stopError('Validate Error!');
                    echo "Validate Error!\n";
                    break;
                }

                //Проверка на паузу, если есть, то переходим к расчету времени сна и следующей итерации
                if ($procProp['status']!='paused'){

                    //То, что делает робот
                    echo date("Y-m-d G:i:s") . "\n";

                }//конец проверки на паузу
                //Считаем оставшееся время в микросекундах до начала след итерации и отдыхаем это время.
                $timeDelta = microtime(true) - $timeStart;
                if ($timeDelta<1) usleep(intval(1000000 - 1000000 * $timeDelta));

            }

            $proc->clear(); //Если если это не бесконечный циклический процесс, то перед выходом очистим данные по процессу.

            //Запишем конфиг и логи----------------------
            MNBVf::putFinStatToLog();

        }

    }

}
