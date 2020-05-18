<?php
require_once("conn_function.php");
require_once("sql.php");
require_once("awd_inscriptionComments.php");
require_once("images.php");

class awardClass{
	var $m_award;
	var $m_inscription;
	var $m_image;	
	var $pagesize = 2;
	//constructor
	function awardClass()
	{
		$this->m_award=array( 'pkaward_id'=>"",'awd_recipient'=>"",'awd_desc'=>"",'awdinscrip_content'=>"",'awd_size'=>"",'awd_material'=>"",'awd_style'=>"",'awd_location'=>"",'awd_inaug_date'=>"",'awdinsc_date'=>"",'awd_order_reqd'=>"",'awd_inscript_reqd'=>"",'fkapplication_id'=>"",'primary_img'=>"");
		$this->m_inscription = new awdinscriptionCommentClass();
		$this->m_image = new imageClass();
	}
	
	function createAward($vars)
	{	
		$id='pkaward_id';
		$insert_vars =  array_intersect_key($vars,$this->getAward());
		$insert_inscrip = array_intersect_key($vars,$this->m_inscription->getInscription());
		$sql =" Insert into  tblaward";
		$sql .=InsertSQL($insert_vars,$id);
		$result = getconn($sql);
		$award_id=$this->getLastAwardId();
		if($insert_inscrip['awdinsc_comments'] !="")
		{
			//getawardid
			$insert_inscrip['fkaward_id'] = $award_id;
			$this->m_inscription->createInscriptionComments($insert_inscrip);
		}
		if( (array_key_exists('image_name',$vars)) && ($vars['image_name'] !="") )
		{
			$vars['pkaward_id']=$award_id;
			$vars['fkaward_id']=$award_id;
			$this->m_image->createImage($vars);
		}
		//tom added				
		if($insert_vars['fkapplication_id'] !=0 or $insert_vars['fkapplication_id'] !=""){
			$this->m_application->updateStatus($insert_vars['fkapplication_id']);
		}


		return $result;
		
	}
	
	function getLastAwardId()
	{
		$id=mysql_insert_id();
		return $id;
	}

	function updateAward($vars)
	{	print_r($vars);
		$id='pkaward_id';
		$insert_vars =  array_intersect_key($vars,$this->getAward());
		$insert_inscrip = array_intersect_key($vars,$this->m_inscription->getInscription());
		if($insert_inscrip['awdinsc_comments'] !="")
		{
			//apply the award id to the fk award id
			$insert_inscrip['fkaward_id'] = $insert_vars['pkaward_id'];
			//if inscription already in table then update otherwise create inscription comments
			$result=$this->m_inscription->getInscriptionCommentsByAwardId($insert_inscrip['fkaward_id']);
			$row=mysql_fetch_array($result);
			if($row['pkawardinscription_id'] !=""){
				$insert_inscrip['pkawardinscription_id']=$row['pkawardinscription_id'];
				//call update function
				$this->m_inscription->updateAwardInscription($insert_inscrip);
			}else{
				//call inscription comments add
				$this->m_inscription->createInscriptionComments($insert_inscrip);
			}
		}
		if( (array_key_exists('image_name',$vars)) && ($vars['image_name'] !="") )
		{
			$vars['fkaward_id']=$award_id;
			$this->m_image->createImage($vars);
		}
		$sql="UPDATE tblaward SET ";
		$sql.=UpdateSQL($insert_vars,$id);
		$sql .=" where ".$id."=".$vars[$id];
		$result = getconn($sql);
		return $result;
	}
	function getAwardByID($id)
	{	
		$sql =" select * from tblaward where pkaward_id =".$id;
		//echo $sql;
		$result = getconn($sql);
		return $result;
	}
	function getAllAwards($currpg,$url)
	{
		$sql="Select * from tblaward order by awd_recipient asc";
		$result = paging($sql,$currpg,$this->pagesize,$url); 
		return $result;
	}	
	function getAllAward()
	{
		$sql="Select * from tblaward order by awd_recipient asc ";
		$result = getconn($sql); 
		return $result;
	}

	function getAward()
	{
		return $this->m_award;
	}
	function getAwardByAppId($id)
	{
		$sql="Select * from tblaward where fkapplication_id=".$id;
		$result = getconn($sql);
		return $result;

	}

	function getInscriptionByAwardId($pkaward_id)
	{
		$result=$this->m_inscription->getInscriptionByAwardId($pkaward_id);
		return $result;

	}	
	function getInscriptionCommentsByAwardId($pkaward_id)
	{
		$result=$this->m_inscription->getInscriptionCommentsByAwardId($pkaward_id);
		return $result;
	
	}
	function getRelationshipAward($img_id)
	{ 
			$sql="Select fkaward_id from tblimageaward where fkimage_id=".$img_id; 
			$result=getconn($sql);  
			return $result;
	}
	function removeAwardImage($pid,$imgid)
	{
			$sql="Delete from tblimageaward where fkaward_id=".$pid. " and fkimage_id=".$imgid ;
			//echo $sql;
			$result = getconn($sql);
			return $result;		
	}
	function checkPrimaryAwardImage($pid,$imgid)
	{
			$sql="Select pkaward_id from tblaward where pkaward_id=".$pid. " and primary_img=".$imgid ;
			$result = getconn($sql);
			return $result;		
	}
	function setPrimaryAwardImage($pid)
	{
			$sql="Update tblaward set primary_img=0 where pkaward_id=".$pid;
			$result = getconn($sql);
			return $result;		

	}
	function getAwardsByCriteria($vars,$currpg,$url)
	{
			// start sql command 
			$sql="select * from tblaward A  where "; 
			// check for search on keyword 
			if ($vars['keywd'] != "") 
			{
				// include sql for keyword search in sql command 
				$sql .=	" A.awdinscrip_content like '%%%" .$vars['keywd']. "%%%' or A.awd_desc like '%%%" . $vars['keywd'] ."%%%' or A.awd_recipient like '%%%". $vars['keywd'] ."%%%' "; 
				// check for search on inscription or dates 
				if (($vars['awd_inscript_reqd'] != "") or (($vars['start_date']!="") and ($vars['end_date']!=""))) { 
					// if search on inscription or date include "and" in sql command 
					$sql .= " and "; 
				} 
			} 
			
			// check if search on date range 
			if (($vars['start_date'] != "") and ($vars['end_date'] != "")) { 
				// include sql for date range search in sql command 
				$sql .= " ((A.awd_inaug_date >='".$vars['start_date']."' and A.awd_inaug_date <='".$vars['end_date']."') or (A.awdinsc_date >='".$vars['start_date']."' and A.awdinsc_date <='".$vars['end_date']."'))"; 
				// check if search on inscription required 
				if ($vars['awd_inscript_reqd'] != "") { 
					// if search on inscription include "and" in sql command 
					$sql .= " and "; 
				}
			}

			// check for search on inscription 
			if ($vars['awd_inscript_reqd'] !="" ) { 
				// include sql for inscription search in sql command 
				$sql .= " A.awd_inscript_reqd='".$vars['awd_inscript_reqd']."'";
			}
	
			// include sql to sort result 
			$sql .=" ORDER BY A.awd_recipient Asc";
			//echo $sql; 
			$result = paging($sql,$currpg,$this->pagesize,$url); 
			return $result;
	} 

	function getAwardsByYearCriteria($vars,$currpg,$url)
	{
			$sql="select * from tblaward A  where ";
			if($vars['keywd'] !="")
			{
				$sql .=	" A.awdinscrip_content like '%%%" .$vars['keywd']. "%%%' or A.awd_desc like '%%%" . $vars['keywd'] ."%%%' or A.awd_recipient like '%%%". $vars['keywd'] ."%%%' ";
			}
			if( ($vars['year'] !="") and ($vars['keywd'] !="")){ $sql .= " and ";}
			if($vars['year'] !=""){
				$sql .= " year(A.awd_inaug_date) >='".$vars['year']."'";
			}
			if(($vars['year'] !="") and ($vars['year2'] !="")){ $sql .= " and ";}

			if($vars['year2'] !=""){
				$sql .= " year(A.awd_inaug_date) <='".$vars['year2']."'";
			}
			if(array_key_exists('awd_inscript_reqd',$vars)){
				if( ($vars['awd_inscript_reqd'] != "") and (($vars['year'] !="") or ($vars['year2'] !=""))){ 
						// if search on inscription include "and" in sql command 
						$sql .= " and "; 
				}
				// check for search on inscription 
				if ($vars['awd_inscript_reqd'] !="" ) { 
					// include sql for inscription search in sql command 
					$sql .= " A.awd_inscript_reqd='".$vars['awd_inscript_reqd']."'";
				}
			}

			$sql .=" ORDER BY A.awd_recipient Asc";
			//echo $sql;
			$result = paging($sql,$currpg,$this->pagesize,$url); 
			return $result;
		} 

}

?>