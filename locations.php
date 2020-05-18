<?php
header('Content-type: text/xml');
require_once("admin/projectClasses/controller.php");
$m_location = new controllerClass();
$keywd="";
$loc="";
$fkneighbor_id ="";
if(isset($_GET['keywd']))
{
	$keywd=$_GET['keywd'];
}
if(isset($_GET['loc']))
{
	$loc=$_GET['loc'];
}
if(isset($_GET['fkneighbor_id']))
{
	$fkneighbor_id =$_GET['fkneighbor_id'];
}

if((($keywd !="") or ($loc !="")) and ($fkneighbor_id !="")){
	$vars = array('keywd'=>$keywd,'loc'=>$loc,'fkneighbor_id'=>$fkneighbor_id);	
	$result=$m_location->getLandmarksByCriteriaforMarkers($vars);
}elseif($fkneighbor_id !="")
{
	$result=$m_location->getLandmarksByNeighbourhood($fkneighbor_id);
}else{$result=$m_location->getLandmarksByNeighbourhood(205);}
$rowXml='<marker latitude="%s" longitude="%s" locname="%s"';
$rowXml .=' address="%s" city="Edmonton" province="Alberta" />';
$xml ="<markers>\n";
while($row=mysql_fetch_array($result))
{
	$xml .= sprintf($rowXml . "\n",
					htmlentities($row['latitude']),
					htmlentities($row['longitude']),
					htmlentities($row['land_name']),
					htmlentities($row['street_address']));
					
/*	$xml .='<marker latitude="'.htmlentities($row['latitude']).'" longitude="'.htmlentities($row['longitude']).'" locname="'.htmlentities($row['land_name']).'"';
	$xml .=' address="'.htmlentities($row['street_address']).'" city="Edmonton" province="Alberta" postal="T5J 1V9" />\n';
*/
}
$xml .= "</markers>\n";

echo $xml;
?>