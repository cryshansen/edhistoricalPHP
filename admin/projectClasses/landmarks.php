<?php
require_once("conn_function.php");
require_once("sql.php");
require_once("images.php");

class landmarkClass{
	var $m_landmark;
	var	$m_image;
	var $pagesize = 10;
	 
	//constructor
	function landmarkClass()
	{
		$this->m_landmark =array('pklandmark_id'=>"",'land_name'=>"",'street_address'=>"",'latitude'=>"",'longitude'=>"",'classification'=>"",'designation'=>"",'landmark_age'=>"",'location'=>"",'land_description'=>"",'land_comments'=>"",'fkowner_id'=>"",'fkneighbor_id'=>"");
		$this->m_image = new imageClass();

	}
		//getter
	function getLandmark()
	{
		return $this->m_landmark;
	}

	
	function createLandmark($vars)
	{	$id='pklandmark_id';
		$vars['longitude']= getdecimalval($vars['dLg'],$vars['mLg'],$vars['sLg']);
		$vars['latitude']= getval2($vars['dLt'],$vars['mLt'],$vars['sLt']);
		//print_r($vars);
		//print_r($this->getLandmark());
		$insert_vars=array_intersect_key($vars,$this->getLandmark());
		$sql =" Insert into  tbllandmark";
		$sql .=InsertSQL($insert_vars,$id);
		$result = getconn($sql);
		$land_id=$this->getLastLandId();
		if( (array_key_exists('image_name',$vars)) && ($vars['image_name'] !="") )
		{
			$vars['pklandmark_id']=$land_id;
			$vars['fklandmark_id']=$land_id;
			$this->m_image->createImage($vars);
		}
		return $result;
	}
	
	function getLastLandId()
	{
		$id=mysql_insert_id();
		return $id;
	}

	function updateLandmark($vars)
	{	
		$id='pklandmark_id';
		$vars['longitude']= getdecimalval($vars['dLg'],$vars['mLg'],$vars['sLg']);
		$vars['latitude']= getval2($vars['dLt'],$vars['mLt'],$vars['sLt']);
		$insert_vars=array_intersect_key($vars,$this->getLandmark());
		if( (array_key_exists('image_name',$vars)) && ($vars['image_name'] !="") )
		{
			$vars['fklandmark_id']=$land_id;
			$this->m_image->createImage($vars);
		}
		$sql="UPDATE tbllandmark SET ";
		$sql.=UpdateSQL($insert_vars,$id);
		$sql .=" where ".$id."=".$vars[$id];
		$result = getconn($sql);
		return $result;
	}
	function checkLandname($landname)
	{
		$sql =" select pklandmark_id,land_name from tbllandmark where land_name ='".$landname."'";
		$result = getconn($sql);
		return $result;

	}
	function getLandmarkByID($id)
	{	
		$sql =" select * from tbllandmark where pklandmark_id =".$id;
		$result = getconn($sql);
		return $result;
	}
	function getAllLandmarks($currpg,$url)
	{
		$sql="Select * from tbllandmark order by land_name asc";
		$pagesize = 10;
		$result = paging($sql,$currpg,$this->pagesize,$url); 
		return $result;
	}
	function getAllLandmark()
	{
		$sql="Select * from tbllandmark order by land_name asc";
		$pagesize = 10;
		$result = getconn($sql); 
		return $result;
	}

	function getAllNeighbourhoods()
	{
		$sql="Select * from tblneighbourhood order by name asc";
		$result = getconn($sql);
		return $result;
	}
	function getLandmarkOwnerById($landmark_id)
	{
		$sql = "SELECT * FROM tbllandmark L INNER JOIN tblowner ON pkowner_id = fkowner_id INNER JOIN tblneighbourhood N ON N.id = L.fkneighbor_id WHERE pklandmark_id=".$landmark_id;
		$result = getconn($sql);
		return $result;

	}
	function getMarkersByAddress($address)
	{
		$sql = "SELECT * FROM tbllandmark  WHERE street_address=".$address;
		$result = getconn($sql);
		return $result;

	}
	
	function getLandmarksByNeighbourhood($id)
	{
		$sql = "SELECT * FROM tbllandmark  WHERE fkneighbor_id=".$id;
		$result = getconn($sql);
		return $result;
	}
	function getLandmarkNeighbourhood($id)
	{
		$sql="Select N.* from tblneighbourhood N inner join tbllandmark LA on LA.fkneighbor_id=id where LA.pklandmark_id=".$id;
		$result = getconn($sql);
		return $result;
	}
	function getPlaquesAllfromLandmark($id)
	{
		$sql="Select P.* from tblplaque P inner join tbllandmarkplaque on  fkplaque_id = pkplaque_id where fklandmark_id=".$id;
		$result = getconn($sql);
		return $result;

	}
	function getRelationshipLand($img_id)
	{//need landmark listing
		$sql="Select fklandmark_id from tblimagelandmark where fkimage_id=".$img_id; 
		//echo $sql;
		$result=getconn($sql);  
		return $result; 
	
	}
	function removeLandmarkImage($pid,$imgid)
	{
			$sql="Delete from tblimagelandmark where fklandmark_id=".$pid. " and fkimage_id=".$imgid ;
			echo $sql;$result = getconn($sql);
			return $result;		
	}

	function getLandmarksByCriteria($vars,$currpg,$url)
	{		
			$sql="select L.*,N.name from tbllandmark L inner join tblneighbourhood N on L.fkneighbor_id = N.id where ";
			if($vars['keywd'] !="")
			{
				$sql .=	"(L.location like '%%%" .$vars['keywd']. "%%%' or  L.street_address like '%%%" .$vars['keywd']. "%%%' or  L.land_description like '%%%" .$vars['keywd']. "%%%' or L.land_comments like '%%%" . $vars['keywd'] ."%%%' or L.designation like '%%%". $vars['keywd'] ."%%%'  or L.land_name like '%%%". $vars['keywd'] ."%%%' or L.classification like '%%%". $vars['keywd'] ."%%%') ";
			}
			if((($vars['keywd'] !="")) and ($vars['fkneighbor_id'] !="" and $vars['fkneighbor_id'] !="Choose a Neighbourhood...") ){ $sql .= " and ";}
			if($vars['fkneighbor_id'] !="" and $vars['fkneighbor_id'] !="Choose a Neighbourhood..."){
				$sql .= " L.fkneighbor_id=".$vars['fkneighbor_id'];
			}
			
			$sql .=" ORDER BY L.land_name,N.name";
			//echo $sql;
			$result = getconn($sql); 
			return $result;
	}
		function getLandmarksforMap($vars)
	{
			$sql="select L.*,N.name from tbllandmark L inner join tblneighbourhood N on L.fkneighbor_id = N.id where ";
			if($vars['keywd'] !="")
			{
				$sql .=	"(L.location like '%%%" .$vars['keywd']. "%%%' or  L.street_address like '%%%" .$vars['keywd']. "%%%' or  L.land_description like '%%%" .$vars['keywd']. "%%%' or L.land_comments like '%%%" . $vars['keywd'] ."%%%' or L.designation like '%%%". $vars['keywd'] ."%%%'  or L.land_name like '%%%". $vars['keywd'] ."%%%' or L.classification like '%%%". $vars['keywd'] ."%%%') ";
			}
			if((($vars['keywd'] !="")) and ($vars['fkneighbor_id'] !="" and $vars['fkneighbor_id'] !="Choose a Neighbourhood...") ){ $sql .= " and ";}
			if($vars['fkneighbor_id'] !="" and $vars['fkneighbor_id'] !="Choose a Neighbourhood..."){
				$sql .= " L.fkneighbor_id=".$vars['fkneighbor_id'];
			}
			
			$sql .=" ORDER BY L.land_name,N.name";
			//echo $sql;
			$result = getconn($sql); 
			return $result;
	}
	
}

?>