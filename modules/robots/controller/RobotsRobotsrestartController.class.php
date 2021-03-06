<?php
/**
 * RobotsController class - класс робота для сбора основной статистики по активным роботам на базе ps -ax | grep=start_robot
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class RobotsRobotsrestartController extends AbstractMnbvsiteController{

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
        $logFilename1 = APP_STORAGEFILESPATH.Glob::$vars['robotsRunStorage'].'/att/p[obj_id]_1.txt';
        $logFilename2 = APP_STORAGEFILESPATH.Glob::$vars['robotsRunStorage'].'/att/p[obj_id]_2.txt';
        $outputFilename = APP_STORAGEFILESPATH.Glob::$vars['robotsRunStorage'].'/att/p[obj_id]_3.txt';
        #################################################################

        usleep(1000000 * $usleepTime); //Спим $usleepTime секунд. чтоб все по базам записалось
        $procId = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'proc',''),'int');
        $rsid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'rsid',md5(time().rand())),'strictstr');

        echo "Start MNBV robot " . $this->thisModuleName . "! \n";
        echo "RSid=[$rsid]\n";
        
        $proc = new MNBVRobot($procId);
        $procProp = $proc->getObj();
        $outputLogStr = '';
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $procProp=NULL;
            echo "It is Windows - we can`t use ps!\n";
        }

        if ($procProp!==null){//Стартовая валидация

            if (empty($procProp['sid']) || $procProp['sid']!=$rsid){//Если sid не задан в БД, то запишем его туда
                //if (!empty($procProp['sid']) && $procProp['sid']!=$rsid) $outputLogStr = "Robot is already running, restart!\n";
                $proc->setPsid($rsid);
                $updateArr = array();
                $updateArr['sid'] = $procProp['sid'] = $rsid;
                $updateArr['status'] = $procProp['status'] = 'working';
                $updateArr['message'] = $procProp['message'] = 'From ' . date("Y-m-d H:i:s");
                MNBVStorage::setObj($proc->getStorage(), $updateArr, array("id",'=',$procId));
            }

            $timeStart = microtime(true);
            $timeStartSec = intval($timeStart);

            $proc->setPsid($rsid);
            $procProp['sid'] = $rsid;

            //Откроем сессию, подключим пользователя, того, кто был редактором задания на выполнение.
            Glob::$vars['session'] = new MNBVSession(true,'','Nosave'); //Инициализация сессии
            Glob::$vars['session']->set('userid',$procProp['edituser']); //Скрипт запускается от идентификатора пользователя последнего редактора
            Glob::$vars['user'] = new MNBVUser(Glob::$vars['session']->get('userid'));

            echo "Pid=[".$proc->getPid()."]\n";
            echo "UserId=[".Glob::$vars['session']->get('userid')."]\n";
            echo "Script=[".$procProp['vars']['script']."]\n";
            echo "Output=[".$procProp['vars']['output']."]\n";

            $scriptvarsArr = array();
            if (!empty($procProp['vars']['scriptvars'])) {
                echo "scriptvars=[".$procProp['vars']['scriptvars']."]\n";
                $scriptvarsArr = json_decode($procProp['vars']['scriptvars'],true);
            }

            echo date("Y-m-d G:i:s") . " Run script!\n";

            //То, что делает робот
            #########################################[ То, что делает робот ]###########################################

            $restartScripts = $restartScriptsErr = 0;

            //Открое файл с логом для записи туда результата работы
            //Запишем в файл
            $outputFilename = str_replace('[obj_id]',$procId,$outputFilename); //Имя файла лога действий этого скрипта.
            $outputFile = fopen($outputFilename,"a");
            if ($outputFile === false){
                SysLogs::addError("Error open Log file [$outputFilename]!");
            }else{

                //Зарегистрируем приложенные файлы, куда будем выгружать данные
                if (!isset($procProp['files']['att'])) $procProp['files']['att'] = array();
                $procProp['files']['att']['3'] = array('type'=>'txt','fname'=>'log.txt');
                $procPropFilesUpd = json_encode($procProp['files']);
                $res = MNBVStorage::setObj(Glob::$vars['robotsRunStorage'], array('files'=>$procPropFilesUpd), array("id",'=',$procProp["id"]));

                //Получим список запущенных процессов роботов
                $pidsArr = MNBVProcess::psRunList();
                echo "Found processes:\n";
                foreach($pidsArr as $curPidArr) echo "[" . $curPidArr['proc'] . "]" . $curPidArr['scriptName'] . "[" . $curPidArr['pid'] . "][" . $curPidArr['sid'] . "]\n";

                //Выберем запущенные процессы из базы и посмотрим какие из них померли, запустим померших заново
                $storageRes = MNBVStorage::getObj(
                    Glob::$vars['robotsRunStorage'],
                    array("id","name","sid","pid"),
                    array("visible","=","1","and","pid",">",0,"and","status","in",array("working","paused")));
                $pidsDbArr = array();
                if (!empty($storageRes[0])) {
                    unset($storageRes[0]);
                    foreach($storageRes as $value) {
                        $pidsDbArr[strval($value['pid'])] = (!empty($value['sid']))?$value['sid']:'';

                        //Если запущен процесс а по его pid не находим в системе процесса, то запускаем этот процесс заново и освежаем его свойства
                        if (!isset($pidsArr[strval($value['pid'])]) && $procId!=$value["id"]){

                            if ($outputLogStr=='') $outputLogStr = "\n";
                            $rproc = new MNBVRobot($value["id"]);
                            $rprocProp = $rproc->getObj();

                            //Сохраним старый лог в 2й файл, чтоб если что смогли бы понять почему процесс встал
                            $logFilename1 = str_replace('[obj_id]',$value["id"],$logFilename1);
                            $logFilename2 = str_replace('[obj_id]',$value["id"],$logFilename2);
                            if(file_exists($logFilename1)) {
                                exec("cp $logFilename1 $logFilename2");
                                SysLogs::addLog("Exec command: [cp $logFilename1 $logFilename2]");
                                //Зарегистрируем приложенные файлы, куда будем выгружать данные
                                if (!isset($rprocProp['files']['att'])) $rprocProp['files']['att'] = array();
                                $rprocProp['files']['att']['2'] = array('type'=>'txt','fname'=>'log2.txt');
                                $rprocPropFilesUpd = json_encode($rprocProp['files']);
                                MNBVStorage::setObj(Glob::$vars['robotsRunStorage'], array('files'=>$rprocPropFilesUpd), array("id",'=',$rprocProp["id"]));
                            }

                            $res=$rproc->start('restart');
                            $currStr = date("Y-m-d H:i:s") . " Restart proc[".$value["id"]."] sid=[".$rproc->getPsid()."] pid=[".$rproc->getPid()."] ".(($res)?'Ok!':'Error!')."\n";
                            $outputLogStr .= $currStr;
                            echo $currStr;
                            if ($res) $restartScripts++; else $restartScriptsErr++;

                        }
                    }
                }

                //Запись результата операции в лог.
                fwrite($outputFile,$outputLogStr);
                fclose($outputFile); //Закроем файл лога

            }

            ############################################################################################################
            
            //Финальные операции
            $proc->clear('status'); //Если если это не бесконечный циклический процесс, то перед выходом очистим данные по процессу.
            echo "Restart Scripts: $restartScripts" . "\n";
            echo "Restart Scripts Errors: $restartScriptsErr" . "\n";
        
        }
        
        echo date("Y-m-d G:i:s") . " Stop script!\n";

        //Запишем конфиг и логи----------------------
        MNBVf::putFinStatToLog();

    }

}
