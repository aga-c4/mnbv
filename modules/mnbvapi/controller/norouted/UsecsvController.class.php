<?php
/**
 * Usecsv Controller class - работа с csv файлами
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 26.08.14
 * Time: 00:00
 */
class UsecsvController{

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
        $this->action_help($tpl_mode, $console);//Покажем хелп
    }

    /**
     * Вывод страницы помощи
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_help($tpl_mode='html', $console=false){

        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = 'Help UseCSV'; //Метатеги
        $item = array(); //Массив данных, передаваемых во View

        $PgHtml = '
-------
UseCSV Module help:

Input Parameters:
filename=FALENAME.csv - name of csv file or directory
splitter=tab - splitter - TAB, else  ","
converter=linkconuter (default)

Controllers:
Usecsv - default controller

Actions:
help - read Help Information (default)
read - read csv file from filename

tpl_mode:
html - to view result as html file
txt  - to view result as txt file
json - to view result in json format
-------
';
        if ($tpl_mode=='html'){$PgHtml = "<pre>$PgHtml</pre>";}

        $item['page_h1'] = Glob::$vars['page_h1'];
        $item['page_content'] = $PgHtml;

        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);

	}

    /**
     * Чтение и разбор CSV файла(ов) с разделителями запятыми или табуляцией принимаются из /tmp/upl/
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_read($tpl_mode='html', $console=false){

        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = 'Read CSV file'; //Метатеги
        $item = array(); //Массив данных, передаваемых во View

        //Получим входные данные
        if (isset(Glob::$vars['request']['splitter'])){$splitter = (Glob::$vars['request']['splitter']==SysBF::trueName('tab'))?'   ':',';}
        if (isset(Glob::$vars['request']['filename'])){$filename = trim(Glob::$vars['request']['filename']);}else $filename = null;

        //Получим список csv файлов
        $csvfiles = array(); // Массив csv файлов
        if ($filename && !is_dir($filename)) {
            $csvfiles[] = $filename;
        } else { //Это директория с файлами, определим правильный путь и сформируем массив файлов
            if ($filename && is_dir($filename)) $path = $filename;
            else $path = APP_UPLPATH;

            $Dir_list=opendir($path);
            //readdir($Dir_list);//Уберем мусор
            //readdir($Dir_list);//Уберем мусор
            while ($tec_file_nam = readdir($Dir_list)) {
                if (preg_match("/\.(txt|csv)+$/",$tec_file_nam)){//Если окончание txt или csv, то добавляем данный файл к списку
                    $csvfiles[] = $path . $tec_file_nam;
                    SysLogs::addLog("CSV File: $tec_file_nam");
                }
            }
        }

        //Обработаем входные csv файлы
        $alllinks = 0;
        $allblogs = 0;
        $allbb = 0;
        $allwords = 0;
        $counter = 0;
        foreach($csvfiles as $tec_file_nam){

            if (!$file=fopen($tec_file_nam,'r')){
                SysLogs::addError("Error: File open error!");
            }else{
                $fdescr = null;
                $links = 0;
                $blogs = 0;
                $bb = 0;
                $words = 0;
                while (!feof($file)){
                    $str=trim(fgets($file, 255));
                    if (substr($str,0,1) === '#') {
                        if (!$fdescr) $fdescr = $str;
                        continue;
                    }
                    $mmm=preg_split("/	/",$str);
                    if (isset($mmm[1]) && $mmm[1]!=''){
                        $links += intval($mmm[3]);
                        $blogs += intval($mmm[4]);
                        $bb += intval($mmm[5]);
                        $words++;
                    }
                }

                SysLogs::addLog("-->File: $fdescr");
                SysLogs::addLog("--->Words: $words");
                SysLogs::addLog("--->links: $links");
                SysLogs::addLog("--->blogs: $blogs");
                SysLogs::addLog("--->bb: $bb");
                SysLogs::addLog("--->all: ".($links+$blogs+$bb));


                $alllinks += $links;
                $allblogs += $blogs;
                $allbb += $bb;
                $allwords += $words;
                $counter++;
            }

        }

        $item['page_h1'] = Glob::$vars['page_h1'];
        $item['page_content'] = "Converte complite found ".($alllinks+$allblogs+$allbb)." links in $counter files in $allwords words!\n";

        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);

    }


	
}
