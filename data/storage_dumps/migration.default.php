<?php
/**
 * Механизм обработки файлов миграций
 * запускаем так:
 * php migration.php [db=dbAlias] [help|info|migrate|dump]
 *
 * dbAlias - database alias for info or migrate
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
 * Далее последовательно применяются файлы миграфий по возрастанию их номера.
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
    'db_name' => array(
        "host" => "127.0.0.1", //Хост
        "login" => "root", //Логин к БД с достаточными правами
        "passwd" => "", //Пароль к БД
        "db_dump_scrpt" => "", //Скрипт создания дампа бд с заменой шаблона [file] на имя файла создаваемого дампа
        "db_script" => "", //Скрипт выполнения скрипта бд с заменой шаблона [file] на имя файла применяемого файла
        "version" => "1", //Номер текущей версии, для которой будут выполняться файлы миграций
        "ext" => "sql", //расширение файлов миграции и дампов.
    )
);


chdir(__DIR__);

//Получим входные параметры из консоли $argv (недоступно если register_argc_argv установлен в disabled)
$request = array();
if (isset($argv) && is_array($argv)){
    foreach ($argv as $value){
        $tecArr = preg_split("/=/", $value);
        if (isset($tecArr[0]) && $tecArr[0]!='' && isset($tecArr[1])){$request["{$tecArr[0]}"] = trim($tecArr[1]);}
    }
}

echo "Script to DB migration.\n";

$dbAlias = (!empty($request['db']))?$request['db']:'';
$db = new MNBVMigration($dbAlias);

if (!empty($dbAlias) && false!==$db->getConfig($config)){//Изменения только для режима редактирования

    if(isset($request['info'])||isset($request['migrate'])) {

        $this->loadMigrations();
        $this->findNewMigrations();
        echo "Complete migrations:\n";
        foreach($this->migrationsLog as $value) echo $value."\n";
        echo "Database: $dbAlias current version ".$db->getDbFullVersion()."\n";

        if(isset($request['migration'])) {
            echo "Run migrations files:\n";
            foreach($this->newMigrations as $value) {
                if (!empty($value)){
                    echo $value."\n";
                    $this->migrate($value);
                }
            }
        }else{
            echo "New migrations files:\n";
            foreach($this->newMigrations as $value) echo $value."\n";
        }

    }if(isset($request['dump'])) {

        $this->loadMigrations();
        echo "Database: $dbAlias current version ".$db->getDbFullVersion()."\n";
        $this->dump();

    }else{
        echo "
COMMAND:
php migration.php [db=dbAlias] [help|info|migrate]

dbAlias - database alias for info or migrate
help - info about script
info - info about database status and version
migrate - run migrations
dump - create databse dump
------------------------
";
    }

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
    private $version = '01';

    /**
     * @var string текущая подверсия БД
     */
    private $subversion = '000';

    /**
     * @var array массив выполненных файлов миграций
     */
    public $migrationsLog = array();

    /**
     * @var array массив выполненных файлов миграций
     */
    private $migrations = array();

    /**
     * @var array массив файлов миграций для выполнения
     */
    private $newMigrations = array();

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









        return true;
    }

    /**
     * Загружает из файла список миграций и формирует массивы.
     * @return bool результат операции
     */
    public function loadMigrations(){

        $fileName = str_replace('[dbAlias]',$this->dbAlias,$this->migrationStatusFile);

        if (!$file = fopen($fileName,'r')){
            echo "File [$fileName] Error!\n";
            return false;
        }else{
            $strCounter = 0;
            $this->migrationsLog = array();
            $this->migrations = array();
            $error = false;
            while (!feof($file)){
                $str=fgets($file, 255);
                $str=trim($str);
                if (!$str) continue;
                if (empty($str)) continue;
                $tecArr = preg_split("/|/", $str);

                //date-start|Название файла|Номер|Версия|Подверсия|Комментарий|date-stop
                $currMigrFileName = trim($tecArr[1]);
                if (empty($currMigrFileName)) continue;

                if (empty($tecArr[6])) $str .= 'Error!';
                $this->migrationsLog[] = $str;
                $this->migrations[] = $currMigrFileName;

                if (empty($tecArr[6])) $error = true; else $error = false;

                $strCounter++;
            }

            if ($error) $this->error = true; //Если последняя запись с ошибкой, то продолжать нельзя, пока ошибка не будет устранена
            return true;
        }
    }

    /**
     * Загружает из папки список файлов миграций, исключает те из них, которые выполнены и формирует массив $this->newMigrations.
     * @return bool результат операции
     */
    public function findNewMigrations(){

        $Dir_list = opendir($this->dbAlias.'v'.$this->version);
        while ($tec_file_nam = readdir($Dir_list)) if (!is_dir($Dir_list.'/'.$tec_file_nam)){
            $this->migrations[] = $tec_file_nam;
        }
        closedir($Dir_list);
        sort($this->migrations);
        reset($this->migrations);

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
        return $this->$version.'.'.$this->subversion;
    }

    /**
     * Выгружает дамп выбранной базы данных в директорию "dumps".
     * @return bool результат операции
     */
    public function dump(){








        return true;
    }

    /**
     * Выполняет файл миграции для выбранной базы данных.
     * @return bool результат операции
     */
    public function migrate(){








        return true;
    }

}
