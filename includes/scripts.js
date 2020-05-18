// JavaScript Document


/**************************************TESTING Owner Retrieval***********************************/
function showOwner(ownerid)
{ 
	alert("I got here!")
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var url="../admin/apps/landmark/getowner.php"
	url=url+"?fkowner_id="+ownerid 
	url=url+"&sid="+Math.random()
	alert(url)
	xmlHttp.onreadystatechange=stateChangedForOwner
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
function stateChangedForOwner() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtOwner").innerHTML=xmlHttp.responseText 
	} 
}


/************************************************ Creates the HTTP OBJECT FOR AJAX HANDLING  **************************/

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		//Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}