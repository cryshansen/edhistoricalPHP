<?php
require_once("conn_function.php");
require_once("sql.php");

class applicationHistoryClass{

var $history_vars;

	//constructor
	function applicationHistoryClass()
	{
		$this->history_vars=array('pkhistory_id'=>"",'hist_comments'=>"",'history_date'=>"",'fkapplication_id'=>"");
	}
	
	function addHistoryComments($history_comments,$id)
	{
		$sql="Insert into tblapplication_history (hist_comments,history_date,fkapplication_id) Values ('".$history_comments."',NOW( ),'".$id."')";
		//echo $sql;
		$result=getconn($sql);
		return $result;
	
	}
	function updateHistoryComments($hist_vars)
	{
			$id='pkhistory_id';

			$sql="UPDATE tblapplication_history SET ";
			$sql.=UpdateSQL($hist_vars,$id);
			$sql .=" where ".$id."=".$hist_vars[$id];
			//echo $sql;
			$result = getconn($sql);
			return $result;
	}
	function getHistoricalComments($id)
	{
		$sql="Select * from tblapplication_history where fkapplication_id=".$id ;
		//echo $sql;
		$result=getconn($sql);
		return $result; 
	
	
	}
	function getApplicationHistory()
	{
		return $this->history_vars;
	
	}


}

?>
