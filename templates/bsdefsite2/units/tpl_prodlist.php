<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */
?>

<? 
if (isset($item['attr_filters']) && is_array($item['attr_filters'])
        && isset($item['attr_filters']['vendor']) && is_array($item['attr_filters']['vendor']) 
        && isset($item['attr_filters']['vendor']["vals"]) && is_array($item['attr_filters']['vendor']["vals"]) && count($item['attr_filters']['vendor']["vals"])){

    $itemCounter = 0;
    $resVend = '';
    foreach($item['attr_filters']['vendor']["vals"] as $attrItemAlias=>$attrItemVal) {
        if (!is_array($attrItemVal)) continue; 
        if (empty($itemCounter)) $resVend .= '<div class="w-100">';
        $resVend .= '<a class="btn btn-outline-secondary mt-1" href="'.$item['page_list_url'].'/'.$attrItemVal['alias'].'" role="button">'.MNBVf::getItemName($attrItemVal,Lang::isAltLang()).'</a>'."\n";
        $itemCounter++;
    }
    if (!empty($itemCounter) && $itemCounter>1) echo $resVend . '</div>';
} 
?>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 mb-2">
    
<? if (isset($item['attr_filters']) && is_array($item['attr_filters']) && count($item['attr_filters'])){ ?>
<div class="col mt-2">
    <?/*
    <button class="btn btn-primary w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
    <?=Lang::get("Filters");?> <span class="badge rounded-pill bg-secondary">2</span>
    </button>
     */?>
    <button class="btn btn-primary w-100" type="button" data-toggle="modal" data-target="#filterpanel">
    <?=Lang::get("Filters");?><? if (!empty($item['attr_filters_selected_nums'])) echo ' <span class="badge rounded-pill bg-secondary">'.$item['attr_filters_selected_nums'].'</span>';?>
    </button>
</div>
<? } ?>

<?if (!empty($item['list_size'])&&$item['list_size']>1
        &&!empty($item['list_sort_types'])&&is_array($item['list_sort_types'])){?>
<SCRIPT>
function CheckListSort(){
    sortAlias = document.listsort.list_sort_select.value;
    if (sortAlias=='default') {
        location.href = '<?=SysBF::getFrArr($item,'page_list_filters_url','');?>';
    } else {
        location.href = '<?=SysBF::getFrArr($item,'page_list_filters_url','');?>' + 'sort=' + sortAlias;
    }
}
</SCRIPT>  
<div class="col use-prods d-none mt-2">
<form action="" name="listsort" method="post" ENCTYPE="multipart/form-data">
    <?
    echo '<select name="list_sort_select" onChange="CheckListSort()" class="form-select">'."\n";
    echo '<option value="default">'.Lang::get('list_sort_select','list_sort_types')."</option>\n";
    foreach ($item['list_sort_types'] as $key=>$value){
        echo '<option value="'.$key.'" '.(($key==$item['real_list_sort'])?' selected':'').'>'.Lang::get($value,'list_sort_types')."</option>\n";
    }
    echo "</select>\n";
    ?>
</form>
</div>
<? } ?>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-1">
<?
//Список объектов
$folderCounter = 0;
foreach ($item['list'] as $key=>$value) if ($key>0) {
    if ($value['type']!=ST_FOLDER && empty($folderCounter)) {
        echo '<script>$(".use-prods").removeClass("d-none");</script>';
        $folderCounter++;
    }
?>
    <div class="col mb-2">
        <div class="card m-1 bg-light h-100 shadow">
<?
if (isset($value['files']["img"]["1"]) && $tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($value['files']["img"]["1"],'src',''))){//Нашли специфический объект (видео, ютуб.....), выводим его 
    //Ютуб заменяем превьюшкой
    $yuScrArr = MNBVf::getYoutubeScreenByURL(SysBF::getFrArr($value['files']["img"]["1"],'src',''));
    //$imgWStr = ' width=""';
    //$imgHStr = ' height=""';
    if (empty($imgWStr) && isset($item['img_max_size']['img_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_max_w'] .'"';
?>
        <a href="<?=SysBF::getFrArr($value,'url','');?>" class="prodlist-img-a w-100 d-flex justify-content-center bg-white"><img class="card-img-top prodlist-img h-100" src='<?=SysBF::getFrArr($yuScrArr,'default','');?>' alt="<?=SysBF::getFrArr($value,'name','');?>"></a>
<?
} else {//Никакого специфического объекта не нашли, выводим изображения по стандартной схеме
    if (isset($value['files']['img']["1"])){ 
        //Подготовим размеры изображений
        $imgURL = SysBF::getFrArr($value['files']["img"]["1"],'src','');
        $imgWStr = (isset($value['files']["img"]["1"]['size']['w']))?(' width="'.$value['files']["img"]["1"]['size']['w'].'"'):'';
        if ($imgWStr=='' && isset($item['img_max_size']['img_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_max_w'] .'"';
        $imgHStr = (isset($value['files']["img"]["1"]['size']['h']))?(' height="'.$value['files']["img"]["1"]['size']['h'].'"'):'';
    }else{
        if ($value['type']==ST_FOLDER) $imgURL = '/src/mnbv/img/ico/folder1.png';
        else $imgURL = '/src/mnbv/img/ico/nophoto2.jpg';
    }
?>
        <a href="<?=SysBF::getFrArr($value,'url','');?>" class="prodlist-img-a w-100 d-flex justify-content-center bg-white"><img class="card-img-top prodlist-img h-100" src='<?=$imgURL;?>' alt="<?=SysBF::getFrArr($value,'name','');?>"></a>
<? 
} 
?>
        <div class="card-body">
            <h5 class="card-title"><a href="<?=SysBF::getFrArr($value,'url','');?>"><?=SysBF::getFrArr($value,'name','');?></a></h5>
            <? if ($value["type"]!=1) echo Lang::get("Code") .': '. SysBF::getFrArr($value,'id','')."<br>\n";?>
    <? /*=(!empty($value['about']))?('<p class="card-text">'.$value['about'].'</p>'):'';*/?>
<? if (!empty($value['price']) && $value['price']>0){
    ?><?=Lang::get("Price");?>: <span style="font-weight:bold;"><?=SysBF::getFrArr($value,'price','').Glob::$vars['prod_currency_suf'];?></span>
<? if (!empty($value['oldprice']) && $value['oldprice']>$value['price']){ ?> 
            <span class="text-decoration-line-through"><?=$value['oldprice'].Glob::$vars['prod_currency_suf'];?></span>
<?}?>
    <br>
<? if (!empty($value['discount_price']) && $value['discount_price']>0 && $value['discount_price']<$value['price']){?><?=Lang::get("Discount price");?>: <span style="font-weight:bold;color:green;"><?=SysBF::getFrArr($value,'discount_price','').Glob::$vars['prod_currency_suf'];?></span><br>
<?}?>

<?}?>
<? if (empty($value['type']) || $value['type']!=1 && !empty($item['sub_obj']['price']) && $item['sub_obj']['price']>0){?>
            <a href="<?=MNBVf::requestUrl((!Lang::isDefLang())?'altlang':'',SysBF::getFrArr(Glob::$vars,'cart_url',''));?>?product_id=<?=$value['id'];?>" class="btn btn-primary"><?=Lang::get('Buy');?></a>
<? } ?>
            </div>
        </div>
    </div>    
<? } ?>  
</div>

<?  //Номера страниц
if (isset($item['list_max_items'])&&isset($item['list_size'])&&$item['list_max_items']<$item['list_size']) { ?>
<nav aria-label="<?=Lang::get("Pages");?>" class="mt-3">
    <?=MNBVf::startVidget('pagination',$item['obj'],$item['page_list_num_conf']);?>
</nav>
<? } ?>

<!-- Filters panel -->
<? /* 
 * Диапазоны смотреть тут: https://jqueryui.com/slider/#range 
 * <pre><?print_r($item['attr_filters']);?></pre>
 */?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<? if (isset($item['attr_filters']) && is_array($item['attr_filters']) && count($item['attr_filters'])){ ?>
<!-- Modal -->
<div class="modal fade" id="filterpanel" data-keyboard="false" tabindex="-1" aria-labelledby="filterpanelLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="filterpanelLabel"><?=Lang::get("Filters");?></h4>
        <button class="btn btn-primary ml-3 my-0" type="button" onclick='attrFilterGo();'><?=Lang::get("Use filters");?> <span class="badge rounded-pill bg-light text-dark" id="flt-goqty2">12</span></button>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" id="filterform">  
            <div class="row">
                <?                
                //Формирование фильтров
                $sliderDefArr = array();
                $cbGroupDefArr = array();
                    
                    foreach ($item['attr_filters'] as $attrAlias => $attrValue) {
                        if (!is_array($attrValue)) continue;
                        if (empty($attrValue['inshort']) && empty($attrValue["selected"])) continue; //Вывод шорт листа
                        
                        if (!empty($attrValue["filter_type"]) && $attrValue["filter_type"]=="slider"){
                            
                            //Здесь приведено к INT, т.к. используется такой слайдер, если захотите используйте слайдер с десятыми и уберите int количество знаков после запятой в параметре dmsize
                            $minval = intval(SysBF::getFrArr($attrValue,'minval',0));
                            $maxval = intval(SysBF::getFrArr($attrValue,'maxval',0));
                            $minRval = intval(SysBF::getFrArr($attrValue,'minRval',0));
                            $maxRval = intval(SysBF::getFrArr($attrValue,'maxRval',0));
                            
                            //Служебный массив для очистки и передачи данных
                            $sliderDefArr["$attrAlias"] = array(
                                'min' => $minval,
                                'max' => $maxval,
                                'minr' => $minRval,
                                'maxr' => $maxRval,
                            );
                            
                            if ($sliderDefArr["$attrAlias"]["min"] == $sliderDefArr["$attrAlias"]["max"]) {
                                unset($sliderDefArr["$attrAlias"]);
                                continue;
                            }
                            
                            ?>
                
                <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                    <script>
                    $( function() {
                      $( "#<?=$attrAlias;?>-slider-range" ).slider({
                        range: true,
                        min: <?=$minval;?>,
                        max: <?=$maxval;?>,
                        values: [ <?=$minRval;?>, <?=$maxRval;?> ],
                        slide: function( event, ui ) {
                          $( "#f<?=$attrAlias;?>" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
                        }
                      });
                      $( "#f<?=$attrAlias;?>" ).val( $( "#<?=$attrAlias;?>-slider-range" ).slider( "values", 0 ) + " - " + $( "#<?=$attrAlias;?>-slider-range" ).slider( "values", 1 ) );
                    } );
                    </script>

                    <h5><?=MNBVf::getItemName($attrValue,Lang::isAltLang());?></h5>
                    <div id="<?=$attrAlias;?>-slider-range" onmouseup="attrFilterGo('viewonlylistsize');"></div>
                    <input type="text" id="f<?=$attrAlias;?>" readonly style="border:0; color:#f6931f; font-weight:bold;">
                </div>
                
                            <?
                        } elseif (!empty($attrValue["filter_type"]) && $attrValue["filter_type"]== "checkbox_gr"){
                            
                            //Служебный массив для очистки и передачи данных
                            $cbGroupDefArr[] = "$attrAlias";
                            $maxViewItems = 4;
                            $itemsCnt = 0;
                            ?>
                
                <div class="col-sm-12 col-md-6 col-lg-4 mt-2">
                    <h5><?=MNBVf::getItemName($attrValue,Lang::isAltLang());?></h5>
                    <div>
                        <? 
                        if (isset($attrValue["vals"]) && is_array($attrValue["vals"]) && count($attrValue["vals"])) {

                            foreach($attrValue["vals"] as $attrItemAlias=>$attrItemVal) { //Сначала выводим все выделенные
                                if (!is_array($attrItemVal)) continue;
                                if (empty($attrItemVal["selected"])) continue;
                                $itemsCnt++;
                                
                        ?>     
                        <div class="checkbox"><label><input type="checkbox"<?=(!empty($attrItemVal["selected"]))?' checked':'';?> name="f<?=$attrAlias;?>[]" class="cb-<?=$attrAlias;?> flt-chkbx" value="<?=$attrItemAlias;?>"> <?=MNBVf::getItemName($attrItemVal,Lang::isAltLang());?><?=(!empty($attrItemVal["qty"]))?" ({$attrItemVal["qty"]})":'';?></label></div>
                        <? 
                            } 
                            
                        $moreHref = false;    
                        if (count($attrValue["vals"])>$itemsCnt) {//Если есть еще чего выводить, то выведем
                            
                            foreach($attrValue["vals"] as $attrItemAlias=>$attrItemVal) {
                                if (!is_array($attrItemVal)) continue;
                                if (!empty($attrItemVal["selected"])) continue; 
                                $itemsCnt++;
                                
                                if ($itemsCnt>$maxViewItems){
                                    if (!$moreHref) {
                        ?>
                        <div class="checkbox <?=$attrAlias;?>-hideview"><a  onclick='$(".<?=$attrAlias;?>-hide").removeClass("d-none"); $(".<?=$attrAlias;?>-hideview").addClass("d-none");' href="#"><?=Lang::get("View all");?></a></a></div>                    
                        <?
                                        $moreHref = true;
                                    }
                        ?>
                        <div class="checkbox <?=$attrAlias;?>-hide d-none"><label><input type="checkbox"<?=(!empty($attrItemVal["selected"]))?' checked':'';?> name="f<?=$attrAlias;?>[]" class="cb-<?=$attrAlias;?> flt-chkbx" value="<?=$attrItemAlias;?>"> <?=MNBVf::getItemName($attrItemVal,Lang::isAltLang());?><?=(!empty($attrItemVal["qty"]))?" ({$attrItemVal["qty"]})":'';?></label></div>
                        <?
                                } else {
                        ?>      
                        <div class="checkbox"><label><input type="checkbox"<?=(!empty($attrItemVal["selected"]))?' checked':'';?> name="f<?=$attrAlias;?>[]" class="cb-<?=$attrAlias;?> flt-chkbx" value="<?=$attrItemAlias;?>"> <?=MNBVf::getItemName($attrItemVal,Lang::isAltLang());?><?=(!empty($attrItemVal["qty"]))?" ({$attrItemVal["qty"]})":'';?></label></div>
                        <? }}} 
                        
                        if ($moreHref) ?>
                        <div class="checkbox <?=$attrAlias;?>-hide d-none"><a onclick='$(".<?=$attrAlias;?>-hide").addClass("d-none"); $(".<?=$attrAlias;?>-hideview").removeClass("d-none");' href="#"><?=Lang::get("Short list");?></a></a></div>
                        <? } ?>
                    </div>
                </div>

                            <?
                        }
                        
                    }
                    
                    
                    //НЕ выделенные или НЕ из короткого списка
                    $filterCounter = 0;
                    foreach ($item['attr_filters'] as $attrAlias => $attrValue) {
                        if (!is_array($attrValue)) continue;
                        if (!empty($attrValue['inshort']) || !empty($attrValue["selected"])) continue; //Вывод шорт листа
                        
                        if ($filterCounter==0) {
                        ?>
                        <div class="w-100 attrbl-hideview mt-3"><a onclick='$(".attrbl-hide").removeClass("d-none"); $(".attrbl-hideview").addClass("d-none");' href="#"><?=Lang::get("All filters");?></a></a></div>
                        <?
                        }
                        
                        $filterCounter++;
                        
                        if (!empty($attrValue["filter_type"]) && $attrValue["filter_type"]=="slider"){
                            
                            //Здесь приведено к INT, т.к. используется такой слайдер, если захотите используйте слайдер с десятыми и уберите int количество знаков после запятой в параметре dmsize
                            $minval = intval(SysBF::getFrArr($attrValue,'minval',0));
                            $maxval = intval(SysBF::getFrArr($attrValue,'maxval',0));
                            $minRval = intval(SysBF::getFrArr($attrValue,'minRval',0));
                            $maxRval = intval(SysBF::getFrArr($attrValue,'maxRval',0));
                            
                            //Служебный массив для очистки и передачи данных
                            $sliderDefArr["$attrAlias"] = array(
                                'min' => $minval,
                                'max' => $maxval,
                                'minr' => $minRval,
                                'maxr' => $maxRval,
                            );
                            
                            if ($sliderDefArr["$attrAlias"]["min"] == $sliderDefArr["$attrAlias"]["max"]) {
                                unset($sliderDefArr["$attrAlias"]);
                                continue;
                            }
                            
                            ?>
                
                <div class="col-sm-12 col-md-6 col-lg-4 mt-2 attrbl-hide d-none">
                    <script>
                    $( function() {
                      $( "#<?=$attrAlias;?>-slider-range" ).slider({
                        range: true,
                        min: <?=$minval;?>,
                        max: <?=$maxval;?>,
                        values: [ <?=$minRval;?>, <?=$maxRval;?> ],
                        slide: function( event, ui ) {
                          $( "#f<?=$attrAlias;?>" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
                        }
                      });
                      $( "#f<?=$attrAlias;?>" ).val( $( "#<?=$attrAlias;?>-slider-range" ).slider( "values", 0 ) +
                        " - " + $( "#<?=$attrAlias;?>-slider-range" ).slider( "values", 1 ) );
                    } );
                    </script>

                    <h5><?=MNBVf::getItemName($attrValue,Lang::isAltLang());?></h5>
                    <div id="<?=$attrAlias;?>-slider-range" onmouseup="attrFilterGo('viewonlylistsize');"></div>
                    <input type="text" id="f<?=$attrAlias;?>" readonly style="border:0; color:#f6931f; font-weight:bold;">
                </div>
                
                            <?
                        } elseif (!empty($attrValue["filter_type"]) && $attrValue["filter_type"]== "checkbox_gr"){
                            
                            //Служебный массив для очистки и передачи данных
                            $cbGroupDefArr[] = "$attrAlias";
                            $maxViewItems = 4;
                            $itemsCnt = 0;
                            ?>
                
                <div class="col-sm-12 col-md-6 col-lg-4 mt-2 attrbl-hide d-none">
                    <h5><?=MNBVf::getItemName($attrValue,Lang::isAltLang());?></h5>
                    <div>
                        <? 
                        if (isset($attrValue["vals"]) && is_array($attrValue["vals"]) && count($attrValue["vals"])) {

                            foreach($attrValue["vals"] as $attrItemAlias=>$attrItemVal) { //Сначала выводим все выделенные
                                if (!is_array($attrItemVal)) continue;
                                if (empty($attrItemVal["selected"])) continue;
                                $itemsCnt++;
                                
                        ?>     
                        <div class="checkbox"><label><input type="checkbox"<?=(!empty($attrItemVal["selected"]))?' checked':'';?> name="f<?=$attrAlias;?>[]" class="cb-<?=$attrAlias;?> flt-chkbx" value="<?=$attrItemAlias;?>"> <?=MNBVf::getItemName($attrItemVal,Lang::isAltLang());?><?=(!empty($attrItemVal["qty"]))?" ({$attrItemVal["qty"]})":'';?></label></div>
                        <? 
                            } 
                            
                        $moreHref = false;    
                        if (count($attrValue["vals"])>$itemsCnt) {//Если есть еще чего выводить, то выведем
                            
                            foreach($attrValue["vals"] as $attrItemAlias=>$attrItemVal) {
                                if (!is_array($attrItemVal)) continue;
                                if (!empty($attrItemVal["selected"])) continue; 
                                $itemsCnt++;
                                
                                if ($itemsCnt>$maxViewItems){
                                    if (!$moreHref) {
                        ?>
                        <div class="checkbox <?=$attrAlias;?>-hideview"><a  onclick='$(".<?=$attrAlias;?>-hide").removeClass("d-none"); $(".<?=$attrAlias;?>-hideview").addClass("d-none");' href="#"><?=Lang::get("View all");?></a></a></div>                    
                        <?
                                        $moreHref = true;
                                    }
                        ?>
                        <div class="checkbox <?=$attrAlias;?>-hide d-none"><label><input type="checkbox"<?=(!empty($attrItemVal["selected"]))?' checked':'';?> name="f<?=$attrAlias;?>[]" class="cb-<?=$attrAlias;?> flt-chkbx" value="<?=$attrItemAlias;?>"> <?=MNBVf::getItemName($attrItemVal,Lang::isAltLang());?><?=(!empty($attrItemVal["qty"]))?" ({$attrItemVal["qty"]})":'';?></label></div>
                        <?
                                } else {
                        ?>      
                        <div class="checkbox"><label><input type="checkbox"<?=(!empty($attrItemVal["selected"]))?' checked':'';?> name="f<?=$attrAlias;?>[]" class="cb-<?=$attrAlias;?> flt-chkbx" value="<?=$attrItemAlias;?>"> <?=MNBVf::getItemName($attrItemVal,Lang::isAltLang());?><?=(!empty($attrItemVal["qty"]))?" ({$attrItemVal["qty"]})":'';?></label></div>
                        <? }}} 
                        
                        if ($moreHref) ?>
                        <div class="checkbox <?=$attrAlias;?>-hide d-none"><a onclick='$(".<?=$attrAlias;?>-hide").addClass("d-none"); $(".<?=$attrAlias;?>-hideview").removeClass("d-none");' href="#"><?=Lang::get("Short list");?></a></a></div>
                        <? } ?>
                    </div>
                </div>

                            <?
                        }
                        
                    }   
 
                ?>
                
                <div class="w-100 attrbl-hide d-none mt-3"><a onclick='$(".attrbl-hide").addClass("d-none"); $(".attrbl-hideview").removeClass("d-none");' href="#"><?=Lang::get("Filters short list");?></a></a></div>
                
            </div>

        </form>
      </div>
      <div class="modal-footer ">
          <script>
            //Приведение слайдера к начальному значению
            function attrSliderDef(){ //функция собирается на этапе генерации шаблона из фильтров слайдеров
                <? foreach ($sliderDefArr as $key=>$value) { ?>
                        
                $( "#<?=$key;?>-slider-range" ).slider( "values", [<?=$value['min'];?>,<?=$value['max'];?>] );
                $( "#f<?=$key;?>" ).val( $( "#<?=$key;?>-slider-range" ).slider( "values", 0 ) + " - " + $( "#<?=$key;?>-slider-range" ).slider( "values", 1 ) );
                
                <? } ?>
                attrFilterGo('viewonlylistsize');
            }
            
            function attrSliderReset(){ //функция собирается на этапе генерации шаблона из фильтров слайдеров
                <? foreach ($sliderDefArr as $key=>$value) { ?>
                        
                $( "#<?=$key;?>-slider-range" ).slider( "values", [<?=$value['minr'];?>,<?=$value['maxr'];?>] );
                $( "#f<?=$key;?>" ).val( $( "#<?=$key;?>-slider-range" ).slider( "values", 0 ) + " - " + $( "#<?=$key;?>-slider-range" ).slider( "values", 1 ) );

                <? } ?>
                attrFilterGo('viewonlylistsize');
            }
            
            //Переходит на URL с фильтрами
            function attrFilterGo(viewonlylistsize){ //функция собирается на этапе генерации шаблона из фильтров
                var result = '';
                var curVal = '';
                
                <? foreach ($sliderDefArr as $key=>$value) { ?>
                
                curVal = filterform.f<?=$key;?>.value;
                //if (curVal != "<?=$value['min'];?> - <?=$value['max'];?>") { //Тут на этапе генерации шаблона зададим дефолтовые значения
                if ( $( "#<?=$key;?>-slider-range" ).slider( "values", 0 ) != <?=$value['min'];?> || $( "#<?=$key;?>-slider-range" ).slider( "values", 1 ) != <?=$value['max'];?>) { //Тут на этапе генерации шаблона зададим дефолтовые значения    
                    if (result!='') result += ';';
                    result += "<?=$key;?>:" + curVal;
                }           
                
                <? } ?>
                    
                <? foreach ($cbGroupDefArr as $key) { ?>    
                    
                curVal = chkbx2Str($('.cb-<?=$key;?>')); 
                if (curVal!='') {
                    if (result!='') result += ';';
                    result += "<?=$key;?>:" + curVal;
                }
                
                <? } ?>
                
                if (result!='') result = 'filters=' + result.replace( /\s/g, '');
                
                if (viewonlylistsize=='viewonlylistsize'){
                    $.ajax({
                        url: '<?=$item['page_list_sort_url'];?>' + result + '&viewonlylistsize=true',
                        success: function(html){
                            $("#flt-goqty").text(html);
                            $("#flt-goqty2").text(html);
                        }
                    });
                }else{
                    document.location.href =  '<?=$item['page_list_sort_url'];?>' + result;
                }
            }
            
            function chkbx2Str(chkbval){
                var result = '';
                for(i=0;i<chkbval.length;i++) {
                    if(chkbval[i].checked==true){
                        if (result!='') result += ',';
                        result += chkbval[i].value;
                    }
                }
                return result;
            }
            $('.flt-chkbx').change(function() {attrFilterGo('viewonlylistsize');});
            $(document).ready(function(){attrFilterGo('viewonlylistsize');});
          </script>
          <button class="btn btn-primary" type="button" onclick='attrFilterGo();'><?=Lang::get("Use filters");?> <span class="badge rounded-pill bg-light text-dark" id="flt-goqty">12</span></button>
          <button class="btn btn-secondary" type="button" onclick='filterform.reset();attrSliderReset();'><?=Lang::get("Discard changes");?></button>
          <button class="btn btn-secondary" type="button" onclick='$(".flt-chkbx").prop("checked",false);attrSliderDef();'><?=Lang::get("Clear");?></button>
      </div>
    </div>
  </div>
</div>   

<? } 