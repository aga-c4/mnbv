<?php
/**
 * Класс работы с пользователем
 * Есть 2 хранилища
 * $storage - Хранилище с пользователями, идентификаторы принудительно от 1000
 * sysStorage - Хранилище с админами, идентификаторы принудительно до 1000
 * Чтение и запись производится автоматом по идентификатору или поиском: сначала по админскому, потом по пользовательскому хранилищу
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVUser {
    
    /**
     * @var type Массив свойств пользователя 
     */
    private $container = array();
    
    /**
     * @var type Хранилище с пользователями, идентификаторы принудительно от 1000
     */
    private $storage = "users";
    
    /**
     * Получение текущего хранилища пользователей
     * @param $storage - алиас хранилища
     */
    public function getStorage(){
        return $this->storage;
    }

    /**
     * Установка текущего хранилища пользователей
     * @param $storage - алиас хранилища
     */
    public function setStorage($storage){
        $this->storage = $storage;
    }

    /**
     * @var type Хранилище с админами, идентификаторы принудительно до 1000
     */
    private $sysStorage = "sysusers";

    /**
     * Получение текущего хранилища с админами
     * @param $storage - алиас хранилища
     */
    public function getSysStorage(){
        return $this->sysStorage;
    }

    /**
     * Установка текущего хранилища с админами
     * @param $storage - алиас хранилища
     */
    public function setSysStorage($storage){
        $this->sysStorage = $storage;
    }
    
    /**
     * При инициализации получим данные из сессии
     * @param type $sidName - название переменной сессии
     * @param type $sessType - тип хранения сессии (PHPSess - по-умолчанию / DB - хранение в базе данных) 
     */
    public function __construct($userid=0) {
        
        //Получим данные пользователя из базы и инициализируем текущего пользовтеля

        $this->setSysStorage(Glob::$vars['sysusers_storage']);
        $this->setStorage(Glob::$vars['users_storage']);
        $this->load($userid);
        
    }
    
    /**
     * Установка элемента контейнера
     * @param $key Название элемента
     * @param $value Значение элемента
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;
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
     * Получение всех элементов контейнера
     * @param $key Название элемента
     * @return mixed Результат операции
     */
    public function getall()
    {
        $res = $this->container;
        unset($res['vars']);
        return $res;
    }

    /**
     * Уничтожает элемент контейнера
     * @param $key Название элемента
     */
    public function del($key)
    {
        if (isset($this->container[$key])) unset($this->container[$key]);
    }
    
    /**
     * Загружает свойства заданного пользователя при необходимости с прведением авторизаци 
     * @param type $userid идентификатор пользователя
     * @param type $login если задано, то проверяем логин с паролем
     * @param type $passwd если задано, то проверяем логин с паролем
     * @param type $sid идентификатор сессии или другой доп для авторизации
     * @return type идентификатор пользователя
     */
    public function load($userid=0,$login='',$passwd='',$sid=''){
        //Первичная авторизация
        $this->container = array();
        $this->set('userid',0);
        $permarr = array(0);
        $this->set('permarr',$permarr);
        $this->set('permstr','0');
        if ($userid==0&&($login==''||$passwd=='')) {
            return 0; //Если не заданы входные параметры, то проводим первичную инициализацию
        }
        $isAdmin = (!empty($userid)&&$userid<1000)?true:false;
            
        $userid = intval($userid);
        $login = strtolower($login);
        
        if ($userid>0){
            $uslArr = array("id",'=',$userid);$uslConf=array();
            $storage = ($isAdmin)?$this->getSysStorage():$this->getStorage();
        } else {
            $uslArr = array("login",'=',"$login");$uslConf=array("limit"=>array(0,1));
            $storage = $this->getSysStorage();
        }
        
        $UserArr = false;
        $UserFind = false;
        $storageRes = MNBVStorage::getObj($storage,
            array("id","name","namelang","vars","email","login","passwd"),
            $uslArr,$uslConf);
        $UserArr = ($storageRes[0]>0)?$storageRes[1]:null;
        
        //При необходимости проведем авторизацию
        if ($UserArr&&($userid>0||$passwd==md5($sid.$UserArr['passwd']))){
            $UserFind = true;
        }elseif($userid==0){//Если пользователь не найден в хранилище админов и его искали по логину, то поищем в базе простых пользователей
            $storage = $this->getStorage();
            $storageRes = MNBVStorage::getObj($storage,
                array("id","name","namelang","vars","email","login","passwd"),
                $uslArr,$uslConf);
            $UserArr = ($storageRes[0]>0)?$storageRes[1]:null;

            //При необходимости проведем авторизацию
            if ($UserArr&&($passwd==md5($sid.$UserArr['passwd']))) $UserFind = true;

        }

        if ($UserFind){ //Если пользователь найден, то запишем его данные

            $this->set('name',$UserArr['name']);
            $this->set('namelang',$UserArr['namelang']);
            $this->set('email',$UserArr['email']);
            $this->set('login',$UserArr['login']);
            $this->set('passwd',$UserArr['passwd']);
            $this->set('userid',$UserArr['id']);
            $this->set('vars',$UserArr['vars']);
            if (!empty($UserArr['vars'])) $UserArr['vars'] = SysBF::json_decode($UserArr['vars']);
            if (empty($UserArr['vars']['permissions'])) $UserArr['vars']['permissions'] = '';
            foreach ($UserArr['vars'] as $key=>$value) $this->set("$key",$value);

            $remip=GetEnv('REMOTE_ADDR');
            $this->set('remip',$remip);
            $permarr = SysBF::json_decode($UserArr['vars']['permissions']);
            $permarr[]=0;
            $this->set('permarr',$permarr);
            $this->set('permstr',implode(',',$this->container['permarr']));
            
            //Заполним поля скидки в проценте и валюте
            $discArr = null;
            if ($this->get("discount")) {
                $storageRes = MNBVStorage::getObj('discounts',
                array("id","name","namelang","discpr","discval"),
                array("id",'=',$this->get("discount")));
                $discArr = ($storageRes[0]>0)?$storageRes[1]:null;
            }
                
            if ($discArr!==null){
                $this->set("discarr", $discArr);
                $this->set("discname", $discArr['name']); 
                $this->set("discnamelang", $discArr['namelang']); 
                $this->set("discvalstr",(!empty($discArr['discpr']))?($discArr['discpr'].'%'):((!empty($discArr['discval']))?($discArr['discval'].Glob::$vars['prod_currency_suf']):'')); 
                $this->set("discpr",(!empty($discArr['discpr']))?$discArr['discpr']:0);
                $this->set("discval",(!empty($discArr['discval']))?$discArr['discval']:0);
            }else{
                $this->set("discarr", array());
                $this->set("discount",0);
                $this->set("discname",''); 
                $this->set("discnamelang",''); 
                $this->set("discpr",0);
                $this->set("discval",0);
            }

        }


        if (!empty($UserArr['vars']['root'])) $this->set('root',true); else $this->set('root',false);
        if (!empty($UserArr['vars']['viewlogs'])) $this->set('viewlogs',true); else $this->set('viewlogs',false);
        SysLogs::addLog('UserId: ['.$storage.']['.$this->get('userid').']:['.$this->get('permstr').']');
        return $this->get('userid');
    }
    
    /**
     * Сохраняет свойства текущего пользователя, которые он имеет право редактировать (пароль, язык интерфейса, ширина интерфейса, количество строк в таблицах...)
     */
    public function save(){
        $userid = intval($this->get('userid'));
        if (empty($userid)) return false;
        $storage = ($userid<1000)?$this->getSysStorage():$this->getStorage();

        $storageRes = MNBVStorage::getObj($storage,
            array("vars","passwd"),
            array("id",'=',$userid));
        $UserArr = ($storageRes[0]>0)?$storageRes[1]:null;
        if (!empty($UserArr['vars'])) $UserArr['vars'] = SysBF::json_decode($UserArr['vars']);
        $UserArr['vars']['tablerows'] = (!empty($this->container['tablerows']))?'tablerows':21;
        $UserArr['vars']['tplwidth'] = (!empty($this->container['tplwidth']))?'tablerows':1;
        
        //Обновим значения полей
        $updateArr = array();
        if (count($UserArr)>0) $updateArr["vars"] = json_encode($UserArr['vars']); else $updateArr["vars"] = '';
        if ($UserArr["passwd"]!=$this->container['passwd']&&$this->container['passwd']!='') $updateArr['passwd'] = $this->container['passwd'];
        $res = MNBVStorage::setObj($storage, $updateArr, array("id",'=',$userid));
        SysLogs::addLog("Update object /".$storage."/".$userid."/ ".(($res)?'successful!':'error!'));
    }
        
}
