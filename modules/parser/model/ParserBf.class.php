<?php
/**
 * User: aga-c4
 * Date: 28.08.18
 * Time: 11:58
 */

class ParserBf {

    /**
     * Выводит часть $source_text, ограниченная $start_text и $start_text 
     * @param type $source_text
     * @param type $start_text - если не задано, то с начала текста
     * @param type $end_text - если не задано, то до конца текста
     * @param type $counting какое вхождение нас интересует, не всегда это первое вхождение.
     * @return string
     */
    public static function text_between($source_text, $start_text = '', $end_text = '', $counting = 1) {
        $counting = ($counting == 0) ? 1 : $counting;
        $start_pos = -1;
        if ($start_text == '') {
            $start_pos = 0;
        } else {
            for ($i = 1; $i <= $counting; $i++) {
                $start_pos = strpos($source_text, $start_text, $start_pos + 1);
                if ($start_pos === false) break;
            }
        }
        if ($start_pos === false) {
            return '';
        } else {
            $start_pos = $start_pos + strlen($start_text);
        }
        $end_pos = false;
        if ($end_text == '') {
            $result = substr($source_text, $start_pos);
        } else {
            $end_pos = strpos($source_text, $end_text, $start_pos);
            if ($end_pos === false) {
                $result = substr($source_text, $start_pos);
            } else {
                $result = substr($source_text, $start_pos, $end_pos - $start_pos);
            }
        }
        return $result;
    }
        
        
    /**
     * Формирует массив элементов, ограниченных текстовыми маркерами
     * @param type $source_text исходный текст
     * @param type $start_text маркер начала
     * @param type $end_text маркер конца
     * @return array
     */
    public static function get_array($source_text, $start_text, $end_text) {
        $result = array();
        $start_pos = 0;
        $end_pos = 0;
        for ($i = 0; $i <= strlen($source_text); $i++) {
            $start_pos = strpos($source_text, $start_text, $i);
            if ($start_pos === false) {
                break;
            } else {
                $start_pos = $start_pos + strlen($start_text);
            }
            $end_pos = strpos($source_text, $end_text, $start_pos);
            if ($end_pos === false) {
                break;
            } else {
                array_push($result, substr($source_text, $start_pos, $end_pos - $start_pos));
                $i = $end_pos;
            }
        }
        return $result;
    }

} 