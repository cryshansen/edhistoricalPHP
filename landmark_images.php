<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edmonton Historical Board : Landmark Images</title>
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

<h1>Edmonton Historical Board's Catalogue of Landmarks</h1>
<strong>Historical Landmarks</strong>
<p>Unique Buildings and spaces reside throughout Edmonton. The Edmonton Historical Board has dedicated their resources to cataloguing and making these unique buildings and spaces available to visitors and the public to gain a greater appreciation of Edmonton's heritage. Implementing search features on the site allows the public to enjoy landmarks and walking tours.</p>

</p>
<?php  

	require_once('admin/projectClasses/controller.php');
	?>
<form action="" method="post">
	<table>
			<td>Neighbourhood: <br />
				<?php displayNeighbourhood(); ?>
			</td>		
			<td>Location:<br />
			<input name="location" type="text" value=""></td>

			<td>Keyword:<br />
			<input name="keyword_text" type="text" value=""></td>
			<td><br /><input class="btton" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
		<tr>
            <td colspan="3"> <a href="">View All listings</a></td>
		</tr>	
	</table>
</form>

<p><strong>Landmark Images:</strong></p>
<fieldset style='width:60%; border: none; padding-bottom:5px; text-align:center;'>

											<legend>&nbsp; <strong>Total Records Found: 15</strong>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Page 1 of 1&nbsp;</legend>
										</fieldset>
<table width='450'>
  <tr valign="top">
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/061_thu.jpg" alt="Alexander Macdonald Building" /></a> <br clear="all" />
      <b>Alexander Macdonald Building</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/024_thu.jpg" alt="Army and Navy Building" /></a> <br clear="all" />
      <b>Army and Navy Building</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/042_thu.jpg" alt="Birks Building" /></a> <br clear="all" />
      <b>Birks Building</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/045_thu.jpg" alt="Canada Permanent Building" /></a> <br clear="all" />
      <b>Canada Permanent Building</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/030_thu.jpg" alt="Canadian Imperial Bank of Commerce" /></a> <br clear="all" />
      <b>Canadian Imperial Bank of Commerce</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/032_thu.jpg" alt="Edmonton City Hall" /></a> <br clear="all" />
      <b>Edmonton City Hall</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/039_thu.jpg" alt="El-Mirador Apartments" /></a> <br clear="all" />
      <b>El-Mirador Apartments</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/068_thu.jpg" alt="Grand Hotel" /></a> <br clear="all" />
      <b>Grand Hotel</b></td>
  </tr>
  <tr valign="top">
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/067_thu.jpg" alt="Hudson\'s Bay Centre" /></a> <br clear="all" />
      <b>Hudson's Bay Centre</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/047_thu.jpg" alt="Kelly Block" /></a> <br clear="all" />
      <b>Kelly Block</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/038_thu.jpg" alt="Kingston Powell Building" /></a> <br clear="all" />
      <b>Kingston Powell Building</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/071_thu.jpg" alt="McLeod Building" /></a> <br clear="all" />
      <b>McLeod Building</b></td>

    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/003_thu.jpg" alt="Ortona Armoury" /></a> <br clear="all" />
      <b>Ortona Armoury</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/004_thu.jpg" alt="Paramount Theatre" /></a> <br clear="all" />
      <b>Paramount Theatre</b></td>
    <td width="25%" valign="top" align="left"><a href=""> <img src="http://www.albertasource.ca/realestate/images/photo_db/048_thu.jpg" alt="Ramsey Block" /></a> <br clear="all" />
      <b>Ramsey Block</b></td>
  </tr>
</table>

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
<div id="footer">
Copyright © 2009 Edmonton Historical Board. 
All Rights Reserved.
</a></div>
</body>
</html>
