<?php
/**
 * Контроллер вывода списка объектов
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 24.08.17
 * Time: 00:00
 */
class EtalonMnbvsiteController extends AbstractMnbvsiteController {
    
    /**
     * Метод по-умолчанию
     * @param $item массив $item, сформированный в родительском контроллере
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($item=array(),$tpl_mode='html', $console=false){

        //Шаблон вывода списка объектов
        $item['page_sctpl'] = 'tpl_etalon.php'; //По-умолчанию
        if (!empty($item['obj']['vars']['script_tpl_file'])) $item['page_sctpl'] = $item['obj']['vars']['script_tpl_file']; //Если задан в Переменных скрипта в объекте
        SysLogs::addLog('Select mnbv script tpl file: [' . $item['page_sctpl'] . ']');

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
    
}
