<?php
require_once("conn_function.php");
require_once("sql.php");

//these are the comments
class awdinscriptionCommentClass
//opening chicken lip :o
{
	
var $m_inscription;

	//constructor
	function awdinscriptionCommentClass()
	{
		$this->m_inscription = array('pkawardinscription_id'=>"", 'awdinsc_comments'=>"", 'awdcomment_date'=>"", 'fkaward_id'=>"");

	}

	//Add the Award Inscription
	function createInscriptionComments($vars)
	{
		//define the array key for primary key		
		$id='pkawardinscription_id';
		$vars['awdcomment_date']= "NOW()";	
		//create initial sql call		
		$sql = "INSERT INTO tblawardinscription "; 		
		//concatenate and call sql function from sql.php pass in the vars from post and the id defined above.		
		$sql .=getKeys($vars,$id);	
		$sql .= sanitizeString($vars['awdinsc_comments']);
		$sql .="," . $vars['fkaward_id'];
		$sql .=",".$vars['awdcomment_date'];	
		$sql .=")" ;
		// call getconn function defined in conn_function .php your mysql database 		
		$result = getconn($sql);		
		//return the success or failure		
		return $result;	
	}

	//Update the Award Inscription
	//use the print to view the post variables being sent to the db
	//print_r($vars);
	//star the updateAwardInscription for the Award inscription updating
	function updateAwardInscription($vars)
	{	
		//define the array key for primary key		
		$id='pkawardinscription_id';		
		//create initial sql call to do the Award inscription updating	
		$sql = "Update tblawardinscription SET "; 		
		//concatenate and call sql function from sql.php pass in the vars from post and the id defined above.		
		$sql .=UpdateSQL($vars,$id);
		// make sure the the pkawardinscription_id sent in the array matches the id in the table
		$sql .= " where ".$id."=".$vars[$id];
		// call getconn function defined in conn_function .php your mysql database and passwords/username		
		$result = getconn($sql);		
		//return the success or failure		
		return $result;
	}
	
	//Get the Award Inscription names) 
	function getInscriptions()
	{
		//select all the Award inscriptions and all fields from the tblawardinscription table	
		$sql="Select * from tblawardinscription";
		//collect the results
		$result=getconn($sql);
		//send the results if the query to the display page
		return $result;
	}

	//Get the Award Inscription Name by id NameById 
	function GetInscriptionByInscriptionId($id)
	{
		//make the select call to the table
		$sql="Select * from tblawardinscription where pkawardinscription_id =".$id;
		//collect the results from the query
		$result=getconn($sql);
		//send the results to the display page
		return $result;
	}
	function getInscriptionCommentsByAwardId($pkaward_id)
	{
		//make the select call to the table
		$sql="Select * from tblawardinscription where fkaward_id =".$pkaward_id;
		//collect the results from the query
		$result=getconn($sql);
		//send the results to the display page
		return $result;	
	}

	//getter
	function getInscription()
	{
		return $this->m_inscription;
	}
	
	
}//close chicken lip LOL
?>