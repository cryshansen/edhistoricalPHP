 
<?php
		$m_vendorClass = new controllerClass();
		$vendors_vars=$m_vendorClass->getAllvendors();
		 $vendor_validation = array('pkvendor_id', 1, 'primary key', 'vendor_name', 5, 'Vendor Name', 'contact_name', 105, 'Vendor Contact', 'vendor_address', 105, 'Address', 'vendor_phone_bus', 103, 'Phone (bus)', 'vendor_fax', 103, 'Fax', 'email', 104, 'Email Address', 'fkvendortype_id', 2, 'Vender Type'); 
		if(isset($_POST['submit_app']))
			{
				$post_vars=$_POST;
				$post_vars['vendor_phone_bus'] = deconstructPhone($post_vars['vendor_phone_bus']);
				$post_vars['vendor_fax'] = deconstructPhone($post_vars['vendor_fax']);
				if($post_vars['pkvendor_id'] =='new'){
					if (validateData($vendor_validation, $post_vars)) { 
						$result = $m_vendorClass->createVendor($post_vars); 
					if($result) { 					// if successful 
		?>	
							<p>Your Vendor has been Added. If you would like to see a listing click <a href="index.php?page=vendor_listing">here</a>.</p>
		<?php 
						} 
					} else { 
	?>
						<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
<?php 						displayVendor($post_vars); 		

					}
				} else { 
					// updating existing vendor record 
					if (validateData($vendor_validation, $post_vars)) { 
						$result = $m_vendorClass->updateVendors($post_vars);  
						if($result) {				// if successful 
?>
							<p>Your Vendor has been Updated. If you would like to see a listing click <a href="index.php?page=vendor_listing">here</a>.</p>
<?php 
						} 
					} else { 						
	?>
						<p> <?php echo '<font style="color:red;">'.$err_mess.'</font>'; ?> </p> 
						displayVendor($post_vars); 	 
<?php 
					}
				}
		
			}else{			
				
			
						if(isset($_GET['id']))
						{
							//display individual
							$result=$m_vendorClass->getVendorsById($_GET['id']);
							while ($row = mysql_fetch_array($result))
							{	
									$row['vendor_phone_bus']= displayPhone($row['vendor_phone_bus']);
									$row['vendor_fax']=displayPhone($row['vendor_fax']);
									//call display function()
									displayVendor($row);
							
							}
						}else{
						
							//call dislay function() with empty parameters
							displayVendor($vendors_vars);
						}

			}//closing outerelse
	/*------------------------------------------------	Diplay Vendor  ---------------------------------------------------*/
			function displayVendor($vars)
			{
		
		?>

					<form name="vendor" method="post" action="" ><!--index.php?action=applicant-->							
							<fieldset>
							<legend>Vendor</legend>
								<table>
                                <tr><td>
									<input type="hidden" name="pkvendor_id" value="<?php if ($vars['pkvendor_id']=='') echo 'new'; else echo $vars['pkvendor_id']; ?>" /> </td></tr>
								<tr>
									<td>Vendor Name:<br />
								        <input  name="vendor_name" value="<?php echo $vars['vendor_name']; ?>"/>
									  </td>
									  <td>Contact Name:<br />
									  <input type="text" name="contact_name" value="<?php echo $vars['contact_name']; ?>" /></td>
									 <tr>
									 <td>
									 	<select name="fkvendortype_id" >
											<option >Choose a Vendor Type...</option>
									 	<?php getVendorType($vars['fkvendortype_id']); ?>
										</select>
									 </td>
									 </tr>
								</tr>		
								<tr>
							  		  <td>Phone:<br />
                                          <input type="text" name="vendor_phone_bus" value="<?php echo $vars['vendor_phone_bus']; ?>"/>
								      </td>
									<td>Fax:<br />
									  <input type="text" name="vendor_fax" value="<?php echo $vars['vendor_fax']; ?>"/></td>
								</tr>
								<tr>
									
     							 <td colspan="2">Address:<br />
											 <input  name="vendor_address"  value="<?php echo $vars['vendor_address']; ?>" size="50"/>
									</td>
									
									<tr>
									<td colspan="2">Email:<br />
									  <input name="email" value="<?php echo $vars['email']; ?>" size="50" />
								  </td>
								  </tr>
									
								</table>
								
							</fieldset>
								<input class="btton" type="submit" value="Submit" name="submit_app" />

								</form>
<?php
			}
/*-----------------------------------  Display Vendor  -----------------------------------*/ 
function getVendorType($fkvendortype_id)	
{
		$m_vendor = new controllerClass();		// instantiate new controller class 
		$result = $m_vendor->getVendorTypes();	// retrieve all vendors 
		while($row = mysql_fetch_array($result)) 
		{
		?>
						<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $fkvendortype_id) echo "selected"; ?>><?php echo $row['name']; ?> </option>
		
		<?php
		}


}		
?>