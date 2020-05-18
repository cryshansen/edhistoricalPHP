<?php
require_once("conn_function.php");
require_once("sql.php");

class inspectionClass{
var $m_inspection;

	//constructor
	 function inspectionClass()
	 {
		$this->m_inspection=array('pkplaqueinspection_id'=>"",'plqinsp_date'=>"",'fkvendor_id'=>"",'fkplaqueinspectiontype_id'=>"", 'plqinsp_action'=>"",'plqinsp_comments'=>"",'fkplaque_id'=>"");
	 }
	
	
	/* ********************************************************************************** */
	// Nov 18 
	// add plaque inspection record to database  

	function createInspection ($vars)
	{
		$id = 'pkplaqueInspection_id';		// define primary key 
		$sql = "Insert into tblplaqueinspection";	// sql statement 
		$sql .= InsertSQL($vars, $id);		// append variables to sql insert statement 
		// echo $sql;						// display sql statement 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}

	/* ********************************************************************************** */
	// Nov 18 
	// update plaque inspection record 

	function updateInspection($vars)
	{	
		$id = 'pkplaqueinspection_id';		// set plaque inspection id 
		$sql = "Update tblplaqueinspection Set ";	// sql statement 
		$sql .= UpdateSQL($vars, $id);		// append plaque inpsection attributes 
		$sql .=" where ".$id."=".$vars[$id];  // append plaque inspection id
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}

	/* ********************************************************************************** */
	
	//getAllInspection
	function getAllInspection()  {
	
			$sql="Select * from tblplaqueinspection";  
			$result=getconn($sql);
			return $result;
	}
	
	function getInspectionById($id)  {
			$sql="Select * from tblplaqueinspection WHERE pkplaqueinspection_id=".$id;
			$result=getconn($sql);  
			return $result;  		
	}
	
	// **************************************** 
	// Nov 18  
	// retrieve plaque inspection types 
	// changed function name "...Type" to "...Types" 
		
	function  getInspectionTypes()
	{
		$sql="Select * from tblplaqueinspectiontype";  
		$result=getconn($sql);
		return $result;
	}
	// **************************************** 
	
	function getInspection()
	{
		return $this->m_inspection;
	} 
	
	/* ********************************************************************************** */
	// Nov 18 
	// retrieve plaque inspection record 
	//     look for match on plaque id and year 
	// should be one plaque restoration record for each year 

	function getInspectionByPlqIdYear($fkplaque_id, $year) 
	{ 
	 	$sql = "Select * from tblplaqueinspection where fkplaque_id='" .$fkplaque_id ."' and year(plqinsp_date)='" .$year ."'"; 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return what was retrieved 		
	} 
	/* ********************************************************************************** */	
}
?>