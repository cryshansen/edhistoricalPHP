<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="Edmonton Historical Board, Edmonton Awards, Award Recipients,architects, builders, developers, members of Edmonton Historic Board, members of ehb, ehb members, contributors to edmonton's historic significance, contributors to Edmonton's history, Award biographies, architect biographies, biographies of Edmonton Organizations, Biographies of architects, " />
<meta name="description" content="A Biography and Details of an Edmonton Historical Board award recipient recognized for their contributions towards our city's history. " />

<title>Edmonton Historical Board : Award Display</title>
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
		<li class="current"><a href="awards.html">Awards</a></li>
		<li ><a href="Landmarks.html">Landmark</a></li>
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
	$result=$m_plaque->getAwardById($_GET['id']);
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
<h1>Award Details</h1>
<br/>
			<h2>Recipient Name: <?php echo $row['awd_recipient'];?></h2>
			<?php $year=substr($row['awd_inaug_date'],0,4); ?>
  			<p><strong>Year: </strong> <?php echo $year;?></p>
			
			<p><strong>Recipient Description: </strong><?php echo $row['awd_desc'];?></p>
			<p><strong>Award Inscription: </strong><?php echo $row['awdinscrip_content'];?></p>
<br />		
<h1>Award Images:</strong></h1>
		<?php
				$m_images = new controllerClass();
				$results=$m_images->getImagesByAwardId($row['pkaward_id']);
				$rowcount=mysql_num_rows($results);
				//if($results){
					
				if($rowcount >0){
					$i=0;?>
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
			}else{
				echo "No Images at Present.";}
			}
?>


</div>
		<ul id="menu">
		<li><a href="Award_search.php">Search Awards </a></li>
	
</ul>
<div id="footer">
Copyright © 2009 Edmonton Historical Board. 
All Rights Reserved.
</a></div>
</body>
</html>
