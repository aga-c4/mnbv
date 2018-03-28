<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.10.17
 * Time: 16:22
 */

class StorageRobotsrunListController {

    /**
     * ѕреобразует по требованию массив текущей строки и массив формата его вывода
     * @param $item массив элементов вывода
     * @return array
     */
    public function updateItem($obj=false,$view=false){
        $result = array(
            "item" => array(),
            "view" => array(),
            "viewline" => array(),
        );
        if ($obj===false) return $result;

        if ($view!==false && is_array($view)) $result['view'] = $view;

        //»зменение view
        if ($obj['status']=='working') $result['view']['viewline']['style'] = "background-color::green;font-weight:bold";
        elseif ($obj['status']=='paused') $result['view']['viewline']['style'] = "background-color::#ff6600;font-weight:bold";
        elseif ($obj['status']=='error'||$obj['status']=='starterror'||$obj['status']=='noresponse') $result['viewline']['style'] = "background-color::red;color:white;font-weight:bold";

        return $result;
    }

}

//$item["list_subfunct_obj"] = new StorageRobotsrunListController();
