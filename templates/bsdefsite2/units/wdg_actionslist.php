<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */
$carouselCaptions = array();
$carouselItems = array();
$itemCounter=0;
foreach ($item['list'] as $key=>$value) if ($key>0) {
    if (!isset($value['files']["img"]["1"]) || $tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($value['files']["img"]["1"],'src',''))) continue;
    $carouselCaptions[] = '<li data-target="#carouselCaptions" data-slide-to="'.$itemCounter.'"'.((!$itemCounter)?' class="active"':'').'"></li>';
    
    $carouselItem = '<div class="carousel-item'.((!$itemCounter)?' active':'').'">'."\n";
    //Подготовим размеры изображений
    $imgWStr = (isset($value['files']["img"]["1"]['size']['min']['w']))?(' width="'.$value['files']["img"]["1"]['size']['min']['w'].'"'):'';
    if ($imgWStr=='' && isset($item['img_max_size']['img_min_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_min_max_w'] .'"';
    $imgHStr = (isset($value['files']["img"]["1"]['size']['min']['h']))?(' height="'.$value['files']["img"]["1"]['size']['min']['h'].'"'):'';
    //$carouselItem .= '<a href="' . SysBF::getFrArr($value,'url','') . '"><img src="' . SysBF::getFrArr($value['files']["img"]["1"],'src_min','') . '" class="d-block w-100" alt="' . MNBVf::getItemName($value,Lang::isAltLang()) . '"></a>'."\n";
    $carouselItem .= '<a href="' . SysBF::getFrArr($value,'url','') . '"><img src="' . SysBF::getFrArr($value['files']["img"]["1"],'src_min','') . '" class="d-block w-100" alt="' . MNBVf::getItemName($value,Lang::isAltLang()) . '">'."\n";
    //Заголовок и краткое описание
    $carouselItem .= '<div class="carousel-caption d-sm-block">'."\n";
    $carouselItem .= '<h5>' . MNBVf::getItemName($value,Lang::isAltLang()) . '</h5>'."\n";
    if ($curAbout=MNBVf::getItemAbout($value,$altlang=Lang::isAltLang(),$defval='')) $carouselItem .= '<div class="d-none d-md-block">'.$curAbout.'</div>'."\n";
    $carouselItem .= '</div></a></div>'."\n";
    $carouselItems[] = $carouselItem;
    $itemCounter++;  
}

/*
  <ol class="carousel-indicators">
    <li data-target="#carouselCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselCaptions" data-slide-to="1"></li>
    <li data-target="#carouselCaptions" data-slide-to="2"></li>
    <li data-target="#carouselCaptions" data-slide-to="3"></li>
  </ol>

  <div class="carousel-inner">
      
    <div class="carousel-item active">
      <img src="/src/bsdefsite2/img/p1_2.jpg" class="d-block w-100" alt="Баннер1">
    </div>
      
    <div class="carousel-item">
        <img src="/src/bsdefsite2/img/p1_3.jpg" class="d-block w-100" alt="Баннер2">
        <div class="carousel-caption d-sm-block">
            <h5>Second slide label</h5>
            <div class="d-none d-md-block">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br> consectetur adipiscing elit, consectetur</p>
            </div>
        </div>
    </div>
      
    <div class="carousel-item">
      <img src="/src/bsdefsite2/img/p1_4.jpg" class="d-block w-100" alt="Баннер3">
    </div>
      
    <div class="carousel-item">
      <img src="/src/bsdefsite2/img/p1_5.jpg" class="d-block w-100" alt="Баннер4">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
      </div>
    </div>
      
  </div>

  <a class="carousel-control-prev" href="#carouselCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </a>
  <a class="carousel-control-next" href="#carouselCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </a>
 */
?>
  
<? if (count($carouselItems)>0){ ?>

  <ol class="carousel-indicators">
<? foreach ($carouselCaptions as $value) echo $value."\n"; ?>
  </ol>

  <div class="carousel-inner">
<? foreach ($carouselItems as $value) echo $value."\n"; ?>      
  </div>

  <a class="carousel-control-prev" href="#carouselCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </a>
  <a class="carousel-control-next" href="#carouselCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </a>
<? } else { ?>

  <ol class="carousel-indicators">
    <li data-target="#carouselCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselCaptions" data-slide-to="1"></li>
    <li data-target="#carouselCaptions" data-slide-to="2"></li>
    <li data-target="#carouselCaptions" data-slide-to="3"></li>
  </ol>

  <div class="carousel-inner">
      
    <div class="carousel-item active">
      <img src="/src/bsdefsite2/img/p1_2.jpg" class="d-block w-100" alt="Баннер1">
    </div>
      
    <div class="carousel-item">
        <img src="/src/bsdefsite2/img/p1_3.jpg" class="d-block w-100" alt="Баннер2">
        <div class="carousel-caption d-sm-block">
            <h5>Second slide label</h5>
            <div class="d-none d-md-block">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br> consectetur adipiscing elit, consectetur</p>
            </div>
        </div>
    </div>
      
    <div class="carousel-item">
      <img src="/src/bsdefsite2/img/p1_4.jpg" class="d-block w-100" alt="Баннер3">
    </div>
      
    <div class="carousel-item">
      <img src="/src/bsdefsite2/img/p1_5.jpg" class="d-block w-100" alt="Баннер4">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
      </div>
    </div>
      
  </div>

  <a class="carousel-control-prev" href="#carouselCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </a>
  <a class="carousel-control-next" href="#carouselCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </a>

<? } ?>

