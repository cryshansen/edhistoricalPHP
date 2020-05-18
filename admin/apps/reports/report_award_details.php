<?php 
$m_award = new controllerClass();			// instantiate new controllerClass object 

// determine what happened 
// report_award detail is activated by report_awardlisting 
// pkaward_id of award record to operate on is passed in url 
if (isset($_GET['id'])) {
	// award record selected in report_awardlisting 
	// read award record using id passed in url as record key 
	$result = $m_award->getawardByID($_GET['id']); 
	if ($result) {							// if operation successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount = 0) { 				// if nothing retrieved 
			echo "<p>Your query results in 0 rows returned.</p>"; 
		} else { 							// otherwise 
			// retrieved award record so display award data 
			$row = mysql_fetch_array($result);  // record retrieved 
?>
			<p> Award Receipient: &nbsp; <?php echo $row['awd_recipient']; ?> </p>            
<?php 			
            displayAward($row); 
		}
	}
}

/* ------------------------------ display award information ------------------------------ */ 
// display award information 
function displayAward($vars)
{
?>	
				<form style="text-align:right" name="applicant" method="post" action="" >
				<input class="btton" type="submit" value="Print" onClick="window.print()" name="print" />
<!-- 				<input class="btton" type="submit" value="CSV" name="submit_app" /> -->
			</form>
	<fieldset>
		<legend> Award </legend>
			<table>
				<tr>
					<td width="60"> <strong>Size:</strong> <br />
						<?php echo $vars['awd_size']; ?> 
					</td>
					<td width="112"><strong>Material:</strong> <br />
						<?php echo $vars['awd_material']; ?> 
					</td>
					<td width="184"><strong>Style:</strong> <br />
						<?php echo $vars['awd_style']; ?> 
					</td>
				</tr>
				<tr>
					<td colspan="2"><strong>Inscription Date:</strong> <br />
					<?php echo $vars['awdinsc_date']; ?> 
					</td>
					<td><strong>Inauguration Date:</strong> <br />
						<?php echo $vars['awd_inaug_date']; ?> 
					</td>
				</tr>
				<tr>
					<td colspan="2"><strong>Inscription Required:</strong>
						<?php displayInscriptReqd($vars['awd_inscript_reqd']);?> <br />
						</td>
					<td>		
						<strong>Order Required:</strong> &nbsp;
						<?php displayOrderReqd($vars['awd_order_reqd']);?> <br />
					</td>
				</tr>			
				<tr>
					<td> <strong>Status:</strong> <?php displayApplicationStatus($vars['fkapplication_id']); ?> <br />
					</td>
				</tr>
				<tr>
					<td colspan="3"><strong>Award Description:</strong> <br />
						<?php echo $vars['awd_desc']; ?> </td>
				</tr>	
				<tr>
					<td colspan="3"><strong>Biography:</strong> <br />
						<?php displayRecipientBiography($vars['fkapplication_id']); ?> </td>
					<td>
				</tr>					
				<tr>
					<td colspan="3"><strong>Inscription:</strong> <br />
						<?php echo $vars['awdinscrip_content']; ?> </td>
						<br />
					</td>
				</tr>
				<tr>
					<td colspan="3"><strong>Inscription Comments:</strong><br />
							<br />
					</td>				
				</tr>
			<!-- ------------------------- award image data ------------------------- --> 
			<?php displayAwardImage($vars['pkaward_id']); ?> 
			</table>
            
	</fieldset> 
<?php 
} 

/* ------------------------------ display application status ------------------------------ */ 
// retrieve application status 
// use application id in award record [fkapplication_id) 
//     as key to access application record 
function displayApplicationStatus($id) 
{
	$m_application = new controllerClass();  // instantiate new controllerClass object 
	$m_applicationstatus = new controllerClass();  // instantiate new controllerClass object
	// read application record using application id as key 
	$result = $m_application->getApplicationById($id); 
	if ($result) {							// if operation successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount > 0) { 				// if record retrieved 
			// read application status record using application 
			// status id in application record as key 
			// extract application status from application status record 
			$table_name = 'tblapplication_status';  // table to retrieve from 
			$row = mysql_fetch_array($result);  // retrieve record 
			$table_id = $row['fkapplication_status_id'];  // table id 
			$result2 = $m_applicationstatus->getTableById($table_name, $table_id); 
			if ($result2) {					// if operation successful 
				$rowcount = mysql_num_rows($result);  // number of records retrieved 
				if ($rowcount > 0) {		// if record retrieved 
				$row2 = mysql_fetch_array($result2);  // retrieve record 
				echo $row2['name']; 		// should have application status 
				}
			}
		}
	}
}

/* ------------------------------ display biography ------------------------------ */ 
// display award recipient biography 
// use application id in award record (fkapplicant_id) 
//     as key to access application record 
function displayRecipientBiography($id) 
{
	$m_application = new controllerClass();  // instantiate new controllerClass object 
	// read application record using application id as key 
	$result = $m_application->getApplicationById($id); 
	if ($result) {							// if operation successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount > 0) { 				// if record retrieved 
			$row = mysql_fetch_array($result);  // retrieve record 
			echo $row['app_biography']; 	// should have application status 
		}
	}
}

/* ------------------------------ display inscription required ------------------------------ */ 
// display inscription required - yes/no 
// use awd_inscript_reqd to set radio button 
// awd_inscript_reqd is in award record 
function displayInscriptReqd($id) 
{
	if ($id == 'Y' or $id == 'y') { 
		echo "Yes"; 
	} else { 
		echo "No"; 
	}
}

/* ------------------------------- display order required ------------------------------- */ 
// display order required - yes/no 
// use awd_inpect_reqd to set radio button 
// awd_order_reqd is in award record 
function displayOrderReqd($id) 
{
	if ($id == 'Y' or $id == 'y') { 
		echo "Yes"; 
	} else { 
		echo "No"; 
	}
}

/* ------------------------------ display award image data ------------------------------ */ 
// populate table containing award image data 
// attempt to read imageaward record using award is as key 
// if imageaward record exists read image record using fkimage_id as key 
//     and populate form using data in corresponding image record 
// if imageaward record does not exists create blank form 

function displayAwardImage($id) 
{

	$m_images = new controllerClass();
	$results=$m_images->getImagesByAwardId($id);
	if($results){?>
			<tr>
<?php	$i=0;
		while($row = mysql_fetch_array($results))
		{
			if($i%3==0 && $i!=0)
			{
				echo "				</tr>\n";
				echo "				<tr valign=\"top\">\n";
			}

		?>			
			<td><a href="<?php echo $row['image_directory'].$row['image_name']?>" rel="lightbox" title="<?php echo stripslashes($row['image_title']); ?>">
			<img src="<?php echo trim($row['image_directory'])."/small/".trim($row['image_name']); ?>" alt="<?php echo stripslashes($row['image_title']); ?>"></a></td>
			
<?php 	$i++;
		} ?>
	</tr>
<?php
	}
}
?>
