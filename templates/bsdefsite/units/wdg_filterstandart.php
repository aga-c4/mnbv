<?php
/**
 * Шаблон вывода стандартного фильтра хранилища
 * Данные передаются массиве $filterArr
 */
?>
<script>
    var selectform=0;
    function fltrSubmitForm()
    {
            document.fltrform0.submit();
    }
    function fltrSelForm()
    {
        selectform=selectform+1;
        if (selectform >1 ){
            document.fltrform0.submit();
        }
    }
    function fltrSelForm2()
    {
        selectform=0;
    }
</script>
<form class="form1" action="<?=SysBF::getFrArr($item,'list_base_url_clear','');?>" name="fltrform0" method="<?=(!empty($filterArr["filter"]['fltr_method'])&&$filterArr["filter"]['fltr_method']=='post')?'post':'get';?>" ENCTYPE="multipart/form-data">
<?
MNBVf::listFilterGenerator($filterArr, $item['mnbv_altlang']);
?>
</form>