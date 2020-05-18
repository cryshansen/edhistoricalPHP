<?php
/* ------------------------------ validate data ------------------------------ */ 
// validate data in form 
$vars = array( 'organization_name' => "Banana",'owner_type' => "Organization", 'owner_name' => "Banana Boat", 'owner_address' => "24 145 Avenue", 'owner_phone_bus' => 7895674328, 'owner_phone_res' => 7895674328, 'owner_fax' => 7895674328, 'email' => "pocket_goddess@hotmail.com", 'foip' => "Y", 'pkowner_id' => 3 ); 

$fields = array('pkowner_id', 1, 'owner', 'organization_name', 101, 'organization', 'owner_name', 1, 'owner', 'owner_address', 101, 'address', 'owner_phone_bus', 103, 'phone (bus)' , 'owner_phone_res', 103, 'phone (res)', 'owner_fax', 103, 'fax', 'email', 104, 'email address', 'foip', 101, 'waiver', 'owner_type', 1, 'type'); 

//WE WONT BE CHECKING PRIMARY KEYS BECAUSE A) IF ITS NEW, IT WILL FAIL WILL IT NOT? AND B) THAT IS CODE BEHIND AND THE USER DOES NOT HAVE ANY CONTROL OVER THE PRIMARY KEY. IF IT DOES NOT EXIST WE HAVE NOT CODED IT PROPERLY AND WE HAVE A PROBLEM.

// IF A FIELD IS NOT REQUIRED IT SHOULD NOT GO INTO THE LOOP AT ALL, AND THAT WAS THE PURPOSE OF MY SUGGESTING DOING AN ARRAY INTERSECT KEY  
		

function validateData($fields, $vars) 
{ 
	// array for storing error messages 
	global $err_mess; 						// error message, make accessible outside function 
	$err_msg = ""; 							// blank to begin with 
	$fields_ok = true;						// success/failure indicator - assume success 

	// for each field name in validation information validate data 
	//     data according to rules for field 
	// $fields[x]   - attribute name 
	// $fields[x+1] - human name for err message (if any) 
	// $fields[x+2] - validation code 
	// validation codes - correspond to array entry in function validateData 
	//     1   - field required - no validation required 
	//     2   - field required - number 
	//     3   - field required - phone number, must be 10 digits long 
	//     4   - field required - email address  
	//     101 - field not required field - no validation required 
	//     code + 100 - field not required but same validation as code if field required 
	
	// want to consider validation for all fields in record 
	for ($i=0; $i<count($fields); $i=$i+3) 
	{
		// extract data value from $vars that corresponds 
		//     to field name in validation data 
		$field_name = $fields[$i]; 			// field name 
		$field_data = $vars[$field_name]; 	// value from form 
		$field_code = $fields[$i+1];		// validation code 
		$field_err = $fields[$i+2];			// field name for error message 
		
		// determine if field is required with no validation 
		if ($field_code==1) { 
			// required field, no validation required, determine if entered 
			if (strlen($field_data)==0) { 
				// required field not entered 
				$err_mess .=$field_err ."-required field "; 
				$fields_ok = false;			// indicate validation problem 
			}
		} 
		
		// determine if validating number 
		if ($field_code==2 or $field_code==102) {
			// validation may be required on number 
			// check if required field and no data 
			if ($field_code==2 and is_numeric($field_data) == false) { 
			//THIS SHOULD BE FOREIGN KEY CHECK AND IF IT ISNT SELECTED FROM A DROPDOWN IT IS NOT NUMERIC AKA "CHOOSE A VENDOR TYPE...."
				// required field and no data 
				$err_mess .=$field_err ."-required field "; 
				$fields_ok = false; 		// indicate validation problem 
			} else { 						// could still be no data 
				if ($field_data!="" and is_numeric($field_data) == false) { 		// if data is entered 
					// determine if field is numeric 
						// field is not numeric 
						$err_mess .=$field_err ."-not numeric "; 
						$fields_ok = false;		// indicate validation problem 
				} 
			}
		}

		// determine if validating phone number 
		if ($field_code==3 or $field_code==103) { 
			// validation may be required on phone number 
			if ($field_code==3 and (is_numeric($field_data)==false and strlen($field_data)!=10) { 
				// required field and no data 
				$err_mess .=$field_err ."-required field "; 
				$fields_ok = false; 		// indicate validation problem 
			} else { 						// could still be no data 
				if ($field_data!="" and is_numeric($field_data)==false and strlen($field_data)!=10)) { 		// if data is entered 
					// validate if not required field & data entered 
					// except 0 is a valid phone number (mysql doing)  //THIS SHOULD BE HANDLED TO NOT SHOW 0 ON DISPLAY SO WHEN A POST IS DONE THE 0 WONT BE THERE TO CHECK CONDITION THEREFORE I REMOVED IT AND BROUGHT THE OTHER CONDITIONS INTO THE SAME IF STATEMENT
						// determine if field is numeric 
							// field is not numeric 
							$err_mess .=$field_err ."-not numeric "; 
							// phone number length not 10 
							$err_mess .=$field_err ."-must be 10 digits "; 
							$fields_ok = false;  // indicate validation problem 
				}	
			}
		} 
		
		// determine if validating email address 
		if ($field_code==4 or $field_code==104) { 
			// validation may be required on email address 
			// check if required field and no data 
			if ($field_code==4 and (!$this->isEmail($field_data)) { 
			//IF ITS A REQUIRED FIELD CHECK IF IT IS AN EMAIL ADDRESS BC THERE IS NO POINT IN SAYING ITS A REQUIRED FIELD IF IT IS INCORRECT ANYWAYS.
				// required field and invalid email address
					$err_mess .=$field_err ."-invalid"; 
					$fields_ok = false;		// indicate validation problem 
			} else { 						// could still be no data 
				if ($field_data!="") { 
					// validate email address 
					if (!$this->isEmail($field_data))
					{ 
						// invalid email address 
						$err_mess .=$field_err ."-invalid"; 
						$fields_ok = false;		// indicate validation problem 
					} 
				}
			}
		
	}

	// all fields validated, return success/failure indicator 
	return $fields_ok; 	
} 

function isEmail($field_data)
{
	$fields_ok=preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $field_data);
	return $fields_ok

}
?>