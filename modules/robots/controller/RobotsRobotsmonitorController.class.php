<?php
/**
 * RobotsController class - класс робота для сбора основной статистики по активным роботам на базе ps -ax | grep=start_robot
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class RobotsRobotsmonitorController extends AbstractMnbvsiteController{

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
        $outputFilename = APP_STORAGEFILESPATH.Glob::$vars['robotsRunStorage'].'/att/p[obj_id]_1.txt';
        $outputFilename3 = APP_STORAGEFILESPATH.Glob::$vars['robotsRunStorage'].'/att/p[obj_id]_3.txt';
        #################################################################

        usleep(1000000 * $usleepTime); //Спим $usleepTime секунд. чтоб все по базам записалось
        $procId = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'proc',''),'int');
        $rsid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'rsid',''),'strictstr');

        $proc = new MNBVRobot($procId);
        $procProp = $proc->getObj();
        $proc->setPsid($rsid);
        $procProp['sid'] = $rsid;
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $procProp=NULL;
            echo "It is Windows - we can`t use ps!\n";
        }

        if ($procProp!==null && (empty($procProp['sid']) || $procProp['sid']==$rsid)) {//Продолжаем работу только если данное задание не имеет sid, т.е. не запущено.

            //Откроем сессию, подключим пользователя, того, кто был редактором задания на выполнение.
            Glob::$vars['session'] = new MNBVSession(true,'','Nosave'); //Инициализация сессии
            Glob::$vars['session']->set('userid',$procProp['edituser']); //Скрипт запускается от идентификатора пользователя последнего редактора
            Glob::$vars['user'] = new MNBVUser(Glob::$vars['session']->get('userid'));
            
            //Зарегистрируем приложенные файлы, куда будем выгружать данные
            if (!isset($procProp['files']['att'])) $procProp['files']['att'] = array();
            $procProp['files']['att']['3'] = array('type'=>'txt','fname'=>'log.txt');
            $procPropFilesUpd = json_encode($procProp['files']);
            MNBVStorage::setObj(Glob::$vars['robotsRunStorage'], array('files'=>$procPropFilesUpd), array("id",'=',$procProp["id"]));

            //Установки языка и инициализация словаря
            if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['lang'].'.php'); //Переподключим основной словарь с языком пользователя
            MNBVf::requireFile(MNBVf::getRealFileName($this->thisModuleName, 'lang/LangDict_'.Glob::$vars['lang'].'.php')); //Словарь модуля

            $outputFilename = str_replace('[obj_id]',$procId,$outputFilename);
            $outputFilename3 = str_replace('[obj_id]',$procId,$outputFilename3);

            while (true){ //Бесконечный цикл жизни робота

                $outputStr = '';
                $outputStr .= "----=[Robots Monitor]=----\n";
                $outputStr .= "RSid=[$rsid]\n";
                $outputStr .= "Pid=[".$proc->getPid()."]\n";
                $outputStr .= date("Y-m-d G:i:s") . " Active robots:\n\n";

                $timeStart = microtime(true);

                $procProp = $proc->getObjById($procId);
                $procProp['action'] = (!empty($procProp['action']))?SysBF::json_decode($procProp['action']):array();

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
                    #########################################[ То, что делает робот ]###########################################
                    
                    //Обработка внешних комманд-----------------------------------
                    $commandNameArr = array(
                        "stop_all" => "All process stop",
                        "mass_start" => "Mass start",
                    );

                    if (!empty($procProp['action']['command'])) {
                        $commandName = (!empty($commandNameArr[$procProp['action']['command']]))?trim(strtolower($commandNameArr[$procProp['action']['command']])):'Bad command';
                        SysBF::saveFile($outputFilename3,"\n" . date("Y-m-d H:i:s") . " Get command: " . $commandNameArr[$commandName] . "\n",'a');
                        if ($commandName != 'Bad command') {

                            if ($commandName=='stop_all'){

                                //Получим массив всех запущенных процессов роботов и остановим их
                                $pidsArr = MNBVProcess::psRunList();
                                SysBF::saveFile($outputFilename3,date("Y-m-d H:i:s") . "Found processes:\n",'a');
                                foreach($pidsArr as $curPidArr) {
                                    if ($curPidArr['proc']==$procId) continue; //Себя не трогаем
                                    //MNBVProcess::procStop($curPidArr['pid']);
                                    $currPrStr =  "[" . $curPidArr['proc'] . "]" . $curPidArr['scriptName'] . "[" . $curPidArr['pid'] . "][" . $curPidArr['sid'] . "] ";
                                    SysBF::saveFile($outputFilename3,"$currPrStr Stopped!\n",'a');
                                }

                            }elseif($commandName=='mass_start'){



                            }
                            
                        }
                    }
                    MNBVStorage::setObj(Glob::$vars['robotsRunStorage'], array('action'=>''), array("id",'=',$procProp["id"]));
                    //-------------------------
                        
                        

                    $command = "ps -ax | grep start_robot  2>&1";
                    //exec($command . " 2>&1", $output);
                    //if (!empty($output) && is_array($output)) $outputStr .= explode("\n",$output);
                    $result = shell_exec( $command." 2>&1" );
                    $resArr = preg_split("/\n/",$result);

                    foreach($resArr as $resStr){
                        if (!empty($resStr) && !preg_match("/grep/",$resStr) && !preg_match("/\/bin\/bash/",$resStr)) {
                            preg_match("/robot=([^\s]+)[\s]+proc=([^\s]+)/i",$resStr,$resStrArr);
                            preg_match("/rsid=([^\s]+)/i",$resStr,$resStrArr2);

                            if (!empty($resStrArr[1])) $outputStr .= '['.intval($resStr).']['.$resStrArr[2].'] '.$resStrArr[1]. ((!empty($resStrArr2[1]))?(' sid=['.$resStrArr2[1]."]"):'')."\n" ;
                            else $outputStr .= $resStr ."\n";
                            //$outputStr .= implode(",", $resStrArr) ."\n";
                        }
                    }

                    $outputStr .= "\n";


                    //Запишем в файл
                    SysBF::saveFile($outputFilename,$outputStr,'w');
                    
                    #########################################[ То, что делает робот ]###########################################

                }//конец проверки на паузу
                //Считаем оставшееся время в микросекундах до начала след итерации и отдыхаем это время.
                $timeDelta = microtime(true) - $timeStart;
                if ($timeDelta<1) usleep(intval(1000000 - 1000000 * $timeDelta));

            }

            //Запишем конфиг и логи, если этого не произошлов в конце шаблона
            if (!SysLogs::$logComplete) MNBVf::putFinStatToLog(true);
        
            //Выведем на экран ----------------------
            $script_datetime_stop = date("Y-m-d G:i:s");
            $script_time_stop = SysBF::getmicrotime();
            $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));

            //Запишем в файл статус завершения
            $outputStr = '';
            $outputStr .= "----=[Robots Monitor]=----\n";
            $outputStr .= "RSid=[$rsid]\n";
            $outputStr .= "Pid=[".$proc->getPid()."]\n";
            $outputStr .= date("Y-m-d G:i:s") . " Stop script:\n\n";

            $outputStr .= 'Starttime: ' . Glob::$vars['datetime_start'] . "\n";
            $outputStr .= "Endtime: $script_datetime_stop" . "\n";
            $outputStr .= "Runtime: $time_script" . "\n";
            
            //Запишем конфиг и логи----------------------
            //MNBVf::putFinStatToLog(true);

            $outputFile = fopen($outputFilename,"w");
            if ($outputFile !== false){
                fwrite($outputFile,$outputStr);
            }
            fclose($outputFile);

            $proc->clear(); //Если если это не бесконечный циклический процесс, то перед выходом очистим данные по процессу.

        }

    }

}
