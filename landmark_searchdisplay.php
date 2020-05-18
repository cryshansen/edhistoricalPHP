<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="Edmonton Alberta landmarks, Edmonton Alberta landmark buildings,Search Edmonton landmark places, Search Edmonton historical sites, Edmonton Alberta landmark places, historic sites of Edmonton Alberta, Edmonton Alberta historic sites, historic buildings of Edmonton Alberta, Edmonton Alberta historic buildings, historic sites, historic buildings,search landmark places " />

	<meta name="description" content="Display the content from the Edmonton Historical Board Landmarks catalogue." />

<title>Edmonton Historical Board - Landmark Display</title>
<link rel="stylesheet" type="text/css" href="css/lightbox.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder" ></script>
<script type="text/javascript" src="js/lightbox.js"></script>
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

<?php require_once("admin/projectClasses/controller.php");
$m_plaque = new controllerClass();
if(isset($_GET['id']))
{
	//display individual
	$result=$m_plaque->getLandmarkById($_GET['id']);
	while ($row = mysql_fetch_array($result))
	{								
		//call display function()
		displayListing($row);
	
	}
}else{

	//call dislay function() with empty parameters
	//displayListing($plaque_vars);
}


function displayListing($row)
{
?>
<h1>Landmark Details</h1>
		
	
			
			<h2>Landmark Name: <?php echo $row['land_name']; ?></h2>
			<p class="heading"><strong>Address: </strong><?php echo $row['street_address'];?><br />
			<strong>Locations: </strong><?php echo $row['location'];?><br />
			<strong>Classification: </strong><?php echo $row['classification'];?><br />
			<strong>Designation: </strong><?php echo $row['designation'];?><br />
			<strong>Year Built: </strong> <?php echo $row['land_age'];?></p>
			
			<p><strong>Landmark Description:</strong><?php echo $row['land_description'];?><br /></p>


			<p><Strong>Click on <a href="landmark_toursmap.php?id=<?php echo $row['pklandmark_id'];?>">Landmarks Neighbourhood Walking map</a> to view the map</Strong></p>
			<br />
			<h1>Plaque Details</h1>
<?php 
		$m_plaque = new controllerClass();
		$result=$m_plaque->getPlaquesAllfromLandmark($row['pklandmark_id']);
		while($row2=mysql_fetch_array($result))
		{
		?>	
			<p><strong>Plaque receipent: </strong><?php echo $row2['plq_recipient'];?></p>
			<p><strong>Plaque Inscription:</strong><?php echo $row2['plq_inscription'];?></p>

<!-- 			<p><strong> Click on <a href="plaque_toursmap.php?id=<?php //echo $row2['pkplaque_id']; ?>">Plaque Neighbourhood Map</a> to view the map </strong></p>
 -->
<br />

<h1>Landmark Images:</strong></h1>
		<?php
				$m_images = new controllerClass();
				$results=$m_images->getImagesByLandmarkId($row['pklandmark_id']);
				if($results){?>
						<tr>
			<?php
					while($row = mysql_fetch_array($results))
					{
						if($i%3==0 && $i!=0)
						{
							echo "				</tr>\n";
							echo "				<tr valign=\"top\">\n";
						}
			
					?>		
						
						<td><a href="<?php echo "images/gallery/".$row['image_name']?>" rel="lightbox" title="<?php echo stripslashes($row['image_title']); ?>">
						<img src="<?php echo "images/gallery/small/".trim($row['image_name']); ?>" alt="<?php echo stripslashes($row['image_title']); ?>"></a></td>
						
			<?php 	} ?>
				</tr>
			<?php
			}
		}

}


?>

</div>



</div>
		<ul id="menu">
		<li><a href="landmark_search.php">Search Landmarks </a></li>
		
</ul>
<div id="footer">
Copyright © 2009 Edmonton Historical Board. 
All Rights Reserved.
</a></div>
</body>
</html>