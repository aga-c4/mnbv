function korzclear()
{
    if (confstat = confirm ("�� ������������� ������ �������� �������?")){
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