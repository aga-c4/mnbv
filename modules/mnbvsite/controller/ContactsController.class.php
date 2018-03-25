<?php
/**
 * Контроллер формы обратной связи
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 24.08.17
 * Time: 00:00
 */
class ContactsController extends AbstractMnbvsiteController {
    
	
    /**
     * @var string идентификатор текущего используемого хранилища
     */
    private $storage = 'messages';
    
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
     * @param $item массив $item, сформированный в родительском контроллере
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($item=array(),$tpl_mode='html', $console=false){
        
        $thisTime = time();
        $thisDateTime = date("Y-m-d H:i:s",time($thisTime));
        //$this->setStorage('messages');
        
        $storage = $this->getStorage();
        $folderId = (!empty($item['obj']['vars']['script_folder']))?intval($item['obj']['vars']['script_folder']):0;   
        
        $item['sub_obj'] = MNBVf::createStorageObject($this->getStorage(),$folderId,array('altlang'=>Glob::$vars['mnbv_altlang']));//Объект для редактирования найден
        $item['sub_obj']['sub_obj_storage'] = $storage; 
        $item['sub_obj']['folderid'] = $folderId;   

        SysLogs::addLog('Select mnbv script storage: [' . $storage . ']');
        SysLogs::addLog('Select mnbv script storage folder: [' . $folderId . ']');
        
        //Структура формы работы с данными важно определить ее до операций над объектом
        $item['sub_obj']['form_folder'] = array(
            "from_fio" => array("name"=>"from_fio", "type"=>"text", "print_name"=>"name", "size"=>255,"width"=>"100%","checktype" => "text"), //Основной язык
            "email" => array("name"=>"email", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"), //Основной язык
            "phone" => array("name"=>"phone", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"), //Основной язык
            "text" => array("name"=>"text", "type"=>"textarea", "print_name"=>"Message", "editor"=>false,"rows"=>20,"width"=>"100%","table" =>"thline","checktype" => "text"), //Основной язык
        );
        
        $item['sub_obj']['messageOk'] = false;
        $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');
        switch ($act){
            
            case 'create': //Редактирование элемента списка

                //Установка маркеров видимости и выделения
                $ob_visible = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ob_visible',0),'on');
                $ob_first = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ob_first',0),'on');
                $ob_type = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ob_type',0),'on');
                
                //Принудительная установка некоторых параметров (в других контроллерах этот список может быть иным, вышестоящее определение переменных - для универсальности при копипасте)
                $ob_visible = 1; //Видимый объект
                $ob_first = 0; //Без маркера Гл
                $ob_type = 0; //Это объект, не папка

                //Получим новые значения полей
                $updateArr = array("parentid"=>$folderId, "visible"=>$ob_visible, "first"=>$ob_first,"type"=>$ob_type,);
                $varsArr = $item['sub_obj']['vars'];
                $attrValsArr = $item['sub_obj']['attrvals'];
                $varsArrUpd = $attrValsArrUpd = false; //Маркеры необходимости редактирования
                foreach(Glob::$vars['request'] as $key=>$value){
                    if (preg_match("/^ob_/",$key) && $key!='ob_visible' && $key!='ob_first' && $key!='ob_id') {
                        $realKey = preg_replace("/^ob_/","",$key);
                        if (!isset(SysStorage::$storage[$this->getStorage()]["stru"]["$realKey"]))continue;
                        $realKeyStru = SysStorage::$storage[$this->getStorage()]["stru"]["$realKey"];
                        if ($realKey=='typeval') $realKeyView = array("name"=>"typeval", "type"=>"text", "size"=>255,"width"=>"70%","checktype" => "url");
                        else $realKeyView = $item['sub_obj']['form_folder']["$realKey"];                            
                        $keyType = ($realKeyStru["dbtype"])?$realKeyStru["dbtype"]:'';
                        $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';
                        $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='ob_',$prefKey='obk_', $prefUpd='obd_');
                        if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                        $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';
                        $updateArr["$realKey"] = SysBF::checkStr($value,$checkType);    
                    }elseif (preg_match("/^obv_/",$key)) {
                        $realKey = preg_replace("/^obv_/","",$key);
                        if (!isset(SysStorage::$storage[$this->getStorage()]["stru"]["vars"]["list"]["$realKey"]))continue;
                        $realKeyStru = SysStorage::$storage[$this->getStorage()]["stru"]["vars"]["list"]["$realKey"];
                        $realKeyView = $item['sub_obj']["vars"]["view"]["$realKey"];
                        $keyType = ($realKeyStru["dbtype"])?$realKeyStru["dbtype"]:'';
                        $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';                            
                        $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='obv_',$prefKey='obvk_', $prefUpd='obvd_');
                        if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                        $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';                            
                        if (!empty($value)) $varsArr["$realKey"] = SysBF::checkStr($value,$checkType); 
                        elseif(isset($varsArr["$realKey"]))unset($varsArr["$realKey"]);
                        $varsArrUpd = true;
                    }elseif (preg_match("/^obav_/",$key)) {                           
                        $realKey = preg_replace("/^obav_/","",$key);
                        if (!isset($item["sub_obj"]["attrview"]["$realKey"]))continue;
                        $realKeyView = $item["sub_obj"]["attrview"]["$realKey"];
                        $keyType = ($realKeyView["dbtype"])?$realKeyView["dbtype"]:'';
                        $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';                            
                        $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='obav_',$prefKey='obavk_', $prefUpd='obavd_');
                        if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                        $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';                           
                        if (!empty($value)) $attrValsArr["$realKey"] = SysBF::checkStr($value,$checkType); 
                        elseif(isset($attrValsArr["$realKey"]))unset($attrValsArr["$realKey"]);
                        $attrValsArrUpd = true;                              
                    }

                }
                
                if ($varsArrUpd) {if (count($varsArr)>0) $updateArr["vars"] = json_encode($varsArr); else $updateArr["vars"] = '';}
                if ($attrValsArr){if (count($attrValsArr)>0) $updateArr["attrvals"] = json_encode($attrValsArr); else $updateArr["attrvals"] = '';}
                if ($ob_type==1) {//Если это папка, то сформируем ей массив атрибутов вышестоящей папки
                    $updateArr["attrup"] = $item['sub_obj']['parent']['attrup'];
                    foreach ($item['sub_obj']['parent']['attr'] as $value) $updateArr["attrup"] = $value; 
                    if (count($updateArr["attrup"])>0) $updateArr["attrup"] = json_encode($updateArr["attrup"]); else $updateArr["attrup"] = '';
                }
                $updateArr["attr"] = '';
                

                $updateArr["author"] = Glob::$vars['user']->get('name');
                $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                $updateArr["editdate"] = $thisTime;
                $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                
                $updateArr['name'] = MNBVf::substr($updateArr["text"],0,50,true);
                $updateArr["text"] = preg_replace("/\r\n/","<br>",$updateArr["text"]);
                $updateArr["text"] = preg_replace("/\n/","<br>",$updateArr["text"]);
                $updateArr["userid"] = Glob::$vars['user']->get('userid');
                
                $res = MNBVStorage::addObj($this->getStorage(), $updateArr,'',false);
                SysLogs::addLog("Create object /".$this->getStorage()."/" . (($res)?($res.'/ successful!'):' error!'));
                $item['sub_obj']['messageOk'] = true;

                break;
            
        }

        //Шаблон вывода списка объектов
        $item['page_sctpl'] = 'tpl_contacts.php'; //По-умолчанию
        if (!empty($item['obj']['vars']['script_tpl_file'])) $item['page_sctpl'] = $item['obj']['vars']['script_tpl_file']; //Если задан в Переменных скрипта в объекте
        SysLogs::addLog('Select mnbv script tpl file: [' . $item['page_sctpl'] . ']');

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
    
}
