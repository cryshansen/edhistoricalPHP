
<?php
$m_plqrestore = new controllerClass();		// instantiate new controllerClass class 
$restoration_validation = array('plqrestore_date', 5, 'Restoration Date', 'plqrestore_comments', 5, 'Comments', 'fkvendor_id', 2, 'Vendor'); 
 
// want attributes for plaquerestorationsClass 
$plqrestore_vars = $m_plqrestore->getPlaqueRestoration();  // atributes 

// if submit button add or update plaque restoration record 
if (isset($_POST['submit_app'])) {			// if submit button 
	$post_vars = $_POST;					// field values entered on form 
	if ($post_vars['pkplaquerestoration_id'] == 'new') {  // if a new plq restoration 
		// create plaque restoration record 
		// create plaque restoration record 
		echo "adding ..."; 
		// validate data 
		if(validateData($restoration_validation, $post_vars)) { 
			// data is valid, create restoration record 
			$result=$m_plqrestore->createPlaqueRestoration($post_vars);
			if($result) { 
?> 
				<p> Your Restoration has been added.  If you would like to see a listing click <a href="index.php?page=plaque_listing">here</a>.</p> 
<?php 
			} 
		} else { 
			// validation error 
?>
			<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php
			displayPlaqueRestoration($post_vars); 
		} 
	} else {
		echo "updating ...";
		// validate data 
		if(validateData($restoration_validation, $post_vars)) { 
			// data is valid, update restoration record 
			$result=$m_plqrestore->updatePlaqueRestoration($post_vars);
			if($result) { 
?> 
				<p> Your Restoration has been updated.  If you would like to see a listing click <a href="index.php?page=plaque_listing">here</a>.</p> 
<?php 
			} 
		} else { 
			// validation error 
?>
			<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php
			displayPlaqueRestoration($post_vars); 
		} 
	}
} else { 									// otherwise 
	if (isset($_GET['id'])) {				// if plaque id is set in url 
		// read plaque record using id passed in url 
		// extract plaque record data 
		$plqresult = $m_plqrestore->getPlaqueByID($_GET['id']); 
		$plqrow = mysql_fetch_array($plqresult); 
		// determine if there is existing plaque restoration record 
		// attempt to retrieve plaque restoration record 
		//     using plaque id and current year 
		$today = getdate();					// current date 
		$result = $m_plqrestore->getPlaqueRestorationByPlqIdYear($_GET['id'], $today['year']);  
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount > 0) {				// if plq restoration record exists 
			// retrieve plaque restoration data 
			// append plaque restoration data to plaque data 
			// want all data accessible when populating form 
			while ($row = mysql_fetch_array($result)) {  
				$row = array_merge($row, $plqrow);  
				displayPlaqueRestoration($row);  // populate form 
			}
		} else {							// otherwise 
			// no plaque restoration record 
			// want to display blank form - plaque restoration data 
			// form includes plaque restoration required field from plaque record 		
			// include plaque restoration attributes with plaque attributes 
			$row = array_merge($plqrestore_vars, $plqrow); 
			displayPlaqueRestoration($row);  	
		}
	}
}

/*--------------------------------  plaque restoration form  --------------------------------*/ 
// display plaque restoration form (tblplaquerestoration) 
// include plaque restoration required from plaque record (tblplaque) 
// if no plaque restoration record - display form with no data 
// if    plaque restoration record - display form populated with data from record 
// plaque restoration required from plaque record is always displayed 
function displayPlaqueRestoration($vars)
{
?>
<p> Plaque Recipient: &nbsp; <?php echo $vars['plq_recipient']; ?> </p>

	<form name="plaquerestoration" method="post" action="" > 
		<fieldset>
			<legend> Plaque Restoration </legend>
				<table>
					<tr>
						<td> Restoration Date: <br />
							<div> <input onclick='ds_sh(this);' name='plqrestore_date' 
                            	readonly='readonly' style='cursor: text' 
                                value="<?php echo $vars['plqrestore_date']; ?>" /> <div> 
						</td>
						<td> Done By: <br /> <?php displayVendor($vars['fkvendor_id']); ?> </td> 
						<td> Restoration Required: <br /> 
                        	 <input type="radio" name="plq_restore_reqd" value="Y" 
                            	<?php if($vars['plq_restore_reqd']=='Y') echo 'checked'; ?> /> Yes 
							 <input type="radio" name="plq_restore_reqd" value="N"
                            	<?php if($vars['plq_restore_reqd']=='N') echo 'checked'; ?> /> No 
						</td> 
 					</tr>
					<tr>
						<td colspan="2"> Restoration Comments: <br />
							<textarea name="plqrestore_comments" cols="40" rows="6"><?php echo $vars['plqrestore_comments']; ?></textarea> </td>
					</tr> 
				</table> 
		</fieldset>
			<input type="hidden" name="pkplaquerestoration_id" value="<?php if($vars['pkplaquerestoration_id']=='') { echo "new"; } else { echo $vars['pkplaquerestoration_id']; }?>" /> 
			<input type="hidden" name="pkplaque_id" value="<?php echo $vars['pkplaque_id']; ?>" /> 
			<input class="btton" type="submit" value="Submit" name="submit_app" />                 
	</form> 
<?php
}

/*-----------------------------------  display vendors -----------------------------------*/ 
// display drop down list containing vendors (file tblvendor) 
// populate drop down list entries with vendor id and vendor name 
function displayVendor($fkvendor_id)
{		
	$m_vendor = new controllerClass();		// instantiate new controller class 
	$result = $m_vendor->getAllvendors();	// retrieve all vendors 
?>	
	<select name="fkvendor_id">
		<option value="0"> Choose a Vendor... </option>
		<?php			
		while($row = mysql_fetch_array($result)) {  // for all records in vendor table 
		?>
			<option value="<?php echo $row['pkvendor_id']; ?>" <?php if($row['pkvendor_id'] == $fkvendor_id) echo "selected"; ?>> <?php echo $row['vendor_name']; ?> </option> 
            
            
		<?php			
		}
		?>
	</select>
<?php		
}
?>
