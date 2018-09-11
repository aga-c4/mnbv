<?php
/**
 * RobotsController class - класс работы с Telegram
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVTelegram{

    /**
     * @var type URL коннекта без авторизации 
     */
    public $apiUrl = "https://api.telegram.org/";
    
    /**
     * @var type API token 
     */
    public $token = '';

    /**
     * @var type идентификатор чата
     */    
    public $chatId = '';

    /**
     * @var string массив настроек proxy
     */
    public $proxy = '';
    
    
    public function __construct($token='',$chatId='',$proxy='') {
        if (!empty($token)) $this->token = $token;
        if (!empty($chatId)) $this->chatId = $chatId;
        if (!empty($proxy)) $this->proxy = $proxy;
    }

    
    /**
     * Выполняет запрос к telegram
     * @param type $method метод
     * @param type $req массив с передаваемыми данными. Если в них есть chat_id, то он остается, иначе берется из свойств объекта
     * @param type $token Если задан, то используется в качестве token, иначе он берется из свойства объекта
     * @param type $params Массив параметров, тип array("proxy"=>array("host"=>"","port"=>"","login"=>"","passwd":""))
     * @return type array результат операции или NULL, если не успешно
     */
    public function telegramApiQuery($method, $req = array(), $token='', $params='') {
       
        if (!in_array($method, array('getUpdates','sendMessage'))) return false;
        $realToken = (!empty($token))?$token:$this->token;
        
        $headers = array();
        if ($method=='sendMessage') {
            if (!is_array($req) || empty($req['chat_id'])) $req['chat_id'] = $this->chatId;;
        }
        $post_data = http_build_query($req, '', '&');
        $apiUrl = $this->apiUrl . 'bot' . $realToken . '/' . $method;


        /*
        $prxy       = 'http://94.130.223.179:1080'; // адрес:порт прокси
        $prxy_auth = 'auth_user:auth_pass';       // логин:пароль для аутентификации
        /**************** /
        $ch  = curl_init();
        $url = "https://api.telegram.org/botXXXXX/sendMessage?chat_id=XXXXX&text=XXXXX"; // где XXXXX - ваши значения
        curl_setopt_array ($ch, array(CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true));
        /********************* Код для подключения к прокси ********************* /
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);  // тип прокси
        curl_setopt($ch, CURLOPT_PROXY,  $prxy);                 // ip, port прокси
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $prxy_auth);  // авторизация на прокси
            curl_setopt($ch, CURLOPT_HEADER, false);                // отключение передачи заголовков в запросе
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            // возврат результата в качестве строки
            curl_setopt($ch, CURLOPT_POST, 1);                      // использование простого HTTP POST
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        // отмена проверки сертификата удаленным сервером
        /*********************************************************************** /
        $result = curl_exec($ch);  // DIGITAL RESISTANCE!
        curl_close($ch);
        */


        $ch = null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; SMART_API PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);                      // использование простого HTTP POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING , 'gzip');

        if (is_array($this->proxy && !empty($this->proxy['host']))){
            //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy['host']);
            if (!empty($params['proxy']['port'])) curl_setopt($ch, CURLOPT_PROXYPORT, $params['proxy']['port']);
            if (!empty($params['proxy']['passwd'])) curl_setopt($ch, CURLOPT_PROXYUSERPWD, $params['proxy']['passwd']);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }

        $res = curl_exec($ch);
        if($res === false)
        {
            $e = curl_error($ch);
            //debuglog($e);
            curl_close($ch);
            return false;
        }


        curl_close($ch);

        $result = json_decode($res, true);
        //if(!$result) debuglog($res);

        return $result;
    }

}
