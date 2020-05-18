<p>This listing has been designed to assist you to do a search for applications associated with the Edmonton Historical Board. You can search by application status  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.</p>

<?php
	$m_applicant = new controllerClass();
	$keywd=""; //description app_description 	app_biography 	supporting_material
	$start_date_text="";
	$end_date_text="";
	$url="index.php?page=application_listing";
	if(isset($_GET['pgid']))
	{
	$currpg = $_GET['pgid'];
	}
	else
	{
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
if(isset($_GET['fkapplication_status_id']))
{
	$fkapplication_status_id=$_GET['fkapplication_status_id'];
	
}else{
	$fkapplication_status_id="";
}
	?>
	<form action="" method="post">
	<table>
		<tr><?php displayApplicationStatus(); ?>			
            <td>Keyword:<br />
			<input name="keywd" type="text" value=""></td></tr>
            <tr><td> Start Year: <br /> 
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
			</td></tr>

			
			<td><br /><input class="btton" name="list_submit" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
		<tr>
            <td colspan="3"> <a href="index.php?page=application_listing">View All listings</a></td>
		</tr>	
	</table>
    </form>
<?php	
		
		if(isset($_POST['list_submit'])){
			$url.="&keywd=".$_POST['keywd']."&start_year=".$_POST['start_year']."&end_year=".$_POST['end_year']."&fkapplication_status_id=".$_POST['fkapplication_status_id'];
			$result=$m_applicant->getApplicationsByCriteria($_POST,$currpg,$url);
			if ($result)
			{
				$rowcount=mysql_num_rows($result);
				//echo $rowcount;
				displayListing($result);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}elseif(($keywd !="") or ($fkapplication_status_id !="") or(($start_year !="") and ($end_year !="")) ){
			$url.="&keywd=".$_GET['keywd']."&start_date=".$_GET['start_year']."&end_date=".$_GET['end_year']."&fkapplication_status_id=".$fkapplication_status_id;
			$vars = array('keywd'=>$keywd,'start_date'=>$_GET['start_year'],'end_date'=>$_GET['end_year'],'fkapplication_status_id'=>$fkapplication_status_id);
			$result=$m_applicant->getApplicationsByCriteria($vars,$currpg,$url);
			displayListing($result);

		}else{
			$result=$m_applicant->getAllApplications($currpg,$url);
			$rowcount=mysql_num_rows($result);
			//echo $rowcount;
			displayListing($result);
		
		}
		
		
		
		
		
/*--------------------------------------------	 Display All listings      ---------------------------------------------*/		
function displayListing($result){
	$m_applicant = new controllerClass();
	$pkplaque_id=0;
	$pkaward_id=0;

?>
		<table>
		<tr style="text-align:left;"><th>Site Name    </th><th>Contact Name    </th><th>Status   </th><th colspan="2" >Actions</th></tr>
		</tr>
<?php
		while ($row = mysql_fetch_array($result))
		{
			$result2=$m_applicant->getPlaqueByAppId($row['pkapplication_id']);
			if(mysql_num_rows($result2) >0){
				$row2=mysql_fetch_array($result2);
				$pkplaque_id = $row2['pkplaque_id'];
				
			}
			$awardres=$m_applicant->getAwardByAppId($row['pkapplication_id']);
			if(mysql_num_rows($result2) >0){
				$row3=mysql_fetch_array($awardres);
				$pkaward_id = $row3['pkaward_id'];
			}

		?>
			<tr><td><?php echo $row['site_name'];  ?></td>
				<td><?php echo $row['app_fname']; ?> 	&nbsp;&nbsp;<?php echo $row['app_lname']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><form name="edit_app" method="post" action="index.php?page=application&id=<?php echo $row['pkapplication_id'];?>"> 
					<input class="btton" type="submit" value="Edit" />
				</form></td>
				<td><?php 
				if($row['application_type'] =='Award'){
						if($pkaward_id !=0){
				?>
				<form name="create_award" method="post" action="index.php?page=award&id=<?php echo $row['pkaward_id'];?>">
					<input class="btton" type="submit"  value="Update Award" />
				</form></td>
						
<?php
						}else{
				?>
				<form name="create_award" method="post" action="index.php?page=award&aid=<?php echo $row['pkapplication_id'];?>">
					<input class="btton" type="submit"  value="Create Award" />
				</form></td>
<?php
						}
				}else{
					if($pkplaque_id !=0){
					?>
					<form name="create_plaque" method="post" action="index.php?page=plaque&id=<?php echo $row['pkplaque_id'];?>">
						<input class="btton" type="submit"  value="Update Plaque" />
					</form></td>
<?php					
					
					}else{
					?>
					<form name="create_plaque" method="post" action="index.php?page=plaque&aid=<?php echo $row['pkapplication_id'];?>">
						<input class="btton" type="submit"  value="Create Plaque" />
					</form></td>
					<?php
					}
				 } ?>
			</tr>
<?php		
		
		}
		?>
		</table>
<?php
}
/*--------------------------------  DISPLAY APPLICATION STATUS --------------------------------------*/
		function displayApplicationStatus()
		{		
		?>	
			<td>Application Status <br />
			<select name="fkapplication_status_id">
				<option value="">Choose a Status...</option>

<?php			
			$m_application_status = new controllerClass();
			$result=$m_application_status->getApplicationStatus();
			while($row = mysql_fetch_array($result)){
		?>
			
				<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php			
			}
			?>
			</select>
			</td>
<?php		
		}


?><html xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882"><head>
<!--[if gte mso 9]><xml>
<mso:CustomDocumentProperties>
<mso:AddDocumentEventProcessedId msdt:dt="string">027dd75c-a1cc-4637-8fc4-57ef3af77ee5</mso:AddDocumentEventProcessedId>
</mso:CustomDocumentProperties>
</xml><![endif]-->
</head>
