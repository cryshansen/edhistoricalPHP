<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome To Edmonton Historical Board</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Edmonton Historical Board: Neighbourhood Map</title>
	<!-- online key
	-->
	    <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAr-VkLAVeby8KYZyn0ivvehSWkCJnp-ZkYp3eaq1ccwkzROXybBQ4j3xdpq-C6hciAMOIq_DPfyHO9A" type="text/javascript"></script>
<!-- local key
    <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAzr2EBOXUKnm_jVnk0OJI7xSosDVG8KKPE1-m51RBrvYughuyMxQ-i1QfUnH94QxWIa6N4U6MouMmBA" type="text/javascript"></script> -->
    <script type="text/javascript">
	var mapContainer=null;
    var mapLng = -113.490833;
	var mapLat = 53.541944;
	var mapZoom = 3;
	var locationsXml = 'locations.php';
	
	function getNeighbourhood(id){
		//alert(id);
		locationsXml = 'locations.php?fkneighbor_id='+id ;
		//alert(locationsXml);
		init();
		loadMap();
	}
    function init() {
        mapContainer = document.getElementById("map");
		loadMap();
	}
    
	function createInfoMarker(point,theaddy)
	{
		var marker = new GMarker(point);
		GEvent.addListener(marker, "click",function () {marker.openInfoWindowHtml(theaddy);	});
		return marker;
	}
function loadMap()
{
	var map = new GMap(mapContainer);
	map.addControl(new GMapTypeControl());
	map.addControl(new GLargeMapControl());
	map.centerAndZoom(new GPoint(mapLng,mapLat),mapZoom);
	
	var request = GXmlHttp.create();
	request.open("POST",locationsXml,true);
	request.onreadystatechange= function(){
		if (request.readyState==4){ 
		var xmlDoc = request.responseXML;
		
		var markers = xmlDoc.documentElement.getElementsByTagName("marker");
		for(var i=0;i< markers.length; i++){
			var point = new GPoint(parseFloat(markers[i].getAttribute("longitude")),
									parseFloat(markers[i].getAttribute("latitude")));
		var theaddy = '<div class="location"><strong>'
					+ markers[i].getAttribute('locname')
					+ '</strong><br />';
			theaddy +=markers[i].getAttribute('address') + '<br />';
			
			theaddy +=markers[i].getAttribute('city') + ', ';
			theaddy +=markers[i].getAttribute('province') + ' <br />';
			theaddy += '</div>';
			
			var marker = createInfoMarker(point,theaddy);
			map.addOverlay(marker);
		}
	}
	}
	request.send('a');
}

    </script>
</head>

<body onload="init()">

<div id="header">
<div id="logo">

</div>
		<ul id="topmenu">
		<li><a href="index.html">Home</a></li>
		<li class="current"><a href="Plaques.html">Plaques</a></li>
		<li><a href="awards.html">Awards</a></li>
		<li><a href="Landmarks.html">Landmark</a></li>
		<li><a href="about_us.html">About Us</a></li>
		<li><a href="contact_us.html">Contact Us</a></li>		
		</ul>
</div>
<div id="contents">

<h1>Plaque Recognition Program</h1>

<strong>Plaque Awards Map Zone</strong>
<?php  

	require_once('admin/projectClasses/controller.php');
	?>
<form action="" method="post">
	<table>
		<tr>
			<td>Neighbourhood: <br />
							<?php displayNeighbourhood(); ?>
						</td>
			<td>Location:<br />
			<input name="location" type="text" value=""></td>

			<td>Keyword:<br />
			<input name="keyword_text" type="text" value=""></td>
			<td><br /><input class="btton" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
	</table>
</form>


<p>Your Landmark Map search for <?php echo $_GET['fkneighbor_id']; ?> is below:</p>
<div id="map" style="width: 500px; height: 400px"></div>



</div>
		<ul id="menu">
		<li><a href="plaque_search.php">Plaque Search</a></li>
				</ul>
<div id="footer">
Copyright 2009
</a></div>
</body>
</html>
<?php
/* ------------------------------------------- Display Neighbourhood ------------------------------------------*/

	function displayNeighbourhood()
	{
			$m_landmark = new controllerClass();
			$results=$m_landmark->getAllNeighbourhoods();

	?>
											<select name="fkneighbor_id">
											<option>Choose a Neighbourhood...</option>
				<?php
				while($row=mysql_fetch_array($results))
				{
				?>
		
												<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
				<?php 
				}
				?>
											</select>

	
<?php
	}

?>
