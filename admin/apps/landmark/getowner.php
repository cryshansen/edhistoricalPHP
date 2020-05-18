<?php
require_once("../../projectClasses/controller.php");
$m_owner = new controllerClass();
	if (isset($_GET['fkowner_id'])){
		
		$owner_id = $_GET['fkowner_id'];
	}else{
		//$category=4;
		}

$owner = $m_owner->getOwnerById($owner_id);
?>
<br clear="all" />
<p>Change Owner to:</p>
<table>
<tr>
	<th>Owner Name</th>
	<th>Phone</th>
	<th>FOIP</th>
</tr>
<?php
	while($row=mysql_fetch_array($owner))
	 {
	 ?>
		<tr>
			<td><?php echo $row['owner_name']; ?></td>
			<td><?php echo $row['owner_phone_bus']; ?> </td>
			<td><?php echo $row['foip'];?> </td>
		</tr>
<?php
	 }
		
?>
</table>
