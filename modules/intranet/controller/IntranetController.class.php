<?php
/**
 * Intranet Controller class - дефолтовый контроллер
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class IntranetController{

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

        if (Glob::$vars['user']->get('userid')==0) MNBVf::redirect('/intranet/auth/'); //Если неавторизованный пользователь, перебросим на авторизацию
        
        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("MNBV intranet","module_names"); //Метатеги
        SysLogs::addLog("Page_title: ". Glob::$vars['page_title']);
        
        $item = array(); //Массив данных, передаваемых во View

        $PgHtml = '
-------
Intranet
-------
';
        if ($tpl_mode=='html'){$PgHtml = "<pre>$PgHtml</pre>";}

        $item['page_h1'] = Glob::$vars['page_h1'];
        $item['page_content'] = $PgHtml;

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();

    }


}
