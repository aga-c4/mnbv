<?php
/**
 * Upload Controller class - контроллер загрузки файлов
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class UploadController{

    /**
     * @var string Имя модуля контроллера в нижнем регистре(Внимание, оно должно соответствовать свойству $thisModuleName фронт контроллера модуля (используется во View)
     */
    public $thisModuleName = '';

    /**
     * @var string наименование контроллера - требуется в ряде случаев при формировании URL и т.п.
     */
    public $controllerName = 'upload';

    /**
     * @var string папка словаря интерфейса
     */
    public $tplFolder = 'upload';

    /**
     * @var string идентификатор текущего используемого хранилища
     */
    private $storage = '';

    /**
     * Конструктор класса BaseobjController
     * @param string название (алиас) текущего модуля
     */
    public function __construct($thisModuleName) {
        $this->thisModuleName = strtolower($thisModuleName);
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
     * Метод по-умолчанию
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($tpl_mode='html', $console=false){
        $this->action_upload($tpl_mode, $console);//Покажем хелп
    }

    /**
     * Работа с приложенными файлами (загрузка/удаление)
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_upload($tpl_mode='html', $console=false){
        //if (Glob::$vars['user']->get('userid')==0) MNBVf::redirect('/intranet/auth/'); //Если неавторизованный пользователь, перебросим на авторизацию !!!!!!!!!!!!!!!!!!!!!!!!!!!

        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("MNBV API","module_names"); //Метатеги
        SysLogs::addLog("Page_title: ". Glob::$vars['page_title']);

        $thisTime = time();

        $this->setStorage(Glob::$vars['mnbv_usestorage']);

        $PgHtml = '';//'<a href="/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . Glob::$vars['mnbv_useobj'] . '/view/">Object view</a>';
        $item = array(); //Массив данных, передаваемых во View
        $item['usestorage'] = $this->getStorage();
        $item["id"] = Glob::$vars['mnbv_useobj'];
        $item["slot_type"] = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'slot_type',''),'strictstr');
        $item["slot_id"] = intval(SysBF::getFrArr(Glob::$vars['request'],'slot_id',0));
        
        $item["main_form_name"] = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'mainformname',''),'minstr'); //Если задана, то при необходимости может сабмититься но только в случае если задана форма загрузки
        $item["upl_form_name"] = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'uplformname',''),'minstr'); //Выдача HTML будет только если задана форма работы с загрузками

        $PgHtml = '';
        
        //Сведения по текущему объекту -----------------------------------------------------
        $storageRes = MNBVStorage::getObjAcc($this->getStorage(),
            array("access","access2","files"),
            array("id",'=',$item["id"]));
        $item['obj'] = ($storageRes[0]>0)?$storageRes[1]:null;

        if (!empty($storageRes[0]) && (Glob::$vars['user']->get('root') || in_array($item['obj']["access2"],Glob::$vars['user']->get('permarr')))){//Объект для редактирования найден

            /*
             * Массив приложенных файлов
             * Структура:
             * "img" => array("1"=>array("type"=>"", "fname"=>"", "src"=>"", "name"=>"", "text"=>"", "about"=>"", "url"=>"", "link"=>"","edituser"=>"","editdate"=>"","upldate"=>"","editip"=>"","size"=>array('kb'=>10,'w'=>250,'h'=>188,'min'=>array(...),'big'=>array(...))),...),
             * "att" => array("1"=>array("type"=>"", "fname"=>"", "src"=>"", "name"=>"",             "url"=>"", "link"=>"","edituser"=>"","editdate"=>"","upldate"=>"","editip"=>"","size"=>array('kb'=>10)),...),
             * Если каких то полей нет, то их дефолтовое значение "". Минимальный набор для слота array("type"=>"")),
             * Количество приложенных файлов ограничено 100 слотами на изображения и столько же на остальное.
             */
            $filesArr = $item['obj']['files'] = (!empty($item['obj']['files']))?SysBF::json_decode($item['obj']['files']):array();

            //Возможные действия -------------------------------------------------------------------------------------------
            $PgHtml = '<script type="text/javascript">';
            $filesArrUpd = false;
            $updateArr = array(); //Массив вносимых в объект изменений
            $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');
            switch ($act){

                case 'upload': ;//Закачки разного рода
                case 'frimgeditor': //Закачка из редактора

                    //Подключим библиотеку обработки изображений
                    require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVImg.class.php';

                    //Проверяем входные данные
                    if(($item["slot_type"]!='img'&&$item["slot_type"]!='att') || $item["slot_id"]===null) break;
                    $folderName = 'uf'.$item["slot_type"].$item["slot_id"]; //Название поле закачки файла
                    $folderDelName = 'f'.$item["slot_type"].'del'.$item["slot_id"]; //Название поле удаления файла
                    if ($act!='frimgeditor' && empty($_FILES["$folderName"]['name'])) break; //Нет файла - остановка

                    if ($act=='frimgeditor'){
                        $filename_in = Glob::$vars['session']->get('img_editor_file');
                        if (!empty($filename_in)){
                            $tmpname_in = APP_DUMPPATH . 'imgeditor/' .Glob::$vars['session']->get('img_editor_file');
                        }else $tmpname_in = '';
                    }else{
                        $filename_in = $_FILES["$folderName"]['name'];
                        $tmpname_in = $_FILES["$folderName"]['tmp_name'];
                    }

                    $filetype = MNBVf::getFileType($filename_in);
                    if ($filetype===null) break;
                    $slot_type = $item["slot_type"];
                    $slot_id = strval($item["slot_id"]); //ВНИМАНИЕ!!! важно чтоб это была строка!!! иначе индексы массива могут быть не верными

                    if ($act=='frimgeditor' || empty($_FILES["$folderName"]["error"])) { // Если загрузка прошла успешно

                        if ($item["slot_type"]=='img'){//Это изображение, грузим с преобразованием
                            if (Glob::$vars['file_types']["$filetype"]["type"]!=="img" || !MNBVStorage::validateFileType($item['usestorage'],$filetype,$slot_type)) {
                                SysLogs::addError('Error: Wrong file type='.$filetype.' on slot_type='.$slot_type.'!');
                                break;
                            }
                            //Преобразуем изображение с учетом настроек и копируем в папку назначения
                            $filename = MNBVStorage::getRealFileName($item['usestorage'],$item["id"],$slot_type,$slot_id,$filetype);
                            $filenameMin = MNBVStorage::getRealFileName($item['usestorage'],$item["id"],$slot_type,$slot_id,$filetype,'min');
                            $filenameBig = MNBVStorage::getRealFileName($item['usestorage'],$item["id"],$slot_type,$slot_id,$filetype,'big');
                            if ($filename===null) break;

                            //Получим из конфига настройки преобразования и проведем преобразование
                            $imgResize = false; //Результат преобразования

                            //Профиль размера изображения
                            $maxSizeProfile = (isset(Glob::$vars['img_max_size'][$item['usestorage']]))?$item['usestorage']:$imgSizeType="default";
                            if ($imgSizeType = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'img_max_size'),'strictstr')) if (isset(Glob::$vars['img_max_size']["$imgSizeType"])) {
                                if (isset(Glob::$vars['img_max_size']["$imgSizeType"])) $maxSizeProfile = $imgSizeType;
                            }
                            
                            //Загрузим параметры конфигурации панели работы с приложенными изображениями
                            $maxSizeConf = MNBVf::getImgMaxSize($maxSizeProfile,Glob::$vars['img_max_size']);
                            
                            //Тип трансформации изображения если установлен и допустим, то применим его
                            if ($imgCropType = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'img_сrop_type',''),'strictstr')){//Варианты преобразования изображений
                                if (in_array($imgCropType,array('none','crop-top','crop-center'))) $maxSizeConf['img_update'] = $imgCropType;
                            }

                            $filesList = $filesListErr= '';
                            $imgProp = true;
                            //Создание основного изображения
                            if (!empty($maxSizeConf['img_max_w'])&&!empty($maxSizeConf['img_max_w'])&&$imgProp=MNBVImg::imageResize($filename,$tmpname_in,$filetype,$maxSizeConf['img_max_w'],$maxSizeConf['img_max_h'],$maxSizeConf['img_quality'],$maxSizeConf['img_update'])){
                                if (!isset($filesArr[$slot_type][$slot_id]["size"])) $filesArr[$slot_type][$slot_id]["size"]=array();
                                $filesArr[$slot_type][$slot_id]["size"]["kb"] = $imgProp['kb'];
                                $filesArr[$slot_type][$slot_id]["size"]["w"] = $imgProp['w'];
                                $filesArr[$slot_type][$slot_id]["size"]["h"] = $imgProp['h'];
                                $imgResize = true;
                                $filesList .= $filename;
                            } elseif($imgProp===false) $filesListErr .= $filename;
                            //Создание превью изображения
                            $imgProp = true;
                            if (!empty($maxSizeConf['img_min_max_w'])&&!empty($maxSizeConf['img_min_max_w'])&&$imgProp=MNBVImg::imageResize($filenameMin,$tmpname_in,$filetype,$maxSizeConf['img_min_max_w'],$maxSizeConf['img_min_max_h'],$maxSizeConf['img_min_quality'],$maxSizeConf['img_update'])){
                                if (!isset($filesArr[$slot_type][$slot_id]["size"])) $filesArr[$slot_type][$slot_id]["size"]=array();
                                $filesArr[$slot_type][$slot_id]["size"]['min']["kb"] = $imgProp['kb'];
                                $filesArr[$slot_type][$slot_id]["size"]['min']["w"] = $imgProp['w'];
                                $filesArr[$slot_type][$slot_id]["size"]['min']["h"] = $imgProp['h'];
                                $imgResize = true;
                                $filesList .= (!empty($filesList)?', ':'').$filenameMin;
                            } elseif($imgProp===false) $filesListErr .= (!empty($filesListErr)?', ':'').$filenameMin;
                            //Создание большого изображения
                            $imgProp = true;
                            if (!empty($maxSizeConf['img_big_max_w'])&&!empty($maxSizeConf['img_big_max_w'])&&$imgProp=MNBVImg::imageResize($filenameBig,$tmpname_in,$filetype,$maxSizeConf['img_big_max_w'],$maxSizeConf['img_big_max_h'],$maxSizeConf['img_big_quality'],$maxSizeConf['img_update'])){
                                if (!isset($filesArr[$slot_type][$slot_id]["size"])) $filesArr[$slot_type][$slot_id]["size"]=array();
                                $filesArr[$slot_type][$slot_id]["size"]['big']["kb"] = $imgProp['kb'];
                                $filesArr[$slot_type][$slot_id]["size"]['big']["w"] = $imgProp['w'];
                                $filesArr[$slot_type][$slot_id]["size"]['big']["h"] = $imgProp['h'];
                                $filesList .= (!empty($filesList)?', ':'').$filenameBig;
                                $imgResize = true;
                            } elseif($imgProp===false) $filesListErr .= (!empty($filesListErr)?', ':'').$filenameBig;

                            if ($imgResize){ //Если преобразование закончилось успешно, то продолжим
                                MNBVStorage::sendFile($filename,$item['usestorage'],$item["id"],$slot_type,$slot_id); //При необходимости свяжемся с другим серваком
                                //Вносим изменения в массив приложенных файлов
                                $filesArr[$slot_type][$slot_id]["type"] = $filetype;
                                $filesArr[$slot_type][$slot_id]["fname"] = $filename_in;
                                $filesArr[$slot_type][$slot_id]["edituser"] = Glob::$vars['user']->get('userid');
                                $filesArr[$slot_type][$slot_id]["editdate"] = $thisTime;
                                $filesArr[$slot_type][$slot_id]["upldate"] = $thisTime;
                                $filesArr[$slot_type][$slot_id]["editip"] = GetEnv('REMOTE_ADDR');
                                $filesArrUpd = true;
                                SysLogs::addLog("Upload $filesList complite!");
                                
                                //Сформируем блок текста, который затем вставим в форму
                                $tecFsrc = '';
                                $tecFgo_link = '';
                                if (SysBF::getFrArr($filesArr[$slot_type][$slot_id],"fname")) $tecFsrc = MNBVStorage::getFileName($item['usestorage'],$item["id"],$slot_type,$slot_id,SysBF::getFrArr($filesArr[$slot_type][$slot_id],"type"),SysBF::getFrArr($filesArr[$slot_type][$slot_id],"upldate"));
                                elseif (SysBF::getFrArr($filesArr[$slot_type][$slot_id],"url")) $tecFsrc = SysBF::getFrArr($filesArr[$slot_type][$slot_id],"url");
                                $tecFgo_link = (!empty($filesArr[$slot_type][$slot_id]["link"]))?$filesArr[$slot_type][$slot_id]["link"]:'';
            
                                $putHtmlTxt = '';
                                $PgHtml .= 'window.parent.document.getElementById("res'.$item["slot_type"].$item["slot_id"].'").innerHTML="";';
                                if (!empty($tecFgo_link)) $putHtmlTxt .= '<a href=\"'.$tecFgo_link.'\" target=_blank>';
                                $putHtmlTxt .= '<img src=\"'.$tecFsrc.'\" style=\"max-width:100%\"><br>';
                                if (!empty($tecFgo_link)) $putHtmlTxt .= '</a>';
                                $putHtmlTxt .= '<input type=\"button\" onclick=\"slot_update(\'delete\',\''.$slot_type.'\','.$slot_id.');\" value=\"'.Lang::get("Delete").'\"><br>';
                                //$putHtmlTxt .= Lang::get('Name').': <input type=\"text\" name=\"uf'.$slot_type.'name['.$slot_id.']\" value=\"'.((!empty($filesArr[$slot_type][$slot_id]["name"]))?$filesArr[$slot_type][$slot_id]["name"]:'').'\" style=\"width:80%;\"><br>';
                                //$putHtmlTxt .= Lang::get('Link').': <input type=\"text\" name=\"uf'.$slot_type.'link['.$slot_id.']\" value=\"'.((!empty($filesArr[$slot_type][$slot_id]["link"]))?$filesArr[$slot_type][$slot_id]["link"]:'').'\" style=\"width:80%;\"><br>';
                                $putHtmlTxt .= "&nbsp;";
                                
                                //if (empty($filesArr[$slot_type][$slot_id]["url"])) 
                                $PgHtml .= 'window.parent.document.getElementById("res'.$slot_type.$slot_id.'").innerHTML="'.$putHtmlTxt.'";';
                                //-----------------------------------------------------
                            }else{
                                SysLogs::addError('Error Upload: '.$filesListErr.' on slot_type='.$item["slot_type"].'!');
                            }
                        }elseif($item["slot_type"]=='att'){ //Это не изображение, грузим без преобразования
                            if (!MNBVStorage::validateFileType($item['usestorage'],$filetype,$item["slot_type"])) {
                                SysLogs::addError('Error: Wrong file type='.$filetype.' on slot_type='.$item["slot_type"].'!');
                                break;
                            }
                            //Копируем файл в папку назначения
                            $filename = MNBVStorage::getRealFileName($item['usestorage'],$item["id"],$slot_type,$slot_id,$filetype);
                            if ($filename===null) break;
                            if (copy($_FILES["$folderName"]['tmp_name'],$filename)){
                                MNBVStorage::sendFile($filename,$item['usestorage'],$item["id"],$slot_type,$slot_id); //При необходимости свяжемся с другим серваком
                                //Вносим изменения в массив приложенных файлов типа $item['obj']['files']['att'][1]=array('type'=>'txt','fname'=>'output.txt')
                                if (!isset($item['obj']['files'][$slot_type][$slot_id])) $filesArr[$slot_type][$slot_id] = array();
                                $filesArr[$slot_type][$slot_id]["type"] = $filetype;
                                $filesArr[$slot_type][$slot_id]["fname"] = $_FILES["$folderName"]['name'];
                                $filesArr[$slot_type][$slot_id]["size"]["kb"] = ceil($_FILES["$folderName"]["size"]/1024);
                                $filesArr[$slot_type][$slot_id]["edituser"] = Glob::$vars['user']->get('userid');
                                $filesArr[$slot_type][$slot_id]["editdate"] = $thisTime;
                                $filesArr[$slot_type][$slot_id]["upldate"] = $thisTime;
                                $filesArr[$slot_type][$slot_id]["editip"] = GetEnv('REMOTE_ADDR');
                                $filesArr[$slot_type][$slot_id]["kb"] = ceil($_FILES["$folderName"]["size"]/1024);
                                $filesArrUpd = true;
                                SysLogs::addLog("Upload $filename complite!");
                                
                                //Сформируем блок текста, который затем вставим в форму ВНИМАНИЕ!!! ATT отличается от IMG!
                                $tecFsrc = '';
                                $tecFgo_link = '';
                                if (SysBF::getFrArr($filesArr[$slot_type][$slot_id],"fname")) $tecFsrc = WWW_IMGPATH . Glob::$vars['file_types'][SysBF::getFrArr($filesArr[$slot_type][$slot_id],"type",'')]['logo_big'];
                                elseif (SysBF::getFrArr($filesArr[$slot_type][$slot_id],"url")) $tecFsrc = SysBF::getFrArr($filesArr[$slot_type][$slot_id],"url");
                                $tecFgo_link = (!empty($filesArr[$slot_type][$slot_id]["link"]))?$filesArr[$slot_type][$slot_id]["link"]:'';
                                if (SysBF::getFrArr($filesArr[$slot_type][$slot_id],"fname")) $tecFgo_link = MNBVStorage::getFileName($item['usestorage'],$item["id"],$slot_type,$slot_id,SysBF::getFrArr($filesArr[$slot_type][$slot_id],"type"),SysBF::getFrArr($filesArr[$slot_type][$slot_id],"upldate"));
            
                                $putHtmlTxt = '';
                                if (!empty($tecFgo_link)) $putHtmlTxt .= '<a href=\"'.$tecFgo_link.'\" target=_blank>';
                                $putHtmlTxt .= '<img src=\"'.$tecFsrc.'\">';
                                if (!empty($tecFgo_link)) $putHtmlTxt .= '</a>';
                                $putHtmlTxt .= '<input type=\"button\" onclick=\"slot_update(\'delete\',\''.$slot_type.'\','.$slot_id.');\" value=\"'.Lang::get("Delete").'\"><br>';
                                //$putHtmlTxt .= Lang::get('Name').': <input type=\"text\" name=\"uf'.$slot_type.'name['.$slot_id.']\" value=\"'.((!empty($filesArr[$slot_type][$slot_id]["name"]))?$filesArr[$slot_type][$slot_id]["name"]:'').'\" style=\"width:80%;\"><br>';
                                $putHtmlTxt .= "&nbsp;";
                                
                                //if (empty($filesArr[$slot_type][$slot_id]["url"])) 
                                $PgHtml .= 'window.parent.document.getElementById("res'.$slot_type.$slot_id.'").innerHTML="'.$putHtmlTxt.'";';
                                //-----------------------------------------------------
                            }
                        }
                        $PgHtml .= 'window.parent.document.forms["'.$item["upl_form_name"].'"].reset();';

                    }else{
                        SysLogs::addError("Upload Error!");
                    }

                    break;
                case 'frphotoedit': //Загрузить из редактора
                    break;
                case 'update': //Редактирование полей при необходимости

                    //Профили размера изображений
                    $maxSizeProfile = (isset(Glob::$vars['img_max_size'][$item['usestorage']]))?$item['usestorage']:$imgSizeType="default";
                    if ($imgSizeType = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'img_max_size'),'strictstr')) if (isset(Glob::$vars['img_max_size']["$imgSizeType"])) {
                        $maxSizeProfile = $imgSizeType;
                    }
                    Glob::$vars['session']->set('img_max_size_profile',$maxSizeProfile);
                    Glob::$vars['session']->set('img_max_size_objid',$item["id"]);
                    //-------------------------------------------------

                    //Картинки
                    $ufimgurl = SysBF::getFrArr(Glob::$vars['request'],'ufimgurl');
                    $ufimglink = SysBF::getFrArr(Glob::$vars['request'],'ufimglink');
                    $ufimgname = SysBF::getFrArr(Glob::$vars['request'],'ufimgname');
                    $ufimgtext = SysBF::getFrArr(Glob::$vars['request'],'ufimgtext');
                    //Данные по URL
                    if (isset($ufimgurl) && is_array($ufimgurl)){
                        foreach ($ufimgurl as $key=>$value){
                           //Вносим изменения в массив приложенных файлов
                           $valueVal = SysBF::checkStr($value,'url',255); //Делаем проверку входных данных на строку
                           if (!empty($valueVal)&&!isset($item['obj']['files']['img'][strval($key)])) $filesArr['img'][strval($key)] = array();
                           $filesArr['img'][strval($key)]["url"] = $valueVal; //Делаем проверку входных данных на строку
                           if (empty($filesArr['img'][strval($key)]["url"])) unset($filesArr['img'][strval($key)]["url"]);
                           else {
                               if (empty($filesArr['img'][strval($key)]["fname"])) $filesArr['img'][strval($key)]['type'] = MNBVf::getFileType($filesArr['img'][strval($key)]["url"]);
                               $filesArr['img'][strval($key)]["edituser"] = Glob::$vars['user']->get('userid');
                               $filesArr['img'][strval($key)]["editdate"] = $thisTime;
                               $filesArr['img'][strval($key)]["editip"] = GetEnv('REMOTE_ADDR');
                               $filesArrUpd = true;
                           }
                        }
                    }
                    
                    //Данные по link
                    if (isset($ufimglink) && is_array($ufimglink)){
                        foreach ($ufimglink as $key=>$value){
                            //Вносим изменения в массив приложенных файлов
                            $valueVal = SysBF::checkStr($value,'url',255); //Делаем проверку входных данных на строку
                           if (!empty($valueVal)&&!isset($item['obj']['files']['img'][strval($key)])) $filesArr['img'][strval($key)] = array();
                           $filesArr['img'][strval($key)]["link"] = $valueVal; //Делаем проверку входных данных на строку
                           if (empty($filesArr['img'][strval($key)]["link"])) unset($filesArr['img'][strval($key)]["link"]);
                            $filesArr['img'][strval($key)]["edituser"] = Glob::$vars['user']->get('userid');
                            $filesArr['img'][strval($key)]["editdate"] = $thisTime;
                            $filesArr['img'][strval($key)]["editip"] = GetEnv('REMOTE_ADDR');
                            $filesArrUpd = true;
                        }
                    }
                    
                    //Данные по name
                    if (isset($ufimgname) && is_array($ufimgname)){
                        foreach ($ufimgname as $key=>$value){
                            //Вносим изменения в массив приложенных файлов
                            $valueVal = SysBF::checkStr($value,'stringkav',255); //Делаем проверку входных данных на строку
                           if (!empty($valueVal)&&!isset($item['obj']['files']['img'][strval($key)])) $filesArr['img'][strval($key)] = array();
                           $filesArr['img'][strval($key)]["name"] = $valueVal; //Делаем проверку входных данных на строку
                           if (empty($filesArr['img'][strval($key)]["name"])) unset($filesArr['img'][strval($key)]["name"]);
                            $filesArr['img'][strval($key)]["edituser"] = Glob::$vars['user']->get('userid');
                            $filesArr['img'][strval($key)]["editdate"] = $thisTime;
                            $filesArr['img'][strval($key)]["editip"] = GetEnv('REMOTE_ADDR');
                            $filesArrUpd = true;
                        }
                    }

                    //Данные по text
                    if (isset($ufimgtext) && is_array($ufimgtext)){
                        foreach ($ufimgtext as $key=>$value){
                            //Вносим изменения в массив приложенных файлов
                            $valueVal = SysBF::checkStr($value,'stringkav',255); //Делаем проверку входных данных на строку
                            if (!empty($valueVal)&&!isset($item['obj']['files']['img'][strval($key)])) $filesArr['img'][strval($key)] = array();
                            $filesArr['img'][strval($key)]["text"] = $valueVal; //Делаем проверку входных данных на строку
                            if (empty($filesArr['img'][strval($key)]["text"])) unset($filesArr['img'][strval($key)]["text"]);
                            $filesArr['img'][strval($key)]["edituser"] = Glob::$vars['user']->get('userid');
                            $filesArr['img'][strval($key)]["editdate"] = $thisTime;
                            $filesArr['img'][strval($key)]["editip"] = GetEnv('REMOTE_ADDR');
                            $filesArrUpd = true;
                        }
                    }
                    
                    //Файлы
                    $ufatturl = SysBF::getFrArr(Glob::$vars['request'],'ufatturl');
                    $ufattname = SysBF::getFrArr(Glob::$vars['request'],'ufattname');
                    
                    //Данные по URL
                    if (isset($ufatturl) && is_array($ufatturl)){
                        foreach ($ufatturl as $key=>$value){
                            //Вносим изменения в массив приложенных файлов
                            $valueVal = SysBF::checkStr($value,'url',255); //Делаем проверку входных данных на строку
                           if (!empty($valueVal)&&!isset($item['obj']['files']['att'][strval($key)])) $filesArr['att'][strval($key)] = array();
                           $filesArr['att'][strval($key)]["url"] = $valueVal; //Делаем проверку входных данных на строку
                           if (empty($filesArr['att'][strval($key)]["url"])) unset($filesArr['att'][strval($key)]["url"]);
                           else {
                               if (empty($filesArr['att'][strval($key)]["fname"])) $filesArr['att'][strval($key)]['type'] = MNBVf::getFileType($filesArr['att'][strval($key)]["url"]);
                               $filesArr['att'][strval($key)]["edituser"] = Glob::$vars['user']->get('userid');
                               $filesArr['att'][strval($key)]["editdate"] = $thisTime;
                               $filesArr['att'][strval($key)]["editip"] = GetEnv('REMOTE_ADDR');
                               $filesArrUpd = true;
                           }
                        }
                    }
                    
                    //Данные по name
                    if (isset($ufattname) && is_array($ufattname)){
                        foreach ($ufattname as $key=>$value){
                            //Вносим изменения в массив приложенных файлов
                           $valueVal = SysBF::checkStr($value,'stringkav',255); //Делаем проверку входных данных на строку
                           if (!empty($valueVal)&&!isset($item['obj']['files']['att'][strval($key)])) $filesArr['att'][strval($key)] = array();
                           $filesArr['att'][strval($key)]["name"] = $valueVal; //Делаем проверку входных данных на строку
                           if (empty($filesArr['att'][strval($key)]["name"])) unset($filesArr['att'][strval($key)]["name"]);
                            $filesArr['att'][strval($key)]["edituser"] = Glob::$vars['user']->get('userid');
                            $filesArr['att'][strval($key)]["editdate"] = $thisTime;
                            $filesArr['att'][strval($key)]["editip"] = GetEnv('REMOTE_ADDR');
                            $filesArrUpd = true;
                        }
                    }
                          
                    if (!empty($item["main_form_name"])) $PgHtml .= 'window.parent.document.forms["'.$item["main_form_name"].'"].submit();';
                    
                    break;
                case 'delete': //Удаление файлов

                    //Проверяем входные данные
                    if(($item["slot_type"]!='img'&&$item["slot_type"]!='att') || $item["slot_id"]===null) break;
                    $folderName = 'uf'.$item["slot_type"].$item["slot_id"]; //Название поле закачки файла
                    $folderDelName = 'f'.$item["slot_type"].'del'.$item["slot_id"]; //Название поле удаления файла

                    //Удалим требуемые файлы
                    if (!empty($filesArr[$item["slot_type"]][strval($item["slot_id"])]["fname"])){//При наличии реального файла, удаляем его
                        $filename = MNBVStorage::getRealFileName($item['usestorage'],$item["id"],$item["slot_type"],$item["slot_id"],SysBF::getFrArr($item['obj']['files'][$item["slot_type"]][$item["slot_id"]],'type',''));
                        if ($item["slot_type"]=='img'){
                            $filenameMin = MNBVStorage::getRealFileName($item['usestorage'],$item["id"],$item["slot_type"],$item["slot_id"],SysBF::getFrArr($item['obj']['files'][$item["slot_type"]][$item["slot_id"]],'type',''),'min');
                            $filenameBig = MNBVStorage::getRealFileName($item['usestorage'],$item["id"],$item["slot_type"],$item["slot_id"],SysBF::getFrArr($item['obj']['files'][$item["slot_type"]][$item["slot_id"]],'type',''),'big');
                        }
                        if ($filename===null) break;

                        //Если файлы есть локально, то удалим
                        $filesList = '';
                        if (file_exists($filename)==1) {
                            chmod("$filename",0666);
                            $dlres=unlink($filename);
                            $filesList .= $filename;
                        }
                        if ($item["slot_type"]=='img' && file_exists($filenameMin)==1) {
                            chmod("$filenameMin",0666);
                            $dlres=unlink($filenameMin);
                            $filesList .= (!empty($filesList)?', ':'').$filenameMin;
                        }
                        if ($item["slot_type"]=='img' && file_exists($filenameBig)==1) {
                            chmod("$filenameBig",0666);
                            $dlres=unlink($filenameBig);
                            $filesList .= (!empty($filesList)?', ':'').$filenameBig;
                        }

                        //Почистим данные слота
                        unset($filesArr[$item["slot_type"]][strval($item["slot_id"])]["fname"]);
                        unset($filesArr[$item["slot_type"]][strval($item["slot_id"])]["type"]);
                        unset($filesArr[$item["slot_type"]][strval($item["slot_id"])]["size"]);
                        if (!empty($filesList)) SysLogs::addLog("Delete $filesList complite!");

                        //При необходимости свяжемся с другим серваком
                        MNBVStorage::sendRemoveFile($item['usestorage'],$item["id"],$item["slot_type"],$item["slot_id"]);

                        //Если задан URL. то тип в слоте поправим по URL
                        if (!empty($filesArr[$item["slot_type"]][strval($item["slot_id"])]["url"]) && empty($filesArr[$item["slot_type"]][strval($item["slot_id"])]["fname"])) {
                            $filesArr[$item["slot_type"]][strval($item["slot_id"])]['type'] = MNBVf::getFileType($filesArr[$item["slot_type"]][strval(strval($item["slot_id"]))]["url"]);
                            $filesArr[$item["slot_type"]][strval($item["slot_id"])]["edituser"] = Glob::$vars['user']->get('userid');
                            $filesArr[$item["slot_type"]][strval($item["slot_id"])]["editdate"] = $thisTime;
                            $filesArr[$item["slot_type"]][strval($item["slot_id"])]["upldate"] = '';
                            $filesArr[$item["slot_type"]][strval($item["slot_id"])]["editip"] = GetEnv('REMOTE_ADDR');
                        }
                        else {//Если URL нет, то удаляем слот полностью
                            unset($filesArr[$item["slot_type"]][strval($item["slot_id"])]);
                            SysLogs::addLog("Clear slot ".$item["slot_type"]."[".$item["slot_id"]."] complite!");
                        }
                    }else{//Если файла нет, то удаляем ссылку
                        unset($filesArr[$item["slot_type"]][strval($item["slot_id"])]);
                        SysLogs::addLog("Clear slot ".$item["slot_type"]."[".$item["slot_id"]."] complite!");
                    }

                    $filesArrUpd = true; //Маркер необходимости редактирования files

                    //При необходимости сформируем html
                    if ($item["slot_type"]=='img' && !empty($filesArr[$item["slot_type"]][strval($item["slot_id"])]["url"])) {//Там еще остался URL
                        $putHtmlTxt = '';
                        $PgHtml .= 'window.parent.document.getElementById("res'.$item["slot_type"].$item["slot_id"].'").innerHTML="";';
                        $tecFgo_link = (!empty($filesArr[$item["slot_type"]][strval($item["slot_id"])]["link"]))?$filesArr[$item["slot_type"]][strval($item["slot_id"])]["link"]:'';
                        if (!empty($tecFgo_link)) $putHtmlTxt .= '<a href=\"'.$tecFgo_link.'\" target=_blank>';
                        $putHtmlTxt .= '<img src=\"'.$filesArr[$item["slot_type"]][strval($item["slot_id"])]["url"].'\" style=\"max-width:100%\"><br>';
                        if (!empty($tecFgo_link)) $putHtmlTxt .= '</a>';
                        $putHtmlTxt .= '<input type=\"button\" onclick=\"slot_update(\'delete\',\''.$item["slot_type"].'\','.$item["slot_id"].');\" value=\"'.Lang::get("Delete").'\"><br>';
                        //$putHtmlTxt .= Lang::get('Name').': <input type=\"text\" name=\"uf'.$item["slot_type"].'name['.$item["slot_id"].']\" value=\"'.((!empty($filesArr[$item["slot_type"]][strval($item["slot_id"])]["name"]))?$filesArr[$item["slot_type"]][strval($item["slot_id"])]["name"]:'').'\" style=\"width:80%;\"><br>';
                        //$putHtmlTxt .= Lang::get('Link').': <input type=\"text\" name=\"uf'.$item["slot_type"].'link['.$item["slot_id"].']\" value=\"'.((!empty($filesArr[$item["slot_type"]][strval($item["slot_id"])]["link"]))?$filesArr[$item["slot_type"]][strval($item["slot_id"])]["link"]:'').'\" style=\"width:80%;\"><br>';
                        $putHtmlTxt .= "&nbsp;";
                        $PgHtml .= 'window.parent.document.getElementById("res'.$item["slot_type"].$item["slot_id"].'").innerHTML="'.$putHtmlTxt.'";';
                    }else{//Нет ничего, удаляем все поля
                        $PgHtml .= 'window.parent.document.getElementsByName(\'uf'.$item["slot_type"].'url['.$item["slot_id"].']'.'\')[0].value="";'."\n";
                        $PgHtml .= 'window.parent.document.getElementById("res'.$item["slot_type"].$item["slot_id"].'").innerHTML="";'."\n";
                    }

                    //$PgHtml .= 'window.parent.document.forms["'.$item["upl_form_name"].'"].reset();';

                    break;

            }

            $PgHtml .= 'window.parent.document.forms["'.$item["upl_form_name"].'"].act.value="update";'; //Вернем в исходное состояние, иначе будет дублирование действия при редактировании прошлых полей
            
            $PgHtml .=  '</script>';

            //Сохраняем массив приложенных файлов если были изменения
            //Почистим массив files при необходимости
            if (isset($filesArr['img']) && is_array($filesArr['img']))foreach ($filesArr['img'] as $key=>$value) if (count($value)==0||(empty($value['fname'])&&empty($value['url']))) unset($filesArr['img']["$key"]);
            if (isset($filesArr['att']) && is_array($filesArr['att']))foreach ($filesArr['att'] as $key=>$value) if (count($value)==0||(empty($value['fname'])&&empty($value['url']))) unset($filesArr['att']["$key"]);
            if (isset($filesArr['img']) && (!is_array($filesArr['img'])||count($filesArr['img'])==0)) unset($filesArr['img']);
            if (isset($filesArr['att']) && (!is_array($filesArr['att'])||count($filesArr['att'])==0)) unset($filesArr['att']);
            
            if ($filesArrUpd){
                $updateArr["files"] = (count($filesArr)>0)?json_encode($filesArr):'';

                $updateArr["author"] = Glob::$vars['user']->get('name');
                $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                $updateArr["editdate"] = $thisTime;
                $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$item["id"]));
                SysLogs::addLog("Update object /".$this->getStorage()."/".$item["id"]."/ ".(($res)?'successful!':'error!'));
                $reloadObjects = true;
            }

            /* Раскомментить, если потребуется передать данные по объекту
            if (!empty($reloadObjects)){//Еще раз получим сведения по текущему объекту, если были изменения.
                //Сведения по текущему объекту -----------------------------------------------------
                $storageRes = MNBVStorage::getObjAcc($this->getStorage(),
                    array("access","access2","files"),
                    array("id",'=',$item["id"]));
                $item['obj'] = ($storageRes[0]>0)?$storageRes[1]:null;
            }
            */
            unset($item['obj']); //Очистим данные по объекту, ибо не надо их передавать.
        
        }else{
            SysLogs::addError("Error: Access denied! [".Glob::$vars['user']->get('permstr')."]");
        }

        $PgHtml .= '<script type="text/javascript">window.parent.document.getElementById("uplformloading").style.display="none";</script>';
        //if ($tpl_mode=='html'){$PgHtml = "<pre>$PgHtml</pre>";}
        if (!empty($item["upl_form_name"])) $item['page_content'] = $PgHtml; //Выводим эту шнягу только по запросу

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main_blank.php'),$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();

    }

    public function action_upload_imgslot($slot='no'){

    }

}