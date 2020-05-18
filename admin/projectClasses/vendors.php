<?php
require_once("conn_function.php");
require_once("sql.php");

class vendorClass{
	
	var	$vendors_vars; 
	// ****************************************  
	// Nov 21 
	var $pagesize = 1; 						// paging - number of entries to display 
	// ****************************************  
		
		 //controller  
		  function vendorClass()
		  {
			$this->vendors_vars=array( 'pkvendor_id'=>"",'vendor_name'=>"",'vendor_address'=>"",  'vendor_phone_bus'=>"",  'vendor_phone_res'=>"",  'vendor_fax'=>"",  'fkvendortype_id'=>"");
		
		  }
		  function createVendors($vendor_vars)
		  {			
				//define the array key for primary key		
				$id='pkvendor_id';		
				//create initial sql call		
				$sql = "INSERT INTO tblvendor "; 		
				//concatenate and call sql function from sql.php pass in the vars from post and the id defined above.		
				$sql .=InsertSQL($vendor_vars,$id);
				// call getconn function defined in conn_function .php your mysql database and passwords/username		
				$result = getconn($sql);		
				//return the success or failure	
				echo $result;		
				return $result;	
			}

		// ****************************************  
			// Nov 14 
			// line 49 - changed "$vendor_vars" to "$vendors_vars" 
			// line 49 - changed "$pkvendor_id" to "$id" 
			// line 52 - changed "$vars" to "$vendors_vars" 
			// line 52 - changed "$pkvendor_id" to "$id" 
		  function updateVendors($vendors_vars){
				//define the array key for primary key		
				$id='pkvendor_id';
				$sql="UPDATE tblvendor SET ";
				//concatenate and call sql function from sql.php pass in the vars from post and the id defined above 		
				// $sql.=UpdateSQL($vendor_vars,$pkvendor_id);
				$sql.=UpdateSQL($vendors_vars,$id);				
				//concatenate where clause		
				// $sql .=" where ".$id."=".$vars[$pkvendor_id];
				$sql .=" where ".$id."=".$vendors_vars[$id];					
				// call getconn function defined in conn_function .php your mysql database and passwords/username
				$result = getconn($sql);
				//return the success or failure
				return $result;
			}
		// ****************************************  			
			
		function getAllvendors()
		{
			// retrieve records order by name 
			$sql="Select * from tblvendor"; 
			$result=getconn($sql); 
			return $result;					// return search result 
		}
			
		// ****************************************  
		// Nov 21 
		// retrieve all vendor records 
		// sort by name (ascending order) 
		// want results to be paged 
		// set number of records to display 
			
		function getAllVendorsList($currpg, $url )
		{
			// retrieve records order by name 
			$sql="Select * from tblvendor order by vendor_name"; 
			//echo $sql;  
			// $result=getconn($sql); 
			$result = paging($sql, $currpg, $this->pagesize, $url); 
			return $result;					// return search result 
		}
		// ****************************************  
					  
		  function getVendorsById($id)
		  {
				// simple select statement		
				$sql="Select * from tblvendor WHERE pkvendor_id=".$id;
				// call getconn function defined in conn_function .php your mysql database and passwords/username
				$result=getconn($sql);
				//returns recordset or failure	
				return $result;
		} 
		
		function getVendorTypes()
		{
			$sql="Select * from tblvendortype ";
			$result=getconn($sql);
			return $result;
		}


		// ****************************** 
		// Nov 14 
		// line 101 - "$keyword_text" to "$vars['keyword_text']" 
		// line 101 - "fkvendortypeid" to "fkvendortype_id" 
		// line 102 - "(" before "vendor_name", ")" before "space end quote" at end of statement 
		// line 107, 108, 109 - "fkvendortypeid" to "fkvendortype_id" 
		// line 111 - space before "ORDER BY" 
		// line 110, 111, 112, 113 - commented out 
		// add lines 114, 115, 116, 117 
		function getVendorsByCriteria($vars,$currpg,$url)
		{
		//	$sql="select tblvendor.*,name from tblvendor INNER JOIN tblvendortype ON fkvendortypeid = id where vendor_name like '%%%".$keyword_text."%%%' or contact_name like '%%%".$keyword_text."%%%' ";
		$sql="select tblvendor.*,name from tblvendor INNER JOIN tblvendortype ON fkvendortype_id = id where "; 
		if($vars['keywd'] !="") 
		{
			$sql.="(vendor_name like '%%%".$vars['keywd']."%%%' or contact_name like '%%% ".$vars['keywd']."%%%') ";	
		}
		if(($vars['fkvendortype_id'] !="") and ($vars['keywd'] !="") ){
				$sql .= " and "; 
		}
		// to here $sql contains search criteria relating to tblvendor 
		// checks against vendor type if vendor type is selected in drop down line 
		// included sql code for criteria relating to vendor type 

		if($vars['fkvendortype_id'] !="") {
			$sql .= " fkvendortype_id=".$vars['fkvendortype_id']; 
		}
		$sql .=" ORDER BY vendor_name ASC"; 
		$result = paging($sql,$currpg,$this->pagesize,$url); 
		return $result;
		}
		// ****************************** 
		
		//getter 
		function getVendor()
		{
			return $this->vendors_vars;
		}
 }
?>
