<?php
/**
 * Description of gormenuController
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class WidgetPaginationController extends AbstractWidgetControllerController {
    
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
     * Вывод виджета
     * @param type $item - массив данных шаблона, который приходит из контроллера модуля. Если не хотите передавать, можно не задавать, либо задать ''
     * @param type $param входные параметры (может быть массивом, либо переменной), если не задано, то запускается виджет без параметров. В параметрах может быть:
     * 'page_list_url' - базовый URL списка к которому надо добавить номер страницы, если задан, то используется для генерации URL
     * 'list_size' - полный размер списка
     * 'list_max_items' - максимальное количество элементов на странице
     * 'list_filter' - текущий фильтр, по-умолчанию ''
     * 'list_sort' - текущая сортировка, по-умолчанию ''
     * 'list_page' - текущая страница, по-умолчанию 1
     * 'centre_bl' - количество элементов в центральном блоке
     * @param type $vidget_tpl название файла шаблона для вывода, если не задан, то используется текущий шаблон Glob::$vars['mnbv_tpl']/units/wdg_ВИДЖЕТ.php
     * @return string результат выполнения виджета
     */
    public function action_index($item=array(),$param=NULL,$vidget_tpl=''){
        
        if (empty($param)) return;

        if (!is_array($item)) $item = array();
        $this->param = $param;

        //Формирование массива параметров виджета-----------------------------------------
        if (!is_array($param)) return;
        
        $tplFile = MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.((!empty($vidget_tpl))?$vidget_tpl:'wdg_'.$this->thisWidgetName.'.php')); 
        if(!file_exists($tplFile)) {
            SysLogs::addError('Error: Wrong widget template [' . $tplFile . ']');
            return;
        }
        $this->tpl = $tplFile;
        
        $page_list_url = (isset($param['page_list_url'])&&$param['page_list_url']!=='notset')?$param['page_list_url']:'notset';
        $list_size = (!empty($param['list_size']))?intval($param['list_size']):0;
        $list_max_items = (!empty($param['list_max_items']))?intval($param['list_max_items']):1;
        $centre_bl = (!empty($param['centre_bl']))?intval($param['centre_bl']):5;
        $list_page = (!empty($param['list_page']))?intval($param['list_page']):1;
        $list_filter = (!empty($param['list_filter']))?$param['list_filter']:'';
        $list_sort = (!empty($param['list_sort']))?$param['list_sort']:'';
        if ($list_page<1) $list_page = 1;
        $pages = ceil($list_size / $list_max_items);
        $blockPoz = floor($centre_bl / 2) + 1;
        $blockStart = $list_page - $blockPoz + 1;
        $blockEnd = $list_page + $blockPoz-1;
        
        //Условия смещения блока
        if ($blockStart<4){$blockStart = 1;$blockEnd = $centre_bl+2;}
        if($blockStart>$pages-$centre_bl-2){$blockEnd = $pages; $blockStart = $pages-$centre_bl-1;}
        
        if ($blockStart<1) $blockStart = 1;
        if ($blockEnd>$pages) $blockEnd = $pages;
        
        //Сведения о папке, которую выводим
        require $tplFile;
        
        return;
        
    }
    
}
