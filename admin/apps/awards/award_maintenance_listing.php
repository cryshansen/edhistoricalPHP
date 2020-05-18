<p>This listing has been designed to assist you to do a search for maintenance required on associated plaques. You can search by plaque status  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.
<?php
	$m_award = new controllerClass();
	$url="index.php?page=award_maintenancelisting";
if(isset($_GET['pgid']))
{
$currpg = $_GET['pgid'];
}
else
{
$currpg ="";
}

	?>
<form action="" method="post">
	<table>
		<tr>
			<td>Award Status:<br />
				<select name="fkaward_status_ID">
				<option value="">Choose a Status...</option>
				<option>No Inscription</option>
				<option>Has Inscription</option>
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
			$result=$m_award->getLandmarksByCriteria($_POST);
			if ($result)
			{
				displayListing($result);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}

		}else{
			$result=$m_award->getAllAwards($currpg,$url);
			displayListing($result);
		
		}
/* ------------------------------------------- Display Listing ------------------------------------------*/
	function displayListing($results)
	{

?>
	<table>
			<tr><th>Site Name    </th><th colspan="4" style="text-align:left">Actions</th></tr>
			<tr><td><a href="index.php?page=application&id=2">Lemarchant</a></td>
				<td><form name="edit_app" method="post" action="index.php?page=order&aid="> 
					<input class="btton" type="submit" value="Order" />
				</form>
				</td>
			</tr>
</table>
<?php
	}
?>