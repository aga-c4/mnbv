<?php
/**
 * Класс работы с сессией пользователя
 * Помимо работы непосредственно с сессией, он формирует и поддерживает в актуальном состоянии Cookie:
 * - MNBVSID - идентификатор технической стабильной сессии
 * - MNBVSIDLONG - идентификатор сессии персонализации, которая живет максимально долго (до конца эпохи Unix) 
 * - MNBVSIDLV - время последнего захода Unix метка времени
 * - MNBVSIDSHORT - идентификатор технической стабильной сессии, которая живет только во время текущей сессии
 * Названия переменных Cookie берутся из соответствующих констант.
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVSession {
    
    /**
     * @var type Название переменной сессии
     */
    public $sidName = 'PHPSESSID'; //Название переменной идентификатора сессии
    
    /**
     * @var type Идентификатор сессии 
     */
    public $sid = '';
    
    /**
     * @var type Тип хранения сессии (PHPSess - по-умолчанию / DB - хранение в базе данных) 
     */
    private $sessType = 'PHPSess'; 

    /**
     * @var type Массив свойств сессии 
     */
    private $container = array();
    
    /**
     * @var type Маркер того что данные сессии изменились
     */
    private $sessUpdate = false;
    
    /**
     * При инициализации загрузим данные сессии
     * @param type $GlobVars - маркер необходимости инициализировать глобальные переменные
     * @param type $sidName - название переменной сессии
     * @param type $sessType - тип хранения сессии (PHPSess - по-умолчанию / DB - хранение в базе данных / Cookie - хранение в куках только идентификаторов сессии / Nosave - нигде не храним) 
     */
    public function __construct($GlobVars=false,$sidName='',$sessType='') {
        
        $location = '';
        if (SysLogs::$logsEnable) {
            $debugArr = debug_backtrace();
            if (!empty($debugArr)&& is_array($debugArr)){
                $maxLocCount = count($debugArr);
                $currItem = 0;
                //При необходимости перепрыгнем через служебные методы, для получения интересующей нас точки входа
                $location = 'file=['.$debugArr[$currItem]['file'].'] line=['.$debugArr[$currItem]['line'].']'; $currItem++;
                if ($currItem<$maxLocCount) $location .= ' <== file=['.$debugArr[$currItem]['file'].'] line=['.$debugArr[$currItem]['line'].']';
            }else $location = 'empty debug_backtrace';
        }
        
        $this->sessType = 'PHPSess';
        if ($sessType == 'DB') $this->sessType = 'DB';
        elseif ($sessType == 'Cookie') $this->sessType = 'Cookie';
        elseif ($sessType == 'Nosave') $this->sessType = 'Nosave';
        $this->sidName = (!empty($sidName))?$sidName:PHPSESSID;
        
        if ($this->sessType == 'Nosave'){ //Техническая сессия для кроновских и подобных скриптов
            $this->sid = '';
            SysLogs::addLog('Session start Nosave in location: '.$location);
        }elseif ($this->sessType == 'Cookie') {
            $this->sid = (!empty($_COOKIE[MNBVSID]))?$_COOKIE[MNBVSID]:''; //У нас будет только идентификатор, никаких переменных не будет
            SysLogs::addLog('Session start Cookie in location: '.$location);
        }elseif ($this->sessType == 'DB') {//Если сессия в БД, то загрузим из базы данных сессию
            $this->sid = '';
            SysLogs::addLog('Session start DB in location: '.$location);
        }else{
            if (!empty(Glob::$vars['mnbv_site']['cookiedomain'])) {
                SysLogs::addLog('Session cookiedomain: ['.Glob::$vars['mnbv_site']['cookiedomain'].']');
                session_set_cookie_params(0, '/', Glob::$vars['mnbv_site']['cookiedomain']);
            }
            if (empty($_COOKIE[PHPSESSID])) {
                if (MNBVSID_TO_PHPSESSID && !empty($_COOKIE[MNBVSID])) {
                    session_id($_COOKIE[MNBVSID]);
                }
                if (PHPSESSID != 'PHPSESSID') session_name(PHPSESSID); //Если в константах задано нестандартное имя сессии, то используем его.
                session_start();
                $this->sessUpdate = true; //Не было идентификатора сессии, теперь будет, надо сохраниться 
            } else session_start();
            $this->sid = session_id(); //Установим текущий идентификатор сессии
            if (isset($_SESSION) && is_array($_SESSION)) $this->container = $_SESSION;
            SysLogs::addLog('Session start default sid=['.$this->sid.'] in location: '.$location);
        }
        
        if ($GlobVars){
            //Сделаем первоначальную установку переменных персонализации
            //Язык интерфейса
            if ($this->get('lang')){Glob::$vars['lang'] = $this->get('lang');Lang::setLang(Glob::$vars['lang']);} //Установим язык интерфейса
            //Количество строк в таблице
            if ($this->get('list_max_items')) Glob::$vars['list_max_items'] = $this->get('list_max_items');           
        }
        
    }

    /**
     * Установка элемента контейнера
     * @param $key Название элемента
     * @param $value Значение элемента
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;
        $this->sessUpdate = true;
    }

    /**
     * Получение элемента контейнера
     * @param $key Название элемента
     * @return mixed Результат операции
     */
    public function get($key)
    {
        return (isset($this->container[$key]))?$this->container[$key]:NULL;
    }

    /**
     * Уничтожает элемент контейнера
     * @param $key Название элемента
     */
    public function del($key)
    {
        if (isset($this->container[$key])) {
            unset($this->container[$key]);
            $this->sessUpdate = true;
        }
    }
    
    /**
     * Сохраняет текущую сессию в соответствии с ее типом хранения
     */
    public function save(){
        
        if ($this->sessUpdate){
            if ($this->sessType == 'DB') {//Если сессия в БД
                ;
            }else{
                $_SESSION = $this->container;
                SysLogs::addLog('Session save '.PHPSESSID.'='.$this->sid);
                //foreach ($this->container as $key => $value) $_SESSION["$key"] = $value; //Сделать так, если будет запрет на установку $_SESSION
            }
        }
        
    }
    
    
    
}
