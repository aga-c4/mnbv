<?php
/**
 * Description of gormenuController
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class WidgetPgController extends AbstractWidgetControllerController {
    
    /**
     * @var string алиас текущего виджета
     */
    public $thisWidgetName = '';
    
    /**
     * @var type параметры текущего виджета
     */
    public $param = NULL;

    /**
     * @var string хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
     */
    public $storage = '';

    /**
     * @var int папка из которой будут выбираться объекты. Если не задано, то виджет не выводит ничего
     */
    public $id = 0;
    
    /**
     * @var type текущий шаблон вывода виджета
     */
    public $tpl = '';
    
    public function __construct($widget) {
        $this->thisWidgetName = $widget;
    }
    
    /**
     * Метод по-умолчанию
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    
    /**
     * Вывод виджета
     * @param type $item - массив данных шаблона, который приходит из контроллера модуля. Если не хотите передавать, можно не задавать, либо задать ''
     * @param type $param входные параметры (может быть массивом, либо переменной), если не задано, то запускается виджет без параметров. В параметрах может быть:
     * 'storage' - хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
     * 'id' - идентификатор показываемого объекта.
     * @param type $vidget_tpl название файла шаблона для вывода, если не задан, то используется текущий шаблон Glob::$vars['mnbv_tpl']/units/wdg_ВИДЖЕТ.php
     * @return string результат выполнения виджета
     */
    public function action_index($item=array(),$param=NULL,$vidget_tpl=''){
        if (empty($param)) return;

        if (!is_array($item)) $item = array();
        $this->param = $param;

        //Формирование массива параметров виджета-----------------------------------------
        if (!is_array($param)) return;
        if (empty($param['storage']) || !MNBVStorage::isStorage($param['storage'])) return; else $this->storage = $param['storage'];
        if (!empty($param['id'])) {
            $this->id = intval($param['id']);
        }else{
            return;
        }
        
        $tplFile = MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.((!empty($vidget_tpl))?$vidget_tpl:'wdg_'.$this->thisWidgetName.'.php')); 
        if(!file_exists($tplFile)) {
            SysLogs::addError('Error: Wrong widget template [' . $tplFile . ']');
            return;
        }
        $this->tpl = $tplFile;
        
        //Сведения о папке, которую выводим
        if ($item['sub_obj'] = MNBVf::getStorageObject($this->storage,$this->id,array('altlang'=>$item['mnbv_altlang'],'visible'=>false,'access'=>true,'site'=>true))){//Объект для редактирования найден
            if (Lang::isAltLang() && !empty($item['sub_obj']['textlang'])) require $tplFile;
            elseif (!Lang::isAltLang() && !empty($item['sub_obj']['text'])) require $tplFile;
        }
        
        return;
        
    }
    
}
