<p>This listing has been designed to assist you to do a search for Images associated with plaques, awards and landmarks. You can search by Image Type (landmark,plaque, or award)  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.

<!--MMDW 0 --><?php  
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
	?><!--MMDW 1 -->
<form mmdw="0"  action="" method="post">
	<table>
		<tr>
			<td>Image Type:<br />
				<select mmdw="1"  name="fkplaque_status_ID">
				<option mmdw="2"  value="">Choose a Type...</option>
				<option>Plaque</option>
				<option>Award</option>
				<option>Landmark</option>
				<option>No Type</option>
				</select></td>
			<td>Keyword:<br />
			<input mmdw="3"  name="keyword_text" type="text" value=""></td>
			<td><br /><input mmdw="4"  class="btton" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
		<tr>
            <td mmdw="5"  colspan="3"> <a mmdw="6"  href="">View All listings</a></td>
		</tr>	
	</table>
</form>
<!--MMDW 2 --><?php
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
?><!--MMDW 3 -->

	<table>
			<tr><th>Image Preview</th><th>Image Title</th><th>Caption</th><th mmdw="7"  colspan="2" style="text-align:left">Actions</th></tr>
			<!--MMDW 4 --><?php
			while($row =  mysql_fetch_array($result))
			{
			?><!--MMDW 5 -->
			<tr>
				<td><a mmdw="8"  href="<?php echo $row['image_directory'].$row['image_name']?>" rel="lightbox" title="<?php echo stripslashes($row['image_title']); ?>"><img mmdw="9"  style="float:left" width="40" height="40" src="<?php echo trim($row['image_directory'])."small/".trim($row['image_name']); ?>" alt="<?php echo stripslashes($row['image_title']); ?>"/></a></td>
				<td><a mmdw="10"  href="index.php?page=image&id=<?php echo $row['pkimage_id']; ?>"><!--MMDW 6 --><?php echo $row['image_title']; ?><!--MMDW 7 --></a></td>
				<td><!--MMDW 8 --><?php echo  $row['image_location'];?><!--MMDW 9 --></td>
				<td><form mmdw="11"  name="edit_app" method="post" action="index.php?page=image&id=<?php echo $row['pkimage_id']; ?>"> 
					<input mmdw="12"  class="btton" type="submit" value="Edit Image" />
				</form>
				</td>
				<td><form mmdw="13"  name="edit_app" method="post" onclick="confirmSubmit()" action="index.php?page=image_listing&id=<?php echo $row['pkimage_id']; ?>&title=<?php echo $row['image_title']; ?>">
					<input mmdw="14"  class="btton" name="delete" type="submit" value="Delete Image" />
				</form>
				</td>
				
			</tr>
			<!--MMDW 10 --><?php
			}
			?><!--MMDW 11 -->
</table>
<!--MMDW 12 --><?php
}
?><!--MMDW 13 --><!-- MMDW:success -->