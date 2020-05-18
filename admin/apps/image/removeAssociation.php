<?php
require_once("../../projectClasses/controller.php");
$m_owner = new controllerClass();
$name="";
$pid="";
$imgid="";

	if (isset($_GET['pid'])){
		
		$pid = $_GET['pid'];
	}
if (isset($_GET['imgid'])){
		
		$imgid = $_GET['imgid'];
	}
if(isset($_GET['name']))
{
	$name=$_GET['name'];
}

if($name=="Plaque")
{
	$owner=$m_owner->removePlaqueImage($pid,$imgid);

}elseif($name=="Award"){
		$owner=$m_owner->removeAwardImage($pid,$imgid);
		//$name='fkaward_id';
}elseif($name=="Land"){
	$owner=$m_owner->removeLandmarkImage($pid,$imgid);
	//$name='fklandmark_id';
}

if($owner)
{
	echo "The Image was successfully removed from the ".$name;
}else{
		echo "Failed to remove the image from the ".name;

}

		
?>

