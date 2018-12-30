<?php
/**
 * MNBVf.class.php Библиотека базовых функций MNBV
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVf {

    /**
     * Возвращает распознанного UserAgent и статус разрешения
     * @param $UsAgent строка, содержащая UserAgent или массив с ключами ("ua"=>"","ip"=>"")
     * @return mixed array("bot"=>"string","access"=>bool)
     */
    public function checkBots($UsAgent) {

        if (is_array($UsAgent)){ //Если входной параметр - массив, то выберем из него строку и ip, иначе это просто строка
            $userAgentStr = (!empty($UsAgent["ua"]))?$UsAgent["str"]:'';
            $ipAddr = (!empty($UsAgent["ip"]))?$UsAgent["ip"]:'';
        }else{$userAgentStr = $UsAgent;$ipAddr='';}

        $result = array("bot"=>"unknown","access"=>true);

        $botArr = array(
            "Google" => true,
            "Yandex" => true,
            "YaDirect" => true,
            "SputnikBot" => true,
            "Mail.Ru" => true,
            "bingbot" => true,
            "HostTracker" => true,
            "AhrefsBot" => true,
            "MegaIndex" => true,
            "WebIndex" => true,
        );

        $botIpArr = array(
            '217\.197\.124\.24' => "SeopultContentAnalyzer",
            '212\.158\.161\.19' => "H.Ru Yam"
        );

        foreach ($botArr as $key=>$value) if (stripos($userAgentStr, $key) !== false) {$result["bot"] = $key; $result["access"] = ($value)?true:false;}
        foreach ($botIpArr as $key=>$value) if (preg_match("$key",$ipAddr) !== false) {$result["bot"] = $value; $result["access"] = ($botArr["$value"])?true:false;}

        return result;

    }
    
    /**
     * По строке возвращаяет timestmp из заданного формата, по-умолчанию - 'Y-m-d\TH:i:s.u' (2011-01-01T15:03:01.012345)
     * @param type $str - строка со временем
     * @return type timestamp
     */
    public static function timestampFromStr($str){
        $publishDate = new DateTime($str);
        return $publishDate->getTimestamp();
    }

    /**
     * Переслать файл на ftp
     * @param string $path - папка размещения файла
     * @param string $filename - название файла
     * @param array $ftpArr - массив с параметрами ftp сервера array("server"=>"", "login"=>"", "password"=>"", "folder"=>"", "unlink"=>false)
     * @return bool резульатат операции
     */
    public static function ftpPutFile($path,$filename, $ftpArr=array("server"=>"", "login"=>"", "password"=>"", "folder"=>"", "unlink"=>false)){

        if (!empty($ftpArr["server"])) return false;
        if (!empty($ftpArr["login"])) $ftpArr["login"] = '';
        if (!empty($ftpArr["password"])) $ftpArr["password"] = '';
        if (!empty($ftpArr["folder"])) $ftpArr["folder"] = '';
        if (!empty($ftpArr["unlink"])) $ftpArr["unlink"] = false;

        if (file_exists($path.$filename)){
            $conn_id = ftp_connect($ftpArr["server"]);
            $login_result = ftp_login($conn_id, $ftpArr["login"], $ftpArr["password"]);
            if (!$conn_id || !$login_result){
                SysLogs::addError('FTP ERROR: no connection to ' . $ftpArr["server"]);
            }else{
                SysLogs::addLog('FTP: connect to ' . $ftpArr["server"]);
                SysLogs::addLog('FTP: folder ' . ftp_pwd($conn_id));

                if (!empty($ftpArr["folder"])){//Указана директория на сервере куда качать
                    if (ftp_chdir($conn_id, $ftpArr["folder"])) SysLogs::addLog('FTP: New folder ' . ftp_pwd($conn_id));
                    else  {SysLogs::addLog('FTP ERROR: change folder ' . ftp_pwd($conn_id)); return false;}
                }

                if(ftp_put($conn_id, $filename, $path.$filename, FTP_BINARY)){
                    SysLogs::addLog('FTP: put file ' . $filename . ' to server!');
                }else{
                    SysLogs::addError('FTP ERROR: can`t put file ' . $path.$filename . ' to server!');
                }

                ftp_close($conn_id);
            }
            if ($ftpArr["unlink"]) unlink($path.$filename);
        }else{
            SysLogs::addError('FTP ERROR: File ' . $path.$filename . 'not found!');
        }
    }

    /**
     * Аналог функции substr - обрезает строку в кодировке utf-8
     * @param string $str строка источник
     * @param int $start начальный символ
     * @param int $length количество символов от начального
     * @param bool $finstr - если true, то в случае обрезания добавляется многоточие (...)
     */
    public static function substr($str, $start, $length, $finstr=false){
        $res = mb_substr($str, (int)$start, (int)$length,'utf-8');
        if ($finstr && $str!=$res) $res .= '...';
        return $res;
    }
    
    /**
     * Возвращает название объекта, которое выбирается из входящего массива в зависимости от текущего, 
     * дефолтового языков, а так же маркера альтернативного язывка в списке
     * @param type $value - массив, содержащий в том числе имена объекта на разных языках
     * @param bool $altlang - маркер использования альтернативного языка
     * @param string $defval - значение, если ничего не найдено
     * @return string название хранилища на приемлемом языке
     */
    public static function getItemName($value,$altlang=false,$defval=''){
        if ($altlang && !empty($value['namelang'])) $objName = $value['namelang'];
        elseif ($altlang && !empty($value[Lang::getAltLangName()."_name"])) $objName = $value[Lang::getAltLangName()."_name"];
        elseif (!empty($value[Glob::$vars['lang']."_name"])) $objName = $value[Glob::$vars['lang']."_name"];
        elseif (!empty($value[Glob::$vars['def_lang']."_name"])) $objName = $value[Glob::$vars['def_lang']."_name"];
        elseif (!empty($value["name"])) $objName = $value["name"];
        else $objName = $defval;
        return $objName;
    }
    
    /**
     * Формирует строку с номерами страниц списка
     * @param int $list_size - полный размер списка
     * @param int $list_max_items - максимальное количество элементов на странице
     * @param int $list_page - текущая страница по-умолчанию 0
     * @param string $list_base_url - текущий URL по-умолчанию ''
     * @param string $list_get_params - текущие GET параметры без '?', по-умолчанию ''
     * @param int $centreBl - количество элементов в центральном блоке
     * @return string строка с номерами страниц типа 1...4,5,[6],7,8...11
     * @return $to_arr если 'array' то возвращается массив с номерами, который можно уже потом обработать
     */
    public static function getItemsNums($list_size,$list_max_items,$list_page=1,$list_base_url='',$list_get_params='',$centreBl=5,$to_arr=''){

        $result = '';
        $list_size = intval($list_size);
        $list_max_items = intval($list_max_items);
        $centreBl = intval($centreBl);
        $list_page = intval($list_page);
        if ($list_page<1) $list_page = 1;
        $pages = ceil($list_size / $list_max_items);
        $blockPoz = floor($centreBl / 2) + 1;
        $blockStart = $list_page - $blockPoz + 1;
        $blockEnd = $list_page + $blockPoz-1;
        
        //Условия смещения блока
        if ($blockStart<4){$blockStart = 1;$blockEnd = $centreBl+2;}
        if($blockStart>$pages-$centreBl-2){$blockEnd = $pages; $blockStart = $pages-$centreBl-1;}
        
        if ($blockStart<1) $blockStart = 1;
        if ($blockEnd>$pages) $blockEnd = $pages;
        
        //Первая страница и многоточие
        if ($list_page!=1) $result .= '<a href="'.$list_base_url.((!empty($list_get_params))?('/?'.$list_get_params):'').'">1</a>';
        else $result .= '<span style="font-weight:bold;">[1]</span>';  
        if ($blockStart>3) $result .= '...';else$result .= ',';
        
        //Блок
        for ($i=$blockStart;$i<=$blockEnd;$i++) {
            if ($i==1||$i==$pages) continue;
            if ($list_page!=$i) $result .= '<a href="'.$list_base_url.'pg'.$i.((!empty($list_get_params))?('/?'.$list_get_params):'').'">'.$i.'</a>';
            else $result .= '<span style="font-weight:bold;">['.$i.']</span>';
            if ($i!=$pages&&$i<$blockEnd) $result .= ',';
        }
        
        //Многоточие и последняя страница
        if ($blockEnd<$pages-1) $result .= '...';
        if ($list_page!=$pages) $result .= '<a href="'.$list_base_url.'pg'.$pages.((!empty($list_get_params))?('/?'.$list_get_params):'').'">'.$pages.'</a>';
        else $result .= '<span style="font-weight:bold;">['.$pages.']</span>';
        
        return $result;     
        
    }  
    
    /**
     * Посылает запрос к внешнему URL с помощью cURL и возвращает ответ
     * @param string $url - URL вызова
     * @param array $query - массив post переменных, если есть
     * @param array $param - массив параметров
     * 'headers' - массив с заголовками запроса не ассоциативный
     * 'user_agent' - строка с user-agent
     * @return mixed|string
     */
    public static function sendCurlQuery($url='',$query='', $param = array()){
        
        if (is_array($param)) {
            if (!empty($param['headers'])) $headers = $param['headers'];
            if (!empty($param['user_agent'])) $user_agent = $param['user_agent'];
        }
        
        if (empty($url)) return false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if(getenv("REMOTE_ADDR")=="127.0.0.1"){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (!empty($user_agent)) curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        else curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; SMART_API PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
        if (is_array($query)) {
            $queryJson = json_encode($query);
            //curl_setopt($soap, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $queryJson);
        }
        curl_setopt( $ch, CURLOPT_USERAGENT, "Robot" );

        //Для отладки
        //curl_setopt($ch, CURLOPT_COOKIESESSION, true); //для указания текущему сеансу начать новую "сессию"
        //curl_setopt($ch, CURLOPT_FAILONERROR, true); //для подробного отчета при неудаче 400
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //для следования любому заголовку "Location: "
        //curl_setopt($ch, CURLOPT_FORBID_REUSE, true); //для принудительного закрытия соединения после завершения
        //curl_setopt($ch, CURLOPT_FRESH_CONNECT, true); //для принудительного использования нового соединения вместо закешированного
        //curl_setopt($ch, CURLOPT_TCP_NODELAY, true); //для отключения алгоритма Нейгла, который пытается уменьшить количество мелких пакетов в сети.
        //curl_setopt($ch, CURLOPT_HEADER, true); //для включения заголовков в вывод.
        //curl_setopt($ch, CURLOPT_NOBODY, true); //для исключения тела ответа из вывода.
        //curl_setopt($ch, CURLOPT_NOSIGNAL, true); //для игнорирования любой функции cURL, посылающей сигналы PHP процессу

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); //Количество секунд ожидания при попытке соединения. Используйте 0 для бесконечного ожидания.
        //curl_setopt($soap, CURLOPT_CONNECTTIMEOUT_MS, 0); //Количество миллисекунд ожидания при попытке соединения. Используйте 0 для бесконечного ожидания.

        $responce = curl_exec($ch);
        if($errno = curl_errno($ch)) {
            $responce = "ERROR: ".curl_error($ch);
            //echo "API.EC => ".$errno.' : '.$responce . "<br>\n";
        }
        curl_close($ch);
        return $responce;
    }
    
    /**
     * Формирует строку с номерами страниц списка для сайта
     * @param array $obj массив свойств объекта, по которому формируем URL
     * @param array $param массив параметров формирования списка страниц сайта:
     * 'list_size' - полный размер списка
     * 'list_max_items' - максимальное количество элементов на странице
     * 'list_filter' - текущий фильтр, по-умолчанию ''
     * 'list_sort' - текущая сортировка, по-умолчанию ''
     * 'list_page' - текущая страница, по-умолчанию 1
     * 'centre_bl' - количество элементов в центральном блоке
     * @return string строка с номерами страниц типа 1...4,5,[6],7,8...11
     */
    public static function getSiteItemsNums(array $obj,$param=array()){

        $result = '';
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
        
        //Первая страница и многоточие
        if ($list_page!=1) $result .= '<a href="'.MNBVf::generateObjUrl($obj,array('altlang'=>Lang::isAltLang(),'sort'=>$list_sort,'pg'=>1,'type'=>'list')).'">1</a>';
        else $result .= '<span style="font-weight:bold;">[1]</span>';  
        if ($blockStart>3) $result .= '...';else$result .= ',';
        
        //Блок
        for ($i=$blockStart;$i<=$blockEnd;$i++) {
            if ($i==1||$i==$pages) continue;
            if ($list_page!=$i) $result .= '<a href="'.MNBVf::generateObjUrl($obj,array('altlang'=>Lang::isAltLang(),'sort'=>$list_sort,'pg'=>$i,'type'=>'list')).'">'.$i.'</a>';
            else $result .= '<span style="font-weight:bold;">['.$i.']</span>';
            if ($i!=$pages&&$i<$blockEnd) $result .= ',';
        }
        
        //Многоточие и последняя страница
        if ($blockEnd<$pages-1) $result .= '...';
        if ($list_page!=$pages) $result .= '<a href="'.MNBVf::generateObjUrl($obj,array('altlang'=>Lang::isAltLang(),'sort'=>$list_sort,'pg'=>$pages,'type'=>'list')).'">'.$pages.'</a>';
        else $result .= '<span style="font-weight:bold;">['.$pages.']</span>';
        
        return $result;     
        
    } 
    
    /**
     * Возвращает отформатированную строку даты с временем при необходимости если не задано форматирование, то используется ГГГГ-ММ-ДД + время если требуется
     * @param type $date Unix метка времени
     * @param type $param массив параметров:
     * 'format' строка форматирования, если задана, то применяем функцию data
     * 'mnbv_format' type1:строка типа 14 сен 1976; type1:строка типа 14.09.1976 г. - имеет приоритет перед format
     * 'time_format' - шаблон вывода времени (def для дефолтового шаблона типа "G:i"), если не задан или пуст, то время не добавляется к дате  
     * @return string
     */
    public static function getDateStr($date,$param=array()){
        $date = intval($date);
        $format = 'Y-m-d';
        $mnbv_format = '';
        $time_format = '';
        if (isset($param['format'])) $format = strtolower($param['format']);
        if (isset($param['mnbv_format'])) $mnbv_format = strtolower($param['mnbv_format']);
        if (isset($param['time_format'])) $time_format = $param['time_format'];
        if ($time_format=='def') $time_format = "G:i"; //Дефолтовый шаблон времени       
        
        $result = '';
        if (!empty($mnbv_format)){
            if ($mnbv_format=='type1') $result = date("d", $date) . ' ' . Lang::get(Glob::$vars['weeks_arr'][intval(date("m", $date))]) . ' ' . date("Y", $date);
            else $result = date("d.m.Y", $date);
                
            if (!empty($time_format)) $result .= ' ' . date($time_format, $date); //Добавим время если надо      
        }else{
            $result = date($format, $date);
        }
        
        return $result;
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
            if (!$debug && Glob::$vars['allow_redirect']) header("Location: " . $path, true, 301);
            SysLogs::addLog('Moved Permanently (Redirect 301) to: ' . $path);
        } elseif ($rnum==302) { //Временный редирект
            header("HTTP/1.1 302 Moved Temporarily");
            if (!$debug && Glob::$vars['allow_redirect']) header("Location: " . $path, true, 302);
            SysLogs::addLog('Moved Temporarily (Redirect 302) to: ' . $path);
        } else { //Простой редирект
            if (!$debug && Glob::$vars['allow_redirect']) header("Location: " . $path);
            SysLogs::addLog('MNBV Moved (Redirect) to: ' . $path);
        }

        if (isset(Glob::$vars['session']) && Glob::$vars['session'] instanceof UserSession) Glob::$vars['session']->save(); //Сохраним сессию, если это требуется
        if (SysLogs::$logSave) SysLogs::SaveLog(); //Сохраним лог, если это требуется
        
        if (!empty(Glob::$vars['mnbv_tpl'])) require_once(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'redirect.php')); //Если есть возможность, то задействуем пользовательский шаблон
        else require_once MNBV_DEF_TPL_FOLDER . 'redirect.php'; //Иначе выведем дефолтовый        
        
        exit();

    }
    
    /**
     * возвращает общую статистику использования баз данных
     */
    public static function getDBStat(){
        $result = '';

        //MySQL---
        $mysqlStat = DbMysql::mysqlStat();
        $result .= "\n---MySQL statistic: ---" . "\n";
        foreach ($mysqlStat as $key=>$value){
            if (is_array($value)){
                $counter=1;
                foreach ($value as $mysqlQu) {
                    $result .= "Query$counter: " . str_replace("\n",' ',$mysqlQu) . "\n";
                    $counter++;
                }
            }else{
                $result .= "$key: ".$value . "\n";
            }
        }
        
        return $result;
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
            //Общая статистика по работе хранилищ
            SysLogs::addLog("\n---Storage statistic: ---");
            $storageStatArr = MNBVStorage::getStat();
            foreach ($storageStatArr as $key => $value) {
                if ($value['add']['qty']+$value['set']['qty']+$value['get']['qty']+$value['del']['qty']>0){ 
                    $logStr  = ' ' . $key . ':';
                    if ($value['add']['qty']>0) $logStr  = ' add=['.$value['add']['qty'].'/'.sprintf ("%01.6f",$value['add']['time']).'s]';
                    if ($value['set']['qty']>0) $logStr .= ' set=['.$value['set']['qty'].'/'.sprintf ("%01.6f",$value['set']['time']).'s]';
                    if ($value['get']['qty']>0) $logStr .= ' get=['.$value['get']['qty'].'/'.sprintf ("%01.6f",$value['get']['time']).'s]';
                    if ($value['del']['qty']>0) $logStr .= ' del=['.$value['del']['qty'].'/'.sprintf ("%01.6f",$value['del']['time']).'s]';
                    SysLogs::addLog($logStr);
                }
            }
        
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
            
            SysLogs::$logComplete = true;
        } 
        
        SysLogs::$logView = $oldLogView;
        
    }
    

    /**
     * Проверяет соответствует ли значение шаблону типа 1,2,3,4-6... или * - для всех вариантов
     * @param $value значение
     * @param string $str шаблон
     * @return bool
     */
    public static function validateValByStr($value,$str=''){
        $str = preg_replace("/\s/",'',$str);
        if ($str=='*') return true;
        $strArr = preg_split("/,/",$str);
        foreach ($strArr as $tpl){
            if ($tpl==$value) return true;
            $tplArr = preg_split("/-/",$tpl);
            if (count($tplArr)>1 && $value>=$tplArr[0] && $value<=$tplArr[1]) return true;
        }
        return false;
    }

        
    /**
     * Выводит данные в заданном шаблоне и формате
     * @param string $tplPath - путь к шаблону дизайна
     * @param array $item - массив с входными переменными, определяющими выдачу
     * @param string $tplMode - тип вывода (html|txt|json), html по-умолчанию
     */
    public static function render($tplPath='',$item=array(),$tplMode='html'){

        //View------------------------
        switch ($tplMode) {
            case "html": //Вывод в html формате для Web
                if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/controller/render.php'))  { //При наличии локального рендера, передать управление ему
                    //Внимание, имейте в виду, что в $tplPath передается полный путь к шаблону от корня проекта, возможно будет необходимо его обрезать до корня используемого шаблонизатора
                    include (USER_MODULESPATH . MNBV_MAINMODULE . '/controller/render.php');
                }else{//В остальных случаях - используем обычные php шаблоны.
                    include $tplPath;
                }
                break;
            case "txt": //Вывод в текстовом формате для консоли
                if (!empty(Glob::$vars['mnbv_tpl'])) require_once(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'txtmain.php')); //Если есть возможность, то задействуем пользовательский шаблон
                else require_once MNBV_DEF_TPL_FOLDER . 'txtmain.php'; //Иначе выведем дефолтовый
                break;
            case "json": //Вывод в json формате
                if (!Glob::$vars['console']) header('Content-Type: text/json; charset=UTF-8');
                echo Glob::$vars['json_prefix'] . json_encode($item);
                break;
        }

    }

    /**
     * Выводит данные в заданном шаблоне и формате из шаблонов локального модуля (папка view)
     * @param string $tplPath - файл шаблона дизайна для html, если не задан, то используется main.php
     * @param array $item - массив с входными переменными, определяющими выдачу
     * @param string $tplMode - тип вывода (html|txt|json), html по-умолчанию
     */
    public static function localRender($tplPath='',$item=array(),$tplMode='html'){

        //View------------------------
        switch ($tplMode) {
            case "html": //Вывод в html формате для Web
                require_once APP_MODULESPATH . Glob::$vars['module'] . '/view/'.(!empty($tplPath))?$tplPath:'main.php';
                break;
            case "txt": //Вывод в текстовом формате для консоли
                require_once APP_MODULESPATH . Glob::$vars['module'] . '/view/txtmain.php';
                break;
            case "json": //Вывод в json формате
                if (!Glob::$vars['console']) header('Content-Type: text/json; charset=UTF-8');
                echo Glob::$vars['json_prefix'] . json_encode($item);
                break;
        }

    }

    /**
     * Подключает файл выбранным методом с предварительной проверкой его наличия. Внимание подключение происходит в
     * пространстве имен функции, соответственно глобальные переменные изначально не доступны.
     * @param type $fileName - имя файла
     * @param type $method - метод открытия
     * @return boolean статус выполнения
     */
    public static function requireFile($fileName,$method='require_once'){
        $res = false;
        if(file_exists($fileName)){
            if ($method=='require') require $fileName;
            elseif ($method=='include') include $fileName;
            else require_once $fileName;
            $res = true;
            SysLogs::addLog('Require: ' . $fileName);
        }else {SysLogs::addLog('Require Error: ' . $fileName);}
        
        return $res;
    }
    
    /**
     * Возвращает подготовленный алиас на базе входящей строки
     * @param string $string исходная строка
     * @return string алиас в транслите
     */
    public static function str2alias($str) {
        // переводим в транслит
        $str = SysBF::rus2translit($str);

        // в нижний регистр
        $str = strtolower($str);

        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);

        // удаляем начальные и конечные '-'
        $str = trim($str, "-");

        return $str;
    }
    
        /**
     * Преобразует строку, экранируя кавычки 
     * @param string $str - исходная строка
     * @return string результат операции
     */
    public static function strToHtml($str){
        $res = $str;
        $res=preg_replace('/"/',"&#34;",$res);        
        //$res=preg_replace("/`/","&#96;",$res);
        $res=preg_replace("/’/","&#39;",$res);
        $res=preg_replace("/'/","&#39;",$res);
        //$res = addslashes($res);
        return $res;
    }
    
    /**
     * Корректировка системных переменных: массива обратных ссылок и количества ссылок на основе сведений о текущем URL
     * @param type $url - URL текущей страницы
     * @return boolean статус выполнения
     */
    public static function updateBackUrl($url){
        
        //Расширения статических файлов
        $statAtt = array(
            ".htm",".htm",".css",".csv",".tsv",".js",".xml",".jpg",".gif",".bmp",".tif",
            ".ico",".png",".doc",".pdf",".xls",
        );
        $is_static = false;
        foreach($statAtt as $value)if (strripos($url,$value)!==false) $is_static = true;
        
        $size=10; if (!empty(Glob::$vars['back_url_max_num'])) $size = intval(Glob::$vars['back_url_max_num']);
        
        Glob::$vars['back_url_arr'] = array();
        if(isset(Glob::$vars['session']) && !is_array(Glob::$vars['back_url_arr'] = Glob::$vars['session']->get('back_url_arr'))) Glob::$vars['back_url_arr'] = array();
        Glob::$vars['back_url_num'] = count(Glob::$vars['back_url_arr']);
        if (Glob::$vars['back_url_num']>$size){
            $delta = Glob::$vars['back_url_num'] - intval($size);
            $res=array();
            foreach (Glob::$vars['back_url_arr'] as $key=>$value){
                if ($key>=$delta) $res[]=$value;
            }
            Glob::$vars['back_url_num'] = $size;
            Glob::$vars['back_url_arr'] = $res;
            unset($res);
        }

        Glob::$vars['back_url_last'] = '/';
        if (!$is_static){
            if (Glob::$vars['back_url_num']>0 && isset(Glob::$vars['request']['back'])){
                unset(Glob::$vars['back_url_arr'][(Glob::$vars['back_url_num']-1)]);
                if(isset(Glob::$vars['session'])) Glob::$vars['session']->set('back_url_arr',Glob::$vars['back_url_arr']);
                Glob::$vars['back_url_num']--;
                if (Glob::$vars['back_url_num']>1 && !empty(Glob::$vars['back_url_arr'][(Glob::$vars['back_url_num']-2)])) Glob::$vars['back_url_last'] = Glob::$vars['back_url_arr'][(Glob::$vars['back_url_num']-2)];
            }elseif(Glob::$vars['back_url_num']==0 || (Glob::$vars['back_url_num']>0 && Glob::$vars['back_url_arr'][(Glob::$vars['back_url_num']-1)]!=$url)) {
                if (Glob::$vars['back_url_num']>0 && !empty(Glob::$vars['back_url_arr'][(Glob::$vars['back_url_num']-1)])) Glob::$vars['back_url_last'] = Glob::$vars['back_url_arr'][(Glob::$vars['back_url_num']-1)];
                Glob::$vars['back_url_arr'][] = $url;
                if(isset(Glob::$vars['session'])) Glob::$vars['session']->set('back_url_arr',Glob::$vars['back_url_arr']);
                Glob::$vars['back_url_num']++;
            }
        }

        //foreach (Glob::$vars['back_url_arr'] as $value) SysLogs::addLog('BackUrl('.Glob::$vars['back_url_num'].'): ' . $value);
        
    }
    
    /**
     * Возвращает текущий URL страницы
     * @param $swlang если 'swlang', то вернется соотвествующий URL на другом языке в зависимости от того на каком языке сейчас идет вывод
     * @param $uri если задано, то будет подставлено в REQUEST_URI
     * @return string текущий URL
     */
    public static function requestUrl($swlang='',$uri='')
    {
        $result = ''; // Пока результат пуст
        $default_port = 80; // Порт по-умолчанию
        $realUri = (!empty($uri))?$uri:((!empty($_SERVER['REQUEST_URI']))?$_SERVER['REQUEST_URI']:'');  
        
        if (!empty(Glob::$vars['mnbv_site']['fullurl'])){ //Если требуется формировать URL с протоколом и доменом
            if ($realUri=='/') $realUri = '';

            if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
              $result .= 'https://';
              $default_port = 443;
            } else {
              $result .= 'http://';
            }
            $result .= $_SERVER['SERVER_NAME'];
            if ($_SERVER['SERVER_PORT'] != $default_port) {
              $result .= ':'.$_SERVER['SERVER_PORT'];
            }
        }
        
        if ($swlang=='swlang'){ //Необходимо URL на другом языке
            if (Lang::isDefLang()){//Для основного языка - добавим перед URI альтернативный
                $result .= '/'.Lang::getAltLangName() .$realUri;
            }else{//Для дополнительного - вырежем альтернативный из URI
                $result .= preg_replace("/^\/".Lang::getAltLangName()."/ui",'',$realUri);
            }
        }elseif ($swlang=='altlang'){ //Необходимо URL на альтернативном языке,
            $result .= '/'.Lang::getAltLangName() . preg_replace("/^\/".Lang::getAltLangName()."/ui",'',$realUri);
        }else{
            $result .= $realUri;
        }
        
        if ($result=='') $result = '/'; //По итогу пустого не должно быть, хотя бы корень.
        
        return $result;
    }
    
    /**
     * Возвращает URL текущего объекта $obj. //URL состоит из Протокол + домен + [алиас если есть] + сортировка + [страница если есть] + ? [id=Номер, если есть] [&sort=Сортирока, если задана (приоритет)] [&pg=Номер страницы списка, если задан  (приоритет)]
     * @param $obj массив свойств текущего объекта
     * @param $param параметры формирования: array('altlang'='true/false', 'sort'='', 'pg'='', 'page_main_alias'='', 'type'='list'); 
     * Если какой то элемент не задан, он не выводится. Если pg <2, то не выводится. Если sort=дефолтовый для данного раздела ($obj['list_sort']), тоже не выводится.
     * 'type'='list' - это не список и тогда работаем с родительской папкой, иначе это объект и работаем с ним
     * @return string текущий URL
     */
    public static function  generateObjUrl(array $obj, $param=array())
    {
        $result = ''; // Пока результат пуст
        $default_port = 80; // Порт по-умолчанию 
        
        if (!empty(Glob::$vars['mnbv_site']['fullurl'])){ //Если требуется формировать URL с протоколом и доменом

            if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
              $result .= 'https://';
              $default_port = 443;
            } else {
              $result .= 'http://';
            }
            $result .= $_SERVER['SERVER_NAME'];
            if ($_SERVER['SERVER_PORT'] != $default_port) {
              $result .= ':'.$_SERVER['SERVER_PORT'];
            }
        }
        
        //Формирование папок
        if (!empty($param['altlang'])) $result .= '/'.Lang::getAltLangName();
        //die(var_dump($obj['page_main_alias']));
        
        //Основной алиас
        if ($obj['type']==2){ //Если это URL, то впишем его
            $result .= (!empty($obj['typeval']))?$obj['typeval']:'';
        }else{
            
            if (!empty($obj['use_other_storage']) && !empty(SysStorage::$storage[$item['obj']['use_other_storage']]['castom_url'])){ //Если для данного хранилища надо формировать URL
                $result .= Glob::$vars['mnbv_urlmaster']->getURLById($obj['id'],$item['obj']['use_other_storage'],Glob::$vars['mnbv_site']['id']);
            }else{
                if (!empty($obj['use_other_storage']) && isset($obj['page_main_alias'])) { //Вариант с внешним хранилищем
                    $result .= $obj['page_main_alias']; //Сначала добавим корневой алиасэ
                    if (!empty($param['type']) && $param['type']=='list') { //Формируем ссылку на список
                        $result .= (!empty($obj['folder_alias']))?('/'.$obj['folder_alias']):''; //Алиас объекта
                        if ($obj['folderid']!==$obj['folder_start_id']) $result .= '/il' . $obj['folderid']; //Идентификатор объекта
                    }else{ //Формируем ссылку на объект
                        $result .= (!empty($obj['alias']))?('/'.$obj['alias']):''; //Алиас объекта
                        $result .= (($obj['type']==1)?'/il':'/io') . $obj['id']; //Идентификатор объекта или списка, если это папка
                    }
                } else { //Вариант с текущим хранилищем
                    $result .= (!empty($obj['alias']))?('/'.$obj['alias']):('/id'.$obj['id']);
                }
            }

            if (!empty(Glob::$vars['mnbv_site']['sorturl']) && !empty($param['sort']) && (empty($obj['vars']['list_sort'])||$param['sort']!=$obj['vars']['list_sort'])) $result .= '/sort_' . $param['sort']; //Если сортировка в папках
            if (!empty(Glob::$vars['mnbv_site']['pginurl']) && !empty($param['pg']) && $param['pg']>1) $result .= '/pg' . $param['pg']; //Если страницы в папках

            //Формирование параметров
            $urlParams = '';
            //if (empty($obj['alias'])) $urlParams .= (($urlParams=='')?'?':'&').'id='.$obj['id'];
            if (empty(Glob::$vars['mnbv_site']['sorturl']) && !empty($param['sort']) && (empty($obj['vars']['list_sort'])||$param['sort']!=$obj['vars']['list_sort'])) $urlParams .= (($urlParams=='')?'?':'&').'sort='.$param['sort'];
            if (empty(Glob::$vars['mnbv_site']['pginurl']) && !empty($param['pg']) && $param['pg']>1) $urlParams .= (($urlParams=='')?'?':'&').'pg='.$param['pg'];
            $result .= $urlParams;
        }
        
        if ($result=='') $result = '/';
        
        return $result;
    }

    /**
     * Если текущий протокол соответствует указанному в параметрах, то возвращает истину
     * @param type $protocol тип допустимого протокола ('//'|'http://'|'https://'), если '//', то допустимы все типы
     * @return boolean результат проверки
     */
    public static function validateRequestProtocol($protocol){
        $protocol = strtolower($protocol);
        if (empty($protocol) || $protocol=='//') return true;
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on') && $protocol=='https://') return true;
        elseif ($protocol=='http://') return true;
        return false;
    }
    
    /**
     * Возвращает массив, который можно использовать для сортировки при запросе
     * @param type $sortStr алиас сортировки
     * @return type 
     */
    public static function getSortArr($sortStr=''){
        return (isset(Glob::$vars['sort_types']["$sortStr"]))?Glob::$vars['sort_types']["$sortStr"]:array();
    }

    /**
     * Проверка на допустимость типа сортировки по алиасу
     * @param type $sortStr алиас сортировки
     * @return результат операции
     */
    public static function validateSortType($sortStr=''){
        return (isset(Glob::$vars['sort_types']["$sortStr"]))?true:false;
    }
    
    /**
     * Формирует строку хлебных крошек из массива, начиная с заданного стартового элемента
     * @param array $navArr массив хлебных крошек {'name'=>'','url'=>''}...
     * @param array $params массив параметров формирования строки: 
     * - 'start_item' стартовый элемент массива, по-умолчанию 0;
     * - 'fin_item_view'  выводить финальный элемент массива, по-умолчанию true;
     * - 'fin_link_ctive' линк на финальном элементе массива, по-умолчанию true.
     * - 'link_class' класс линка, может понадобиться при верстке
     * - 'delim' - разделитель, по-умолчанию ' / '
     * @return string сформированная строка навигации
     */
    public static function getNavStr(array $navArr, $params=array()){
        
        $startItem = 0; 
        $finItemView = true;
        $finlinkActive = true;
        $linkClass = '';
        $delim = ' / ';
        
        //Обработаем массив параметров
        if (isset($params['start_item'])) $startItem = intval($params['start_item']); 
        if (isset($params['fin_item_view'])) $finItemView = ($params['fin_item_view'])?true:false;
        if (isset($params['fin_link_ctive'])) $finlinkActive = ($params['fin_link_ctive'])?true:false;
        if (isset($params['link_class'])) $linkClass = ' class="'.$params['link_class'].'"'; 
        if (isset($params['delim'])) $delim = $params['delim']; 
    
        $navStr = $navLast = $navLastNoLink = '';
        foreach ($navArr as $key => $value) {
            if ($key>=$startItem){
                $navStr .= $navLast; //Прицепим к навигации предыдущую строку
                $navLast = $navLastNoLink = '';
                if (!empty($value['name'])) {
                    $navLast = (($navStr!='')?$delim:'') . (!empty($value['url'])?('<a href="'.$value['url'].'"'.$linkClass.'>'):'') . $value['name'] . (!empty($value['url'])?'</a>':'');
                    $navLastNoLink = (($navStr!='')?$delim:'') . $value['name'];
                }
            }
        }
        
        if ($finItemView) $navStr .= ($finlinkActive)?$navLast:$navLastNoLink; //Прицепим к навигации предыдущую строку 
        
        return $navStr;
    }

        /**
     * Служит для анализа входных данных при редактировании vars,attr,attrvals 
     * Получает реальное значение по ключу и возвращает его, если надо удалить 
     * объект, то возвращает delete.
     * @param type $realKey - название ключа
     * @param type $keyType - тип ключа в БД
     * @param type $keyViewType - тип отображения ключа
     * @param type $value - значение поля
     * @param type $prefView префиксы типа 'ob_'
     * @param type $prefKey префиксы типа 'obk_'
     * @param type $prefUpd префиксы типа 'obd_'
     * @return возвращает либо значение, либо 'delitem', если надо удалить данный объект из атрибутов
     */
    public static function updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='ob_',$prefKey='obk_', $prefUpd='obd_'){
        if ($keyViewType == '');
        elseif (($keyViewType=="datetime")&&($value=='datetime')){//Тип у данного поля datetime и его надо собрать из типовых полей
            $dateStr = SysBF::getFrArr(Glob::$vars['request'],$prefUpd.$realKey.'_date','00.00.0000');
            $dateHStr = intval(SysBF::getFrArr(Glob::$vars['request'],$prefUpd.$realKey.'_h',0));
            $dateMStr = intval(SysBF::getFrArr(Glob::$vars['request'],$prefUpd.$realKey.'_m',0));
            $dateStrArr = preg_split("/\./",$dateStr);
            $dateYYYYStr = (!empty($dateStrArr[2]))?intval($dateStrArr[2]):1970;
            $dateMMStr =   (!empty($dateStrArr[1]))?intval($dateStrArr[1]):1;
            $dateDDtr =    (!empty($dateStrArr[0]))?intval($dateStrArr[0]):1;
            if ($keyType=='int') $value = mktime($dateHStr, $dateMStr, 0, $dateMMStr, $dateDDtr, $dateYYYYStr);
            else $value = date("Y-m-d H:i:s",mktime($dateHStr, $dateMStr, 0, $dateMMStr, $dateDDtr, $dateYYYYStr));
        }elseif (($keyViewType=="date")&&($value=='date')){//Тип у данного поля date и его надо собрать из типовых полей
            $dateStr = SysBF::getFrArr(Glob::$vars['request'],$prefUpd.$realKey.'_date','00.00.0000');
            $dateStrArr = preg_split("/\./",$dateStr);
            $dateYYYYStr = (!empty($dateStrArr[2]))?intval($dateStrArr[2]):1970;
            $dateMMStr =   (!empty($dateStrArr[1]))?intval($dateStrArr[1]):1;
            $dateDDtr =    (!empty($dateStrArr[0]))?intval($dateStrArr[0]):1;
            if ($keyType=='int') $value = mktime(0, 0, 0, $dateMMStr, $dateDDtr, $dateYYYYStr);
            else $value = date("Y-m-d",mktime(0, 0, 0, $dateMMStr, $dateDDtr, $dateYYYYStr));
        }elseif ($keyViewType=="list" && $value=='list'){
            $resArr = array();
            foreach($_POST[$prefKey.$realKey] as $poz=>$keylist) if(isset($_POST[$prefUpd.$realKey][$poz]) && !in_array($keylist, $resArr)) $resArr[]=$keylist;
            if (count($resArr)>0) $value = json_encode($resArr);else $value = null;
        }elseif ($keyViewType=="checkbox" && $value=='checkbox'){
            $value = (!empty($_POST[$prefUpd.$realKey]))?1:0;
            if ($realKey==='delitem' && $value) {
                return 'delitem';
            }
        }elseif ($keyViewType=="text" && $keyType == "decimal"){
           $value = (!empty($value))?sprintf ("%01.2f", $value):'0.00';
        }
        return $value;
    }

    /**
     * Подготавливает массив настроек размеров приложенных файлов и т.п. для вывода в панели редактирования
     * @param $profile - название профиля - обычно совпадает с именем хранилища редактирование в $config
     * @param array $config - массив конфигурации обычно в конфиге modules/mnbv/config/config.php
     */
    public static function getImgMaxSize($profile,$config = array()){
        $result = array(
            'dnloadto' => 'object',         //Куда закачивать файл Варианты object - в заданный объект / tmp - в tmp папку + запись в сессию названия файла (производное от сессии) с типом
            'img_type' => 'jpg',            //Тип изображение по-умолчанию
            'img_max_w' => 600,             //Максимальная ширина базового изображения
            'img_max_h' => 600,             //Максимальная высота базового изображения
            'img_quality' => 100,           //Процент сжатия изображений
            'img_update' => 'none',         //Тим изменения по-умолчанию none. Варианты ("none" - пропорционально сжать / full - пропорционально по максимуму/"crop-top" - обрезать от верха/"crop-center" - обрезать от центра)
            'img_min_max_w' => 100,         //Максимальная ширина минииконки
            'img_min_max_h' => 100,         //Максимальная высота минииконки
            'img_min_quality' => 100,       //Процент сжатия изображений
            'img_min_update' => 'none',     //Тим изменения по-умолчанию none.
            'img_big_max_w' => 1920,        //Максимальная ширина большого изображения
            'img_big_max_h' => 1024,        //Максимальная высота большого изображения
            'img_big_quality' => 100,       //Процент сжатия изображений
            'img_big_update' => 'none',     //Тим изменения по-умолчанию none.
            'form_img_num' => 5,            //Количество изображений в панели редактирования
            'form_att_num' => 5,            //Количество приложенных файлов в панели редактирования
        );
        if (isset($config["default"]) && is_array($config["default"])) $result=$config["default"];
        if (isset($config["$profile"]) && is_array($config["$profile"])) foreach($config["$profile"] as $key=>$value) $result["$key"] = $value;
        return $result;
    }

    /**
     *
     * @param $filename
     * @return mixed|string
     */
    public static function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
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
        $filenameArr = explode('.',$filename);
        $ext = strtolower(array_pop($filenameArr));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        else {
            return 'application/octet-stream';
        }
    }

    /**
     * Берет URL любой. отрезает от него все лишнее и выделяет расширение файла
     * @param string $url
     * @return mixed
     */
    public static function getFileType($url=''){
        //1. отрежем все после ?, включая его самого и выделим расширение файла
        $filenamArr = explode('?',$url);
        $fnam1Arr = explode('.',$filenamArr[0]);
        $fnam1 = array_pop($fnam1Arr);
        $ext = strtolower($fnam1);
        if (SysBF::getFrArr(Glob::$vars['file_types'],"$ext")!==null) return $ext;
    }
    
    /**
     * Берет URL и если это ссылка на один из заданных объкетов, то подменяет его на код выдачи объекта. Если не нашлось спец объекта, то false
     * @param string $url
     * @return mixed
     */
    public static function getObjCodeByURL($url=''){
        //1. Проверка на Ютуб https://youtu.be/hSO91n7Yedc
        $res = explode('youtu.be/',$url);
        if (!empty($res[1])) return '<iframe style="style="max-width: 98%;" src="https://www.youtube.com/embed/'.$res[1].'?rel=0" frameborder="0" allowfullscreen></iframe>';
        return false;
    }
    
    /**
     * Берет URL и если это ссылка на ютубовый ролик, то возвращает массив со ссылками на разные его превьюшки, которые можно использовать.
     * @param string $url
     * @return array массив со ссылками на скрины
     */
    public static function getYoutubeScreenByURL($url=''){
        //1. Проверка на Ютуб https://youtu.be/hSO91n7Yedc
        $res = explode('youtu.be/',$url);
        $result = array();
        if (!empty($res[1])) {
            $result['iframe'] = '<iframe style="style="max-width: 98%;" src="https://www.youtube.com/embed/'.$res[1].'?rel=0" frameborder="0" allowfullscreen></iframe>';
            $result['default'] = 'http://img.youtube.com/vi/'.$res[1].'/default.jpg'; //120х90 с черными рамками если пропорции другие
            $result['hqdefault'] = 'http://img.youtube.com/vi/'.$res[1].'/hqdefault.jpg'; //480х360 4х3 с черными рамками если пропорции другие
            $result['mqdefault'] = 'http://img.youtube.com/vi/'.$res[1].'/mqdefault.jpg'; //320хКак_выйдет пропорционально без черных рамок
            $result['sddefault'] = 'http://img.youtube.com/vi/'.$res[1].'/sddefault.jpg'; //640х480 4х3 с черными рамками если пропорции другие
            $result['maxresdault'] = 'http://img.youtube.com/vi/'.$res[1].'/maxresdault.jpg'; //не показывает
            $result['mini1'] = 'http://img.youtube.com/vi/'.$res[1].'/1.jpg'; //мальнький скрин начала 120х90
            $result['mini2'] = 'http://img.youtube.com/vi/'.$res[1].'/2.jpg'; //маленький скрин середины 120х90
            $result['mini3'] = 'http://img.youtube.com/vi/'.$res[1].'/3.jpg'; //маленький скрин конца 120х90
        }
        return $result;
    }
    
    /**
     * Возвращает реальное расположение файла в 2х паралельных стурктурах модулей с учетом приоритета пользовательского модуля перед дефолтовым
     * @param type $module название модуля
     * @param type $fileName путь к файлу от папки модуля
     * @return string истинное положение файла
     */
    public static function getRealFileName($module,$fileName){
        //Приоритет - пользовательскому файлу, если в настоящий момент активирован пользовательский модуль
        if (APP_MODULESPATH != Glob::$vars['mnbv_module_path']){
            $realFileName = Glob::$vars['mnbv_module_path'].$module.'/'.$fileName;
            if (file_exists($realFileName)) return $realFileName;
        }
            
        //Если таковой не найден, то отдаем соответствующий файл из папки дефолтовых модулей без проверки
        $realFileName = APP_MODULESPATH.$module.'/'.$fileName;
        return $realFileName;
    }
    
     /**
     * Возвращает реальное расположение файла view шаблона в 2х паралельных стурктурах с учетом приоритета пользовательского размещения перед дефолтовым
     * @param type $tplName название шаблона
     * @param type $fileName путь к файлу от папки шаблона
     * @return string истинное положение файла шаблона
     */
    public static function getRealTplName($tplName,$fileName){
        //Приоритет - пользовательскому файлу
        if (MNBV_DEF_TPL_FOLDER != MNBV_TPL_FOLDER){
            $realFileName = MNBV_TPL_FOLDER . $tplName . '/' . $fileName;
            if (file_exists($realFileName)) return $realFileName;
        }
            
        //Если таковой не найден, то отдаем соответствующий файл из папки дефолтовых без проверки
        $realFileName = MNBV_DEF_TPL_FOLDER . $tplName . '/' . $fileName;
        return $realFileName;
    }
    
    /**
     * Возвращает результат выполнения виджета в строковой переменной.
     * @param type $vidget алиас виджета - обязательный параметр
     * @param type $item - массив данных шаблона, который приходит из контроллера модуля. Если не хотите передавать, можно не задавать, либо задать ''
     * @param type $param входные параметры (может быть массивом, либо переменной), если не задано, то запускается виджет без параметров
     * @param type $vidget_tpl название файла шаблона для вывода, если не задан, то используется текущий шаблон Glob::$vars['mnbv_tpl']/units/wdg_ВИДЖЕТ.php
     * @return bool результат операции
     */
    public static function startVidget($vidget,$item = array(),$param=NULL,$vidget_tpl=''){

        $vidget = SysBF::checkStr($vidget,'routeitem');
        if (!is_array($item)) $item = array();
        
        //Выбор и запуск контроллера
        $vidgetController = MNBV_PATH . MOD_WIDGETS_PATH . 'Widget' . SysBF::trueName($vidget,'title') . 'Controller.class.php';
        if (file_exists($vidgetController)) {
            require_once MNBVf::getRealFileName(MNBV_MAINMODULE, MOD_WIDGETS_PATH . 'AbstractWidgetController.class.php'); //Подгрузим абстрактный класс контроллера
            require_once $vidgetController;
            $controllerName = 'Widget' . SysBF::trueName($vidget,'title') . "Controller";
            $controllerObj = new $controllerName($vidget);
            return $controllerObj->action_index($item,$param,$vidget_tpl);
        }else{
            SysLogs::addError('Error: Wrong widget controller [' . $vidgetController . ']');
            trigger_error('Error: Wrong widget controller [' . $vidgetController . ']');
            return false;
        }
    }

    /**
     * Возвращает текущее состояние массива доступов к объектам.
     * @return array массив групп доступов, принадлежащих текущему пользователю, всегда присутствует 0
     */
    public static function getPermArr(){
        $result = array(0);
        if (isset(Glob::$vars['user'])){
            $result = Glob::$vars['user']->get('permarr');
            if (!in_array(0,$result)) $result[] = 0;
        }
        return $result;
    }

    /**
     * Возвращает текущее наличие рут статуса у пользователя
     * @return array массив групп доступов, принадлежащих текущему пользователю, всегда присутствует 0
     */
    public static function getRootStatus(){
        $result = false;
        if (isset(Glob::$vars['user'])){
            $result = (Glob::$vars['user']->get('root'))?true:false;
        }
        return $result;
    }

    /**
     * Возвращает текущее наличие рут статуса у пользователя
     * @return array массив групп доступов, принадлежащих текущему пользователю, всегда присутствует 0
     */
    public static function getViewLogsStatus(){
        $result = false;
        if (isset(Glob::$vars['user'])){
            $result = (Glob::$vars['user']->get('viewlogs'))?true:false;
        }
        return $result;
    }
    
    
    /**
     * Получает все основные данные по объекту из хранилища с учтом доступа и если задан сайт, то с учетом видимости для сайта
     * @param $storage - хранилище
     * @param $objid - объект
     * @param $params - массив параметров:
     * 'altlang' - статус altlang обычно из Glob::$vars['mnbv_altlang'];
     * 'site' - true для проверки принадлежности объекта сайту из переменной Glob::$vars['mnbv_site']['id'].'] если она не установлена, то
     * 'visible' - true для проверки по полю видимости объекта
     * 'access' - true|false проверять права доступа к объекту (по умолчанию true)
     * @return mixed - массив с параметрами объекта или null
     */
    public static function getStorageObject($storage,$objid,$params=array()){
        
        //Сформируем массив параметров--------
        $param = array(
            'altlang' => false, // статус altlang обычно из Glob::$vars['mnbv_altlang']
            'site' => false, // идентификатор сайта, если не задано или 0, то без ограничений
            'visible' => false, //для проверки по полю видимости объекта
            'access' => false, //проверять права доступа к объекту
        );
        if (isset($params['altlang'])) $param['altlang'] = (!empty($params['altlang']))?true:false;
        if (isset($params['visible'])) $param['visible'] = (!empty($params['visible']))?true:false;
        if (isset($params['access'])) $param['access'] = (!empty($params['access']))?true:false;
        if (isset($params['site'])) $param['site'] = (!empty($params['site']))?true:false;
        //-------------------------------------

        //Сведения по текущему объекту и по его родительской папке -----------------------------------------------------
        $filter = array('id','=',$objid);
        $storageRes = MNBVStorage::getObj($storage,
            array('*'),
            $filter);
        $result = ($storageRes[0]>0)?$storageRes[1]:null;

        if (!empty($storageRes[0])){//Объект для редактирования найден

            //Эти условия специально вынесены таким образом, чтоб ускорить запрос по единственному ключу, если там только id
            if ($param['visible'] && empty($result['visible'])) return null; //Проверка на видимость
            if ($param['site'] && !empty($result['siteid']) && isset(Glob::$vars['mnbv_site']['id']) && $result['siteid']!=Glob::$vars['mnbv_site']['id']) return null; //Проверка на сайт
            if ($param['access'] && !MNBVf::getRootStatus() && !in_array($result['access'], MNBVf::getPermArr())) return null; //Проверка на доступ

            //Сведения по родительской папке нужны чтоб окончательно сформировать список редактируемых полей
            $parentid = (!empty($result['parentid']))?$result['parentid']:0;
            $result['parent_name'] = $result['parent_name_min'] =  Lang::get('Root folder');

            if (empty($parentid)){
                $result['parent'] = array(
                    "id" => 0,
                    "name" => 'Корневая категория',
                    "namelang" => 'Root folder',
                    "type" => 1,
                );
                $result['parent_id'] = 0;
            }else{
                $storageRes = MNBVStorage::getObj($storage,
                    array('id','type','parentid','alias','visible','first','access','access2','name','namelang','attr','attrup','attrvals','upfolders','files'),
                    array('id','=',$parentid));
                $result['parent'] = ($storageRes[0]>0)?$storageRes[1]:null;
                $result['parent_id'] = (!empty($result['parent']['id']))?$result['parent']['id']:0;
                if (!empty($result['parent'])) {
                    $result['parent_name'] = MNBVf::getItemName($result['parent'],$param['altlang']);
                    $result['parent_name_min'] = mb_substr($result['parent_name'],0,17,'utf-8');
                    if ($result['parent_name']!=$result['parent_name_min']) $result['parent_name_min'] .= '...';
                    if (!Lang::isDefLang() && !empty($result['parent']['namelang'])) $result['parent_name'] = $result['parent']['namelang'];
                }
            }

            if (empty($result['parent']['access'])) $result['parent']['access'] = SysStorage::$storage[$storage]['access'];
            if (empty($result['parent']['access2'])) $result['parent']['access2'] = SysStorage::$storage[$storage]['access2'];

            if (!empty($result['parent']['attr'])) $result['parent']['attr'] = SysBF::json_decode($result['parent']['attr']);
            if (!empty($result['parent']['attrup'])) $result['parent']['attrup'] = SysBF::json_decode($result['parent']['attrup']);
            if (!empty($result['parent']['upfolders'])) $result['parent']['upfolders'] = SysBF::json_decode($result['parent']['upfolders']);
         

            //Сформируем данные по атрибутам из родительской папки и настройкам их вывода
            $storageRes2 = MNBVStorage::upObjInfo($result['parent'],'array','array',false);
            $result['mnbvgen'] = array();
            $result['mnbvgen']['upfolders'] = (isset($storageRes2['upfolders']))?$storageRes2['upfolders']:array(); 
            $result['mnbvgen']['attrup'] = (isset($storageRes2['attrup']))?$storageRes2['attrup']:array();  
            $result['mnbvgen']['attrviewParentId'] = $result['parent_id'];
            $attrviewArr = MNBVStorage::getAttrViewArr($result['mnbvgen']['attrup']);
            $result['attrview'] = $attrviewArr['attrview'];
            $result['attrviewmini'] = $attrviewArr['attrviewmini'];

            //Формирование полей vars,attr объекта --------------------------------------------------------------------------
            $result['vars'] = (!empty($result['vars']))?SysBF::json_decode($result['vars']):array();
            $result['attr'] = (!empty($result['attr']))?SysBF::json_decode($result['attr']):array();
            $result['attrup'] = (!empty($result['attrup']))?SysBF::json_decode($result['attrup']):array();
            $result['attrvals'] = (!empty($result['attrvals']))?SysBF::json_decode($result['attrvals']):array();

            //Поля, которые обязательно должны быть
            if (empty($result['name'])) $result['name'] = '';
            if (empty($result['about'])) $result['about'] = '';
            if (empty($result['text'])) $result['text'] = '';
            
            //Формирование полей files
            $result['files'] = (!empty($result['files']))?MNBVf::updateFilesArr($storage,$objid,$result['files']):array();
        
        }
        
        return $result;
    }
     
    /**
     * Создает объект в хранилище в заданной папке
     * @param $storage - хранилище
     * @param $parentid - идентификатор родительской папки, если не задана, то 0 
     * @param $params - массив параметров:
     * 'altlang' - статус altlang обычно из Glob::$vars['mnbv_altlang'];
     * 'siteid' - идентификатор сайта, если не задано, то без ограничений
     * @return mixed - массив с параметрами объекта или null
     */
    public static function createStorageObject($storage,$parentid=0,$params=array()){
        $thisTime = time();
        $thisDateTime = date("Y-m-d H:i:s",time($thisTime));
        
        //Сформируем массив параметров--------
        $param = array(
            'altlang' => false, // статус altlang обычно из Glob::$vars['mnbv_altlang']
            'siteid' => 0, // идентификатор сайта, если не задано или 0, то без ограничений
        );
        if (isset($params['altlang'])) $param['altlang'] = (!empty($params['altlang']))?true:false;
        if (isset($params['visible'])) $param['visible'] = (!empty($params['visible']))?true:false;
        if (isset($params['siteid'])) $param['siteid'] = intval($params['siteid']);
        //-------------------------------------
            
        //Сведения по текущему объекту и по его родительской папке -----------------------------------------------------
        $result = array(
                        "parentid"=>$parentid,
                        "pozid"=>100,
                        "visible"=>0,
                        "first"=>0,
                        "type"=>0,
                        "datestr"=>$thisDateTime,
                        "date"=>$thisTime,
 
                        "author" => Glob::$vars['user']->get('name'),
                        "createuser" => Glob::$vars['user']->get('userid'),
                        "createdate" => $thisTime,
                        "edituser" => Glob::$vars['user']->get('userid'),
                        "editdate" => $thisTime,
                        "editip" => GetEnv('REMOTE_ADDR'),
                    );

            
        //Сведения по родительской папке нужны чтоб окончательно сформировать список редактируемых полей
        $parentid = intval($parentid);
        $result['parent_name'] = $result['parent_name_min'] =  Lang::get('Root folder');

        if (empty($parentid)){
            $result['parent'] = array(
                "id" => 0,
                "name" => 'Корневая категория',
                "namelang" => 'Root folder',
            );
            $result['parent_id'] = 0;
        }else{
            $storageRes = MNBVStorage::getObjAcc($storage,
                array('id','parentid','alias','visible','first','access','access2','name','namelang','attr','attrup','attrvals','upfolders','files'),
                array('id','=',$parentid));
            $result['parent'] = ($storageRes[0]>0)?$storageRes[1]:null;
            $result['parent_id'] = (!empty($result['parent']['id']))?$result['parent']['id']:0;
            if (!empty($result['parent'])) {
                $result['parent_name'] = MNBVf::getItemName($result['parent'],$param['altlang']);
                $result['parent_name_min'] = mb_substr($result['parent_name'],0,17,'utf-8');
                if ($result['parent_name']!=$result['parent_name_min']) $result['parent_name_min'] .= '...';
                if (Lang::getLang() != Lang::getDefLang() && !empty($result['parent']['namelang'])) $result['parent_name'] = $result['parent']['namelang'];
            }
        }

        if (empty($result['parent']['access'])) $result['access'] = $result['parent']['access'] = SysStorage::$storage[$storage]['access'];
        if (empty($result['parent']['access2'])) $result['access2'] = $result['parent']['access2'] = SysStorage::$storage[$storage]['access2'];

        if (!empty($result['parent']['attr'])) $result['parent']['attr'] = SysBF::json_decode($result['parent']['attr']);
        if (!empty($result['parent']['attrup'])) $result['parent']['attrup'] = SysBF::json_decode($result['parent']['attrup']);
        if (!empty($result['parent']['upfolders'])) $result['parent']['upfolders'] = SysBF::json_decode($result['parent']['upfolders']);


        //Сформируем данные по атрибутам из родительской папки и настройкам их вывода
        $storageRes2 = MNBVStorage::upObjInfo($result['parent'],'array','array',false);
        $result['mnbvgen'] = array();
        $result['mnbvgen']['upfolders'] = (isset($storageRes2['upfolders']))?$storageRes2['upfolders']:array(); 
        $result['mnbvgen']['attrup'] = (isset($storageRes2['attrup']))?$storageRes2['attrup']:array();  
        $result['mnbvgen']['attrviewParentId'] = $result['parent_id'];
        $attrviewArr = MNBVStorage::getAttrViewArr($result['mnbvgen']['attrup']);
        $result['attrview'] = $attrviewArr['attrview'];
        $result['attrviewmini'] = $attrviewArr['attrviewmini'];

        //Формирование полей vars,attr объекта --------------------------------------------------------------------------
        $result['vars'] = (!empty($result['vars']))?SysBF::json_decode($result['vars']):array();
        $result['attr'] = (!empty($result['attr']))?SysBF::json_decode($result['attr']):array();
        $result['attrup'] = (!empty($result['attrup']))?SysBF::json_decode($result['attrup']):array();
        $result['attrvals'] = (!empty($result['attrvals']))?SysBF::json_decode($result['attrvals']):array();

        //Поля, которые обязательно должны быть
        if (empty($result['name'])) $result['name'] = '';
        if (empty($result['about'])) $result['about'] = '';
        if (empty($result['text'])) $result['text'] = '';

        //Формирование полей files
        $result['files'] = (!empty($result['files']))?MNBVf::updateFilesArr($storage,$result,$result['files']):array();
        
        return $result;
    }
    
    
    public static function addStorageObject($storage,$updateArr=array(),$parentArr=false){
        
        $thisTime = time();
        $thisDateTime = date("Y-m-d H:i:s",time($thisTime));
        
        if (!isset($updateArr['parentid'])) $updateArr['parentid'] = 0;
        if (!isset($updateArr['pozid'])) $updateArr['pozid'] = 100;
        if (!isset($updateArr['visible'])) $updateArr['visible'] = 1;
        if (!isset($updateArr['first'])) $updateArr['first'] = 0;
        if (!isset($updateArr['name'])) $updateArr['name'] = 'NoName';
        if (!isset($updateArr['type'])) $updateArr['type'] = 0;
        if (!isset($updateArr['siteid'])) $updateArr['siteid'] = 0;
        
        //Посмотрим данные родительской папки
        if (!$parentArr || !is_array($parentArr)){
            $storageRes = MNBVStorage::getObj(
                $storage,
                array("id","upfolders","attrup","attr","access","access2"),
                array("id","=",$updateArr['parentid']));
        }else{
            $storageRes=array(0=>1,1=>$parentArr);
        }
        if (!empty($storageRes[0])) {//Есть сведения о родительской папке
            $storageRes2 = $storageRes[1];
            if ($updateArr["type"]==ST_FOLDER) {
                $updateArr["upfolders"] = $storageRes2["upfolders"];
                $updateArr["attrup"] = $storageRes2["attrup"];
            }
            if (!isset($updateArr['access'])) $updateArr['access'] = $storageRes2["access"];
            if (!isset($updateArr['access2'])) $updateArr['access2'] = $storageRes2["access2"];            
        }else{//Нет сведений о родительской папке
            $updateArr["upfolders"] = '';
            $updateArr["attrup"] = '';
            $updateArr["parentid"] = 0;
            if (!isset($updateArr['access'])&&!empty(SysStorage::$storage[$storage]['access'])) $updateArr['access'] = SysStorage::$storage[$storage]['access'];
            if (!isset($updateArr['access2'])&&!empty(SysStorage::$storage[$storage]['access'])) $updateArr['access2'] = SysStorage::$storage[$storage]['access']; 
        }

        if (!empty($updateArr["vars"]) && is_array($updateArr["vars"]) && count($updateArr["vars"])>0) $updateArr["vars"] = json_encode($updateArr["vars"]);
        if (!empty($updateArr["attrvals"]) && is_array($updateArr["attrvals"]) && count($updateArr["attrvals"])>0) $updateArr["attrvals"] = json_encode($updateArr["attrvals"]);

        if (!isset($updateArr['author'])) $updateArr['author'] = Glob::$vars['user']->get('name');
        if (!isset($updateArr['createuser'])) $updateArr['createuser'] = Glob::$vars['user']->get('userid');
        if (!isset($updateArr['createdate'])) $updateArr['createdate'] = 'NoName';
        if (!isset($updateArr['edituser'])) $updateArr['edituser'] = Glob::$vars['user']->get('userid');
        if (!isset($updateArr['editdate'])) $updateArr['editdate'] = $thisTime;
        if (!isset($updateArr['editip'])) $updateArr['editip'] = GetEnv('REMOTE_ADDR');
        if (!isset($updateArr['datestr'])) $updateArr['datestr'] = $thisDateTime;
        if (!isset($updateArr['date'])) $updateArr['date'] = $thisTime;

        $res = MNBVStorage::addObj($storage, $updateArr);
        //SysLogs::addLog("Create object /".$storage."/" . (($res)?($res.'/ successful!'):' error!'));
        
        return $res;
                    
    }
    
    
    /**
     * Получает на входе строку с json массивом с данными о приложенных файлах, выполняет все преобразования и отдает его
     * @param $storage - хранилище
     * @param $objid - объект
     * @param type $filesStr json массив с данными о приложенных файлах
     * @return type
     */
    public static function updateFilesArr($storage,$objid,$filesStr=''){
        
        $filesArr = (!empty($filesStr))?SysBF::json_decode($filesStr):array();
        if (isset($filesArr['img']))  foreach ($filesArr['img'] as $key=>$value) {
            if (SysBF::getFrArr($filesArr['img'][strval($key)],'fname')) {
                    $filesArr['img'][strval($key)]['src'] = MNBVStorage::getFileName($storage,$objid,'img',$key,SysBF::getFrArr($filesArr['img'][strval($key)],'type'),'normal',SysBF::getFrArr($filesArr['img'][strval($key)],'upldate'));
                    $filesArr['img'][strval($key)]['src_min'] = MNBVStorage::getFileName($storage,$objid,'img',$key,SysBF::getFrArr($filesArr['img'][strval($key)],'type'),'min',SysBF::getFrArr($filesArr['img'][strval($key)],'upldate'));
                    $filesArr['img'][strval($key)]['src_big'] = MNBVStorage::getFileName($storage,$objid,'img',$key,SysBF::getFrArr($filesArr['img'][strval($key)],'type'),'big',SysBF::getFrArr($filesArr['img'][strval($key)],'upldate'));
            } elseif (SysBF::getFrArr($filesArr['img'][strval($key)],'url')) { 
                    $filesArr['img'][strval($key)]['src'] = SysBF::getFrArr($filesArr['img'][strval($key)],'url');
                    $filesArr['img'][strval($key)]['src_min'] = $filesArr['img'][strval($key)]['src'];
                    $filesArr['img'][strval($key)]['src_big'] = $filesArr['img'][strval($key)]['src'];
            }
            $filesArr['img'][strval($key)]['go_link'] = SysBF::getFrArr($filesArr['img'][strval($key)],'link','');
        }
        
        if (isset($filesArr['att'])) foreach ($filesArr['att'] as $key=>$value) {
            if (!empty($filesArr['att'][strval($key)]['fname'])||!empty($filesArr['att'][strval($key)]['url'])) {
                $filesArr['att'][strval($key)]['src'] = ((!empty(Glob::$vars['mnbv_site']['maindomain']))?((Glob::$vars['mnbv_site']['protocol'].Glob::$vars['mnbv_site']['maindomain'])):'') . WWW_IMGPATH . Glob::$vars['file_types'][SysBF::getFrArr($filesArr['att'][strval($key)],'type','')]['logo_big'];
            } else {
                $filesArr['att'][strval($key)]['src'] = WWW_IMGPATH . Glob::$vars['file_types']['default']['logo_big'];
            }
            $filesArr['att'][strval($key)]['go_link'] = SysBF::getFrArr($filesArr['att'][strval($key)],'url','');
            if (SysBF::getFrArr($filesArr['att'][strval($key)],'fname')) $filesArr['att'][strval($key)]['go_link'] = MNBVStorage::getFileName($storage,$objid,'att',$key,SysBF::getFrArr($filesArr['att'][strval($key)],'type'),SysBF::getFrArr($filesArr['att'][strval($key)],'upldate'));
        }
        return $filesArr;
            
    }
    
    /**
     * Производит преобразования текстовой переменной с контентом, подменяя шаблоны на ссылки на картинки и проложенные файлы
     * @param type $text исходный текст
     * @param type $mnbv_site массив с параметрами текущего сайта
     * @param type $videoSize массив, с размерами видеоролика ширина, высота
     * @return type текст - разультат
     */
    public static function updateTxt($text,$files,$mnbv_site,$videoSize=array(320,240)){
        
        $PgHtml = $text;
        
        if (is_array($mnbv_site)){
            
            //TODO - оптимизировать преобразования
            
            //Автозамена приложенных изображений и файлов img и att ----------------------------------------------------------------------------------
            $maxSizeProfile = (isset(Glob::$vars['img_max_size'][$mnbv_site['storage']]))?$mnbv_site['storage']:"default";
            $img_max_size = MNBVf::getImgMaxSize($maxSizeProfile,Glob::$vars['img_max_size']); //Массив с настройками трансформации
            $formImgNum = (isset($img_max_size["form_img_num"]))?intval($img_max_size["form_img_num"]):5; //количество изображений в панели редактирования
            $formAttNum = (isset($img_max_size["form_att_num"]))?intval($img_max_size["form_att_num"]):5; //количество приложенных файлов в панели редактирования

            for ($i=1;$i<=$formImgNum;$i++){ 

                if (isset($files["img"]["$i"]) && $tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($files["img"]["$i"],'src',''))){//Нашли специфический объект (видео, ютуб.....), выводим его 
                    $PgHtml = preg_replace("/\{\{img:".$i."\}\}/ui", '<div style="width:'.$videoSize[0].';height:'.$videoSize[1].'">'.$tecObjTxtCode.'</div>',$PgHtml);
                    $PgHtml = preg_replace("/\{\{img-left:".$i."\}\}/ui", '<div style="float:left;width:'.$videoSize[0].';height:'.$videoSize[1].'">'.$tecObjTxtCode.'</div>',$PgHtml);
                    $PgHtml = preg_replace("/\{\{img-right:".$i."\}\}/ui", '<div style="float:right;width:'.$videoSize[0].';height:'.$videoSize[1].'">'.$tecObjTxtCode.'</div>',$PgHtml);
                }elseif(!empty($files["img"]["$i"]['src'])){
                    $imgTitle = (!empty($files["img"]["$i"]["name"]))?$files["img"]["$i"]["name"]:'';
                    $imgSrc = SysBF::getFrArr($files['img']["$i"],'src','');
                    $replace1 = ((SysBF::getFrArr($files["img"]["$i"],'go_link'))?('<a href="'.$files['img']["$i"]['go_link'].'" target=_blank>'):'') . '<img src="' . $imgSrc . '" title="'.$imgTitle.'">'.((SysBF::getFrArr($files["img"]["$i"],'go_link'))?('</a>'):'');
                    $replace2 = ((SysBF::getFrArr($files["img"]["$i"],'go_link'))?('<a href="'.$files['img']["$i"]['go_link'].'" target=_blank>'):'') . '<img align=left src="' . $imgSrc . '" title="'.$imgTitle.'">'.((SysBF::getFrArr($files["img"]["$i"],'go_link'))?('</a>'):'');
                    $replace3 = ((SysBF::getFrArr($files["img"]["$i"],'go_link'))?('<a href="'.$files['img']["$i"]['go_link'].'" target=_blank>'):'') . '<img align=right src="' . $imgSrc . '" title="'.$imgTitle.'">'.((SysBF::getFrArr($files["img"]["$i"],'go_link'))?('</a>'):'');
                    $PgHtml = preg_replace("/\{\{img:".$i."\}\}/ui", $replace1, $PgHtml);
                    $PgHtml = preg_replace("/\{\{img-left:".$i."\}\}/ui", $replace2, $PgHtml);
                    $PgHtml = preg_replace("/\{\{img-right:".$i."\}\}/ui", $replace3, $PgHtml);
                }

            }

            for ($i=1;$i<=$formAttNum;$i++){ 
                if(!empty($files["att"]["$i"]['src'])){
                    $replace1 = ((SysBF::getFrArr($files["att"]["$i"],'go_link'))?('<a href="'.$files['att']["$i"]['go_link'].'" target=_blank>'):'') . '<img src="' . SysBF::getFrArr($files["att"]["$i"],'src','') . '" title="'.$imgTitle.'">'.((SysBF::getFrArr($files["att"]["$i"],'go_link'))?('</a>'):'');
                    $PgHtml = preg_replace("/\{\{att:".$i."\}\}/ui", $replace1,$PgHtml);
                }
            }
        
        }
        
        return $PgHtml;
        
    }
    
    /**
     * Установки и др. операции производимые с глобальными переменными и сессией при авторизации пользователя
     */
    public static function loginOperations(){
        //Язык интерфейса
        $userLang = Glob::$vars['user']->get('iflang');
        if (!empty($userLang)&&in_array($userLang, Lang::getLangList())) {
            Glob::$vars['lang'] = $userLang;
            Glob::$vars['session']->set('lang',Glob::$vars['lang']);
        }

        //Количество строк в таблице
        if (intval(Glob::$vars['user']->get('tablerows'))) {
            Glob::$vars['list_max_items']=intval(Glob::$vars['user']->get('tablerows'));
            Glob::$vars['session']->set('list_max_items',Glob::$vars['list_max_items']);
        }

        //Ширина шаблона
        if (Glob::$vars['user']->get('tplwidth')) {
            Glob::$vars['session']->set('intranet_width',Glob::$vars['user']->get('tplwidth'));
        } 
    }
    
    /**
     * Установки и др. операции производимые с глобальными переменными и сессией при выходе пользователя или установке первоначальных значений
     */
    public static function logoutOperations(){
        Glob::$vars['session']->del('lang');
        Glob::$vars['session']->del('list_max_items');
        Glob::$vars['session']->del('intranet_width');
        Glob::$vars['session']->del('logs_view'); //Убрал очистку этого свойства, чтоб даже разлогинившись можно было бы работать с логами
    }


    public static function listFilterGenerator($filterArr=false,$altlang=false){

        if ($filterArr==false || !is_array($filterArr)) return;
        if (empty($filterArr['storage'])) return;
        if (!isset($filterArr["filter"]) || !is_array($filterArr["filter"])) return;

        $filter = $filterArr["filter"];
        $storage = $filterArr['storage'];
        $values = array();
        if (!empty($filterArr["values"]) && is_array($filterArr["values"])) $values = $filterArr["values"];

        foreach ($filter['view'] as $flPoz=>$view){
            $key = strval($view["name"]);

            //Название, если требуется
            $tecItNameView = Lang::get($key,'sysBaseObj');
            if (!empty($view['print_name'])) $tecItNameView = Lang::get($view['print_name'],'sysBaseObj'); //Непосредственное указание имени в строке берется алиас и смотрится в указанной папке значение по языку
            if ($altlang && !empty($view["namelang"])) $tecItNameView = $view["namelang"];
            elseif (!empty($view["namedef"])) $tecItNameView = $view["namedef"];

            switch ($view['type']){
                case 'same':
                case 'like':
                case 'more':
                case 'less':
                    echo '
    <div class="fltrbl">
        <b>'.$tecItNameView.':</b> <input type="text" name="fl_'.$flPoz.'" value="'.((isset($values[$flPoz]))?$values[$flPoz]:'').'" style="width:165px;"' . ((!empty($filter["autosubmit"]))?' onchange="fltrSubmitForm();"':'') . '>
    </div>';
                    break;

                case 'select':
                    echo '
    <div class="fltrbl">
       <SELECT name="fl_'.$flPoz.'"' . ((!empty($filter["autosubmit"]))?' onClick="fltrSelForm();" onblur="fltrSelForm2();" onchange="fltrSubmitForm();"':'') . '>';

                    if (!empty($view["notset"])) echo '<OPTION value="nofltr"'.((!isset($values[$flPoz]) || null===$values[$flPoz])?' selected':'').'>'.$tecItNameView."</OPTION>\n";

                    if (is_array($view["linkstorage"])){

                        foreach($view["linkstorage"] as $slkey=>$slkeyAlias){
                            $valueStr = Lang::get($slkeyAlias);
                            echo '<OPTION value="'.$slkey.'"'.((isset($values[$flPoz]) && $slkey==$values[$flPoz])?' selected':'').'>'.((!empty($view['viewindex']))?('['.$slkey.'] '):'').$valueStr."</OPTION>\n";
                        }

                    }else{
                        $storName = ($view["linkstorage"]!='this')?$view["linkstorage"]:"$storage";
                        $paramArr = array();
                        if (isset($view["filter_folder"])) array_push($paramArr,'and','parentid','=',$view["filter_folder"]);
                        if (isset($view["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                        if (isset($view["filter_type"])&&$view["filter_type"]!=='all') {
                            array_push($paramArr,'and','type','=',($view["filter_type"]==="folders")?1:0);
                        }
                        if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                        $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                        if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                            if ($poz==0) continue;
                            $slkey=$valueArr["id"];
                            $valueStr = MNBVf::substr($valueArr[(Lang::isDefLang())?"name":"namelang"],0,50,true);
                            if ($valueStr==='') $valueStr = $valueArr["name"];
                            echo '<OPTION value="'.$slkey.'"'.((isset($values[$flPoz]) && $slkey==$values[$flPoz])?' selected':'').'>'.((!empty($view['viewindex']))?('['.$slkey.'] '):'').$valueStr."</OPTION>\n";
                        }
                    }
                    echo '</select></div>'."\n";
                    break;

                case 'submitstr':
                    echo '<div class="fltrbl"><input value="'.Lang::get(SysBF::getFrArr($view,'string','')).'" type="submit" class="submit"></div>'."\n";
                    break;
            }
        }

    }

    /**
     * Получает данные по URL с таймаутом
     * @param $URL - путь, откуда забрать данные
     * @param $timeout - время ожидания в секундах (10сек по-умолчанию)
     * @return mixed - массив с результатом, или Null, если не вышло
     */
    public static function retrieveJSON($URL,$timeout=10) {
        $timeout = intval($timeout);
        $opts = array('http' =>
            array(
                'method'  => 'GET',
                'timeout' => $timeout
            )
        );
        $context = stream_context_create($opts);
        $feed = @file_get_contents($URL, false, $context);
        if ($feed===false) {
            SysLogs::addError('File_get_contents error in URL: '.$URL);
            //SysLogs::addLog('File_get_contents error in URL:' . $URL);
            return null;
        }
        $json = json_decode($feed, true);
        if(!$json) {
            //$printFeed = '';//substr(preg_replace("/\n/", " ", $feed),0,100);
            SysLogs::addError('File_get_contents decode Error: ['. $feed .']');
        }
        return $json;
    }

    /**
     * Вывод формы редактирования свойств типового объекта
     * @param $usestorage - хранилище
     * @param array $obj - редактируемый объект
     * @param mixed $form_folder - массив, содержащий сведения о форме вывода списка параметров объекта (как это описано в storage.php)
     * @param bool $altlang - маркер альтернативного языка
     * @param string $print - если 'print' (по-умолчанию) - то непосредственный вывод, если 'array', то возвращает массив с данными  
     */
    public static function objPropGenerator($usestorage, array $obj, $form_folder='', $altlang=false, $print='print'){
        
        $result = array();

        if (is_array($form_folder)){

        foreach ($form_folder as $ffkey=>$viewArr){
            if ($ffkey=='viewonly') continue;
            if (!(empty($viewArr["lang"]) || $viewArr["lang"]=="all" || ($viewArr["lang"]=="lang" && !$altlang) || ($viewArr["lang"]=="altlang" && $altlang))) continue; //Если данное поле не подлежит выводу по текущему языку, то идем далее

            if ($viewArr["type"]=="vars") {
                foreach ($viewArr["view"] as $value) {//Выводе неиндексируемых переменых
                    //Если привязка не задана в view, то заберем ее из свойств хранилища "linkstorage"
                    if (!isset($value["linkstorage"]) && isset(SysStorage::$storage[$usestorage]['stru']['vars']['list'][$value['name']]["linkstorage"])) $value["linkstorage"] = SysStorage::$storage[$usestorage]['stru']['vars']['list'][$value['name']]["linkstorage"];
                    if (!(!isset($value["lang"]) || $value["lang"]=="all" || ($value["lang"]=="lang" && !Lang::isAltLang()) || ($value["lang"]=="altlang" && $altlang))) continue; //Если данное поле не подлежит выводу по текущему языку, то идем далее
                    if ($print=='print') MNBVf::formValsGenerator($usestorage, $obj['vars'], $value, $altlang, 'obv_', 'obvk_', 'obvd_');
                    else $result[] = MNBVf::formValsGeneratorToArr($usestorage, $obj['vars'], $value, $altlang);
                }
            }elseif (isset($obj["attrview"]) && $viewArr["type"]=="attrvals") {
                foreach ($obj["attrview"] as $value) {//Выводе неиндексируемых переменых
                    if (!(!isset($value["lang"]) || $value["lang"]=="all" || ($value["lang"]=="lang" && !Lang::isAltLang()) || ($value["lang"]=="altlang" && $altlang))) continue; //Если данное поле не подлежит выводу по текущему языку, то идем далее
                    if (empty($viewArr["viewindex"])) $value["viewindex"]=false; //В режиме просмотра - индексы не показываются, только значения
                    if (isset($viewArr["active"]) && $viewArr["active"]=="print") $value["active"]="print";
                    if ($print=='print') MNBVf::formValsGenerator($usestorage, $obj['attrvals'], $value,  $altlang, 'obav_', 'obavk_', 'obavd_',"def-lang");
                    else $result[] = MNBVf::formValsGeneratorToArr($usestorage, $obj['attrvals'], $value, $altlang,"def-lang");
                }
            }elseif (isset($obj["attrview"]) && $viewArr["type"]=="attrvalsmini") {
                foreach ($obj["attrviewmini"] as $value) {//Выводе неиндексируемых переменых укороченном
                    if (!(!isset($value["lang"]) || $value["lang"]=="all" || ($value["lang"]=="lang" && !Lang::isAltLang()) || ($value["lang"]=="altlang" && $altlang))) continue; //Если данное поле не подлежит выводу по текущему языку, то идем далее
                    if (empty($viewArr["viewindex"])) $value["viewindex"]=false;  //Управление индексами массово на уровне атрибутов
                    if (isset($viewArr["active"]) && $viewArr["active"]=="print") $value["active"]="print";
                    if ($print=='print') MNBVf::formValsGenerator($usestorage, $obj['attrvals'], $value,  $altlang, 'obav_', 'obavk_', 'obavd_',"def-lang");
                    else $result[] = MNBVf::formValsGeneratorToArr($usestorage, $obj['attrvals'], $value, $altlang,"def-lang");
                }
            }elseif ($viewArr["type"]=="attr") {//Вывод структуры атрибутов
                if (!is_array($obj['attr']))continue;

                //Вывод атрибутов более высокого уровня
                if (is_array($obj['attrup'])){
                foreach ($obj['attrup'] as $attrId=>$attrv) {//Вывод списка атрибутов
                    foreach ($viewArr["view"] as $value){//Вывод структуры атрибута
                        //Если привязка не задана в view, то заберем ее из свойств хранилища "linkstorage"
                        $value["active"] = "print"; //Режим вывода значений
                        if (!isset($value["linkstorage"]) && isset(SysStorage::$storage[Glob::$vars['mnbv_usestorage']]['stru']['attr']['list'][$value['name']]["linkstorage"])) $value["linkstorage"] = SysStorage::$storage[Glob::$vars['mnbv_usestorage']]['stru']['attr']['list'][$value['name']]["linkstorage"];
                        if (!(!isset($value["lang"]) || $value["lang"]=="all" || ($value["lang"]=="lang" && !Lang::isAltLang()) || ($value["lang"]=="altlang" && $altlang))) continue; //Если данное поле не подлежит выводу по текущему языку, то идем далее
                        if ($print=='print') MNBVf::formValsGenerator($usestorage, ((is_array($attrv))?$attrv:array()), $value,  $altlang, 'oba_'.$attrId.'_', 'obak_'.$attrId.'_', 'obad_'.$attrId.'_');
                        else return MNBVf::formValsGeneratorToArr($usestorage, ((is_array($attrv))?$attrv:array()), $value, $altlang);
                    }
                    if ($print=='print') MNBVf::formValsGenerator($usestorage, $obj, array("type"=>"lineblock", "table"=>"thline", "string"=>""),  $altlang, 'oba_add_', 'obak_add_', 'obad_add_');
                    else $result[] = MNBVf::formValsGeneratorToArr($usestorage, $obj, array("type"=>"lineblock", "table"=>"thline", "string"=>""), $altlang);
                }
                }

                //Вывод списка атрибутов текущего уровня
                if (is_array($obj['attr'])){
                    foreach ($obj['attr'] as $attrId=>$attrv) {
                        foreach ($viewArr["view"] as $value){//Вывод структуры атрибута
                            //Если привязка не задана в view, то заберем ее из свойств хранилища "linkstorage"
                            if (!isset($value["linkstorage"]) && isset(SysStorage::$storage[Glob::$vars['mnbv_usestorage']]['stru']['attr']['list'][$value['name']]["linkstorage"])) $value["linkstorage"] = SysStorage::$storage[Glob::$vars['mnbv_usestorage']]['stru']['attr']['list'][$value['name']]["linkstorage"];
                            if (!(!isset($value["lang"]) || $value["lang"]=="all" || ($value["lang"]=="lang" && !Lang::isAltLang()) || ($value["lang"]=="altlang" && $altlang))) continue; //Если данное поле не подлежит выводу по текущему языку, то идем далее
                            if ($print=='print') MNBVf::formValsGenerator($usestorage, ((is_array($attrv))?$attrv:array()), $value,  $altlang, 'oba_'.$attrId.'_', 'obak_'.$attrId.'_', 'obad_'.$attrId.'_');
                            else return MNBVf::formValsGeneratorToArr($usestorage, ((is_array($attrv))?$attrv:array()), $value, $altlang);
                        }
                        if ($print=='print') MNBVf::formValsGenerator($usestorage, $obj, array("type"=>"lineblock", "table"=>"thline", "string"=>""),  $altlang, 'oba_add_', 'obak_add_', 'obad_add_');
                        else $result[] = MNBVf::formValsGeneratorToArr($usestorage, $obj, array("type"=>"lineblock", "table"=>"thline", "string"=>""), $altlang);
                    }
                }

                //Добавление атрибута
                if ($print=='print') MNBVf::formValsGenerator($usestorage, $obj, array("type"=>"lineblock", "table"=>"thline", "string"=>"Folder object attributes add"),  $altlang, 'oba_add_', 'obak_add_', 'obad_add_');
                else MNBVf::formValsGeneratorToArr($usestorage, $obj, array("type"=>"lineblock", "table"=>"thline", "string"=>"Folder object attributes add"), $altlang);
                foreach ($viewArr["view"] as $key=>$value){//Вывод структуры атрибута
                    //Если привязка не задана в view, то заберем ее из свойств хранилища "linkstorage"
                    if (!isset($value["linkstorage"]) && isset(SysStorage::$storage[Glob::$vars['mnbv_usestorage']]['stru']['attr']['list'][$value['name']]["linkstorage"])) $value["linkstorage"] = SysStorage::$storage[Glob::$vars['mnbv_usestorage']]['stru']['attr']['list'][$value['name']]["linkstorage"];
                    if (!(!isset($value["lang"]) || $value["lang"]=="all" || ($value["lang"]=="lang" && !Lang::isAltLang()) || ($value["lang"]=="altlang" && $altlang))) continue; //Если данное поле не подлежит выводу по текущему языку, то идем далее
                    if ($key==='delitem') continue; //Не выгружаем, если это маркер удаления атрбута
                    if ($print=='print') MNBVf::formValsGenerator($usestorage, array(), $value, $altlang, 'oba_add_', 'obak_add_', 'obad_add_');
                    else $result[] = MNBVf::formValsGeneratorToArr($usestorage, array(), $value, $altlang);
                }

            }else{
                //Если привязка не задана в view, то заберем ее из свойств хранилища "linkstorage"
                if (!isset($viewArr["linkstorage"]) && isset(SysStorage::$storage[$usestorage]['stru'][$viewArr['name']]["linkstorage"])) $viewArr["linkstorage"] = SysStorage::$storage[$usestorage]['stru'][$viewArr['name']]["linkstorage"];
                if ($print=='print') MNBVf::formValsGenerator($usestorage, $obj, $viewArr, $altlang, 'ob_', 'obk_', 'obd_');
                else $result[] = MNBVf::formValsGeneratorToArr($usestorage, $obj, $viewArr, $altlang);
            }
        }

        }
        
        return $result;
        
    }

    /**
     * Получает данные из файла и возвращает его часть в соответствии с параметрами
     * @param $filename название файла от корня проекта
     * @param array $param массив параметров:
     * 'upd_tags' - если true, то заменяем <> на коды символов чтоб они вывелись в html шаблоне
     * 'last_line' - int количество последних строк для вывода, если не задано, то выводим все
     * 'pre' - true чтоб поменять перевод строки на <br>
     * @return string результат операции
     */
    public static function file_get_contents($filename,$param=array()){
        $result = file_get_contents($filename);
        if (is_array($param)){
            if (!empty($param['num_line'])) {
                $last_line = intval($param['num_line']);
                $resArr = preg_split("/\n/",$result);
                $colLine = count($resArr);

                if ($colLine>$last_line) {//Надо обрезать
                    if (!empty($param['crop_type'])&&$param['crop_type']=='top'){//Верхние строки
                        for($i=$last_line+1;$i<$colLine;$i++) unset($resArr[$i]);
                    }else{//Нижние строки
                        $start = $colLine - $last_line - 1;
                        for($i=0;$i<$start;$i++) unset($resArr[$i]);
                    }
                }
                $result = implode("\n",$resArr);
            }
            if (!empty($param['upd_tags'])) $result = preg_replace(array('/</','/>/'),array('&lt;','&gt;'),$result);
            if (!empty($param['pre'])) $result = str_replace("\n",'<br>',$result);
        }
        return $result;
    }
    
    /**
     * Вывод поля формы редактирования свойств типового объекта
     * @param $usestorage - хранилище
     * @param array $obj - редактируемый объект
     * @param array $viewArr - массив, содержащий сведения о стурктуре объекта и его выводе
     * @param bool $altlang - маркер альтернативного языка
     * @param string $prefView - префикс названия ключа объекта
     * @param string $prefKey - префикс вложенного ключа объекта (переменные, атрибуты, свойства атрибутов)
     * @param string $prefUpd - префикс данных вложенных ключей объектов
     * @param string $nameFr - как формировать имя "name" из соответствующего поля (по-умолчанию), "def-lang" из специальных полей "namedef" и "namelang"
     */
    public static function formValsGenerator($usestorage, array $obj, array $viewArr, $altlang=false, $prefView='ob_',$prefKey='obk_', $prefUpd='obd_', $nameFr = "name"){

        $pgid = SysBF::getFrArr($obj,'id',0); //Id данного объекта
        $vKey = (!empty($viewArr["name"]))?$viewArr["name"]:'clear'; //Название поля хранилища

        if (!isset($viewArr["active"])) $viewArr["active"] = "update";

        //Вид строки
        $delimStr = $colspanStr = $disablStr = $tdStr = $tdStr2 = $styleStr = $sizeStr = $rowsStr = $styleStr = '';

        if (!empty($viewArr["style"])) $styleStr = ' style="'. $viewArr["style"] .'"';

        if (!empty($viewArr["table"]) && ($viewArr["table"]=="tdline" || $viewArr["table"]=="thline")) $colspanStr = ' colspan="2"';
        if (!empty($viewArr["table"]) && ($viewArr["table"]=="th" || $viewArr["table"]=="thline")) {$tdStr = '<th class="line"'.$styleStr; $tdStr2 = '</th>';} else {$tdStr = '<td'.$styleStr; $tdStr2 = '</td>';}
        if (!empty($viewArr["width"])) $styleStr = ' style="width: '.$viewArr["width"].';"';
        if (!empty($viewArr["size"])) $sizeStr = ' size="'.$viewArr["size"].'"';
        if (!empty($viewArr["rows"])) $rowsStr = ' rows="'.((intval($viewArr["rows"]))?intval($viewArr["rows"]):5).'"';
        if (!empty($viewArr["active"]) && $viewArr["active"]=='noupdate') $disablStr = ' disabled';
        if (!empty($viewArr["delim"])) $delimStr = $viewArr["delim"];
        if (!empty($viewArr["viewindex"])) $viewindex = true; else $viewindex = false;

        //Название, если требуется
        $tecItNameView = Lang::get($vKey,(!empty($viewArr['print_folder']))?$viewArr['print_folder']:'sysBaseObj');
        if ($nameFr == "def-lang"){
            if (!empty($viewArr["namedef"])) $tecItNameView = $viewArr["namedef"];
            if (!Lang::isDefLang() && !empty($viewArr["namelang"])) $tecItNameView = $viewArr["namelang"];
        }
        if (!empty($viewArr['print_name'])){//Непосредственное указание имени в строке берется алиас и смотрится в указанной папке значение по языку
            $tecItNameView = Lang::get($viewArr['print_name'],(!empty($viewArr['print_folder']))?$viewArr['print_folder']:'sysBaseObj');
        }
        
        if ($viewArr["type"]!="refresh") echo '<tr>'.$tdStr.$colspanStr.(($colspanStr=='')?('>'.$tecItNameView.$tdStr2.$tdStr):'').'>';

        if($viewArr["type"]=="lineblock") echo Lang::get(SysBF::getFrArr($viewArr,'string',''));
        elseif($viewArr["type"]=="submitstr") echo '<input class="bigsubmit_vid" value="'.Lang::get(SysBF::getFrArr($viewArr,'string','')).'" type="submit">';
        elseif($viewArr["type"]=="int") {
            if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,$vKey,''); //Это просто вывод данных
            else echo '<input type="text" name="'.$prefView.$vKey.'" value="'.SysBF::getFrArr($obj,$vKey,'').'"'.$styleStr.$sizeStr.$disablStr.'>';
        }elseif($viewArr["type"]=="checkbox"){
            $realVal = SysBF::getFrArr($obj,$vKey,0);
            if ($viewArr["active"]=="print") echo (!empty($realVal))?'<span style="color:green;font-weight:bold;">On</span>':'<span style="color:red;font-weight:bold;">Off</span>'; //Это просто вывод данных
            else echo '<input type="checkbox" name="'.$prefUpd.$vKey.'"'.((!empty($realVal))?' checked':'').''.$disablStr.'><input type="hidden" name="'.$prefView.$vKey.'" value="checkbox">';
        }elseif($viewArr["type"]=="text") {
            if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,$vKey,''); //Это просто вывод данных
            else echo '<input type="text" name="'.$prefView.$vKey.'" value="'.MNBVf::strToHtml(SysBF::getFrArr($obj,$vKey,'')).'"'.$styleStr.$sizeStr.$disablStr.'>';
        }elseif($viewArr["type"]=="password") {
            if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,$vKey,''); //Это просто вывод данных
            else echo '<input type="password" name="'.$prefView.$vKey.'" value="'.MNBVf::strToHtml(SysBF::getFrArr($obj,$vKey,'')).'"'.$styleStr.$sizeStr.$disablStr.'>';
        }elseif($viewArr["type"]=="passwdscr") {
            if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,$vKey,''); //Это просто вывод данных
            else echo '<script type="text/javascript" src="/src/mnbv/js/md5-min.js"></script><input type="hidden" name="'.$prefView.$vKey.'"><input type="password" name="fp" value=""'.$styleStr.$sizeStr.$disablStr.' onChange="if (document.edit.fp.value != \'\'){ document.edit.'.$prefView.$vKey.'.value=hex_md5(document.edit.fp.value);}else{document.edit.'.$prefView.$vKey.'.value=\'\';}">';
        }elseif($viewArr["type"]=="textarea") {//Текстовый блок
            if ($viewArr["active"]=="print") { //Это просто вывод данных
                //В этом режиме может происходить не только отображение текста из данного объекта, но и отображение текста из заданного файла от корня проекта.
                if (!empty($viewArr["frfile"])){
                    $kolRows = !empty($viewArr["rows"])?$viewArr["rows"]:25;
                    $frFile = str_replace('[obj_id]',$pgid,$viewArr["frfile"]); //data/storage_files/zbpairs/att/p[obj_id]_1.txt
                    $frFileJQ = str_replace('data/storage_files/','',$frFile);
                    $rowstypeStr = (!empty($viewArr["croptype"])&&$viewArr["croptype"]=='top')?'&croptype=top':'';
                    $frFileStr = ''; //MNBVf::file_get_contents($frFile,array('upd_tags'=>true,'last_line'=>$kolRows));
                    if (!empty($viewArr["pre"]))  $frFileStr = str_replace("\n",'<br>', $frFileStr);
                    echo '<div id="'.$prefView.$vKey.'">'.$frFileStr.'</div>';

                    if (!empty($viewArr["timeout"])){//Если задан этот параметр то будет обновляться по ajax раз в это количество секунд.
                        $timeout = 1000 * intval($viewArr["timeout"]);
                        if ($timeout==0) $timeout = 1000;
                        ?>
                        <script>
                            $(document).ready(function(){
                                setInterval(function(){
                                    $.ajax({
                                        url: "/sdata/<?=$frFileJQ;?>?rows=<?=$kolRows.$rowstypeStr;?>",
                                        cache: false,
                                        success: function(html){
                                            $("#<?=$prefView.$vKey;?>").html(html);
                                        }
                                    });
                                },<?=$timeout;?>);
                            });
                        </script>
                    <?
                    }
                }else{
                    if (!empty($viewArr["pre"])) echo "<pre>";
                    echo SysBF::getFrArr($obj,$vKey,'');
                    if (!empty($viewArr["pre"])) echo "</pre>";
                }
            }
            else {
                if (Glob::$vars['def_text_editor']=='tmce' && !empty($viewArr["editor"]) && $viewArr["editor"]==true){
                    //$edit_text1=str_replace("\r\n","&#13;",$row->text1);
                    ?>

                    <span style="float: right;">
<b><?=Lang::get("Insert pictures");?>:&nbsp;&nbsp;&nbsp;</B>
<img src="<?=WWW_IMGPATH;?>admin/img1l.gif" alt="<?=Lang::get("Insert picture");?>1 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:1}}');">
<img src="<?=WWW_IMGPATH;?>admin/img2l.gif" alt="<?=Lang::get("Insert picture");?>2 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:2}}');">
<img src="<?=WWW_IMGPATH;?>admin/img3l.gif" alt="<?=Lang::get("Insert picture");?>3 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:3}}');">
<img src="<?=WWW_IMGPATH;?>admin/img4l.gif" alt="<?=Lang::get("Insert picture");?>4 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:4}}');">
<img src="<?=WWW_IMGPATH;?>admin/img5l.gif" alt="<?=Lang::get("Insert picture");?>5 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:5}}');">

<img src="<?=WWW_IMGPATH;?>admin/img1.gif" alt="<?=Lang::get("Insert picture");?>1" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:1}}');">
<img src="<?=WWW_IMGPATH;?>admin/img2.gif" alt="<?=Lang::get("Insert picture");?>2" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:2}}');">
<img src="<?=WWW_IMGPATH;?>admin/img3.gif" alt="<?=Lang::get("Insert picture");?>3" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:3}}');">
<img src="<?=WWW_IMGPATH;?>admin/img4.gif" alt="<?=Lang::get("Insert picture");?>4" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:4}}');">
<img src="<?=WWW_IMGPATH;?>admin/img5.gif" alt="<?=Lang::get("Insert picture");?>5" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:5}}');">

<img src="<?=WWW_IMGPATH;?>admin/img1r.gif" alt="<?=Lang::get("Insert picture");?>1 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:1}}');">
<img src="<?=WWW_IMGPATH;?>admin/img2r.gif" alt="<?=Lang::get("Insert picture");?>2 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:2}}');">
<img src="<?=WWW_IMGPATH;?>admin/img3r.gif" alt="<?=Lang::get("Insert picture");?>3 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:3}}');">
<img src="<?=WWW_IMGPATH;?>admin/img4r.gif" alt="<?=Lang::get("Insert picture");?>4 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:4}}');">
<img src="<?=WWW_IMGPATH;?>admin/img5r.gif" alt="<?=Lang::get("Insert picture");?>5 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:5}}');">
<!--&nbsp;&nbsp;<img src="<?=WWW_IMGPATH;?>admin/br.gif" alt='Вставить BR' onclick="tinyMCE.execCommand('mceInsertContent',false,'<br>');">-->
&nbsp;
</span>
                    <?=Lang::get($vKey,'sysBaseObj');?>
                    </th>
                    </tr>
                    <tr>
                    <th class="line" colspan=2>
                    <textarea id="<?=$prefView.$vKey;?>" name="<?=$prefView.$vKey;?>" rows="<?=SysBF::getFrArr($viewArr,'rows',5);?>" cols="80" style="width: 100%;"<?=$disablStr;?>><?=SysBF::getFrArr($obj,$vKey,'');?></textarea>
<span style="float: right;">
    <a href="javascript:;" onmousedown="tinyMCE.get('<?=$prefView.$vKey;?>').show();">[Show]</a>
    <a href="javascript:;" onmousedown="tinyMCE.get('<?=$prefView.$vKey;?>').hide();">[Hide]</a>
</span>
                <?php
                }else{
                    echo '<span style="font-weight:bold;">'.$tecItNameView.'</span><br><textarea class="no-tiny" rows="'.SysBF::getFrArr($viewArr,'rows',5).'" type="text" name="'.$prefView.$vKey.'"'.$styleStr.$rowsStr.$disablStr.'>'.SysBF::getFrArr($obj,$vKey,'').'</textarea>';
                }
            }
        }elseif($viewArr["type"]=="datetime"){ //Дата-время
            $ftdate = date("d.m.Y",intval(SysBF::getFrArr($obj,$vKey,0)));
            $ft_h = date("H",intval(SysBF::getFrArr($obj,$vKey,0)));
            $ft_m = date("i",intval(SysBF::getFrArr($obj,$vKey,0)));
            $ft_s = date("s",intval(SysBF::getFrArr($obj,$vKey,0)));
            if ($viewArr["active"]=="print"){
                echo $ftdate.' '.$ft_h.':'.$ft_m.':'.$ft_s;
            }else{
                echo Lang::get("Date").': <input type="text" class="datepickerTimeField" size="10" name="'.$prefUpd.$vKey.'_date" value="'.$ftdate.'"'.$disablStr.'>
'.Lang::get("Time").': <input size="2" type="text" name="'.$prefUpd.$vKey.'_h" value="'.$ft_h.'" maxlength=2'.$disablStr.'>
: <input size="2" type="text" name="'.$prefUpd.$vKey.'_m" value="'.$ft_m.'" maxlength=2'.$disablStr.'><input type="hidden" name="'.$prefView.$vKey.'" value="datetime">';
            }

            echo $tdStr2 . "</tr>\n";

        }elseif($viewArr["type"]=="date"){ //Дата
            $ftdate = date("d.m.Y",intval(SysBF::getFrArr($obj,$vKey,0)));
            if ($viewArr["active"]=="print"){
                echo $ftdate;
            }else{
                echo Lang::get("Date").': <input type="text" class="datepickerTimeField" size="10" name="'.$prefUpd.$vKey.'_date" value="'.$ftdate.'"'.$disablStr.'><input type="hidden" name="'.$prefView.$vKey.'" value="date">';
            }

            echo $tdStr2 . "</tr>\n";

        }elseif($viewArr["type"]=="select"){
            $realVal = SysBF::getFrArr($obj,$vKey,'noitem');
            if ($viewArr["active"]=="print"){
                //Получим значение из привязанного поля
                $valueStr = '';$value='';
                if (!empty($viewArr["notset"])) $valueStr = Lang::get("Not set"); $value=0;
                if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"]) && isset($viewArr["linkstorage"]["$realVal"])) {$valueStr = Lang::get($viewArr["linkstorage"]["$realVal"]);}
                elseif (!empty($viewArr["linkstorage"]) && !is_array($viewArr["linkstorage"])) {//Это хранилище, выберем элемент из хранилища по id
                    $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                    $storageRes = MNBVStorage::getObjAcc($storName,array("name","namelang"),array("id",'=',"$realVal","and","visible",'=',1),array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                    $valueArr = ($storageRes[0]>0)?$storageRes[1]:null;
                    if (isset($valueArr[(Lang::isDefLang())?"name":"namelang"])){$value=$realVal;$valueStr=$valueArr[(Lang::isDefLang())?"name":"namelang"];}
                    if ($valueStr==='') $valueStr = $valueArr["name"];
                }
                echo (($viewindex)?('['.$value.'] '):'') . $valueStr;
            }else{
                echo '<SELECT name="'.$prefView.$vKey.'"'.$sizeStr.'>'."\n";
                if (!empty($viewArr["notset"])) echo '<OPTION value="0"'.((0==$realVal)?' selected':'').'>'.(($viewindex)?('[0] '):'').Lang::get("Not set")."</OPTION>\n";
                if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"])) {
                    foreach ($viewArr["linkstorage"] as $key => $value) {
                        echo '<OPTION value="'.$key.'"'.(($key==$realVal)?' selected':'').'>'.(($viewindex)?('['.$key.'] '):'').Lang::get($value)."</OPTION>\n";
                    }
                } else {//Это хранилище, выберем элемент из хранилища по id
                    $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                    $paramArr = array();
                    if (isset($viewArr["filter_folder"])) array_push($paramArr,'and','parentid','=',$viewArr["filter_folder"]);
                    if (isset($viewArr["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                    if (isset($viewArr["filter_type"])&&$viewArr["filter_type"]!=='all') {
                        array_push($paramArr,'and','type','=',($viewArr["filter_type"]==="folders")?1:0);
                    }
                    if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                    $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                    if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                        if ($poz==0) continue;
                        $key=$valueArr["id"];
                        $valueStr = MNBVf::substr($valueArr[(Lang::isDefLang())?"name":"namelang"],0,50,true);
                        if ($valueStr==='') $valueStr = $valueArr["name"];
                        echo '<OPTION value="'.$key.'"'.(($key==$realVal)?' selected':'').'>'.(($viewindex)?('['.$key.'] '):'').$valueStr."</OPTION>\n";
                    }
                }
                echo "</SELECT>\n";
            }
        }elseif($viewArr["type"]=="radio"){
            $realVal = SysBF::getFrArr($obj,$vKey,'noitem');
            if ($viewArr["active"]=="print"){
                //Получим значение из привязанного поля
                $valueStr = '';$value='';
                if (!empty($viewArr["notset"])) $valueStr = Lang::get("Not set"); $value=0;
                if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"]) && isset($viewArr["linkstorage"]["$realVal"])) {$valueStr = Lang::get($viewArr["linkstorage"]["$realVal"]);}
                elseif (!empty($viewArr["linkstorage"]) && !is_array($viewArr["linkstorage"])) {//Это хранилище, выберем элемент из хранилища по id
                    $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                    $storageRes = MNBVStorage::getObjAcc($storName,array("name","namelang"),array('id','=',"$realVal",'and','visible','=',1),array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                    $valueArr = ($storageRes[0]>0)?$storageRes[1]:null;
                    if (isset($valueArr[(Lang::isDefLang())?"name":"namelang"])){$value=$realVal;$valueStr=$valueArr[(Lang::isDefLang())?"pozid,name":"pozid,namelang"];}
                    if ($valueStr==='') $valueStr = $valueArr["name"];
                }
                echo (($viewindex)?('['.$value.'] '):'') . $valueStr;
            }else{
                $delimSt = '';//$delimStr;
                if (!empty($viewArr["notset"])) {$delimSt = $delimStr; echo '<input type="radio"  name="'.$prefView.$vKey.'" value="0"'.((0==$realVal)?' checked':'').'/> <label for="'.$prefView.$vKey.'">'.(($viewindex)?('[0] '):'').Lang::get("Not set")."</label>\n";}
                if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"])) {
                    foreach ($viewArr["linkstorage"] as $key => $value) {
                        echo $delimSt.'<input type="radio"  name="'.$prefView.$vKey.'" value="'.$key.'"'.(($key==$realVal)?' checked':'').'/> <label for="'.$prefView.$vKey.'">'.(($viewindex)?('['.$key.'] '):'').Lang::get($value)."</label>\n";
                        if ($delimSt == '') $delimSt = $delimStr;
                    }
                } else {//Это хранилище, выберем элемент из хранилища по id
                    $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                    $paramArr = array();
                    if (isset($viewArr["filter_folder"])) array_push($paramArr,'and','parentid','=',$viewArr["filter_folder"]);
                    if (isset($viewArr["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                    if (isset($viewArr["filter_type"])&&$viewArr["filter_type"]!=='all') {
                        array_push($paramArr,'and','type','=',($viewArr["filter_type"]==="folders")?"1":"0");
                    }
                    if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                    $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                    if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                        if ($poz==0) continue;
                        $key=$valueArr["id"];
                        $valueStr = $valueArr[(Lang::isDefLang())?"name":"namelang"];
                        if ($valueStr==='') $valueStr = $valueArr["name"];
                        echo $delimSt.'<label><input type="radio"  name="'.$prefView.$vKey.'" value="'.$key.'"'.(($key==$realVal)?' checked':'').'/> '.(($viewindex)?('['.$key.'] '):'').$valueStr."</label>\n";
                        if ($delimSt == '') $delimSt = $delimStr;
                    }
                }
            }
        }elseif($viewArr["type"]=="list"){
            $realVal = SysBF::getFrArr($obj,$vKey);
            $realValArr = SysBF::json_decode($realVal);
            if ($viewArr["active"]=="print"){
                $delimSt = '';
                if (!empty($viewArr["notset"])&&in_array(0,$realValArr)) {$delimSt = $delimStr; echo (($viewindex)?('[0] '):'').Lang::get("Not set")."\n";}
                if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"])) {
                    foreach ($viewArr["linkstorage"] as $key => $value) {
                        if (in_array($key,$realValArr)){
                            echo $delimSt . (($viewindex)?('['.$key.'] '):'').Lang::get($value)."\n";
                            if ($delimSt == '') $delimSt = $delimStr;
                        }
                    }
                } else {//Это хранилище, выберем элемент из хранилища по id
                    $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                    $paramArr = array();
                    if (isset($viewArr["filter_folder"])) array_push($paramArr,'and','parentid','=',$viewArr["filter_folder"]);
                    if (isset($viewArr["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                    if (isset($viewArr["filter_type"])&&$viewArr["filter_type"]!=='all') {
                        array_push($paramArr,'and','type','=',($viewArr["filter_type"]==="folders")?"1":"0");
                    }
                    if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                    $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                    if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                        $key=$valueArr["id"];
                        if ($poz==0) continue;
                        $valueStr = $valueArr[(Lang::isDefLang())?"name":"namelang"];
                        if ($valueStr==='') $valueStr = $valueArr["name"];
                        echo $delimSt . (($viewindex)?('['.$key.'] '):'').Lang::get($valueStr)."\n";
                        if ($delimSt == '') $delimSt = $delimStr;
                    }
                }
            }else{
                $delimSt = '';
                $countlist = 0;
                if (!empty($viewArr["notset"])) {$delimSt = $delimStr; echo '<input type="radio"  name="'.$prefView.$vKey.'" value="0"'.((in_array(0,$realValArr))?' checked':'').'/> <label for="'.$prefView.$vKey.'">'.(($viewindex)?('[0] '):'').Lang::get("Not set")."</label>\n";}
                if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"])) {
                    foreach ($viewArr["linkstorage"] as $key => $value) {
                        echo $delimSt.'<input type="checkbox"  name="'.$prefUpd.$vKey.'['.$countlist.']" value="'.$key.'"'.((in_array($key,$realValArr))?' checked':'').'/> <label for="'.$prefUpd.$vKey.'['.$countlist.']">'.(($viewindex)?('['.$key.'] '):'').Lang::get($value)."</label>";
                        echo '<input type="hidden" name="'.$prefKey.$vKey.'['.$countlist.']" value="'.$key.'">'."\n";
                        if ($delimSt == '') $delimSt = $delimStr;
                        $countlist++;
                    }
                } else {//Это хранилище, выберем элемент из хранилища по id
                    $storName = (!empty($viewArr["linkstorage"])&&$viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                    $paramArr = array();
                    if (isset($viewArr["filter_folder"])) array_push($paramArr,'and','parentid','=',$viewArr["filter_folder"]);
                    if (isset($viewArr["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                    if (isset($viewArr["filter_type"])&&$viewArr["filter_type"]!=='all') {
                        array_push($paramArr,'and','type','=',($viewArr["filter_type"]==="folders")?"1":"0");
                    }
                    if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                    $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                    if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                        if ($poz==0) continue;
                        $key=$valueArr["id"];
                        $valueStr = $valueArr[(Lang::isDefLang())?"name":"namelang"];
                        if ($valueStr==='') $valueStr = $valueArr["name"];
                        echo $delimSt.'<input type="checkbox"  name="'.$prefUpd.$vKey.'['.$countlist.']" value="'.$key.'"'.((in_array($key,$realValArr))?' checked':'').'/>  <label for="'.$prefUpd.$vKey.'['.$countlist.']">'.(($viewindex)?('['.$key.'] '):'').$valueStr."</label>";
                        echo '<input type="hidden" name="'.$prefKey.$vKey.'['.$countlist.']" value="'.$key.'">'."\n";
                        if ($delimSt == '') $delimSt = $delimStr;
                        $countlist++;
                    }
                }
                echo '<input type="hidden" name="'.$prefView.$vKey.'" value="list">';
            }
        }elseif($viewArr["type"]=="refresh" && !empty($viewArr['timeout'])){
            echo "<script>setTimeout(\"location.reload(true);\",".(1000*intval($viewArr['timeout'])).");</script>";
        }

        //Дополнительные поля к некоторым системным полям
        if ($vKey=='type' && (2==SysBF::getFrArr($obj,'type',0)||3==SysBF::getFrArr($obj,'type',0))) {//Если это тип объекта Link или URL, то выведем дополнительное поле
            if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,'typeval','');
            else echo '<input type="text" name="ob_typeval" value="'.SysBF::getFrArr($obj,'typeval','').'" style="width:70%">';
        }elseif ($vKey=='alias' && empty($altlang) && $viewArr["active"]!="print") echo ' | <input type="checkBox" name="obd_alias_autogen"> <b>'.Lang::get("URL generator")."</b>\n";

        if ($viewArr["type"]!="refresh") echo "</td></tr>";
        echo "\n\n";
        
    }
    
    
    /**
     * Вывод свойств типового объекта с подготовкой значений в массив типа array('key_name'=>'value')
     * @param $usestorage - хранилище
     * @param array $obj - редактируемый объект
     * @param array $viewArr - массив, содержащий сведения о стурктуре объекта и его выводе
     * @param bool $altlang - маркер альтернативного языка
     * @param string $nameFr - как формировать имя "name" из соответствующего поля (по-умолчанию), "def-lang" из специальных полей "namedef" и "namelang"
     */
    public static function formValsGeneratorToArr($usestorage, array $obj, array $viewArr, $altlang=false, $nameFr = "name"){

        $pgid = SysBF::getFrArr($obj,'id',0); //Id данного объекта
        $vKey = (!empty($viewArr["name"]))?$viewArr["name"]:'clear'; //Название поля хранилища
        if (empty($viewArr["name"])) return array(); //Название поля хранилища
        if (!empty($viewArr["viewindex"])) $viewindex = true; else $viewindex = false;
        $delimStr = (!empty($viewArr["delim"]))?$viewArr["delim"]:'';

        //Название, если требуется
        $tecItNameView = Lang::get($vKey,(!empty($viewArr['print_folder']))?$viewArr['print_folder']:'sysBaseObj');
        if ($nameFr == "def-lang"){
            if (!empty($viewArr["namedef"])) $tecItNameView = $viewArr["namedef"];
            if (!Lang::isDefLang() && !empty($viewArr["namelang"])) $tecItNameView = $viewArr["namelang"];
        }
        if (!empty($viewArr['print_name'])){//Непосредственное указание имени в строке берется алиас и смотрится в указанной папке значение по языку
            $tecItNameView = Lang::get($viewArr['print_name'],(!empty($viewArr['print_folder']))?$viewArr['print_folder']:'sysBaseObj');
        }
        
        $result = array("alias"=>"$vKey", "name"=>"$tecItNameView", "key" => "$vKey", "type" => $viewArr["type"], "realval" => SysBF::getFrArr($obj,$vKey,''));
            
        if($viewArr["type"]=="lineblock") $result["value"] = Lang::get(SysBF::getFrArr($viewArr,'string',''));
        elseif($viewArr["type"]=="int") $result["value"] = SysBF::getFrArr($obj,$vKey,'');
        elseif($viewArr["type"]=="checkbox") $result["value"] = (SysBF::getFrArr($obj,$vKey,0))?Lang::get('Yes'):Lang::get('No');
        elseif($viewArr["type"]=="text")  $result["value"] = SysBF::getFrArr($obj,$vKey,'');
        elseif($viewArr["type"]=="password") $result["value"] = '******';
        elseif($viewArr["type"]=="passwdscr") $result["value"] = '******';
        elseif($viewArr["type"]=="textarea") $result["value"] = MNBVf::updateTxt(SysBF::getFrArr($obj,$vKey,''),$obj['files'],Glob::$vars['mnbv_site'],array(400,300)); //TODO - потом подумать про размеры видеоролика
        elseif($viewArr["type"]=="datetime") $result["value"] = date("d.m.Y H:i",intval(SysBF::getFrArr($obj,$vKey,0)));
        elseif($viewArr["type"]=="date") $result["value"] = date("d.m.Y",intval(SysBF::getFrArr($obj,$vKey,0)));
        elseif($viewArr["type"]=="select"){
            $realVal = SysBF::getFrArr($obj,$vKey,'noitem');
            //Получим значение из привязанного поля
            $valueStr = '';$value='';
            if (!empty($viewArr["notset"])) $valueStr = Lang::get("Not set"); $value=0;
            if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"]) && isset($viewArr["linkstorage"]["$realVal"])) {$valueStr = Lang::get($viewArr["linkstorage"]["$realVal"]);}
            elseif (!empty($viewArr["linkstorage"]) && !is_array($viewArr["linkstorage"])) {//Это хранилище, выберем элемент из хранилища по id
                $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                $storageRes = MNBVStorage::getObjAcc($storName,array("name","namelang"),array("id",'=',"$realVal",'and','visible','=',1),array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                $valueArr = ($storageRes[0]>0)?$storageRes[1]:null;
                if (isset($valueArr[(Lang::isDefLang())?"name":"namelang"])){$value=$realVal;$valueStr=$valueArr[(Lang::isDefLang())?"name":"namelang"];}
                if ($valueStr==='') $valueStr = $valueArr["name"];
            }
            $result["value"] = (($viewindex)?('['.$value.'] '):'') . $valueStr;
        }
        elseif($viewArr["type"]=="radio"){
            $realVal = SysBF::getFrArr($obj,$vKey,'noitem');
            //Получим значение из привязанного поля
            $valueStr = '';$value='';
            if (!empty($viewArr["notset"])) $valueStr = Lang::get("Not set"); $value=0;
            if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"]) && isset($viewArr["linkstorage"]["$realVal"])) {$valueStr = Lang::get($viewArr["linkstorage"]["$realVal"]);}
            elseif (!empty($viewArr["linkstorage"]) && !is_array($viewArr["linkstorage"])) {//Это хранилище, выберем элемент из хранилища по id
                $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                $storageRes = MNBVStorage::getObjAcc($storName,array("name","namelang"),array('id','=',"$realVal",'and','visible','=',1),array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                $valueArr = ($storageRes[0]>0)?$storageRes[1]:null;
                if (isset($valueArr[(Lang::isDefLang())?"name":"namelang"])){$value=$realVal;$valueStr=$valueArr[(Lang::isDefLang())?"pozid,name":"pozid,namelang"];}
                if ($valueStr==='') $valueStr = $valueArr["name"];
            }
            $result["value"] = (($viewindex)?('['.$value.'] '):'') . $valueStr;
        }elseif($viewArr["type"]=="list"){
            $realVal = SysBF::getFrArr($obj,$vKey);
            $result["realval"] = $realValArr = SysBF::json_decode($realVal);
            $delimSt = '';
            if (!empty($viewArr["notset"])&&in_array(0,$realValArr)) {$delimSt = $delimStr; $result["value"] .= (($viewindex)?('[0] '):'').Lang::get("Not set")."\n";}
            if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"])) {
                foreach ($viewArr["linkstorage"] as $key => $value) {
                    if (in_array($key,$realValArr)){
                        $result["value"] .= $delimSt . (($viewindex)?('['.$key.'] '):'').Lang::get($value)."\n";
                        if ($delimSt == '') $delimSt = $delimStr;
                    }
                }
            } else {//Это хранилище, выберем элемент из хранилища по id
                $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                $paramArr = array();
                if (isset($viewArr["filter_folder"])) array_push($paramArr,'and','parentid','=',$viewArr["filter_folder"]);
                if (isset($viewArr["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                if (isset($viewArr["filter_type"])&&$viewArr["filter_type"]!=='all') {
                    array_push($paramArr,'and','type','=',($viewArr["filter_type"]==="folders")?"1":"0");
                }
                if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                    $key=$valueArr["id"];
                    if ($poz==0) continue;
                    $valueStr = $valueArr[(Lang::isDefLang())?"name":"namelang"];
                    if ($valueStr==='') $valueStr = $valueArr["name"];
                    $result["value"] .= $delimSt . (($viewindex)?('['.$key.'] '):'').Lang::get($valueStr)."\n";
                    if ($delimSt == '') $delimSt = $delimStr;
                }
            }
        }
        return $result;
        
    }

}
