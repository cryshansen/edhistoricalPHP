 


<p>This listing has been designed to assist you to do a search for Manufacturing status associated with Plaques in the Edmonton Historical Board System. You can search by plaque manufacturing status  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.
<?php
  
	require_once('projectClasses/applications.php');
?>

	<form action="" method="post">
	<table>
		<tr>
			<td>Order Type<br />
				<select>
					<option>Manufacturing </option>
					<option>Printing</option>
					<option>Inspection</option>
					<option>Installation</option>
					<option>Restoration</option>
				</select>
			</td>
			<td>Plaque Site Name:<br />
			<input name="sitename" type="text" value="<?php echo $sitename; ?>"></td>
<!--			<td>Report Name: <br /><select>
					<option>Order LookUp</option>
					<option>Plaque Installation</option>
					<option>Plaque Restoration</option>
					<option>Plaque Inspection</option>
					<option>Order Awards</option>
				</select>
			</td>
-->			<td><br /><input class="btton" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
		<tr>
            <td colspan="3"> <a href="">View All listings</a></td>
		</tr>	
	</table>
    </form>
	<?php
	
		$m_applicant = new applicationClass();
		if(isset($_POST['list_submit'])){
			$result=$m_applicant->getApplicationsByCriteria($_POST);

		}else{
			$result=$m_applicant->getAllApplications();
		?>
			<p> Listing of Applications that match the criteria for Manufacturing Orders, all Status'. </p>
				<form style="text-align:right" name="applicant" method="post" action="" >
				<input class="btton" type="submit" value="Print" onClick="window.print()" name="print" />
				<!--<input class="btton" type="submit" value="CSV" name="submit_app" /> -->
			</form>

<?php		
			displayListing($result);
		
		}
		
		
		
		
		
/*-------------------------------------------------- Display All listings      ---------------------------------------------*/		
function displayListing($result){
?>
		<table>
			<tr style="text-align:left;"><th>Site Name    </th><th>Nominee Name    </th><th>MFG Status    </th><th>Actions</th></tr>
<?php		while ($row = mysql_fetch_array($result))
		{
		?>
			<tr><td><a href="index.php?page=application&id= echo $row['pkApplication_ID'];?>">
				<?php	 echo $row['site_name'];  ?></a></td><td><?php echo $row['app_fname']; ?> 	&nbsp;&nbsp;<?php echo $row['app_lname']; ?></td>
				<td>Ordered</td>
				<td><form name="edit_app" method="post" action="index.php?page=report_plaquedetails&id= <?php echo $row['pkApplication_ID'];?>"> 
					<input class="btton" type="submit" value="View Details" />
				</form></td>
			</tr>
<?php		
		
		}
		?>
		<tr>
		<td><a href="">Armstrong, Residence</a></td><td>Sweta Meher</td><td>Filled</td>
		<td><form name="edit_app" method="post" action="index.php?page=report_plaquedetails&id=<?php echo $row['pkApplication_ID'];?>"> 
			<input class="btton" type="submit" value="View Details" />
		</form></td>

		</tr>
		</table>
<?php
}
/*--------------------------------  DISPLAY APPLICATION STATUS --------------------------------------*/
		function displayApplicationStatus()
		{		
		?>	
			<td>Application Status <br />
			<select name="fkapplication_status_ID">
				<option value="">Choose a Status...</option>
<?php
			
			$m_application_status = new applicationClass();
			$result=$m_application_status->getApplicationStatus();
			while($row = mysql_fetch_array($result)){
		?>
			
				<option value="<?php echo $row['pkApplication_Status_ID']; ?>"> <?php echo $row['txtApplication_Status']; ?></option>
<?php			
			}
			?>
			</select>
			</td>
<?php		
		}
/*--------------------------------	HISTORICAL EVENT -------------------------------------------------*/
function displayHistoricalEvent()
{
  		?>	
			<td>Historical Event <br />
			<select name="fkapplication_status_ID">
				<option value="">Choose a Status...</option>

<?php			
			$m_application_status = new applicationClass();
			$result=$m_application_status->getHistoricalEvent();
			while($row = mysql_fetch_array($result)){
		?>
			
				<option value="<?php echo $row['pkhistorical_id']; ?>"> <?php echo $row['histor_name']; ?></option>
<?php			
			}
			?>
			</select>
			</td>
<?php
}
?>
