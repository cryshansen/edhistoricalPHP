// JavaScript Document
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
//STATE CHANGE FOR  ASSOCIATIONS TO PLAQUES / LANDMARKS / AWARDS
function stateChangedForAssociation() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtAssoc").innerHTML=xmlHttp.responseText 
	} 
}
//FUNCTION TO REMOVE IMAGE ASSOCIATION WITH PLAQUE

function removePlaque($id)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var mySplitResult = $id.split("-");
	var url="../admin/apps/image/removeAssociation.php"
	url=url+"?pid="+mySplitResult[0]
	url = url+"&imgid="+mySplitResult[1]
	url=url+"&name=Plaque"
	url=url+"&sid="+Math.random()
	alert(url);
	xmlHttp.onreadystatechange=stateChangedForAssociation
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)


}
//FUNCTION TO REMOVE IMAGE ASSOCIATION WITH LANDMARK

function removeLandmark($id)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var mySplitResult = $id.split("-");
	var url="../admin/apps/image/removeAssociation.php"
	url=url+"?pid="+mySplitResult[0]
	url = url+"&imgid="+mySplitResult[1]
	url=url+"&name=Land"
	url=url+"&sid="+Math.random()
	
	xmlHttp.onreadystatechange=stateChangedForAssociation
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
//FUNCTION TO REMOVE IMAGE ASSOCIATION WITH AWARD

function removeAward($id)
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var mySplitResult = $id.split("-");
	var url="../admin/apps/image/removeAssociation.php"
	url=url+"?pid="+mySplitResult[0]
	url = url+"&imgid="+mySplitResult[1]
	url=url+"&name=Award"
	url=url+"&sid="+Math.random()
	alert(url);
	xmlHttp.onreadystatechange=stateChangedForAssociation
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)


}
// REQJUIRED FOR PLAQUE FORM
function showLandmark(ownerid)
{ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var url="../admin/apps/plaque/getlandmark.php"
	url=url+"?fklandmark_id="+ownerid 
	url=url+"&sid="+Math.random()
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

//REQUIRED FOR IMAGES TO ADD RELATIONSHIP ASSOCIATIONS
function getDropDown(itemID)
{ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	}
	var url="../admin/apps/image/getListing.php"
	url=url+"?listId="+itemID 
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=stateChangedForListing
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
function stateChangedForListing() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtListing").innerHTML=xmlHttp.responseText 
	} 
}
