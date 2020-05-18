<?php 

// class      :  owners.php 
// folder     :  edmhistorical/admin/projectclasses 
// date       :  Nov 21, 2009 
	
require_once("conn_function.php"); 			// include conn_function 
require_once("sql.php"); 					// include sql 
	
class ownerClass{ 

	// class attributes 
	
	var $m_owner; 							// class attributes 
	var $pagesize = 2;						// number of entries for paging 

	/* ******************************************************************************* */

	// constructor 
	
	function ownerClass()
	{
		$this->m_owner = array('pkowner_id'=>"", 'organization_name'=>"", 'owner_name'=>"", 'owner_address'=>"", 'owner_phone_bus'=>"", 'owner_phone_res'=>"", 'owner_fax'=>"", 'email'=>"", 'foip'=>"", 'owner_type'=>""); 
	}

	/* ******************************************************************************* */

	// add owner record to database  

	function createOwner($vars)
	{
        //print_r($vars);					// print array for testing purposes 
		$id = 'pkowner_id';					// define primary key 
		$sql = "Insert into tblowner";		// sql statement 
		$sql .= InsertSQL($vars, $id);		// append variables to sql insert statement 
		//echo $sql;						// display sql statement 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}

	// **************************************** 
	// **************************************** 

	// update owner record 

	function updateOwner($vars)
	{	
		//print_r($vars);					// print array for testing purposes 
		$id = 'pkowner_id';					// key field in mysql table 
		$sql = "Update tblowner Set ";		// sql statement 
		$sql .= UpdateSQL($vars, $id);		// append variables & values to update  
		$sql .=" where ".$id."=".$vars[$id];  // append 
		//echo $sql;						// display sql statement 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}

	/* ******************************************************************************* */

	// retrieve all owner records 
	// sort by organization name 
	// use paging 

	function getAllOwners($currpg,$url)
	{
		$sql = "Select * from tblowner order by organization_name";	// sql statement 
		$result = paging($sql,$currpg, $this->pagesize,$url);  // execute sql statement 
		return $result;						// return result from sql 
	}
		function getAllOwner()
	{
		$sql = "Select * from tblowner order by organization_name";	// sql statement 
		$result = getconn($sql);  // execute sql statement 
		return $result;						// return result from sql 
	}


	/* ******************************************************************************* */

	// retrieve owner record using owner id 

	function getOwnerById($id)
	{
		$sql = "Select * from tblowner where pkowner_id =" .$id;  // sql statement 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}

	/* ******************************************************************************* */

	// retrieve last owner id in database 

	function getLastOwnerId()
	{
		$id = mysql_insert_id();			// id of last owner in database 
		return $id;							// return 
	}
	
	/* ******************************************************************************* */

	// search for owner records by keyword 
	// for display purposes want to page results 
	
	function ownerKeywordSearch($keyword,$currpg,$url)
	{ 
		$sql = "SELECT * FROM tblowner WHERE organization_name LIKE '%%%" .$keyword ."%%%' OR owner_name LIKE '%%%" .$keyword ."%%%' OR  owner_address LIKE '%%%" .$keyword ."%%%'"; 
		$result = paging($sql, $currpg, $this->pagesize, $url); 
		return $result;						// return result 
	}
	
	/* ***************************************  **************************************** */

	// getter 
	// retrieve class attributes 
	
	function getOwner()
	{
		return $this->m_owner;				// return class attributes 
	}
}
?>
