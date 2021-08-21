<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */
$carouselCaptions = array();
$carouselItems = array();
$itemCounter=0;
$ban_img_id = SysBF::getFrArr($item,'ban_img_id',1);
foreach ($item['list'] as $key=>$value) if ($key>0) {
    if (!isset($value['files']["img"]["$ban_img_id"]) || $tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($value['files']["img"]["$ban_img_id"],'src',''))) continue;
    $carouselCaptions[] = '<li data-target="#carouselCaptions" data-slide-to="'.$itemCounter.'"'.((!$itemCounter)?' class="active"':'').'"></li>';
    
    $carouselItem = '<div class="carousel-item'.((!$itemCounter)?' active':'').'">'."\n";
    //Подготовим размеры изображений
    $imgWStr = (isset($value['files']["img"]["$ban_img_id"]['size']['w']))?(' width="'.$value['files']["img"]["$ban_img_id"]['size']['w'].'"'):'';
    if ($imgWStr=='' && isset($item['img_max_size']['img_min_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_min_max_w'] .'"';
    $imgHStr = (isset($value['files']["img"]["$ban_img_id"]['size']['h']))?(' height="'.$value['files']["img"]["$ban_img_id"]['size']['h'].'"'):'';
    //$carouselItem .= '<a href="' . SysBF::getFrArr($value,'url','') . '"><img src="' . SysBF::getFrArr($value['files']["img"]["$ban_img_id"],'src_min','') . '" class="d-block w-100" alt="' . MNBVf::getItemName($value,Lang::isAltLang()) . '"></a>'."\n";
    $carouselItem .= '<a href="' . SysBF::getFrArr($value,'url','') . '"><img src="' . SysBF::getFrArr($value['files']["img"]["$ban_img_id"],'src','') . '" class="d-block w-100" alt="' . MNBVf::getItemName($value,Lang::isAltLang()) . '">'."\n";
    //Заголовок и краткое описание
    /* Если нужно выводить заголовок акции с описанием поверх баннера - раскомментить
    $carouselItem .= '<div class="carousel-caption d-sm-block">'."\n";
    $carouselItem .= '<h5>' . MNBVf::getItemName($value,Lang::isAltLang()) . '</h5>'."\n";
    if ($curAbout=MNBVf::getItemAbout($value,$altlang=Lang::isAltLang(),$defval='')) $carouselItem .= '<div class="d-none d-md-block">'.$curAbout.'</div>'."\n";
    $carouselItem .= '</div></a>'."\n";
     */
    $carouselItem .= '</div>'."\n";
    $carouselItems[] = $carouselItem;
    $itemCounter++;  
}
?>
  
<? if (count($carouselItems)>0){ ?>

<?if (false){?>
  <ol class="carousel-indicators">
<? foreach ($carouselCaptions as $value) echo $value."\n"; ?>
  </ol>
<?}?>

  <div class="carousel-inner">
<? foreach ($carouselItems as $value) echo $value."\n"; ?>      
  </div>

  <a class="carousel-control-prev" href="#carouselCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </a>
  <a class="carousel-control-next" href="#carouselCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </a>
<? } 
