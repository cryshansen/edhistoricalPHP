<p>This listing has been designed to assist you to do a search for users associated with the Edmonton Historical Board Admin Access. You can search by name  or keywords then click on "View Listing" button. Or select view all listings.

  
<?php
	require_once("projectClasses/controller.php");
	$m_user = new controllerClass();
	$keyword_text="";
	$url="index.php?page=user_listing";
	if(isset($_GET['pgid']))
	{
	$currpg = $_GET['pgid'];
	}
	else
	{
	$currpg ="";
	}

	?>
	<form action="index.php?page=user_listing" method="post">
	<table>
		<tr>
			<td>Keyword:<br />
			<input name="keyword_text" type="text" value="<?php echo $keyword_text; ?>"></td>
			<td><br /><input class="btton" type="submit" name="list_submit" value="View Listing"></td>
		</tr>
		<tr>
            <td colspan="3"> <a href="<?php echo $url; ?>">View All listings</a></td>
		</tr>	
	</table>
    </form>
	<br />
<?php	
		if(isset($_POST['list_submit'])){
			$result=$m_user->getUsersByCriteria($_POST['keyword_text']);
			displayListing($result);

		}else{
			$result=$m_user->getAllUsers($currpg,$url);
			displayListing($result);
		
		}
		
		
		
		
		
/*-------------------------------------------------- Display All listings      ---------------------------------------------*/		
function displayListing($result){
?>
		<table>
			<tr style="text-align:left;"><th>Username</th> <th>Full Name</th><th>User Privileges</th><th>Actions</th></tr>
<?php
		while ($row = mysql_fetch_array($result))
		{
		?>
			<tr><td>
				<?php	 echo $row['user_name'];  ?></td>
				<td><?php echo $row['user_first_name']; ?> 	&nbsp;&nbsp;<?php echo $row['user_last_name']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><form name="edit_app" method="post" action="index.php?page=user&id=<?php echo $row['pkuser_id'];?>"> 
					<input class="btton" type="submit" value="Edit" />
				</form></td>
			</tr>
		
	<?php	
		}
		?>
		</table>
<?php
}

?>