function korzclear()
{
    if (confstat = confirm ("Вы действительно хотите очистить корзину?")){
		window.open("/korz.php?act=clear");
    }
}
var selectform=0;
function selform()
{
	selectform=selectform+1;
    if (selectform >1 ){
		document.filtr.submit();
    }
}
function selform2()
{
	selectform=0;
}