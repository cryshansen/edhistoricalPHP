<?php
require_once("../../projectClasses/controller.php");
$m_owner = new controllerClass();
$name="";
	if (isset($_GET['listId'])){
		
		$listId = $_GET['listId'];
	}else{
		//$category=4;
		}
if($listId=="Plaque")
{
	$owner=$m_owner->getAllPlaque();
	$name='fkplaque_id';


}elseif($listId=="Award"){
		$owner=$m_owner->getAllAward();
		$name='fkaward_id';


}elseif($listId=="Landmark"){
	$owner=$m_owner->getAllLandmark();
	$name='fklandmark_id';
}
	
	
?>

<select name="<?php echo $name; ?>" >
<?php
		 if($listId=="Plaque")
		{
				while($row=mysql_fetch_array($owner))
	 			{

			?>
				 		<option value="<?php echo $row['pkplaque_id']; ?>"><?php echo $row['plq_recipient']; ?></option>
<?php			}
		}elseif($listId=="Award"){ 
				while($row=mysql_fetch_array($owner))
	 			{

		?>
				 		<option  value="<?php echo $row['pkaward_id']; ?>"><?php echo $row['awd_recipient']; ?></option>

<?php			}
		}elseif($listId=="Landmark"){ 
				while($row=mysql_fetch_array($owner))
	 			{
?>
			<option  value="<?php echo $row['pklandmark_id']; ?>"><?php echo $row['land_name']; ?></option>
<?php			}

		}
	 ?>
</select>
<br />
