<?php
require_once('users.php');
require_once('applicants.php');
require_once('applications.php');
require_once('application_historys.php');
require_once('tablemanager.php');
require_once('awards.php');
require_once('plaques.php');
require_once('owners.php');
require_once('images.php');
require_once('landmarks.php');
require_once('vendors.php');

//$history_vars
class controllerClass{
var $m_user;
var $m_applicant;
var $m_application;
var $m_application_history;
var $m_table;
var $m_award;
var $m_Owners;
var $m_image;
var $m_Landmark;
var $m_Plaque;
var $m_Vendors;


	function controllerClass(){
		$this->m_user= new userClass();
		$this->m_applicant = new applicantClass();
		$this->m_application = new applicationClass();
		$this->m_application_history = new applicationHistoryClass();
		$this->m_table = new tableManagerClass();
		$this->m_award = new awardClass();
		$this->m_Owners = new ownerClass();
		$this->m_image = new imageClass();
		$this->m_Landmark = new landmarkClass();
		$this->m_Plaque = new plaqueClass();
		$this->m_Vendors = new vendorClass();
	}


/*-------------------------------------------	Applicants				--------------------------------------------------*/	
			function createApplicant($applicant_vars)
			{
				$result=$this->m_applicant->createApplicant($applicant_vars);
				return $result;
			}
			
			function updateApplicant($vars)
			{
				$result=$this->m_applicant->updateApplicant($vars);
				return $result;
			}
			function getAllApplicants($currpg,$url)
			{
				$result=$this->m_applicant->getAllApplicants($currpg,$url);
				return $result;
			}
			function getAllApplicant()
			{
				$result=$this->m_applicant->getAllApplicant();
				return $result;
			}

			function getApplicantById($id)
			{
				$result=$this->m_applicant->getApplicantById($id);
				return $result;
			}
			
			function getLastApplicantId()
			{
				$result=$this->m_applicant->getLastApplicantId();
				return $result;
			}
			function getApplicant()
			{
				$result=$this->m_applicant->getApplicant();
				return $result;
			}
			function getApplicantByCriteria($vars,$currpg,$url)
			{
				$result=$this->m_applicant->getApplicantByCriteria($vars,$currpg,$url);
				return $result;
			}
		
		
/*-------------------------------------------	Applications				--------------------------------------------------*/	
			function createApplication( $post_vars)
			{
				$result=$this->m_application->createApplication( $post_vars );
				return $result;
			
			}
			function updateApplication( $post_vars)
			{
				$result=$this->m_application->updateApplication( $post_vars);
				return $result;
		
			
			}
			function getApplicationNameById($id)
			{
				$result=$this->m_application->getApplicationNameById($id);
				return $result;
		
			}
			function getAllApplications($currpg,$url)
			{
				$result=$this->m_application->getAllApplications($currpg,$url);
				return $result;	
			}
			function getApplicationForReport($id)
			{
				$result=$this->m_application->getApplicationForReport($id);
				return $result;
			}
			function getApplicationById($id)
			{
				$result=$this->m_application->getApplicationById($id);
				return $result;
			}
			function getLastApplicationId()
			{
				$result=$this->m_application->getLastApplicationId();
				return $result;
			}
			function getApplication()
			{
				$result=$this->m_application->getApplication();
				return $result;
			}
			function getHistoricalEventById($id)
			{
				$result=$this->m_application->getHistoricalEventById($id);
				return $result;
			}
			function getApplicationByNominator($id)
			{
				$result=$this->m_application->getApplicationByNominator($id);
				return $result;
			
			}
			//NOv10 Crystal
			function getApplicationStatus()
			{
				$result=$this->m_application->getApplicationStatus();
				return $result;
			}
			function getApplicationsByCriteria($vars,$currpg,$url)
			{
				$result=$this->m_application->getApplicationsByCriteria($vars,$currpg,$url);
				return $result;
			}
			function getApplicationsByCriteria2($vars,$currpg,$url)
			{
				$result=$this->m_application->getApplicationsByCriteria2($vars,$currpg,$url);
				return $result;			
			
			}

/*-------------------------------------------	Application History		--------------------------------------------------*/	
			function getHistoricalComments($id)
			{
				$result=$this->$m_application_history->getHistoricalComments($id);
				return $result;
			
			}
			function getApplicationHistory()
			{
				$result=$this->m_application_history->getApplicationHistory();
				return $result;
			}
/*-------------------------------------------	Users				--------------------------------------------------*/	
			function user_create($vars)
			{
				$result=$this->m_user->user_create($vars);
				return $result;
			}
			function get_Password($username)
			{
				$result=$this->m_user->get_Password($username);
				return $result;
			}
			function check_UserByEmail($email)
			{
				$result=$this->m_user->check_UserByEmail($email);
				return $result;
			}
			function getUserById($id)
			{
				$result=$this->m_user->getUserById($id);
				return $result;
			}
			function getUserGroup()
			{
				$result=$this->m_user->getUserGroup();
				return $result;
			
			}
			function getAllUsers($currpg,$url)
			{
				$result=$this->m_user->getAllUsers($currpg,$url);
				return $result;
			}
			function updateUser($vars)
			{
				$result=$this->m_user->updateUser($vars);
				return $result;
			
			}
			function check_Username($username)
			{
				$result=$this->m_user->check_Username($username);
				return $result;
			}
			function getUsersByCriteria($keyword_text)
			{
				$result=$this->m_user->getUsersByCriteria($keyword_text);
				return $result;
			}
			function getUser()
			{
				$result=$this->m_user->getUser();
				return $result;	
			
			}
		
		
/*-------------------------------------------	TABLE MANAGER				--------------------------------------------------*/	
			
			function getallTables()
			{
				$result=$this->m_table->getallTables();
				return $result;
			}
			function getTable()
			{
				$result=$this->m_table->getTable();
				return $result;
			}
			// **************************************** 
			// Nov 20  
			// retrieve all records from selected table 
			// want paging when results are displayed 
			function getTableRecords($table_name, $currpg, $url)			
			{
				$result=$this->m_table->getTableRecords($table_name, $currpg, $url);
				return $result;
			}
			// **************************************** 

			// **************************************** 
			// Nov 20 
			// retrieve all records from table  
			// want results to populate drop down list 
			function getTableRecordsList($table_name)
			{
				$sql="Select * from ".$table_name;
				$result=getconn($sql); 
				return $result;
			}

			// Nov 13 
			// get table record 
			//     $pktable_id	- table name 
			//     $id			- record number 
			function getTableById($pktable_id, $id) 
			{
				$result = $this->m_table->getTableById($pktable_id, $id); 
				return $result; 
			}
			// ****************************** 

			// ****************************** 
			// Nov 13
			// update record in table 
			//     $pktable_id	- table name 
			//     $vars 		- attributes & values 
			function updateTableRecord($pktable_id, $vars)	
			{
				$result = $this->m_table->updateTableRecord($pktable_id, $vars); 
				return $result; 
			} 
			// ****************************** 			
			
			// ******************************  
			// Nov 13
			// delete record from table 
			//     $pktable_id	- table name 
			//     $id			- record number	
			function deleteTableRecord($pktable_id, $id)
			{
				$result = $this->m_table->deleteTableRecord($pktable_id, $id); 
				return $result; 
			}
			// ******************************  

			// ******************** 
			// Nov 13 
			// add record to table 
			//     $pktable_id 	- table name  
			//     $vars 		- attributes & values 
			function createTableRecord($pktable_id, $vars)
			{
				$result = $this->m_table->createTableRecord($pktable_id, $vars); 
				return $result; 
			}
			// ******************************  
			

/*-------------------------------------------	Awards				--------------------------------------------------*/
		function createAward($vars)
		{
				$result=$this->m_award->createAward($vars);
				return $result;
		}
		function updateAward($vars)
		{
				$result=$this->m_award->updateAward($vars);
				return $result;
		}
		function getAwardByID($id)
		{
				$result=$this->m_award->getAwardByID($id);
				return $result;
		}
		function getAllAwards($currpg,$url)
		{
				$result=$this->m_award->getAllAwards($currpg,$url);
				return $result;
		}
		function getAllAward()
		{
				$result=$this->m_award->getAllAward();
				return $result;
		}

		function getAward()
		{
			$result=$this->m_award->getAward();
				return $result;
		}
		function getInscriptionByAwardId($pkaward_id)
		{		
				$result=$this->m_award->getInscriptionByAwardId($pkaward_id);
				return $result;
		}
		function getInscriptionCommentsByAwardId($pkaward_id)
		{
			$result=$this->m_award->getInscriptionCommentsByAwardId($pkaward_id);
			return $result;
		
		}
		function getRelationshipAward($img_id)
		{
				$result=$this->m_award->getRelationshipAward($img_id);
				return $result;
		}
		function removeAwardImage($pid,$imgid)
		{
				$result=$this->m_award->removeAwardImage($pid,$imgid);
				return $result;
		}
		function checkPrimaryAwardImage($pid,$imgid)
		{
				$result=$this->m_award->checkPrimaryAwardImage($pid,$imgid);
				return $result;		
		}
		function setPrimaryAwardImage($pid)
		{				
				$result=$this->m_award->setPrimaryAwardImage($pid);
				return $result;		
		}

		function getAwardsByCriteria($vars,$currpg,$url)
		{
			$result=$this->m_award->getAwardsByCriteria($vars,$currpg,$url);
			return $result;
		}
		function getAwardsByYearCriteria($vars,$currpg,$url)
		{
			$result=$this->m_award->getAwardsByYearCriteria($vars,$currpg,$url);
			return $result;
		
		}
		function getAwardByAppId($id)
		{
			$result=$this->m_award->getAwardByAppId($id);
			return $result;
		
		}

/*-------------------------------------------	Images				--------------------------------------------------*/
		function createImage($vars)
		{
				$result=$this->m_image->createImage($vars);
				return $result;
		}
		function deleteImage($id)
		{
				$result=$this->m_image->deleteImage($id);
				return $result;		
		}
		function getAllImage($currpg,$url)
		{
				$result=$this->m_image->getAllImage($currpg,$url);
				return $result;
		}
		function getImageById($id)
		{
				$result=$this->m_image->getImageById($id);
				return $result;
		}
		function updateImage($vars)
		{
				$result=$this->m_image->updateImage($vars);
				return $result;
		}
		function getImage()
		{
				$result=$this->m_image->getImage();
				return $result;
		}
		function getImagesByPlaqueId($pkplaque_id)
		{
				$result=$this->m_image->getImagesByPlaqueId($pkplaque_id);
				return $result;
		}
		function getImagesByAwardId($pkaward_id)
		{
				$result=$this->m_image->getImagesByAwardId($pkaward_id);
				return $result;
		}
		function getImagesByLandmarkId($pkland_id)
		{
				$result=$this->m_image->getImagesByLandmarkId($pkland_id);
				return $result;
		}
		
		function image_name_check($Image_name)
		{
				$result=$this->m_image->image_name_check($Image_name);
				return $result;
		
		}
		function getImagesByCriteria($vars)
		{
				$result=$this->m_image->getImagesByCriteria($vars);
				return $result;
		
		}

/*-------------------------------------------	Landmarks				--------------------------------------------------*/
		function createLandmark($vars)
		{
				$result=$this->m_Landmark->createLandmark($vars);
				return $result;
		}
		function updateLandmark($vars)
		{
				$result=$this->m_Landmark->updateLandmark($vars);
				return $result;
		}
		function checkLandname($landname)
		{
				$result=$this->m_Landmark->checkLandname($landname);
				return $result;
		}
		function getLandmarkByID($id)
		{
				$result=$this->m_Landmark->getLandmarkByID($id);
				return $result;
		}
		function getAllLandmarks($currpg,$url)
		{
				$result=$this->m_Landmark->getAllLandmarks($currpg,$url);
				return $result;
		}
		function getAllLandmark()
		{
				$result=$this->m_Landmark->getAllLandmark();
				return $result;
		}

		function getLandmark()
		{
				$result=$this->m_Landmark->getLandmark();
				return $result;
		}
		function getAllNeighbourhoods()
		{
				$result=$this->m_Landmark->getAllNeighbourhoods();
				return $result;
		}
		function getLandmarkOwnerById($landmark_id)
		{
				$result=$this->m_Landmark->getLandmarkOwnerById($landmark_id);
				return $result;
		}
		function getPlaquesAllfromLandmark($id)
		{
				$result=$this->m_Landmark->getPlaquesAllfromLandmark($id);
				return $result;

		}
		function getRelationshipLand($img_id)
		{
				$result=$this->m_Landmark->getRelationshipLand($img_id);
				return $result;
		}

		function removeLandmarkImage($pid,$imgid)
		{
				$result=$this->m_Landmark->removeLandmarkImage($pid,$imgid);
				return $result;
		}
		function checkPrimaryLandImage($pid,$imgid)
		{
				$result=$this->m_Landmark->checkPrimaryLandImage($pid,$imgid);
				return $result;		
		}
		function setPrimaryLandImage($pid)
		{				
				$result=$this->m_Landmark->setPrimaryLandImage($pid);
				return $result;		
		}
		function getImagesByLandPrimaryId($prim)
		{
				$result=$this->m_Landmark->getImagesByLandPrimaryId($prim);
				return $result;		
		}
		function getLandmarksByCriteria($vars,$currpg,$url)
		{
			$result=$this->m_Landmark->getLandmarksByCriteria($vars,$currpg,$url);
			return $result;
		}
		function getLandmarksByCriteriaforMarkers($vars)
		{
			$result=$this->m_Landmark->getLandmarksByCriteriaforMarkers($vars);
			return $result;
		}

		function getLandmarksByNeighbourhood($id)
		{
			$result=$this->m_Landmark->getLandmarksByNeighbourhood($id);
			return $result;
		}
		function getLandmarkNeighbourhood($landmark_id) 
		{
			$result = $this->m_Landmark->getLandmarkNeighbourhood($landmark_id); 
			return $result; 
		} 
		function getMarkersByAddress($address)
		{
			$result = $this->m_Landmark->getMarkersByAddress($address); 
			return $result; 
		
		}
		function getLandmarksForMap($vars)
		{
			$result = $this->m_Landmark->getLandmarksForMap($vars); 
			return $result; 
		

		}

/*-------------------------------------------	Owners				--------------------------------------------------*/
		function createOwner($vars)
		{
				$result=$this->m_Owners->createOwner($vars);
				return $result;
		}
		function updateOwner($vars)
		{
				$result=$this->m_Owners->updateOwner($vars);
				return $result;
		}
		function getOwnerById($id)
		{
				$result=$this->m_Owners->getOwnerById($id);
				return $result;
		}
		function getAllOwners($currpg,$url)
		{
				$result=$this->m_Owners->getAllOwners($currpg,$url);
				return $result;
		}
		function getAllOwner()
		{
				$result=$this->m_Owners->getAllOwner();
				return $result;
		}

		function getOwner()
		{
				$result=$this->m_Owners->getOwner();
				return $result;
		}
		// ****************************** 
		// nov 13 
		// search for owner records by keyword 
		function ownerKeywordSearch($keyword,$currpg,$url) 
		{ 
				$result = $this->m_Owners->ownerKeywordSearch($keyword,$currpg,$url); 
				return $result; 
		}

/*-------------------------------------------	Plaques			--------------------------------------------------*/
		function getPlaque()
		{
				$result=$this->m_Plaque->getPlaque();
				return $result;
		}
		function createPlaque($vars)
		{
				$result=$this->m_Plaque->createPlaque($vars);
				return $result;
		}
		function updatePlaque($vars)
		{
				$result=$this->m_Plaque->updatePlaque($vars);
				return $result;
		}
		function getPlaqueByID($id)
		{
				$result=$this->m_Plaque->getPlaqueByID($id);
				return $result;
		}
		function getAllPlaques($currpg,$url)
		{
				$result=$this->m_Plaque->getAllPlaques($currpg,$url);
				return $result;
		}
		function getAllPlaque()
		{
				$result=$this->m_Plaque->getAllPlaque();
				return $result;
		}

		function getPlaqueType()
		{
				$result=$this->m_Plaque->getPlaqueType();
				return $result;
		}
		function getLandmarkfromPlaque($fkplaque_id)
		{
				$result=$this->m_Plaque->getLandmarkfromPlaque($fkplaque_id);
				return $result;
		}
		function getLandmarkAllfromPlaque($fkplaque_id)
		{
				$result=$this->m_Plaque->getLandmarkAllfromPlaque($fkplaque_id);
				return $result;
		}
		function getPlaqueByAppId($id)
		{
				$result=$this->m_Plaque->getPlaqueByAppId($id);
				return $result;
		}
		function getRelationshipPlaque($img_id)
		{//gets image plaque relationship
				$result=$this->m_Plaque->getRelationshipPlaque($img_id);
				return $result;
		}
		function removePlaqueImage($pid,$imgid)
		{
			$result=$this->m_Plaque->removePlaqueImage($pid,$imgid);
			return $result;
		}
		function checkPrimaryPlaqueImage($pid,$imgid)
		{
			$result=$this->m_Plaque->checkPrimaryPlaqueImage($pid,$imgid);
			return $result;

		}
		function setPrimaryPlaqueImage($pid)
		{
			$result=$this->m_Plaque->setPrimaryPlaqueImage($pid);
			return $result;
		
		}
		function getPlaquesforSearch($vars,$currpg,$url)
		{
						$result=$this->m_Plaque->getPlaquesforSearch($vars,$currpg,$url);
						return $result;
		
		}
		function getPlaquesforMap($vars)
		{
				$result=$this->m_Plaque->getPlaquesforMap($vars);
				return $result;
		}

		function getPlaquesByCriteria($vars,$currpg,$url)
		{
				$result=$this->m_Plaque->getPlaquesByCriteria($vars,$currpg,$url);
				return $result;
		}
		function getPlaquesByNeighbourhoodCriteria($vars,$currpg,$url)
		{
				$result=$this->m_Plaque->getPlaquesByNeighbourhoodCriteria($vars,$currpg,$url);
				return $result;
		}
		function getPlaques3ByCriteria($vars,$currpg,$url)
		{		
				$result=$this->m_Plaque->getPlaques3ByCriteria($vars,$currpg,$url);
				return $result;
		}
		function getPlaques2ByCriteria($vars,$currpg,$url)
		{
				$result=$this->m_Plaque->getPlaques2ByCriteria($vars,$currpg,$url);
				return $result;
		}
		function getPlaques4ByCriteria($vars,$currpg,$url)
		{
				$result=$this->m_Plaque->getPlaques4ByCriteria($vars,$currpg,$url);
				return $result;
		}
		/*----------------	Installation Through Plaque Class		---------*/
		
		function createInstallation($installation_vars)
		{
				$result=$this->m_Plaque->createInstallation($installation_vars);
				return $result;
		}
		function updateInstallation($installation_vars)
		{
				$result=$this->m_Plaque->updateInstallation($installation_vars);
				return $result;
		}
		function getInstallationByID($id)
		{
				$result=$this->m_Plaque->getInstallationByID($id);
				return $result;
		}
		function getAllInstallation()
		{
				$result=$this->m_Plaque->getAllInstallation();
				return $result;
		}

		function getInstallation()
		{
				$result=$this->m_Plaque->getInstallation();
				return $result;
		}

		/*----------------	Inspections Through Plaque Class		---------*/

		function getInspection()
		{
				$result=$this->m_Plaque->getInspection();
				return $result;
		}
		function GetInspectionById($id)
		{
				$result=$this->m_Plaque->GetInspectionById($id);
				return $result;
		
		}
				// **************************************** 
		// Nov 18  
		// create inspection record 
		function createInspection($vars)
		{
				$result = $this->m_Plaque->createInspection($vars); 
				return $result; 
		}
		
		// **************************************** 		
		// Nov 18 
		// update inspection record 
		function updateInspection($vars)
		{
				$result = $this->m_Plaque->updateInspection($vars); 
				return $result; 
		}

		// **************************************** 
		// Nov 18  
		// retrieve plaque inspection record 
		//     look for match on plaque id and year 
		
		function getInspectionByPlqIdYear($fkplaque_id, $year) 
		{
				$result = $this->m_Plaque->getInspectionByPlqIdYear($fkplaque_id, $year); 
				return $result; 
		} 
		function getinspectionbydatebyplaqueid($id)
		{
				$result=$this->m_Plaque->getinspectionbydatebyplaqueid($id);
				return $result;
		}

		
		// **************************************** 
		// Nov 18  
		// retrieve plaque inspection types 
		
		function getInspectionTypes()
		{
				$result = $this->m_Plaque->getInspectionTypes();
				return $result;
		} 
		// **************************************** 
		

		/*----------------	Inscriptions Through Plaque Class		---------*/
		function GetInscriptionByPlaqueId($id)
		{
				$result=$this->m_Plaque->GetInscriptionByPlaqueId($id);
				return $result;
		}
		function getInscriptions() 
		{
				$result=$this->m_Plaque->GetInscriptions();
				return $result;			
		}
		function updatePlaqueInscription()
		{
				$result=$this->m_Plaque->GetInscription();
				return $result;
		}
		function createInscription($vars)
		{
			$result=$this->m_Plaque->createInscription($vars);
			return $result;
		}
		function getInscription()
		{
				$result=$this->m_Plaque->getInscription();
				return $result;
		}
		function GetInscriptionCommentsByPlaqueId($id)
		{
				$result=$this->m_Plaque->GetInscriptionCommentsByPlaqueId($id);
				return $result;
		}


		/*----------------	Restorations Through Plaque Class		---------*/
		function createPlaqueRestoration($vars)
		{
				$result=$this->m_Plaque->createPlaqueRestoration($vars); 
				return $result; 
		}
		
		function updatePlaqueRestoration($vars)
		{
				$result=$this->m_Plaque->updatePlaqueRestoration($vars); 
				return $result; 
		}
		
		function getAllPlaqueRestorations()
		{
				$result=$this->m_Plaque->getAllPlaqueRestorations(); 
				return $result; 
		}
		
		function getPlaqueRestorationById($id)
		{
				$result=$this->m_Plaque->getPlaqueRestorationById($id); 
				return $result;
		}

		function getPlaqueRestoration()
		{
				$result=$this->m_Plaque->getPlaqueRestoration();
				return $result;
		}
		// **************************************** 
		// Nov 18  
		// retrieve plaque restoration record 
		//     look for match on plaque id and year 
		
		function getPlaqueRestorationByPlqIdYear($fkplaque_id, $year) 
		{
				$result = $this->m_Plaque->getPlaqueRestorationByPlqIdYear($fkplaque_id, $year); 
				return $result; 
		} 

		
/*-------------------------------------------	Vendors			--------------------------------------------------*/
		function createVendors($vendors_vars)
		{
				$result=$this->m_Vendors->createVendors($vendors_vars);
				return $result;
		}
		function updateVendors($vendors_vars)
		{
				$result=$this->m_Vendors->updateVendors($vendors_vars);
				return $result;
		}
		function getVendorsById($id)
		{
				$result=$this->m_Vendors->getVendorsById($id);
				return $result;
		}
		function getAllvendors()
		{
				$result=$this->m_Vendors->getAllvendors();
				return $result;
		}
		function getVendor()
		{
				$result=$this->m_Vendors->getVendor();
				return $result;
		}
		function getVendorTypes()
		{
				$result=$this->m_Vendors->getVendorTypes();
				return $result;
		} 
		function getVendorsByCriteria($vars,$currpg,$url)
		{
			$result=$this->m_Vendors->getVendorsByCriteria($vars,$currpg,$url);
			return $result;
		}
		// ************************************************** 
		// Nov 21 
		// retrieve all vendor records 
		// when displaying results use paging 

		function getAllVendorsList($currpg,$url)
		{
				$result = $this->m_Vendors->getAllVendorsList($currpg, $url);
				return $result;				// return results from search 
		}



}
?>
