<?php
require_once("../../projectClasses/controller.php");
require_once("../../includes/validateData.php");

$m_owner = new controllerClass();
	if (isset($_GET['fklandmark_id'])){
		
		$owner_id = $_GET['fklandmark_id'];
		$owner = $m_owner->getLandmarkOwnerById($owner_id);
	}
?>
<br clear="all" />
<table>
<tr>
	<th>Address</th>
	<th>Classification</th>
	<th>Neighbourhood</th>
</tr>
<?php
	while($row=mysql_fetch_array($owner))
	 {
	 ?>
		<tr>
			<td><?php echo $row['street_address']; ?></td>
			<td><?php echo $row['classification']; ?> </td>
			<td><?php echo $row['name'];?> </td>
		</tr>
</table>
<table>
<tr>
	<th>Owner Name</th>
	<th>Phone</th>
	<th>FOIP</th>
</tr>
<?php

	 ?>
		<tr>
			<td><?php echo $row['owner_name']; ?></td>
			<td><?php echo displayPhone($row['owner_phone_bus']); ?> </td>
			<td><?php echo $row['foip'];?> </td>
		</tr>
<?php
	 }
		
?>
</table>