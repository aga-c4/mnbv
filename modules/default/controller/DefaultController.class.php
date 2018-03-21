<?php
/**
 * User: AGA-C4
 * Date: 26.08.14
 * Time: 14:40
 */
 
/**
 * Default Controller class - дефолтовый контроллер
 */
class DefaultController{

    /**
     * @var string - Имя модуля контроллера (Внимание, оно должно соответствовать свойству $thisModuleName фронт контроллера модуля (используется во View)
     */
    public $thisModuleName = '';
    
    public function __construct($thisModuleName) {
        $this->thisModuleName = $thisModuleName;
    }

    /**
     * Метод по-умолчанию
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($tpl_mode='html', $console=false){
        $this->action_help($tpl_mode, $console);//Покажем хелп
    }

    /**
     * Вывод страницы помощи
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_help($tpl_mode='html', $console=false){

        $help_txt = '
-------
Format:
php init.php [module=...] [controller=...] [action=...] [tpl_mode=...]
Don\'t print Space near "="

Controllers:
default - default controller

Actions:
help - read Help Information
hello - view Hello World! If [name=...], then Hello ...!

tpl_mode:
html - to view result as html file
txt  - to view result as txt file
json - to view result in json format
-------
';

        if ($tpl_mode=='html'){$help_txt = "<pre>$help_txt</pre>";}

        //Установим глобальные метатеги для данной страницы
        Glob::$vars['page_title'] = 'Help'; //Метатег title
        Glob::$vars['page_keywords'] = 'Help'; //Метатег keywords
        Glob::$vars['page_description'] = 'Help'; //Метатег description
        Glob::$vars['page_h1'] = 'Help'; //Содержание основного заголовка страницы

        $item = array(); //Массив данных, передаваемых во View
        $item['page_content'] = $help_txt;

        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        //View------------------------
        switch ($tpl_mode) {
            case "html": //Вывод в html формате для Web 
                require_once APP_MODULESPATH . Glob::$vars['module'] . '/view/main.php';
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
     * Hello World!
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_hello($tpl_mode='html', $console=false){

        $item = array(); //Массив данных, передаваемых во View
        if (isset(Glob::$vars['request']['name'])){$helloText = 'Hello ' . SysBF::checkStr(Glob::$vars['request']['name'],'string',255) . '!';}
        else {$helloText = 'Hello World!';}

        $item['page_content'] = $helloText;
        if ($tpl_mode=='html'){$item['page_content'] .= "\n<br><img src=\"/" . APP_SRCPATH . self::$thisModuleName ."/img/smile.jpg\">";}

        //Установим глобальные метатеги для данной страницы
        Glob::$vars['page_title'] = $helloText; //Метатег title
        Glob::$vars['page_keywords'] = $helloText; //Метатег keywords
        Glob::$vars['page_description'] = $helloText; //Метатег description
        Glob::$vars['page_h1'] = 'It\'s works!'; //Содержание основного заголовка страницы

        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        //View------------------------
        switch ($tpl_mode) {
            case "html": //Вывод в html формате для Web
                require_once APP_MODULESPATH . $this->thisModuleName . '/view/main.php';
                break;
            case "txt": //Вывод в текстовом формате для консоли
                require_once APP_MODULESPATH . $this->thisModuleName . '/view/txtmain.php';
                break;
            case "json": //Вывод в json формате
                if (!Glob::$vars['console']){header('Content-Type: text/json; charset=UTF-8');}
                echo Glob::$vars['json_prefix'] . json_encode($item);
                break;
        }

    }

    /**
     * Тест баз данных!
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_dbtest($tpl_mode='html', $console=false){

        $maxitems = 10000;//Количество итераций теста

        $item = array(); //Массив данных, передаваемых во View
        $page_content = "\nTest DB (maxitems=$maxitems):\n\n";
        $helloText = 'Test DB';

        //Тест для MySQL
        $page_content .= "MySQL:\n";
        //DbMysql::$dbParams['default']['database']='new';
        //DbMysql::$dbParams['default']['user']='root';
        //$myDb = DbMysql::getInstance();

        SysStorage::$db['mysql1']['database']='new';
        SysStorage::$db['mysql1']['user']='root';
        $myDb = SysStorage::getLink('test');

        //INSERT
        $testtime = microtime(true);
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++)$myDb->query("insert into test (id,text) values ($i,'test message');");
        $times = microtime(true) - $timestart;
        $page_content .= "INSERT: $times s\n";

        //UPDATE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++)$myDb->query("update test set text='test message2' where id=$i;");
        $times = microtime(true) - $timestart;
        $page_content .= "UPDATE: $times s\n";

        //SELECT
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){$teststr = DbMysql::mysql_fetch_array($myDb->query("select id,text from test where id=$i;"));}
        $times = microtime(true) - $timestart;
        $page_content .= "SELECT: $times s\n";

        //DELETE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++)$myDb->query("delete from test where id=$i;");
        $times = microtime(true) - $timestart;
        $page_content .= "DELETE: $times s\n";

        //ALL TIME
        $page_content .= "---> MYSQL_TIME: " . (microtime(true) - $testtime) . " s\n\n";


        //Тест для MySQL Memmory
        $page_content .= "MySQL Memmory:\n";
        $myDb = SysStorage::getLink('testmem');

        //INSERT
        $testtime = microtime(true);
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++)$myDb->query("insert into testmem (id,text) values ($i,'test message');");
        $times = microtime(true) - $timestart;
        $page_content .= "INSERT: $times s\n";

        //UPDATE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++)$myDb->query("update testmem set text='test message2' where id=$i;");
        $times = microtime(true) - $timestart;
        $page_content .= "UPDATE: $times s\n";

        //SELECT
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){$teststr = DbMysql::mysql_fetch_array($myDb->query("select id,text from testmem where id=$i;"));}
        $times = microtime(true) - $timestart;
        $page_content .= "SELECT: $times s\n";

        //DELETE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++)$myDb->query("delete from testmem where id=$i;");
        $times = microtime(true) - $timestart;
        $page_content .= "DELETE: $times s\n";

        //ALL TIME
        $page_content .= "---> MYSQL_MEMORY_TIME: " . (microtime(true) - $testtime) . " s\n\n";

/*
        //Тест для MongoDB
        $page_content .= "MongoDB:\n";
        $mongoDb = new Mongo();

        //INSERT
        $testtime = microtime(true);
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $testtxt = array("_id" => $i,"text" =>  "test message");
            $mongoDb->test->test1->insert($testtxt);
        }
        $times = microtime(true) - $timestart;
        $page_content .= "INSERT: $times s\n";

        //UPDATE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $testtxt = array("_id" => $i);
            $testtxt2 = array("_id" => $i,"text" =>  "test message2");
            $mongoDb->test->test1->update($testtxt,$testtxt2);
        }
        $times = microtime(true) - $timestart;
        $page_content .= "UPDATE: $times s\n";

        //SELECT
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $testtxt = array("_id" => $i);
            $mongoDb->test->test1->findOne($testtxt);
        }
        $times = microtime(true) - $timestart;
        $page_content .= "SELECT: $times s\n";

        //DELETE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $testtxt = array("_id" => $i);
            $mongoDb->test->test1->remove($testtxt);
        }
        $times = microtime(true) - $timestart;
        $page_content .= "DELETE: $times s\n";

        //ALL TIME
        $page_content .= "---> Mongo_TIME: " . (microtime(true) - $testtime) . " s\n\n";


        //Тест для Memcached
        $page_content .= "Memcached:\n";
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) or die ("Could not connect");

        //INSERT
        $testtime = microtime(true);
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $memcache->set("$i", "test message", false, 10);
        }
        $times = microtime(true) - $timestart;
        $page_content .= "INSERT: $times s\n";

        //UPDATE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $memcache->set("$i", "test message2", false, 10);
        }
        $times = microtime(true) - $timestart;
        $page_content .= "UPDATE: $times s\n";

        //SELECT
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $memcache->get("$i");
        }
        $times = microtime(true) - $timestart;
        $page_content .= "SELECT: $times s\n";

        //DELETE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $memcache->delete("$i",10);
        }
        $times = microtime(true) - $timestart;
        $page_content .= "DELETE: $times s\n";

        //ALL TIME
        $page_content .= "---> Memcached_TIME: " . (microtime(true) - $testtime) . " s\n\n";



        //Тест для Redis
        $page_content .= "Redis:\n";
        $redis = new Redis();
        $redis->connect('localhost:6379') or die ("Could not connect");

        //INSERT
        $testtime = microtime(true);
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $redis->set("$i", "test message");
        }
        $times = microtime(true) - $timestart;
        $page_content .= "INSERT: $times s\n";

        //UPDATE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $redis->set("$i", "test message2");
        }
        $times = microtime(true) - $timestart;
        $page_content .= "UPDATE: $times s\n";

        //SELECT
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $redis->get("$i");
        }
        $times = microtime(true) - $timestart;
        $page_content .= "SELECT: $times s\n";

        //DELETE
        $timestart = microtime(true);
        for ($i=1;$i<=$maxitems;$i++){
            $redis->delete("$i",10);
        }
        $times = microtime(true) - $timestart;
        $page_content .= "DELETE: $times s\n";
*/
        //ALL TIME
        $page_content .= "---> Redis_TIME: " . (microtime(true) - $testtime) . " s\n\n";



        if ($tpl_mode=='html'){$page_content = "<pre>$page_content</pre>";}

        $item['page_content'] = $page_content;

        //Установим глобальные метатеги для данной страницы
        Glob::$vars['page_title'] = $helloText; //Метатег title
        Glob::$vars['page_keywords'] = $helloText; //Метатег keywords
        Glob::$vars['page_description'] = $helloText; //Метатег description
        Glob::$vars['page_h1'] = 'It\'s works!'; //Содержание основного заголовка страницы

        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        //View------------------------
        switch ($tpl_mode) {
            case "html": //Вывод в html формате для Web
                require_once APP_MODULESPATH . $this->thisModuleName . '/view/main.php';
                break;
            case "txt": //Вывод в текстовом формате для консоли
                require_once APP_MODULESPATH . $this->thisModuleName . '/view/txtmain.php';
                break;
            case "json": //Вывод в json формате
                if (!Glob::$vars['console']){header('Content-Type: text/json; charset=UTF-8');}
                echo Glob::$vars['json_prefix'] . json_encode($item);
                break;
        }

    }
	
}

