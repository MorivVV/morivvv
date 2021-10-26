var xmlHttp = createXmlHttpRequestObject();

function createXmlHttpRequestObject()
{
	var xmlHttp;
	if(window.ActiveXObject)	{
		try		{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e)		{
			xmlHttp = false;
		}
	}
	else	{
		try		{
			xmlHttp = new XMLHttpRequest();
		}
		catch (e)		{
			xmlHttp = false;
		}
	}
	if (!xmlHttp)
		alert("Не удалось создать XMLHttpRequest объект.");
	else
		return xmlHttp;
}

function async(){
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)	{
		name = encodeURIComponent(document.getElementById("nick_name").value);
		xmlHttp.open("GET", "/ajax/ajax.php?nick_name=" + name, true);
		xmlHttp.onreadystatechange = ServerResponse;
		xmlHttp.send(null);
	}
	else
		setTimeout('async()', 1000);
}
function img_name_change(imgname){
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)	{
		var id =imgname.id;
		var name = imgname.value;
		xmlHttp.open("GET", "/img_name_change.php?new_name=" + name + "&id=" + id, true);
		xmlHttp.send(null);
	}
	else
		setTimeout('img_name_change()', 1000);
}

function RunSQL(sql){
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)	{
		xmlHttp.open("GET", "/ajax/ajaxSQL.php?SQL=" + sql, true);
		xmlHttp.send(null);
	}
	else
		setTimeout('RunSQL()', 1000);
}

function SaveXY(x,y,id){
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)	{
		xmlHttp.open("GET", "/savexy.php?x=" + x + "&y=" + y + "&id=" + id, true);
		xmlHttp.send(null);
	}
	else
		setTimeout('SaveXY()', 1000);
}

function ServerResponse(){
	if (xmlHttp.readyState == 4)	{
		if (xmlHttp.status == 200)		{
			xmlResponse = xmlHttp.responseXML;
			xmlDocumentElement = xmlResponse.documentElement;
			helloMessage = xmlDocumentElement.firstChild.data;
			document.getElementById("check").innerHTML =
			'<i>' + helloMessage + '</i>';
			//setTimeout('async()', 1000);
		}
		else		{
			alert("Error accessing the server: " +
			xmlHttp.statusText);
		}
	}
}