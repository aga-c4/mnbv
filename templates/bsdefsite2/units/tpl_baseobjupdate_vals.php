<?php
/**
 * Вывод формы редактирования свойств типового объекта
 * @param $usestorage - хранилище
 * @param array $obj - редактируемый объект
 * @param array $viewArr - массив, содержащий сведения о стурктуре объекта и его выводе
 * @param string $imgPath - путь к изображениям
 * @param bool $altlang - маркер альтернативного языка
 * @param string $prefView - префикс названия ключа объекта
 * @param string $prefKey - префикс вложенного ключа объекта (переменные, атрибуты, свойства атрибутов)
 * @param string $prefUpd - префикс данных вложенных ключей объектов
 * @param string $nameFr - как формировать имя "name" из соответствующего поля (по-умолчанию), "def-lang" из специальных полей "namedef" и "namelang"
 */
function valsGenerator ($usestorage, array $obj, array $viewArr, $imgPath='', $altlang=false, $prefView='ob_',$prefKey='obk_', $prefUpd='obd_', $nameFr = "name"){

    $pgid = SysBF::getFrArr($obj,'id',0); //Id данного объекта
    $vKey = (!empty($viewArr["name"]))?$viewArr["name"]:'clear'; //Название поля хранилища
    
    if (!isset($viewArr["active"])) $viewArr["active"] = "update";

    //Вид строки
    $delimStr = $colspanStr = $disablStr = $tdStr = $tdStr2 = $styleStr = $sizeStr = $rowsStr = '';
    if (!empty($viewArr["table"]) && ($viewArr["table"]=="tdline" || $viewArr["table"]=="thline")) $colspanStr = ' colspan="2"';
    if (!empty($viewArr["table"]) && ($viewArr["table"]=="th" || $viewArr["table"]=="thline")) {$tdStr = '<th class="line"'; $tdStr2 = '</th>';} else {$tdStr = '<td'; $tdStr2 = '</td>';}
    if (!empty($viewArr["width"])) $styleStr = ' style="width: '.$viewArr["width"].';"';
    if (!empty($viewArr["size"])) $sizeStr = ' size="'.$viewArr["size"].'"';
    if (!empty($viewArr["rows"])) $rowsStr = ' rows="'.((intval($viewArr["rows"]))?intval($viewArr["rows"]):5).'"';
    if (!empty($viewArr["active"]) && $viewArr["active"]=='noupdate') $disablStr = ' disabled';
    if (!empty($viewArr["delim"])) $delimStr = $viewArr["delim"];
    if (!empty($viewArr["viewindex"])) $viewindex = true; else $viewindex = false;

    //Название, если требуется
    $tecItNameView = Lang::get($vKey,'sysBaseObj');
    if ($nameFr == "def-lang"){
        if (!empty($viewArr["namedef"])) $tecItNameView = $viewArr["namedef"];
        if (!Lang::isDefLang() && !empty($viewArr["namelang"])) $tecItNameView = $viewArr["namelang"];
    }
    echo '<tr>'.$tdStr.$colspanStr.(($colspanStr=='')?('>'.$tecItNameView.$tdStr2.$tdStr):'').'>';

        if($viewArr["type"]=="lineblock") echo Lang::get(SysBF::getFrArr($viewArr,'string',''));
    elseif($viewArr["type"]=="submitstr") echo '<input class="bigsubmit_vid" value="'.Lang::get(SysBF::getFrArr($viewArr,'string','')).'" type="submit">';
    elseif($viewArr["type"]=="int") {
        if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,$vKey,''); //Это просто вывод данных
        else echo '<input type="text" name="'.$prefView.$vKey.'" value="'.SysBF::getFrArr($obj,$vKey,'').'"'.$styleStr.$sizeStr.$disablStr.'>';
    }elseif($viewArr["type"]=="checkbox"){
            $realVal = SysBF::getFrArr($obj,$vKey,0);
            if ($viewArr["active"]=="print") echo (!empty($realVal))?'<span style="color:green;font-weight:bold;">On</span>':'<span style="color:red;font-weight:bold;">Off</span>'; //Это просто вывод данных
            else echo '<input type="checkbox" name="'.$prefUpd.$vKey.'"'.((!empty($realVal))?' checked':'').''.$disablStr.'><input type="hidden" name="'.$prefView.$vKey.'" value="checkbox">';
    }elseif($viewArr["type"]=="text") {
        if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,$vKey,''); //Это просто вывод данных
        else echo '<input type="text" name="'.$prefView.$vKey.'" value="'.MNBVf::strToHtml(SysBF::getFrArr($obj,$vKey,'')).'"'.$styleStr.$sizeStr.$disablStr.'>';
    }elseif($viewArr["type"]=="password") {
        if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,$vKey,''); //Это просто вывод данных
        else echo '<input type="password" name="'.$prefView.$vKey.'" value="'.MNBVf::strToHtml(SysBF::getFrArr($obj,$vKey,'')).'"'.$styleStr.$sizeStr.$disablStr.'>';
    }elseif($viewArr["type"]=="passwdscr") {
        if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,$vKey,''); //Это просто вывод данных
        else echo '<script type="text/javascript" src="/src/mnbv/js/md5-min.js"></script><input type="hidden" name="'.$prefView.$vKey.'"><input type="password" name="fp" value=""'.$styleStr.$sizeStr.$disablStr.' onChange="if (document.edit.fp.value != \'\'){ document.edit.'.$prefView.$vKey.'.value=hex_md5(document.edit.fp.value);}else{document.edit.'.$prefView.$vKey.'.value=\'\';}">';
    }elseif($viewArr["type"]=="textarea") {//Текстовый блок
        if ($viewArr["active"]=="print") echo SysBF::getFrArr($obj,$vKey,''); //Это просто вывод данных
        else {
            if (!empty($viewArr["editor"]) && $viewArr["editor"]==true){
            //$edit_text1=str_replace("\r\n","&#13;",$row->text1);
?>

<span style="float: right;">
<b><?=Lang::get("Insert pictures");?>:&nbsp;&nbsp;&nbsp;</B>
<img src="<?=WWW_IMGPATH;?>admin/img1l.gif" alt="<?=Lang::get("Insert picture");?>1 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:1}}');">
<img src="<?=WWW_IMGPATH;?>admin/img2l.gif" alt="<?=Lang::get("Insert picture");?>2 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:2}}');">
<img src="<?=WWW_IMGPATH;?>admin/img3l.gif" alt="<?=Lang::get("Insert picture");?>3 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:3}}');">
<img src="<?=WWW_IMGPATH;?>admin/img4l.gif" alt="<?=Lang::get("Insert picture");?>4 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:4}}');">
<img src="<?=WWW_IMGPATH;?>admin/img5l.gif" alt="<?=Lang::get("Insert picture");?>5 <?=Lang::get("to the left");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-left:5}}');">

<img src="<?=WWW_IMGPATH;?>admin/img1.gif" alt="<?=Lang::get("Insert picture");?>1" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:1}}');">
<img src="<?=WWW_IMGPATH;?>admin/img2.gif" alt="<?=Lang::get("Insert picture");?>2" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:2}}');">
<img src="<?=WWW_IMGPATH;?>admin/img3.gif" alt="<?=Lang::get("Insert picture");?>3" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:3}}');">
<img src="<?=WWW_IMGPATH;?>admin/img4.gif" alt="<?=Lang::get("Insert picture");?>4" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:4}}');">
<img src="<?=WWW_IMGPATH;?>admin/img5.gif" alt="<?=Lang::get("Insert picture");?>5" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img:5}}');">

<img src="<?=WWW_IMGPATH;?>admin/img1r.gif" alt="<?=Lang::get("Insert picture");?>1 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:1}}');">
<img src="<?=WWW_IMGPATH;?>admin/img2r.gif" alt="<?=Lang::get("Insert picture");?>2 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:2}}');">
<img src="<?=WWW_IMGPATH;?>admin/img3r.gif" alt="<?=Lang::get("Insert picture");?>3 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:3}}');">
<img src="<?=WWW_IMGPATH;?>admin/img4r.gif" alt="<?=Lang::get("Insert picture");?>4 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:4}}');">
<img src="<?=WWW_IMGPATH;?>admin/img5r.gif" alt="<?=Lang::get("Insert picture");?>5 <?=Lang::get("to the right");?>" onclick="tinyMCE.execCommand('mceInsertContent',false,'{{img-right:5}}');">
<!--&nbsp;&nbsp;<img src="<?=WWW_IMGPATH;?>admin/br.gif" alt='Вставить BR' onclick="tinyMCE.execCommand('mceInsertContent',false,'<br>');">-->
&nbsp;
</span>
<?=Lang::get($vKey,'sysBaseObj');?>
</th>
</tr>
<tr>
<th class="line" colspan=2>
<textarea id="<?=$prefView.$vKey;?>" name="<?=$prefView.$vKey;?>" rows="<?=SysBF::getFrArr($viewArr,'rows',5);?>" cols="80" style="width: 100%;"<?=$disablStr;?>><?=SysBF::getFrArr($obj,$vKey,'');?></textarea>
<span style="float: right;">
    <a href="javascript:;" onmousedown="tinyMCE.get('<?=$prefView.$vKey;?>').show();">[Show]</a>
    <a href="javascript:;" onmousedown="tinyMCE.get('<?=$prefView.$vKey;?>').hide();">[Hide]</a>
</span>
<?php
            }else{
                echo '<span style="font-weight:bold;">'.Lang::get($vKey,'sysBaseObj').'</span><br><textarea class="no-tiny" rows="'.SysBF::getFrArr($viewArr,'rows',5).'" type="text" name="'.$prefView.$vKey.'"'.$styleStr.$rowsStr.$disablStr.'>'.SysBF::getFrArr($obj,$vKey,'').'</textarea>';
            }
        }
    }elseif($viewArr["type"]=="datetime"){ //Дата-время
        $ftdate = date("d.m.Y",intval(SysBF::getFrArr($obj,$vKey,0)));
        $ft_h = date("H",intval(SysBF::getFrArr($obj,$vKey,0)));
        $ft_m = date("i",intval(SysBF::getFrArr($obj,$vKey,0)));
        $ft_s = date("s",intval(SysBF::getFrArr($obj,$vKey,0)));
        if ($viewArr["active"]=="print"){
            echo $ftdate.' '.$ft_h.':'.$ft_m.':'.$ft_s;
        }else{
            echo Lang::get("Date").': <input type="text" class="datepickerTimeField" size="10" name="'.$prefUpd.$vKey.'_date" value="'.$ftdate.'"'.$disablStr.'>
'.Lang::get("Time").': <input size="2" type="text" name="'.$prefUpd.$vKey.'_h" value="'.$ft_h.'" maxlength=2'.$disablStr.'>
: <input size="2" type="text" name="'.$prefUpd.$vKey.'_m" value="'.$ft_m.'" maxlength=2'.$disablStr.'><input type="hidden" name="'.$prefView.$vKey.'" value="datetime">';
        }

        echo $tdStr2 . "</tr>\n";

    }elseif($viewArr["type"]=="date"){ //Дата
            $ftdate = date("d.m.Y",intval(SysBF::getFrArr($obj,$vKey,0)));
            if ($viewArr["active"]=="print"){
                echo $ftdate;
            }else{
                echo Lang::get("Date").': <input type="text" class="datepickerTimeField" size="10" name="'.$prefUpd.$vKey.'_date" value="'.$ftdate.'"'.$disablStr.'><input type="hidden" name="'.$prefView.$vKey.'" value="date">';
            }

            echo $tdStr2 . "</tr>\n";

    }elseif($viewArr["type"]=="select"){
        $realVal = SysBF::getFrArr($obj,$vKey,'noitem');
        if ($viewArr["active"]=="print"){
            //Получим значение из привязанного поля
            $valueStr = '';$value='';
            if (!empty($viewArr["notset"])) $valueStr = Lang::get("Not set"); $value=0;
            if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"]) && isset($viewArr["linkstorage"]["$realVal"])) {$valueStr = Lang::get($viewArr["linkstorage"]["$realVal"]);}
            elseif (!empty($viewArr["linkstorage"]) && !is_array($viewArr["linkstorage"])) {//Это хранилище, выберем элемент из хранилища по id
                $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                $storageRes = MNBVStorage::getObjAcc($storName,array("name","namelang"),array("id",'=',"$realVal"),array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                $valueArr = ($storageRes[0]>0)?$storageRes[1]:null;                                
                if (isset($valueArr[(Lang::isDefLang())?"name":"namelang"])){$value=$realVal;$valueStr=$valueArr[(Lang::isDefLang())?"name":"namelang"];}
                if ($valueStr==='') $valueStr = $valueArr["name"];
            }
            echo (($viewindex)?('['.$value.'] '):'') . $valueStr;
        }else{
            echo '<SELECT name="'.$prefView.$vKey.'"'.$sizeStr.'>'."\n";
            if (!empty($viewArr["notset"])) echo '<OPTION value="0"'.((0==$realVal)?' selected':'').'>'.(($viewindex)?('[0] '):'').Lang::get("Not set")."</OPTION>\n";
            if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"])) {
                foreach ($viewArr["linkstorage"] as $key => $value) {
                    echo '<OPTION value="'.$key.'"'.(($key==$realVal)?' selected':'').'>'.(($viewindex)?('['.$key.'] '):'').Lang::get($value)."</OPTION>\n";
                }
            } else {//Это хранилище, выберем элемент из хранилища по id
                $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                $paramArr = array();
                if (isset($viewArr["filter_folder"])) array_push($paramArr,'and','parentid','=',$viewArr["filter_folder"]);
                if (isset($viewArr["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                if (isset($viewArr["filter_type"])&&$viewArr["filter_type"]!=='all') {
                    array_push($paramArr,'and','type','=',($viewArr["filter_type"]==="folders")?"1":"0");
                }
                if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                    if ($poz==0) continue;
                    $key=$valueArr["id"];
                    $valueStr = MNBVf::substr($valueArr[(Lang::isDefLang())?"name":"namelang"],0,50,true);
                    if ($valueStr==='') $valueStr = $valueArr["name"];
                    echo '<OPTION value="'.$key.'"'.(($key==$realVal)?' selected':'').'>'.(($viewindex)?('['.$key.'] '):'').$valueStr."</OPTION>\n";
                }
            }
            echo "</SELECT>\n";
        }
    }elseif($viewArr["type"]=="radio"){
        $realVal = SysBF::getFrArr($obj,$vKey,'noitem');
        if ($viewArr["active"]=="print"){
            //Получим значение из привязанного поля
            $valueStr = '';$value='';
            if (!empty($viewArr["notset"])) $valueStr = Lang::get("Not set"); $value=0;
            if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"]) && isset($viewArr["linkstorage"]["$realVal"])) {$valueStr = Lang::get($viewArr["linkstorage"]["$realVal"]);}
            elseif (!empty($viewArr["linkstorage"]) && !is_array($viewArr["linkstorage"])) {//Это хранилище, выберем элемент из хранилища по id
                $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                $storageRes = MNBVStorage::getObjAcc($storName,array("name","namelang"),array("id",'=',"$realVal"),array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                $valueArr = ($storageRes[0]>0)?$storageRes[1]:null;                                
                if (isset($valueArr[(Lang::isDefLang())?"name":"namelang"])){$value=$realVal;$valueStr=$valueArr[(Lang::isDefLang())?"pozid,name":"pozid,namelang"];}
                if ($valueStr==='') $valueStr = $valueArr["name"];
            }
            echo (($viewindex)?('['.$value.'] '):'') . $valueStr;
        }else{
            $delimSt = '';//$delimStr;
            if (!empty($viewArr["notset"])) {$delimSt = $delimStr; echo '<input type="radio"  name="'.$prefView.$vKey.'" value="0"'.((0==$realVal)?' checked':'').'/> <label for="'.$prefView.$vKey.'">'.(($viewindex)?('[0] '):'').Lang::get("Not set")."</label>\n";}
            if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"])) {
                foreach ($viewArr["linkstorage"] as $key => $value) {
                    echo $delimSt.'<input type="radio"  name="'.$prefView.$vKey.'" value="'.$key.'"'.(($key==$realVal)?' checked':'').'/> <label for="'.$prefView.$vKey.'">'.(($viewindex)?('['.$key.'] '):'').Lang::get($value)."</label>\n";
                    if ($delimSt == '') $delimSt = $delimStr;
                }
            } else {//Это хранилище, выберем элемент из хранилища по id
                $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                $paramArr = array();
                if (isset($viewArr["filter_folder"])) array_push($paramArr,'and','parentid','=',$viewArr["filter_folder"]);
                if (isset($viewArr["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                if (isset($viewArr["filter_type"])&&$viewArr["filter_type"]!=='all') {
                    array_push($paramArr,'and','type','=',($viewArr["filter_type"]==="folders")?"1":"0");
                }
                if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                    if ($poz==0) continue;
                    $key=$valueArr["id"];
                    $valueStr = $valueArr[(Lang::isDefLang())?"name":"namelang"];
                    if ($valueStr==='') $valueStr = $valueArr["name"];
                    echo $delimSt.'<label><input type="radio"  name="'.$prefView.$vKey.'" value="'.$key.'"'.(($key==$realVal)?' checked':'').'/> '.(($viewindex)?('['.$key.'] '):'').$valueStr."</label>\n";
                    if ($delimSt == '') $delimSt = $delimStr;
                }
            }
        }
    }elseif($viewArr["type"]=="list"){
        $realVal = SysBF::getFrArr($obj,$vKey);
        $realValArr = SysBF::json_decode($realVal);
        if ($viewArr["active"]=="print"){
            $delimSt = '';
            if (!empty($viewArr["notset"])&&in_array(0,$realValArr)) {$delimSt = $delimStr; echo (($viewindex)?('[0] '):'').Lang::get("Not set")."\n";}
            if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"])) {
                foreach ($viewArr["linkstorage"] as $key => $value) {
                    if (in_array($key,$realValArr)){
                        echo $delimSt . (($viewindex)?('['.$key.'] '):'').Lang::get($value)."\n";
                        if ($delimSt == '') $delimSt = $delimStr;
                    }
                }
            } else {//Это хранилище, выберем элемент из хранилища по id
                $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";
                $paramArr = array();
                if (isset($viewArr["filter_folder"])) array_push($paramArr,'and','parentid','=',$viewArr["filter_folder"]);
                if (isset($viewArr["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                if (isset($viewArr["filter_type"])&&$viewArr["filter_type"]!=='all') {
                    array_push($paramArr,'and','type','=',($viewArr["filter_type"]==="folders")?"1":"0");
                }
                if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                    $key=$valueArr["id"];
                    if ($poz==0) continue;
                    $valueStr = $valueArr[(Lang::isDefLang())?"name":"namelang"];
                    if ($valueStr==='') $valueStr = $valueArr["name"];
                    echo $delimSt . (($viewindex)?('['.$key.'] '):'').Lang::get($valueStr)."\n";
                    if ($delimSt == '') $delimSt = $delimStr;
                }
            }                    
        }else{
            $delimSt = '';
            $countlist = 0;
            if (!empty($viewArr["notset"])) {$delimSt = $delimStr; echo '<input type="radio"  name="'.$prefView.$vKey.'" value="0"'.((in_array(0,$realValArr))?' checked':'').'/> <label for="'.$prefView.$vKey.'">'.(($viewindex)?('[0] '):'').Lang::get("Not set")."</label>\n";}
            if (isset($viewArr["linkstorage"]) && is_array($viewArr["linkstorage"])) {
                foreach ($viewArr["linkstorage"] as $key => $value) {
                    echo $delimSt.'<input type="checkbox"  name="'.$prefUpd.$vKey.'['.$countlist.']" value="'.$key.'"'.((in_array($key,$realValArr))?' checked':'').'/> <label for="'.$prefUpd.$vKey.'['.$countlist.']">'.(($viewindex)?('['.$key.'] '):'').Lang::get($value)."</label>";
                    echo '<input type="hidden" name="'.$prefKey.$vKey.'['.$countlist.']" value="'.$key.'">'."\n";
                    if ($delimSt == '') $delimSt = $delimStr;
                    $countlist++;
                }
            } else {//Это хранилище, выберем элемент из хранилища по id
                $storName = ($viewArr["linkstorage"]!='this')?$viewArr["linkstorage"]:"$usestorage";

                $paramArr = array();
                if (isset($viewArr["filter_folder"])) array_push($paramArr,'and','parentid','=',$viewArr["filter_folder"]);
                if (isset($viewArr["filter_vis"])) array_push($paramArr,'and','visible','=',1);
                if (isset($viewArr["filter_type"])&&$viewArr["filter_type"]!=='all') {
                    array_push($paramArr,'and','type','=',($viewArr["filter_type"]==="folders")?"1":"0");
                }
                if (strtolower($paramArr[0])=='and') unset($paramArr[0]); //Уберем лишний 'and'

                $storageRes = MNBVStorage::getObjAcc($storName,array("id","name","namelang"),$paramArr,array("sort"=>array("pozid"=>"inc",((Lang::isDefLang())?"name":"namelang")=>"inc")));
                if ($storageRes[0]>0) foreach ($storageRes as $poz=>$valueArr){
                    if ($poz==0) continue;
                    $key=$valueArr["id"];
                    $valueStr = $valueArr[(Lang::isDefLang())?"name":"namelang"];
                    if ($valueStr==='') $valueStr = $valueArr["name"];  
                    echo $delimSt.'<input type="checkbox"  name="'.$prefUpd.$vKey.'['.$countlist.']" value="'.$key.'"'.((in_array($key,$realValArr))?' checked':'').'/>  <label for="'.$prefUpd.$vKey.'['.$countlist.']">'.(($viewindex)?('['.$key.'] '):'').$valueStr."</label>";
                    echo '<input type="hidden" name="'.$prefKey.$vKey.'['.$countlist.']" value="'.$key.'">'."\n";
                    if ($delimSt == '') $delimSt = $delimStr;
                    $countlist++;
                }
            }
            echo '<input type="hidden" name="'.$prefView.$vKey.'" value="list">';
        }
    }
    
    //Дополнительные поля к некоторым системным полям
    if ($vKey=='type' && (2==SysBF::getFrArr($obj,'type',0)||3==SysBF::getFrArr($obj,'type',0))) //Если это тип объекта Link или URL, то выведем дополнительное поле
        echo '<input type="text" name="ob_typeval" value="'.SysBF::getFrArr($obj,'typeval','').'" style="width:70%">';
    elseif ($vKey=='alias' && empty($altlang)) echo ' | <input type="checkBox" name="obd_alias_autogen"> <b>'.Lang::get("URL generator")."</b>\n";

}