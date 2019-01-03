<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.08.18
 * Time: 11:58
 */

class ParserPg {

    public $url = '';

    public $status = '';

    public $timestamp = '';

    public $header = '';

    public $content = '';
    
    public $lag = 0;
    
    public $data = array();

    public function __construct($url=''){
        $this->url = $url;
        if (!empty($url)) $this->upload();
    }

    /**
     * Получает по URL заголовок и страницу
     * @return int код возврата
     */
    public function upload(){

        if (true||$this->url!='https://shop.nag.ru/search?word=cisco&count=0'){
            $res = SysBf::curl($this->url,'',array('printheader'=>true));
            $this->timestamp = microtime(true);
            $this->header = ParserBf::text_between($res, '', "\r\n\r\n");
            $this->content = ParserBf::text_between($res, "\r\n\r\n" , '');
            $this->status = intval(ParserBf::text_between($this->header, ' ', " "));
            if ($this->url=='https://shop.nag.ru/search?word=cisco&count=0') SysBf::saveFile('tmp/nag-source.csv',$this->content); 
        }else{
            $this->content = file_get_contents('D:\OSPanel\domains\parser\tmp\nag-source.csv');
            $this->header = '';
            $this->status = 200;
        }
        
        return $this->status;

    }
    
    /**
     * Принимает контент и создает список структурированных данных.
     * @param type $content
     */
    public function parse($content){
        $start_text = '<small>Артикул: <span class="orange">';
        $end_text = '</span>';  
        $this->data['articul'] = ParserBf::text_between($content, $start_text, $end_text);
    }

} 