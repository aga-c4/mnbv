<?php
/**
 * RobotsController class - класс работы с пушами 
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVPush{

    /**
     * @var type URL коннекта без авторизации 
     */
    public $apiUrl = "https://fcm.googleapis.com/fcm/send";
    
    /**
     * @var string API key - нашего сервера 
     */
    public $key = '';

    /**
     * @var string  заголовок сообщения
     */
    public $title = '';
    
    /**
     * @var string иконка
     */
    public $icon = '';
    
    /**
     * @var string время жизни сообщения в секундах (час по-умолчанию)
     */
    public $time_to_live = 3600;
    
    
    public function __construct($key='',$param=array()) {
        if (!empty($key)) $this->key = $key;
        if (is_array($param)) {
            if (!empty($param['title'])) $this->title = $param['title'];
            if (!empty($param['icon'])) $this->icon = $param['icon'];
            if (!empty($param['time_to_live'])) $this->time_to_live = $param['time_to_live'];
        }
    }

    
    /**
     * Выполняет запрос к telegram
     * @param type $method метод
     * @param type $req массив с передаваемыми данными. Если в них есть chat_id, то он остается, иначе берется из свойств объекта
     * @param type $token Если задан, то используется в качестве token, иначе он берется из свойства объекта
     * @return type array результат операции или NULL, если не успешно
     */
    public function telegramApiQuery($method, $req = array(), $token='') {
       
        if (!in_array($method, array('getUpdates','sendMessage'))) return false;
        $realToken = (!empty($token))?$token:$this->token;
        
        $headers = array();
        if ($method=='sendMessage') {
            if (!is_array($req) || empty($req['chat_id'])) $req['chat_id'] = $this->chatId;;
        }
        $post_data = http_build_query($req, '', '&');
        $apiUrl = $this->apiUrl . 'bot' . $realToken . '/' . $method;
        
        $ch = null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; SMART_API PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING , 'gzip');
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
