<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
		<tr>
            <td colspan="3"> <a href="">View All listings</a></td>
		</tr>	
	</table>
</form>


<p><strong>Historical Mapping Tours:</strong></p>
										<fieldset style='width:60%; border: none; ;padding-bottom:5px; text-align:center;'>

											 <strong>Total Records Found: 20</strong>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Page 1 of 2&nbsp;
											<strong> [ </strong>
											<strong>1</strong>
											<a href=''>2</a>
											<strong> ] </strong>

											<a href=''>Last</a>
										</fieldset>
<ul>
<li><a href="plaque_toursmap.php">BIRKS BUILDING </a><br />The Birks Building was designed by Nobbs and Hyde, an architectural firm of national significance. Percy Nobbs, who collaborated with Cecil Burgess on the Birks Building, also designed the original master plan for the University of Alberta.</li>
<li><a href="plaque_toursmap.php">BOARDWALK</a><br />The building now popularly known as the Boardwalk was built in 1910 for $100,000 by Ross Brothers Wholesalers, a hardware firm.</li>
<li><a href="plaque_toursmap.php">CANADA PERMANENT BUILDING </a><br />Roland Lines was the architect who designed this sophisticated little building. Comparison with the Union Bank building reveals the same masterful handling of classical elements.</li>
<li><a href="plaque_toursmap.php">CANADIAN BANK OF COMMERCE </a><br />Traditionally, banks were built in classical styles of architecture which implied stability, security and permanence.</li>
<li><a href="plaque_toursmap.php">CHURCHILL WIRE CENTRE </a><br />At one time, Sir Winston Churchill Square was ringed by a grand collection of civic buildings from the earlier part of this century.</li>
<li><a href="plaque_toursmap.php">CITADEL THEATRE </a><br />The Citadel Theatre officially opened on November 12, 1976. It was designed by Barton Myers of Toronto and R.L. Wilkin of Edmonton.</li>
<li><a href="plaque_toursmap.php">CIVIC BLOCK/EDMONTON POLICE STATION</a><br />Concealed by a 1950s façade, this six-storey brick building, known throughout most of its history as the Civic Block, was constructed in 1912.</li>
<li><a href="plaque_toursmap.php">EATON’S STORE </a><br />On August 29, 1939, T. Eaton Co. opened what was referred to as its million dollar store.</li>
<li><a href="plaque_toursmap.php">EATON’S WAREHOUSE</a><br />Eaton’s Warehouse was designed by the prominent Edmonton architects Magoon and MacDonald in 1929 as a western centre for Eaton’s catalogue sales.</li>
<li><a href="plaque_toursmap.php">EDMONTON ART GALLERY</a><br />The Edmonton Art Gallery has had five homes since the Museum of Art Association was founded in 1923.</li>
</ul>             
	



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
<div id="footer">
Copyright © 2009 Edmonton Historical Board. 
All Rights Reserved.
</a></div>
</body>
</html>
