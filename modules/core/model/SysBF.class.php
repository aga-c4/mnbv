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
     * Посылает запрос по HTTP с помощью CURL ExpertSender и возвращает ответ
     * @param array $param
     * @return mixed|string
     */
    public function sendQuery($url,$contentType,$tip_op='',$query){

        if ($tip_op == 'ImportToListTasks' || strpos($tip_op, 'Transactionals') !== FALSE){
            $soap = curl_init();
            curl_setopt($soap, CURLOPT_URL, $url . $tip_op);
            curl_setopt($soap, CURLOPT_POST, 1);
            curl_setopt($soap, CURLOPT_HEADER, 0);
            //if(getenv("REMOTE_ADDR")=="127.0.0.1"){
            curl_setopt($soap, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($soap, CURLOPT_SSL_VERIFYHOST, 0);
            //}
            curl_setopt($soap, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($soap, CURLOPT_HTTPHEADER,array('Content-Type: '.$contentType.';'));
            curl_setopt($soap, CURLOPT_POSTFIELDS, $query);
            $responce = curl_exec($soap);
            if($errno = curl_errno($soap)) {
                $responce = "ERROR: ".curl_error($soap);
                //Log::debug("API.EC => ".$errno.' : '.$responce);
            }
            curl_close($soap);
            return $responce;
        }else{
            return 'Метод API не определен';
        }

    }

    /**
     * Получает содержимое URL по https://
     * @param $url
     * @param bool $fileTo
     * @param string $refer
     * @param bool $usecookie
     * @return mixed
     */
    static public function open_https_url($url, $fileTo = false, $refer = "", $usecookie = false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //Для https
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //2); // Для https: было можно 0 или false
        curl_setopt($ch, CURLOPT_HEADER, false); //было 0
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
        if ($fileTo != false){//Дескриптор открытого файла
            curl_setopt($ch, CURLOPT_FILE, $fileTo);
        }
        if ($refer != "") {
            curl_setopt($ch, CURLOPT_REFERER, $refer );
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); //было 1
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
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
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
     * @return mixed Значение
     */
    public static function getFrArr($arr,$key,$defval=null){
        if (!is_array($arr)) return $defval;
        if (!isset($arr[$key])) return $defval;
        return $arr[$key];
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
	
}


