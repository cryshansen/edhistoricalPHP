<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="Edmonton Alberta landmarks, Edmonton Alberta landmark buildings,Search Edmonton landmark places, Search Edmonton historical sites, Edmonton Alberta landmark places, historic sites of Edmonton Alberta, Edmonton Alberta historic sites, historic buildings of Edmonton Alberta, Edmonton Alberta historic buildings, historic sites, historic buildings " />
<meta name="description" content="A Map search on Edmonton Alberta’s landmark buildings and places." />

<title>Welcome To Edmonton Historical Board</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
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

<h1>Search the Catalogue of Landmarks</h1>
<p>Unique Buildings and spaces reside throughout Edmonton. The Edmonton Historical Board has dedicated their resources to cataloguing and making these unique buildings and spaces available to visitors and the public to gain a greater appreciation of Edmonton's heritage. Implementing search features on the site allows the public to enjoy landmarks and walking tours.</p>
<p><em>These searching features have been designed to assist you to find Landmarks associated with Edmonton's Historical Landmark Catalogue. You can search by Neighbourhood using the drop down menu, you can search according to keywords or use both and then click on "View Listing" button.</em></p>

</p>
<?php
require_once("admin/projectClasses/controller.php");
$m_landmark = new controllerClass();

$keywd=""; //description  title, content
$url="landmark_search.php?page=landmark";
$currpg ="";
if(isset($_GET['pgid']))
{
	$currpg = $_GET['pgid'];
}else{$currpg="";}

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
			<td><br /><input class="btton"name="list_submit" type="submit" value="View Listing"></td>
		</tr>
		<tr>
            <td colspan="3"> <a href="">View All listings</a></td>
		</tr>	
	</table>
    </form>
<?php	
		if(isset($_POST['list_submit'])){
			$results=$m_landmark->getLandmarksByCriteria($_POST,$currpg,$url);
			if ($results)
			{
				displayListing($results);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}elseif(($keywd !="") or ($plq_inscript_reqd !="")) { 
			$url .="&keywd=".$keywd."&fkneighbor_id=".$fkneighbor_id; 
			$vars = array('keywd'=>$keywd, 'fkneighbor_id'=>$fkneighbor_id); 
			$results=$m_plaque->getLandmarksByCriteria($vars,$currpg,$url);
			displayListing($result);

		}else{
			$result=$m_landmark->getAllLandmarks($currpg,$url);
			
			displayListing($result);
		}
		
function displayListing($result){
?>
<p><strong>Historical Landmarks:</strong></p>
<ul>
<?php 
while($row=mysql_fetch_array($result)){
	?>
<li><a href="landmark_searchdisplay.php?id=<?php echo $row['pklandmark_id']; ?>"><?php echo $row['land_name']; ?></a><br /><?php echo $row['land_description'];?></li><?php 
}
?>
</ul>             
	
<?php
}
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
