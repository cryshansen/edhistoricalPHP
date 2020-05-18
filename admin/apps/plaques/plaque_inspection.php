

<?php
$m_inspection = new controllerClass();		// instantiate in controllerClass object 
$inspection_validation = array('plqinsp_date', 5, 'date', 'plqinsp_comments', 5, 'comments', 
	'fkvendor_id', 2, 'vendor', 'fkplaqueinspectiontype_id', 2, 'inspection type'); 
$result = $m_inspection->getPlaqueByID($_GET['id']);  // read plaque record 
$row = mysql_fetch_array($result);			// plaque data 
?>
<p> Plaque Receipient: &nbsp; <?php echo $row['plq_recipient']; ?></p>

<?php 
// want attributes for plaqueinspectionClass
$inspection_vars = $m_inspection->getInspection();  // attributes
// if submit button add or update plaque inspection record 

if(isset($_POST['submit_app'])) {			// if submit button 
	$post_vars = $_POST;					// field values entered on form 
	if ($post_vars['pkplaqueinspection_id']=='new') {  // if a new plq inspection 
		// create plaque inspection record 
		echo "adding ..."; 
		// validate data 
		if(validateData($inspection_validation, $post_vars)) { 
			// data is valid, create inspection record 
			$result=$m_inspection->createInspection($post_vars);
			$result=$m_inspection->updatePlaque($post_vars);
			if($result) { 
?> 
				<p> Your Inspection has been added.  If you would like to see a listing click <a href="index.php?page=plaque_listing">here</a>.</p> 
<?php 
			} 
		} else { 
			// validation error 
?>
			<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php
			displayPlaqueInspection($post_vars); 
		} 
	} else {
		echo "updating ...";
		// validate data 
		if(validateData($inspection_validation, $post_vars)) { 
			// data is valid, update inspection record 
			$result=$m_inspection->updateInspection($post_vars);
			$result=$m_inspection->updatePlaque($post_vars);
			if($result) { 
?> 
				<p> Your Inspection has been updated.  If you would like to see a listing click <a href="index.php?page=plaque_listing">here</a>.</p> 
<?php 
			} 
		} else { 
			// validation error 
?>
			<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php
			displayPlaqueInspection($post_vars); 
		} 
	}
} else {			
	if(isset($_GET['id'])) {				// if plaque id is set in url 
		// read plaque record passed in url 
		// extract plaque record data 
		$plqresult = $m_inspection->getPlaqueByID($_GET['id']); 
		$plqrow = mysql_fetch_array($plqresult); 
		// determine if there is existing plaque inspection record 
		// attempt to retrieve plaque inspection record 
		//     using plaque id and current year 
		$today = getdate();					// current date from system 
		$result = $m_inspection->getInspectionByPlqIdYear($_GET['id'], $today['year']); 
		$rowcount = mysql_num_rows($result);  // number of records retrieved 
		if ($rowcount > 0) {				// if plq inspection record exists 
			// retrieve plaque inspection data 
			// append plaque inspection data to plaque data 
			// want all data accessible when populating form 
			while ($row = mysql_fetch_array($result)) {
				$row = array_merge($row, $plqrow); 
				displayPlaqueInspection($row);  // populate form 
			}
		} else { 							// otherwise 
			// no plaque inspection data 
			// display blank form - plaque inspection data 
			// form includes plaque inspection required field from plaque record 
			// include plaque inspection attributes with plaque attributes 
			$row = array_merge($inspection_vars, $plqrow); 
			displayPlaqueInspection($row); 
		}
	}
} 
?>

<?php
/*----------------------------------- display inspection form -----------------------------------*/ 
// display plaque inspection form (tblplaqueinspection) 
// include plaque inspection required field from plaque record (tblplaque) 
// if no plaque inspection record - display form with no date 
// if    plaque inpsection record - display form poulated with data from record 
function displayPlaqueInspection($vars)
{
?>	
	<form name="Inspection" method="post" action="" > <!--index.php?action=applicant-->
		<fieldset>
			<legend> Plaque Inspection </legend>
				<table>
					<tr>
						<td> Inspection Date: <br />
							<div> <input onclick='ds_sh(this);' name="plqinsp_date" readonly='readonly' style='cursor: text' value="<?php echo $vars['plqinsp_date']; ?>" /> </div> </td>
						<td> Done By: <br /> <?php displayVendor($vars['fkvendor_id']); ?> </td> 
                        <td> Inspection Required: <br /> 
                        	<input type="radio" name="plq_inspect_reqd" value="Y" <?php if($vars['plq_inspect_reqd']=='Y') echo  'checked'; ?> /> Yes 
							<input type="radio" name="plq_inspect_reqd" value="N" <?php if($vars['plq_inspect_reqd']=='N') echo  'checked'; ?> /> No 
						</td> 
					</tr> 
                    <tr> 
                    	<td> Inspection Action: <br /> 
							<input type="text" name="plqinsp_action" value="<?php echo $vars['plqinsp_action']; ?>" /> </td> 
                        <td> Inspection Type: <br /> <?php displayInspectType($vars['fkplaqueinspectiontype_id']); ?> </td> 
                    </tr>
					<tr> 
						<td colspan="2"> Inspection Comments: <br />
							<textarea name="plqinsp_comments" cols="40" rows="6"><?php echo $vars['plqinsp_comments']; ?></textarea> </td>
					</tr>
				</table> 
			</fieldset>
			<input type="hidden" name="pkplaqueinspection_id" value="<?php if ($vars['pkplaqueinspection_id']=='') { echo 'new'; }  else { echo $vars['pkplaqueinspection_id']; }?>" /> 
			<input type="hidden" name="pkplaque_id" value="<?php echo $vars['pkplaque_id']; ?>" /> 
			<input class="btton" type="submit" value="Submit" name="submit_app" />
	</form>
<?php
}
/*----------------------------------- display vendors -----------------------------------*/ 
// display drop down list containing vendors (file tblvendor) 
// populate drop down list entries with vendor id and vendor name 
function displayVendor($fkvendor_id)
{
 	$m_vendor = new controllerClass();		// instantiate new controller object 
	$results = $m_vendor->getAllVendors();	// retrieve all records 
?>
	<select name="fkvendor_id"> 
    	<option value="0"> Choose a Vendor... </option> 
		<?php
		while($row=mysql_fetch_array($results)) {  // for all records in vendor table 
		?>
			<option value="<?php echo $row['pkvendor_id']; ?>"<?php if($row['pkvendor_id'] == $fkvendor_id) echo "selected"; ?>><?php echo $row['vendor_name']; ?></option>
		<?php 
		}
		?> 
	</select> 
<?php
}

/*------------------------------ display plaque inspection type ------------------------------*/ 
// display drop down list containing plaque inspection type (file tblplaqueinspectiontype) 
// populate drop down list entries with id and name 
function displayInspectType($fkplaqueinspectiontype_id)
{
 	$m_plqinspecttype = new controllerClass();		// instantiate new controller object 
	$result = $m_plqinspecttype->getInspectionTypes();	// retrieve all records 
?>
	<select name="fkplaqueinspectiontype_id"> 
    	<option value="0"> Choose Inspection Type ... </option> 
		<?php
		while($row=mysql_fetch_array($result)) {  // for all records in vendor table 
		?>
			<option value="<?php echo $row['id']; ?>"<?php if($row['id'] == $fkplaqueinspectiontype_id) echo "selected"; ?>> <?php echo $row['name']; ?> </option>
		<?php 
		}
		?> 
	</select> 
<?php
}
?>
