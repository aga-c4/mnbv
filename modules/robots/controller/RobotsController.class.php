<?php
/**
 * RobotsController class - дефолтовый контроллер
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class RobotsController extends AbstractMnbvsiteController{

    /**
     * @var string - Имя модуля контроллера (Внимание, оно должно соответствовать свойству $thisModuleName фронт контроллера модуля (используется во View)
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
        $this->action_hello($item,$tpl_mode, $console);//Покажем хелп
    }

    /**
     * Вывод страницы помощи
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_hello($item=array(),$tpl_mode='txt', $console=true){

        echo  '
MNBV robot start!
-------
Run help:
For Windows:
$ php start_robot.php session=RunId > data/storage_files/zbrobotsrun/att/p[RunId]_1.txt

For Unix:
$ nohup php start_robot.php session=RunId > data/storage_files/zbrobotsrun/att/p[RunId]_1.txt &

Output print to data/storage_files/zbrobotsrun/att/p[RunId]_1.txt

add debug=on to view logs
-------
';

        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

    }

}
