<?php 

/*----------------------------	Phone reconstruct --------------------------- */
function displayPhone($value){
	if($value !=0){
		$area=substr($value,0,3);
		$first3=substr($value,3,3);
		$last4=substr($value,6);
		$value= "(".$area.") ".$first3."-".$last4;
	}else{
		$value="";
	}
		return $value;
}
function deconstructPhone($value){

		$phone=str_replace('(', '', $value);
		$phone=str_replace(') ', '', $phone);
		$phone=str_replace(')', '', $phone);
		$phone=str_replace('-', '', $phone);
		$phone=str_replace(' ', '', $phone);
		//echo $phone."<br />";
		return $phone;

}

/* ------------------------------ validate data ------------------------------ */ 
// validate data in form 

function validateData($fields, $vars) 
{ 
	// array for storing error messages 
	global $err_mess; 						// error message, make accessible outside function 
	$err_msg = ""; 							// blank to begin with 
	$fields_ok = true;						// success/failure indicator - assume success 

	// for each field name in validation information validate data 
	//     data according to rules for field 
	// $fields[x]   - attribute name 
	// $fields[x+1] - validation code 
	// $fields[x+2] - human name for error message 
	// validation codes - correspond to array entry in function validateData 
	//     1   - field required - primary key, "new" (new record) or numeric (existing record) 
	//     2   - field required - foreign key, must be numeric, must be > 0 
	//     3   - field required - phone number, must be 10 digits long 
	//     4   - field required - email address 
	//	   5   - field required - no validation required 
	//     code + 100 - field not required but same validation as code if field required 
	
	// want to consider validation for all fields in record 
	for ($i=0; $i<count($fields); $i=$i+3) 
	{
		// extract data value from $vars that corresponds 
		//     to field name in validation data 
		$field_name = $fields[$i]; 			// field name 
		$field_data = $vars[$field_name]; 	// data value from form 
		$field_code = $fields[$i+1];		// validation code 
		$field_err = $fields[$i+2];			// field name for error message 
		
		// determine if validating primary key 
		if ($field_code==1) { 
			// primary key, required field, must be "new" or numeric 
			if (strlen($field_data)==0) { 
				// required field not entered 
				$err_mess .=$field_err ."-required field "; 
				$fields_ok = false;			// indicate validation problem 
			} else { 						// not blank so 
				// check for "new" (new record) or numeric (update existing record) 
				if ($field_data != "new") { 
					if (is_numeric($field_data) == false) { 
						// invalid primary key 
						$err_mess .=$field_err ." - invalid primary key "; 
						$fields_ok = false;			// indicate validation problem 						
					}
				}
			} 
		} 

		// determine if validating foreign key 
		if ($field_code==2 or $field_code==102) {
			// validation may be required on number 
			// check if required field and no data 
			if ($field_code==2 and is_numeric($field_data)==false) { 
				// required foreign key and no data 
				$err_mess .=$field_err ."-required field "; 
				$fields_ok = false; 		// indicate validation problem 
			} else { 						// could still be no data 
				if ($field_data!="" and is_numeric($field_data)==false) { 
					// field is not blank, must be number 
					$err_mess .=$field_err ."-not numeric "; 
					$fields_ok = false;		// indicate validation problem 
				} else { 
					// ensure value is > 0 
					if ($field_data <= 0) { 
						// invalid foreign key 
						$err_mess .=$field_err ."-select "; 
						$fields_ok = false;		// indicate validation problem 
					}
				}
			}
		}

		// determine if validating phone number 
		if ($field_code==3 or $field_code==103) { 
			// validation may be required on phone number 
			if ($field_code==3 and $field_data=="") { 
				// required field and no data 
				$err_mess .=$field_err ."-required field "; 
				$fields_ok = false; 		// indicate validation problem 
			} else { 						// could still be no data 
				// validate if not required field & data entered 
				if ($field_data!="" and is_numeric($field_data)==false) { 
					// field is not a number 
					$err_mess .=$field_err ."-not numeric "; 
					$fields_ok = false;		// indicate validation problem 
				} else { 
					// check for correct length (must be 10 digits) 
					if ($field_data!="" and strlen($field_data)!=10) {
						// phone number length not 10 
						$err_mess .=$field_err ."-must be 10 digits "; 
						$fields_ok = false;  // indicate validation problem 
					}
				}
			} 
		} 
		
		// determine if validating email address 
		if ($field_code==4 or $field_code==104) { 
			// validation may be required on email address 
			// check if required field and no data 
			if ($field_code==4 and (!isEmail($field_data))) { 
				// required field and invalid email address 
				$err_mess .=$field_err ."-invalid address "; 
				$fields_ok = false; 	// indicate validation problem 
			} else { 						// could still be no data 
				if ($field_data!="") { 
					// validate email address 
					if (!isEmail($field_data)) { 
						// invalid email address 
						$err_mess .=$field_err ."-invalid address "; 
						$fields_ok = false;		// indicate validation problem 
					} 
				}
			}
		} 

		// determine if no validation required (but could be required field) 
		if ($field_code==5 or $field_code==105) { 
			// considering field with no validation requirements 
			if ($field_code==5 and strlen($field_data)==0) { 
				// required field and no data 
				$err_mess .=$field_err ."-required field "; 
				$fields_ok = false; 	// indicate validation problem 
			}
		} 
	} 

	// all fields validated, return success/failure indicator 
	return $fields_ok; 	
} 

/* -------------------------------------------------------------------------------- */ 
// validate email address 
function isEmail($field_data) 
{ 
	$fields_ok=preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $field_data); 
	return $fields_ok; 
}


 
?>

