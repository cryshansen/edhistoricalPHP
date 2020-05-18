 <p> This listing has been designed to assist you to do a search for plaques associated with the Edmonton Historical Board. You can search by plaque status using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button. </p> 
  
<?php
$m_plaque = new controllerClass();			// instantiate new controllerClass object 
$keywd = "";								// keyword search string 
$start_year = ""; 							// keyword search string 
$end_year = ""; 							// keyword search string 

// for paging when displaying plaque list 
// if page id is available have already displayed first page 
//     trying to display other pages  
// $url is used in paging algorithm 
$url = "index.php?page=report_plaquelisting";
if (isset($_GET['pgid'])) { 
    // set current page to page id from url 
	$currpg = $_GET['pgid']; 
} else { 
    // have not displayed anything so set current page to null 
	$currpg = ""; 
} 

// if paging related to "View Listing" button 
// set status, keyword, start date and end date from url 
// otherwise set to null 
if (isset($_GET['plq_inscript_reqd'])) {
	$plq_inscript_reqd = $_GET['plq_inscript_reqd'];
} else {
	$plq_inscript_reqd ="";
}
if (isset($_GET['keywd'])) {
	$keywd = $_GET['keywd'];
} else {
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
?>

<form action="" method="post">
	<table>
		<tr> 
			<td> Plaque Status: <br /> 
				<select name="plq_inscript_reqd"> 
					<option value=""> Choose a Status... </option> 
					<option value="Y"> Inscription Required </option> 
					<option value="N"> Inscription NOT Required </option>
				</select>
			</td>
			<td> Keyword: <br />
				<input name="keywd" type="text" value="<?php echo $keywd; ?>"> </td> 
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
			<td> <br /> <input class="btton"name="list_submit" type="submit" value="View Listing"> </td>				 
		</tr>
		<tr>
            <td colspan="3"> <a href="">View All listings</a> </td>
		</tr>	
	</table>
</form>

<?php
// determine what happened 
if (isset($_POST['list_submit'])) { 
	// "View Listing" button - search on status, location or keyword 
	// retrieve plaque records using search criteria 
	// ensure $url contains status, location and keyword 
	// start display from record 1 
	$currpg = ""; 
	$url .= "&keywd=".$_POST['keywd']."&plq_inscript_reqd=".$_POST['plq_inscript_reqd']."&start_year=".$_POST['start_year']."&end_year=".$_POST['end_year']; 
	$result = $m_plaque->getPlaquesByCriteria($_POST, $currpg, $url); 
	if ($result) { 							// if operation successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount > 0) { 				// if something retrieved 
			// display records retrieved 
			displayListing($result); 
		} else { 
			echo "<p>Your query resulted in 0 rows returned.</p>"; 
		}
	// check if paging as a result of "View Listing" button 
	} 
} else { 
	if (($keywd !="") or ($plq_inscript_reqd !="") or (($start_year != "") and ($end_year != ""))) { 
		// paging on page subsequent to first page 
		// construct $url containing keyword and location 
		// construct an array containing status, location and keyword 
		$url .="&keywd=".$keywd."&plq_inscript_reqd=".$plq_inscript_reqd."&start_year=".$start_year."&end_year=".$end_year; 
		$vars = array('keywd'=>$keywd, 'plq_inscript_reqd'=>$plq_inscript_reqd, 'start_year'=>$_GET['start_year'], 'end_year'=>$_GET['end_year']); 
		$result = $m_plaque->getPlaquesByCriteria($vars, $currpg, $url); 
		displayListing($result); 			// display result 
	} else { 								// otherwise 
		// not a search request 
		// display information relating to all plaques 
		// this is not display as a result of "View Listing" button 
		// remember - using paging 
		// want to start from beginning of plaques 
		$result = $m_plaque->getAllPlaques($currpg, $url); 
		if ($result) { 						// if operation successful 
			$rowcount = mysql_num_rows($result);  // number of records retrieved 
			if ($rowcount > 0) { 		// if something retrieved 
				// display records retrieved 
				displayListing($result); 
			} else { 
				echo "<p>Your query resulted in 0 rows returned.</p>"; 
			}
		}
	} 
}

/* ----------------------------- display plaque records ----------------------------- */ 
// display list of plaque records 
function displayListing($result)
{
?>
			<form style="text-align:right" name="applicant" method="post" action="" >
				<input class="btton" type="submit" value="Print" onClick="window.print()" name="print" />
<!-- 				<input class="btton" type="submit" value="CSV" name="submit_app" /> -->
			</form>

	<table>
		<tr style="text-align:left">
			<th> Plaque Recipient </th>
			<th> Plaque Inscription </th>
			<th colspan="2">Actions </th>
		</tr>
<?php 
		while ($row = mysql_fetch_array($result))
		{
?>
		<tr>
			<td> <?php echo $row['plq_recipient']; ?> </td> 
			<td> <?php echo $row['plq_inscription']; ?> </td> 
			<td>
				<form name="edit_app" method="post" action="index.php?page=report_plaque_details&amp;id=<?php echo $row['pkplaque_id'];?>"> 
				<input class="btton" type="submit" value="View Details" />
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

