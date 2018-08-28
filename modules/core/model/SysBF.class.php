<?php
/**
 * SysBF.class.php Библиотека базовых функций системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

/**
 * Библиотека базовых функций системы
 */
class SysBF {

        /**
     * Получает содержимое URL
     * @param $url
     * @param array $post массив post переменных, если не задан или не массив, то не передаем
     * @param array $params массив дополнительных параметров:
     * - useragent,
     * - refer,
     * - header (array типа array('Sign: 123', 'Key: dssdsd',...),
     * - proxy (array типа array('host'=>'145.239.92.106:3128','passwd'=>'test:test')),
     * - fileto дескриптор файла передачи результат, если надо,
     * - timeout максимальное время выполнения в секундах, если 0 или не задано, то нет ограничения
     * @return mixed
     * https://php.ru/manual/function.curl-setopt.html
     */
    static public function curl($url, $post='', $params='') {

        if (!is_array($params)) $params=array();

        $ch = curl_init();
        //Основные параметры запроса
        curl_setopt($ch, CURLOPT_URL, $url);
        if (is_array($post)){
            $post_data = http_build_query($post, '', '&');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }

        //Дополнительные параметры
        $userAgent = (isset($params['useragent']))?$params['useragent']:'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)';
        if ($userAgent != '') curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        if (isset($params['refer'])) curl_setopt($ch, CURLOPT_REFERER, $params['refer'] ); //это тот адрес, с которого обратился к странице пользователь
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //Для https - отключение проверки сертификата
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //Для https - отключение проверки общего имени в сертификате SSL
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //Следовать редиректам
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1); //Максимальное количество редиректов
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1); //TRUE для принудительного использования нового соединения вместо закэшированного.
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); //Количество секунд ожидания при попытке соединения. Используйте 0 для бесконечного ожидания.
        if (!empty($params['timeout'])) curl_setopt($ch, CURLOPT_TIMEOUT,intval($params['timeout'])); //Максимально позволенное количество секунд для выполнения cURL-функций.	

        if (isset($params['header']) && is_array($params['header'])) curl_setopt($ch, CURLOPT_HEADER, $params['header']); //Массив того, что пойдет в хедере типа array('Sign: 123', 'Key: dssdsd',...) Возможно CURLOPT_HTTPHEADER
        else curl_setopt($ch, CURLOPT_HEADER, false);
        if (!empty($params['header_out'])) curl_setopt($ch, CURLINFO_HEADER_OUT, 1); //TRUE для отслеживания строки запроса дескриптора !!!Посмотреть что это!

        if (isset($params['proxy']) && is_array($params['proxy'] && !empty($params['proxy']['host']))){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
            curl_setopt($ch, CURLOPT_PROXY, $params['proxy']['host']);
            if (!empty($params['proxy']['passwd'])) curl_setopt($ch, CURLOPT_PROXYUSERPWD, $params['proxy']['passwd']);
            curl_setopt($ch, CURLOPT_PROXYTYPE, "CURLPROXY_HTTP");
        }

        if (!empty($params['fileto']) && $params['fileto']!=false) curl_setopt($ch, CURLOPT_FILE, $params['fileto']); //Дескриптор открытого файла передачи результата

        $result =curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }
    
    /**
     * Оставляет в строке допустимые символы
     * @param type $str - входная строка
     * @param type $type - тип проверки (int,decimal,datetime,strictstr,string,text,email,on,id,routeitem,url):
     * @param type $lenght - если задано и больше 0, то количество символов в результате
     * @return string - результат операции
     */
    public static function checkStr($str,$type="",$lenght=0){

        if ($str === null) return null; //Пустые значения транслируем насквозь

        //Почитать: http://www.php.su/articles/?cat=regexp&page=004
        if ($type==="" || $type==="no") return $str;
        $res = $str;

        if($type=='int') $res = intval($res); //Целое значение или дробное с точкой
        elseif($type=='decimal') {$res = preg_replace("/[^0-9\.,\-]/","",$res);$res = str_replace(',','.',$res);} //Целое значение или дробное с точкой, TODO - возможно доработать - всегда заменять запятую на точку или наоборот
        elseif($type=='datetime') $res = preg_replace("/[^0-9\.,:\/\- ]/","",$res); //Проверка 0000-00-00 00:00:00
        elseif($type=='strictstr') $res = preg_replace("/[^0-9a-zA-Z_\-]/","",strtolower($res)); //Проверка только символы, цифры, дефис и нижнее подчеркивание с переводом в нижний регистр
        elseif($type=='minstr') $res = preg_replace("/[^0-9a-zA-Z_\-]/","",$res); //Проверка только символы, цифры, дефис и нижнее подчеркивание с переводом в нижний регистр
        elseif($type=='string') ; //Проверка для строк
        elseif($type=='stringkav') {
            $res = preg_replace("/'/","&#39;",trim($res)); //Проверка для строк с заменой кавычек на их коды символов
            $res = preg_replace("/\"/","&#34;",trim($res)); //Проверка для строк с заменой кавычек на их коды символов
            $res = preg_replace("/\r\n/"," ",trim($res));
        }
        elseif($type=='text') ; //Проверка текстовых блоков
        elseif($type=='email') {//Проверка E-Mail
            $res = strtolower(trim(pregtrim($res)));
            if (!preg_match("/^[a-zа-я0-9_-\.]{1,20}@(([a-zа-я0-9-]+\.)+(com|net|org|mil|".
                "edu|gov|arpa|info|biz|inc|name|[a-zа-я]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-".
                "9]{1,3}\.[0-9]{1,3})$/is",$res)) $res = '';
        }elseif($type=='on') $res = ('on'===strtolower($res) || 'yes'===strtolower($res) || $res==1)?1:0; //CheckBox
        elseif($type=='id') $res = preg_replace("/[^0-9a-zA-Zа-яА-ЯЁё_\-]/","",strtolower($res)); //Проверка идентификатора
        elseif($type=='routeitem') $res = preg_replace("/[^0-9a-zA-Z_\-\.]/","",strtolower(trim($res))); //элементы строки маршрутизации
        elseif ($type=='url') $res = preg_replace("/[\"']/","",trim($res));
        //if ($type=='url') $res = preg_replace("/[^0-9a-zA-Zа-яА-ЯЁё_\\/:;\.,\-\s\*\(\)\[\]]/","",strtolower(trim($res)));
        //elseif ($type=='hack') $res = preg_replace("//", '', $res);
        //$res = SafeHtml::out(htmlspecialchars(strip_tags($res), ENT_QUOTES, 'UTF-8'));
        elseif($type=='login') $res = preg_replace("/[^0-9a-zA-Zа-яА-ЯЁё_\-]/","",strtolower($res)); //Проверка идентификатора
        elseif($type=='passwd') $res = preg_replace("/[^0-9a-zA-Zа-яА-ЯЁё_\-]/","",$res); //Проверка идентификатора

        $lenght = intval($lenght);
        if ($lenght>0) $res = MNBVf::substr($res,0,$lenght);

        return $res;

    }


    // проверяет мыло и возвращает
    //  *  +1, если мыло пустое
    //  *  -1, если не пустое, но с ошибкой
    //  *  строку, если мыло верное
    //

    function checkmail($mail) {
        // режем левые символы и крайние пробелы
        $mail=trim(pregtrim($mail)); // функцию pregtrim() возьмите выше в примере
        // если пусто - выход
        if (strlen($mail)==0) return 1;
        if (!preg_match("/^[a-z0-9_-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|".
            "edu|gov|arpa|info|biz|inc|name|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-".
            "9]{1,3}\.[0-9]{1,3})$/is",$mail))
            return -1;
        return $mail;
    }


    /**
     * Получение текущего времени
     * @return float
     */
    public static function getmicrotime()
    {
        return microtime(true);
    }

    /**
     * Список файлов в директории
     * @param string $mode (dir|file|all)
     * @return array ('файл' => тип: 0-файл, 1-директория)
     */
    public static function getDirList($path,$mode='all')
    {
        $fileArr = array();
        if ($Dir_list=@opendir("$path")){
            while ($file = readdir($Dir_list)) {
                $tec_file_nam = $file;
                if ($tec_file_nam != '.' && $tec_file_nam != '..'){
                    if (is_dir("$path$tec_file_nam") && ($mode=='all' || $mode=='dir')) $fileArr["$tec_file_nam"] = 1;
                    elseif(is_dir("$path$tec_file_nam") && ($mode=='all' || $mode=='file')) $fileArr["$tec_file_nam"] = 0;
                }
            }
        }

        return $fileArr;
    }

    /**
     * При наличии в массиве $arr элемента с ключем $key выдает его значение, иначе null
     * @param array $arr массив
     * @param string $key ключ
     * @param string $defval дефолтовое значение
     * @param string $update варианты модификации результата (intval|floatval|strval|trim|strtolower|)
     * @return mixed Значение
     */
    public static function getFrArr($arr,$key,$defval=null,$update=''){

        if (!is_array($arr)) $result = $defval;
        elseif (!isset($arr[$key])) $result = $defval;
        else $result = $arr[$key];

            if ($update==='intval') $result = intval($result);
        elseif ($update==='floatval') $result = floatval($result);
        elseif ($update==='strval') $result = strval($result);
        elseif ($update==='trim') $result = trim($result);
        elseif ($update==='strtolower') $result = strtolower($result);
        elseif ($update==='strtoupper') $result = strtoupper($result);

        return $result;
    }

    /**
     * Преобразование строки в JSON в массив
     * @param $arrStr - строка в JSON
     * @return array - массив
     */
    public static function json_decode($arrStr){
        if (!empty($arrStr)) $resArr = json_decode($arrStr,true);
        if (empty($resArr)) $resArr = array();
        return $resArr;
    }

    /**
     * Формирует Glob::$vars['request'] из $_GET, потом из $_POST, потом из $argv (недоступна если register_argc_argv установлен в disabled)
     * @param bool $startFromConsole - Маркер запуска из консоли
     */
    public static function getRequest($startFromConsole=false){
        global $argv;

        foreach ($_GET as $key => $value){
            Glob::$vars['request']["$key"] = $_GET["$key"];
        }

        foreach ($_POST as $key => $value){
            Glob::$vars['request']["$key"] = $_POST["$key"];
        }

        if (isset($argv) && is_array($argv)){
            foreach ($argv as $value){
                $tecArr = preg_split("/=/", $value);
                if (isset($tecArr[0]) && $tecArr[0]!='' && isset($tecArr[1])){Glob::$vars['request']["{$tecArr[0]}"] = trim($tecArr[1]);}
            }
            Glob::$vars['console'] = true; //Если есть консольные параметры, то считаем что это вывод в консоль
        }
        if ($startFromConsole) Glob::$vars['console'] = ($startFromConsole)?true:false; //Если жестко указано, то считаем что это вывод в консоль

    }

    /**
     * Перемещает пользователя на указанный URL
     * @param string $path - URL перехода
     * @param string $rnum - номер редиректа 301,302 или ничего
     * @param bool $debug - поставить true для отключения перехода
     */
    public static function redirect($path='',$rnum='',$debug=false){

        //Редирект
        $rnum = intval($rnum);
        if ($rnum==301) { //Постоянный редирект
            header("HTTP/1.1 301 Moved Permanently");
            if (!$debug) header("Location: " . $path, true, 301);
            SysLogs::addLog('Moved Permanently (Redirect 301) to: ' . $path);
        } elseif ($rnum==302) { //Временный редирект
            header("HTTP/1.1 302 Moved Temporarily");
            if (!$debug) header("Location: " . $path, true, 302);
            SysLogs::addLog('Moved Temporarily (Redirect 302) to: ' . $path);
        } else { //Простой редирект
            if (!$debug) header("Location: " . $path);
            SysLogs::addLog('SysBF Moved (Redirect) to: ' . $path);
        }

        if (SysLogs::$logSave) SysLogs::SaveLog(); //Сохраним лог, если это требуется

        require_once APP_MODULESPATH . 'default/view/redirect.php';
        exit();

    }

    /**
     * Возвращает строку в транслите
     * @param string $string исходная строка
     * @return string строка в транслите
     */
    public static function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }

    /**
     * Создает/(перезаписывает по-умолчанию) файл, сохраняет в него данные из переменной.
     * @param string $filename полный путь к файлу
     * @param string $fileTxt переменная для записи в файл
     * @param string $mode параметр аналогичный, используемому в fopen()
     * @return bool - результат операции
     */
    public static function saveFile($filename='',$fileTxt='',$mode='w'){
	    if ($filename == '') return false;
        if ($handle = @fopen($filename,$mode)){
            if (fwrite($handle,$fileTxt)){
                fclose($handle);
            } else return false;
        } else {
            SysLogs::addError('Error: open file '.$filename. ' in ' . __FILE__);
            return false;
        }
        return true;
    }

    /**
     * Корректирует указанную строку из значения указанного массива, убирая слеши - нужно для очистки от служебных смиволов
     * @param pointer $obj - указатель на изменяемый объект
     */
    public static function stripsl(&$obj) {
        if (is_array($obj))
            foreach($obj as $k=>$v)
                strips($obj[$k]);
        else $obj = stripslashes($obj);
    }

    /**
     * Переводит значение в строку
     * @param mixed $value
     * @return string - результат операции
     */
    public static function toStr($value){
        return "$value";
    }

    /**
     * Возвращает требуемый элемент массива $_SERVER, если элемент не найден, то возвращает пустую строку
     * @param $str
     * @return string - результат операции
     */
    public static function getFrServerArr($str){
        return (!empty($_SERVER[$str]))?$_SERVER[$str]:'';
    }

    /**
     * Нормализация имени (все маленькие буквы, если form=title, то первая - большая)
     * @param string $str
     * @param string $form
     * @return string
     */
    public static function trueName($str='',$form=''){
        $str1 = trim($str);
        $result = mb_strtolower($str1,'UTF-8');
        $str1 = preg_replace("/ё/",'е', $str1);
        if ($form == 'title'){//Заглавную в верхний регистр
            $str2 = substr($str1, 0, 1);
            $str3 = substr($str1, 1, 100);
            $str2 = mb_strtoupper($str2,'UTF-8');
            $result = $str2 . $str3;
        }
        return $result;
    }

    /**
     * Переводит из CP1251 в UTF-8
     * @param $str
     * @return string
     */
    public static function wtu($str){
        return iconv("CP1251", "UTF-8", $str);
    }

    /**
     * Переводит из UTF-8 в CP1251
     * @param $str
     * @return string
     */
    public static function utw($str){
        return iconv("UTF-8","CP1251", $str);
    }

    /**
     * Записывает в лог общую статистику использования баз данных
     * @param $view true - выводить лог независимо от установки константы APP_DEBUG_MODE
     */
    public static function putFinStatToLog($view=false){

        if (SysLogs::$logComplete) return; //Разрешено отработать этому только 1 раз.

        $oldLogView = SysLogs::$logView;
        SysLogs::$logView = true;

        //Запишем в лог основные параметры работы текущего процесса
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        $memory_peak_usage = intval(memory_get_peak_usage()/1024) . 'kB';
        $memory_fin_usage = intval(memory_get_usage()/1024) . 'kB';

        SysLogs::addLog("---Fin Log: ---");
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script".'s.');
        SysLogs::addLog("Memory peak usage: $memory_peak_usage");
        SysLogs::addLog("Memory fin usage: $memory_fin_usage");

        SysLogs::$logComplete = true;
        SysLogs::$logView = $oldLogView;

    }

}


