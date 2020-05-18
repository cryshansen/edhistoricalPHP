<p>This listing has been designed to assist you to do a search for maintenance required on associated plaques. You can search by plaque status  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.

  
<?php
	$m_award = new controllerClass();
	$keywd = "";							// keyword search string 
	$start_date = ""; 						// start date search string 
	$end_date = ""; 						// end date search string 

$url="index.php?page=report_award_listing";
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
	if(isset($_GET['awd_inscript_reqd']))
	{
		$awd_inscript_reqd =$_GET['awd_inscript_reqd'];
	}else{
		$awd_inscript_reqd ="";
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
			<td>Award Status:<br />
        <select name="awd_inscript_reqd">
          <option value="">Choose a Status...</option>
          <option value="N">Inscription NOT Required</option>
          <option value="Y">Inscription Required</option>
        </select> </td>
			<td> Keyword: <br /> 
            	<input name="keywd" type="text" value=""> </td>
		</tr> 
		<tr>
			<td> Start Year: <br />
				<Select name="year"> 
					<option value=''> </option>
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
				<Select name="year2"> 
					<option value=''> </option> 				
<?php 
					for($i=1975; $i<=$curr_year; $i++) {  
						echo "    <option value='".$i."'>".$i."</option>";                
					} 
?> 					
				</Select> 
			</td>
			<td> <br /> 
				<input class="btton" name="list_submit" type="submit" id="list_submit" value="View Listing"> 
			</td>
		</tr>
		<tr>
            <td colspan="3"> <a href="<?php echo $url; ?>">View All listings</a></td>
		</tr>	
	</table>
</form>
<?php
		if(isset($_POST['list_submit'])){
			$url .= "&keywd=".$_POST['keywd']."&awd_inscript_reqd=".$_POST['awd_inscript_reqd']."&start_year=".$_POST['year']."&end_year=".$_POST['year2']; 
			$result=$m_award->getAwardsByYearCriteria($_POST,$currpg,$url);
			if ($result)
			{
				$rowcount=mysql_num_rows($result);
				//echo $rowcount;
				displayRecords($result);

			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}elseif (($keywd != "") or ($awd_inscript_reqd != "") or (($start_year != "") or ($end_date != ""))) { 
			$url .="&keywd=".$keywd."&awd_inscript_reqd=".$awd_inscript_reqd."&start_year=".$start_year."&end_year=".$end_year; 
			$vars = array('keywd'=>$keywd, 'awd_inscript_reqd'=>$awd_inscript_reqd, 'start_year'=>$_GET['start_year'], 'end_year'=>$_GET['end_year']); 
			$result=$m_award->getAwardsByYearCriteria($vars,$currpg,$url);
			displayRecords($result);
		}else{
			$result=$m_award->getAllAwards($currpg,$url);
			$rowcount=mysql_num_rows($result);
			displayRecords($result);
	}

	

/* ------------------------------	DISPLAY AWARD RECORDS ---------------------------------------------------------------*/
function displayRecords($vars)
{
?>
			<form style="text-align:right" name="applicant" method="post" action="" >
				<input class="btton" type="submit" value="Print" onClick="window.print()" name="print" />
<!-- 				<input class="btton" type="submit" value="CSV" name="submit_app" /> -->
			</form>

	<table>
			<tr>
            	<th>Award Recipient </th> <th> Award Inscription </th> 
            	<th colspan="3" style="text-align:left">Actions</th> </tr>
<?php	
	while($row=mysql_fetch_array($vars))
	{ ?>
			<tr><td><a href="index.php?page=award&id=<?php echo $row['pkaward_id']; ?>"><?php echo $row['awd_recipient']; ?> </a></td>
				<td> <?php echo $row['awdinscrip_content']; ?> </td> 
				<td><form name="edit_app" method="post" action="index.php?page=report_award_details&id=<?php echo $row['pkaward_id']; ?>"> 
						<input class="btton" type="submit" value="View Details" /> 
					</form> 
				</td>
				
			</tr>
<?php	
	} ?>
</table>
<?php
}
?>