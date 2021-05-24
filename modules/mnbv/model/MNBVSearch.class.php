<?php
/**
 * Класс работы с поисковыми индексами, полями и др.
 * 
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 24.05.21
 * Time: 18:04
 */
class MNBVSearch {
    
    public $Stem_Caching = 0;
    public $Stem_Cache = array();
    public $VOWEL = '/аеиоуыэюя/';
    public $PERFECTIVEGROUND = '/((ив|ивши|ившись|ыв|ывши|ывшись)|((?<=[ая])(в|вши|вшись)))$/';
    public $REFLEXIVE = '/(с[яь])$/';
    public $ADJECTIVE = '/(ее|ие|ые|ое|ими|ыми|ей|ий|ый|ой|ем|им|ым|ом|его|ого|еых|ую|юю|ая|яя|ою|ею)$/';
    public $PARTICIPLE = '/((ивш|ывш|ующ)|((?<=[ая])(ем|нн|вш|ющ|щ)))$/';
    public $VERB = '/((ила|ыла|ена|ейте|уйте|ите|или|ыли|ей|уй|ил|ыл|им|ым|ены|ить|ыть|ишь|ую|ю)|((?<=[ая])(ла|на|ете|йте|ли|й|л|ем|н|ло|но|ет|ют|ны|ть|ешь|нно)))$/';
    public $NOUN = '/(а|ев|ов|ие|ье|е|иями|ями|ами|еи|ии|и|ией|ей|ой|ий|й|и|ы|ь|ию|ью|ю|ия|ья|я)$/';
    public $RVRE = '/^(.*?[аеиоуыэюя])(.*)$/';
    public $DERIVATIONAL = '/[^аеиоуыэюя][аеиоуыэюя]+[^аеиоуыэюя]+[аеиоуыэюя].*(?<=о)сть?$/';

    public function s(&$s, $re, $to)
    {
        $orig = $s;
        $s = preg_replace($re, $to, $s);
        return $orig !== $s;
    }

    public function m($s, $re)
    {
        return preg_match($re, $s);
    }

    public function stem_word($word) 
    {
        $word = strtolower($word);
        $word = strtr($word, 'ё', 'е');
        # Check against cache of stemmed words
        if ($this->Stem_Caching && isset($this->Stem_Cache[$word])) {
            return $this->Stem_Cache[$word];
        }
        $stem = $word;
        do {
          if (!preg_match($this->RVRE, $word, $p)) break;
          $start = $p[1];
          $RV = $p[2];
          if (!$RV) break;

          # Step 1
          if (!$this->s($RV, $this->PERFECTIVEGROUND, '')) {
              $this->s($RV, $this->REFLEXIVE, '');

              if ($this->s($RV, $this->ADJECTIVE, '')) {
                  $this->s($RV, $this->PARTICIPLE, '');
              } else {
                  if (!$this->s($RV, $this->VERB, ''))
                      $this->s($RV, $this->NOUN, '');
              }
          }

          # Step 2
          $this->s($RV, '/и$/', '');

          # Step 3
          if ($this->m($RV, $this->DERIVATIONAL))
              $this->s($RV, '/ость?$/', '');

          # Step 4
          if (!$this->s($RV, '/ь$/', '')) {
              $this->s($RV, '/ейше?/', '');
              $this->s($RV, '/нн$/', 'н'); 
          }

          $stem = $start.$RV;
        } while(false);
        if ($this->Stem_Caching) $this->Stem_Cache[$word] = $stem;
        return $stem;
    }

    public function stem_caching($parm_ref) 
    {
        $caching_level = @$parm_ref['-level'];
        if ($caching_level) {
            if (!$this->m($caching_level, '/^[012]$/')) {
                die(__CLASS__ . "::stem_caching() - Legal values are '0','1' or '2'. '$caching_level' is not a legal value");
            }
            $this->Stem_Caching = $caching_level;
        }
        return $this->Stem_Caching;
    }

    public function clear_stem_cache() 
    {
        $this->Stem_Cache = array();
    }
    
    public static function prepareSearchSth($str){
        $res = $str;
        $res=preg_replace('/<[^>]*>/'," ",$res);        
        $res=preg_replace("/</"," ",$res);
        $res=preg_replace("/>/"," ",$res);
        $res=preg_replace("/%/"," ",$res);
        $res=preg_replace("/&/"," ",$res);
        $res=preg_replace("/(\s)+/"," ",$res);
        $search=trim($str, " \t.");
        return $res;
    }
    
}
