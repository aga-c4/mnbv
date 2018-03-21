<?php
/**
 * Шаблон авторизации
 * Данные передаются массиве $item
 * Поля:
 * 'login' - если задано, то установим стартовое значение login
 */
?>
<br>
<script type="text/javascript" src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/md5-min.js"></script>
<SCRIPT>
var selectform=0;
function CheckForm()	
{
   if (selectform == 0 ){
	if (document.authform.ul.value =='')
	{
     alert('<?=Lang::get("Login is empty!");?>');
	 document.authform.ul.focus();
	 return false;
	}

	if (document.authform.fp.value == '')
	{
     alert('<?=Lang::get("Password is empty!");?>');
	 document.authform.fp.focus();
	 return false;
	}
	selectform=1;
	document.authform.fu.value=hex_md5(getCookie('<?=SysBF::getFrArr($item['sidName'],'login','PHPSESSID');?>') + hex_md5(document.authform.fp.value));
	document.authform.fp.value='';
	document.authform.submit();
   }else{
   document.Send.submit();
   }
}
</SCRIPT>
<FORM action="" method=post onsubmit="CheckForm();" name=authform>
<div style='WIDTH: 250px;'>
<table class=base>
<tr>

<td align=right><b><?=Lang::get("Login");?>:</b> <input type=text name=ul size="16" value="<?=SysBF::getFrArr($item['user'],'login','');?>"><br>
<b><?=Lang::get("Password");?>:</b> <input type="Password" name=fp size="16" onchange="CheckForm();"><br>
<input type=hidden name=fu value=''>
<input type=hidden name=act value='auth'>
<input type=button onclick="CheckForm();" value="<?=Lang::get("Authorise");?>"><br>

</td>
</tr>
</table>
</div>
</FORM>
<br>
IP:[<? echo GetEnv('REMOTE_ADDR'); ?>]