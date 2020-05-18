<p>This listing has been designed to assist you to do a search for maintenance required on associated plaques. You can search by plaque status  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.

  
<?php
	require_once('projectClasses/controller.php');
	$m_plaque = new controllerClass();
	$location=""; //
	$keyword_text=""; //

	?>
<form action="" method="post">
	<table>
		<tr>
			<td>Plaque Status:<br />
				<select name="fkplaque_status_ID">
				<option value="">Choose a Status...</option>
				<option>No Inscription</option>
				<option>No Installation</option>
				<option>No Inspection</option>
				<option>No Restoration</option>
				</select></td>
			<td>Location:<br />
			<input name="location" type="text" value=""></td>

			<td>Keyword:<br />
			<input name="keyword_text" type="text" value=""></td>
			<td><br /><input class="btton" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
		<tr>
            <td colspan="3"> <a href="">View All listings</a></td>
		</tr>	
	</table>
</form>

<?php	
		if(isset($_POST['list_submit'])){
			$results=$m_plaque->getPlaquesByCriteria($_POST);
			if ($results)
			{
				displayListing($results);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}

		}else{
			$result=$m_plaque->getAllPlaques();
			
			displayListing($result);
		}
		
/*-------------------------------------------------- Display All listings      ---------------------------------------------*/		
function displayListing($result){
?>
		<table>
			<tr style="text-align:left">
			  <th>Site Name </th>
			  <th>Plaque Recipient    </th>
			  <th colspan="4">Actions</th></tr>
<?php
		while ($row = mysql_fetch_array($result))
		{
			//$m_plaque = new controllerClass();
		?>
			<tr><td>
					<?php if(array_key_exists('site_name',$row)) echo $row['site_name'];  ?></td>
				<td><?php echo $row['plq_recipient']; ?></td>
				<td><form name="install_plaque" method="post" action="index.php?page=order&id=<?php echo $row['pkplaque_id'];?>">
					<input class="btton" type="submit"  value="Order" />
				</form></td>
				<td><form name="install_plaque" method="post" action="index.php?page=plaque_installation&id=<?php echo $row['pkplaque_id'];?>">
					<input class="btton" type="submit"  value="Install" />
				</form>
				</td>
				<td><form name="inspect_plaque" method="post" action="index.php?page=plaque_inspection&id=<?php echo $row['pkplaque_id'];?>">
					<input class="btton" type="submit"  value="Inspection" />
				</form></td>
				<td><form name="inspect_plaque" method="post" action="index.php?page=plaque_restoration&id=<?php echo $row['pkplaque_id'];?>">
					<input class="btton" type="submit"  value="Restoration" />
				</form></td>
			</tr>
		
<?php		
		}
		?>
		</table>
<?php
}