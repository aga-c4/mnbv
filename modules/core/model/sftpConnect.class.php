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
 *      $sftp = new SftpConnect('localhost');
 *      $sftp->login('tester', 'password');
 *      $sftp->upload("D:/progressorD/config.txt", "config.txt");
 *      $ret = $sftp->download("config.txt", "D:/progressorD/config.php");
 *      if($ret){echo 'Ok!';}
 * }
 * catch (Exception $e)
 * {
 *      echo $e->getMessage() . "\n";
 * }
 *
 */

//set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');

class sftpConnect{

    /**
     * @var Net_SFTP линк на соединение
     */
    private $connection;

    public function __construct($host, $port=22, $timeout = 90){
        require_once APP_VENDORS . 'phpseclib/Net/SFTP.php';
        $this->connection = new Net_SFTP($host, $port,  $timeout);
        if (!$this->connection){
            throw new Exception("Could not connect to $host on port $port.");
        }
    }

    /**
     * SFTP авторизация
     * @param $username
     * @param $password
     * @return bool
     * @throws Exception
     */
    public function login($username, $password){
        if (!$this->connection->login($username, $password)) {
            throw new Exception("Could not authenticate");
        }
        return true;
    }

    /**
     * SFTP авторизация RSA
     * @param $username
     * @param $privatekey
     * @return bool
     * @throws Exception
     */
    public function loginRSA($username, $privatekey) {
        $key = new Crypt_RSA();
        $key->loadKey(file_get_contents($privatekey));
        if (!$this->connection->login($username, $key)) {
            throw new Exception("Could not authenticate");
        }
        return true;
    }

    /**
     * SFTP авторизация PPRSA
     * @param $username
     * @param $privatekey
     * @param $password
     * @throws Exception
     */
    public function loginPPRSA($username, $privatekey, $password) {
        $key = new Crypt_RSA();
        $key->setPassword($password);
        $key->loadKey(file_get_contents($privatekey));
        if (!$this->connection->login($username, $key)) {
            throw new Exception("Could not authenticate");
        }
    }

    /**
     * SFTP загрузка файла на сервер
     * @param $local_file
     * @param $remote_file
     * @return bool
     * @throws Exception
     */
    public function upload($local_file, $remote_file) {
        if(file_exists($local_file)){
            $fp = fopen($local_file, 'r');
            if ($this->connection->put($remote_file, $fp)) {
                return true;
            } else {
                throw new Exception("Could not upload file");
            }
            fclose($fp);
        } else {
            throw new Exception("Local file not found");
        }
        return false;
    }

    /**
     * SFTP скачивание файла
     * @param $remote_file
     * @param $local_file
     * @return bool
     * @throws Exception
     */
    public function download($remote_file, $local_file) {
        if ($this->connection->get($remote_file,$local_file)) {
            return true;
        } else {
            throw new Exception("Could not download file");
        }
        return false;
    }

} 