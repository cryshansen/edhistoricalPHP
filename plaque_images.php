<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome To Edmonton Historical Board</title>
<link rel="stylesheet" type="text/css" href="css/lightbox.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder" ></script>
<script type="text/javascript" src="js/lightbox.js"></script>
</head>

<div id="header"> 
  	<div align="center"> 
    <div id="logo"> 
	<img src="images/cooltext442749221.png" atl="HeaderImage"/>
	</div> 

		<ul id="topmenu">
		<li><a href="index.html">Home</a></li>
		<li class="current"><a href="Plaques.html">Plaques</a></li>
		<li><a href="awards.html">Awards</a></li>
		<li><a href="Landmarks.html">Landmark</a></li>
		<li><a href="about_us.html">About Us</a></li>
		<li><a href="contact_us.html">Contact Us</a></li>		
		</ul></div>
</div>
<div id="contents">

<h1>Plaque Recognition Program</h1>

<strong>Plaque Awards</strong>

<p>Nominations will be accepted for a historically-relevant building or site. The awarded plaques will be installed at each location so that the public can gain a greater appreciation of Edmonton's heritage.</p>

<?php  

	require_once('admin/projectClasses/applications.php');
	?>
<form action="" method="post">
	<table>
		<tr>
<!--			<td>Image Type:<br />
				<select name="fkplaque_status_ID">
				<option value="">Choose a Type...</option>
				<option>Plaque</option>
				<option>Award</option>
				<option>Landmark</option>
				<option>No Type</option>
				</select></td>
-->			<td>Location:<br />
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

<p><strong>Plaque Images:</strong></p>
<fieldset style='width:60%; border: none; padding-bottom:5px; text-align:center;'>

											<legend>&nbsp; <strong>Total Records Found: 15</strong>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Page 1 of 1&nbsp;</legend>
										</fieldset>
<table width='450'>
  <tr valign="top">
    <td width="25%" valign="top" align="left"><a href="images/imagesplaques/Orange-Hall-plaque-2.jpg" rel="lightbox" title="Orange Hall Plaque"> <img src="images/imagesplaques/Orange-Hall-plaque-2.jpg" alt="Orange Hall Plaque" width="90" height="110" /></a> <br clear="all" />
      <b>Orange Hall Plaque 2</b></td>
    <td width="25%" valign="top" align="left"><a href="images/imagesplaques/Orange-Hall-plaque.jpg" rel="lightbox" title="Orange Hall Plaque" > <img src="images/imagesplaques/Orange-Hall-plaque.jpg" alt="Orange Hall Plaque" width="90" height="110" /></a> <br clear="all" />
      <b>Orange Hall Plaque</b></td>
    <td width="25%" valign="top" align="left"><a href="images/imagesplaques/Pantages-Theatre-plaque.jpg" rel="lightbox" title="Pantages Theatre Plaque"> <img src="images/imagesplaques/Pantages-Theatre-plaque.jpg" alt="Pantages Theatre Plaque" width="90" height="110"/></a> <br clear="all" />
      <b>Pantages Theatre Plaque</b></td>
    <td width="25%" valign="top" align="left"><a href="images/imagesplaques/Pemb_Assin_Athabasc_plaque.jpg" rel="lightbox" title="Pembina, Assiniboia and Athabasca Halls Plaque"><img src="images/imagesplaques/Pemb_Assin_Athabasc_plaque.jpg" alt="Pembina, Assiniboia and Athabasca Halls Plaque" width="90" height="110"/></a><br clear="all" />
      <b>Pembina, Assiniboia and Athabasca Halls Plaque</b></td>
    <td width="25%" valign="top" align="left"><a href="images/imagesplaques/Phillips-Bldg-plaque-flat.jpg" rel="lightbox" title="Phillips Building Plaque"> <img src="images/imagesplaques/Phillips-Bldg-plaque-flat.jpg" alt="Phillips Building Plaque" width="90" height="110" /></a> <br clear="all" />
      <b>Phillips Building Plaque</b></td>
    <td width="25%" valign="top" align="left"><a href="images/imagesplaques/POWA-plaque-2.jpg" rel="lightbox" title="Prince of Whales Armories Plaque 2"><img src="images/imagesplaques/POWA-plaque-2.jpg" alt="Prince of Whales Armories Plaque 2" width="90" height="110"/></a><br clear="all" />
      <b>Prince of Whales Armories Plaque 2</b></td>
    <td width="25%" valign="top" align="left"><a href="images/imagesplaques/POWA-plaque-2a.jpg" rel="lightbox" title="Prince of Whales Armories Plaque 2"> <img src="images/imagesplaques/POWA-plaque-2a.jpg" alt="Prince of Whales Armories Plaque 2" width="90" height="110"/></a> <br clear="all" />
      <b>Prince of Whales Armories Plaque 2</b></td>
    <td width="25%" valign="top" align="left"><a href="images/imagesplaques/Provincial-Court-House-plaq.jpg" rel="lightbox" title="Provincial Court House Plaque"> <img src="images/imagesplaques/Provincial-Court-House-plaq.jpg" alt="Provincial Court House Plaque" width="90" height="110" /></a> <br clear="all" />
      <b>Provincial Court House Plaque</b></td>
    <td width="25%" valign="top" align="left"><a href="images/imagesplaques/QueenElizPlanetariumPlq.jpg" rel="lightbox" title="Queen Elizabeth Planetarium"> <img src="images/imagesplaques/QueenElizPlanetariumPlq.jpg" alt="Queen Elizabeth Planetarium" width="90" height="110"/></a> <br clear="all" />
      <b>Queen Elizabeth Planetarium</b></td>
  </tr>
</table>
</div>
		<ul id="menu">
		<li><a href="plaque_search.php">Plaque Search</a></li>
		
		</ul>
<div id="footer">
Copyright © 2009 Edmonton Historical Board. 
All Rights Reserved.
</a></div>
</body>
</html>