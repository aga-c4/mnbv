<?php
/**
 * StorageZbrobotsrunController.php специализированный контроллер для обработки объектов хранилища zbrobotsrun при редактировании.
 * Он может менять как форматы отображения панели, так и проводить дополнительные корректировки перед редактированием и сохранением данных.
 * Created by PhpStorm.
 * User: User
 * Date: 28.09.17
 * Time: 13:19
 */

require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVProcess.class.php';  //Класс работы со словарями

//Произведем действия в случае смены статуса
$act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');
$ob_status = SysBF::getFrArr($item['obj'],'status','');
$ob_pid= SysBF::getFrArr($item['obj'],'pid',0);
$ob_sid= SysBF::getFrArr($item['obj'],'sid','');
$ob_command = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ob_command',''),'strictstr');

if ($act=='update' && !empty($ob_command)){//Изменения только для режима редактирования

    if ($ob_command == 'run' && !in_array($ob_status,array('working','paused'))) {//1. Запуск - запустим процесс
        $ob_sid = md5(time().rand());
        $command = 'php start_robot.php robot=Timer rsid='.$ob_sid;
        $output = 'data/storage_files/zbrobotsrun/att/p'.$item['obj']['id'].'_1.txt';
        if (!empty($command)){
            $startRes = MNBVProcess::runDaemon($command,$output);
            if (false !== $startRes){//Запустили успешно
                //Сгенерим sid
                Glob::$vars['request']['ob_sid'] = md5(time().rand());
                Glob::$vars['request']['ob_pid'] = $startRes;//Установим pid
                Glob::$vars['request']['ob_status'] = 'working';
                Glob::$vars['request']['ob_message'] = 'From ' . date("Y-m-d H:i:s");
            }else{//Возникли проблемы с запуском
                Glob::$vars['request']['ob_status'] = 'starterror';
                Glob::$vars['request']['ob_message'] = 'In ' . date("Y-m-d H:i:s");
            }
        }
    }elseif ($ob_command == 'pause' && $ob_status == 'working') {//2. Пауза - status='paused'
        Glob::$vars['request']['ob_status'] = 'paused';
        Glob::$vars['request']['ob_message'] = 'In ' . date("Y-m-d H:i:s");
    }elseif ($ob_command == 'continue' && $ob_status == 'paused') {//3. Продолжение выполнения status='paused'
        Glob::$vars['request']['ob_status'] = 'working';
        Glob::$vars['request']['ob_message'] = 'Continue from ' . date("Y-m-d H:i:s");
    }elseif ($ob_command == 'stop') {//4. Сигнал остановки
        Glob::$vars['request']['ob_status'] = 'stopped';
        Glob::$vars['request']['ob_message'] = 'In ' . date("Y-m-d H:i:s");
    }elseif ($ob_command == 'kill') {//5. Принудительное завершение возможно только при наличии pid
        if (!empty($ob_pid)){
            $stopRes = MNBVProcess::stop($ob_pid);
            if (false !== $stopRes){//Остановили успешно
                Glob::$vars['request']['ob_status'] = 'killed';
                Glob::$vars['request']['ob_message'] = 'In ' . date("Y-m-d H:i:s");
            }
        }
    }
    unset ($ob_command);
    if (!empty(Glob::$vars['request']['ob_status'])) $ob_status = Glob::$vars['request']['ob_status'];
    Glob::$vars['request']['ob_command'] = ''; //Скинем команду

}

//Подсветим текущий статус процесса цветом
if ($ob_status=='working') SysStorage::$storage['zbrobotsrun']['view']['main']['status']['style'] = "color:green;font-weight:bold";
elseif ($ob_status=='paused') SysStorage::$storage['zbrobotsrun']['view']['main']['status']['style'] = "color:cyan;font-weight:bold";
elseif ($ob_status=='error'||$ob_status=='starterror'||$ob_status=='noresponse') SysStorage::$storage['zbrobotsrun']['view']['main']['status']['style'] = "color:red;font-weight:bold";
