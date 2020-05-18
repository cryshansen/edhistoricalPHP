<p>This listing has been designed to assist you to do a search for Owners of landmarks. You can search according to keywords and then click on the "View Listing" button.</p>

<?php
require_once('projectClasses/controller.php');	// need controller class 
$m_owner = new controllerClass();			// instantiate new controllerClass class 
$keywd = "";								// used for searching 

// for paging when displaying list of records 
// if page is is available in url from already displayed
//     first page trying to display other pages 
$url="index.php?page=owner_listing";		// url used in paging 
if (isset($_GET['pgid'])) {	
	// set current page to page id from url 
	$currpg = $_GET['pgid'];
} else { 
	// have not displayed anything so set current page to null 
	$currpg ="";
} 

// if paging related to "View Listing" button 
// set keyword from url otherwise set to null 
if (isset($_GET['keywd'])) {
	$keywd = $_GET['keywd']; 
} else { 
	$keywd = ""; 
} 
?>

<form action="" method="post">
	<table>
		<tr>
			<td> Owner Name or Keyword: <br />
				<input name="keywd" type="text" value=""> </td>
			<td> <br /> <input class="btton" type="submit" name="list_submit" id="list_submit" value="View Listing"> </td>
		</tr>
		<tr> <td colspan="3"> <a href="">View All listings</a> </td> </tr>
	</table>
</form> 
    
<?php 
// determine what happened 
if(isset($_POST['list_submit'])){			// if want to search on keyword 
	// "View Listing" button 
	// search owner records for occurrence of keyword 
	// display owner records using paging 
	// ensure url contains keyword 
	$url .= "&keywd=".$_POST['keywd']; 
	$result = $m_owner->ownerKeywordSearch($_POST['keywd'], $currpg, $url);  
	if ($result) { 							// if operation successful 
		$rowcount=mysql_num_rows($result);	// count of records retrieved 
		if ($rowcount > 0) { 				// if something retrieved 
			displayListing($result); 		// display owners retrieved 
		} else { 							// otherwise no data retrieved 
			echo "<p>Your query resulted in 0 rows returned.</p>"; 
		}
	}
} else if ($keywd != "") { 
		// paging as a result of "View Listing" button 
		// paging on page subsequent to first page 
		// construct $url containing search keyword 
		$url .="&keywd=".$keywd; 
		$result = $m_owner->ownerKeywordSearch($keywd, $currpg, $url);  
		if ($result) { 						// if operation successful 
			$rowcount=mysql_num_rows($result);	// count of records retrieved 
			if ($rowcount > 0) { 			// if something retrieved 
				displayListing($result); 	// display owners retrieved 
			} else { 						// otherwise no data retrieved 
				echo "<p>Your query resulted in 0 rows returned.</p>"; 
			}
		}
} else { 								// otherwise 
		// not a search request as a result of "View Listing" button 
		// display information relating to all owners 
		// retrieve all owner records 
		// display owner records using paging 
		$result = $m_owner->getAllOwners($currpg, $url); 
		if ($result) { 							// if operation successful 
			$rowcount=mysql_num_rows($result);	// count of records retrieved 
			if ($rowcount > 0) { 				// if something retrieved 
				displayListing($result); 		// display vendors retrieved 
			} else { 								// otherwise no data retrieved 
				echo "<p>Your query resulted in 0 rows returned.</p>"; 
			}
		} 
	} 



/* **************************************** owner listing **************************************** */ 
// display list of owner records 
function displayListing($result) 
{
?>
	<table>
		<tr style="text-align:left">
			<th>Organization Name </th>
			<th>Owner Name </th>
			<th colspan="2">Actions</th>
		</tr>
		<?php		
		while ($row = mysql_fetch_array($result)) {  // for each owner record retrieved 
		?>
		<tr>
        	<td>
				<?php echo $row['organization_name']; ?> </a> </td>    
			<td>
				<?php echo $row['owner_name']; ?> </a> </td>
			<td>
				<form name="edit_app" method="post" action="index.php?page=owner&id=<?php echo $row['pkowner_id'];?>"> 
					<input class="btton" type="submit" value="Edit" />
				</form> </td>
			<td>
				<!--<form name="lookup_landmark" method="post" action="index.php?page=landmark&pid=<?php //echo $row['pkApplicnat_ID'];?>">
					<input class="btton" type="submit" value="Add Owner to Landmark" />
				</form>--> </td>
		</tr>
		<?php		
		}
		?>
	</table>
<?php 
}
?>
