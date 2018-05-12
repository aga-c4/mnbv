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
     * @return type array результат операции или false, если не успешно
     */
    public function sendPush($token,$param=array()) {
       
        if (!is_array($token)&&empty($token)) return false;
        if (!is_array($param)) return false;
        
        if (!empty($param['title'])) $title = SysBF::getFrArr($param,'title',$this->title);
        if (!empty($param['body'])) $body = SysBF::getFrArr($param,'body',$this->body);
        if (!empty($param['icon'])) $icon = SysBF::getFrArr($param,'icon',$this->icon);
        if (!empty($param['click_action'])) $click_action = SysBF::getFrArr($param,'click_action',$this->click_action);
        if (!empty($param['time_to_live'])) $time_to_live = intval(SysBF::getFrArr($param,'time_to_live',$this->time_to_live));
        
        $request_headers = array(
            'Content-Type: application/json',
            'Authorization: key=' . $this->key,
        );

        if (!is_array($token)) $tokenArr = array($token); else $tokenArr = $token;
        
        foreach($tokenArr as $key=>$value){
            $query = [
                'to' => $value,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'icon' => $icon,
                    'click_action' => $click_action,
                ],
                "time_to_live" => $time_to_live
            ];
            MNBVf::sendCurlQuery($this->apiUrl,$query,array('headers'=>$request_headers));
        }
        
        return true;

    }

}
