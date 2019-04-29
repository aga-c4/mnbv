<?php
/**
 * DbMysql.class.php Класс работы с MySQL
 *
 * Created by Konstantin Khachaturyan
 * User: AGA-C4
 * Date: 21.04.15
 * Time: 16:53
 */

/**
 * Class DbMysql - интерфейс работы с Mysql
 */
class DbMysql {

    /**
     * @var array - массив параметров доступа и отображения баз данных
     */
    public static $dbParams = array(
        'default' => array(
            'host'=>'localhost',
            'port'=>3306,
            'user'=>'',
            'password'=>'',
            'database'=>null,
            'charset'=>'utf8',
            'collation'=>'utf8_general_ci'
        )
    );

    /**
     * @var array (bool) - Массив маркеров остановки скрипта при ошибке БД
     */
    public static $errorExit = array('default'=>false);

    /**
     * @var object - Алиас базы данных
     */
    private $aliasDb = '';

    /**
     * @var object - массив линков к базам данных
     */
    private $linkDb = null;

    /**
     * @var string - Последний запрос к БД
     */
    private $lastQuery = '';

    /**
     * @var array - Массив статистических даных работы БД
     */
    private static $sqlStat = array(
        'maxSqlTime' => 0,
        'maxSqlQuery' => 0,
        'allSql' => 0,
        'allTime' => 0,
        'allQueries' => array()
    );

    /**
     * @var array - массив объектов, интерфейсов баз данных
     */
    private static $instance = array('default'=>null);

    /**
     * @return object Singleton
     * @param string $dbName - требуемая БД (по-умолчанию default)
     * @param bool|false $new_link_open - открыть отдельное соединение с БД, даже если уже есть с подобными параметрами
     * @param $action действие: "reconnect" - обновление соединения, "checkconnect" - проверить и если надо возобновить коннект., "nocheck" - не проверять реальный коннект, просто отдать линк (по-умолчанию)
     * @return object - ссылка на объект работы с требуемой БД
     */
    public static function getInstance($dbName='default', $action = '')  //$new_link_open=false - ранее был такой параметр, его заменили на $action
    {
        //Создадим при необходимости объект
        if (!isset(self::$dbParams["$dbName"]))$dbName='default';
        if (empty(self::$instance["$dbName"]))self::$instance["$dbName"] = new self();

        if (self::$instance["$dbName"]->linkDb && $action == 'checkconnect' && !self::$instance["$dbName"]->mysql_ping()){ //Провести проверку соединения, если оно протухло, то поменять значение $action = 'reconnect'
            $action = 'reconnect';
            SysLogs::addError('Mysql: Error connection to DB '.$dbName.'! Try to reconnect.');
        }

        //Объект существует
        if ($action == 'reconnect' || !self::$instance["$dbName"]->linkDb){//Если коннекта еще не было, то попробуем приконнектиться к БД с текущими настройками
            $timebefore = microtime(true);
            $host = (!empty(self::$dbParams["$dbName"]['host']))?self::$dbParams["$dbName"]['host']:((!empty(self::$dbParams['default']['host']))?self::$dbParams['default']['host']:'localhost');
            $port = (!empty(self::$dbParams["$dbName"]['port']))?self::$dbParams["$dbName"]['port']:((!empty(self::$dbParams['default']['port']))?self::$dbParams['default']['port']:'3306');
            $user = (!empty(self::$dbParams["$dbName"]['user']))?self::$dbParams["$dbName"]['user']:((!empty(self::$dbParams['default']['user']))?self::$dbParams['default']['user']:'');
            $password = (!empty(self::$dbParams["$dbName"]['password']))?self::$dbParams["$dbName"]['password']:((!empty(self::$dbParams['default']['password']))?self::$dbParams['default']['password']:'');
            $database = (!empty(self::$dbParams["$dbName"]['database']))?self::$dbParams["$dbName"]['database']:((!empty(self::$dbParams['default']['database']))?self::$dbParams['default']['database']:null);
            $charset = (!empty(self::$dbParams["$dbName"]['charset']))?self::$dbParams["$dbName"]['charset']:((!empty(self::$dbParams['default']['charset']))?self::$dbParams['default']['charset']:'utf8');
            $collation = (!empty(self::$dbParams["$dbName"]['collation']))?self::$dbParams["$dbName"]['collation']:((!empty(self::$dbParams['default']['collation']))?self::$dbParams['default']['collation']:'utf8_general_ci');

            try {
                if (!self::$instance["$dbName"]->linkDb = @mysqli_connect($host, $user, $password, $database, $port)){
                    //Соединиться с базой не смогли
                    SysLogs::addError('Mysql:Error connection DB ' . $database . '!');
                    self::$instance["$dbName"]->mysqlError("$dbName");
                    return null;
                }

                //Выберем БД
                if (!@mysqli_select_db(self::$instance["$dbName"]->linkDb,$database)) {
                    //Выбрать БД не смогли
                    SysLogs::addError('Mysql:Error selection DB ' . $database . '!');
                    self::$instance["$dbName"]->mysqlError("$dbName");
                    return null;
                }

                self::$instance["$dbName"]->aliasDb = $dbName;

                //Зададим параметры кодировок
                self::$instance["$dbName"]->query("SET NAMES " . mb_strtoupper($charset));
                self::$instance["$dbName"]->query("SET CHARACTER SET " . mb_strtoupper($charset));
                self::$instance["$dbName"]->query("SET COLLATION_CONNECTION='" . mb_strtoupper($collation) . "'");

                SysLogs::addLog('Mysql: Connect to server ' .$host . ":" . $port . ' success! Database: '.$database.'. [' .  sprintf ("%01.6f",(microtime(true)-$timebefore)) . 's]');
            }catch (Exception $e) {
                SysLogs::addError('Mysql:Error - ' . $e->getMessage());
                return null;
            }
        }
        //Если все прошло отлично, то вернем ссылку на объект БД
        return self::$instance["$dbName"];
    }

    private function __clone() {}
    private function __construct() {}

    /**
     * Удаление объекта
     */
    public function __destruct() {
        $this->disconnect();
    }

    /**
     * Добавление в массив параметров доступа баз данных еще одной базы
     * @param $dbAlias
     * @param array $param
     */
    public static function addDb($dbAlias,$param=array()){
        if ($dbAlias!='default' && !empty($dbAlias) && is_array($param) && !empty($param['database'])) {
            self::$dbParams[$dbAlias] = array();
            if (isset($param['host']))self::$dbParams[$dbAlias]['host'] = $param['host'];
            if (isset($param['port']))self::$dbParams[$dbAlias]['port'] = $param['port'];
            if (isset($param['user']))self::$dbParams[$dbAlias]['user'] = $param['user'];
            if (isset($param['password']))self::$dbParams[$dbAlias]['password'] = $param['password'];
            if (isset($param['database']))self::$dbParams[$dbAlias]['database'] = $param['database'];
            if (isset($param['charset']))self::$dbParams[$dbAlias]['charset'] = $param['charset'];
            if (isset($param['collation']))self::$dbParams[$dbAlias]['collation'] = $param['collation'];
        }
    }

    /**
     * Обрабатывает ошибки БД (логи и остановка скрипта, при необходимости)
     * @param string $dbName
     * @return array|null
     */
    public function mysqlError() {
        $dbName = $this->aliasDb;
        $errorExit = (!empty(self::$errorExit["$dbName"]))?self::$errorExit["$dbName"]:((!empty(self::$errorExit['default']))?self::$errorExit['default']:false);
        $result = array();
        $result['error'] = @mysqli_error($this->linkDb);
        $result['errno'] = @mysqli_errno($this->linkDb);
        if (empty($result['errno'])) return null; //Если нет ошибки, возвращаем null
        else{//Действия при наличии ошибок
            SysLogs::addError('Mysql:Error '.$result['errno'] . ': ' . $result['error'] . '. Query: ' . $this->lastQuery );
            if ($errorExit) { //Если есть ошибки и у БД установлен маркер останова, то останавливаем
                if (SysLogs::$logSave) SysLogs::SaveLog();//Сохраним лог, если это требуется
                if (SysLogs::$errorsView) echo "\n\nErrors:\n" . SysLogs::getErrors();
                if (SysLogs::$logView) echo "\n\nErrors:\n" . SysLogs::getLog();
                exit('Mysql Error! errorExit=['.$errorExit.']');//Остановка скрипта
            }
            return $result;
        }
    }

    /**
     * Закрывает соединение с БД
     * @return bool
     */
    public function disconnect() {
        if (@mysqli_close($this->linkDb)){
            $this->linkDb = null;
            return true;
        } else {
            $this->mysqlError();
            return false;
        }
    }

    /**
     * Отправка запроса к БД
     * @param $query
     * @return bool|resource
     */
    public function query($query)  {
        
        $location = '';
        if (SysLogs::$logsEnable) {
            $debugArr = debug_backtrace();
            if (!empty($debugArr)&& is_array($debugArr)){
                $maxLocCount = count($debugArr);
                $currItem = 0;
                //При необходимости перепрыгнем через служебные методы, для получения интересующей нас точки входа
                if ($currItem<$maxLocCount && false!==stripos($debugArr[$currItem]['file'],'MNBVMySQLSt.class.php')) $currItem++;
                if ($currItem<$maxLocCount && false!==stripos($debugArr[$currItem]['file'],'MNBVStorage.class.php')) $currItem++;
                if ($currItem<$maxLocCount && false!==stripos($debugArr[$currItem]['file'],'MNBVStorage.class.php')) $currItem++; //Возможен двойной вызов по getObjAcc()
                $location = 'file=['.$debugArr[$currItem]['file'].'] line=['.$debugArr[$currItem]['line'].']';
            }else $location = 'empty debug_backtrace';
        }
        
        try {
            if ($this->linkDb) {
                $this->lastQuery = htmlspecialchars($query,ENT_QUOTES,'utf-8');
                $timebefore = microtime(true);
                if (!$result = @mysqli_query($this->linkDb,$query)){
                    //Ошибка в запросе
                    $this->mysqlError();
                    return false;
                }else{ //Действия при успешном запросе

                    $timesql = microtime(true) - $timebefore;
                    if (self::$sqlStat['maxSqlTime'] < $timesql) {
                        self::$sqlStat['maxSqlTime'] = sprintf ("%01.6f",$timesql);
                        self::$sqlStat['maxSqlQuery'] = htmlspecialchars($query,ENT_QUOTES,'utf-8');
                    }
                    self::$sqlStat['allSql'] ++;
                    self::$sqlStat['allTime'] += $timesql;

                    //Если это ражим отладки, то сохраним все запросы, но не более 100.
                    if (SysLogs::$logsEnable) {
                        $qItems = count(self::$sqlStat['allQueries']);
                        if ($qItems<=100) {self::$sqlStat['allQueries'][] = htmlspecialchars($query,ENT_QUOTES,'utf-8') . ' |---> [Time:'.sprintf ("%01.6f",$timesql).'s]'.((!empty($location))?(' [Location: '.$location.']'):'');}
                        elseif ($qItems==101) {self::$sqlStat['allQueries'][] = 'Saved only 100 queries';}
                    }

                    $this->lastQuery = '';
                    return $result;
                }
            }else{
                SysLogs::addError('Mysql:Error - Empty linkDb for ' . $this->aliasDb . '!'.((!empty($locaton))?('[Location: '.$location.']'):''));
                $this->linkDb = null;
                return false;
            }
        }catch (Exception $e) {
            SysLogs::addError('Mysql:Error - ' . $e->getMessage() . ((!empty($locaton))?('[Location: '.$location.']'):''));
            $this->mysql_ping();
            return false;
        }
    }

    /**
     * Возвращает количество записей в предыдущем Mysql установленной SQL_CALC_FOUND_ROWS
     * @return int количество записей без учета limit
     */
    public function countFoundRows() {
        try{
            $sql = "select FOUND_ROWS() as count";
            $o = @mysqli_fetch_object($this->query($sql));
            return $o->count;
        }catch (Exception $e) {
            SysLogs::addError('Mysql:Error - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Обрабатывает ряд результата запроса, возвращая ассоциативный массив, численный массив или оба
     * @param null $result - результат запроса
     * @param int $result_type - массив ответа (MYSQL_ASSOC - ассоциативный (по-умолчанию), MYSQL_NUM - численный или MYSQL_BOTH - оба) это константы
     * @return array|bool - false, если ошибка или нет больше данных
     */
    public static function mysql_fetch_array($result=null, $result_type = "MYSQL_ASSOC") {
        try{
            if ($result) {
                if ($result_type == 'MYSQL_NUM') return @mysqli_fetch_array($result, MYSQLI_NUM);
                elseif ($result_type == 'MYSQL_BOTH') return @mysqli_fetch_array($result, MYSQLI_BOTH);
                else return @mysqli_fetch_array($result, MYSQLI_ASSOC);
            }else return false;
        }catch (Exception $e) {
            SysLogs::addError('Mysql:Error - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обрабатывает ряд результата запроса, возвращая объект
     * @param null $result - результат запроса
     * @return array|bool - false, если ошибка или нет больше данных
     */
    public static function mysql_fetch_object($result=null) {
        try{
            if ($result) {
                return @mysqli_fetch_object($result);
            }else return false;
        }catch (Exception $e) {
            SysLogs::addError('Mysql:Error - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Возвращает численный массив, содержащий ряды ответа MYSQL
     * @param null $result - Результат запроса
     * @param int $result_type - 'OBJECT' или Массив ответа(MYSQL_ASSOC - ассоциативный (по-умолчанию), MYSQL_NUM - численный или MYSQL_BOTH - оба)
     * @return array
     */
    public function getAll($result=null, $result_type = 'OBJECT') {
        try{
            $data=array();
            if ($result){
                if ($result_type=='OBJECT') while ($row_top = @mysqli_fetch_object($result)) $data[] = $row_top;
                elseif ($result_type=='MYSQL_NUM') while ($row_top = @mysqli_fetch_array($result,MYSQL_NUM)) $data[] = $row_top;
                elseif ($result_type=='MYSQL_BOTH') while ($row_top = @mysqli_fetch_array($result,MYSQL_BOTH)) $data[] = $row_top;
                else while ($row_top = @mysqli_fetch_array($result)) $data[] = $row_top;
            }
            return $data;
        }catch (Exception $e) {
            SysLogs::addError('Mysql:Error - ' . $e->getMessage());
            return array();
        }
    }

    /**
     * Возвращает количество рядов, затронутых последним INSERT, UPDATE, DELETE
     * @return bool|int
     */
    public function mysql_affected_rows() {
        try{
            if ($this->linkDb) return @mysqli_affected_rows($this->linkDb);
            else return false;
        }catch (Exception $e) {
            SysLogs::addError('Mysql:Error - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Возвращает ID, сгенерированный колонкой с AUTO_INCREMENT последним запросом INSERT к серверу
     * @return bool|int
     */
    public function mysql_insert_id() {
        try{
            if ($this->linkDb) return @mysqli_insert_id($this->linkDb);
            return false;
        }catch (Exception $e) {
            SysLogs::addError('Mysql:Error - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Проверяет соединение с сервером. Если оно утеряно, автоматически предпринимается попытка пересоединения.
     * @return bool - TRUE, если соединение в рабочем состоянии и FALSE в противном случае.
     */
    public function mysql_ping() {
        try{
            if ($this->linkDb) return @mysqli_ping($this->linkDb);
            else return false;
        }catch (Exception $e) {
            SysLogs::addError('Mysql:Error - ' . $e->getMessage());
            $this->linkDb = null;
            return false;
        }
    }

    /**
     * Возвращает массив статистических данных работы с БД
     * @return mixed
     */
    public static function mysqlStat() {
        return self::$sqlStat;
    }
    
    /**
     * Очищает массив статистических данных работы с БД
     * @return mixed
     */
    public static function clearMysqlStat() {
        self::$sqlStat = array(
            'maxSqlTime' => 0,
            'maxSqlQuery' => 0,
            'allSql' => 0,
            'allTime' => 0,
            'allQueries' => array()
        );
    }

}

