<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.08.18
 * Time: 11:59
 */

class TestObj2 {

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
        return array('articul','original_id','price_rub1','price_usd1','price_rub2','price_usd2','price_rub3','price_usd3');
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
        $end_text = '</span></small>';  
        $this->data['articul'] = ParserBf::text_between($content, $start_text, $end_text);
        
        $start_text = 'original_id="';
        $end_text = '"';  
        $this->data['original_id'] = ParserBf::text_between($content, $start_text, $end_text);
            
        //Ваша цена блок
        $start_text = 'Ваша цена &mdash;
        <nobr>
                                            <span class="price currency_select" rel="rub"';
        $end_text = 'Оптовая цена &mdash;';
        $preceBlock = ParserBf::text_between($content, $start_text, $end_text);
        
        //Ваша цена рубли
        $start_text = 'original_id="'.$this->data['original_id'].'">';
        $end_text = '<span';  
        $this->data['price_rub1'] = ParserBf::text_between($preceBlock, $start_text, $end_text);
        $this->data['price_rub1'] = trim(preg_replace("/[^0-9\.,]/i","",$this->data['price_rub1']));
        $this->data['price_rub1'] = str_replace(".", ",", $this->data['price_rub1']);
        //echo "start_text=[$start_text] price_rub1=[".$this->data['price_rub1']."]";
        
        //Ваша цена $
        $start_text = 'display: none;">';
        $end_text = '<span';  
        $this->data['price_usd1'] = ParserBf::text_between($preceBlock, $start_text, $end_text);
        $this->data['price_usd1'] = trim(preg_replace("/[^0-9\.,]/i","",$this->data['price_usd1']));
        $this->data['price_usd1'] = str_replace(".", ",", $this->data['price_usd1']);
        //echo " price_usd1=[".$this->data['price_usd1']."]\n";
        
        
        //Оптовая цена блок
        $start_text = 'Оптовая цена &mdash;';
        $end_text = 'Специальная цена &mdash;';
        $preceBlock = ParserBf::text_between($content, $start_text, $end_text);
        
        //echo '['.$preceBlock ."]\n";
        
        //Оптовая цена рубли
        $start_text = 'original_id="'.$this->data['original_id'].'"';
        $end_text = '<span';
        $this->data['price_rub2'] = ParserBf::text_between($preceBlock, $start_text, $end_text);
        $this->data['price_rub2'] = trim(preg_replace("/[^0-9\.,]/i","",$this->data['price_rub2']));
        $this->data['price_rub2'] = str_replace(".", ",", $this->data['price_rub2']);
        //echo "start_text=[$start_text] price_rub2=[".$this->data['price_rub2']."]";
        
        //Оптовая цена $
        $start_text = 'display: none;">';
        $end_text = '<span';  
        $this->data['price_usd2'] = ParserBf::text_between($preceBlock, $start_text, $end_text);
        $this->data['price_usd2'] = trim(preg_replace("/[^0-9\.,]/i","",$this->data['price_usd2']));
        $this->data['price_usd2'] = str_replace(".", ",", $this->data['price_usd2']);
        //echo " price_usd2=[".$this->data['price_usd2']."]\n";
        
        
        //Специальная цена блок
        $start_text = 'Специальная цена &mdash;';
        $end_text = '</span>
    </small>  <p><a href';
        $preceBlock = ParserBf::text_between($content, $start_text, $end_text);
        
        //Специальная цена рубли
        $start_text = 'original_id="'.$this->data['original_id'].'"';
        $end_text = '<span';  
        $this->data['price_rub3'] = ParserBf::text_between($preceBlock, $start_text, $end_text);
        $this->data['price_rub3'] = trim(preg_replace("/[^0-9\.,]/i","",$this->data['price_rub3']));
        $this->data['price_rub3'] = str_replace(".", ",", $this->data['price_rub3']);
        
        //Специальная цена $
        $start_text = 'display: none;"';
        $end_text = '<span';  
        $this->data['price_usd3'] = ParserBf::text_between($preceBlock, $start_text, $end_text);
        $this->data['price_usd3'] = trim(preg_replace("/[^0-9\.,]/i","",$this->data['price_usd3']));
        $this->data['price_usd3'] = str_replace(".", ",", $this->data['price_usd3']);
        
    }

} 