<?php
/**
 * Класс работы с кешем
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVCache {
    
    /**
     * @var type Название переменной сессии
     */
    protected $storage = 'tmp';
    
    /**
     * @var string режим работы кеша - зависит от системной переменной Glob::$vars['cacheMode'] (none/rw/r/w)   
     */
    protected $cacheMode = 'rw'; 
    
    /**
     * При инициализации загрузим данные сессии
     * @param string $storage - алиас хранилища кеша
     */
    public function __construct($storage='tmp') {

        if (!empty(Glob::$vars['cacheMode']) && in_array(Glob::$vars['cacheMode'], array('none','rw','r','w'))){
            $this->cacheMode = Glob::$vars['cacheMode'];
        }else{
            $this->cacheMode = 'none';
        }
        
        if (!empty(SysStorage::$storage["$storage"]["db"])&&!empty(SysStorage::$db[SysStorage::$storage["$storage"]["db"]]['dbtype'])&&in_array(SysStorage::$db[SysStorage::$storage["$storage"]["db"]]['dbtype'],SysStorage::$dbtypes)){
            $this->storage = $storage;
        }else{
            SysLogs::addError("No storage: $storage");
            return false;
        }

    }

    /**
     * Установка элемента контейнера
     * @param string $id алиас элемента
     * @param int $ttl время жизни кеша в секундах
     * @param bool $assoc - выдать как ассоциативный массив (по умолчанию false)
     */
    public function set($id, $val, $ttl=0, $assoc=false)
    {
        if ($this->cacheMode!=='rw' && $this->cacheMode!=='w') return false;
        if (!empty(Glob::$vars['no_cache'])) return false;
            
        $assoc = (!empty($assoc))?true:false;
        $ttl = intval($ttl);
        if ($val==null) return false;
        
        $valJson = json_encode($val,$assoc);

        $updateArr = array();
        $updateArr['ts'] = time();
        $updateArr['tsto'] = ($ttl==0)?0:$updateArr['ts'] + $ttl;
        $updateArr['val'] = $valJson;

        $storageRes = MNBVStorage::getObj(
            $this->storage,
            array("ts","tsto"),
            array("id","=","$id"));
        if (empty($storageRes[0])){
            $updateArr['id'] = $id;
            MNBVStorage::addObj($this->storage, $updateArr,'',false);
            SysLogs::addLog("Cache ADD key[$id] ttl[$ttl]");
        }else{
            MNBVStorage::setObj($this->storage, $updateArr, array("id",'=',$id),false);
            SysLogs::addLog("Cache UPDATE key[$id] ttl[$ttl]");
        }

        return true;

    }

    /**
     * Получение элемента контейнера
     * @param string $id алиас элемента
     * @param bool $assoc - выдать как ассоциативный массив (по умолчанию false)
     * @param int $lag лаг, после которого значение считается устаревшим, если 0, то смотрим по сведениям из самого кеша (tsto>=time())
     * @return mixed Результат операции или NULL, если ничего не найдено
     */
    public function get($id, $assoc=false, $lag=0)
    {
        if ($this->cacheMode!=='rw' && $this->cacheMode!=='r') return false;
        if (!empty(Glob::$vars['no_cache'])) return false;
        $assoc = (!empty($assoc))?true:false;
        $lag = intval($lag);
        if ($lag==0) {
            $uslArr = array("id","=","$id","and","tsto",">=",time());
        }else{
            $uslArr = array("id","=","$id","and","ts",">=",time()-$lag);
        }

        $storageRes = MNBVStorage::getObj(
            $this->storage,
            array("ts","tsto","val"),
            $uslArr,
            array("limit" => array(0,1)));
        if (!empty($storageRes[0])){
            SysLogs::addLog("Cache GET key[$id] lag[$lag]"); // result=[{$storageRes[1]["val"]}]
            $result=json_decode($storageRes[1]["val"],$assoc);
            return ($result!==false)?$result:null;
        }else{
            SysLogs::addLog("Cache GET key[$id] lag[$lag] nof found!");
            return null;
        }

    }

    /**
     * Уничтожает элемент контейнера
     * @param string $id алиас элемента
     */
    public function del($id) {
        if ($this->cacheMode!=='rw' && $this->cacheMode!=='w') return false;
        if (!empty(Glob::$vars['no_cache'])) return false;
        MNBVStorage::delObj($this->storage, array("id","=","$id"));
    }
    
    /**
     * Удаляет из кеша просроченные значения, если
     * @param int $ts timestump до которого значение считается устаревшим, если 0 или не задан, то удаляем все устаревшие по данным из записей
     */
    public function clear($ts=0){
        if ($this->cacheMode!=='rw' && $this->cacheMode!=='w') return false;
        if (!empty(Glob::$vars['no_cache'])) return false;
        $ts = intval($ts);
        $currTs = ($ts==0)?time():$ts;
        MNBVStorage::delObj($this->storage, array("tsto","<",$currTs));
    }

}
