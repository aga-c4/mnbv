<?php
/**
 * Шаблон авторизации
 * Данные передаются массиве $item
 * Поля:
 * 'login' - если задано, то установим стартовое значение login
 */
?>
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
<div class="jumbotron">
<form class="form-signin" action="" method=post onsubmit="CheckForm();" name=authform>
  <label for="inputEmail" class="sr-only"><?=Lang::get("Login");?></label>
  <input type=email id="inputEmail" name=ul class="form-control" placeholder="<?=Lang::get("Login");?>" required autofocus>
  <label for="inputPassword" class="sr-only"><?=Lang::get("Password");?></label>
  <input type="Password" name=fp size="16" onchange="CheckForm();" id="inputPassword" class="form-control" placeholder="<?=Lang::get("Password");?>" required>
  <input type=hidden name=fu value=''>
  <input type=hidden name=act value='auth'>
  <input class="btn btn-lg btn-primary btn-block" type=button onclick="CheckForm();" value="<?=Lang::get("Authorise");?>">
  <br><center>IP:[<? echo GetEnv('REMOTE_ADDR'); ?>]</center>
</form>
</div>
