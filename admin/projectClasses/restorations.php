<?php 

// class      :  restorations.php 
// folder     :  edmhistorical/admin/projectclasses 
// date       :  Nov 18, 2009 
	
require_once("conn_function.php"); 				// include conn_function.php  
require_once("sql.php"); 						// include sql.php 
	
class plaquerestorationsClass{ 
	
	// class attributes 
	
	var $m_plaquerestoration;
	
	// constructor 
	
	function plaquerestorationsClass()
	{
		$this->m_plaquerestoration = array('pkplaquerestoration_id'=>"", 'plqrestore_date'=>"", 'fkvendor_id'=>"", 'plqrestore_comments'=>"", 'fkplaque_id'=>""); 
	}

	/* ********************************************************************************** */

	// add plaquerestoration record to database  

	function createPlaqueRestoration($vars)
	{
		$id = 'pkplaquerestoration_id';		// define primary key 
		$sql = "Insert into tblplaquerestoration";	// sql statement 
		$sql .= InsertSQL($vars, $id);		// append variables to sql insert statement 
		// echo $sql;						// display sql statement 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}

	/* ********************************************************************************** */

	// update plaquerestoration record 

	function updatePlaqueRestoration($vars)
	{	
		$id = 'pkplaquerestoration_id';		// set plaquerestoration id 
		$sql = "Update tblplaquerestoration Set ";	// sql statement 
		$sql .= UpdateSQL($vars, $id);		// append plaquerestoration value to sql statement 
		$sql .=" where ".$id."=".$vars[$id];  // append 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}

	/* ********************************************************************************** */

	// retrieve all plaquerestoration records 

	function getAllPlaqueRestorations()
	{
		$sql = "Select * from tblplaquerestoration";  // sql statement 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}

	/* ********************************************************************************** */

	// retrieve plaquerestoration record using plaquerestoration id 

	function getPlaqueRestorationById($id)
	{
		$sql = "Select * from tblplaquerestoration where pkplaquerestoration_id =" .$id;  // sql statement 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}

	/* ********************************************************************************** */

	// retrieve last plaquerestoration id in database 

	function getLastPlaqueRestorationId()
	{
		$id = mysql_insert_id();			// id of last plaquerestoration in database 
		return $id;							// return 
	}

	/* ********************************************************************************** */

	// retrieve array containing class attributes 

	function getPlaqueRestoration()
	{
		return $this->m_plaquerestoration;	// array containing attributes 
	}

	/* ********************************************************************************** */

	// retrieve plaque restoration record 
	//     look for match on plaque id and year 
	// should be one plaque restoration record for each year 

	function getPlaqueRestorationByPlqIdYear($fkplaque_id, $year) 
	{ 
	 	$sql = "Select * from tblplaquerestoration where fkplaque_id='" .$fkplaque_id ."' and year(plqrestore_date)='" .$year ."'"; 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return what was retrieved 		
	} 
	/* ********************************************************************************** */	
}
?>