<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.08.18
 * Time: 11:59
 */

class TestObj {

    public $data = array();
    
    /**
     * Конструктор
     * @param $content объект для парсинга
     */
    public function __construct($content){

        $this->parse($content);
        
    }
    
    //Возвращает стурктуру объекта в массиве
    public static function getStru(){
        return array('articul','articul2','original_id','price_rub','price_usd','price_rub1','price_usd1','price_rub2','price_usd2','price_rub3','price_usd3','instock','url');
    }

    /**
     * Принимает контент и создает список структурированных данных.
     * Хотим получить:
     *   - список товаров с URL, артикул, цена, маленькое изображение
     * @param type $content
     */
    public function parse($content){
        
        //strtoloyer(preg_replace("/[^A-Za-zА-Яа-я0-9]/i","",$string));
        
        $start_text = '<small>Артикул: <span class="orange">';
        $end_text = '</span>';  
        $this->data['articul'] = ParserBf::text_between($content, $start_text, $end_text);
        
        $start_text = 'original_id="';
        $end_text = '"';  
        $this->data['original_id'] = ParserBf::text_between($content, $start_text, $end_text);
            
        $start_text = '<span class="price currency_select" rel="rub"
                      original_id="'.$this->data['original_id'].'">';
        $end_text = '<span';  
        $this->data['price_rub'] = ParserBf::text_between($content, $start_text, $end_text);
        $this->data['price_rub'] = trim(preg_replace("/[^0-9\.,]/i","",$this->data['price_rub']));
        $this->data['price_rub'] = str_replace(",", ".", $this->data['price_rub']);
        
        $start_text = '<span class="price currency_select" rel="usd"
                      original_id="'.$this->data['original_id'].'"
                      style="display: none;">';
        $end_text = '<span';  
        $this->data['price_usd'] = ParserBf::text_between($content, $start_text, $end_text);
        $this->data['price_usd'] = trim(preg_replace("/[^0-9\.,]/i","",$this->data['price_usd']));
        $this->data['price_usd'] = str_replace(".", ",", $this->data['price_usd']);
        
        $start_text = 'Наличие:   <a title="" href="javascript:;" class="type-help onfocus"><em class="orange">';
        $end_text = '</em>';  
        $this->data['instock'] = ParserBf::text_between($content, $start_text, $end_text);
        
        $start_text = '</div>
    <h2 class="blue item_name"><a
                href="';
        $end_text = '"';  
        $this->data['url'] = 'https://test.domain' . ParserBf::text_between($content, $start_text, $end_text);
        
    }

} 