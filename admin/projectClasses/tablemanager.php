<?php
require_once("conn_function.php");
require_once('sql.php');

class tableManagerClass{

// define arrays for class attributes corresponding to tables 
// all tables except tblneighbourhood 
var $m_table;								// all tables except 
var $m_table2; 								// tblneightbourhood 
var $m_tablereferences;						// references between tables 

	//constructor
	function tableManagerClass()
	{
		$this->m_table = array('id'=>"",'name'=>"",'description'=>""); 
		$this->m_table2 = array('id'=>"",'name'=>"",'description'=>"", 'fkward_id'=>""); 
		
		// administrative table references 
		// $m_tablreferences[x]   - name of table record is being deleted from (tablexx) 
		// $m_tablreferences[x+1] - name of table tablexx is referenced in (tableyy) 
		// $m_tablreferences[x+2] - foreign key field name in tableyy that references tablexx
		$this->m_tablereferences = array('tblapplication_status', 'tblapplication', 'fkapplication_status_id', 
					'tblhistorical_event', 'tblapplication' ,'fk_historical_id', 
					'tblplaqueinspectiontype', 'tblplaqueinspection', 'fkplaqueinspectiontype_id', 
					'tblneighbourhood','tbllandmark', 'fkneighbor_id', 
					'tblordertype', 'tblorder', 'fkorder_type', 
					'tblplaquetype', 'tblplaque', 'fkplaquetypeid', 
					'tbluser_group', 'tbluser', 'fkuser_group_id', 
					'tblvendortype', 'tblvendor', 'fkvendortype_id', 
					'tblward', 'tblneighbourhood', 'fkward_id');  
	} 
	/* -------------------------------------------------------------------------------- */ 
	/* -------------------------------------------------------------------------------- */ 	
	
	function getallTables()
	{
		$sql = "SELECT * FROM tbltablemanager";
		$result = getconn($sql);
		return $result;	
	}
	
	// **************************************** 
	// Nov 20 
	// retrieve all records from table  
	// sort by name (ascending order) 
	// want results to be paged 
	// can set number of entries to display 
	function getTableRecords($table_name, $currpg, $url)
	{
		$sql="Select * from ".$table_name ." order by name asc";
		// $result = getconn($sql); 
		$pagesize = 10;
		$result = paging($sql, $currpg, $pagesize, $url); 
		return $result;
	}
	// **************************************** 

	// **************************************** 
	// Nov 20 
	// retrieve all records from table  
	// sort by name (ascending order) 
	// want results to populate drop down list 
	function getTableRecordsList($table_name)
	{
		$sql="Select * from ".$table_name;
		$result=getconn($sql); 
		return $result;
	}
	// **************************************** 

	function getTable()
	{
		return $this->m_table;
	}
	
	// ******************** 
	// Nov 13 
	// get table record from table 
	//     $pktable_id	- table name 
	//     $id			- record number 
	function getTableById($pktable_id, $id)
	{
		$sql = "SELECT * FROM " .$pktable_id  ." Where id= " .$id; 
		$result = getconn($sql); 			// execute sql 
		return $result; 					// return result 
	}
	// ******************** 
	
	// ******************** 
	// Nov 20 
	// update record in table 
	//     $pktable_id 	- table name  
	//     $vars 		- attributes & values 
	function updateTableRecord($pktable_id, $vars)
	{
		$id = 'id';							// table key 
		$pktable_id= str_replace(' ','',$pktable_id);  // ensure no spaces in table name 		
		$array = $this->m_table; 			// field names for all tables table 
		if ($pktable_id == "tblneighbourhood") {  // except if neighbourhood table 
			$array = $this->m_table2;		// different field names 
		} 
		$vars = array_intersect_key($vars,$array);	// for update remove extra field names 
		$sql = "Update " .$pktable_id ." Set ";	// sql statement 
		$sql .= UpdateSQL($vars, $id);		// append field names and values 
		$sql .=" where ".$id."=".$vars['id'];	// append record to operate on 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}
	// ******************** 
	
	/* -------------------------------------------------------------------------------- */ 
	/* -------------------------------------------------------------------------------- */ 	
	// Dec 3 
	// delete record from table 
	//     $pktable_id	- table name 
	//     $id			- record number	

	function deleteTableRecord($pktable_id, $id)
	{ 
		$delete_ok = 1;						// to begin with assume can delete 
		
		// consider all entries in reference table 
		// if table entry [x], corresponds to name of table to be deleted 
		//     from construct sql command and execute sql command 
		// if no records returned can    delete 
		// if    records returned cannot delete 
		
		for ($i=0; $i<count($this->m_tablereferences); $i=$i+3) 
		{
			if ($this->m_tablereferences[$i] == $pktable_id) 
			{
				// match on table name in table and table to be deleted from 
				// construct sql command 
				$sql = "select * from " .$this->m_tablereferences[$i+1] ." where " .$this->m_tablereferences[$i+2] ." = " .$id; 
				$result = getConn($sql);	// execute sql command 
				if ($result) {				// if successful 
					$rowcount = mysql_num_rows($result);  // number of records retrieved 
					if ($rowcount > 0) {
						// records returned from read 
						// do not want to delete record 
						$delete_ok = 0; 
					} 
				} else { 					// operation failed 
					$delete_ok = 0; 		// do not want to delete record 
				} 
			} 
		} 
		
		// have processed table name to delete from against 
		//     all [x] entries in reference table 
		if ($delete_ok == 1) { 
			// ok to delete so delete record 
			// construct sql command 
			$sql = "Delete from " .$pktable_id ." Where id = " .$id;  // sql statement 
			$result = getConn($sql);		// execute sql command 
			if (!$result) { 				// if problem with delete 
				$delete_ok = 0; 			// indicate delete not ok 
			} 
		}
		
		return $delete_ok;					// return success/failure indicator 
	}
	/* -------------------------------------------------------------------------------- */ 
	/* -------------------------------------------------------------------------------- */ 	
	
	// ******************** 
	// Nov 20 
	// add record to table 
	//     $pktable_id 	- table name  
	//     $vars 		- attributes & values 
	function createTableRecord($pktable_id, $vars)
	{
		$id = 'id';							// table key 
		$pktable_id= str_replace(' ','',$pktable_id);  // ensure no spaces in table name 		
		$array = $this->m_table; 			// field names for all tables table 
		if ($pktable_id == "tblneighbourhood") {  // except if neighbourhood table 
			$array = $this->m_table2;		// different field names 
		} 
		$vars = array_intersect_key($vars,$array);	// for insert remove extra field names 
		$sql = "Insert into " .$pktable_id; // start of sql statement 
		$sql .= InsertSQL($vars, $id);		// append field names and values 
		$result = getConn($sql);			// execute sql statement 
		return $result;						// return result from sql 
	}
	// ******************** 
}
?>
