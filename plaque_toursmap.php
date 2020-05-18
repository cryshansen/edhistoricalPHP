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
    $map->mapWidth   = 675;

    /*** the map height ***/
    $map->mapHeight  = 500;

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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="Edmonton Alberta plaques,Edmonton Historical Board Plaques,Edmonton Historical Board Map,Edmonton Plaque Map,Edmonton Historical Board plaques recognition program, Edmonton Alberta landmark plaques, Edmonton Alberta building plaques, historic sites of Edmonton Alberta, Edmonton Alberta historic sites, historic buildings of Edmonton Alberta, Edmonton Alberta historic buildings, historic sites, historic buildings" />
<meta name="description" content="Search map of plaques awarded on Edmonton Alberta’s landmark buildings and places. " />

<title>Welcome To Edmonton Historical Board : Plaque Map</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Edmonton Historical Board: Neighbourhood Map</title>
	<!-- online key
	-->
	    <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAr-VkLAVeby8KYZyn0ivvehSWkCJnp-ZkYp3eaq1ccwkzROXybBQ4j3xdpq-C6hciAMOIq_DPfyHO9A" type="text/javascript"></script>
</head>

<body>

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
$m_landmark = new controllerClass();

	if(isset($_GET['keywd'])){
	$keywd=$_GET['keywd'];
}else{
	$keywd="";
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
			<td>Keyword:<br />
			<input name="keywd" type="text" value=""></td>		
			<td>Neighbourhood: <br />
							<?php displayNeighbourhood(); ?>
						</td>
			<td><br /><input class="btton" name="list_submit" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
	</table>
</form>

<?php
		if(isset($_POST['list_submit'])){
			$result=$m_landmark->getPlaquesforMap($_POST);
			if ($result)
			{
				$count=1;
				while($row=mysql_fetch_array($result))
				{
						$row['plq_recipient']=addslashes($row['plq_recipient']);
						$row['plq_location']=addslashes($row['plq_location']);
						$row['plq_inscription'] =  substr( $row['plq_inscription'],0, 178);
						$row['plq_inscription'] = $row['plq_inscription']."...";
						$row['plq_inscription']=addslashes($row['plq_inscription']);
					if($row['plq_latitude'] !='' or $row['plq_longitude'] !=''){	
						$result2=$m_landmark->getLandmarkAllfromPlaque($_GET['id']);
						$rowcount=mysql_num_rows($result2);
						if ($rowcount>0)//$result2)
						{
								while($row2=mysql_fetch_array($result2))
								{
									$row2['land_description'] =  substr( $row2['land_description'],0, 178);
									$row2['land_description'] = $row2['land_description']."...";
									$row2['land_description']=addslashes($row2['land_description']);
	
									$map->addMarker($row['plq_latitude'], $row['plq_longitude'], '<h2>Plaque: '.$row['plq_recipient'].'</h2><p>'.$row['plq_location'].'<br />'.$row['plq_inscription'].'</p><h2>Site Name:</h2>'.$row2['land_name'].'</h2><p>'.$row2['street_address'].'</p><p>'.$row2['land_description'].'</p>');
									//$map->addMarker($row2['latitude'], $row2['longitude'], '<h2>'.$row2['land_name'].'</h2><p>'.$row2['street_address'].'</p>');
								}
						}else{
								$map->addMarker($row['plq_latitude'], $row['plq_longitude'], '<h2>Plaque: '.$row['plq_recipient'].'</h2><p>'.$row['plq_location'].'<br />'.$row['plq_inscription'].'</p>');
						}
					}else{
						echo "<p>Sorry we encountered an error.</>";
					}
						//echo $count;
						$count++;
				}
			}
		}elseif(isset($_GET['id'])){	
			$result=$m_landmark->getPlaqueById($_GET['id']);
			if ($result){
				$count=1;
				while($row=mysql_fetch_array($result))
				{
						$row['plq_recipient']=addslashes($row['plq_recipient']);
						$row['plq_location']=addslashes($row['plq_location']);
						$row['plq_inscription'] =  substr( $row['plq_inscription'],0,100);
						$row['plq_inscription'] = $row['plq_inscription']."...";
						$row['plq_inscription']=addslashes($row['plq_inscription']);
					if($row['plq_latitude'] !='' or $row['plq_longitude'] !=''){	
						$result2=$m_landmark->getLandmarkAllfromPlaque($_GET['id']);
						$rowcount=mysql_num_rows($result2);
						if ($rowcount>0)//$result2)
						{
							while($row2=mysql_fetch_array($result2))
							{
								$row2['land_description'] =  substr( $row2['land_description'],0, 178);
								$row2['land_description'] = $row2['land_description']."...";
								$row2['land_description']=addslashes($row2['land_description']);

								$map->addMarker($row['plq_latitude'], $row['plq_longitude'], '<h2>Plaque: '.$row['plq_recipient'].'</h2><p>'.$row['plq_location'].'<br />'.$row['plq_inscription'].'</p><h2>Site Name:'.$row2['land_name'].'</h2><p>'.$row2['street_address'].'</p><p>'.$row2['land_description'].'</p>');
								//$map->addMarker($row2['latitude'], $row2['longitude'], '<h2>'.$row2['land_name'].'</h2><p>'.$row2['street_address'].'</p>');
							}
						}else{
							$map->addMarker($row['plq_latitude'], $row['plq_longitude'], '<h2>Plaque: '.$row['plq_recipient'].'</h2><p>'.$row['plq_location'].'<br />'.$row['plq_inscription'].'</p>');						
						}

					}
				}		
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}else{
						echo "<p>Your query resulted in 0 rows returned.</p>";
		}



 echo $map->drawMap(); 
 
 
 ?>

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
