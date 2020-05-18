<?php 
$m_application = new controllerClass();   // instantiate new controllerClass object

// determine what happened 
// report_plaque detail is activated by report_plaquelisting 
// pkplaque_id of plaque record to operate on is passed in url 
if (isset($_GET['id'])) {
 // plaque record selected in report_plaquelisting 
 // read plaque record using id passed in url as record key 
 $result = $m_application->getApplicationForReport($_GET['id']); 
 if ($result) {       // if operation successful 
  $rowcount = mysql_num_rows($result);  // number of records retrieved 
  if ($rowcount = 0) {     // if nothing retrieved 
   echo "<p>Your query results in 0 rows returned.</p>"; 
  } else {        // otherwise 
   // retrieved plaque record so display plaque data 
   $row = mysql_fetch_array($result);  // record retrieved
   ?>
   <?php    
            displayApplication($row);
		
  }
 }?>

          
<?php            
			
 
}
/* ------------------------------ display plaque information ------------------------------ */ 
// display plaque information 
function displayApplication($vars)
{
?> 
<p> <strong>Site Name:</strong> <?php echo $vars['site_name'];?> </p>
			<form style="text-align:right" name="applicant" method="post" action="" >
				<input class="btton" type="submit" value="Print" onClick="window.print()" name="print" />
<!-- 				<input class="btton" type="submit" value="CSV" name="submit_app" /> -->
			</form>

<br />
<fieldset>
  <legend> Application </legend>
   <table>
    <tr>
     <td width="147"><strong>Contact First Name:</strong><br /> 
      <?php echo $vars['app_fname']; ?> 
     </td>
     <td width="163"><strong>Contact Last Name:</strong><br />   
       <?php echo $vars['app_lname']; ?> 
     </td>
     <td width="208"><strong> Address:</strong> <br /> 
      <?php echo $vars['app_address']; ?> 
     </td>
    </tr>
    <tr>
     <td width="147"><strong>Phone Number:</strong><br />
      <?php echo displayPhone($vars['phone_bus']); ?> 
     </td>
     <td width="163"><strong>Home Phone:</strong> <br />
      <?php echo displayPhone($vars['phone_res']); ?> 
     </td>
     <td width="208"><strong>Fax:</strong> <br />
      <?php echo displayPhone($vars['app_fax']); ?> 
    </tr>
    <tr>
     <td colspan="2"><strong>Email:</strong> <br />
      <?php echo $vars['app_email']; ?> 
     </td><td colspan="2"><strong> Date:</strong> <br />
      <?php echo $vars['app_date']; ?> 
     </td>
    </tr>
    <tr>
     
     <td colspan="2"><strong>Application Description:</strong> <br />
      <?php echo $vars['app_description']; ?> 
         </td>
         <td><strong>Application Type:</strong><br/>
          <?php echo $vars['application_type']; ?></td>
         
    </tr>
    <tr>
     <td colspan="2"><strong>Support Documents:</strong> <br />
      <?php echo $vars['supporting_material']; ?> 
     </td>
	 		<td colspan="2"><strong> Historical Event:</strong> <br />
      <?php displayHistoricalEvent($vars['pkapplication_id']); ?> 
     </td>

	 
    </tr> 
	<tr>
	    <td colspan="2"><strong>Leave Comments:</strong> <br />
      <?php echo $vars['hist_comments'];?> <br />
      </td>
	     <td colspan="2"><strong>Application Status:</strong> <br />
      	<?php echo $vars['name']; ?></td>

	</tr>
   </table> 
   <table>
   <tr><th colspan="3" align="left"> Nominator: </th></tr>
    <tr>
     <td width="123"><strong>Organization Name:</strong><br />
      <?php echo $vars['organization_name']; ?> 
     </td>
     <td width="126"><strong>Organization Type:</strong><br />   
      <?php echo $vars['app_type']; ?> 
     </td>
     <td width="164"><strong>Contact First Name:</strong><br />
      <?php echo $vars['contact_fname']; ?> 
     </td>
    </tr>
    <tr>
     <td width="123"><strong>Contact Last Name:</strong><br />
      <?php echo $vars['contact_lname']; ?> 
     </td>
     <td width="126"><strong>Address:</strong><br />
      <?php echo $vars['address']; ?> 
     </td>
     <td width="164"><strong>Phone Number:</strong><br />
      <?php echo displayPhone($vars['phone']); ?> 
    </tr>
    <tr>
     <td colspan="2"><strong>Secondary Phone:</strong><br />
      <?php echo displayPhone($vars['phone2']); ?> 
     </td><td colspan="2"><strong>Fax:</strong><br />
      <?php echo displayPhone($vars['fax']); ?> 
     </td>
    
    
    </tr>
    <tr>
     
     <td colspan="2"><strong>Email:</strong><br /><?php echo $vars['email']; ?> 
      </td>
         <td><strong>FOIP Waiver Signed:</strong><br/>
      <?php echo $vars['foip']; ?></td>
         
    
</table> 
<?php
}
?>
<?php
function displayHistoricalEvent($id) 
{
 $m_application = new controllerClass();  
 $result = $m_application->getHistoricalEventById($id); 
 if ($result) {       
  $rowcount = mysql_num_rows($result); 
  if ($rowcount > 0) {     
   $row = mysql_fetch_array($result);  
   echo $row['name'];
  }
 }
}
?>
