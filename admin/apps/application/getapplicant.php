<?php
require_once("../../projectClasses/controller.php");
require_once("../../includes/validateData.php");

$m_owner = new controllerClass();
	if (isset($_GET['fkapplicant_id'])){
		
		$fkapplicant_id = $_GET['fkapplicant_id'];
	}else{
		//$category=4;
		}

$owner = $m_owner->getApplicantById($fkapplicant_id);
?>
<br clear="all" />
<p>Change Nominator to:</p>
<table>
<tr>
	<th>Nominator Name</th>
	<th>Phone</th>
	<th>FOIP</th>
</tr>
<?php
	while($row=mysql_fetch_array($owner))
	 {
	 ?>
		<tr>
			<td><?php echo $row['contact_fname']. " ".$row['contact_lname'] ; ?></td>
			<td><?php echo displayPhone($row['phone']); ?> </td>
			<td><?php echo $row['foip'];?> </td>
		</tr>
<?php
	 }
		
?>
</table>
