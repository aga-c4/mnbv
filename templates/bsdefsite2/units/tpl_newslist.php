<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */
?>

<?if (false && !empty($item['list_sort_types'])&&is_array($item['list_sort_types'])){?>
<SCRIPT>
function CheckListSort(){
    sortAlias = document.listsort.list_sort_select.value;
    location.href = '<?=SysBF::getFrArr($item,'page_list_url','');?>' + '/sort_' + sortAlias;
}
</SCRIPT>
<form action="" name="listsort" method="post" ENCTYPE="multipart/form-data">
    <?
    echo '<select name="list_sort_select" onChange="CheckListSort()">'."\n";
    echo '<option value="">'.Lang::get('list_sort_select','list_sort_types')."</option>\n";
    foreach ($item['list_sort_types'] as $key=>$value){
        echo '<option value="'.$key.'">'.Lang::get($value,'list_sort_types')."</option>\n";
    }
    echo "</select>\n";
    ?>
</form>
<br>
<? } ?>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 g-1">
<?
//Список объектов
foreach ($item['list'] as $key=>$value) if ($key>0) {
?>
    <div class="col mb-2">
        <div class="card m-1 bg-light h-100 border-0">
            <div class="card-body p-1">
                <?=(SysBF::getFrArr($value,'type')!=1)?('<span class="card-subtitle mb-2 text-muted">'.MNBVf::getDateStr(SysBF::getFrArr($value,'date',0),array('mnbv_format'=>'type1')).'</span>'):'';?>
<? if (!empty($value['text'])){ ?>
                <span class="card-title"><a href="<?=SysBF::getFrArr($value,'url','');?>"><?=(!empty($value['about']))?('<p class="card-text">'.$value['about'].'</p>'):SysBF::getFrArr($value,'name','');?></a></span>
<? } else {?>
                <?=(!empty($value['about']))?('<p class="card-text">'.$value['about'].'</p>'):'';?>
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
<? } 


