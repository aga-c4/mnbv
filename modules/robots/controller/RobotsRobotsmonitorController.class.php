<?php
/**
 * RobotsController class - ����� ������ ��� ����� �������� ���������� �� �������� ������� �� ���� ps -ax | grep=start_robot
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class RobotsRobotsmonitorController extends AbstractMnbvsiteController{

    /**
     * @var string - ��� ������
     */
    public $thisModuleName = '';

    public function __construct($thisModuleName) {
        $this->thisModuleName = $thisModuleName;
    }

    /**
     * ����� ��-���������
     * @param string $tpl_mode - ������ ������
     * @param bool $console - ���� true, �� ����� � �������
     */
    public function action_index($item=array(),$tpl_mode='html', $console=false){

        #################################################################
        # ��������� ������
        #################################################################
        ini_set('max_execution_time', 0); //������������ ����� ���������� �������, ��������� � 0, ���� ������ �����������. ������������� � �����������, �.�. ����� ���� ������ � ������������� ������������ �� �������
        $usleepTime = 1; //1 ������� - ����������� ����� ��� ���������� ��������� ������� ����������.
        SysLogs::$logsEnable = false; //����������� ���
        SysLogs::$errorsEnable = false; //����������� ��� ������
        SysLogs::$logRTView = true; //�������� ��������� ��������������� ��� �� ������������. ���� �� ����������� SysLogs::$logView, �� ��������� ������ ������
        SysLogs::$logView = false; //���������� ��� ������� ������� (��������� ��� ������ � �������). ���� �� ������, �� ��������� ������� � ��� �� ����� ���������� ���� ��� ������������� SysLogs::$logRTView
        $outputFilename = 'data/storage_files/zbrobotsrun/att/p[obj_id]_1.txt';
        #################################################################

        usleep(1000000 * $usleepTime); //���� $usleepTime ������. ���� ��� �� ����� ����������
        $procId = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'proc',''),'int');
        $rsid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'rsid',''),'strictstr');

        require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVProcess.class.php';  //����� ������ �� ���������
        require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVRobot.class.php';  //����� ������ �� ���������
        $proc = new MNBVRobot('zbrobotsrun',$procId);
        $procProp = $proc->getObj();
        $proc->setPsid($rsid);
        $procProp['sid'] = $rsid;

        if ($procProp!==null && (empty($procProp['sid']) || $procProp['sid']==$rsid)) {//���������� ������ ������ ���� ������ ������� �� ����� sid, �.�. �� ��������.

            //������� ������, ��������� ������������, ����, ��� ��� ���������� ������� �� ����������.
            Glob::$vars['session'] = new MNBVSession(true,'','Nosave'); //������������� ������
            Glob::$vars['session']->set('userid',$procProp['edituser']); //������ ����������� �� �������������� ������������ ���������� ���������
            Glob::$vars['user'] = new MNBVUser(Glob::$vars['session']->get('userid'));

            //��������� ����� � ������������� �������
            if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['lang'].'.php'); //������������� �������� ������� � ������ ������������
            MNBVf::requireFile(MNBVf::getRealFileName($this->thisModuleName, 'lang/LangDict_'.Glob::$vars['lang'].'.php')); //������� ������

            $outputFilename = str_replace('[obj_id]',$procId,$outputFilename);

            while (true){ //����������� ���� ����� ������

                $outputStr = '';
                $outputStr .= "----=[Robots Monitor]=----\n";
                $outputStr .= "RSid=[$rsid]\n";
                $outputStr .= "Pid=[".$proc->getPid()."]\n";
                $outputStr .= date("Y-m-d G:i:s") . " Active robots:\n\n";

                $timeStart = microtime(true);

                $procProp = $proc->getObjById($procId);

                //���� ���������� ���� ������ � �� �� ����� ��������
                if ($procProp===null){
                    $timeDelta = microtime(true) - $timeStart;
                    if ($timeDelta<1) usleep(intval(1000000 - 1000000 * $timeDelta));
                    continue;
                }

                //�������� �� ������ ����������, ���� ����, �� ����������� (������� ������ �������������� ���������)
                if ($procProp['status']=='stopped' || $procProp['status']=='killed') {
                    echo "Script stopped\n";
                    break;
                }

                //��������� ������� ������ ������� ������
                if (!$proc->validate($procProp)){
                    $proc->stopError('Validate Error!');
                    echo "Validate Error!\n";
                    break;
                }

                //�������� �� �����, ���� ����, �� ��������� � ������� ������� ��� � ��������� ��������
                if ($procProp['status']!='paused'){

                    //��, ��� ������ �����

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


                    //������� � ����
                    $outputFile = fopen($outputFilename,"w");
                    if ($outputFile !== false){
                        fwrite($outputFile,$outputStr);
                    }
                    fclose($outputFile);

                }//����� �������� �� �����
                //������� ���������� ����� � ������������� �� ������ ���� �������� � �������� ��� �����.
                $timeDelta = microtime(true) - $timeStart;
                if ($timeDelta<1) usleep(intval(1000000 - 1000000 * $timeDelta));

            }

            //������� ������ � ����----------------------
            $script_datetime_stop = date("Y-m-d G:i:s");
            $script_time_stop = SysBF::getmicrotime();
            $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
            SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
            SysLogs::addLog("Endtime: $script_datetime_stop");
            SysLogs::addLog("Runtime: $time_script");

            //������� � ���� ������ ����������
            $outputStr = '';
            $outputStr .= "----=[Robots Monitor]=----\n";
            $outputStr .= "RSid=[$rsid]\n";
            $outputStr .= "Pid=[".$proc->getPid()."]\n";
            $outputStr .= date("Y-m-d G:i:s") . " Stop script:\n\n";

            $outputStr .= 'Starttime: ' . Glob::$vars['datetime_start'] . "\n";
            $outputStr .= "Endtime: $script_datetime_stop" . "\n";
            $outputStr .= "Runtime: $time_script" . "\n";
            //$outputStr .= "------Log-------\n";
            //$outputStr .= SysLogs::getLog() . "\n";
            //$outputStr .= MNBVf::putDBStatToLog() . "\n";

            $outputFile = fopen($outputFilename,"w");
            if ($outputFile !== false){
                fwrite($outputFile,$outputStr);
            }
            fclose($outputFile);

            $proc->clear(); //���� ���� ��� �� ����������� ����������� �������, �� ����� ������� ������� ������ �� ��������.

        }

    }

}
