<?php
/**
 * Description of gormenuController
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class WidgetGormenuController extends AbstractWidgetControllerController {
    
    /**
     * @var string алиас текущего виджета
     */
    public $thisWidgetName = '';
    
    /**
     * @var type параметры текущего виджета
     */
    public $param = NULL;
    
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
     * @param type $param входные параметры (может быть массивом, либо переменной), если не задано, то запускается виджет без параметров
     * @param type $vidget_tpl название файла шаблона для вывода, если не задан, то используется текущий шаблон Glob::$vars['mnbv_tpl']/units/wdg_ВИДЖЕТ.php
     * @return string результат выполнения виджета
     */
    public function action_index($item=array(),$param=NULL,$vidget_tpl=''){
        if (empty($param)) return;

        if (!is_array($item)) $item = array();
        $this->param = $param;

        $tplFile = MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.((!empty($vidget_tpl))?$vidget_tpl:'wdg_'.$this->thisWidgetName.'.php'));
        if(!file_exists($tplFile)) {
            SysLogs::addError('Error: Wrong widget template [' . $tplFile . ']');
            return;
        }
        $this->tpl = $tplFile;

        if (is_array($param)){ //Если массив, то данные по идентификатору меню и текущему объекту берем из него
            if (!empty($param['menuId'])) $menuId = intval($param['menuId']); else return;
            $activeObjId = (!empty($param['menuId']))?intval($param['activeObjId']):0;     
        }else{ //Если не массив, то это идентификатор текущего меню
            $menuId = intval($param);
        }
        
        $storageRes = MNBVStorage::getObjAcc('menu',
            array("id","parentid","name","namelang","type","nologin","lang","vars"),
            array("parentid",'=',$menuId,'and',"visible",'=',1,'and',"type","!=",1),array("sort"=>array("pozid"=>"inc")));
        if ($storageRes[0]>0) unset($storageRes[0]); else $storageRes=array();

        $menuArr = array();
        foreach ($storageRes as $menuItem) if (empty($menuItem["type"])) {

            $menuItem['vars'] = (!empty($menuItem['vars']))?SysBF::json_decode($menuItem['vars']):array();

            if (isset($menuItem['nologin']) && Glob::$vars['user']->get('userid')>0 && $menuItem['nologin']) continue;
            if (empty($menuItem['lang']) || !(Lang::getLang()==$menuItem['lang'] || $menuItem['lang']=='all'))continue;

            $menuResItem = array();
            $menuResItem['id'] = $menuItem['id'];
            $menuResItem['name'] = (Lang::isDefLang())?$menuItem['name']:$menuItem['namelang'];
            $menuResItem['url'] = (!empty($menuItem['vars']['url']))?$menuItem['vars']['url']:'';
            $menuResItem['active'] = false; 

            if (!empty($menuItem['vars']['objid']) && !empty($item["id"])&&
                $menuItem['vars']['objid']==$item["id"]
                ) $menuResItem['active'] = true;//Совпадение по объекту
            elseif(!empty($menuItem['vars']['controller'])&&!empty($menuItem['varsArr']['action']) &&
                $menuItem['vars']['controller']==Glob::$vars['mnbv_controller']&&$menuItem['vars']['action']==Glob::$vars['mnbv_action']
                ) $menuResItem['active'] = true; //Совпадение по controller+action
            elseif(!empty($menuItem['vars']['controller']) &&
                $menuItem['vars']['controller']==Glob::$vars['mnbv_controller']
                ) $menuResItem['active'] = true; //Совпадение по controller
            
            $menuArr[strval($menuResItem['id'])] = $menuResItem;

        }

        require $tplFile;
        
    }
    
}
