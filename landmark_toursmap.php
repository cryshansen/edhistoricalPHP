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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="Edmonton Alberta landmarks, Edmonton Alberta landmark buildings,Search Edmonton landmark places, Search Edmonton historical sites, Edmonton Alberta landmark places, historic sites of Edmonton Alberta, Edmonton Alberta historic sites, historic buildings of Edmonton Alberta, Edmonton Alberta historic buildings, historic sites, historic buildings " />
<meta name="description" content="A search on Edmonton Alberta’s landmark buildings and places. " />

<title>Welcome To Edmonton Historical Board</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Edmonton Historical Board: Neighbourhood Map</title>
	<!-- online key
	-->
	    <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAr-VkLAVeby8KYZyn0ivvehSWkCJnp-ZkYp3eaq1ccwkzROXybBQ4j3xdpq-C6hciAMOIq_DPfyHO9A" type="text/javascript"></script>
</head>
<body>
<div id="header"> 
  <div align="center"> 
    <div id="logo"> 
		<img src="images/cooltext442749221.png" atl="HeaderImage"/>
	</div> 

		<ul id="topmenu">
		<li><a href="index.html">Home</a></li>
		<li><a href="Plaques.html">Plaques</a></li>
		<li><a href="awards.html">Awards</a></li>
		<li class="current"><a href="Landmarks.html">Landmark</a></li>
		<li><a href="about_us.html">About Us</a></li>
		<li><a href="contact_us.html">Contact Us</a></li>	
		</ul></div>
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
			<td><br /><input class="btton"  name="list_submit" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
	</table>
</form>
<?php
		if(isset($_POST['list_submit'])){
			$result=$m_landmark->getLandmarksForMap($_POST);
			$rowcount=mysql_num_rows($result);
			if ($rowcount >0)
			{
				$count=1;
				while($row=mysql_fetch_array($result))
				{
					$row['land_name']=addslashes($row['land_name']);
					$row['street_address']=addslashes($row['street_address']);
					$row['land_description'] =  substr( $row['land_description'],0, 178);
					$row['land_description'] = $row['land_description']."...";
					$row['land_description']=addslashes($row['land_description']);
					if($row['latitude'] !='' or $row['longitude'] !=''){	
						$result2=$m_landmark->getPlaquesAllfromLandmark($_GET['id']);
						if ($result2)
						{				
							while($row2=mysql_fetch_array($result2))
							{
								if($row['latitude']==$row2['plq_latitude'])
								{//add increment to row2
									$row2['plq_latitude'] =$row2['plq_latitude'] +.00002;
									echo "The lattitude is".$row2['plq_latitude'] ;
								}
								if($row['longitude']==$row2['plq_longitude'])
								{
									$row2['plq_longitude'] =$row2['plq_longitude'] +.00002;
									echo "The longitude is".$row2['plq_longitude'] ;
								}
							$row2['plq_recipient']=addslashes($row2['plq_recipient']);
							$row2['plq_location']=addslashes($row2['plq_location']);
							$map->addMarker($row['latitude'], $row['longitude'], '<h2>'.$row['land_name'].'</h2><p>'.$row['street_address'].'<br />'.$row['land_description'].'</p><h2>Plaque Location:</h2><p>'.$row2['plq_location'].'</p>');	
							$count++;
							}
						}else{
							$map->addMarker($row['latitude'], $row['longitude'], '<h2>'.$row['land_name'].'</h2><p>'.$row['street_address'].'<br />'.$row['land_description'].'</p>');
						}
					}
				}
			}else{
				echo "Your query has no corresponding results.";
			}
		}elseif(isset($_GET['id'])){	
			$result=$m_landmark->getLandmarkByID($_GET['id']);
			if ($result)
			{	
				$count=1;
				while($row=mysql_fetch_array($result))
				{
						//print_r($row);
						$row['land_name']=addslashes($row['land_name']);
						$row['street_address']=addslashes($row['street_address']);
						$row['land_description'] =  substr( $row['land_description'],0, 178);
						$row['land_description'] = $row['land_description']."...";
						$row['land_description']=addslashes($row['land_description']);
						if($row['latitude'] !='' or $row['longitude'] !=''){	
						$result2=$m_landmark->getPlaquesAllfromLandmark($_GET['id']);
						$rowcount=mysql_num_rows($result2);
						if ($rowcount>0)
						{				
							while($row2=mysql_fetch_array($result2))
							{
								if($row['latitude']==$row2['plq_latitude'])
								{//add increment to row2
									$row2['plq_latitude'] =$row2['plq_latitude'] +.00002;
								}
								if($row['longitude']==$row2['plq_longitude'])
								{
									$row2['plq_longitude'] =$row2['plq_longitude'] +.00002;
								}
							//echo $count;
							$row2['plq_recipient']=addslashes($row2['plq_recipient']);
							$row2['plq_location']=addslashes($row2['plq_location']);
							$map->addMarker($row['latitude'], $row['longitude'], '<h2>'.$row['land_name'].'</h2><p>'.$row['street_address'].'<br />'.$row['land_description'].'</p><h2>Plaque Location:</h2><p>'.$row2['plq_location'].'</p>');
							}
						}else{
							$map->addMarker($row['latitude'], $row['longitude'], '<h2>'.$row['land_name'].'</h2><p>'.$row['street_address'].'<br />'.$row['land_description'].'</p>');
						}
					}
				}
			}		

		}else{
			echo "<p>Your query resulted in 0 rows returned.</p>";
		}



 echo $map->drawMap(); 
 
 
 ?>


</div>
		<ul id="menu">
		<li><a href="landmark_search.php">Search Landmarks </a></li>
		
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
