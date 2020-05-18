<?php 

require_once("conn_function.php");
require_once("sql.php");
require_once("inspections.php");
require_once("inscriptions.php");
require_once("installations.php");
require_once("restorations.php");
require_once("images.php");


class plaqueClass{
	var $m_plaque;
	var $m_inscription;
	var $m_restoration;
	var $m_inspection;
	var $m_Installation;
	var $m_PlaqueRestoration;
	var $m_landplaque;
	var $m_image;
	var $pagesize=10;
	
	//constructor
	function plaqueClass()
	{
		$this->m_plaque=array('pkplaque_id'=>"",'plq_recipient'=>"",'plq_desc'=>"",'plq_inscription'=>"",'plq_size'=>"",'plq_material'=>"",'plq_style'=>"",'fkplaquetypeid'=>"",'plq_location'=>"",'plq_longitude'=>"",'plq_latitude'=>"",'plq_inaug_date'=>"",'plqinsc_date'=>"",'plq_order_reqd'=>"",'plq_instal_reqd'=>"",'plq_inspect_reqd'=>"",'plq_inscript_reqd'=>"",'plq_restore_reqd'=>"",'fkapplication_id'=>"",'primary_img'=>"");
		$this->m_landplaque = array('pklandmarkplaque_id'=>"",'fklandmark_id'=>"",'fkplaque_id'=>"");
		$this->m_inspection = new inspectionClass();
		$this->m_inscription = new inscriptionCommentsClass();
		$this->m_PlaqueRestoration = new plaquerestorationsClass();
		$this->m_Installation = new installationClass();
		$this->m_image = new imageClass();
	}
//GETTER
	function getPlaque()
	{
		return $this->m_plaque;
	
	}


//--------------------------------------		 CRUDS			 -----------------------------------------------//
			function createPlaque($vars)
			{	$id='pkplaque_id';
				if(array_key_exists('dLg',$vars) and array_key_exists('mLg',$vars) and array_key_exists('sLg',$vars) )
				$vars['plq_longitude']= getdecimalval($vars['dLg'],$vars['mLg'],$vars['sLg']);
				if(array_key_exists('dLt',$vars) and array_key_exists('mLt',$vars) and array_key_exists('sLt',$vars) )
				$vars['plq_latitude']= getval2($vars['dLt'],$vars['mLt'],$vars['sLt']);
				$insert_vars =  array_intersect_key($vars,$this->getPlaque());
				$inscriptcomment_vars =  array_intersect_key($vars,$this->m_inscription->getInscriptionComments());
				$sql =" Insert into  tblplaque";
				$sql .=InsertSQL($insert_vars,$id);
				$result = getconn($sql);
				$plaque_id=$this->getLastPlaqueId();
				if(array_key_exists('fklandmark_id',$vars))
				{
					//insert into associate table landmark/plaqueid
					$landplaque_vars= array('fklandmark_id'=>$vars['fklandmark_id'],'fkplaque_id'=>$plaque_id);
					$this->addLandmarktoPlaque($landplaque_vars);
				}

				if($inscriptcomment_vars['plqinsc_comments'] !="")
				{
					//get plaque id 
					$inscriptcomment_vars['fkplaque_id'] = $plaque_id;
					$this->m_inscription->createInscriptionComments($inscriptcomment_vars);
				}
				if( (array_key_exists('image_name',$vars)) && ($vars['image_name'] !="") )
				{
					$vars['pkplaque_id']=$plaque_id;
					$vars['fkplaque_id']=$plaque_id;
					$this->m_image->createImage($vars);
					//$imgid=$this->m_image->getLastImageId();
					//add to associate table.
					//$this->m_image->addPlaqueImage($imgid,$plaque_id);
				}
								//tom added
				if($insert_vars['fkapplication_id'] !=0 or $insert_vars['fkapplication_id'] !=""){
					$this->m_application->updateStatus($insert_vars['fkapplication_id']);
				}


				return $result;
			}
			function getLastPlaqueId()
			{
				$id=mysql_insert_id();
				return $id;
			}
	
		
			function updatePlaque($vars)
			{	
				//print_r($vars);
				$id='pkplaque_id';
				if(array_key_exists('dLg',$vars) and array_key_exists('mLg',$vars) and array_key_exists('sLg',$vars) )
				$vars['plq_longitude']= getdecimalval($vars['dLg'],$vars['mLg'],$vars['sLg']);
				if(array_key_exists('dLt',$vars) and array_key_exists('mLt',$vars) and array_key_exists('sLt',$vars) )
				$vars['plq_latitude']= getval2($vars['dLt'],$vars['mLt'],$vars['sLt']);
				$insert_vars =  array_intersect_key($vars,$this->getPlaque());
				if(array_key_exists('fklandmark_id',$vars))
				{
					//insert into associate table landmark/plaqueid
					$landplaque_vars= array('fklandmark_id'=>$vars['fklandmark_id'],'fkplaque_id'=>$vars['pkplaque_id']);
					$this->addLandmarktoPlaque($landplaque_vars);
					
				}
				if(array_key_exists('plqinsc_comments',$vars))
				{
					$inscriptcomment_vars =  array_intersect_key($vars,$this->m_inscription->getInscriptionComments());
					if($inscriptcomment_vars['plqinsc_comments'] !="")
					{
						//get plaque id 
						$inscriptcomment_vars['fkplaque_id'] = $insert_vars[$id];
						//if inscription already in table then update otherwise create inscription comments
						$result=$this->m_inscription->GetInscriptionByPlaqueId($inscriptcomment_vars['fkplaque_id']);
						$row=mysql_fetch_array($result);
						if($row){
							$inscriptcomment_vars['pkplaqueinscription_id']=$row['pkplaqueinscription_id'];
							$this->m_inscription->updateInscriptionComments($inscriptcomment_vars);
						}else{
							$this->m_inscription->createInscriptionComments($inscriptcomment_vars);
						}
					}
				}
				if( (array_key_exists('image_name',$vars)) && ($vars['image_name'] !="") )
				{
					$vars['fkplaque_id']=$vars['pkplaque_id'];
					$this->m_image->createImage($vars);
					//$imgid=$this->m_image->getLastImageId();
					//add to associate table.
					//$this->m_image->addPlaqueImage($imgid,$insert_vars[$id]);
				}
		
				$sql="UPDATE tblplaque SET ";
				$sql.=UpdateSQL($insert_vars,$id);
				$sql .=" where ".$id."=".$insert_vars[$id];
				$result = getconn($sql);
				return $result;
			}
			function getPlaqueByID($id)
			{	
				$sql =" select * from tblplaque where pkplaque_id =".$id;
				$result = getconn($sql);
				return $result;
			}
			function getAllPlaques($currpg,$url)
			{
				$sql="Select * from tblplaque order by plq_recipient asc";
				$result = paging($sql,$currpg,$this->pagesize,$url); 
				return $result;
			}
			function getAllPlaque()
			{
				$sql="Select * from tblplaque order by plq_recipient asc";
				$result = getconn($sql); 
				return $result;
			}

			function getPlaqueType()
			{
				$sql="Select * from tblplaquetype order by name asc";
				$result = getconn($sql);
				return $result;
			}
			function getPlaquesByNeighbourhoodCriteria($vars)
			{
			
			}
			function addLandmarktoPlaque($vars)
			{//mujst check associate table for entry and delete it then add it bc cant have more than one landmark to plaque 
				//$this->m_landplaque
				$this->deletelandmarktoPlaque($vars['fkplaque_id']);
				$sql="insert into tbllandmarkplaque ";
				$sql .=InsertSQL($vars,$id);
				$result = getconn($sql);
				return $result;

			
			}
			function getPlaqueByAppId($id)
			{
				$sql="Select * from tblplaque where fkapplication_id=".$id;
				$result = getconn($sql);
				return $result;

			}
			function deletelandmarktoPlaque($pkplaque_id)
			{
				$sql="Delete from tbllandmarkplaque where fkplaque_id=".$pkplaque_id;
				$result = getconn($sql);
				return $result;
			}

		function getLandmarkfromPlaque($fkplaque_id)
		{
				$sql="Select * from tbllandmarkplaque where fkplaque_id=".$fkplaque_id;
				$result = getconn($sql);
				return $result;

		}
		function getLandmarkAllfromPlaque($fkplaque_id)
		{
				$sql="Select L.* from tbllandmark L inner join tbllandmarkplaque on fklandmark_id = pklandmark_id where fkplaque_id=".$fkplaque_id;
				$result = getconn($sql);
				return $result;

		}
		
		function getRelationshipPlaque($img_id)
		{
			$sql="Select fkplaque_id from tblimageplaque where fkimage_id=".$img_id;
			$result=getconn($sql);  
			return $result;
		}
		function removePlaqueImage($pid,$imgid)
		{
				$sql="Delete from tblimageplaque where fkplaque_id=".$pid. " and fkimage_id=".$imgid ;
				$result = getconn($sql);
				return $result;		
		}
		function checkPrimaryPlaqueImage($pid,$imgid)
		{
		
				$sql="Select pkplaque_id from tblplaque where pkplaque_id=".$pid. " and primary_img=".$imgid ;
				$result = getconn($sql);
				return $result;		
		}
		function setPrimaryPlaqueImage($pid)
		{
				$sql="Update tblplaque set primary_img=0 where pkplaque_id=".$pid;
				$result = getconn($sql);
				return $result;		
		}


	/*-------------------------------------------	Inscriptions		--------------------------------------------------*/
			function createInscription($vars)
			{
					$result=$this->m_inscription->createInscription($vars);
					return $result;
			}
			function updatePlaqueInscription($vars) 
			{
					$result=$this->m_inscription->updatePlaqueInscription($vars);
					return $result;
			}
			function getInscriptions() 
			{
					$result=$this->m_inscription->getInscriptions();
					return $result;
			}
			function GetInscriptionByInscriptionId($id)
			{
					$result=$this->m_inscription->GetInscriptionByInscriptionId($id);
					return $result;
			}
			function getInscription()
			{
					$result=$this->m_inscription->getInscriptionComments();
					return $result;
				
			}
			function GetInscriptionByPlaqueId($id)
			{
					$result=$this->m_inscription->GetInscriptionByPlaqueId($id);
					return $result;
			}
			function GetInscriptionCommentsByPlaqueId($id)
			{
					$result=$this->m_inscription->GetInscriptionCommentsByPlaqueId($id);
					return $result;
			}
	
	/*-------------------------------------------	Inspections			--------------------------------------------------*/
		// **************************************************  
		// Nov 18 
		// modified to deal with plaque inspection 

		// update plaque inspection record 
		// also update plaque inspection required field in plaque record 
		function createInspection($vars) 		
		{
			// update plaque record - plaque inspection required field 
			$id = 'pkplaque_id';			// key field 
			// plaque table field names 
			$insert_vars =  array_intersect_key($vars,$this->getPlaque());
			updatePlaque($insert_vars);
			// attributes that relate to plaque inspection 
			$plqinspect_vars =  array_intersect_key($vars, $this->m_inspection->getInspection()); 
			// set plaque id (fkplaque_id) in plaque inspection record 
			$plqinspect_vars['fkplaque_id'] = $insert_vars[$id]; 
			// create plaque inspection record 
			$result = $this->m_inspection->createInspection($plqinspect_vars); 
			return $result; 
		}
		// **************************************************  
		
		// **************************************************  
		// Nov 18 
		// modified to deal with plaque inspection 

		// update plaque inspection record 
		// also update plaque inspection required field in plaque record 
		function updateInspection($vars) 		
		{
			// update plaque record - plaque inspection required field 
			$id = 'pkplaque_id';			// key field 
			// plaque table field names 
			$insert_vars =  array_intersect_key($vars, $this->getPlaque()); 
			updatePlaque($insert_vars);
			// attributes that relate to plaque inspection 
			$plqinspect_vars =  array_intersect_key($vars, $this->m_inspection->getInspection()); 
			// set plaque id (fkplaque_id) in plaque restoration record 
			$plqinspect_vars['fkplaque_id'] = $insert_vars[$id]; 
			// update existing plaque inspection record 
			$result = $this->m_inspection->updateInspection($plqinspect_vars); 
			return $result; 
		}
		function getAllInspection() 
		{
				$result=$this->m_inspection->getAllInspection();
				return $result;
		}
		function GetInspectionById($id)
		{
				$result=$this->m_inspection->GetInspectionById($id);
				return $result;
		}
		function getInspection()
		{
			$result=$this->m_inspection->getInspection();
				return $result;
		
		}
				// **************************************** 
		// Nov 18  
		// retrieve plaque inspection types 
		
		function getInspectionTypes()
		{
				$result = $this->m_inspection->getInspectionTypes();
				return $result;
		} 
		// **************************************** 
	
		// **************************************** 
		// Nov 18 
		// retrieve plaque inspection record 
		//     look for match on plaque id and year 
		
		function getInspectionByPlqIdYear($fkplaque_id, $year) 
		{
			$result = $this->m_inspection->getInspectionByPlqIdYear($fkplaque_id, $year); 
			return $result; 
		} 
		// **************************************** 		

/*-------------------------------------------	Installation		--------------------------------------------------*/
		function createInstallation($installation_vars)
		{
				$insert_vars =  array_intersect_key($installation_vars,$this->getPlaque());
				$result = $this->updatePlaque($insert_vars);
				if ($result )
				{	
					$result=$this->m_Installation->createInstallation($installation_vars);}
				return $result;
		}
		function updateInstallation($installation_vars)
		{
				$result=$this->m_Installation->updateInstallation($installation_vars);
				return $result;
		}
		function getInstallationByID($id)
		{
				$result=$this->m_Installation->getInstallationByID($id);
				return $result;
		}
		function getAllInstallation()
		{
				$result=$this->m_Installation->getAllInstallation();
				return $result;
		}
		function getInstallation()
		{
				$result=$this->m_Installation->getInstallation();
				return $result;
		}
		function getinspectionbydatebyplaqueid($id)
		{
				$result=$this->m_Installation->getinspectionbydatebyplaqueid($id);
				return $result;
		}


/*-------------------------------------------	Plaquerestorations	 --------------------------------------------------*/
		// **************************************************  
		// Nov 18 
		// modified to deal with plaque restoration 

		// update plaque restoration record 
		// also update plaque restoration required field in plaque record 
		function createPlaqueRestoration($vars) 		
		{
			// update plaque record - plaque restoration required field 
			$id = 'pkplaque_id';			// key field 
			// plaque table field names 
			$insert_vars =  array_intersect_key($vars,$this->getPlaque());
			// construct sql statement 
			$this->updatePlaque($insert_vars);
			// attributes that relate to plaque restoration 
			$plqrestore_vars =  array_intersect_key($vars, $this->m_PlaqueRestoration->getPlaqueRestoration()); 
			// set plaque id (fkplaque_id) in plaque restoration record 
			$plqrestore_vars['fkplaque_id'] = $insert_vars[$id]; 
			// create existing plaque restoration record 
			$result = $this->m_PlaqueRestoration->createPlaqueRestoration($plqrestore_vars); 
			return $result; 
		}
		// **************************************************  
		
		// **************************************************  
		// Nov 18 
		// modified to deal with plaque restoration 

		// update plaque restoration record 
		// also update plaque restoration required field in plaque record 
		function updatePlaqueRestoration($vars) 		
		{
			// update plaque record - plaque restoration required field 
			$id = 'pkplaque_id';			// key field 
			// plaque table field names 
			$insert_vars =  array_intersect_key($vars,$this->getPlaque());
			$this->updatePlaque($insert_vars);
			// attributes that relate to plaque restoration 
			$plqrestore_vars =  array_intersect_key($vars, $this->m_PlaqueRestoration->getPlaqueRestoration()); 
			// set plaque id (fkplaque_id) in plaque restoration record 
			$plqrestore_vars['fkplaque_id'] = $insert_vars[$id]; 
			// update existing plaque restoration record 
			$result = $this->m_PlaqueRestoration->updatePlaqueRestoration($plqrestore_vars); 
			return $result; 
		}
		function getPlaqueRestorationById($id)
		{
				$result=$this->m_PlaqueRestoration->getPlaqueRestorationById($id);
				return $result;
		}
		function getAllPlaqueRestorations()
		{
				$result=$this->m_PlaqueRestoration->getAllPlaqueRestorations();
				return $result;
		}
		
		
		function getPlaqueRestoration()
		{
			$result=$this->m_PlaqueRestoration->getPlaqueRestoration();
			return $result;
		}
				// **************************************** 
		// Nov 18 
		// retrieve plaque restoration record 
		//     look for match on plaque id and year 
		
		function getPlaqueRestorationByPlqIdYear($fkplaque_id, $year) 
		{
			$result = $this->m_PlaqueRestoration->getPlaqueRestorationByPlqIdYear($fkplaque_id, $year); 
			return $result; 
		} 


//-------------------------------- SEARCH FUNCTIONS -------------------------------------//		
		function getPlaquesByCriteria($vars,$currpg,$url)
		{
			// initialize for search on year 
			// if both start year and end year blank search on all years 
			// if start year blank, start search at before first year and end on end year 
			// if end year blank, start search on start year and end after current year 
			$start_year=$vars['start_year']; 
			$end_year=$vars['end_year']; 
			if (($start_year==0) or ($end_year==0)) { 
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
			$sql="select * from tblplaque P where "; 
			// check for search on keyword 
			if ($vars['keywd'] != "") 
			{
				// include sql for keyword search in sql command 
				$sql .=	" (P.plq_inscription like '%%%" .$vars['keywd']. "%%%' or P.plq_desc like '%%%" . $vars['keywd'] ."%%%' or P.plq_recipient like '%%%". $vars['keywd'] ."%%%' or P.plq_location like '%%%" . $vars['keywd'] ."%%%')"; 
				// check for search on inscription required or dates 
				if (($vars['plq_inscript_reqd'] != "") or (($start_year!="") and ($end_year!=""))) { 
					// if search on inscription or date include "and" in sql command 
					$sql .= " and "; 
				} 
			} 
			
			// check if search on date range 
			if (($start_year != "") and ($end_year != "")) { 
				// include sql for date range search in sql command 
				$sql .= " ((YEAR(P.plq_inaug_date) >='".$start_year."' and YEAR(P.plq_inaug_date) <='".$end_year."') or (YEAR(P.plqinsc_date) >='".$start_year."' and YEAR(P.plqinsc_date) <='".$end_year."'))"; 
				// check if search on inscription required 
				if ($vars['plq_inscript_reqd'] != "") { 
					// if search on inscription include "and" in sql command 
					$sql .= " and "; 
				}
			}

			// check for search on inscription 
			if ($vars['plq_inscript_reqd'] !="" ) { 
				// include sql for inscription search in sql command 
				$sql .= " P.plq_inscript_reqd='".$vars['plq_inscript_reqd']."'";
			}
	
			// include sql to sort result 
			$sql .=" ORDER BY P.plq_recipient Asc";
			//echo $sql; 
			$result = paging($sql,$currpg,$this->pagesize,$url); 
			return $result; 
			
		} 
		function getPlaques2ByCriteria($vars,$currpg,$url)
		{
			// initialize for search on year 
			// if both start year and end year blank search on all years 
			// if start year blank, start search at before first year and end on end year 
			// if end year blank, start search on start year and end after current year 
			$start_year=$vars['start_year']; 
			$end_year=$vars['end_year']; 
			if (($start_year==0) or ($end_year==0)) { 
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
			$sql="select * from tblplaque P inner join tblplaqueinstallation PI on PI.fkplaque_id = P.pkplaque_id where "; 

			// check for search on keyword 
			if($vars['keywd'] !="")
			{ 
				// include keyword search in sql command 			
				$sql .=	" (P.plq_location like '%%%" .$vars['keywd']. "%%%' or P.plq_inscription like '%%%" .$vars['keywd']. "%%%' or P.plq_desc like '%%%" . $vars['keywd'] ."%%%' or P.plq_recipient like '%%%". $vars['keywd'] ."%%%') ";
				// check for search on installation required or dates 
				if (($vars['plq_instal_reqd'] != "") or (($start_year!="") and ($end_year!=""))) { 
					// if search on installation required or dates include "and" in sql command 
					$sql .= " and "; 
				}
			} 

			// check for search on installation required 
			if($vars['plq_instal_reqd'] !="") {
				$sql .= " P.plq_instal_reqd='".$vars['plq_instal_reqd']."'"; 
				// check if search on dates 				
				if (($start_year != "") and ($end_year != "")) { 
					// if search on dates include "and" in sql command 
					$sql .= " and "; 
				}
			}

			// check if search on date range 
			if (($start_year != "") and ($end_year != "")) { 
				// include sql for date range search in sql command 
				$sql .= " ((YEAR(PI.plqinst_date) >='".$start_year."' and YEAR(PI.plqinst_date) <='".$end_year."'))"; 
				// check if search on inscription required 
			}
			
			$sql .=" ORDER BY P.plq_recipient";
			//echo $sql;					// testing 
			$result = paging($sql,$currpg,$this->pagesize,$url); 
			return $result;
		} 
		
		function getPlaques3ByCriteria($vars,$currpg,$url)
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

			$sql="select * from tblplaque P  where ";
			if($vars['keywd'] !="")
			{
				$sql .=	" P.plq_inscription like '%%%" .$vars['keywd']. "%%%' or P.plq_desc like '%%%" . $vars['keywd'] ."%%%' or P.plq_recipient like '%%%". $vars['keywd'] ."%%%' ";
				if (($vars['plq_inspect_reqd'] != "") or (($start_year!="") and ($end_year!=""))) { 
					// if search on inscription or date include "and" in sql command 
					$sql .= " and "; 
				} 

			}
			if (($vars['start_year'] != "") and ($vars['end_year'] != "")) { 
				// include sql for date range search in sql command 
				$sql .= " ((YEAR(P.plq_inaug_date) >='".$start_year."' and YEAR(P.plq_inaug_date) <='".$end_year."') or (YEAR(P.plqinsc_date) >='".$start_year."' and YEAR(P.plqinsc_date) <='".$end_year."'))"; 
				// check if search on inscription required 
				if ($vars['plq_inspect_reqd'] != "") { 
					// if search on inscription include "and" in sql command 
					$sql .= " and "; 
				}
			}


			if(($vars['plq_inspect_reqd'] !="") and (($vars['loc'] !="") or ($vars['keywd'] !=""))){ $sql .= " and ";}
			if($vars['plq_inspect_reqd'] !=""){
				$sql .= " P.plq_inspect_reqd='".$vars['plq_inspect_reqd']."'";
			}
			
			$sql .=" ORDER BY P.plq_recipient";
			//echo $sql;
			$result = paging($sql,$currpg,$this->pagesize,$url); 
			return $result;
		}
		
		function getPlaques4ByCriteria($vars,$currpg,$url)
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
			
			$sql="select * from tblplaque P  where ";			 
			if($vars['keywd'] !="")
			{
				$sql .=	" P.plq_location like '%%%" .$vars['keywd']. "%%%' or P.plq_inscription like '%%%" .$vars['keywd']. "%%%' or P.plq_desc like '%%%" . $vars['keywd'] ."%%%' or P.plq_recipient like '%%%". $vars['keywd'] ."%%%' ";
					if (($vars['plq_restore_reqd'] != "") or (($start_year!="") and ($end_year!=""))) { 
					// if search on inscription or date include "and" in sql command 
					$sql .= " and "; 
				}
			}
			
			if (($vars['start_year'] != "") and ($vars['end_year'] != "")) { 
				// include sql for date range search in sql command 
				$sql .= " ((YEAR(P.plq_inaug_date) >='".$start_year."' and YEAR(P.plq_inaug_date) <='".$end_year."') or (YEAR(P.plqinsc_date) >='".$start_year."' and YEAR(P.plqinsc_date) <='".$end_year."'))"; 
				// check if search on inscription required 
				if ($vars['plq_restore_reqd'] != "") { 
					// if search on inscription include "and" in sql command 
					$sql .= " and "; 
				}
			}

			// check for search on inscription 
			if ($vars['plq_restore_reqd'] !="" ) { 
				// include sql for inscription search in sql command 
				$sql .= " P.plq_restore_reqd='".$vars['plq_restore_reqd']."'";
			}			
						
			$sql .=" ORDER BY P.plq_recipient";
			//echo $sql;
			$result =  paging($sql,$currpg,$this->pagesize,$url); 
			return $result;
	}
		function getPlaquesforMap($vars)
		{
				$sql="select distinct P.pkplaque_id, P.* from tblplaque P inner join tbllandmarkplaque LP on fkplaque_id=P.pkplaque_id inner join tbllandmark L on L.pklandmark_id = LP.fklandmark_id inner join tblneighbourhood N on L.fkneighbor_id = N.id  where ";
				if($vars['keywd'] !="")
				{
					$sql .=	"( P.plq_location like '%%%" .$vars['loc']. "%%%' or P.plq_recipient like '%%%" .$vars['keywd']. "%%%' or P.plq_inscription like '%%%" . $vars['keyword_text'] ."%%%' or L.land_description like '%%%". $vars['keywd'] ."%%%'  or L.land_name like '%%%". $vars['keywd'] ."%%%') ";
				}
				if(($vars['keywd'] !="") and ($vars['fkneighbor_id'] !="" and $vars['fkneighbor_id'] !="Choose a Neighbourhood..." ) ){ $sql .= " and ";}
				if($vars['fkneighbor_id'] !="" and $vars['fkneighbor_id'] !="Choose a Neighbourhood..." ){
					$sql .= " L.fkneighbor_id=".$vars['fkneighbor_id'];
				}
				
				$sql .=" ORDER BY P.plq_recipient";
				//echo $sql;
				$result = getconn($sql); 
				return $result;
	
		
		}
		function getPlaquesforSearch($vars,$currpg,$url)
		{
				$sql="select distinct P.pkplaque_id, P.* from tblplaque P inner join tbllandmarkplaque LP on fkplaque_id=P.pkplaque_id inner join tbllandmark L on L.pklandmark_id = LP.fklandmark_id inner join tblneighbourhood N on L.fkneighbor_id = N.id  where ";
				if($vars['keywd'] !="")
				{
					$sql .=	"( P.plq_location like '%%%" .$vars['loc']. "%%%' or P.plq_recipient like '%%%" .$vars['keywd']. "%%%' or P.plq_inscription like '%%%" . $vars['keyword_text'] ."%%%' or L.land_description like '%%%". $vars['keywd'] ."%%%'  or L.land_name like '%%%". $vars['keywd'] ."%%%') ";
				}
				if(($vars['keywd'] !="") and ($vars['fkneighbor_id'] !="" and $vars['fkneighbor_id'] !="Choose a Neighbourhood..." ) ){ $sql .= " and ";}
				if($vars['fkneighbor_id'] !="" and $vars['fkneighbor_id'] !="Choose a Neighbourhood..." ){
					$sql .= " L.fkneighbor_id=".$vars['fkneighbor_id'];
				}
				
				$sql .=" ORDER BY P.plq_recipient";
				//echo $sql;
				$result = getconn($sql); 
				return $result;
	
		
		}

}

?>
