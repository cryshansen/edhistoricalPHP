<?php 
$m_tablemanager = new controllerClass();	// instantiate new controller class 
$table_vars = $m_tablemanager->getTable();	// universal table attributes 
$table_validation = array('id', 1, 'primary key', 'name', 5, 'name', 'description', 105, 'description');   // table validation information 
$table_validation2 =  array('id', 1, 'primary key', 'name', 5, 'name', 'description', 105, 'description', 'fkward_id', 2, 'ward'); // neighbourhood table validation information

if (isset($_POST['submit_app'])) {			// if submit button 
	$post_vars = $_POST; 					// retrieve form data 
	// if operating on table neighbourhood different validation is required 
	// ensure no spaces in table name for compare 
	$pktable_id= str_replace(' ','',$post_vars['pktable_id']); 
	if ($pktable_id == "tblneighbourhood") { 
		$validation = $table_validation2; 
	} else { 
		$validation = $table_validation; 
	} 
	// want to add record to table or update record in table 
	if ($post_vars['id']=="new") {			// if add record to table 
		// validate data 
		if (validateData($validation, $post_vars)) { 	
			// data is valid - add record to table 
			$result = $m_tablemanager->createTableRecord($_POST['pktable_id'], $post_vars); 
			echo "adding ...";					// testing 
			if ($result) { 
?>
			    <p> Your table record has been Added.  If you would like to see a listing click <a href="index.php?page=tablemanager_listing">here</a>.<p> 
<?php
			}
		} else { 
			// validation error, display form and data again 
?>
			<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php 			displayTable($post_vars); 

		} 
			
	} else { 								// otherwise update existing record 
		// update record in table, validate data 
		if (validateData($validation, $post_vars)) { 
			// data is valid - update record in table 
			$result = $m_tablemanager->updateTableRecord($_POST['pktable_id'], $post_vars); 
			//echo "updating ..."; 				// testing 
			if ($result) { 
?>
		    <p> Your table record has been Updated.  If you would like to see a listing click <a href="index.php?page=tablemanager_listing">here</a>.<p> 
<?php
			}
		} else { 
			// validation error, display form and data again 
?>
			<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php			displayTable($post_vars); 

 
		}
	} 
} else {									// not submit button so set up form 
	if (isset($_GET['id'])) {				// if id is set update existing record 
		// read record from table 
		// pktable_id 	- table name (from tablemanager_listing) 
		// $_GET['id']	- record number (from tablemanager_listing) 
		$result = $m_tablemanager->getTableById($_POST['pktable_id'], $_GET['id']); 
		while ($row = mysql_fetch_array($result)) { 
			displayTable($row);		// display form & table data 
		}
	} else { 								// otherwise display blank form 
		displayTable($table_vars);		// form but no data values 
	}
}

/* ------------------------------ display table maint form & data ------------------------------ */ 
// display table maintenance form 
// if create - data entries in form are blank 
// if update - data entries are from existing record 
// if working with tblneighbourhood display ward 
//     associated with neighbourhood in drop down list 
function displayTable($vars) 
{
?>
<form method="post" action="">
	<fieldset>
		<legend>Table Maintenance</legend>
			<table>
				<tbody>
					<tr>
						<td> Table Name: </td> 
                        <td> <?php echo $_POST['pktable_id']; ?> </td> 
					</tr>
					<tr>
						<td> Name:<br />
						<input name="name" type="text" value="<?php echo $vars['name']; ?>" />
 						</td> 
                        <td><?php if(array_key_exists('fkward_id', $vars)) echo "Ward:"; ?><br /> <?php if(array_key_exists('fkward_id', $vars)) displayWards($vars['fkward_id']); ?> 
  </td> 
					</tr>
					<tr>
						<td colspan="3"> Description:<br />
							<input name="description" type="text" size="65" value="<?php echo $vars['description']; ?>" /></td> 
						</tr>
				</tbody>
			</table> 
	</fieldset>
		<input name="pktable_id" type="hidden" value=" <?php echo $_POST['pktable_id']; ?>" /> 
		<input name="id" type="hidden" value="<?php if($vars['id']=='') { echo "new"; } else { echo $vars['id']; }?>" />
        <input class="btton" type="submit" value="Submit" name="submit_app" />
</form>
<?php 
}

/*-----------------------------------  display wards -----------------------------------*/ 
// display wards in drop down list (file tblward) 
// populate drop down list entries with id and name 
function displayWards($fkward_id)
{		
	$m_wards = new controllerClass();		// instantiate new controller class 
	$result = $m_wards->getTableRecordsList('tblward');  // retrieve all wards 
?>	
	<select name="fkward_id">
		<option value="0"> Choose a Ward ... </option>
		<?php			
		while($row = mysql_fetch_array($result)) {  // for all records in vendor table 
		?>
			<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $fkward_id) echo "selected"; ?>> <?php echo $row['name']; ?> </option> 
		<?php			
		}
		?>
	</select>
<?php		
}
?>
