<?php
require_once("conn_function.php");
require_once("sql.php");
require_once("applicants.php");
require_once("application_historys.php");

class applicationClass{
var $app_pre_vars;
var $m_applicant;
var $m_history;
var $pagesize = 10;

	
	//constructor
	function applicationClass()
	{
		$this->app_pre_vars=array('pkapplication_id'=>"",'site_name'=>"",'app_fname'=>"",'app_lname'=>"",'app_address'=>"",'phone_bus'=>"",'phone_res'=>"",'app_fax'=>"",'app_email'=>"",'application_type'=>"",'app_date'=>"",'app_description'=>"",'app_biography'=>"",'supporting_material'=>"",'fkapplicant_id'=>"",'fkapplication_status_id'=>"",'fkhistorical_id'=>"");
		$this->m_applicant= new applicantClass();
		$this->m_history= new applicationHIstoryClass();
	}
	//getter
	function getApplication()
	{
		return $this->app_pre_vars;
	}

	
	function createApplication($post_vars)
	{	
		//separate the arrays
		$application_vars =  array_intersect_key($post_vars,$this->getApplication());
		$applicant_vars =  array_intersect_key($post_vars,$this->m_applicant->getApplicant());
		$hist_vars=array_intersect_key($post_vars,$this->m_history->getApplicationHistory());
		//call applicant insert
		if($applicant_vars['pkapplicant_id'] =='new'){
			$results=$this->m_applicant->createApplicant($applicant_vars);
		}else{
			$results=$this->m_applicant->updateApplicant($applicant_vars);
		}
		
			if($results){
			//return last value
				if($applicant_vars['pkapplicant_id'] =='new'){
					$applicant_id=$this->m_applicant->getLastApplicantId();
					//echo "The Applicants Id is: " .$applicant_id;
					$application_vars['fkapplicant_id'] = $applicant_id;
					$id='pkapplication_id';
					//insert into application
					$sql =" Insert into  tblapplication";
					$sql .=InsertSQL($application_vars,$id);
					//echo $sql;
					$result = getconn($sql);
					if(($result)&&($hist_vars['hist_comments']!='')){
						$application_id=$this->getLastApplicationId();
						//echo "The application ID is:".$application_id;
						$this->m_history->addHistoryComments($hist_vars['hist_comments'],$application_id);
					}

				}else{
					//set the applicant foreign key in array
					$application_vars['fkapplicant_id'] = $applicant_vars['pkapplicant_id'];
					$id='pkapplication_id';
					//insert into application
					$sql =" Insert into  tblapplication";
					$sql .=InsertSQL($application_vars,$id);
					$result = getconn($sql);
					if(($result)&& ($hist_vars['hist_comments']!='')){
						$application_id=$this->getLastApplicationId();
						$this->m_history->addHistoryComments($hist_vars['hist_comments'],$application_id);
					}
				}
			}
		return $result;
	}
	function updateApplication($post_vars)
	{	
		
		$id='pkapplication_id';
		$application_vars =  array_intersect_key($post_vars,$this->getApplication());
		//print_r($application_vars);
		$hist_vars=array_intersect_key($post_vars,$this->m_history->getApplicationHistory());
		if($hist_vars['hist_comments']!='')
		{
			//assign fkapplicationid
			$hist_vars['fkapplication_id']=$application_vars['pkapplication_id'];
			//check to see if comments exist in db based on fkapplication id
			$result=$this->m_history->getHistoricalComments($hist_vars['fkapplication_id']);
			$row=mysql_fetch_array($result);
			if($row['pkhistory_id'] !="")
			{
				$hist_vars['pkhistory_id']=$row['pkhistory_id'];
				//echo "update the comments ";
				$results=$this->m_history->updateHistoryComments($hist_vars);
			}else{
				$results=$this->m_history->addHistoryComments($hist_vars['hist_comments'],$hist_vars['fkapplication_id']);
			}
			$sql="UPDATE tblapplication SET ";
			$sql.=UpdateSQL($application_vars,$id);
			$sql .=" where ".$id."=".$application_vars[$id];
			//echo $sql;
			$result = getconn($sql);
		}
		return $result;
	}
		//tom add
	function updateStatus($fkapp_id)
	{
		$sql="UPDATE tblapplication SET fkapplication_status_id = 4 where pkapplication_id =".$fkapp_id;		
		$result=getconn($sql);
		//echo $sql;
		return $result;		
	}

	function getAllApplications($currpg,$url)
	{ 
		$sql="Select * from tblapplication A, tblapplication_status ASS where ASS.id = A.fkapplication_status_id order by site_name, app_fname, app_lname ";
		$result = paging($sql,$currpg,$this->pagesize,$url); 
		return $result;
	}
	function getApplicationById($id)
	{
		$sql="Select * from tblapplication inner join tblapplicant on fkapplicant_id=pkapplicant_id where  pkapplication_id =".$id;
	//  echo $sql;
		$result=getconn($sql);
		return $result;
	}
	function getApplicationForReport($id)
	{
		$sql="Select * from tblapplication A inner join tblapplicant T on A.fkapplicant_id=T.pkapplicant_id INNER JOIN tblapplication_status S ON A.fkapplication_status_id = S.id INNER JOIN tblapplication_history Y ON A.fkhistorical_id  = Y.pkhistory_id  and pkapplication_id =".$id;
		$result=getconn($sql);
		return $result;

	}
	function getApplicationNameById($id)
	{
		$sql="Select site_name from tblapplication where  pkapplication_id =".$id;
		$result=getconn($sql);
		return $result;

	}
	function getApplicationStatus(){
	
		$sql="Select * from tblapplication_status order by name" ;
		$result=getconn($sql);
		return $result; 
	
	}
	function getHistoricalEvent()
	{
		$sql="Select * from tblhistorical_event order by name" ;
		$result=getconn($sql);
		return $result; 

	}
	function getHistoricalEventById($id)
	{
		$sql="Select name from tblhistorical_event inner join tblapplication on fkhistorical_id=id  where pkapplication_id =".$id;
		$result=getconn($sql);
		return $result; 

	}

	function getHistoricalComments($id)
	{
		$sql="Select * from tblapplication_history where fkapplication_id=".$id ;
		$result=getconn($sql);
		return $result; 
	}
	function getLastApplicationId()
	{
		$id=mysql_insert_id();
		//echo "Application ID is:" .$id;
		return $id;
	}
	function getApplicationByNominator($id)
	{
		$sql="Select * from tblapplication where fkapplicant_id=".$id;
		$result=getconn($sql);
		return $result; 	
	}

	function getApplicationsByCriteria($vars,$currpg,$url)
	{		
			$start_year=$vars['start_year']; 
			$end_year=$vars['end_year']; 
			// initialize for search on year 
			// if both start year and end year blank do not search on year 
			// if start year blank start search at beginning and end on end year 
			// if end year blank start search on start year and end after current year 
			
			if (($vars['start_year']==0) or ($vars['end_year']==0)) { 
				// either start year is not blank or end year is not blank 
				if ($start_year==0) { 
					// start year is blank, initialize to first year for data  
					$start_year=1975; 
				}
				if ($end_year==0) { 
					// end year is blank, initialize to year after current year 
					$date=getdate();
					$end_year= $date['year'];
				} 
			} 	
			// start sql command 
			$sql="select A.*, ASS.name from tblapplication A inner join tblapplication_status ASS on A.fkapplication_status_id = ASS.id where ";

			
			// check for search on keyword 
			if($vars['keywd'] !="")
			{	// include search on description, biograph, supporting material 
				$sql .=	" (A.site_name like '%%%" .$vars['keywd']. "%%%' or  A.app_fname like '%%%" .$vars['keywd']. "%%%'  or  A.app_lname like '%%%" .$vars['keywd']. "%%%' or A.app_description like '%%%" .$vars['keywd']. "%%%' or A.app_biography like '%%%" . $vars['keywd'] ."%%%' or A.supporting_material like '%%%". $vars['keywd'] ."%%%')";
			}
			
			// if search on location or keyword and dates include "and" in sql command  
			if(($vars['keywd'] !="") and (($start_year !='') and ($end_year !=''))) { $sql .= " and ";} 
			
			// if search on dates include date search in sql command 
			if(($start_year !="") and ($end_year !="")) {
				$sql .= "YEAR(A.app_date) >='".$start_year."' and A.app_date <='".$end_year."'";
			}
			
			// if search on location or keyword or dates and application status id include "and" in sql command 
			if((($vars['keywd'] !="") or (($start_year !='') and ($end_year !=''))) and ($vars['fkapplication_status_id'] !='')){ $sql .= " and ";}

			// if search on application status id include in sql command 
			if($vars['fkapplication_status_id'] !="") {
				$sql .= " A.fkapplication_status_id='".$vars['fkapplication_status_id']."'";
			}

			// if search on location or keyword or dates or application status id 
			// and application type include "and" in sql command
			
		 
			$sql .=" ORDER BY A.site_name, A.app_fname, A.app_lname ASC";
			echo $sql;
			$result = paging($sql,$currpg,$this->pagesize,$url); 
			return $result;
	}
		function getApplicationsByCriteria2($vars,$currpg,$url)
		{			//$location=""; site award name applicant name 
			$start_year=$vars['start_year']; 
			$end_year=$vars['end_year']; 
			// initialize for search on year 
			// if both start year and end year blank do not search on year 
			// if start year blank start search at beginning and end on end year 
			// if end year blank start search on start year and end after current year 
			
			if (($vars['start_year']==0) or ($vars['end_year']==0)) { 
				// either start year is not blank or end year is not blank 
				if ($start_year==0) { 
					// start year is blank, initialize to first year for data  
					$start_year=1975; 
				}
				if ($end_year==0) { 
					// end year is blank, initialize to year after current year 
					$date=getdate();
					$end_year= $date['year'];
				} 
			} 	
			$sql="select A.*, ASS.name from tblapplication A inner join tblapplication_status ASS on A.fkapplication_status_id = ASS.id where ";

			if($vars['keywd'] !="")
			{	// include search on description, biograph, supporting material 
				$sql .=	" (A.site_name like '%%%" .$vars['keywd']. "%%%' or  A.app_fname like '%%%" .$vars['keywd']. "%%%'  or  A.app_lname like '%%%" .$vars['keywd']. "%%%' or A.app_description like '%%%" .$vars['keywd']. "%%%' or A.app_biography like '%%%" . $vars['keywd'] ."%%%' or A.supporting_material like '%%%". $vars['keywd'] ."%%%')";
			}
			
			// if search on location or keyword and dates include "and" in sql command  
			if(($vars['keywd'] !="") and (($start_year !='') and ($end_year !=''))) { $sql .= " and ";} 
			
			// if search on dates include date search in sql command 
			if(($start_year !="") and ($end_year !="")) {
				$sql .= "YEAR(A.app_date) >='".$start_year."' and YEAR(A.app_date) <='".$end_year."'";
			}
			
			// if search on location or keyword or dates and application status id include "and" in sql command 
			if((($vars['keywd'] !="") or (($start_year !='') and ($end_year !=''))) and ($vars['fkapplication_status_id'] !='')){ $sql .= " and ";}

			// if search on application status id include in sql command 
			if($vars['fkapplication_status_id'] !="") {
				$sql .= " A.fkapplication_status_id='".$vars['fkapplication_status_id']."'";
			}

			// if search on location or keyword or dates or application status id 
			// and application type include "and" in sql command
			if((($vars['keywd'] !="") or (($start_year !='') and ($end_year !='')) or ($vars['fkapplication_status_id'] !='')) and ($vars['awdplq'] !="")) { $sql .= " and ";}

			// if search on application type include in sql command 
			if($vars['awdplq'] !="") { 
				$sql .= " A.application_type='".$vars['awdplq']."'"; 
			}

			// add sorting to sql command 
			$sql .=" ORDER BY A.site_name, A.app_fname, A.app_lname ASC";
			//echo $sql;
			$result = paging($sql,$currpg,$this->pagesize,$url); 
			return $result;
	}
	/* -------------------------------------------------------------------------------- */ 
	/* -------------------------------------------------------------------------------- */ 
	// Dec 2 
	// retrieve application status using application status id in application record as key 
	
	function getApplicationStatusbyId($id) 
	{
		$sql="Select * from tblapplication_status where id=".$id;
		$result=getconn($sql);
		return $result; 
	}
}
?>
