<?php
require_once("conn_function.php");
require_once('sql.php');

class userClass{

var $user_var;
var $pagesize=10;

	//constructor
	function userClass()
	{
		$this->user_var=array('pkuser_id'=>"",'fkuser_group_id'=>"",'user_first_name'=>"" , 'user_last_name'=>"",'user_name'=>"",'user_password'=>"",'email'=>"");
	}
	function user_create($vars)
	{
		$id='pkuser_id';
		$vars['user_password']=md5($vars['user_password']);
		$sql = "INSERT INTO tbluser "; 
		$sql .=InsertSQL($vars,$id);
		$result = getconn($sql);
		return $result;
	}
	
	function updateUser($vars)
	{
		$id='pkuser_id';
		$insert_vars =  array_intersect_key($vars, $this->getUser());
		$sql="UPDATE tbluser SET ";
		$sql.=UpdateSQL($insert_vars,$id);
		$sql .=" where ".$id."=".$vars[$id];
		//echo $sql;
		$result = getconn($sql);
		return $result;
	}
	function check_UserByEmail($email)
	{
		$sql = "SELECT * FROM tbluser WHERE email ='".$email."'" ;
		//echo $sql;
		$result = getconn($sql);
		return $result;
	}
	function get_Password($username){
		$sql = "SELECT fkuser_group_id,user_password, pkuser_id FROM tbluser WHERE user_name  = '".$username."'" ;
		//echo $sql;
		$result = getconn($sql);
		return $result;

	}
	function check_Username($username){
		$sql = "SELECT user_name FROM tbluser WHERE user_name  = '".$username."'" ;
		//echo $sql;
		$result = getconn($sql);
		return $result;	
	}
	function getUserById($id)
	{
		$sql="Select * from tbluser WHERE pkuser_id=".$id;
		$result=getconn($sql);
		return $result;
	}
	function getUserGroup()
	{
		$sql="Select * from tbluser_group";
		$result=getconn($sql);
		return $result;
	}
	
	// User List
	function getAllUsers($currpg,$url)
	{
		$sql = "SELECT tbluser.*,name FROM tbluser INNER JOIN tbluser_group  ON fkuser_group_id = id ORDER BY user_name";
		$result = paging($sql,$currpg,$this->pagesize,$url); 
		return $result;
	}
	function getUsersByCriteria($keyword_text)
	{
		$sql="select tbluser.*,name from tbluser INNER JOIN tbluser_group ON fkuser_group_id = id where user_name like '%%%".$keyword_text."%%%' or user_first_name like '%%%".$keyword_text."%%%' or user_last_name like '%%%".$keyword_text."%%%' ORDER BY user_name";
		$result = getconn($sql);
		return $result;
	}
	function getUser()
	{
		return $this->user_var;
	}
	
	
	

}

?>
