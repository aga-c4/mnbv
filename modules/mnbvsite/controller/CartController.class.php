<?php
/**
 * Auth Controller - контроллер авторизации
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class CartController extends AbstractMnbvsiteController {

    /**
     * Метод по-умолчанию
     * @param $item массив $item, сформированный в родительском контроллере
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($item=array(),$tpl_mode='html', $console=false){

        //Действия в рамках данного контроллера
        $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');
        switch ($act){
            case 'auth': //Авторизация  
                Glob::$vars['user'] = new MNBVUser();
                $ul = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ul'),'login');
                $fu = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'fu'),'passwd');;
                $res = Glob::$vars['user']->load(0,$ul,$fu,$sid); 
                Glob::$vars['session']->set('userid',$res);
                
                //Сделаем первоначальную установку переменных персонализации
                if (Glob::$vars['user']->get('userid')==0){//Если это пользоваетель 0
                    MNBVf::logoutOperations(); //Первоначальные установки
                }else{//Если установлен пользователь
                    MNBVf::loginOperations(); //Установки с сессией и глобальными переменными
                }
                Glob::$vars['session']->save(); //Сохраним данные сессии
                //MNBVf::redirect('/intranet/storage/'); //Редирект в корень сайта               
                break;
            
            case 'logout': //Авторизация
                Glob::$vars['session']->set('userid',0);
                Glob::$vars['user'] = new MNBVUser();
                MNBVf::logoutOperations(); //Первоначальные установки
                Glob::$vars['session']->save(); //Сохраним данные сессии
                //MNBVf::redirect('/intranet/auth/'); //Редирект в корень сайта
                break;
        }
                
        //Блок контента, который будет выводиться в шаблоне
        $item['page_sctpl'] = 'tpl_cart.php'; //Шаблон

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();

    }

}
