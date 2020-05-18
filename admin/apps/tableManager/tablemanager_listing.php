<p>This listing has been designed to assist you to do a search for Tables associated with the Edmonton Historical Board System. You can search using the drop down menu and clicking on "Get Listing" button.</p>

<?php
require_once("projectClasses/controller.php");	// need class controller 
$m_table = new controllerClass(); 			// instantiate new controllerClass object 

// for paging when displaying list of records from table 
// if page id is available have already displayed first page 
//     trying to display other pages 
if (isset($_GET['pgid'])) { 	
	// set current page to page id 
 	$currpg = $_GET['pgid']; 
} else { 	
	// have not displayed anything so set current page to null 
 	$currpg ="";
}
?>

<form action="" method="post">
<table>
	<tr>
		<td>Select a table:<br />
			<select name="pktable_id">
				<option>Choose a Table...</option>
				<?php		
				$result = $m_table->getallTables();
				while($row = mysql_fetch_array($result)){
				?>
					<option value="<?php echo $row['table_name'];?>"> <?php echo $row['human_name']; ?> </option>
				<?php		
				}
				?>
			</select></td>
		<td> <br /> 
			<input class="btton" type="submit" value="Get Listing" name="submit_table" />
		</td>
		<td> </td>
	</tr>
</table>
</form>	
<br />		

<?php 
// something has happened 
// submit_table - want listing of table 
if(isset($_POST['submit_table']))
{ 
	// button submit_table - list all records in selected table 
	// use paging on results 
	// since selected a table name ensure result display 
	// starts over from the beginning of table 
	$currpg = ""; 							// start display from record 1 
	// want access to table being operated  
	$url = "index.php?page=tablemanager_listing&tblname=".trim($_POST['pktable_id']);
	$result = $m_table->getTableRecords($_POST['pktable_id'], $currpg, $url); 
	if ($result) { 							// if successful 
		$rowcount = mysql_num_rows($result);  // number of records retrieved
		//if ($rowcount > 0) { 
						// if something retrieved 
?>
			<p> No records to display. </p>

<?php			displayListing($_POST['pktable_id'], $result);  // display records 
		//} else {							// otherwise no records retrieved 


		//}
	}
} else {									// otherwise table has been listed 
	// button edit_row - edit a record using tablemanager 
	// determine if trying to delete record 
	if(isset($_POST['id'])) {		// test for delete 
		// button delete_row - delete record 
		$result = $m_table->deleteTableRecord($_POST['name'], $_GET['id']); 
		// determine if record was deleted 
		if ($result == 1) { 	
			// record was deleted 
?> 
			<p> Record deleted. </p> 
<?php 
		} else { 							// record not deleted 
?> 
			<p> Record not deleted - in use. </p> 
<?php
		} 

		// list all records in table 
		// record may or may not have deleted 
		$url = "index.php?page=tablemanager_listing&tblname=".trim($_POST['pktable_id']);		
		$result = $m_table->getTableRecords($_POST['pktable_id'], $currpg, $url); 
		if ($result) { 						// if successful 
			$rowcount = mysql_num_rows($result);  // number of records retrieved 
		
			?>		
				<p> No records to display. </p>
<?php			// if something retrieved 
				displayListing($_POST['pktable_id'], $result);  // display records 
			
				

			 
		}
	} else { 								// otherwise 
		// could be displaying page of results from button submit_table 
		// if current page has a value that is what is happening 
		if ($currpg != "") { 
			// set url, tblname used in controlling paging 
			// read more records from table 
			$url = "index.php?page=tablemanager_listing&tblname=".$_GET['tblname'];	
			$result = $m_table->getTableRecords($_GET['tblname'], $currpg, $url); 
			if ($result) { 							// if successful 
			$rowcount = mysql_num_rows($result);  // number of records retrieved 
				//if ($rowcount > 0) {				// if something retrieved 
					displayListing($_GET['tblname'], $result);  // display records 
				//} else {							// otherwise no records retrieved 
?>
				<p> No records to display. </p>
				
<?php
				//}
			}
		}
	}
}

/*----------------------------------- display listing -----------------------------------*/
// display all records from selected table 
// headings followed by as many rows as there are records in table 
// $tbl_name - name of table being operated on 
// $vars - array containing table data 
function displayListing($tbl_name, $vars){
?>
	<table>
		<tbody> 
           	<tr> 
				<th> Table Name: </th> 
				<th> <?php echo $tbl_name; ?> </th> 
			</tr>
			<tr style="text-align:left"><th>Name</th><th>Description</th><th colspan="2">Actions</th>
			</tr>
			<?php				
				while($row = mysql_fetch_array($vars))
				{
			?>
			<tr>
				<td><?php echo $row[1];?></td> <td> <?php	 echo $row[2]; ?></td>
				<td>
                   	<form name="" method="post" action="index.php?page=tablemanager&id=<?php echo $row[0]; ?>">
					<input type="hidden" name="pktable_id" value="<?php echo $tbl_name; ?>" />
					<input class="btton" type="submit" value="Edit" name="edit_row" /> </form>
				</td>					
				<td>
				<a href="javascript:confirmation(<? echo $row[0].",'{$tbl_name}','index.php?page=tablemanager_listing&id='"; ?>)">delete</a>

<!--                   	<form method="post" name="pktable_id"  onclick="return confirmSubmit()" action="index.php?page=tablemanager_listing&id=<?php// echo $row[0]; ?>">
						<input type="hidden" name="pktable_id" value="<?php //echo $tbl_name; ?>" /> 
						<input class="btton" type="submit" value="Delete" name="delete_row" /> </form> 
-->				</td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td>
					<form name="" method="post" action="index.php?page=tablemanager">
					<input type="hidden" name="pktable_id" value=" <?php echo $tbl_name; ?>" />
					<input class="btton" type="submit" value="Create New" name="create_row" /> </form>
				</td>
			</tr>
		</tbody>
	</table>
<?php
}	
?> 
