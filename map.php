<?php

/*** include the phroogle class definition ***/
include ('includes/phproogle.class.php');

try
{
    /*** a new phproogle instance ***/
    $map = new phproogleMap();

    /*** the google api key ***/
    $map->apiKey = 'ABQIAAAAASPkxhpVbd6wClv2BfZq2hQbbxrhhjzqV-p8DVENOBEFTxznYRT4wgfIT4XRcRUjUazE762D6H5h5w';

    /*** zoom is 0 - 19 ***/
    $map->mapZoom    = 12;

    /*** the map width ***/
    $map->mapWidth   = 600;

    /*** the map height ***/
    $map->mapHeight  = 450;

    /*** set the map type ***/
    $map->mapType = 'normal';

	/*** set the map center ***/
	$map->mapCenter = array(53.541944,-113.490833);
	
	/*** add some controls ***/
	$map->addGoogleMapControl('GMapTypeControl');
	$map->addGoogleMapControl('GSmallMapControl');
	$map->addGoogleMapControl('GOverviewMapControl');


    /*** add some controls ***/
    $map->addGoogleMapControl('GMapTypeControl');
    $map->addGoogleMapControl('GSmallMapControl');
    $map->addGoogleMapControl('GOverviewMapControl');

    /*** add some marker addresses ***/
   // $map->addMarkerAddress('2 Pitt St Sydney NSW Australia', '<h2>Head Office</h2>');
    //$map->addMarkerAddress('122 Pitt St Sydney NSW Australia', '<h2>The Factory</h2>');

    /*** set the map div id ***/
    $map->mapDivID = 'map';
}
catch( Exception $e )
{
    echo $e->getMessage();
}
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Edmonton Historical Board: Neighbourhood Map</title>
<?php echo $map->googleJS(); ?>
</head>
<body>
<div id="header">
<div id="logo">

</div>
		<ul id="topmenu">
		<li><a href="index.html">Home</a></li>
		<li><a href="Plaques.html">Plaques</a></li>
		<li><a href="awards.html">Awards</a></li>
		<li class="current"><a href="Landmarks.html">Landmark</a></li>
		<li><a href="about_us.html">About Us</a></li>
		<li><a href="contact_us.html">Contact Us</a></li>	
		</ul>
</div>
<div id="contents">

<h1>Edmonton Historical Board's Catalogue of Landmarks</h1>
<strong>Historical Landmarks Map Zone</strong>

<?php  

require_once('admin/projectClasses/controller.php');
$m_landmark = new controllerClass();

	if(isset($_GET['keywd'])){
	$keywd=$_GET['keywd'];
}else{
	$keywd="";
}
if(isset($_GET['loc']))
{
	$loc=$_GET['loc'];
}else{
	$loc="";
}
if(isset($_GET['fkneighbor_id']))
{
	$fkneighbor_id =$_GET['fkneighbor_id'];
}else{
	$fkneighbor_id ="";
}
	?>
<form action="" method="post">
	<table>
		<tr>
			<td>Neighbourhood: <br />
							<?php displayNeighbourhood(); ?>
						</td>
			<td>Location:<br />
			<input name="loc" type="text" value=""></td>

			<td>Keyword:<br />
			<input name="keywd" type="text" value=""></td>
			<td><br /><input class="btton" name="list_submit" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
	</table>
</form>

<?php
		if(isset($_POST['list_submit'])){
			$result=$m_landmark->getLandmarksForMap($_POST);
			if ($result)
			{
				$count=1;
				while($row=mysql_fetch_array($result))
				{
						$map->addMarker($row['latitude'], $row['longitude'], '<h2>'.$row['land_name'].'</h2><p>'.$row['street_address'].'</p>');
						echo $count;
						$count++;
				}
			}
		}elseif(isset($_GET['id']))
		{	
		}else{
			echo "<p>Your query resulted in 0 rows returned.</p>";
		}



 echo $map->drawMap(); 
 
 
 ?>
 

</div>
		<ul id="menu">
		<li><a href="landmark_search.php">Search Landmarks </a></li>
		<li><a href="landmark_tours.php">Landmark Tours</a></li>
		<li><a href="landmark_images.php">Landmark Images</a></li>	
		</ul>
<div id="footer">
<a href="#">XHTML 1.0</a> | <a href="#">CSS</a> | Designed by : <a href="http://www.ramblingsoul.com">Rambling Soul
</a></div>
<
</body>
</html> 
 <?php
  /* ------------------------------------------- Display Neighbourhood ------------------------------------------*/

	function displayNeighbourhood()
	{
		require_once('admin/projectClasses/controller.php');
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
