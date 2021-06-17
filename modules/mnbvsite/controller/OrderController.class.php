<?php
/**
 * Контроллер корзины
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 24.08.17
 * Time: 00:00
 */
class OrderController extends AbstractMnbvsiteController {

    /**
     * @var string идентификатор текущего используемого хранилища
     */
    private $storage = 'carts';
    
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
        $thisDateTime = date("Y-m-d H:i:s",$thisTime);
        //$this->setStorage('carts');
        
        $storage = $this->getStorage();
        $folderId = (!empty($item['obj']['vars']['script_folder']))?intval($item['obj']['vars']['script_folder']):1;   
        
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
            case 'add': 
                break;
            case 'update': 
                break;
        }
        
        //Шаблон вывода списка объектов
        if (!empty($_GET["step"]) && $_GET["step"]==='send') {
            $item['page_sctpl'] = 'tpl_ordersend.php'; //По-умолчанию
        } else {
            $item['page_sctpl'] = 'tpl_orderedit.php'; //По-умолчанию
        }
        //$item['page_sctpl'] = 'tpl_ordersend.php'; //По-умолчанию
        if (!empty($item['obj']['vars']['script_tpl_file'])) $item['page_sctpl'] = $item['obj']['vars']['script_tpl_file']; //Если задан в Переменных скрипта в объекте
        SysLogs::addLog('Select mnbv script tpl file: [' . $item['page_sctpl'] . ']');

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
    
}
