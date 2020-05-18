<p>This listing has been designed to assist you to do a search for landmarks within the Edmonton Heritage Board Application. You can search by neighbourhood  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.

  <?php
	$m_landmark = new controllerClass();
	$location=""; //site award name applicant name 
	$keyword_text=""; //description app_description 	app_biography 	supporting_material
$url="index.php?page=landmark_listing";
if(isset($_GET['pgid']))
{
$currpg = $_GET['pgid'];
}
else
{
$currpg ="";
}
if(isset($_GET['keywd'])){
	$keywd=$_GET['keywd'];
}else{
	$keywd="";
}
if(isset($_GET['fkneighbor_id']))
{
	$fkneighbor_id =$_GET['fkneighbor_id'];
}else{
	$fkneighbor_id ="";
}

?>
			<form action="" method="post">
				<table>
					<tr>
						<td>Keyword:<br />
						<input name="keywd" type="text" value=""></td>
						<td colspan="2">Neighbourhood: <br />
							<?php displayNeighbourhood(); ?>
						</td>									

						<td><br /><input class="btton" name="list_submit" type="submit" id="list_submit" value="View Listing"></td>
					</tr>
						<td colspan="3"> <a href="<?php echo $url; ?>">View All listings</a></td>
					</tr>	
				</table>
			</form>
			<br />
	
<?php	
		if(isset($_POST['list_submit'])){
			$url.="&keywd=".$_POST['keywd']."&fkneighbor_id=".$_POST['fkneighbor_id'];
			$result=$m_landmark->getLandmarksByCriteria($_POST,$currpg,$url);
			if ($result)
			{
				displayListing($result);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}elseif(($keywd !="") or ($fkneighbor_id !="")){
			$vars = array('keywd'=>$keywd,'fkneighbor_id'=>$fkneighbor_id);	
			$url .="&keywd=".$keywd."&fkneighbor_id=".$fkneighbor_id;
			$results=$m_landmark->getLandmarksByCriteria($vars,$currpg,$url);
			displayListing($results);

		}else{
			$result=$m_landmark->getAllLandmarks($currpg,$url);
			displayListing($result);
		
		}



/* ------------------------------------------- Display Listing ------------------------------------------*/
	function displayListing($results)
	{
	
	?>

				<table>
						<tr style="text-align:left;"><th>Site Name    </th><th colspan="4" >Actions</th></tr>
						<?php
						while ($row = mysql_fetch_array($results))
						{
						?>
						<tr><td><a href="index.php?page=landmark&id=<?php echo $row['pklandmark_id']; ?>"><?php echo $row['land_name']; ?></a></td>
							<td><form name="edit_app" method="post" action="index.php?page=landmark&id=<?php echo $row['pklandmark_id']; ?>"> 
								<input class="btton" type="submit" value="Edit Landmark" />
							</form>
							</td>
						</tr>
						<?php
						}
						?>
				</table>


<?php
	}
/* ------------------------------------------- Display Neighbourhood ------------------------------------------*/

	function displayNeighbourhood()
	{
			$m_landmark = new controllerClass();
			$results=$m_landmark->getAllNeighbourhoods();

	?>
											<select name="fkneighbor_id">
											<option>Choose a Neighbourhood...</option>
				<?php
				while($row=mysql_fetch_array($results))
				{
				?>
		
												<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
				<?php 
				}
				?>
											</select>

	
<?php
	}

?>
