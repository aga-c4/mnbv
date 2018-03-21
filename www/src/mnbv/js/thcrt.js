//Определим область выделения ширину и длинну. если "0" - Параметры берутся с выделенной области
var tmbwidth = 0;
var tmbheight = 0;

//Первая точка
var x1 = 0;
var y1 = 0;
//Вторая точка
var x2 = 0;
var y2 = 0;
//состояние выделенной области
var ptype = false;

//mouse handler function
function mouseHandler(mouseEvent)
{
	if (!mouseEvent) mouseEvent = window.event;
	if (mouseEvent.button == 2) return;
	var element = (mouseEvent.target)?mouseEvent.target:mouseEvent.srcElement;

	if (mouseEvent.type=="click")
	{
		var x = mouseEvent.clientX - document.getElementById("imagearea").offsetLeft;
		var y = mouseEvent.clientY - document.getElementById("imagearea").offsetTop;
		pointSet(x,y);
		rectangleDraw('area');
	};

	if (mouseEvent.type=="mousemove")
	{
		x2=mouseEvent.clientX - document.getElementById("imagearea").offsetLeft + document.body.scrollLeft;
		y2=mouseEvent.clientY - document.getElementById("imagearea").offsetTop + document.body.scrollTop;

		document.getElementById("imagearea").title="("+x2+","+y2+")";

		if (ptype)
		{
			if ((x2<=document.getElementById("imagearea").offsetWidth) && (y2<=document.getElementById("imagearea").offsetHeight) && (x2>0) && (y2>0))
			{
				inputUpdate();
				rectangleDraw('area');
			}
			else
			{
				if (x2>document.getElementById("imagearea").offsetWidth)
					x2=document.getElementById("imagearea").offsetWidth + document.body.scrollLeft;

				if (y2>document.getElementById("imagearea").offsetHeight)
					y2=document.getElementById("imagearea").offsetHeight + document.body.scrollTop;

				if (x2<0)
					x2=0;

				if (y2<0)
					y2=0;
			};
		}
	}
}

//create TL or BR point
function pointSet(x,y)
{
	if (!ptype)
	{
		x1=x+document.body.scrollLeft;
		y1=y+document.body.scrollTop;
		rectangleHide('area');
		inputUpdate();
	}
	else
	{
		x2=x+document.body.scrollLeft;
		y2=y+document.body.scrollTop;
		pointCorrect();
		inputUpdate();
	}
	ptype = !ptype;
}

//correcting TL and BR points if they are changed
function pointCorrect(x1c,y1c,x2c,y2c)
{
	if (x1c && y1c && x2c && y2c)
	{
		if (x1c>x2c)
		{
			temp=x1c;
			x1c=x2c;
			x2c=temp;
		}

		if (y1c>y2c)
		{
			temp=y1c;
			y1c=y2c;
			y2c=temp;
		}

		var arrReturn = new Array (x1c,y1c,x2c,y2c);

		return arrReturn;
	}
	else
	{
		if (x1>x2)
		{
			temp=x1;
			x1=x2;
			x2=temp;
		}
		if (y1>y2)
		{
			temp=y1;
			y1=y2;
			y2=temp;
		}
	}
}

//draw rectangle area
function rectangleDraw(rectId)
{
	var coords = new Array (4);
	coords=pointCorrect(x1,y1,x2,y2);
	var rect = document.getElementById(rectId);
	rect.style.border='dashed 2px #EEEEEE';
	rect.style.position='relative';
	rect.style.fontSize='0px';
	rect.style.left=coords[0]+'px';
	rect.style.top=coords[1]+'px';
	rect.style.width=coords[2]-coords[0]+'px';
	rect.style.height=coords[3]-coords[1]+'px';
}

//draw rectangle area
function rectangleDrawInput(rectId)
{
	var coords = new Array (4);
	coords=pointCorrect(document.getElementById('x1_inp').value,document.getElementById('y1_inp').value,document.getElementById('x2_inp').value,document.getElementById('y2_inp').value);
	var rect = document.getElementById(rectId);
	rect.style.border='dashed 2px #EEEEEE';
	rect.style.position='relative';
	rect.style.fontSize='0px';
	rect.style.left=coords[0]+'px';
	rect.style.top=coords[1]+'px';
	rect.style.width=coords[2]-coords[0]+'px';
	rect.style.height=coords[3]-coords[1]+'px';
}

//hide rectangle area
function rectangleHide(rectId)
{
	var rect = document.getElementById(rectId);
	rect.style.border='0px';
	rect.style.fontSize='0px';
	rect.style.left='0px';
	rect.style.top='0px';
	rect.style.width='0px';
	rect.style.height='0px';
}

//update input fields
function inputUpdate()
{
	document.getElementById('x1_inp').value=x1;
	document.getElementById('y1_inp').value=y1;
	document.getElementById('x2_inp').value=x2;
	document.getElementById('y2_inp').value=y2;

	document.getElementById('th_width').value=Math.abs(x2-x1);
	document.getElementById('th_height').value=Math.abs(y2-y1);

	if (tmbwidth==0)
		document.getElementById('th_w').value=Math.abs(x2-x1);

	if (tmbheight==0)
		document.getElementById('th_h').value=Math.abs(y2-y1);
}

function inpWidthUpd()
{
	document.getElementById('x2_inp').value=parseInt(document.getElementById('x1_inp').value)+parseInt(document.getElementById('th_width').value);
	if (tmbwidth==0) document.getElementById('th_w').value=document.getElementById('th_width').value;
	rectangleDrawInput('area');
};

function inpHeightUpd()
{
	document.getElementById('y2_inp').value=parseInt(document.getElementById('y1_inp').value)+parseInt(document.getElementById('th_height').value);
	if (tmbheight==0) document.getElementById('th_h').value=document.getElementById('th_height').value;
	rectangleDrawInput('area');
};

function inpXYUpd()
{
	document.getElementById('th_width').value=parseInt(document.getElementById('x2_inp').value)-parseInt(document.getElementById('x1_inp').value);
	if (tmbwidth==0) document.getElementById('th_w').value=document.getElementById('th_width').value;

	document.getElementById('th_height').value=parseInt(document.getElementById('y2_inp').value)-parseInt(document.getElementById('y1_inp').value);
	if (tmbheight==0) document.getElementById('th_h').value=document.getElementById('th_height').value;

	rectangleDrawInput('area');
};
function inpWnovUpd()
{
	//Вычислим пропорцию
    var pr=document.getElementById('th_width').value/document.getElementById('th_height').value;
	document.getElementById('th_h').value=document.getElementById('th_w').value/pr;
};
function inpHnovUpd()
{
	//Вычислим пропорцию
    var pr=document.getElementById('th_width').value/document.getElementById('th_height').value;
	//document.getElementById('th_w').value=document.getElementById('th_h').value*pr;
};