<?php
/**
 * RobotsController class - класс тестового cron робота
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class RobotsUniversalController extends AbstractMnbvsiteController{

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
        ini_set('memory_limit', '128M'); //Максимальный лимит по памяти на время выполенения скрипта
        ini_set('max_execution_time', 0); //Максимальное время выполнения скрипта, установим в 0, чтоб небыло ограничений. Устанавливаем в контроллере, т.к. могут быть роботы с установленным ограничением по времени
        $usleepTime = 5; //1 секунда - понадобится позже при вычислении реального времени выполнения.
        $minIterTime = 1; //Минимальное расстояние между итерациями запуска
        //SysLogs::$logsEnable = false; //Накапливать лог
        //SysLogs::$errorsEnable = false; //Накапливать лог ошибок
        //::$logRTView = true; //Выводить сообщения непосредственно при их формировании. Если не установлено SysLogs::$logView, то выводятся только ошибки
        //::$logView = false; //Показывать лог событий скрипта (суммарный для ошибок и событий). Если не задано, то сообщения обычные в лог не будут выводиться даже при установленном SysLogs::$logRTView
        $outputFilename = 'data/storage_files/'.Glob::$vars['robotsRunStorage'].'/att/p[obj_id]_2.txt';
        $telegramToken = '';
        $telegramChatId = '';
        #################################################################

        $telegram = new MNBVTelegram($telegramToken,$telegramChatId); //Объект для передачи сообщений в телеграм
        $continueMainOk = true;

        //Если надо спать в начале, то спим, чтоб база успела обновиться и pid там бы был.
        usleep(1000000 * $usleepTime); //Спим $usleepTime секунд. чтоб все по базам записалось
        $procId = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'proc',''),'int');
        $rsid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'rsid',''),'strictstr');

        $proc = new MNBVRobot($procId);
        $procProp = $proc->getObj();

        //Открое файл с логом для записи туда результата работы
        //Запишем в файл
        $logFileOk = false; $outputFile = null; //По-умолчанию никакого лога не пишем
        //$outputFilename = str_replace('[obj_id]',$procId,$outputFilename); //Имя файла лога действий этого скрипта.
        //$outputFile = fopen($outputFilename,"a");
        //if ($outputFile === false){
        //    $continueMainOk = false;
        //    SysLogs::addError("Error open Log file [$outputFilename]!");
        //} else $logFileOk = true;

        //Стартовая валидация sid должен либо совпадать с тем что в БД, либо в БД не должно быть заполнено это поле. Модифицируйте условие для скриптов с возможностью паралельного запуска.
        if ($continueMainOk && $procProp!==null && (empty($procProp['sid']) || $procProp['sid']==$rsid)) {

            if (empty($procProp['sid'])){//Если sid не задан в БД, то запишем его туда
                $proc->setPsid($rsid);
                $updateArr = array();
                $updateArr['sid'] = $procProp['sid'] = $rsid;
                $updateArr['status'] = $procProp['status'] = 'working';
                $updateArr['message'] = $procProp['message'] = 'From ' . date("Y-m-d H:i:s");
                MNBVStorage::setObj($proc->getStorage(), $updateArr, array("id",'=',$procId));
            }

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
            $scriptvarsArr = array();
            if (!empty($procProp['vars']['scriptvars'])) {
                echo "Scriptvars=[".$procProp['vars']['scriptvars']."]\n";
                $scriptvarsArr = json_decode($procProp['vars']['scriptvars'],true);
            }

            //То, что делает робот
            echo date("Y-m-d H:i:s") . " Run script!\n";

            #########################################[ То, что делает робот ]###########################################

            $countIter=0;
            $mrktDeltaTime = 0; //Отклонение времени внешней системы от текущего времени сервера

            $lastSaveMin60sec = array();
            $lastRunTicGen = 0;
            $lastTid = 0;
            $lastBtcUsdUpVal = 0;
            $lastBtcUsdDnVal = 0;
            $maxTimeDelta = 0;
            $MaxTimeMrktGet = 0;
            $longIterSumm = 0;
            $lastQtySecTime = 0;
            $maxMemUsage = 0;
            while (true){ //Бесконечный цикл жизни робота. Вы можете сделать роботов, которые не работают в цикле, а пускаются по крону например.
                $timeStart = microtime(true);
                $timeStartSec = intval($timeStart);
                $timeStartMrkt = intval($timeStart + $mrktDeltaTime);
                $timeStartMrktSec = intval($timeStartMrkt);
                $timeMrktGet = 0;

                $newMinSec = $timeStartSec%60;
                $lastMin1sec = $timeStartSec - $newMinSec - 59;
                $lastMin60sec = $timeStartSec - $newMinSec;

                $procProp = $proc->getObjById($procId);

                //Если отвалилась база данных и мы не можем получить
                if ($procProp===null){
                    //Вывод сообщения о очередном максимуме расхода памяти
                    $cur_memory_usage = intval(memory_get_usage() / (1024 * 1024));
                    if (empty($maxMemUsage) || $cur_memory_usage>$maxMemUsage) {
                        $maxMemUsage = $cur_memory_usage;
                        echo date("Y-m-d H:i:s") . " New max memory_usage: ".number_format($maxMemUsage, 3)." Mb\n";
                    }
                    $timeDelta = microtime(true) - $timeStart;
                    if ($timeDelta<1) usleep(intval(1000000 - 1000000 * $timeDelta));
                    continue;
                }

                //Проверка на маркер завершения, если есть, то оставливаем (включая маркер принудительной остановки)
                if ($procProp['status']=='stopped' || $procProp['status']=='killed') {
                    echo "Script stopped\n";
                    break;
                }

                //Если sid процесса отличается от актуального из базы, то надо останавливать робота
                if ($procProp['sid'] !== $proc->getPsid()){
                    $proc->stopError('Validate Error!');
                    echo "Validate Error!\n";
                    break;
                }


                //Проверка на паузу, если есть, то переходим к расчету времени сна и следующей итерации
                if ($procProp['status']!='paused'){

                    //То, что делает робот
                    ###############################[ То, что делает робот в бесконечном цикле]################
                    $outputLogStr = '';










                    ################################[ Конец циклической работы робота ]########################

                    ############################################################################################
                    ## Сервисные операции
                    ############################################################################################
                    //$timeValOver = microtime(true);
                    //echo date("Y-m-d H:i:s",intval($timeStartSec)) . " ValLag=".sprintf("%.8f", $timeValOver-$timeValbefore)."s \n";

                    //Вывод сообщения о очередном максимуме расхода памяти
                    $cur_memory_usage = intval(memory_get_usage() / (1024 * 1024));
                    if (empty($maxMemUsage) || $cur_memory_usage>$maxMemUsage) {
                        $maxMemUsage = $cur_memory_usage;
                        echo date("Y-m-d H:i:s") . " New max memory_usage: ".number_format($maxMemUsage, 3)." Mb\n";
                    }
                    ################################[ Конец сервисных операций ]###############################

                    //Запись результата операции в лог.
                    if ($logFileOk) fwrite($outputFile,$outputLogStr);

                }//конец проверки на паузу
                //Считаем оставшееся время в микросекундах до начала след итерации и отдыхаем это время.
                $timeDelta = microtime(true) - $timeStart;

                if ($procProp['status']!='paused'){//Если не на паузе, то раз в 600 сек примерно будем выводить текущий лог
                    $countIter++;
                    if ($timeDelta > $maxTimeDelta) $maxTimeDelta = $timeDelta;
                    if ($timeMrktGet > $MaxTimeMrktGet) $MaxTimeMrktGet = $timeMrktGet;
                    if ($timeDelta>1) $longIterSumm++;
                    if (!$countIter%10) {//Каждую 10 секунду что-нибудь сделаем
                        ;
                    }
                    if ($countIter>3600) {//1 раз в час запускаем эту обработку, которая выдаст лог и удалит из памяти старые данные
                        $countIter=0;
                        echo "------ Log ".date("Y-m-d H:i:s")." -------\n";
                        echo "Iteration time>1s. = " . $longIterSumm . "\n";
                        echo "Max Iteration time = " . $maxTimeDelta . "s.\n";
                        echo "Max Get time = " . $MaxTimeMrktGet . "s.\n";
                        echo "Memory_usage: ".number_format((memory_get_usage() / (1024 * 1024)), 3)." Mb\n";
                        echo MNBVf::getDBStat() . "\n";
                        //$telegram->telegramApiQuery('sendMessage', array('text'=>'Время: '. date("Y-m-d H:i:s",time())));
                        $maxTimeDelta = 0;
                        $MaxTimeMrktGet = 0;
                        $longIterSumm = 0;
                        DbMysql::clearMysqlStat();
                    }
                }

                //Нужно для организации равномерных точек отчесчета начала работы очередной итерации
                if ($timeDelta<1) usleep(intval($minIterTime*1000000 - 1000000 * $timeDelta));
            }

            $proc->clear(); //Если если это не бесконечный циклический процесс, то перед выходом очистим данные по процессу.
            if ($logFileOk) fclose($outputFile); //Закроем файл лога

            ############################################################################################################

            echo "\n" . date("Y-m-d H:i:s") . " Stop script!\n";

            //Финальные операции
            $proc->clear('status'); //Если если это не бесконечный циклический процесс, то перед выходом очистим данные по процессу.
            
            //Запишем конфиг и логи----------------------
            MNBVf::putFinStatToLog(true);

        }

    }

}
