<?php
/**
 * Класс работы с сессией пользователя
 * Помимо работы непосредственно с сессией, он формирует и поддерживает в актуальном состоянии Cookie:
 * - MNBVSID - идентификатор технической стабильной сессии
 * - MNBVSIDLONG - идентификатор сессии персонализации, которая живет максимально долго (до конца эпохи Unix) 
 * - MNBVSIDLV - время последнего захода Unix метка времени
 * - MNBVSIDSHORT - идентификатор технической стабильной сессии, которая живет только во время текущей сессии
 * Названия переменных Cookie берутся из соответствующих констант.
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVURL {
    
    /**
     * @var string Сайт по-умолчанию для формирования URL
     */
    public $defSiteId = 0; //Сайт по-умолчанию для формирования URL
    
    /**
     * @var string Дефолтовые типы объектов для формирования ЧПУ (URL) импортируется из Glob::$vars['url_types'] обычно.
     * cat_alias_view определяет наличие алиасов в URL ОБЪЕКТА, в категории он будет в любом случае
     * alias_delim - отделяет идентификатор объекта от алиаса объекта
     * item_postf - то, что идет после алиаса для всех объектов (к примеру закрывающий слеш)
     */
    public $urlTypes = array(
        "product" => array('id'=>1,'mod_pref'=>'catalog/','cat_alias_view'=>true,'item_pref'=>'pr_','alias_delim'=>'-','item_postf'=>''),  //Параметры товара
        "news" => array('id'=>2,'mod_pref'=>'news/','cat_alias_view'=>true,'item_pref'=>'nv_','alias_delim'=>'-','item_postf'=>''),        //Параметры новости
        "article" => array('id'=>3,'mod_pref'=>'articles/','cat_alias_view'=>true,'item_pref'=>'art_','alias_delim'=>'-','item_postf'=>''),//Параметры статьи
        "comment" => array('id'=>4,'mod_pref'=>'comments/','cat_alias_view'=>true,'item_pref'=>'cm_','alias_delim'=>'-','item_postf'=>''), //Параметры отзыв
    );
    
    /*
     * @param array $urlTypes - типы объектов для формирования ЧПУ (URL) импортируется из Glob::$vars['url_types'] обычно.
     * @param string $defSiteId - идентификатор сайта по-умолчанию.
     */
    public function __construct($urlTypes='notset', $defSiteId='notset') {
        if ($defSiteId!=='notset') $this->defSiteId = intval($defSiteId);
        if (is_array($urlTypes)) $this->urlTypes = $urlTypes;
    }

    /**
     * Вовращает относительный URL объекта по его идентификатору, типу и сайту
     * @param mixed $id идентификатор объекта
     * @param string $objtype тип объекта
     * @param mixed $siteId идентификатор сайта
     * @return string
     */
    public function getURLById($id,$objtype,$siteId='') {
        $result = null;
        if (!isset($this->urlTypes[$objtype])) return $result;
        if (empty($siteId)) $siteId = $this->defSiteId;

        $stRes = MNBVStorage::getObj(
            'urlaliases',
            array('alias','catalias'),
            array("siteid","=",$siteId,"and","objtype","=",$objtype,"and","idref","=",$id),
            array('limit'=>array(0,1)));
        $alias = (!empty($stRes[0])&&isset($stRes[1])&&isset($stRes[1]['alias']))?$stRes[1]['alias']:'';
        $catalias = (!empty($stRes[0])&&isset($stRes[1])&&isset($stRes[1]['catalias']))?$stRes[1]['catalias']:'';

        $result = '/';
        if (!empty($catalias)&&!empty($this->urlTypes['cat_alias_view'])) $result .= $catalias . '/';
        if (!empty($this->urlTypes['item_pref'])) $result .= $this->urlTypes['item_pref'];
        $result .= $id;
        if (!empty($alias)) $result .= ((!empty($this->urlTypes['alias_delim']))?$this->urlTypes['alias_delim']:'').$alias;
        if (!empty($this->urlTypes['item_postf'])) $result .= $this->urlTypes['item_postf'];

        return $result;
    }

    /**
     * Вовращает идентификатор объекта по относительному URL возможно не в полной комплектности
     * @param string $objtype тип объекта
     * @param string $url идентификатор объекта
     * @param mixed $siteId идентификатор сайта
     * @return mixed идентификатор объекта, обычно это int, если будет особая настройка системы, то идентификатор может быть string
     */
    public function getIdByURL($objtype,$url,$siteId='') {
        if (!isset($this->urlTypes[$objtype])) return null;
        if (empty($siteId)) $siteId = $this->defSiteId;

        $url = preg_replace("/\/$/",'',$url);
        $url = preg_replace("/^\//",'',$url);

        $itemMask = '/\/';
        if (!empty($this->urlTypes['item_pref'])) $itemMask .= $this->urlTypes['item_pref'];
        $itemMask .= '\d+/i';

        $refid = 0;
        $itemGetMask = preg_match($itemMask,$url,$matches);
        if (!empty($itemGetMask)){ //По регулярке пробуем найти объект
            $refid = intval($matches[0]);
        }
        if (!empty($refid)) return $refid;

        //Если объект не найден, то продолжим поиск категории объекта из базы URL
        $stRes = MNBVStorage::getObj(
            'urlaliases',
            array('idref'),
            array("siteid","=",$siteId,"and","objtype","=",$objtype,"and","alias","=",$url),
            array('limit'=>array(0,1)));
        $refid = (!empty($stRes[0])&&isset($stRes[1])&&isset($stRes[1]['idref']))?$stRes[1]['idref']:'';
        if (!empty($refid)) return $refid;

        return null;
    }

    /**
     * Создает или редактирует алиас для заданного объекта
     * @param mixed $id идентификатор объекта
     * @param string $objtype тип объекта
     * @param mixed $siteId идентификатор сайта
     * @param string $alias алиас объекта будут убраны слеши в начале и в конце
     * @param string $catalias алиас категории объекта будут убраны слеши в начале и в конце
     * @return bool
     */
    public function setItemAlias($objtype,$id,$alias,$catalias='notset',$siteId='notset') {
        $result = false;
        if (!isset($this->urlTypes[$objtype])) return $result;
        if ($siteId==='notset') $siteId = $this->defSiteId;
        $alias = preg_replace("/\/$/",'',$alias);
        $catalias = preg_replace("/\/$/",'',$catalias);
        $alias = preg_replace("/^\//",'',$alias);
        $catalias = preg_replace("^/\//",'',$catalias);

        $updateArr = array(
            "siteid" => $siteId, // Идентификатор сайта
            "objtype" => $objtype, // Идентификатор типа (в конфиге прописаны типы стандартные, можно дополнить)
            "alias" => $alias, //алиас объекта
            "idref" => $id, // Идентификатор объекта
        );
        if ($catalias!=='notset') $updateArr['catalias'] = $catalias;

        $stRes = MNBVStorage::getObj(
            'urlaliases',
            array('id'),
            array("siteid","=",$siteId,"and","objtype","=",$objtype,"and","idref","=",$id),
            array('limit'=>array(0,1)));
        $aliasId = (!empty($stRes[0])&&isset($stRes[1])&&isset($stRes[1]['id']))?$stRes[1]['id']:'';

        if (empty($aliasId)) {
            MNBVStorage::addObj('urlaliases', $updateArr, array(), false);
        } else {
            MNBVStorage::setObj('urlaliases', $updateArr, array("id","=",$aliasId), false);
        }

        return true;
    }

}
