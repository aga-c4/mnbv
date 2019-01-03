<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.08.18
 * Time: 11:59
 */

class TestObjList {

    /**
     * @var array массив, содержащий данные по списку объектов типа: {"url":'',"name":'',...}. Обязательный эелемент "url"
     */
    public $list = array();
 
    /**
     * Конструктор
     * @param $content для парсинга
     */
    public function __construct($content){

        $this->parse($content);
        
    }

    /**
     * Принимает контент и создает список структурированных данных
     * @param type $content
     * @return bool результат операции (true/false)
     */
    public function parse($content){
        
        $start_text = '<div class="item_corn">';
        
        $end_text = '<div class="item_info"  >';
        
        $this->list = ParserBf::get_array($content, $start_text, $end_text);
        
    }


} 