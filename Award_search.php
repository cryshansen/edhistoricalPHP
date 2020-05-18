<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="Edmonton Historical Board, Edmonton Awards, Award Recipients,architects, builders, developers, members of Edmonton Historic Board, members of ehb, ehb members, contributors to edmonton's historic significance, contributors to Edmonton's history, Award biographies, architect biographies, biographies of Edmonton Organizations, Biographies of architects, " />
<meta name="description" content="Search award recipients on Edmonton Alberta’s historic recognition program. Awards on important people within the Edmonton area, that have contributed significantly to the History of Edmonton." />

<title>Edmonton Historical Board : Award Search</title>
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
		<li ><a href="Plaques.html">Plaques</a></li>
		<li class="current"><a href="awards.html">Awards</a></li>
		<li><a href="Landmarks.html">Landmark</a></li>
		<li><a href="about_us.html">About Us</a></li>
		<li><a href="contact_us.html">Contact Us</a></li>		
		</ul></div>
</div>
<div id="contents">

<h1>Awards  Recognition Program</h1>

<strong>Awards</strong>

<p>Nominations will be accepted for a historically-relevant building or site. The awarded plaques will be installed at each location so that the public can gain a greater appreciation of Edmonton's heritage.</p>
<?php
require_once("admin/projectClasses/controller.php");
$m_awards = new controllerClass();
$url="Award_search.php?page=award";
$year=""; //date range 
$year2=""; //date range
$keywd=""; //description  title, content
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
if(isset($_GET['year']))
{
	$year=$_GET['year'];
}else{$year="";}
if(isset($_GET['year2']))
{
	$year2 =$_GET['year2'];
}else{$year2="";}
	?>
	<form action="" method="post">
	<table>
		<tr>
					
			<td>Keyword:<br />
			<input name="keywd" type="text" value=""></td>
            <td>Start Year:<br/>
            <SELECT name='year'>
            <?php
             $counter=getdate();
			 $cyear=$counter['year'];
            for ($i=1975;$i<=$cyear;$i++)
            {
//                if($year ==$i){
//                echo"        <option value='".$i."' selected='selected'>".$i."</option>";
//                }else{
                echo"        <option value='".$i."'>".$i."</option>";                
               // }
            }
            ?>
            </SELECT>
            
            <td>End Year:<br/>
            <SELECT name='year2'>
            <?php
             $counter=2020;
            for ($i=1975;$i<=$cyear;$i++)
            {
               // if($year ==$i){
//                echo"        <option value='".$i."' selected='selected'>".$i."</option>";
//                }else{
                echo"        <option value='".$i."'>".$i."</option>";                
               // }
            }
            ?>
			</select>
</td>

			<td><br /><input class="btton"name="list_submit" type="submit" value="View Listing"></td>
		</tr>
		<tr>
            <td colspan="3"> <a href="<?php echo $url; ?>">View All listings</a></td>
		</tr>	
	</table>
    </form>
<?php	
		if(isset($_POST['list_submit'])){
			$url.="&keywd=".$_POST['keywd']."&year=".$_POST['year']."&year2=".$_POST['year2'];
			$results=$m_awards->getAwardsByYearCriteria($_POST,$currpg,$url);
			if ($results)
			{
				displayListing($results);
			}else{
				//echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}elseif(($keywd !="") or ($year !="") or ($year2 != "")) { 
			$url .="&keywd=".$keywd."&year=".$year."&year2=".$year2; 
			$vars = array('keywd'=>$keywd, 'year'=>$year,'year2'=>$year2); 
			print_r($vars);
			$results=$m_awards->getAwardsByYearCriteria($vars,$currpg,$url);
			displayListing($results);

		}else{
			$result=$m_awards->getAllAwards($currpg,$url);
			displayListing($result);
		}
		
function displayListing($result){
?>
<p><strong>Awards:</strong></p>
<ul>
<?php 
while($row=mysql_fetch_array($result)){
	?>
<li><a href="Award_searchdisplay.php?id=<?php echo $row['pkaward_id'];?>"><?php echo $row['awd_recipient']; ?></a><br /><?php echo $row['awd_desc'];?></li>
<?php 
}
?>
</ul>

<?php
}
?>

</div>
		<ul id="menu">
		<li><a href="Award_search.php">Award Search</a></li>
		
		</ul>
<div id="footer">
Copyright © 2009 Edmonton Historical Board. 
All Rights Reserved.
</a></div>
</body>
</html>
</html>

