<p>This listing has been designed to assist you to do a search for plaques associated with the Edmonton Historical Board. You can search by plaque status  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.

  
<?php
$m_plaque = new controllerClass();
$keywd=""; 
$start_year=""; 
$end_year=""; 
$url="index.php?page=plaque_listing";
if(isset($_GET['pgid']))
{
	$currpg = $_GET['pgid'];
}else{
	$currpg ="";
}
if(isset($_GET['keywd'])){
	$keywd=$_GET['keywd'];
}else{
	$keywd="";
}
if(isset($_GET['plq_inscript_reqd']))
{
	$plq_inscript_reqd =$_GET['plq_inscript_reqd'];
}else{
	$plq_inscript_reqd =""; 
}
if (isset($_GET['start_year'])) { 
	$start_year = $_GET['start_year'];
} else {
	$start_year="";
}
if (isset($_GET['end_year'])) { 
	$end_year = $_GET['end_year'];
} else {
	$end_year="";
}
?>
	<form action="" method="post">
	<table>
		<tr>
			<td>Plaque Status <br />
			<select name="plq_inscript_reqd">
				<option value="">Choose a Status...</option>
				<option value="Y">Inscription Required</option>
				<option value="N">Inscription NOT Required</option>
			</select>
			</td>
			<td> Keyword: <br />
			<input name="keywd" type="text" value=""> </td> 
		</tr>
		<tr> 
			<td> Start Year: <br /> 
				<Select name="start_year"> 
					<option value='0'> </option>
<?php 
					$counter=getdate(); 			// current date 
					$curr_year=$counter['year']; 	// extract year 
					for($i=1975; $i<=$curr_year; $i++) { 
						echo "    <option value='".$i."'>".$i."</option>";                					
					} 
?> 
				</Select>
			</td>
			<td> End Year: <br />
				<Select name="end_year"> 
					<option value='0'> </option> 				
<?php 
					for($i=1975; $i<=$curr_year; $i++) {  
						echo "    <option value='".$i."'>".$i."</option>";                
					} 
?> 					
				</Select> 
			</td>
			<td> <br /> <input class="btton"name="list_submit" type="submit" value="View Listing"> </td>
		</tr>
		<tr>
            <td colspan="3"> <a href="">View All listings</a></td>
		</tr>	
	</table>
    </form>
<?php	
		if(isset($_POST['list_submit'])){
			$url .= "&keywd=".$_POST['keywd']."&plq_inscript_reqd=".$_POST['plq_inscript_reqd']."&start_year=".$_POST['start_year']."&end_year=".$_POST['end_year']; 
			$results=$m_plaque->getPlaquesByCriteria($_POST,$currpg,$url);
			if ($results)
			{
				displayListing($results);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}elseif(($keywd !="") or ($plq_inscript_reqd !="") or (($start_year != "") or ($end_year != ""))) { 
			$url .="&keywd=".$keywd."&plq_inscript_reqd=".$plq_inscript_reqd."&start_year=".$start_year."&end_year=".$end_year; 
			$vars = array('keywd'=>$keywd, 'plq_inscript_reqd'=>$plq_inscript_reqd, 'start_year'=>$_GET['start_year'], 'end_year'=>$_GET['end_year']); 
			$results=$m_plaque->getPlaquesByCriteria($vars,$currpg,$url);
			displayListing($result);

		}else{
			$result=$m_plaque->getAllPlaques($currpg,$url);
			displayListing($result);
		}
		

		
/*------------------------------------------ Display All listings      ---------------------------------------------*/		
function displayListing($result){
?>
		<table>
			<tr style="text-align:left">
			  <th> Plaque Recipient </th> 
			  <th> Plaque Inscription </th>              
			  <th colspan="2">Actions</th></tr>
<?php
		while ($row = mysql_fetch_array($result))
		{
		?>
			<tr>
				<td> <?php echo $row['plq_recipient']; ?> </td>
				<td> <?php echo $row['plq_inscription']; ?> </td>
				<td><form name="edit_app" method="post" action="index.php?page=plaque&id=<?php echo $row['pkplaque_id'];?>"> 
					<input class="btton" type="submit" value="Edit" />
				</form></td>
				<td><form name="new_inscrption" method="post" action="index.php?page=plaque_inscription&id=<?php echo $row['pkplaque_id'];?>"> 
					<input class="btton" type="submit" value="Create Inscription" />
				</form>
				</td>
			</tr>
		
<?php		
		}
		?>
		</table>
<?php
}
/*--------------------------------  DISPLAY APPLICATION STATUS --------------------------------------*/
		function displayPlaqueStatus()
		{		
		?>	
			<td>Plaque Status <br />
			<select name="plq_inscript_reqd">
				<option value="">Choose a Status...</option>
				<option value="Y">Inscription Required</option>
				<option value="N">Inscription NOT Required</option>
			</select>
			</td>
<?php		
		}


?>
