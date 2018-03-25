<?php
/**
 * User: AGA-C4
 * Date: 26.08.14
 * Time: 14:40
 */
 
/**
 * Sdata Controller class - контроллер вывода закрытой статики
 */
class SdataController{

    /**
     * @var string - Имя модуля контроллера (Внимание, оно должно соответствовать свойству $thisModuleName фронт контроллера модуля (используется во View)
     */
    public $thisModuleName = '';

    /**
     * @var string идентификатор текущего используемого хранилища
     */
    private $storage = '';
    
    public function __construct($thisModuleName) {
        $this->thisModuleName = $thisModuleName;
    }

    /**
     * Метод по-умолчанию
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($tpl_mode='html', $console=false){
        $this->action_dnload($tpl_mode, $console);//Покажем хелп
    }

    /**
     * Установка текущего хранилища для контроллера
     * @param $storage - алиас хранилища
     */
    public function setStorage($storage){
        $this->storage = $storage;
    }

    /**
     * Получение текущего хранилища для контроллера
     * @param $storage - алиас хранилища
     */
    public function getStorage(){
        return $this->storage;
    }

    /**
     * Вывод страницы помощи
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_dnload($tpl_mode='html', $console=false){
        //if (Glob::$vars['user']->get('userid')==0) MNBVf::redirect('/intranet/auth/'); //Если неавторизованный пользователь, перебросим на авторизацию !!!!!!!!!!!!!!!!!!!!!!!!!!!
        
        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = 'Sdata'; //Метатеги
        SysLogs::addLog("Page_title: ". Glob::$vars['page_title']);
        
        $item = array(); //Массив данных, передаваемых во View
        $item['page_h1'] = Glob::$vars['page_h1'];

        if (Glob::$vars['mnbv_fileinfo']['status']){ //Если есть с чем работать, то продолжим

            //Откроем объект, проверим доступы, проверим наличие файла в слоте и точное его расположение и имя
            $this->setStorage(Glob::$vars['mnbv_usestorage']);
            $item["id"] = Glob::$vars['mnbv_useobj'];
            $item['usestorage'] = $this->getStorage();

            $storageRes = MNBVStorage::getObjAcc($this->getStorage(),
                array("access","access2","files"),
                array("id",'=',$item["id"]));
            $item['obj'] = ($storageRes[0]>0)?$storageRes[1]:null;

            if (!empty($storageRes[0])){//Объект для редактирования найден

                $item['obj']['files'] = (!empty($item['obj']['files']))?SysBF::json_decode($item['obj']['files']):array();

                //Проверим чтоб тип в слоте вообще есть привязанный файл
                if (empty($item['obj']['files'][Glob::$vars['mnbv_fileinfo']['slot_type']][strval(Glob::$vars['mnbv_fileinfo']['slot_id'])]['fname'])){
                    SysLogs::addError("Error: No file in slot: ".Glob::$vars['mnbv_fileinfo']['slot_type']."[".Glob::$vars['mnbv_fileinfo']['slot_id']."]!");
                    Glob::$vars['mnbv_fileinfo']['status'] = false;
                }

                //Проверим чтоб тип в слоте совпадал с типом файла, который запрашиваем
                if (Glob::$vars['mnbv_fileinfo']['file_type']!==$item['obj']['files'][Glob::$vars['mnbv_fileinfo']['slot_type']][strval(Glob::$vars['mnbv_fileinfo']['slot_id'])]['type']){
                    SysLogs::addError("Error: File file type: ".Glob::$vars['mnbv_fileinfo']['file_type']."!");
                    Glob::$vars['mnbv_fileinfo']['status'] = false;
                }

                //Истинное имя файла
                $filename = MNBVStorage::getRealFileName($item['usestorage'],$item["id"],Glob::$vars['mnbv_fileinfo']['slot_type'],Glob::$vars['mnbv_fileinfo']['slot_id'],Glob::$vars['mnbv_fileinfo']['file_type']);

                //Откроем файл, откуда будем выгружать-----
                if (Glob::$vars['mnbv_fileinfo']['status']){
                    if (!file_exists($filename)){//Если файл не существует, то
                        SysLogs::addError("Error: File not found: ".$filename."!");
                        Glob::$vars['mnbv_fileinfo']['status'] = false;
                    }else{
                        if (!empty(Glob::$vars['request']['rows'])){
                            $cropType = (!empty(Glob::$vars['request']['croptype']) && Glob::$vars['request']['croptype']=='top')?'top':'bottom';
                            $fp =  MNBVf::file_get_contents($filename,array('pre'=>true,'upd_tags'=>false,'crop_type'=>$cropType,'num_line'=>intval(Glob::$vars['request']['rows'])));
                        }else{
                            $fp = file_get_contents($filename);
                        }

                        if ($fp == false) {
                            Glob::$vars['mnbv_fileinfo']['status'] = false;
                            SysLogs::addError("Error: File not read: ".$filename."!");
                        }
                    }
                }

            } else {
                Glob::$vars['mnbv_fileinfo']['status'] = false;
                SysLogs::addError("Error: Object not found or access denied!");
            }

        }

        //Выдадим ответ пользователю----------------
        if (Glob::$vars['mnbv_fileinfo']['status']==false) { //Если ошибка, то сюда
            SysLogs::addError('Error: download from [' . Glob::$vars['mnbv_module'] . ']');
            MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], '404.php'),$item,$tpl_mode);
        }else{
            //Отправим файл
            $contentType = MNBVf::mime_content_type(Glob::$vars['mnbv_fileinfo']["fname"]);
            $outputFileName = Glob::$vars['mnbv_fileinfo']["fname"];

            if(true || Glob::$vars['mnbv_fileinfo']['slot_type'] == 'img'){//Этим в браузер (slot_type=img)
                header("Content-Type: $contentType");
                header("Content-Disposition: inline; filename=".$outputFileName);
            }else{//Остальным - файл для скачивания
                header("Content-Type: application/force-download");
                header("Content-Disposition: attachment; filename=".$outputFileName);
            }
            echo $fp;
        }

        //View------------------------
        //MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog(true);

    }
	
}

