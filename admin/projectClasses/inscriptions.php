<?php
require_once("conn_function.php");
require_once("sql.php");

//these are the comments
class inscriptionCommentsClass
//opening chicken lip :o
{
	
var $m_inscription;

	//constructor
	function inscriptionCommentsClass()
	{
		$this->m_inscription = array('pkplaqueinscription_id'=>"", 'plqinsc_comments'=>"",'plqcomment_date'=>"", 'fkplaque_id'=>"");

	}

	//Add the Plaque Inscription Comments
	function createInscriptionComments($vars)
	{
		//define the array key for primary key		
		$id='pkplaqueinscription_id';	
		$vars['plqcomment_date']= "NOW()";	
		//create initial sql call		
		$sql = "INSERT INTO tblplaqueinscription "; 		
		$sql .=getKeys($vars,$id);	
		$sql .= sanitizeString($vars['plqinsc_comments']);
		$sql .="," . $vars['fkplaque_id'];
		$sql .=",".$vars['plqcomment_date'];	
		$sql .=")" ;
		//echo $sql;
		// call getconn function defined in conn_function .php your mysql database 		
		$result = getconn($sql);		
		//return the success or failure		
		return $result;	
	}

	//Update the Plaque Inscription
	function updateInscriptionComments($vars)
	{
	print_r($vars);
		//define the array key for primary key		
		$id='pkplaqueinscription_id';		
		//create initial sql call to do the plaque inscription updating	
		$sql = "Update tblplaqueinscription SET "; 		
		//concatenate and call sql function from sql.php pass in the vars from post and the id defined above.		
		$sql .=UpdateSQL($vars,$id);
		// make sure the the pkplaqueinscription_id sent in the array matches the id in the table
		$sql .= " where ".$id."=".$vars[$id];
		//use the echo to view the values being passed to the table
		//echo $sql;
		// call getconn function defined in conn_function .php your mysql database and passwords/username		
		$result = getconn($sql);		
		//return the success or failure		
		return $result;
	}
	
	//Get the Plaque Inscription names) 
	function getInscriptions()
	{
		//select all the plaque inscriptions and all fields from the tblPlaqueInscription table	
		$sql="Select * from tblplaqueinscription";
		//collect the results
		$result=getconn($sql);
		//send the results if the query to the display page
		return $result;
	}

	//Get the Plaque Inscription Name by id NameById 
	function GetInscriptionByInscriptionId($id)
	{
		//make the select call to the table
		$sql="Select * from tblplaqueinscription where pkplaqueinscription_id =".$id;
		//collect the results from the query
		$result=getconn($sql);
		//send the results to the display page
		return $result;
	}
	function GetInscriptionByPlaqueId($id)
	{
		//make the select call to the table
		$sql="Select * from tblplaqueinscription where fkplaque_id =".$id;
		//collect the results from the query
		$result=getconn($sql);
		//send the results to the display page
		return $result;
	}
//the function above does the same as this function
	function GetInscriptionCommentsByPlaqueId($id)
	{
		//make the select call to the table
		$sql="Select * from tblplaqueinscription where fkplaque_id=".$id;
		//collect the results from the query
		$result=getconn($sql);
		//send the results to the display page
		return $result;
	}

	//getter
	function getInscriptionComments()
	{
		return $this->m_inscription;
	}
	
	
}//close chicken lip LOL
?>