<?php
/**
 * Класс работы с FTP
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 *
 * Пример работы:
 *
 * try
 * {
 *      $ftp = new FtpConnect('localhost');
 *      $ftp->login('TestUser', 'BloodRose');
 *      $ret = $ftp->download("config.txt", "D:/progressorD/config.php");
 *      if($ret){echo 'Ok!';}
 *      $ftp->ftpClose();
 * }
 * catch (Exception $e)
 * {
 *      echo $e->getMessage() . "\n";
 * }
 *
 */

class FtpConnect {

    /**
     * @var resource линк ftp соединения
     */
    private $connection;

    /**
     * Конструктор
     * @param $host
     * @param int $port
     * @param int $timeout
     */
    public function __construct($host, $port=21, $timeout = 90){
        $this->connection = ftp_connect($host, $port, $timeout);
        if (!$this->connection) {
            //SysLogs::addError("FtpConnect: Could not connect to $host on port $port");
            throw new Exception("FtpConnect: Could not connect to $host on port $port.");
            return false;
        }
        //SysLogs::addLog("FtpConnect: Connect to $host on port $port");
        return true;
    }

    /**
     * FTP авторизация
     * @param $username логин
     * @param $password пароль
     * @return bool результат операции
     */
    public function login($username, $password){
        if (!ftp_login($this->connection, $username, $password)){
            //SysLogs::addError("FtpConnect: Could not authenticate");
            throw new Exception("FtpConnect: Could not authenticate");
            return false;
        }
        //SysLogs::addLog("FtpConnect: Authenticate");
        return true;
    }

    /**
     * Отправка файла на FTP сервер
     * @param $local_file путь к локальному файлу
     * @param $remote_file название удаленного файла
     * @return bool результат операции
     */
    public function upload($local_file, $remote_file) {
        if(file_exists($local_file)){
            $fp = fopen($local_file, 'r');
            if (ftp_fput($this->connection, $remote_file, $fp, FTP_ASCII)) {
                //SysLogs::addLog("FtpConnect: upload file [$local_file]");
                fclose($fp);
                return true;
            } else {
                fclose($fp);
                //SysLogs::addError("FtpConnect: Could not upload file [$local_file]");
                throw new Exception("FtpConnect: Could not upload file [$local_file]");
                return false;
            }
        } else {
            //SysLogs::addError("FtpConnect: Local file [$local_file] not found");
            throw new Exception("Local file not found");
            return false;
        }
    }

    /**
     * Закачка файла с FTP сервера
     * @param $remote_file название удаленного файла
     * @param $local_file путь к локальному файлу
     * @return bool результат операции
     */
    public function download($remote_file, $local_file) {
        $handle = fopen($local_file, 'w');
        if (ftp_fget($this->connection, $handle, $remote_file, FTP_ASCII, 0)) {
            //SysLogs::addLog("FtpConnect: download remote file [$remote_file]");
            fclose($handle);
            return true;
        } else {
            //SysLogs::addError("FtpConnect: Could not download remote file [$remote_file]");
            throw new Exception("FtpConnect: Could not download remote file [$remote_file]");
            fclose($handle);
            return false;
        }
    }

    /**
     * Закрытие FTP соединения
     */
    public function ftpClose() {
        ftp_close($this->connection);
        return true;
    }

} 