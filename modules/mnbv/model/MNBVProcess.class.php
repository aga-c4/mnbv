<?php
/**
 * Управление процессом
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVProcess {

    /**
     * @var type идентификатор процесса в системе
     */
    protected $pid = 0;
    
    /**
     * @var type команда запуска процесса 
     */
    protected $command = '';
    
    /**
     * @var type куда перенаправляем вывод
     */
    protected $output = '';

    
    public function __construct($command=false,$output=''){
        if (!empty($output)) $this->output = $output;
        if (!empty($command)){
            $this->command = $command;
            //$this->runCom();
        }
    }

    protected function runCom(){
        $result = self::runDaemon($this->command,$this->output);
        if ($result!==false) $this->pid = $result;
        return $result;
    }

    public function setPid($pid){
        $this->pid = $pid;
    }

    public function getPid(){
        return $this->pid;
    }

    public function setOutput($output){
        $this->output = $output;
    }

    public function getOutput(){
        return $this->output;
    }

    /**
     * Запускает текущий процесс
     * @return boolean результат операции
     */
    public function start(){
        if (!empty($this->command)) return $this->runCom();
        else return false;
    }

    /**
     * Прерывает текущий процесс
     * @return boolean
     */
    public function stop(){
        $result=false;
        if (!empty($this->pid)) $result = self::procStop($this->pid);
        return $result;
    }
    
    /**
     * Возвращает статус выполнения текущего процесса
     * @return bool
     */
    public function status(){
        $result=false;
        if (!empty($this->pid)) $result = self::procStatus($this->pid);
        return $result;
    }
    
    
    ############################################################################
    ## Статические методы работы с процессами
    ############################################################################
    
    /**
     * Запускает команду как демона и возвращает при успехе PID, если неудачно, то false
     * @param $command выполняемая команда
     * @param string $output файл в который будет вестись вывод
     * @return bool|int false - запуск не удался, либо int - идентификатор процесса, для Windows Pid = 0
     */
    public static function runDaemon($command,$output='/dev/null'){
        if (empty($output)) $output='/dev/null';
        $result = false;
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            $command = 'nohup '.$command.' > '.$output.' 2>&1 & echo $!';
            exec($command ,$op);
            $result = (int)$op[0];
            if (empty($result)) return false;
        }else{
            $command = 'start /b ' . $command.' > '.$output;
            //Поэкспериментировать с /min и /b на оболочке.
            //exec($command);
            pclose(popen($command, "r"));
            $result = 0;
        }
        return $result;
    }

    /**
     * Останавливает процесс
     * @param $pid идентификатор процесса
     * @return bool результат операции
     */
    public static function procStop($pid){
        $result = false;
        $pid = intval($pid);
        if (empty($pid)) return false;
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            exec('kill '.$pid . ' 2>&1 & echo $!',$op);
            if (isset($op[0])) $result = true;
        }
        return $result;
    }

    /**
     * Возвращает статус активности процесса по Pid. Работает только для Unix систем. Используется ps -p pid
     * @param $pid идентификатор процесса
     * @return bool статус активности
     */
    public static function procStatus($pid){
        $result = false;
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            exec('ps -p '.$pid,$op);
            if (isset($op[1]))$result = true;
        }
        return $result;
    }
    
    /**
     * Возвращает массив запущенных процессов с заданным rsid на базе ps
     * @param type $rsid - значение идентификатора rsid, указанное при запуске процесса в ОС. Если не задан, то возвращается массив со всеми запущенными роботами
     * @return array - массив со свойствами запущенных копий процессов в системе на базе ps
     */
    public static function psRunList($rsid=''){
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') return array(); //В виндовсе мы не можем сказать сколько их и будем говорить что не нашли, чтоб не мешало запуску при отладке.
    
        //Получим список запущенных процессов роботов
        $command = "ps -ax | grep start_robot  2>&1";
        $result = shell_exec( $command." 2>&1" );
        $resArr = preg_split("/\n/",$result);
        $pidsArr = array();
        foreach($resArr as $resStr){
            if (!empty($resStr) && !preg_match("/grep/",$resStr) && !preg_match("/\/bin\/bash/",$resStr)) {
                preg_match("/robot=([^\s]+)[\s]+proc=([^\s]+)/i",$resStr,$resStrArr);
                preg_match("/rsid=([^\s]+)/i",$resStr,$resStrArr2);

                //Нас интересуют только те, у которых есть сведения об идентификаторе процесса и не включаем текущее задание
                if (!empty($resStrArr[1])&&!empty($resStrArr2[1])&&(empty($rsid)||$rsid==$resStrArr2[1])) {
                    $pidsArr[strval(intval($resStr))] = array('proc'=>$resStrArr[2],'pid'=>intval($resStr), 'sid'=>$resStrArr2[1], 'scriptName'=>$resStrArr[1],'prstr'=>$resStr);
                }
            }
        }

        return $pidsArr;
                
    }
    
}
