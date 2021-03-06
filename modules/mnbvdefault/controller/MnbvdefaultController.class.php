<?php
/**
 * User: AGA-C4
 * Date: 26.08.14
 * Time: 14:40
 */
 
/**
 * Default Controller class - дефолтовый контроллер
 */
class MnbvdefaultController{

    /**
     * @var string - Имя модуля контроллера (Внимание, оно должно соответствовать свойству $thisModuleName фронт контроллера модуля (используется во View)
     */
    public $thisModuleName = '';
    
    public function __construct($thisModuleName) {
        $this->thisModuleName = $thisModuleName;
    }

    /**
     * Метод по-умолчанию
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($tpl_mode='html', $console=false){
        $this->action_hello($tpl_mode, $console);//Покажем хелп
    }

    /**
     * Вывод страницы помощи
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_hello($tpl_mode='html', $console=false){

        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("MNBV site","module_names"); //Метатеги
        $item = array(); //Массив данных, передаваемых во View

        $PgHtml = '
-------
Site
-------
';
        if ($tpl_mode=='html'){$PgHtml = "<pre>$PgHtml</pre>";}

        $item['page_h1'] = Glob::$vars['page_h1'];
        $item['page_content'] = $PgHtml;
        if ($tpl_mode=='html'){$item['page_content'] .= "\n<center><img src=\"/src/mnbv/img/logo/smile.jpg\" width=240></center>";}

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();

    }

}
