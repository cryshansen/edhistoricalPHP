<?php
require_once("conn_function.php");
require_once("sql.php");

class installationClass{
	
 var $m_installation;
 
 
 		//constructor
		 function installationClass()
		 {
			 $this->m_installation=array( 'pkplaqueinstallation_id'=>"",  'plqinst_comments'=>"",  'plqinst_date'=>"",  'fkvendor_id'=>"",  'fkplaque_id'=>"");
		 }
		  
		 function createInstallation($installation_vars){
	
			//define the array key for primary key		
			$id='pkplaqueinstallation_id';		
			//convert the password to a hash (not needed for other classes)
			$insert_vars =  array_intersect_key($installation_vars,$this->getInstallation() );
			//create initial sql call		
			$sql = "INSERT INTO tblplaqueinstallation "; 		
			//concatenate and call sql function from sql.php pass in the vars from post and the id defined above.		
			$sql .=InsertSQL($insert_vars,$id);		
			// call getconn function defined in conn_function .php your mysql database and passwords/username
			//echo $sql;
			$result = getconn($sql);		
			//return the success or failure		
			return $result;	
		}

			
		  function updateInstallation($vars){
			  
					  //define the array key for primary key		
				$id='pkplaqueinstallation_id';
					
				$insert_vars =  array_intersect_key($vars,$this->getInstallation());	
				$sql="UPDATE tblplaqueinstallation SET ";
				
				//concatenate and call sql function from sql.php pass in the vars from post and the id defined above 		
				$sql.=UpdateSQL($insert_vars,$id);
				
				//concatenate where clause		
				$sql .=" where ".$id."=".$vars[$id];
					
				// call getconn function defined in conn_function .php your mysql database and passwords/username
					
				$result = getconn($sql);
				
				//return the success or failure
				//echo $sql;
						
				return $result;
			  }
		  function getAllInstallation(){
			  // simple select statement
				$sql="Select * from tblplaqueinstallation";
					
				// call getconn function defined in conn_function .php your mysql database and passwords/username
					
				$result=getconn($sql);
				
				//return the recordset or failure
						
				return $result;
				
		}
		function getInstallationById($id){
					  // simple select statement		
				$sql="Select * from tblplaqueinstallation WHERE pkplaqueinstallation_id=".$id;
				
				// call getconn function defined in conn_function .php your mysql database and passwords/username
						
				$result=getconn($sql);
					
				//returns recordset or failure	
				return $result;
		 }
		 function getinspectionbydatebyplaqueid($id)
		 {
			 $date = getDate();
			 $year = $date['year'];
			 $sql="SELECT * FROM tblplaqueinstallation WHERE fkplaque_id = ".$id . " AND YEAR( plqinst_date ) ='". $year."'";

			 $result=getconn($sql);
			//echo $sql;		
			//returns recordset or failure	
			 return $result;
			}
		 //getter
		 function getInstallation()
		 {
		 	return $this->m_installation;
		 }


 }
  
?>
