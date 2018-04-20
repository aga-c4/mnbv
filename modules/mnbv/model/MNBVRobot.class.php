<?php
/**
 * Управление роботом, дочерний класс процесса
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVRobot extends MNBVProcess {

    /**
     * @var string хранилище типов роботов
     */
    protected $robotsStorage = 'robots';

    /**
     * @var string хранилище заданий для роботов
     */
    protected $storage = 'robotsrun';

    /**
     * @var string идентификатор сессии текущего задания
     */
    protected $psid = '';

    /**
     * @var int идентификатор запущенного задания
     */
    protected $objId = 0;

    /**
     * @var int объект текущего задания из БД
     */
    protected $obj = null;

    /**
     * @var string алиас текущего робота
     */
    protected $robotAlias = '';

    public function __construct($objId='',$storage='',$robotsStorage=''){
        if (!empty(Glob::$vars['robotsStorage'])) $this->robotsStorage = Glob::$vars['robotsStorage'];
        if (!empty(Glob::$vars['robotsRunStorage'])) $this->storage = Glob::$vars['robotsRunStorage'];
        if (!empty($robotsStorage)) $this->robotsStorage = $robotsStorage;
        if (!empty($storage)) $this->storage = $storage;
        if (!empty($objId)) $this->objId = $objId;
        if (!empty($command)) $this->command = $command;
        if (!empty($output)) $this->output = $output;

        //Если можно подтянуть объект, то сразу его подтянем.
        if (!empty($this->storage) && !empty($this->objId)) $this->obj = $this->getObjById();
    }

    /**
     * Возвращает объект текущего задания робота, если не найдено, то null
     * @param int $objId идентификатор задания, если не задан, то возьмет из $this->objId
     * @return null результат операции или искомый объект, или null
     */
    public function getObjById($objId=0){
        $storageRes = array(0);
        if (empty($objId)) $objId = $this->objId;
        $storageRes = MNBVStorage::getObj($this->getStorage(),array("*"),array("id","=",$objId),array("connect" => "checkconnect"));
        $result = (!empty($storageRes[0]))?$storageRes[1]:null;
        if ($result === null) return null;

        //Преобразования
        $result['vars'] = (!empty($result['vars']))?SysBF::json_decode($result['vars']):array();
        $result['files'] = (!empty($result['files']))?SysBF::json_decode($result['files']):array();

        //Обязательные поля
        if (empty($result['name'])) $result['name'] = '';
        if (empty($result['status'])) $result['status'] = '';

        $this->command = (!empty($result['script']))?$result['script']:'';
        $this->output = (!empty($result['output']))?$result['output']:'';
        $this->pid = $result['pid'];
        $this->psid = $result['sid'];

        return $result;
    }

    public function setRobotsStorage($storage){
        $this->robotsStorage = $storage;
    }

    public function getRobotsStorage(){
        return $this->robotsStorage;
    }

    public function setStorage($storage){
        $this->storage = $storage;
    }

    public function getStorage(){
        return $this->storage;
    }

    public function setPsid($psid){
        $this->psid = $psid;
    }

    public function getPsid(){
        return $this->psid;
    }

    public function getObjId(){
        return $this->objId;
    }

    public function getRobotAlias(){
        return $this->robotAlias;
    }

    /**
     * Возвращает объект текущего процесса или null, если он не установлен
     * @return null
     */
    public function getObj(){
        return $this->obj;
    }

    /**
     * Запускает текущий процесс
     * $opType - 'restart' для рестарта внезависимости от текущего статуса
     * @return boolean результат операции
     */
    public function start($opType=''){

        if (empty($this->storage)||empty($this->objId)) return false;

        if ($this->obj = $proc = $this->getObjById($this->objId)) ;//Объект для редактирования найден
        else {
            SysLogs::addError('Error: start robot task ['.$this->objId.'] - object not found!');
            return false;
        }

        if ($opType!='restart' && in_array($proc['status'], array('working','paused'))) {
            SysLogs::addError('Error: start robot task ['.$this->objId.'] - wrong status ['.$proc['status'].']!');
            return false;
        }

        //Запишем данные в хранилище процесса

        //Команду и вывод берем из робота, привязанного к объекту
        $storageRes = MNBVStorage::getObj($this->getRobotsStorage(),array("id","alias","vars","files"),array("id","=",$this->obj['robot']));
        $robot = (!empty($storageRes[0]))?$storageRes[1]:null;

        if ($robot==null) {
            SysLogs::addError('Error: start robot task ['.$this->objId.'] - wrong robotId ['.$this->obj['robot'].']!');
            return false;
        }
        $robot['vars'] = (!empty($robot['vars']))?SysBF::json_decode($robot['vars']):array();
        $robot['files'] = (!empty($robot['files']))?SysBF::json_decode($robot['files']):array();
        if (empty($robot['alias'])) $robot['alias'] = '';

        $this->psid = ($opType=='restart'&&!empty($proc['sid']))?$proc['sid']:md5(time().rand()); //Сгенерируем идентификатор сессии для текущего задания
        $this->command = 'php start_robot.php robot='.$robot['alias'].' proc=' . $this->objId . ' rsid=' . $this->psid;
        if (!empty($robot['vars']['script'])) $this->command = str_replace('[obj_id]',$this->objId,$robot['vars']['script']); //[obj_id] - шаблон для замены $this->objId

        $this->output = APP_STORAGEFILESPATH . $this->getStorage().'/att/p'.$this->objId.'_1.txt';
        if (!empty($robot['vars']['output'])) $this->output = str_replace('[obj_id]',$this->objId,$robot['vars']['output']); //[obj_id] - шаблон для замены $this->objId

        //Зарегистрируем приложенные файлы, куда будем выгружать данные
        if (!isset($robot['files']['att'])) $robot['files']['att'] = array();
        $robot['files']['att']['1'] = array('type'=>'txt','fname'=>'output.txt');
        $updateArr['files'] = json_encode($robot['files']);

        $updateArr = array();
        $updateArr['status'] = 'working';
        $updateArr['message'] = (($opType=='restart')?'Restart in ':'From ') . date("Y-m-d H:i:s");
        $updateArr['sid'] = $this->psid;
        $updateArr['vars'] = $proc['vars'];
        $updateArr['vars']['script'] = $this->command;
        $updateArr['vars']['output'] = $this->output;
        $objVarsArr = $updateArr['vars'];
        $updateArr["vars"] = (count($updateArr["vars"])>0)?json_encode($updateArr["vars"]):'';
        $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$this->objId));
        SysLogs::addLog("Update robot task working /".$this->getStorage()."/".$this->objId."/ ".(($res)?'successful!':'error!'));

        $this->obj['status'] = 'working';
        $this->obj['message'] = $updateArr['message'];
        $this->obj['sid'] = $updateArr['sid'];
        $this->obj['vars']['script'] = $objVarsArr['script'];
        $this->obj['vars']['output'] = $objVarsArr['output'];

        $result = MNBVProcess::runDaemon($this->command,$this->output);
        if ($result!==false) {
            $this->pid = $result;
            //Запишем данные в хранилище процесса
            $updateArr = array();
            $updateArr['pid'] = $this->pid;
            $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$this->objId));
            SysLogs::addLog("Update robot task working /".$this->getStorage()."/".$this->objId."/ ".(($res)?'successful!':'error!'));

            $this->obj['pid'] = $this->pid;
            $this->robotAlias = $robot['alias'];
            return true;
        }else{
            $updateArr = array();
            $updateArr['status'] = 'starterror';
            $updateArr['message'] = 'From ' . date("Y-m-d H:i:s");
            $updateArr['sid'] = $this->psid;
            $updateArr['pid'] = 0;
            $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$this->objId));
            SysLogs::addLog("Update robot task working /".$this->getStorage()."/".$this->objId."/ ".(($res)?'successful!':'error!'));

            $this->obj['status'] = $updateArr['status'];
            $this->obj['message'] = $updateArr['message'];
            $this->obj['sid'] = '';
            $updateArr['pid'] = 0;
            return false;
        }

    }

    /**
     * Приостанавливает текущий процесс
     * @return boolean
     */
    public function pauseOn(){

        if ($proc = $this->getObjById($this->objId)) ;//Объект для редактирования найден
        else {
            SysLogs::addError('Error: pause robot task ['.$this->objId.'] - object not found!');
            return false;
        }

        if ($proc['status'] != 'working') { //На паузу можно поставить только работающий процесс
            SysLogs::addError('Error: pause robot task ['.$this->objId.'] - wrong status ['.$proc['status'].']!');
            return false;
        }

        $updateArr = array();
        $updateArr['status'] = 'paused';
        $updateArr['message'] = 'In ' . date("Y-m-d H:i:s");
        $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$this->objId));
        SysLogs::addLog("Update robot task paused /".$this->getStorage()."/".$this->objId."/ ".(($res)?'successful!':'error!'));

        $this->obj['status'] = $updateArr['status'];
        $this->obj['message'] = $updateArr['message'];

        return true;
    }

    /**
     * Возобновляет текущий процесс
     * @return boolean
     */
    public function pauseOff(){

        if ($proc = $this->getObjById($this->objId)) ;//Объект для редактирования найден
        else {
            SysLogs::addError('Error: continue robot task ['.$this->objId.'] - object not found!');
            return false;
        }

        if ($proc['status'] != 'paused') { //Продолжить можно только процесс на паузе
            SysLogs::addError('Error: continue robot task ['.$this->objId.'] - wrong status ['.$proc['status'].']!');
            return false;
        }

        $updateArr = array();
        $updateArr['status'] = 'working';
        $updateArr['message'] = 'Continue from ' . date("Y-m-d H:i:s");
        $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$this->objId));
        SysLogs::addLog("Update robot task working /".$this->getStorage()."/".$this->objId."/ ".(($res)?'successful!':'error!'));

        $this->obj['status'] = $updateArr['status'];
        $this->obj['message'] = $updateArr['message'];

        return true;
    }

    /**
     * Останавливает текущий процесс мягко с завершающими операциями
     * @return boolean
     */
    public function stop(){

        if ($proc = $this->getObjById($this->objId)) ;//Объект для редактирования найден
        else {
            SysLogs::addError('Error: stop robot task ['.$this->objId.'] - object not found!');
            return false;
        }

        if ($proc['status'] != 'working' && $proc['status'] != 'paused') { //Продолжить можно только процесс на паузе
            SysLogs::addError('Error: stop robot task ['.$this->objId.'] - wrong status ['.$proc['status'].']!');
            return false;
        }

        $updateArr = array();
        $updateArr['status'] = 'stopped';
        $updateArr['message'] = 'In ' . date("Y-m-d H:i:s");
        $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$this->objId));
        SysLogs::addLog("Update robot task stopped /".$this->getStorage()."/".$this->objId."/ ".(($res)?'successful!':'error!'));

        $this->obj['status'] = $updateArr['status'];
        $this->obj['message'] = $updateArr['message'];

        return true;

    }

    /**
     * Останавливает текущий процесс мягко с завершающими операциями
     * @return boolean
     */
    public function stopError($message=''){

        if ($proc = $this->getObjById($this->objId)) ;//Объект для редактирования найден
        else {
            SysLogs::addError('Error: stop robot task ['.$this->objId.'] - object not found!');
            return false;
        }

        if ($proc['status'] != 'working' && $proc['status'] != 'paused') { //Продолжить можно только процесс на паузе
            SysLogs::addError('Error: stop robot task ['.$this->objId.'] - wrong status ['.$proc['status'].']!');
            return false;
        }

        $updateArr = array();
        $updateArr['pid'] = 0;
        $updateArr['sid'] = '';
        $updateArr['status'] = 'error';
        $updateArr['message'] = trim($message) . ' In ' . date("Y-m-d H:i:s");
        $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$this->objId));
        SysLogs::addLog("Update robot task stopped /".$this->getStorage()."/".$this->objId."/ ".(($res)?'successful!':'error!'));

        $this->pid = $this->obj['pid'] = $updateArr['pid'];
        $this->psid = $this->obj['sid'] = $updateArr['sid'];
        $this->obj['status'] = $updateArr['status'];
        $this->obj['message'] = $updateArr['message'];

        return true;

    }

    /**
     * Прерывает текущий процесс
     * @return boolean
     */
    public function kill(){

        if ($proc = $this->getObjById($this->objId)) ;//Объект для редактирования найден
        else {
            SysLogs::addError('Error: kill robot task ['.$this->objId.'] - object not found!');
            return false;
        }

        if ($proc['status'] != 'working' && $proc['status'] != 'paused') { //Продолжить можно только процесс на паузе
            SysLogs::addError('Error: kill robot task ['.$this->objId.'] - wrong status ['.$proc['status'].']!');
            return false;
        }

        if ($stopRes = MNBVf::procStop($this->pid)){
            $updateArr = array();
            $updateArr['pid'] = 0;
            $updateArr['sid'] = '';
            $updateArr['status'] = 'killed';
            $updateArr['message'] = 'In ' . date("Y-m-d H:i:s");
            $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$this->objId));
            SysLogs::addLog("Update robot task killed /".$this->getStorage()."/".$this->objId."/ ".(($res)?'successful!':'error!'));

            $this->pid = $this->obj['pid'] = $updateArr['pid'];
            $this->psid = $this->obj['sid'] = $updateArr['sid'];
            $this->obj['status'] = $updateArr['status'];
            $this->obj['message'] = $updateArr['message'];
            return true;
        }else{
            SysLogs::addError('Error: kill robot task ['.$this->objId.']!');
            return false;
        }

    }


    /**
     * Очищает данные процесса
     * @param type $status если 'status', то очищает и поля статуса, а если не задано, то только sid и pid
     * @return boolean Если не удалось забрать из базы данные по роботу, то вернет false, иначе true
     */
    public function clear($status=''){

        if ($proc = $this->getObjById($this->objId)) ;//Объект для редактирования найден
        else {
            SysLogs::addError('Error: clear robot task ['.$this->objId.'] - object not found!');
            return false;
        }

        $updateArr = array();
        $updateArr['pid'] = 0;
        $updateArr['sid'] = '';
        if ($status=='status') {
            $updateArr['status'] = '';
            $updateArr['message'] = '';
        }
        $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$this->objId));
        SysLogs::addLog("Update robot task clear /".$this->getStorage()."/".$this->objId."/ ".(($res)?'successful!':'error!'));

        $this->pid = $this->obj['pid'] = $updateArr['pid'];
        $this->psid = $this->obj['sid'] = $updateArr['sid'];
        if ($status=='status') {
            $this->obj['status'] = $updateArr['status'];
            $this->obj['message'] = $updateArr['message'];
        }
        return true;

    }
    
    /**
     * Проверяет допустимость работы текущего процесса, а именно в текущем объекте psid должен соответствовать тому, что записано в хранилище.
     * @param $procProp - свойства процесса из базы в виде объекта или null 
     * @return boolean - Если объект не найден или валидация прошла успешно, возвращает true, иначе false
     */
    public function validate($procProp=null){
        if ($procProp!==null) ;//Объект для редактирования найден
        else {
            SysLogs::addError('Error: validate robot task ['.$this->objId.'] - object not found!');
            return false;
        }

        if ($procProp['sid'] === $this->psid) return true;
        else SysLogs::addError('Error: validate robot task ['.$this->objId.'] - found deferent sid!'); 
        return false;
    }

}
