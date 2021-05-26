<?php
/**
 * Механизм обработки файлов миграций
 * запускаем так:
 * php migration.php [db=dbAlias] [help|info|migrate|dump]
 *
 * dbAlias - database alias for info or migrate (mnbv - default alias)
 * help - info about script
 * info - info about database status and version
 * migrate - run migrations
 * dump - create databse dump
 *
 * Для работы из под GIT скопируйте файл "migration.default.php" в такой же только без "default" и настройте в нем
 * массив $config.
 *
 * В .gitignore добавьте следующие блокировки:
 * /data/storage_dumps/migration.php
 * /data/storage_dumps/*-status.txt
 * /data/storage_dumps/dump/
 *
 * Номер версии базы берется из массива конфига в данном файле.
 *
 * Скрипт работает с текущей папкой, вы можете размещать его в требуемом вам месте.
 * Скрипт находит папку с названием как у названия базы, в ней находит папку требуемой версии типа "v1"
 * Если еще не было никаких действий по базе, то используется базовый дамп, имеющий дефолтовое название "baseline.sql".
 * Далее последовательно применяются файлы миграфий по возрастанию их номера (метод инкрементных изменений).
 *
 * При применении файлов миграций их названия фиксируются в текстовом файле на базе имени базы данных типа
 * "ИМЯ_БАЗЫ-status.txt". Первой записью данного файла будет baseline.sql, если база уже была восстановлена из дампа.
 * Программа из требуемой директории последовательно откроет и применит файлы миграций по возрастанию их номера,
 * исключив при этом те из них, которые уже перечислены в файле статусов, в котором фиксируются записи типа:
 * date-start|Название файла|Номер|Версия|Подверсия|Комментарий|date-stop
 *
 * Механизм миграций не будет работать, если последняя запись не имеет меток времени окончания миграции.
 *
 * Названия файлов миграций формируются по принципу:
 * Номер-файла.Номер-версии.Номер-подверсии.расширение. Пример: 0001-03-007.sql В результате база после обновления будет
 * иметь версию 03.007 . После версии можно через нижнее подчеркивание латинскими буквами (не используйте "-") кратко
 * описать суть дампа, типа: 0001-03-007-update_users.sql . Система выделит "update_users" в качестве комментария.
 *
 * Не изменяйте названия файлов миграций после того, как они были исполнены, иначе они могут быть применены повторно.
 *
 * Миграция не будет применена и процесс будет остановлен, если в файле статусов миграций уже есть файл миграции с
 * номером, который мы применяем в текущий момент. В этом случае будет выдано предупреждение об ошибке с просьбой в
 * ручном режиме решить эту проблему. Ручной режим требуется для уделения повышенного внимания возможным коллизиям.
 *
 * Скрипт имеет режим создания дампа базы данных, в результате в папке "dump" появится файл типа:
 * Название-базы_Номер-версии_Номер-подверсии_data.расширение
 *
 * В массиве конфигурации можно указать сведения о разных базах.
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * License: BSD 2-Clause License
 * Date: 24.04.18
 */

/**
 * Конфиг скрипта
 */
$config = array(
    'mnbv' => array(
        "db_dump_scrpt" => "mysqldump -uroot mnbv8 > ", //Скрипт создания дампа бд - в конце будет добавлен файл дампа
        "db_script" => "mysql -uroot mnbv8 < ", //Скрипт выполнения скрипта бд - в конце будет добавлен файл дампа
        "version" => 2, //Номер текущей версии, для которой будут выполняться файлы миграций
        "ext" => "sql", //расширение файлов миграции и дампов.
    )
);


chdir(__DIR__);

//Получим входные параметры из консоли $argv (недоступно если register_argc_argv установлен в disabled)
$request = array();
if (isset($argv) && is_array($argv)){
    foreach ($argv as $value){
        $tecArr = preg_split("/=/", $value);
        if (!empty($tecArr[0])) {$request[strval($tecArr[0])] = (isset($tecArr[1]))?trim($tecArr[1]):'value not found in argv';}
    }
}

$dbAlias = (!empty($request['db']))?$request['db']:'';
$db = new MNBVMigration($dbAlias);

if (!empty($dbAlias) && !isset($request['help']) && false!==$db->getConfig($config)){//Изменения только для режима редактирования

    if(isset($request['dump'])) {

        $db->loadMigrations();
        echo "Database: $dbAlias current version ".$db->getDbFullVersion()."\n";
        $res = $db->dump();
        echo ($res)?"Dump complite!\n":"Dump error!\n";

    }else{

        $db->loadMigrations();
        $db->findNewMigrations();
        echo "Complete migrations:\n";
        foreach($db->migrationsLog as $value) echo $value."\n";
        echo "Database: $dbAlias current version ".$db->getDbFullVersion()."\n";

        if(isset($request['migrate'])) {
            echo "Run migrations files:\n";
            foreach($db->newMigrations as $value) {
                if (!empty($value)){
                    echo $value;
                    $res = $db->migrate($value);
                    echo ($res)?" Complite!\n":"";
                }
            }
            echo "Migration finished!\n";
            echo "Database: $dbAlias current version ".$db->getDbFullVersion()."\n";
        }else{
            echo "\nNew migrations files:\n";
            foreach($db->newMigrations as $value) echo $value."\n";
        }

    }

}else{
    echo "COMMAND:
php migration.php [db=dbAlias] [help|info|migrate]

dbAlias - database alias for info or migrate (mnbv - default alias)
help - info about script
info - info about database status and version
migrate - run migrations
dump - create databse dump
--------------------------
";
}


/**
 * Class MNBVMigration класс работы с миграциями
 */
class MNBVMigration {

    /**
     * @var bool маркер ошибки
     */
    public $error = false;

    /**
     * @var string размещение файла конфига
     */
    public $migrationStatusFile = '[dbAlias]-status.csv';

    /**
     * @var string папка с дампами
     */
    public $dumpPath = 'dump/';

    /**
     * @var array массив конфигурации для текущей БД
     */
    private $config = array();

    /**
     * @var string название БД с которой работаем
     */
    private $dbAlias = '';

    /**
     * @var string максимальный найденный номер выполненного файла миграции
     */
    private $lastMigrNum = 0;

    /**
     * @var string текущая версия БД
     */
    private $version = 1;

    /**
     * @var string текущая подверсия БД
     */
    private $subversion = 0;

    /**
     * @var array массив выполненных файлов миграций
     */
    public $migrationsLog = array();

    /**
     * @var array массив выполненных файлов миграций
     */
    public $migrations = array();

    /**
     * @var array массив файлов миграций для выполнения
     */
    public $newMigrations = array();

    public function __construct($dbAlias){
        $this->dbAlias = trim($dbAlias);
    }

    /**
     * Формирует массив конфига для заданной базы данных
     * @param string $dbAlias
     * @param array $config
     * @return bool
     */
    public function getConfig(array $config=array()){

        if (isset($config[$this->dbAlias])&&is_array($config[$this->dbAlias])) $this->config = $config[$this->dbAlias];
        else return false;

        $this->version = intval($this->config["version"]);

        return true;
    }

    /**
     * Загружает из файла список миграций и формирует массивы.
     * @return bool результат операции
     */
    public function loadMigrations(){

        $fileName = str_replace('[dbAlias]',$this->dbAlias,$this->migrationStatusFile);

        if (!file_exists($fileName) || !$file = fopen($fileName,'r')){
            echo "File [$fileName] Not found!\n";
            return false;
        }else{
            $strCounter = 0;
            $this->migrationsLog = array();
            $this->migrations = array();
            $error = false;
            while (!feof($file)){
                $str = fgets($file);
                $str = trim($str);
                if (!$str) continue;
                if (empty($str)) continue;
                $tecArr = preg_split("/\|/", $str);

                //date-start|Название файла|Номер|Версия|Подверсия|Комментарий|date-stop
                $currMigrFileName = trim($tecArr[1]);
                if (empty($currMigrFileName)) continue;

                //if (empty(strval($tecArr[6]))) $str .= 'Error!';
                $this->migrationsLog[] = $str;
                $this->migrations[] = $currMigrFileName;

                if (empty($tecArr[7])||$tecArr[7]!='Complite') $error = true; else $error = false;

                $this->lastMigrNum = intval($tecArr[2]);
                //$this->version = intval($tecArr[3]); //Ее оставляем как есть
                $subversion = intval($tecArr[4]);
                if ($subversion>$this->subversion && !$error) $this->subversion = $subversion;

                $strCounter++;
            }
            fclose($file);
            if ($error) $this->error = true; //Если последняя запись с ошибкой, то продолжать нельзя, пока ошибка не будет устранена
            return true;
        }
    }

    /**
     * Загружает из папки список файлов миграций, исключает те из них, которые выполнены и формирует массив $this->newMigrations.
     * @return bool результат операции
     */
    public function findNewMigrations(){

        $baselineFileNam = 'baseline.'.$this->config["ext"];
        $baselineFound = false;

        $dirList = opendir($this->dbAlias.'/v'.$this->version);
        $resArr = array();
        while ($tec_file_nam = readdir($dirList)) if (!is_dir($dirList.'/'.$tec_file_nam)){
            //0001-03-007-update_users.sql
            $tec_file_nam = trim($tec_file_nam);
            $tecArr = preg_split("/-/", $tec_file_nam);
            $currNum = intval($tecArr[0]);

            if ($baselineFileNam==$tec_file_nam) $baselineFound = true;

            //Условия блокировки
            if (in_array($tec_file_nam,$this->migrations)) continue;
            if ($this->version != intval($tecArr[1])) continue;
            if ($tec_file_nam==$baselineFileNam) continue;

            $resArr[] = $tec_file_nam;
        }
        closedir($dirList);
        sort($resArr);
        reset($resArr);
        $this->newMigrations = array();
        if ($baselineFound && !in_array($baselineFileNam,$this->migrations)) $this->newMigrations[] = $baselineFileNam;
        foreach($resArr as $key=>$value){
            $this->newMigrations[] = $value;
        }

        return true;
    }

    /**
     * Возвращает текущую версию БД
     * @return string
     */
    public function getDbVersion(){
        return $this->$version;
    }

    /**
     * Возвращает текущую версию БД
     * @return string
     */
    public function getDbFullVersion(){
        return $this->version.'.'.$this->subversion;
    }

    /**
     * Добавляет запись в файл лога миграций
     * @param string $str строка для записи в файл
     * @return bool - результат операции
     */
    private function saveToFile($str=''){
        $fileName = str_replace('[dbAlias]',$this->dbAlias,$this->migrationStatusFile);
        if ($handle = fopen($fileName,'a+')){
            if (fwrite($handle,$str)){
                fclose($handle);
            } else return false;
        } else {
            echo "File [$fileName] Not found!\n";
            return false;
        }
        return true;
    }

    /**
     * Выполняет файл миграции для выбранной базы данных.
     * @param string $fileName имя исполняемого файла миграции
     * @return bool результат операции
     */
    public function migrate($fileName){

        if ($this->error) {
            echo "\nError found! Can`t to run next migration script!\n";
            return false;
        }

        $baselineFileNam = 'baseline.'.$this->config["ext"];

        //0001-03-007-update_users.sql
        $fileName = trim($fileName);
        $tecArr = preg_split("/-/", $fileName);
        $currNum = (!empty($tecArr[0]))?intval($tecArr[0]):0;
        $version = (!empty($tecArr[1]))?intval($tecArr[1]):0;
        $subversion = (!empty($tecArr[2]))?intval($tecArr[2]):0;

        $comm = (!empty($tecArr[3]))?trim($tecArr[3]):'';
        $comm = str_replace('.'.$this->config["ext"],'',$comm);

        //echo "fileName=[$fileName] baselineFileNam=[$baselineFileNam]\n";
        //Условия блокировки
        if ($baselineFileNam!=$fileName || $this->lastMigrNum>0){
            if (empty($currNum)||$this->lastMigrNum>=$currNum) {
                echo " Error: wrong number [$currNum] <= last number [".$this->lastMigrNum."]\n";
                $this->error = true; //При этом маркере продолжать уже не будем
                return false;
            }
            if (in_array($fileName,$this->migrations)) return false;
            //if ($this->version != intval($tecArr[3])) return false;
        }

        if ($baselineFileNam==$fileName){
            $currNum = 0;
            $version = $this->version;
            $subversion = 0;
            $comm = 'Baseline';
        }

        //date-start|Название файла|Номер|Версия|Подверсия|Комментарий|date-stop
        $this->saveToFile(date("Y-m-d G:i:s").'|'.$fileName.'|'.$currNum.'|'.$version.'|'.$subversion.'|'.$comm.'|');

        $command = $this->config["db_script"] . $this->dbAlias . '/v' . $this->version . '/' . $fileName;
        //echo $command."\n";

        exec("$command 2>&1", $output, $return_var);

        if (!empty($output[0])) {
            $this->saveToFile(date("Y-m-d G:i:s")."|Error|".$output[0]."\n");
            echo "\nError: ".$output[0]."\n";
            $this->error = true;
            return false;
        }else{
            $this->saveToFile(date("Y-m-d G:i:s")."|Complite\n");
            if ($subversion>$this->subversion) $this->subversion = $subversion;
            return true;
        }

    }

    /**
     * Выгружает дамп выбранной базы данных в директорию "dumps".
     * @return bool результат операции
     */
    public function dump(){

        //Название-базы_Номер-версии_Номер-подверсии_data.расширение
        $fileName = $this->dbAlias . '-v' . $this->version . '.' . $this->version . '-' . date("Ymd-G-i") . '.' . $this->config["ext"];
        $command = $this->config["db_dump_scrpt"] . $this->dumpPath . '/' . $fileName;
        echo $command."\n";

        $res = exec("$command 2>&1", $output, $return_var);
        if (!empty($output[0])) {
            return false;
        }else{
            return true;
        }

    }

}
