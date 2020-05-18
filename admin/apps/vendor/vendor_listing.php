<p>This listing has been designed to assist you to do a search for maintenance required on associated plaques. You can search by plaque status  using the drop down menu, location, or you can search according to keywords or use both and then click on "View Listing" button.</p> 

<?php
require_once('projectClasses/controller.php');  // need controllerClass class 
$m_vendors = new controllerClass();			// instantiate new controllerClass class 
$keyword_text="";							// keyword search string 

// for paging when displaying records 
// if page id is available have already displayed first page 
//     trying to display other pages 
$url="index.php?page=vendor_listing";		// url used in paging 
if (isset($_GET['pgid'])) { 
	// set current page to page id 
	$currpg = $_GET['pgid']; 
} else { 
	// have not displayed anything so set current page to null 
	$currpg = ""; 
}
if(isset($_GET['keywd'])){
	$keywd=$_GET['keywd'];
}else{
	$keywd="";
}
if (isset($_GET['fkvendortype_id']))
{
	$fkvendortype_id=$_GET['fkvendortype_id'];
}else{
$fkvendortype_id="";
}

?>

<form action="" method="post">
	<table>
		<tr>
			<?php displayVendorType(); ?>
			<td>Keyword:<br />
				<input name="keywd" type="text" value=""> </td>
			<td> <br /> <input class="btton" type="submit" name="list_submit" id="list_submit" value="View Listing"> </td>
		</tr>
		<tr>
			<td colspan="3"> <a href="">View All listings</a> </td>
		</tr>	
	</table>
</form>

<?php
if(isset($_POST['list_submit'])) { 
	// search for vendor records that match search criteria 
	$url.="&keywd=".$_POST['keywd']."&fkvendortype_id=".$_POST['fkvendortype_id'];
	$result = $m_vendors->getVendorsbyCriteria($_POST,$currpg,$url);
	if ($result) { 							// if operation successful 
		$rowcount=mysql_num_rows($result);	// count of records retrieved 
		if ($rowcount > 0) { 				// if something retrieved 
			displayRecords($result); 		// display vendors retrieved 
		} else { 							// otherwise no data retrieved 
			echo "<p>Your query resulted in 0 rows returned.</p>"; 
		}
	}
}elseif(($keywd !="") or ($fkvendortype_id !="")){
		$url.="&keywd=".$keywd."&fkvendortype_id=".$fkvendortype_id;
		$vars = array('keywd'=>$keywd,'fkvendortype_id'=>$fkvendortype_id);
		$result = $m_vendors->getVendorsbyCriteria($vars,$currpg,$url);
		displayRecords($result); 		// display vendors retrieved 


} else { 
	// retrieve all vendor records 
	// when displaying results use paging 
	$result = $m_vendors->getAllVendorsList($currpg, $url);  // retrieve all vendor records 
	if ($result) { 							// if operation successful 
		$rowcount=mysql_num_rows($result);	// count of records retrieved 
		if ($rowcount > 0) {				// if something retrieved 
			displayRecords($result);		// display vendors retrieved 
		} else { 							// otherwise no data retrieved 
			echo "<p>Your query resulted in 0 rows returned.</p>"; 
		}
	}
}

/*--------------------------  display vendor type (drop down list)  --------------------------*/ 
function displayVendorType()	
{
?>
	<td> Vendor Type: <br /> 
	<select name="fkvendortype_id">
		<option value=""> Choose a Type... </option> 
        <?php 
		$m_vendor = new controllerClass();	// instantiate new controller class 
		$result = $m_vendor->getVendorTypes();	// retrieve all vendors 
		while($row = mysql_fetch_array($result)) {	// for all retrieved records  
        ?>
			<option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?> </option> 
		<?php
		}
		?>
	</select> </td>
<?php 
}		

/*------------------------------  display vendor records  ------------------------------*/ 
// display vendor records in drop down list 
function displayRecords($result)
{
?>
	<table>
		<tr colspan="4" style="text-align:left"> 
            <th>Vendor Name</th> <th >Actions</th>
		</tr>
		<?php 
		while ($row = mysql_fetch_array($result)) {  // for each vendor record retrieved 
		?> 
		<tr>
			<td> <?php echo $row['vendor_name']; ?> </td> 
			<td> 
				<form name="edit_app" method="post" action="index.php?page=vendor&id=<?php echo $row['pkvendor_id'] ?>"> 
				<input class="btton" type="submit" value="Edit" /> </form> </td> 
			<td> </td> 
		</tr>                     
		<?php 
		}
		?> 
	</table> 
<?php
}
?>
