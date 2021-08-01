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
        if (is_array($post)&count($post)){
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

        if (isset($params['header']) && is_array($params['header'])) curl_setopt($ch, CURLOPT_HTTPHEADER, $params['header']); //Массив того, что пойдет в хедере типа array('Sign: 123', 'Key: dssdsd',...)
        if (isset($params['printheader'])) curl_setopt($ch, CURLOPT_HEADER, true); //True для вывода хедера вместе с контентом
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
    public static function checkStr($str, $type="", $lenght=0){

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
    
    public function seconds () {
        return time ();
    }

    public function milliseconds () {
        list ($msec, $sec) = explode (' ', microtime ());
        return $sec . substr ($msec, 2, 3);
    }

    public function microseconds () {
        list ($msec, $sec) = explode (' ', microtime ());
        return $sec . str_pad (substr ($msec, 2, 6), 6, '0');
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
     * @param bool $nullUpd преобразоывывать null (true по-умолчанию)
     * @return mixed Значение
     */
    public static function getFrArr($arr,$key,$defval=null,$update='',$nullUpd=true){

        if (!is_array($arr)) $result = $defval;
        elseif (!isset($arr[$key])) $result = $defval;
        else $result = $arr[$key];
        
        if ($nullUpd!==true && $result===null) return $result;

            if ($update==='intval' || $update==='int') $result = intval($result);
        elseif ($update==='floatval' || $update==='float') $result = floatval($result);
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
     * Преобразует похожие по звукам буквы
     * @param type $str
     * @return type
     */
    public static function normUpdate($str){

        $converter = array(
            "dzh" => "j",
            "cel" => "sel",
            "cem" => "sem",
            "csh" => "sh",
            "sch" => "sh",
            "ch" => "sh",
            "zh" => "g",
            "ck" => "k",
            "ph" => "f",
            "ee" => "i",
            "ai" => "i",
            "ie" => "i",
            "ia" => "a",
            "kh" => "h",
            "kk" => "k",
            "ie" => "i",
            "yu" => "u",
            "oo" => "u",
            "ou" => "u",
            "ll" => "l",
            "pp" => "p",
            "ss" => "s",
            "ie" => "i",
            "ss" => "s",
            "gg" => "g",
            "au" => "a",
            "ts" => "s",
            "ff" => "f",
            "ee" => "e",
            "nn" => "n",
            "bb" => "b",
            "eu" => "ev",
            "ae" => "ai",
            "je" => "i",
            "tt" => "t",
            "th" => "t",
            "rr" => "r",
            "wh" => "v",
        );
        $str = strtr($str, $converter);
        
        $converter = array(
            "c" => "k",
            "q" => "k",
            "w" => "v",
            "z" => "s",
            "x" => "ks",
            "e" => "i",
            "y" => "i",
        );
        return strtr($str, $converter);
    }
    
    /**
     * Преобразование строки транслита - очистка лишних символов (нормализация)
     * @param $str
     * @param string если $nozpt='zpt_ok' зяпятая остается, если 'space_ok' - пробелы остаются
     * @return mixed|string
     */
    public static function updTranslitStr($str, $nozpt='') {
        $str = self::rus2translit($str);
        $str = strtolower($str);
        $str = preg_replace('~[^-a-z0-9_, ]+~u', '_', $str);
        $str=preg_replace("/ ( )+/u"," ",$str);
        if ($nozpt!=='zpt_ok') $str = preg_replace("/,/u",'',$str);
        if ($nozpt!=='space_ok') $str = preg_replace('/ /u','',$str);
        return  trim($str, "_");
    }
    
    /**
    * Проводит нормализацию строки
    * @param string $str
    * @param string если $nozpt='zpt_ok' зяпятая остается, если 'space_ok' - пробелы остаются
    * @return int
    */
    public static function strNormalize($str, $nozpt=''){
        $result = $str;
        $result = SysBf::updTranslitStr($result, $nozpt);
        $result = preg_replace('/_/','',$result);
        $result = preg_replace('/-/','',$result);
        return $result;
    }
    
    public static function prepareSearchSth($str){
        $res = $str;
        $res=preg_replace('/<[^>]*>/'," ",$res);        
        $res=preg_replace("/</"," ",$res);
        $res=preg_replace("/>/"," ",$res);
        $res=preg_replace("/%/"," ",$res);
        $res=preg_replace("/&/"," ",$res);
        $res=preg_replace("/(\s)+/"," ",$res);
        $search=trim($str, " \t.");
        return $res;
    }
    
    /**
     * Переводит из Win1251 в UTF8
     */
    public static function Win2Utf($str){
      return iconv("CP1251", "UTF-8", $str);
    }
    
    /**
     * Переводит из UTF8 в Win1251
     */
    public static function Utf2Win($str){
      return iconv("UTF-8","CP1251", $str);
    }
    
    /**
     * Возвращает строку csv из массива
     * @param array $fields
     * @param string $delimiter
     * @param string $enclosure
     * @return string
     */
    public static function getCSVLine($fields = array(), $delimiter = ',', $enclosure = '"') {
        $str = '';
        $escape_char = '\\';
        foreach ($fields as $value) {
          if (strpos($value, $delimiter) !== false ||
              strpos($value, $enclosure) !== false ||
              strpos($value, "\n") !== false ||
              strpos($value, "\r") !== false ||
              strpos($value, "\t") !== false ||
              strpos($value, ' ') !== false) {
            $str2 = $enclosure;
            $escaped = 0;
            $len = strlen($value);
            for ($i=0;$i<$len;$i++) {
              if ($value[$i] == $escape_char) {
                $escaped = 1;
              } else if (!$escaped && $value[$i] == $enclosure) {
                $str2 .= $enclosure;
              } else {
                $escaped = 0;
              }
              $str2 .= $value[$i];
            }
            $str2 .= $enclosure;
            $str .= $str2.$delimiter;
          } else {
            $str .= $value.$delimiter;
          }
        }
        $str = substr($str,0,-1);
        $str .= "\n";
        return $str;
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

        if ((defined('APP_DEBUG_MODE') && APP_DEBUG_MODE) || $view) { //Если это ражим отладки Добавим статистику по базам данных
            
            //Статистика запросов MySQL---
            $mysqlStat = DbMysql::mysqlStat();
            SysLogs::addLog("\n---MySQL statistic: ---");
            foreach ($mysqlStat as $key=>$value){
                if (is_array($value)){
                    $counter=1;
                    foreach ($value as $mysqlQu) {
                        SysLogs::addLog("Query$counter: ".str_replace("\n",' ',$mysqlQu));
                        $counter++;
                    }
                }else{
                    SysLogs::addLog("$key: ".$value);
                }
            }
            
        }
        
        
        SysLogs::$logComplete = true;
        SysLogs::$logView = $oldLogView;

    }
    
    
    /**
     * Формирует строку типа файла для заголовка html
     * @param string $filename
     * @param array $mimeArr если задан массив, то из него берутся подстановки в порядке приоритета
     * @return mixed|string
     */
    public static function mime_content_type($filename, $mimeArr='') {

        $mime_types = array(

            'txt' => 'text/plain',
            'csv' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
        
        if (is_array($mimeArr)) {
            foreach ($mimeArr as $key => $value) {
                $mime_types[$key] = $value;
            }
        }
        
        $filenameArr = explode('.', $filename);
        $ext = strtolower(array_pop($filenameArr));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        else {
            return 'application/octet-stream';
        }
    }
    
    /**
     * Создает BAK файл на базе текущего имени файла в той же папке
     * @param type $filename
     * @return boolean результат операции
     */
    public static function createBakFile($filename){
        if (file_exists($filename)) return copy($filename,$filename.'.bak');
        return false;
    }

    /**
     * Объединяет массивы рекурсивно перезаписывая данные из $arr2 в $arr1. 
     * Если оба параметра не являются массивом - вернется null.
     * Если один из параметров - не массив, то вернется неизмененный другой параметр
     * Если элемент массив, то наложение происходит с учетом уже имеющихся в первом массиве полей.
     * Если один из параметров не является массивом, то вернется другой массив.
     * Основное назначение - обработка многоуровневых конфигов в массивах.
     * @param type $arr1
     * @param type $arr2
     * @param string $keyCreate массив значений ключей для которых массивы будут не дополняться, а перезаписываться.
     * @return type
     */
    public static function arrayRecurMerge($arr1 = null,$arr2 = null,$keyCreate=false){
        if (!is_array($arr1) && !is_array($arr2)) return null;
        if (!is_array($arr1)) return $arr2;
        if (!is_array($arr2)) return $arr1;
        
        $result = $arr1;
        if (!empty($arr2['clear_current_array'])) $result = array();  
        foreach ($arr2 as $key=>$value){
            if (is_array($value)) {
                if ($key === 'clear_current_array') continue;
                if (!isset($result[$key]) || !is_array($result[$key]) || (is_array($keyCreate)&& in_array($key, $keyCreate))) $result[$key] = $value;
                else $result[$key] = self::arrayRecurMerge($result[$key],$value);
            }else{
                $result[$key] = $value;
            }
        }
        return $result;
    }
    
    /**
    * Проверяет должен ли быть произведен запуск в текущее время.
    * @param type $ts - метка времени
    * @param type $conf - конфиг крона
    * @return bool результат проверки
    */
    public static function cronTsValidate($ts,$conf){

        if (!is_array($conf)) return false;
        //date("Y-m-d H:i:s",$ts);
        $m = intval(date("i",$ts));
        $h = intval(date("G",$ts));
        $day = intval(date("j",$ts));
        $mon = intval(date("n",$ts));
        $week = intval(date("w",$ts));

        if (isset($conf['m']) && !self::cronItemValidate($m,$conf['m'])) return false;
        if (isset($conf['h']) && !self::cronItemValidate($h,$conf['h'])) return false;
        if (isset($conf['day']) && !self::cronItemValidate($day,$conf['day'])) return false;
        if (isset($conf['mon']) && !self::cronItemValidate($mon,$conf['mon'])) return false;
        if (isset($conf['week']) && !self::cronItemValidate($week,$conf['week'])) return false;

        return true;
    }
    
    /**
    * Валидирует int по состоянию элемента Cron
    * @param int $value значение для проверки
    * @param string $confStr строка проверки элемента
    * @return bool результат проверки
    */
    public static function cronItemValidate($value,$confStr){

        $value = intval($value);
        $confStr = strval($confStr);
        
            $curItem = strval($conf['m']);
            $curArr = preg_split("/",$confStr);
            if (isset($curArr[1])) $curArr[1] = intval($curArr[1]);
            $curDelta = (!empty($curArr[1]))?$curArr[1]:1;
            if ($curArr[0]==='*' && 0===$value%$curDelta) return true;
            if (false===strpos($curArr[0],'-')){
                if (intval($curArr[0])!=$value) return false;
            }else{
                $curBorder = preg_split("/-/",$curItem);
                if (!isset($curBorder[0])){
                    $curBorder[0] = intval($curBorder[0]);
                    if ($value<$curBorder[0]) return false;
                    if (0!==$value%$curDelta) return false;
                }
                if (!isset($curBorder[1])){
                    $curBorder[1] = intval($curBorder[1]);
                    if ($value>$curBorder[1]) return false;
                    if (0!==$value%$curDelta) return false;
                }
            }

        return true;
    }
    
    /**
     * Проверяет соответствует ли IP адрес сети, из параметра $ip и сети в стандартных форматах сеть/маска
     * @param string $ipIn ip адрес
     * @param string $netIn маска сети либо числом, либо 4мя октетами
     * @return boolean результат проверки
     */
    public static function ipNetValidate($ipIn, $netIn){
	$ip = self::updateToFullIp($ipIn);
	$netArr = explode('/', $netIn);
	
	$netIn = strval($netIn);
	$netArr = explode('/', $netIn);
	$netArr[0] = self::updateToFullIp($netArr[0]);
	if (empty($netArr[0])) return false;
	if (!isset($netArr[1])) return false;
	if (false===strpos($netArr[1],'.')) $mask = long2ip(pow(2, 32)-pow(2, (32-intval($netArr[1]))));
	else $mask = self::updateToFullIp($netArr[1]);
	$net = $netArr[0];
	
	// Преобразование IP в беззнаковое десятичное целое число:
        $ipD = (int)sprintf("%u", ip2long($ip));
        $maskD = (int)sprintf("%u", ip2long($mask));
        $netD = (int)sprintf("%u", ip2long($net));

        if (($ipD & $maskD) == $netD) return true;
        else return false;
    }

    /**
     * Убирает лишние нули и пробелы из IP адреса
     * @param type $ip
     * @return string
     */
    public static function updateToFullIp($ip){
            $ip = trim($ip);
            $ipArr = explode('.', $ip);
            $counter = 0;
            $result = '';
            foreach($ipArr as $value){
                    $counter++;
                    $result .= ((!empty($result))?'.':'') . intval($value);
            }	
            for($i=$counter;$i<4;$i++) $result .= ((!empty($result)?'.':'')) . 0;
            return $result;
    }

    
}
