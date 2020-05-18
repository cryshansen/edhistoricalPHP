<?php
$m_owner = new controllerClass();			// instantiate new controllerClass class 
$owner_vars = $m_owner->getOwner();			// array of attribute names from class owner 
$owner_validation = array('pkowner_id', 1, 'primary key', 'organization_name', 105, 'organization', 'owner_name', 5, 'owner', 'owner_address', 105, 'address', 'owner_phone_bus', 103, 'phone (bus)' , 'owner_phone_res', 103, 'phone (res)', 'owner_fax', 103, 'fax', 'email', 104, 'email address', 'foip', 5, 'waiver', 'owner_type', 5, 'type');   // owner validation information 

if (isset($_POST['submit_app'])) { 	
	// submit button - create new owner or update existing owner 
	$post_vars = $_POST;					// field values entered on form 
	$post_vars['owner_phone_bus']= deconstructPhone($post_vars['owner_phone_bus']);
	$post_vars['owner_phone_res']=deconstructPhone($post_vars['owner_phone_res']);
	$post_vars['owner_fax']=deconstructPhone($post_vars['owner_fax']);
	//print_r($post_vars);					// for testing  
	if ($post_vars['pkowner_id'] == "new")  // if a new owner 
	{	
		// create new owner record 
		//echo "adding ...";				// for testing  
		// validate form data 
		if (validateData($owner_validation, $post_vars)) 
		{	
			// data is valid - create owner record 
			$result = $m_owner->createOwner($post_vars); 
			if($result) { 					// if successful 
?>	
				<p>Your Owner has been Added. If you would like to see a listing click <a href="index.php?page=owner_listing">here</a>.</p>
<?php 
			} 
		} 
		else { 
			// validation error, display form and data again 
			//print_r($post_vars);			// for testing  
					// form and data 
?>
			<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php			displayOwner($post_vars); 
             
		}
	} else { 								// otherwise 
		// updating existing owner record 
		//echo "updating ...";				// for testing 
		// validate data on form 
		if (validateData($owner_validation, $post_vars)) {
			// data is valid - update record 
			$result = $m_owner->updateOwner($post_vars);  // update owner record 
			if($result) {					// if successful 
?>
				<p>Your Owner has been Updated. If you would like to see a listing click <a href="index.php?page=owner_listing">here</a>.</p>
<?php 
			} 
		} else { 							// otherwise 
			// validation error, display form and data again 
			//print_r($post_vars);			// for testing  
?>
			<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 

<?php			displayOwner($post_vars); 		// display data again 
 
		}
	}
} else { 									// otherwise 
	if (isset($_GET['id'])) {				// if id is set in url 
		// display owner information 
		// retrieve owner record 
		$result = $m_owner->getOwnerById($_GET['id']);  
		// operate on all retrieved records 
		while ($row = mysql_fetch_array($result)) 
		{  
			$row['owner_phone_bus']= displayPhone($row['owner_phone_bus']);
			$row['owner_phone_res']=displayPhone($row['owner_phone_res']);
			$row['owner_fax']=displayPhone($row['owner_fax']);
			displayOwner($row);				// display form & owner information 
		}
	} else {								// otherwise 
		displayOwner($owner_vars);			// display form & no owner information 	
	}
}
			
/*---------------------------------------- display owner ----------------------------------------*/ 
function displayOwner($vars)
{
?>
	<form name="owner" method="post" action="" >
		<fieldset>			
			<legend> Owner </legend>
			<table>
				<tr>
					<td> Organization Name: <br />
						<input type="text" name="organization_name" value="<?php echo $vars['organization_name']; ?>" /> </td> 
       
					<td> Owner Type: <br /> 
						<input type="radio" name="owner_type" value="Individual" <?php if($vars['owner_type']=='Individual') echo 'checked'; ?>> Individual 
						<input type="radio" name="owner_type" value="Organization"  <?php if($vars['owner_type']=='Organization') echo 'checked'; if($vars['owner_type']=="") echo 'checked'; ?>> Organization 
					</td>
				</tr>
				<tr>
					<td> Owner Name: <br />
						<input type="text" name="owner_name" value="<?php echo $vars['owner_name']; ?>" /> </td>
					<td> Owner Address: <br />
						<input type="text" name="owner_address" value="<?php echo $vars['owner_address']; ?>" /> </td>
				</tr>
				<tr>
					<td> Owner Business Phone: <br />
						<input type="text" name="owner_phone_bus" value="<?php if($vars['owner_phone_bus']!='0') { echo $vars['owner_phone_bus']; } else { echo ''; } ?>" /> </td> 
					<td> Owner Residence Phone: <br />
						<input type="text" name="owner_phone_res" value="<?php if($vars['owner_phone_res']!='0') { echo $vars['owner_phone_res']; } else { echo ''; } ?>" /> </td>
				</tr>
				<tr>
					<td> Owner Fax: <br />
						<input type="text" name="owner_fax" value="<?php if($vars['owner_fax']!='0') { echo $vars['owner_fax']; } else { echo ''; } ?>" /> </td> 

					<td> Owner Email Address: <br />
						<input type="text" name="email" value="<?php echo $vars['email']; ?>" /> </td>
				</tr>
				<tr>
					<td> FOIP Waiver: <br />
						<input type="radio"  name='foip' value="Y" <?php if ($vars['foip']=='Y') echo 'checked'; ?>  /> Yes
						<input type="radio"  name='foip' value="N" <?php if($vars['foip']=='N')  echo 'checked'; if($vars['foip']=="") echo 'checked'; ?>	/> No</td>
				</tr> 

			</table>
			</fieldset>
			<input type="hidden" name="pkowner_id" value="<?php if ($vars['pkowner_id'] == '') { echo "new"; } else { echo $vars['pkowner_id']; } ?>" />
			<input class="btton" type="submit" value="Submit" name="submit_app" />
		
	</form>
<?php
}

