 
<p>This listing has been designed to assist you to do a search for Applications associated with the Edmonton Historical Board System. You can search by plaque or award, application status using the drop down menu, location, or dates or use a combination of the search parameters and then click on "View Listing" button.</p>

<?php
	$url="index.php?page=report_application_status"; 
	$awdplq = ""; 							// search parameter 
	$fkapplication_status_id = "";			// search parameter 									
	$keywd = ""; 							// search parameter 
	$start_year = ""; 						// search parameter 
	$end_year = ""; 						// end date 
	if(isset($_GET['pgid'])) { 
		$currpg = $_GET['pgid'];
	} else { 
		$currpg ="";
	}

	if(isset($_GET['awdplq'])) {
		$awdplq=$_GET['awdplq'];
	} else {
		$awdplq="";
	}
	if(isset($_GET['keywd'])) {
		$keywd=$_GET['keywd'];
	} else {
		$keywd="";
	}
	if(isset($_GET['fkapplication_status_id'])) {
		$fkapplication_status_id=$_GET['fkapplication_status_id'];
	} else {
		$fkapplication_status_id="";
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
			<td> 
				Plaque <input type="radio" name="awdplq" value="Plaque" /> <br />
				Award <input type="radio" name="awdplq" value="Award" /> 
			</td> 
			<?php displayApplicationStatus(); ?>
			<td></td>
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
		
			<td> Keyword: <br />
				<input name="keywd" type="text" value=""> </td> 

			<td> <br /> 
				<input class="btton" name="list_submit" type="submit" id="list_submit" value="View Listing"> 
			</td>

		</tr> 
		<tr> 
			<td> <a href="<?php echo $url;?>"> View All listings </a> </td>
		</tr>	
	</table>
    </form>
	
<?php

	$m_applicant = new controllerClass();
	if(isset($_POST['list_submit'])){
		if(!isset($_POST['awdplq']))
		{$_POST['awdplq']="";}
		$url.="&awdplq=".$_POST['awdplq']."&keywd=".$_POST['keywd']."&start_year=".$_POST['start_year']."&end_year=".$_POST['end_year']."&fkapplication_status_id=".$_POST['fkapplication_status_id'];
		$result=$m_applicant->getApplicationsByCriteria2($_POST,$currpg,$url);
		if ($result)
		{
			$rowcount=mysql_num_rows($result);
			//echo $rowcount;
			displayListing($result);
		}else{
			echo "<p>Your query resulted in 0 rows returned.</p>";
		}
?>
<?php 
	}elseif (($awdplq !="") or ($keywd !="") or ($fkapplication_status_id !="") or(($start_year !="") and ($end_year !=""))) {
		$url.="&awdplq=".$awdplq."&keywd=".$keywd."&start_year=".$start_year."&end_year=".$end_year."&fkapplication_status_id=".$fkapplication_status_id;
		$vars = array('awdplq'=>$awdplq,'keywd'=>$keywd,'start_year'=>$_GET['start_year'],'end_year'=>$_GET['end_year'], 'fkapplication_status_id'=>$fkapplication_status_id);
		$result=$m_applicant->getApplicationsByCriteria2($vars,$currpg,$url);
?>
		<p> Listing of Applications that match the criteria for Plaque, all Status'. </p>
<?php
		displayListing($result);

	} else { 
		// display list of applications 
		// as a result of menu selection 
		$result=$m_applicant->getAllApplications($currpg, $url);
		$rowcount=mysql_num_rows($result);
		//echo $rowcount;
		displayListing($result);
	}
		
/*-------------------------------------------------- Display All listings      ---------------------------------------------*/		
function displayListing($result){
?>
			<form style="text-align:right" name="applicant" method="post" action="" >
				<input class="btton" type="submit" value="Print" onClick="window.print()" name="print" />
<!-- 				<input class="btton" type="submit" value="CSV" name="submit_app" /> -->
			</form>

	<table>
		<tr style="text-align:left;"> 
           	<th>Site / Award Name </th> <th> Nominee Name </th>
			<th>Status </th> <th> Actions </th>
		</tr>
<?php
		while ($row = mysql_fetch_array($result))
		{
		?>
			<tr><td><a href="index.php?page=application&id=<?php echo $row['pkapplication_id'];?>">
<?php echo $row['site_name'];  ?></a></td><td><?php echo $row['app_fname']; ?> &nbsp;&nbsp; <?php echo $row['app_lname']; ?></td>
				<td> <?php getApplicationStatus($row['fkapplication_status_id']); ?> </td>
				<td><form name="edit_app" method="post" action="index.php?page=report_application_details&id=<?php echo $row['pkapplication_id'];?>"> 
					<input class="btton" type="submit" value="View Details" />
				</form></td>
			</tr>
<?php		
		}
		?>
	</table>
<?php
}

/* ------------------------------ application status for application ------------------------------ */ 
	function displayApplicationStatus()
	{		
	?>	
		<td>Application Status <br />
		<select name="fkapplication_status_id">
			<option value="">Choose a Status...</option>
<?php			
		$m_application_status = new applicationClass();
		$result=$m_application_status->getApplicationStatus();
		while($row = mysql_fetch_array($result)){
	?>
			
			<option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?></option>
<?php			
		}
		?>
		</select>
		</td>
<?php		
	}

/* ------------------------------ application status drop down list ------------------------------ */ 
// retrieve application status for application 
	function getApplicationStatus($id)
	{		
		$m_application_status = new applicationClass();
		$result=$m_application_status->getApplicationStatusbyId($id); 
		while($row = mysql_fetch_array($result)) {
			echo $row['name']; 
		} 
	}

/* ----------------------------------- historical event ----------------------------------- */ 
function displayHistoricalEvent()
{
?>	
		<td>Application Status <br />
		<select name="fkapplication_status_ID">
			<option value="">Choose a Status...</option>
<?php
		$m_application_status = new applicationClass();
		$result=$m_application_status->getHistoricalEvent();
			while($row = mysql_fetch_array($result)){
	?>
			
			<option value="<?php echo $row['pkhistorical_id']; ?>"><?php echo $row['histor_name']; ?></option>
<?php			
		}
?>
		</select>
		</td>
<?php
}
?>
