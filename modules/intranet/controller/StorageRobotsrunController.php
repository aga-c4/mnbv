<?php
/**
 * StorageRobotsrunController.php специализированный контроллер для обработки объектов хранилища robotsrun при редактировании.
 * Он может менять как форматы отображения панели, так и проводить дополнительные корректировки перед редактированием и сохранением данных.
 * Created by PhpStorm.
 * User: User
 * Date: 28.09.17
 * Time: 13:19
 */

$currStorageAlias = $this->getStorage();

$proc = new MNBVRobot($item['obj']["id"]);

//Произведем действия по команде для процесса
$act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');
$ob_command = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ob_command',''),'strictstr');
if ($act=='update' && !empty($ob_command)){//Изменения только для режима редактирования
    switch($ob_command){
        case 'run':
            $proc->start();
            if (empty($item['form_folder'])||$item['form_folder']=='main') MNBVf::redirect('folder_status/'); //При создании объекта перебросим в тот же список
            break;

        case 'pause':
            $proc->pauseOn();
            break;

        case 'continue':
            $proc->pauseOff();
            break;

        case 'stop':
            $proc->stop();
            break;

        case 'kill':
            $proc->kill();
            break;
    }
    unset ($ob_command);
    Glob::$vars['request']['ob_command'] = ''; //Скинем команду
}

//Подсветим текущий статус процесса цветом
$procObj = $proc->getObjById();
if ($procObj['status']=='working') SysStorage::$storage[$currStorageAlias]['view']['main']['status']['style'] = "color:green;font-weight:bold";
elseif ($procObj['status']=='paused') SysStorage::$storage[$currStorageAlias]['view']['main']['status']['style'] = "color:#ff6600;font-weight:bold";
elseif ($procObj['status']=='error'||$procObj['status']=='starterror'||$procObj['status']=='noresponse') SysStorage::$storage[$currStorageAlias]['view']['main']['status']['style'] = "color:red;font-weight:bold";

if ($procObj['status']=='working') SysStorage::$storage[$currStorageAlias]['view']['status']['status']['style'] = "color:green;font-weight:bold";
elseif ($procObj['status']=='paused') SysStorage::$storage[$currStorageAlias]['view']['status']['status']['style'] = "color:#ff6600;font-weight:bold";
elseif ($procObj['status']=='error'||$procObj['status']=='starterror'||$procObj['status']=='noresponse') SysStorage::$storage[$currStorageAlias]['view']['status']['status']['style'] = "color:red;font-weight:bold";

