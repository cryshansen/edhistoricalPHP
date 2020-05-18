<?php 
$m_plaque = new controllerClass();			// instantiate new controllerClass object 

// determine what happened 
// report_plaque detail is activated by report_plaquelisting 
// pkplaque_id of plaque record to operate on is passed in url 
if (isset($_GET['id'])) {
	// plaque record selected in report_plaquelisting 
	// read plaque record using id passed in url as record key 
	$result = $m_plaque->getPlaqueByID($_GET['id']); 
	if ($result) {							// if operation successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount = 0) { 				// if nothing retrieved 
			echo "<p>Your query results in 0 rows returned.</p>"; 
		} else { 							// otherwise 
			// retrieved plaque record so display plaque data 
			$row = mysql_fetch_array($result);  // record retrieved 
?>
			<p> Plaque Receipient: &nbsp; <?php echo $row['plq_recipient']; ?> </p>            
<?php 			
            displayPlaque($row); 
		}
	}
}

/* ------------------------------ display plaque information ------------------------------ */ 
// display plaque information 
function displayPlaque($vars)
{
?>	
			<form style="text-align:right" name="applicant" method="post" action="" >
				<input class="btton" type="submit" value="Print" onClick="window.print()" name="print" />
<!-- 				<input class="btton" type="submit" value="CSV" name="submit_app" /> -->
			</form>

	<fieldset>
		<legend> Plaque </legend>
			<table>
				<tr>
					<td><strong> Size:</strong> <br />
						<?php echo $vars['plq_size']; ?> 
					</td>
					<td><strong> Material:</strong> <br />
						<?php echo $vars['plq_material']; ?> 
					</td>
					<td> <strong>Style:</strong> <br />
						<?php echo $vars['plq_style']; ?> 
					</td>
				</tr>
				<tr>
					<td><strong>Inscription Required:</strong> <br />
						<?php displayInscriptReqd($vars['plq_inscript_reqd']);?> <br /></td>
					<td><strong>Inspection Required:</strong> <br />
						<?php displayInspectReqd($vars['plq_inspect_reqd']);?> <br /></td>
					<td><strong>Installation Required:</strong> <br />
						<?php displayInstalReqd($vars['plq_instal_reqd']);?> <br /></td>
					<td><strong>Restoration Required:</strong> &nbsp;
						<?php displayRestoreReqd($vars['plq_instal_reqd']);?> <br /> </td>
					<tr>
						<td><strong>Inauguration Date:</strong> <br />
						<?php echo $vars['plq_inaug_date']; ?> </tr>
					</td>
						<td><strong>Inscription Date:</strong> <br />
						<?php echo $vars['plqinsc_date']; ?> 
						</td>
						<td>
						<strong>Status:</strong> <?php displayApplicationStatus($vars['fkapplication_id']);?></td>
						</td>
					</td></tr>
					
					<tr>
						<td colspan="2"><strong> Plaque latitute:</strong> <br />
						<?php echo $vars['plq_latitude']; ?> </td>
						<td colspan="2"><strong> Plaque Longitude:</strong> <br />
						<?php echo $vars['plq_longitude']; ?> </td>
				</tr>
				<tr>
					<td colspan="3"><strong> Plaque Description:</strong> <br />
						<?php echo $vars['plq_desc']; ?> 
					</td>
				</tr>
				<tr>
					<td colspan="3"><strong> Inscription:</strong> <br />
						<?php echo $vars['plq_inscription']; ?> 
					</td>
				<tr>
					<td colspan="3"> <strong>Inscription Comments:</strong> <br />
						<?php displayInscriptionComments($vars['pkplaque_id']); ?> 
					</td>
				</tr> 

			<!-- ------------------------- plaque image data ------------------------- --> 
			<?php displayPlaqueImage($vars['pkplaque_id']); ?> 
			</table> 


			<!-- ----------------------- plaque landmark data ----------------------- --> 
			<?php displayPlaqueLandmark($vars['pkplaque_id']); ?>             

			<!-- --------------------- plaque landmark/owner data --------------------- --> 
			<?php displayPlaqueLandmarkOwner($vars['pkplaque_id']); ?>             
</table> 
	</fieldset> 
<?php
}

/* ------------------------------ display inscription comments ------------------------------ */ 
// retrieve plaque inscription comments 
//     use plaque id as key to access tblplaqueinscription
function displayInscriptionComments($id) 
{
	$m_inscription = new controllerClass();  // instantiate new controllerClass object 
	$result = $m_inscription->GetInscriptionCommentsByPlaqueId($id); 
	if ($result) {							// if operation successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount > 0) { 				// if record retrieved 
			$row = mysql_fetch_array($result);  // retrieve record 
			echo $row['plqinsc_comments']; 	// should have plaque inscription 
		}
	}
}

/* ------------------------------ display application status ------------------------------ */ 
// retrieve application status 
// use application id in plaque record [fkapplication_id) 
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

/* ------------------------------ display inscription required ------------------------------ */ 
// display inscription required - yes/no 
// use plq_inscript_reqd to set radio button 
// plq_inscript_reqd is in plaque record 
function displayInscriptReqd($id) 
{
	if ($id == 'Y' or $id == 'y') { 
		echo "Yes"; 
	} else { 
		echo "No"; 
	}
}

/* ------------------------------ display inspection required ------------------------------ */ 
// display inspection required - yes/no 
// use plq_inpect_reqd to set radio button 
// plq_inspect_reqd is in plaque record 
function displayInspectReqd($id) 
{
	if ($id == 'Y' or $id == 'y') { 
		echo "Yes"; 
	} else { 
		echo "No"; 
	}
}

/* ------------------------------ display installation required ------------------------------ */ 
// display inspection required - yes/no 
// use plq_instal_reqd to set radio button 
// plq_instal_reqd is in plaque record 
function displayInstalReqd($id) 
{
	if ($id == 'Y' or $id == 'y') { 
		echo "Yes"; 
	} else { 
		echo "No"; 
	}
}

/* ------------------------------ display restoration required ------------------------------ */ 
// display restoration required - yes/no 
// use plq_restore_reqd to set radio button 
// plq_restore_reqd is in plaque record 
function displayRestoreReqd($id) 
{
	if ($id == 'Y' or $id == 'y') { 
		echo "Yes"; 
	} else { 
		echo "No"; 
	}
}

/* ------------------------------ display plaque image data ------------------------------ */ 
// populate table containing plaque image data 
// attempt to read imageplaque record using plaque is as key 
// if imageplaque record exists read image record using fkimage_id as key 
//     and populate form using data in corresponding image record 
// if imageplaque record does not exists create blank form 

function displayPlaqueImage($id) 
{

	$m_images = new controllerClass();
	$results=$m_images->getImagesByPlaqueId($id);
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
			
<?php 	} ?>
	</tr>
<?php
	}
}
						
/* -------------------------- display plaque landmark data -------------------------- */ 
// populate table containing plaque landmark data 
// attempt to read landmarkplaque record using plaque id as key 
// if landmarkplaque record exists read landmark record using fklandmark_id as key 
//     and populate form using data in corresponding landmark record 
// if landmarkplaque record does not exists create blank form 

function displayPlaqueLandmark($id) 
{
	$m_landmarkplaque = new controllerClass();  // instantiate new controllerClass object 
	$m_landmark = new controllerClass();	// instantiate new controllerClass object 
	// read landmarkplaque record using plaque id as key 
	$result = $m_landmarkplaque->getLandmarkfromPlaque($id); 
	if ($result) {							// if operation successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount > 0) { 				// if record retrieved 
			$row = mysql_fetch_array($result);  // record retrieved 
			// read landmark table record using landmark id 
			//     from landmark plaque record 
			$result2 = $m_landmark->getLandmarkByID($row['fklandmark_id']); 
			if ($result2) { 				// if operation successful 
				$rowcount = mysql_num_rows($result2);  // number of records retrieved 
				if ($rowcount > 0) { 		// if record retrieved 
					$row2 = mysql_fetch_array($result2);  // record retrieved 
?> 	
					<!--  landmark data  --> 
					<table>
						<tr>
							<th colspan="3" align="left"> Landmark: </th>
						</tr>
						<tr>
							<td colspan="3"> <?php echo $row2['land_name']; ?> 
						</td>
						</tr>
						<tr>
							<td> <?php echo $row2['street_address'] ?>  </td>
						</tr>
						<tr> 
							<td> Neighbourhood: <?php displayLandmarkNeighbourhood($row2['pklandmark_id']); ?> </td>									
						</tr>
					</table>
<?php 
				} 
			}
		} else { 								// no landmark record for plaque 
?>
			<!--  landmark information  --> 
			<!-- create form but no information to display --> 
			<table>
				<tr> <th colspan="3" align="left"> Landmark: </th> </tr>
			</table>
<?php 
		}
	}
}

/* --------------------------- display landmark neighbourhood --------------------------- */ 
// display neighbourhood of landmark that plaque is associated with 
// read neighbourhood file thru landmark file using 
//     landmark id in landmark record as key 
function displayLandmarkNeighbourhood($id) 
{
	$m_neighbourhood = new controllerClass();	// instantiate new controllerClass object 
	// read neighbourhood record using neighbourhood id as key 
	$result = $m_neighbourhood->getLandmarkNeighbourhood($id); 
	if ($result) {							// if operation successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount > 0) { 				// if record retrieved 
			$row = mysql_fetch_array($result);  // record retrieved 
			echo $row['name']; 				// should have neighbourhood name 
		}
	}else{ echo "failure";}
}

/* ------------------------------ display landmark/owner data ------------------------------ */ 
// display landmark owner information that plaque is associated with 
function displayPlaqueLandmarkOwner($id) 
{
	$m_landmarkplaque = new controllerClass();  // instantiate new controllerClass object 
	$m_landmark = new controllerClass();		// instantiate new controllerClass object 
	// read tbllandmarkplaque using plaque id as key 
	$result = $m_landmarkplaque->getLandmarkfromPlaque($id); 
	if ($result) {							// if operation successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount > 0) { 				// if record retrieved 
			$row = mysql_fetch_array($result);  // record retrieved 
			// read owner record using landmark id that is 
			//     associated with plaque record as key 
			$result2 = $m_landmark->getLandmarkOwnerById($row['fklandmark_id']); 
			if ($result2) { 				// if operation successful 
				$rowcount = mysql_num_rows($result2);  // number of records retrieved 
				if ($rowcount > 0) { 		// if record retrieved 
					$row2 = mysql_fetch_array($result2);  // record retrieved 
?>
					<!--  owner information  --> 
                    <table> 
                    	<tr> <th colspan="3" align="left"> Owner: </th> </tr> 
                        <tr> 
							<td> Owner Name: <?php echo $row2['owner_name']; ?> </td> 
							<td> Contact Phone: <?php echo displayPhone($row2['owner_phone_bus']); ?> </td> 
						</tr> 
					</table> 
<?php 
				} else { 					// no owner record for landmark 
?> 				
					<!--  owner information   --> 
					<!-- create form but no information to display --> 
					<table> 
						<tr> <th colspan="3" align="left"> Owner: </th> </tr> 
					</table> 
<?php 
				}
			}
		} else { 							// no landmark record 
?> 
			<!--  owner information   --> 
			<!-- create form but no information to display --> 
			<table> 
				<tr> <th colspan="3" align="left"> Owner: </th> </tr> 
			</table> 
<?php 
		} 
	}
}
?> 

