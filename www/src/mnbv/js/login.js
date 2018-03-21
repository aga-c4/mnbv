var selectform2=0;
function fCheckForm()	
{
   if (selectform2 == 0 ){
	if (document.forma.ul.value =='')
	{
     alert('Вы не указали Логин');
	 document.forma.ul.focus();
	 return false;
	}

	if (document.forma.fp.value == '')
	{
     alert('Введите пароль');
	 document.forma.fp.focus();
	 return false;
	}
	
	selectform2=1;
	document.forma.fu.value=hex_md5(getCookie('PHPSESSID') + hex_md5(document.forma.fp.value));
	document.forma.fp.value='';
	document.forma.submit();
   }else{
   document.forma.submit();
   }
}
