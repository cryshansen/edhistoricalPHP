<p>This listing has been designed to assist you to do a search for maintenance required on associated plaques. You can search by plaque status  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.

  
<?php
	$m_plaque = new controllerClass();
	$keywd=""; 						// search parameter 
	$start_year=""; 				// search parameter 
	$end_date=""; 					// search parameter 
	$url="index.php?page=maintenance_installation_listing";
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
if(isset($_GET['plq_instal_reqd']))
{
	$plq_instal_reqd =$_GET['plq_instal_reqd'];
}else{
	$plq_instal_reqd ="";
}
if(isset($_GET['start_year']))
{
	$start_year=$_GET['start_year'];
}else{
	$start_year="";
}
if(isset($_GET['end_year']))
{
	$end_year=$_GET['end_year'];
}else{
	$end_year="";
}

?>
<form action="" method="post">
	<table>
		<tr>
			<td> Plaque Installation Status: <br />
				<select name="plq_instal_reqd">
				<option value="">Choose a Status...</option>
				<option value="Y">Installation Required</option>
				<option value="N">No Installation Required</option>
				</select> </td>
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
			<td> <br /><input class="btton" name="list_submit" type="submit" id="list_submit" value="View Listing"> </td>
		</tr>
		<tr>
            <td colspan="3"> <a href="index.php?page=maintenance_installation_listing">View All listings</a></td>
		</tr>	
	</table>
</form>

<?php	
		if(isset($_POST['list_submit']))
		{
			$url.="&keywd=".$_POST['keywd']."&plq_instal_reqd=".$_POST['plq_instal_reqd']."&start_year=".$_POST['start_year']."&end_year=".$_POST['end_year'];
			$results=$m_plaque->getPlaques2ByCriteria($_POST,$currpg,$url);
			if($results)
			{
				displayListing($results);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		} elseif(($keywd !="") or ($plq_instal_reqd !="") or ($plq_instal_reqd !="") or (($start_year !="") or ($end_year !=""))) {
			$vars = array('keywd'=>$keywd,'plq_instal_reqd'=>$plq_instal_reqd,'start_year'=>$start_year,'end_year'=>$end_year);	
			$url .="&keywd=".$keywd."&plq_instal_reqd=".$plq_instal_reqd."&start_year=".$start_year."&end_year=".$end_year;
			$results=$m_plaque->getPlaques2ByCriteria($vars,$currpg,$url);
			displayListing($results);
		}else{
			$result=$m_plaque->getAllPlaques($currpg,$url);
			displayListing($result);
		}
		
/*-------------------------------------------------- Display All listings      ---------------------------------------------*/		
function displayListing($result){
?>
		<table>
			<tr style="text-align:left">
			
			  <th>Plaque Recipient    </th>
              <th>Location   </th>
			  <th>Installation Status</th>
			  <th colspan="4">Actions</th></tr>
<?php
		while ($row = mysql_fetch_array($result))
		{
			//$m_plaque = new controllerClass();
		?>
			<tr>
				<td><?php echo $row['plq_recipient']; ?></td>
                <td><?php echo $row['plq_location']; ?></td>
				<td><?php echo $row['plq_instal_reqd']; ?></td>
				<td><form name="edit_app" method="post" action="index.php?page=plaque&id=<?php echo $row['pkplaque_id'];?>"> 
					<input class="btton" type="submit" value="Edit" />
				</form></td>
				<td><form name="install_plaque" method="post" action="index.php?page=plaque_installation&id=<?php echo $row['pkplaque_id'];?>">
					<input class="btton" type="submit"  value="Install" />
				</form>
				</td>
			</tr>
		
<?php		
		}
		?>
		</table>
<?php
}
?>