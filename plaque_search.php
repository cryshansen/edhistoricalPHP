<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="Edmonton Alberta plaques,Edmonton Historical Board Plaques,Edmonton Historical Board plaques recognition program, Edmonton Alberta landmark plaques, Edmonton Alberta building plaques, historic sites of Edmonton Alberta, Edmonton Alberta historic sites, historic buildings of Edmonton Alberta, Edmonton Alberta historic buildings, historic sites, historic buildings" />
<meta name="description" content="Search plaques awarded on Edmonton Alberta’s landmark buildings and places. " />

<title>Edmonton Historical Board: Plaque Search</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
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

<h1>Search the Catalogue Of Plaques</h1>
<p><em>These searching features have been designed to assist you to find Plaques associated with Edmonton's Historical Plaque Catalogue. You can search by Neighbourhood using the drop down menu, you can search according to keywords or use both and then click on "View Listing" button.</em></p>
<?php
require_once("admin/projectClasses/controller.php");
$m_plaque = new controllerClass();
$keywd=""; //description  title, content
$url="plaque_search.php?page=plaque";
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
			
			<td><br /><input class="btton" name="list_submit" type="submit" value="View Listing"></td>
		</tr>
		<tr>
            <td colspan="3"> <a href="">View All listings</a></td>
		</tr>	
	</table>
    </form>
<?php	
		if(isset($_POST['list_submit'])){
			$results=$m_plaque->getPlaquesforSearch($_POST,$currpg,$url);
			$rowcount=mysql_num_rows($results);
			if ($rowcount > 0)
			{
				displayListing($results);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}elseif(($keywd !="") or ($fkneighbor_id !="")) { 
			$url .="&keywd=".$keywd."&fkneighbor_id=".$fkneighbor_id; 
			$vars = array('keywd'=>$keywd, 'fkneighbor_id'=>$fkneighbor_id); 
			$results=$m_plaque->getPlaquesforSearch($vars,$currpg,$url);
			

		}else{
			$result=$m_plaque->getAllPlaques($currpg,$url);
			displayListing($result);
		}
		
function displayListing($result){
?>
<p><strong>Historical Mapping Tours:</strong></p>
<ul>
<?php 
while($row=mysql_fetch_array($result)){
	?>
<li><a href="plaque_searchdisplay.php?id=<?php echo $row['pkplaque_id']; ?>"><?php echo $row['plq_recipient']; ?></a><br /><?php echo $row['plq_desc'];?>
</li>
<?php 
}
?>
    
										
<ul>            

<?php
}
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
<div id="footer">
Copyright © 2009 Edmonton Historical Board. 
All Rights Reserved.
</a></div>
</body>
</html>

