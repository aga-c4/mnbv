<?php
/**
 * Виджет стандартного фильтра хранилища
 * User: User
 * Date: 10.10.17
 * Time: 10:28
 */

class WidgetFilterstandartController {


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
        //if (empty($param)) return;

        if (!empty($item['list_storage_alias'])) {
            $storage = strval($item['list_storage_alias']);
            if (!isset(SysStorage::$storage[$storage]['filter']) || !is_array(SysStorage::$storage[$storage]['filter'])) return;
            if (!isset(SysStorage::$storage[$storage]['filter']['view']) || !is_array(SysStorage::$storage[$storage]['filter']['view']) || count(SysStorage::$storage[$storage]['filter']['view'])==0) return;

            if (!is_array($item)) $item = array();
            $this->param = $param;

            $tplFile = MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.((!empty($vidget_tpl))?$vidget_tpl:'wdg_'.$this->thisWidgetName.'.php'));
            if(!file_exists($tplFile)) {
                SysLogs::addError('Error: Wrong widget template [' . $tplFile . ']');
                return;
            }
            $this->tpl = $tplFile;

            $filterArr = array(
                "storage" => $storage,
                "filter" => SysStorage::$storage[$storage]['filter'],
            );
            if (isset($item['list_filter_values'])&&is_array($item['list_filter_values'])) $filterArr["values"] = $item['list_filter_values'];
            if (is_array($param)){
                if (!empty($param['autosubmit'])) $filterArr["filter"]["autosubmit"] = true;
                if (!empty($param['fltr_method']) && strtolower($param['fltr_method'])=='post') $filterArr["filter"]["fltr_method"] = 'post';
            }

            require $tplFile;
        }

    }

} 