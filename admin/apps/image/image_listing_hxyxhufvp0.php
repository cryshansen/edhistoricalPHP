<p>This listing has been designed to assist you to do a search for Images associated with plaques, awards and landmarks. You can search by Image Type (landmark,plaque, or award)  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.

<?php  
	$m_image= new controllerClass();
	$url = "index.php?page=image_listing";
	if(isset($_GET['title'])){
		$title=$_GET['title'];
	}else{$title="";}
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
			<td>Image Type:<br />
				<select name="fkplaque_status_ID">
				<option value="">Choose a Type...</option>
				<option>Plaque</option>
				<option>Award</option>
				<option>Landmark</option>
				<option>No Type</option>
				</select></td>
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
			$result=$m_image->getImagesByCriteria($_POST,$currpg,$url);
			if ($result)
			{
				$rowcount=mysql_num_rows($result);
				//echo $rowcount;
				displayListing($result);
			}else{
				echo "<p>Your query resulted in 0 rows returned.</p>";
			}
		}elseif(isset($_POST['delete'])){
			//echo "are you sure youj want to delete this recdorc?";
			//ifimage exists in tables cant delete.
			$result=$m_image->getRelationshipPlaque($_POST['id']);
			$result2=$m_image->getRelationshipAward($_POST['id']);
			$result3=$m_image->getRelationshipLand($_POST['id']);
			if(mysql_num_rows($result)>0){
				echo "<font style='color:red'>You may not delete this image. Please remove plaques associated with this image first</font>".
			}elseif(mysql_num_rows($result2)>0){
				echo "<font style='color:red'>You may not delete this image. Please remove awards associated with this image first</font>".
			}elseif(mysql_num_rows($result3)>0){
				echo "<font style='color:red'>You may not delete this image. Please remove landmarks associated with this image first</font>".
			}else{
				$result=$m_image->deleteImage($_POST['pkimage_id']);
				echo "<p>You successfully deleted".$title.".</p>";
			}
			
		}else{
			$result=$m_image->getAllImage($currpg,$url);
			//$rowcount=mysql_num_rows($result);
			//echo $rowcount;
			displayListing($result);
		
		}
		
		
		
		
		
/*-------------------------------------------------- Display All listings      ---------------------------------------------*/		
function displayListing($result)
{
?>

	<table>
			<tr><th>Image Preview</th><th>Image Title</th><th>Caption</th><th colspan="2" style="text-align:left">Actions</th></tr>
			<?php
			while($row =  mysql_fetch_array($result))
			{
			?>
			<tr>
				<td><a href="<?php echo $row['image_directory'].$row['image_name']?>" rel="lightbox" title="<?php echo stripslashes($row['image_title']); ?>"><img style="float:left" width="40" height="40" src="<?php echo trim($row['image_directory'])."small/".trim($row['image_name']); ?>" alt="<?php echo stripslashes($row['image_title']); ?>"/></a></td>
				<td><a href="index.php?page=image&id=<?php echo $row['pkimage_id']; ?>"><?php echo $row['image_title']; ?></a></td>
				<td><?php echo  $row['image_location'];?></td>
				<td><form name="edit_app" method="post" action="index.php?page=image&id=<?php echo $row['pkimage_id']; ?>"> 
					<input class="btton" type="submit" value="Edit Image" />
				</form>
				</td>
				<td><form name="edit_app" method="post" onclick="confirmSubmit()" action="index.php?page=image_listing&id=<?php echo $row['pkimage_id']; ?>&title=<?php echo $row['image_title']; ?>">
					<input class="btton" name="delete" type="submit" value="Delete Image" />
				</form>
				</td>
				
			</tr>
			<?php
			}
			?>
</table>
<?php
}
?><!-- MMDW:success -->