<?php
require_once("conn_function.php");
require_once("sql.php");

class imageClass{
var $m_images;
var $m_imageplaque;
var $m_imageaward;
var $m_imagelandmark;

	//constructor
	 function imageClass()
	 {
	 	$this->m_images=array( 'pkimage_id'=>"",'image_title'=>"",'image_name'=>"",'image_source'=>"",'image_permission'=>"",'image_location'=>"",  'image_directory'=>"");
		$this->m_imageplaque=array('pkimageplaque_id'=>"",'fkimage_id'=>"",'fkplaque_id'=>"");
	 	$this->m_imagelandmark=array('pkimagelanmdark_id'=>"",'fkimage_id'=>"",'fklandmark_id'=>"");
		$this->m_imageaward = array('pkimageaward_id'=>"",'fkimage_id'=>"",'fkaward_id'=>"");
	 }
	  
	//ADD or create
	function createImage($vars)  
	{		
			$id='pkimage_id';
			$insert_vars=array_intersect_key($vars,$this->getImage());
			
			$sql = "Insert into tblimage "; 
			$sql .=InsertSQL($insert_vars,$id);
			$result = getconn($sql);
			$image_id=$this->getLastImageId();
			//echo $sql;
			if((array_key_exists('fkplaque_id',$vars)) and ($vars['fkplaque_id'] !=""))
			{
				$this->addPlaqueImage($image_id,$vars['fkplaque_id']);
			}
			if((array_key_exists('fkaward_id',$vars)) and ($vars['fkaward_id'] !=""))
			{
				$this->addAwardImage($image_id,$vars['fkaward_id']);
			}
			if((array_key_exists('fklandmark_id',$vars)) and ($vars['fklandmark_id'] !=""))
			{
				$this->addLandmarkImage($image_id,$vars['fklandmark_id']);
			}
			return $result;
	}
	function getLastImageId()
	{
		$id=mysql_insert_id();
		echo "Image ID is:" .$id;
		return $id;
	}

	//UPDATE
	function updateImage($vars){
			$id='pkimage_id';
			$insert_vars=array_intersect_key($vars,$this->getImage());
			if((array_key_exists('fkplaque_id',$vars)) and ($vars['fkplaque_id'] !=""))
			{
				$this->addPlaqueImage($insert_vars['pkimage_id'],$vars['fkplaque_id']);
			}
			if((array_key_exists('fkaward_id',$vars)) and ($vars['fkaward_id'] !=""))
			{
				$this->addAwardImage($insert_vars['pkimage_id'],$vars['fkaward_id']);
			}
			if((array_key_exists('fklandmark_id',$vars)) and ($vars['fklandmark_id'] !=""))
			{
				$this->addLandmarkImage($insert_vars['pkimage_id'],$vars['fklandmark_id']);
			}

			$sql="UPDATE tblimage SET ";
			$sql.=UpdateSQL($insert_vars,$id);
			$sql .=" where ".$id."=".$vars[$id];
			//echo $sql;
			$result = getconn($sql);
			return $result; 
	 }
	 function deleteImage($id)
	{
		$sql="Delete from tblimage where pkimage_id=".$id;
		echo $sql;
		$result = getconn($sql);
		return $result;
	
	}
	//getAllInspection
	function getAllImage($currpg,$url)  {
	
			$sql="Select * from tblimage order by image_title ASC"; 
			$pagesize = 10;
			$result = paging($sql,$currpg,$pagesize,$url); 
			return $result;
	}
	
	function getImageById($id)  {
			$sql="Select * from tblimage WHERE pkimage_id=".$id;
			$result=getconn($sql);  
			return $result;  		
	}
	function getImage()
	{
		return $this->m_images;
	}
	
	function getImagesByPlaqueId($pkplaque_id)
	{
	
			$sql="Select I.* from tblimage I inner join tblimageplaque IP on IP.fkimage_id = I.pkimage_id WHERE  IP.fkplaque_id = ".$pkplaque_id;
			$result=getconn($sql);  
			return $result;  
	}
	function getImagesByAwardId($pkaward_id)
	{
			$sql="Select I.* from tblimage I inner join tblimageaward IA on IA.fkimage_id = I.pkimage_id WHERE  IA.fkaward_id = ".$pkaward_id;
			echo $sql;
			$result=getconn($sql);  
			return $result;  
	}
	function getImagesByLandmarkId($pkland_id)
	{
			$sql="Select I.* from tblimage I inner join tblimagelandmark IL on IL.fkimage_id = I.pkimage_id WHERE  IL.fklandmark_id = ".$pkland_id;
			$result=getconn($sql);  
			return $result;  
	}

	function image_name_check($Image_name)
	{
			$sql="Select * from tblimage  WHERE image_name = ".$Image_name;
			$result=getconn($sql);  
			return $result;  

	}
	function addPlaqueImage($imgid,$plaqueid)
	{
			$id='pkimageplaque_id';
			$vars= array('fkimage_id'=>$imgid,'fkplaque_id'=>$plaqueid);
			$insert_vars=array_intersect_key($vars,$this->m_imageplaque);
			$sql = "Insert into tblimageplaque ";
			$sql .=InsertSQL($insert_vars,$id);
			echo $sql;
			$result = getconn($sql);
			return $result;
	}
	function addAwardImage($imgid,$awardid)
	{
			$id='pkimageaward_id';
			$vars= array('fkimage_id'=>$imgid,'fkaward_id'=>$awardid);
			$insert_vars=array_intersect_key($vars,$this->m_imageaward);
			$sql = "Insert into tblimageaward ";
			$sql .=InsertSQL($insert_vars,$id);
			echo $sql;
			$result = getconn($sql);
			return $result;
	}
	function addLandmarkImage($imgid,$landid)
	{
			$id='pkimagelandmark_id';
			$vars= array('fkimage_id'=>$imgid,'fklandmark_id'=>$landid);
			$insert_vars=array_intersect_key($vars,$this->m_imagelandmark);
			$sql = "Insert into tblimagelandmark ";
			$sql .=InsertSQL($insert_vars,$id);
			echo $sql;
			$result = getconn($sql);
			return $result;
	}

	function getImagesByCriteria($vars)
	{
			$sql="Select * from tblimage  WHERE image_name like '%%%".$vars['keyword_text']."%%%'";
			$result=getconn($sql);  
			return $result;  
	}
}
?>