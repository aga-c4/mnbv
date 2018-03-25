<?php
/**
 * Default Controller class - дефолтовый контроллер
  *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 26.08.14
 * Time: 00:00
 */
class MnbvsiteController{

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
    
        //Редирект на модуль, привязанный к сайту
        if (!empty(Glob::$vars['mnbv_site']['module'])){
            Glob::$vars['mnbv_site']['module'] = strtolower(Glob::$vars['mnbv_site']['module']);
            $moduleFile =  MNBVf::getRealFileName(Glob::$vars['mnbv_site']['module'], Glob::$vars['mnbv_site']['module'] . '.php');
            if(file_exists($moduleFile)) {
                Glob::$vars['mnbv_module'] = Glob::$vars['mnbv_site']['module'];
                SysLogs::addLog('Go to module ['.$moduleFile.']');
                require_once ($moduleFile);
            }else { //Действие при ошибочном модуле - попробуем открыть модуль по-умолчанию
                SysLogs::addError('Error: Wrong module ['.$moduleFile.']');
                MNBVf::render(MNBVf::getRealTplName(MNBV_DEF_TPL,'404.php'),array(),Glob::$vars['tpl_mode']);
            }
            return;
        }

        if (Glob::$vars['mnbv_altlang']) {
            Glob::$vars['lang'] = Lang::getAltLangName();
        }
        
        $item = array(); //Массив данных, передаваемых во View
        $item['mnbv_altlang'] = Glob::$vars['mnbv_altlang'];
        $item['id'] = Glob::$vars['mnbv_site']['pgid'];
            
        //Сведения по текущей странице и по ее родительской папке -----------------------------------------------------

        if ($item['obj'] = MNBVf::getStorageObject(Glob::$vars['mnbv_site']['storage'],$item["id"],array('altlang'=>$item['mnbv_altlang'],'visible'=>true,'access'=>true,'site'=>true))){//Объект для редактирования найден

            //Доработаем данные по родительской папке
            if (!empty($item['obj']['parent']['alias'])) $item['obj']['parent_url'] = '/' . $item['obj']['parent']['alias'];
            
            //Подготовим переменные скрипта, если есть
            $item['obj']['vars']['scriptvars'] = (!empty($item['obj']['vars']['scriptvars']))?SysBF::json_decode($item['obj']['vars']['scriptvars']):array();
            
            //Поправим имя, описание и текст в соответствии с altlang
            if (!Lang::isDefLang()){
                if (!empty($item['obj']['namelang'])) $item['obj']['name'] = $item['obj']['namelang'];
                if (!empty($item['obj']['aboutlang'])) $item['obj']['about'] = $item['obj']['aboutlang'];
                if (!empty($item['obj']['textlang'])) $item['obj']['text'] = $item['obj']['textlang'];
            }
            
            Glob::$vars['page_title'] = (!empty($item['obj']['vars']['title']))?$item['obj']['vars']['title']:((!empty($item['obj']['name']))?$item['obj']['name']:'');
            Glob::$vars['page_keywords'] = (!empty($item['obj']['vars']['title']))?$item['obj']['vars']['keywords']:'';
            Glob::$vars['page_description'] = (!empty($item['obj']['vars']['description']))?$item['obj']['vars']['description']:'';            
            
            $item['page_url'] = MNBVf::requestUrl(); //Формирование URL из текущего адреса
            $item['page_url_swlang'] = MNBVf::requestUrl('swlang'); //Формирование URL из текущего адреса
            
            //Хлебные крошки------------------------------------------------------------------------------
            /*
            Хлебные крошки. Идея такова - есть массив на текущем языке где поля:
            0 => array('name'=>'Главная','url'=>'/') - Формируется в основном контроллере сайта
            1 => array('name'=>'Категория текущего уровня','url'=>'...') - Формируется в основном контроллере сайта, если не совпадает с главной страницей
            2 => array('name'=>'Название текущей страницы','url'=>'URL текущей страницы') - Формируется в основном контроллере сайта 
            3 => array('name'=>'Категория влолженного хранилища 1 уровня','url'=>'...') - Формируется в субконтроллере сайта  если не совпадает с категорией текущего уровня
            4 => array('name'=>'Категория влолженного хранилища текущего уровня','url'=>'...') - Формируется в субконтроллере
            5 => array('name'=>'Название текущего объекта влолженного хранилища ','url'=>'...') - Формируется в субконтроллере сайта
            
            При этом размещение этих элементов массива четко предопределено, чтоб при необходимости не выводить часть из них. смещая начало обработки массива к концу.
             */        
            $item['obj']['nav_arr'] = array();
            $item['obj']['nav_arr'][0] = array('name'=>Lang::get("NavMainpage"),'url'=>MNBVf::requestUrl('',($item['mnbv_altlang'])?('/'.Lang::getAltLangName()):'/')); //Главная страница
            if ($item['obj']['parent_id']>0 && $item['obj']['parent_id']!=Glob::$vars['mnbv_site']['startid']) { //Категория текущего уровня, если не совпадает с главной страницей
                $item['obj']['nav_arr'][1] = array('name'=>$item['obj']['parent_name'],'url'=>MNBVf::generateObjUrl($item['obj']['parent'], array('altlang'=>$item['mnbv_altlang'])));
            }
            if ($item['id']>0 && $item['id']!=Glob::$vars['mnbv_site']['startid']) $item['obj']['nav_arr'][3] = array('name'=>$item['obj']['name'],'url'=>MNBVf::generateObjUrl($item['obj'], array('altlang'=>$item['mnbv_altlang']))); //Текущая страница
            else unset($item['obj']['nav_arr'][0]); //Если это главная страница, то не выводим ссылку "Главная"
            //Конец обработки хлебных крошек -------------------------------------------------------------
            
            $item['page_h1'] = Glob::$vars['page_h1'] = (!empty($item['obj']['name']))?$item['obj']['name']:'';
            $PgHtml = (!empty($item['obj']['text']))?$item['obj']['text']:'';
            
            //Автозамена приложенных изображений и файлов img и att 
            $PgHtml = MNBVf::updateTxt($PgHtml,$item['obj']['files'],Glob::$vars['mnbv_site'],array(400,300));
            
            //Размещение контента и скрипта
            $item['page_content'] = $item['page_content2'] = '';
            if (!empty($item['obj']['vars']['scriptvalign'])&&$item['obj']['vars']['scriptvalign']=2) $item['page_content2'] = $PgHtml;
            else $item['page_content'] = $PgHtml;
            
            //Установки шаблонов дизайна
            Glob::$vars['mnbv_tpl'] = Glob::$vars['mnbv_site']['template']; //Название текущего дизайна
            //Если требуется, то установим mnbv_tpl_file и mnbv_tpl2_file
            $subTpl = (!empty($item['obj']['vars']['tpl_file']))?$item['obj']['vars']['tpl_file']:'main.php';
            $subTpl2 = (!empty($item['obj']['vars']['tpl2_file']))?$item['obj']['vars']['tpl2_file']:'main.php';
            Glob::$vars['mnbv_tpl_file'] = MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'],$subTpl);
            Glob::$vars['mnbv_tpl2_file'] = MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'],$subTpl2);
            if($subTpl!='main.php' && !file_exists(Glob::$vars['mnbv_tpl_file'])) {
                SysLogs::addError('Error: Wrong mnbv_tpl_file [' . Glob::$vars['mnbv_tpl_file'] . ']');
                Glob::$vars['mnbv_tpl_file'] = MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php');     
            }
            if($subTpl2!='main.php' && !file_exists(Glob::$vars['mnbv_tpl2_file'])) {
                SysLogs::addError('Error: Wrong mnbv_tpl2_file [' . Glob::$vars['mnbv_tp2l_file'] . ']');
                Glob::$vars['mnbv_tpl_file'] = MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php');
            }
            SysLogs::addLog('Select mnbv_tpl_file: [' . Glob::$vars['mnbv_tpl_file'] . ']');
            SysLogs::addLog('Select mnbv_tpl2_file: [' . Glob::$vars['mnbv_tpl2_file'] . ']');
            
            //Если к странице привязан скрипт, то запустим контроллер скрипта
            $subcontrollerRun = false;
            if(!empty($item['obj']['vars']['script'])){
                
                $controllerFile =  MNBVf::getRealFileName(Glob::$vars['mnbv_module'], MOD_CONTROLLERSPATH . SysBF::trueName($item['obj']['vars']['script'],'title') . 'Controller.class.php');
                if(file_exists($controllerFile)) {
                    SysLogs::addLog('Start: MNBV site subcontroller [' . $controllerFile . ']');
                    require_once MNBVf::getRealFileName(MNBV_MAINMODULE, MOD_CONTROLLERSPATH . 'AbstractMnbvsiteController.class.php'); //Подгрузим абстрактный класс контроллера
                    require_once $controllerFile;
                    $controllerName = SysBF::trueName($item['obj']['vars']['script'],'title') . "Controller";
                    $controllerObj = new $controllerName($item['obj']['vars']['script']);
                    $controllerObj->action_index($item,Glob::$vars['tpl_mode'],Glob::$vars['console']);
                    $subcontrollerRun = true;
                }else{
                    SysLogs::addError('Error: Wrong subcontroller [' . $controllerFile . ']');
                    //trigger_error('Error: Wrong subcontroller [' . $controllerFile . ']');
                }
                
            }
                  
            if (!$subcontrollerRun){ //Если скрипт не привязан, выведем контент страницы
            
                //View------------------------
                MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
            
                //Запишем конфиг и логи, если этого не произошлов в конце шаблона
                if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
                
            }
            
        }else{
            //Страница не найдена, отдадим 404 ошибку
            SysLogs::addError('Error: site page ['.Glob::$vars['mnbv_site']['pgid'].'] not found');
            MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], '404.php'),$item,$tpl_mode);
        }

    }

}
