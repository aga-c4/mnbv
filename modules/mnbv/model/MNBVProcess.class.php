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
        $result = SysProc::runDaemon($this->command,$this->output);
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
        if (!empty($this->pid)) $result = SysProc::procStop($this->pid);
        return $result;
    }
    
    /**
     * Возвращает статус выполнения текущего процесса
     * @return type
     */
    public function status(){
        $result=false;
        if (!empty($this->pid)) $result = SysProc::procStatus($this->pid);
        return $result;
    }
    
}
