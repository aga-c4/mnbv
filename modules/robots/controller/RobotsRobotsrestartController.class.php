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
        $outputFilename = 'data/storage_files/'.Glob::$vars['robotsRunStorage'].'/att/p[obj_id]_2.txt';
        #################################################################

        usleep(1000000 * $usleepTime); //Спим $usleepTime секунд. чтоб все по базам записалось
        $procId = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'proc',''),'int');
        $rsid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'rsid',md5(time().rand())),'strictstr');

        echo "Start MNBV robot " . $this->thisModuleName . "! \n";
        echo "RSid=[$rsid]\n";
        
        require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVProcess.class.php';  //Класс работы со словарями
        require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVRobot.class.php';  //Класс работы со словарями
        $proc = new MNBVRobot($procId);
        $procProp = $proc->getObj();
        $outputLogStr = '';

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
                $procProp['files']['att']['2'] = array('type'=>'txt','fname'=>'log.txt');
                $procPropFilesUpd = json_encode($procProp['files']);
                $res = MNBVStorage::setObj(Glob::$vars['robotsRunStorage'], array('files'=>$procPropFilesUpd), array("id",'=',$procProp["id"]));

                //Получим список запущенных процессов роботов
                $command = "ps -ax | grep start_robot  2>&1";
                //exec($command . " 2>&1", $output);
                //if (!empty($output) && is_array($output)) $outputStr .= explode("\n",$output);

                $result = shell_exec( $command." 2>&1" );
                $resArr = preg_split("/\n/",$result);

                $pidsArr = array();
                echo "Found processes:\n";
                foreach($resArr as $resStr){
                    if (!empty($resStr) && !preg_match("/grep/",$resStr) && !preg_match("/\/bin\/bash/",$resStr)) {
                        preg_match("/robot=([^\s]+)[\s]+proc=([^\s]+)/i",$resStr,$resStrArr);
                        preg_match("/rsid=([^\s]+)/i",$resStr,$resStrArr2);

                        //Нас интересуют только те, у которых есть сведения об идентификаторе процесса и не включаем текущее задание
                        if (!empty($resStrArr[1])&&!empty($resStrArr2[1])) {
                            echo "[".$resStrArr[2]."]" . $resStrArr[1] . "[" . intval($resStr) . "][" . $resStrArr2[1] . "]\n";
                            $pidsArr[strval(intval($resStr))] = array('proc'=>$resStrArr[2],'pid'=>intval($resStr), 'sid'=>$resStrArr2[1], 'scriptName'=>$resStrArr[1]);
                        }
                    }
                }

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
