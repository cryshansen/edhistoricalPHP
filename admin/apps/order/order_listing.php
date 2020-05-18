<p>This listing has been designed to assist you to do a search for Orders associated with the Edmonton Historical Board. You can search by Order Type  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.

<?php 



	require_once('projectClasses/orders.php');
	require_once('projectClasses/applications.php');
	$keyword_text="";
	?>
	<form action="" method="post">
	<table>
		<tr>
		  <td>Order Type:<br />
		    <select name="select">
              <option>choose a type...</option>
              <option value="round">Manufacturing</option>
              <option value="oval">Printing</option>
			  <option value="rectangular">Installation</option>
			  <option value="rectangular">Inspection</option>
              <option value="rectangular">Restoration</option>
            </select></td>

			<td>Keyword:<br />
			<input name="keyword_text" type="text" value="<?php echo $keyword_text; ?>"></td>
			<td><br /><input class="btton" type="submit" id="list_submit" value="View Listing"></td>
		</tr>
		<tr>
            <td colspan="3"> <a href="">View All listings</a></td>
		</tr>	
	</table>
    </form>
	<table>
		<tr style="text-align:left"><th>Site Name    </th><th>Order Type    </th><th colspan="2">Actions</th></tr>
					<tr><td><a href="index.php?page=order">Lemarchant </a></td>
					<td>Manufacturing </td>
					<td><form name="edit_app" method="post" action="index.php?page=order&id="> 
						<input class="btton" type="submit" value="Edit" />
					</form></td>
<!--					<td><form name="create_plaque" method="post" action="index.php?page=order&id=">
						<input class="btton" type="submit"  value="Create Order" />
					</form></td>
-->				</tr>
				</table>
<?php
		
/*-------------------------------------------------- Display All listings      ---------------------------------------------*/		
function displayListing($result){
?>
		<table>
<?php
		print_r($result);
		if($result!=0){
			while ($row = mysql_fetch_array($result))
			{
			
			
			
			}
		}
		?>
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
			
				<option value="<?php echo $row['pkapplication_status_id']; ?>"> <?php echo $row['application_status']; ?></option>
		<?php
			}
			?>
			</select>
			</td>
<?php		
		}


?>