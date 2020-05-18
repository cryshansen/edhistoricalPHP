<?php
require_once("conn_function.php");
//include_once ('creds.php');
require_once("sql.php");

class applicantClass{
	
var $applicant_vars;
var $pagesize=10;

	//constructor
	function applicantClass()
	{ 
		$this->applicant_vars=array('pkapplicant_id'=>"",'contact_lname'=>"",'contact_fname'=>"",'app_type'=>"",'organization_name'=>"",'address'=>"",'phone'=>"",'phone2'=>"",'fax'=>"",'email'=>"",'foip'=>"");

	}
	function createApplicant($applicant_vars)
	{	$id='pkapplicant_id';
		$sql =" Insert into  tblapplicant";
		$sql .=InsertSQL($applicant_vars,$id);
		//echo $sql;
		$result = getconn($sql);
		return $result;
	}
	function updateApplicant($vars)
	{	
		//print_r($vars);
		$id='pkapplicant_id';
		$sql="UPDATE tblapplicant SET ";
		$sql.=UpdateSQL($vars,$id);
		$sql .=" where ".$id."=".$vars[$id];
		//echo $sql;
		$result = getconn($sql);
		return $result;
	}
	
	function getAllApplicants($currpg,$url)
	{
		$sql="Select * from tblapplicant Order By contact_fname, contact_lname";
		$result = paging($sql,$currpg,$this->pagesize,$url); 
		return $result;
	}
		function getAllApplicant()
	{
		$sql="Select * from tblapplicant Order By contact_fname, contact_lname";
		$result = getconn($sql); 
		return $result;
	}

	function getApplicantById($id)
	{
		$sql="Select * from tblapplicant where pkapplicant_id =".$id;
		$result=getconn($sql);
		return $result;
	}
	
	function getLastApplicantId()
	{
		$id=mysql_insert_id();
		$result=getconn($sql);
		return $id;
	}
	function getApplicantByCriteria($vars,$currpg,$url)
	{		
			$sql="select * from tblapplicant where contact_lname like '%%%" .$vars['keywd']. "%%%' or contact_fname like '%%%" . $vars['keywd'] ."%%%' or organization_name like '%%%". $vars['keywd'] ."%%%' or address like '%%%".$vars['keywd']. "%%%' ORDER BY organization_name, contact_fname, contact_lname";
			//echo $sql;
			$result = paging($sql,$currpg,$this->pagesize,$url); 
			return $result;
	}
	
	function getApplicant()
	{
		return $this->applicant_vars;
	}
}
?>
