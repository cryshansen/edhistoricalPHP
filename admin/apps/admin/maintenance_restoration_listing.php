<p>This listing has been designed to assist you to do a search for maintenance required on associated plaques. You can search by plaque status  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.

  
<?php
	$m_plaque = new controllerClass();
	$loc=""; //
	$keywd=""; //
	$url="index.php?page=maintenance_restoration_listing";
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
if(isset($_GET['plq_restore_reqd']))
{
	$plq_restore_reqd =$_GET['plq_restore_reqd'];
}else{
	$plq_restore_reqd ="";
}


	?>
<form action="" method="post">
	<table>
		<tr>
			<td>Plaque Restoration Status:<br />
				<select name="plq_restore_reqd">
				<option value="">Choose a Status...</option>
				<option value="Y">Restoration Required</option>
				<option value="N">No Restoration Required</option>
				</select></td>
				<td>Keyword:<br />
			<input name="keywd" type="text" value=""></td>
			
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
			<td><br />
			  <input class="btton" name="list_submit" type="submit" id="list_submit" value="View Listing">
	        </td>
		</tr>
		<tr>
            <td colspan="3"> <a href="index.php?page=maintenance_restorationlisting">View All listings</a></td>
		</tr>	
	</table>
</form>

<?php	
		if(isset($_POST['list_submit'])){
			$url.="&keywd=".$_POST['keywd']."&plq_restore_reqd=".$_POST['plq_restore_reqd']."&start_year=".$_POST['start_year']."&end_year=".$_POST['end_year'];
			$results=$m_plaque->getPlaques4ByCriteria($_POST,$currpg,$url);
			if ($results)
			{				
				displayListing($results);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}elseif(($keywd !="") or ($loc !="") or ($plq_restore_reqd !="")){
			$vars = array('keywd'=>$keywd,'start_year'=>$_GET['start_year'], 'end_year'=>$_GET['end_year'],'plq_restore_reqd'=>$plq_restore_reqd);	
			$url .="&keywd=".$keywd."&start_year=".$start_year."&end_year=".$end_year."&plq_restore_reqd=".$plq_restore_reqd;
			$results=$m_plaque->getPlaques4ByCriteria($vars,$currpg,$url);
			displayListing($results);


		}else{
			$result=$m_plaque->getAllPlaques($currpg,$url);
			$rowcount=mysql_num_rows($result);
			displayListing($result);
		}
		
/*-------------------------------------------------- Display All listings      ---------------------------------------------*/		
function displayListing($result){
?>
		<table>
			<tr style="text-align:left">
			
			  <th>Plaque Recipient    </th>
              <th>Location   </th>
			  <th>Restoration Status</th>
			  <th colspan="4">Actions</th></tr>
<?php
		while ($row = mysql_fetch_array($result))
		{
			//$m_plaque = new controllerClass();
		?>
			<tr>
				<td><?php echo $row['plq_recipient']; ?></td>
                <td><?php echo $row['plq_location']; ?></td>
				<td><?php echo $row['plq_restore_reqd']; ?></td>
				<td><form name="edit_app" method="post" action="index.php?page=plaque&id=<?php echo $row['pkplaque_id'];?>"> 
					<input class="btton" type="submit" value="Edit" />
				</form>
                <!--<form name="install_plaque" method="post" action="index.php?page=order&id=<?php //echo $row['pkplaque_id'];?>">
					<input class="btton" type="submit"  value="Order" />
				</form>--></td>
				<!--<td><form name="install_plaque" method="post" action="index.php?page=plaque_installation&id=<?php// echo $row['pkplaque_id'];?>">
					<input class="btton" type="submit"  value="Install" />
				</form>-->
				</td>
				<!--<td><form name="inspect_plaque" method="post" action="index.php?page=plaque_inspection&id=<?php// echo $row['pkplaque_id'];?>">
					<input class="btton" type="submit"  value="Inspection" />
				</form></td>-->
				<td><form name="inspect_plaque" method="post" action="index.php?page=plaque_restoration&id=<?php echo $row['pkplaque_id'];?>">
					<input class="btton" type="submit"  value="Restoration" />
				</form></td>
			</tr>		
<?php		
		}
		?>
		</table>
<?php
}
?>
<html xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882"><head>
<!--[if gte mso 9]><xml>
<mso:CustomDocumentProperties>
<mso:AddDocumentEventProcessedId msdt:dt="string">4fd4c6d8-5878-4985-ad64-42b8120a2402</mso:AddDocumentEventProcessedId>
</mso:CustomDocumentProperties>
</xml><![endif]-->
</head>